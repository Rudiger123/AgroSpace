<?php

// app/Services/AvisService.php

namespace App\Services;

use App\Models\Avis;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AvisService
{
    public function createAvis(array $data): Avis
    {
        return DB::transaction(function () use ($data) {
            $avis = Avis::create([
                'producer_id' => $data['producer_id'],
                'consumer_id' => Auth::user()->id,
                'offre_id' => $data['offre_id'] ?? null,
                'note' => $data['note'],
                'commentaire' => $data['commentaire'] ?? null,
                'is_verified' => $data['is_verified'] ?? false,
                'is_visible' => true,
                'date_creation' => now(),
            ]);

            ActivityLog::log('avis_created', "Avis donné à un producer", [
                'avis_id' => $avis->id,
                'note' => $avis->note
            ]);

            // TODO: Envoyer notification au producer

            return $avis;
        });
    }

    public function updateAvis(Avis $avis, array $data): Avis
    {
        $avis->update([
            'note' => $data['note'],
            'commentaire' => $data['commentaire'] ?? null,
        ]);

        ActivityLog::log('avis_updated', "Avis modifié", ['avis_id' => $avis->id]);

        return $avis->fresh();
    }

    public function deleteAvis(Avis $avis): bool
    {
        ActivityLog::log('avis_deleted', "Avis supprimé", ['avis_id' => $avis->id]);
        return $avis->delete();
    }

    public function toggleVisibility(Avis $avis): bool
    {
        $avis->update(['is_visible' => !$avis->is_visible]);

        ActivityLog::log('avis_visibility_changed', "Visibilité de l'avis changée", [
            'avis_id' => $avis->id,
            'is_visible' => $avis->is_visible
        ]);

        return $avis->is_visible;
    }

    public function canUserLeaveAvis(User $consumer, User $producer): bool
    {
        // Vérifier si l'utilisateur a déjà laissé un avis
        $existingAvis = Avis::where('consumer_id', $consumer->id)
            ->where('producer_id', $producer->id)
            ->exists();

        return !$existingAvis;
    }
}
