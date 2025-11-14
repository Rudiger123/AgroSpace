<?php

// app/Services/offerService.php

namespace App\Services;

use App\Models\OfferPhoto;
use App\Models\ActivityLog;
use App\Models\Offer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class OfferService
{
    public function createOffer(array $data, array $photos = [])
    {
        return DB::transaction(function () use ($data, $photos) {
            // Créer l'offer
            $offer = Offer::create([
                'producer_id' => Auth::user()->id,
                'titre' => $data['titre'],
                'description' => $data['description'],
                'category_id' => $data['categorie'],
                'prix' => $data['prix'],
                'quantite' => $data['quantite'],
                'unite' => $data['unite'],
                'localisation' => $data['localisation'],
                'region' => $data['region'] ?? null,
                'ville' => $data['ville'] ?? null,
                'date_publication' => now(),
                'date_expiration' => $data['date_expiration'] ?? null,
                'statut' => 'en attente',
                'conditions_livraison' => $data['conditions_livraison'] ?? null,
                'contact' => $data['contact'] ?? Auth::user()->phone,
                'is_published' => $data['published']
            ]);

            // Uploader les photos
            if (!empty($photos)) {
                $this->uploadPhotos($offer, $photos);
            }

            ActivityLog::log('offer_created', "offer créée : {$offer->titre}", [
                'offer_id' => $offer->id
            ]);

            return $offer->fresh(['photos']);
        });
    }

    public function updateOffer(Offer $offer, array $data, array $newPhotos = [])
    {
        return DB::transaction(function () use ($offer, $data, $newPhotos) {
            $offer->update([
                'titre' => $data['titre'],
                'description' => $data['description'],
                'category_id' => $data['categorie'],
                'prix' => $data['prix'],
                'quantite' => $data['quantite'],
                'unite' => $data['unite'],
                'localisation' => $data['localisation'],
                'region' => $data['region'] ?? null,
                'ville' => $data['ville'] ?? null,
                'date_expiration' => $data['date_expiration'] ?? null,
                'conditions_livraison' => $data['conditions_livraison'] ?? null,
                'contact' => $data['contact'] ?? null,
                'is_published' => $data['published']
            ]);

            // Uploader nouvelles photos si présentes
            if (!empty($newPhotos)) {
                $this->uploadPhotos($offer, $newPhotos);
            }

            ActivityLog::log('offer_updated', "offer modifiée : {$offer->titre}", [
                'offer_id' => $offer->id
            ]);

            return $offer->fresh(['photos']);
        });
    }

    public function deleteOffer(Offer $offer): bool
    {
        return DB::transaction(function () use ($offer) {
            // Supprimer les photos du storage
            foreach ($offer->photos as $photo) {
                Storage::disk('public')->delete($photo->path);
            }

            ActivityLog::log('Offer_deleted', "offer supprimée : {$offer->titre}", [
                'offer_id' => $offer->id
            ]);

            return $offer->delete();
        });
    }

    public function markAsSold(Offer $offer): bool
    {
        $result = $offer->markAsSold();

        if ($result) {
            ActivityLog::log('Offer_sold', "offer marquée comme vendue : {$offer->titre}", [
                'Offer_id' => $offer->id
            ]);
        }

        return $result;
    }

    public function uploadPhotos(offer $offer, array $photos): void
    {
        $ordre = $offer->photos()->max('ordre') ?? 0;
        $isPremiere = $offer->photos()->count() === 0;

        foreach ($photos as $index => $photo) {
            if ($photo instanceof UploadedFile) {
                $path = $photo->store('offers/' . $offer->id, 'public');

                offerPhoto::create([
                    'offer_id' => $offer->id,
                    'path' => $path,
                    'ordre' => ++$ordre,
                    'is_principale' => $isPremiere && $index === 0,
                ]);
            }
        }
    }

    public function deletePhoto(offerPhoto $photo): bool
    {
        Storage::disk('public')->delete($photo->path);
        return $photo->delete();
    }

    public function setPhotoPrincipale(offerPhoto $photo): void
    {
        DB::transaction(function () use ($photo) {
            // Retirer le statut principal des autres photos
            offerPhoto::where('offer_id', $photo->offer_id)
                      ->update(['is_principale' => false]);

            // Définir cette photo comme principale
            $photo->update(['is_principale' => true]);
        });
    }

    public function duplicateOffer(Offer $offer): offer
    {
        return DB::transaction(function () use ($offer) {
            $newoffer = $offer->replicate();
            $newoffer->titre = $offer->titre . ' (Copie)';
            $newoffer->date_publication = now();
            $newoffer->statut = 'en attente';
            $newoffer->views_count = 0;
            $newoffer->contacts_count = 0;
            $newoffer->save();

            // Dupliquer les photos
            foreach ($offer->photos as $photo) {
                $newPath = str_replace(
                    'offers/' . $offer->id,
                    'offers/' . $newoffer->id,
                    $photo->path
                );

                // Copier le fichier
                Storage::disk('public')->copy($photo->path, $newPath);

                OfferPhoto::create([
                    'offer_id' => $newoffer->id,
                    'path' => $newPath,
                    'ordre' => $photo->ordre,
                    'is_principale' => $photo->is_principale,
                ]);
            }

            ActivityLog::log('offer_duplicated', "offre dupliquée : {$newoffer->titre}");

            return $newoffer;
        });
    }
}
