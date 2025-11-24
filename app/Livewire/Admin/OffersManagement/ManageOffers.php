<?php

namespace App\Livewire\Admin\OffersManagement;

use App\Events\Notifications\NewOfferCreated;
use App\Models\Category;
use App\Models\Offer;
use App\Models\OfferPhoto;
use App\Services\OfferService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout("layouts.app")]
#[Title("Offers Management")]
class ManageOffers extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Filtres
    public $search = '';
    public $filterCategorie = '';
    public $filterStatut = '';
    public $filterRegion = '';
    public $sortBy = 'date_publication';
    public $sortDirection = 'desc';

    // Modales
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showDetailsModal = false;

    // Données du formulaire
    public $offerId;
    public $titre;
    public $description;
    public $categorie;
    public $prix;
    public $quantite;
    public $unite;
    public $localisation;
    public $region;
    public $ville;
    public $date_expiration;
    public $conditions_livraison;
    public $contact;
    public $photos = [];
    public $existingPhotos = [];
    public $published = true;

    // État
    public $selectedOffer;

    protected $queryString = ['search', 'filterCategorie', 'filterStatut', 'filterRegion'];

    protected $rules = [
        'titre' => 'required|string|max:255',
        'description' => 'required|string|min:20',
        'categorie' => 'required|exists:categories,id',
        'prix' => 'required|numeric|min:0',
        'quantite' => 'required|integer|min:1',
        'unite' => 'required|string',
        'localisation' => 'required|string|max:255',
        'region' => 'nullable|string',
        'ville' => 'nullable|string',
        'date_expiration' => 'nullable|date|after:today',
        'conditions_livraison' => 'nullable|string',
        'contact' => 'nullable|string|max:20',
        'photos.*' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'titre.required' => 'Le titre est obligatoire.',
        'titre.min' => 'Le titre doit faire au moins 5 caractères.',
        'description.required' => 'La description est obligatoire.',
        'description.min' => 'La description doit faire au moins 20 caractères.',
        'categorie.required' => 'La catégorie est obligatoire.',
        'prix.required' => 'Le prix est obligatoire.',
        'prix.numeric' => 'Le prix doit être un nombre.',
        'quantite.required' => 'La quantité est obligatoire.',
        'quantite.integer' => 'La quantité doit être un nombre entier.',
        'unite.required' => 'L\'unité est obligatoire.',
        'region.required' => 'La région est obligatoire.',
        'localisation.required' => 'L\'adresse est obligatoire.',
        'photos.*.image' => 'Les fichiers doivent être des images.',
        'photos.*.max' => 'Les images ne doivent pas dépasser 2MB.',
        'date_expiration.after' => 'La date d\'expiration doit être ultérieure à aujourd\'hui.',
    ];

    public function mount()
    {
        $this->contact = Auth::user()->phone;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
        $this->showEditModal = false;
        $this->showDetailsModal = false;
        $this->showDeleteModal = false;
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->showDetailsModal = false;
        $this->resetForm();
        $this->resetErrorBag();
    }

    public function openEditModal($offerId)
    {
        $offer = Offer::with('photos')->findOrFail($offerId);

        $this->offerId = $offer->id;
        $this->titre = $offer->titre;
        $this->description = $offer->description;
        $this->categorie = $offer->category_id;
        $this->prix = $offer->prix;
        $this->published = $offer->is_published;
        $this->quantite = $offer->quantite;
        $this->unite = $offer->unite;
        $this->localisation = $offer->localisation;
        $this->region = $offer->region;
        $this->ville = $offer->ville;
        $this->date_expiration = $offer->date_expiration?->format('Y-m-d');
        $this->conditions_livraison = $offer->conditions_livraison;
        $this->contact = $offer->contact;
        $this->existingPhotos = $offer->photos->toArray();

        $this->showEditModal = true;
        $this->showDetailsModal = false;
        $this->showCreateModal = false;
    }

    public function openDeleteModal($offerId)
    {
        $this->offerId = $offerId;
        $this->showDeleteModal = true;
    }

    public function openDetailsModal($offerId)
    {
        $this->selectedOffer = offer::with(['producer'])
            ->findOrFail($offerId);
        $this->showDetailsModal = true;
    }

    public function createOffer()
    {
        $this->validate();

        try {
            $service = new OfferService();

            $data = [
                'titre' => $this->titre,
                'description' => $this->description,
                'categorie' => $this->categorie,
                'prix' => $this->prix,
                'quantite' => $this->quantite,
                'unite' => $this->unite,
                'localisation' => $this->localisation,
                'region' => $this->region,
                'ville' => $this->ville,
                'date_expiration' => $this->date_expiration,
                'conditions_livraison' => $this->conditions_livraison,
                'contact' => $this->contact,
                'published' => $this->published
            ];

            $offer = $service->createOffer($data, $this->photos);

            // Déclencher l'événement de notification
            event(new NewOfferCreated($offer, Auth::user()));

            $this->showCreateModal = false;
            $this->resetForm();

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'offer créée avec succès !'
            ]);

            $this->dispatch('offerCreated');
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function updateOffer()
    {
        $this->validate();

        try {
            $offer = offer::findOrFail($this->offerId);
            $service = new offerService();

            $data = [
                'titre' => $this->titre,
                'description' => $this->description,
                'categorie' => $this->categorie,
                'prix' => $this->prix,
                'quantite' => $this->quantite,
                'unite' => $this->unite,
                'localisation' => $this->localisation,
                'region' => $this->region,
                'ville' => $this->ville,
                'date_expiration' => $this->date_expiration,
                'conditions_livraison' => $this->conditions_livraison,
                'contact' => $this->contact,
                'published' => $this->published
            ];

            $service->updateOffer($offer, $data, $this->photos);

            $this->showEditModal = false;
            $this->resetForm();

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'offer mise à jour avec succès !'
            ]);

            $this->dispatch('offerUpdated');
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function deleteOffer()
    {
        try {
            $offer = Offer::findOrFail($this->offerId);
            $service = new OfferService();

            $service->deleteOffer($offer);

            $this->showDeleteModal = false;
            $this->offerId = null;

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'offre supprimée avec succès !'
            ]);

            $this->dispatch('offerDeleted');
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function markAsSold($offerId)
    {
        try {
            $offer = Offer::findOrFail($offerId);
            $service = new OfferService();

            $service->markAsSold($offer);

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'offre marquée comme vendue !'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function duplicateOffer($offerId)
    {
        try {
            $offer = Offer::findOrFail($offerId);
            $service = new offerService();

            $service->duplicateOffer($offer);

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'offer dupliquée avec succès !'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function deletePhoto($photoId)
    {
        try {
            $photo = OfferPhoto::findOrFail($photoId);
            $service = new OfferService();

            $service->deletePhoto($photo);

            // Recharger les photos existantes
            if ($this->offerId) {
                $offer = Offer::with('photos')->findOrFail($this->offerId);
                $this->existingPhotos = $offer->photos->toArray();
            }

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Photo supprimée !'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function setPhotoPrincipale($photoId)
    {
        try {
            $photo = OfferPhoto::findOrFail($photoId);
            $service = new OfferService();

            $service->setPhotoPrincipale($photo);

            // Recharger les photos existantes
            if ($this->offerId) {
                $offer = Offer::with('photos')->findOrFail($this->offerId);
                $this->existingPhotos = $offer->photos->toArray();
            }

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Photo principale définie !'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterCategorie = '';
        $this->filterStatut = '';
        $this->filterRegion = '';
        $this->resetPage();
    }

    private function resetForm()
    {
        $this->reset([
            'offerId',
            'titre',
            'description',
            'categorie',
            'prix',
            'quantite',
            'unite',
            'localisation',
            'region',
            'ville',
            'date_expiration',
            'conditions_livraison',
            'photos',
            'existingPhotos'
        ]);
        $this->contact = Auth::user()->phone;
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Offer::with(['photos', 'producer'])
            ->where('producer_id', Auth::id());

        // Recherche
        if ($this->search) {
            $query->search($this->search);
        }

        // Filtres
        if ($this->filterCategorie) {
            $query->byCategory($this->filterCategorie);
        }

        if ($this->filterStatut) {
            $query->when($this->filterStatut !== 'all', function ($query) {
                if ($this->filterStatut === 'pending') {
                    $query->where('statut', 'en attente');
                } else {
                    $query->where('statut', $this->filterStatut);
                }
            });
        }


        if ($this->filterRegion) {
            $query->byRegion($this->filterRegion);
        }

        // Tri
        $query->orderBy($this->sortBy, $this->sortDirection);

        $offers = $query->paginate(12);

        // Statistiques
        $stats = [
            'total' => Offer::where('producer_id', Auth::id())->count(),
            'active' => Offer::where('producer_id', Auth::id())->where('is_published', true)->count(),
            'vendue' => Offer::where('producer_id', Auth::id())->where('statut', 'vendue')->count(),
            'expiree' => Offer::where('producer_id', Auth::id())->where('statut', 'expirée')->count(),
        ];

        return view('livewire.admin.offers-management.manage-offers', [
            'offers' => $offers,
            'stats' => $stats,
            'categories' => Category::where('is_active', true)->where('type', 'offer')->get(),
            'unites' => Offer::getUnitesOptions(),
            'regions' => Offer::getRegionsOptions(),
        ]);
    }
}
