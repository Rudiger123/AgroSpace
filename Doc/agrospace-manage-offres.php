<?php

// app/Http/Livewire/Offres/ManageOffres.php

namespace App\Http\Livewire\Offres;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Offre;
use App\Models\OffrePhoto;
use App\Services\OffreService;
use Illuminate\Support\Facades\Auth;

class ManageOffres extends Component
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
    public $offreId;
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

    // État
    public $selectedOffre;

    protected $queryString = ['search', 'filterCategorie', 'filterStatut', 'filterRegion'];

    protected $rules = [
        'titre' => 'required|string|max:255',
        'description' => 'required|string|min:20',
        'categorie' => 'required|string',
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
    }

    public function openEditModal($offreId)
    {
        $offre = Offre::with('photos')->findOrFail($offreId);

        $this->offreId = $offre->id;
        $this->titre = $offre->titre;
        $this->description = $offre->description;
        $this->categorie = $offre->categorie;
        $this->prix = $offre->prix;
        $this->quantite = $offre->quantite;
        $this->unite = $offre->unite;
        $this->localisation = $offre->localisation;
        $this->region = $offre->region;
        $this->ville = $offre->ville;
        $this->date_expiration = $offre->date_expiration?->format('Y-m-d');
        $this->conditions_livraison = $offre->conditions_livraison;
        $this->contact = $offre->contact;
        $this->existingPhotos = $offre->photos->toArray();

        $this->showEditModal = true;
    }

    public function openDeleteModal($offreId)
    {
        $this->offreId = $offreId;
        $this->showDeleteModal = true;
    }

    public function openDetailsModal($offreId)
    {
        $this->selectedOffre = Offre::with(['photos', 'producteur', 'avis.acheteur'])
                                    ->findOrFail($offreId);
        $this->showDetailsModal = true;
    }

    public function createOffre()
    {
        $this->validate();

        try {
            $service = new OffreService();

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
            ];

            $service->createOffre($data, $this->photos);

            $this->showCreateModal = false;
            $this->resetForm();

            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => 'Offre créée avec succès !'
            ]);

            $this->emit('offreCreated');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function updateOffre()
    {
        $this->validate();

        try {
            $offre = Offre::findOrFail($this->offreId);
            $service = new OffreService();

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
            ];

            $service->updateOffre($offre, $data, $this->photos);

            $this->showEditModal = false;
            $this->resetForm();

            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => 'Offre mise à jour avec succès !'
            ]);

            $this->emit('offreUpdated');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function deleteOffre()
    {
        try {
            $offre = Offre::findOrFail($this->offreId);
            $service = new OffreService();

            $service->deleteOffre($offre);

            $this->showDeleteModal = false;
            $this->offreId = null;

            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => 'Offre supprimée avec succès !'
            ]);

            $this->emit('offreDeleted');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function markAsSold($offreId)
    {
        try {
            $offre = Offre::findOrFail($offreId);
            $service = new OffreService();

            $service->markAsSold($offre);

            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => 'Offre marquée comme vendue !'
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function duplicateOffre($offreId)
    {
        try {
            $offre = Offre::findOrFail($offreId);
            $service = new OffreService();

            $service->duplicateOffre($offre);

            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => 'Offre dupliquée avec succès !'
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function deletePhoto($photoId)
    {
        try {
            $photo = OffrePhoto::findOrFail($photoId);
            $service = new OffreService();

            $service->deletePhoto($photo);

            // Recharger les photos existantes
            if ($this->offreId) {
                $offre = Offre::with('photos')->findOrFail($this->offreId);
                $this->existingPhotos = $offre->photos->toArray();
            }

            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => 'Photo supprimée !'
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function setPhotoPrincipale($photoId)
    {
        try {
            $photo = OffrePhoto::findOrFail($photoId);
            $service = new OffreService();

            $service->setPhotoPrincipale($photo);

            // Recharger les photos existantes
            if ($this->offreId) {
                $offre = Offre::with('photos')->findOrFail($this->offreId);
                $this->existingPhotos = $offre->photos->toArray();
            }

            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => 'Photo principale définie !'
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', [
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
            'offreId', 'titre', 'description', 'categorie', 'prix',
            'quantite', 'unite', 'localisation', 'region', 'ville',
            'date_expiration', 'conditions_livraison', 'photos', 'existingPhotos'
        ]);
        $this->contact = Auth::user()->phone;
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Offre::with(['photos', 'producteur'])
                      ->where('producteur_id', Auth::id());

        // Recherche
        if ($this->search) {
            $query->search($this->search);
        }

        // Filtres
        if ($this->filterCategorie) {
            $query->byCategorie($this->filterCategorie);
        }

        if ($this->filterStatut) {
            $query->where('statut', $this->filterStatut);
        }

        if ($this->filterRegion) {
            $query->byRegion($this->filterRegion);
        }

        // Tri
        $query->orderBy($this->sortBy, $this->sortDirection);

        $offres = $query->paginate(12);

        // Statistiques
        $stats = [
            'total' => Offre::where('producteur_id', Auth::id())->count(),
            'active' => Offre::where('producteur_id', Auth::id())->active()->count(),
            'vendue' => Offre::where('producteur_id', Auth::id())->where('statut', 'vendue')->count(),
            'expiree' => Offre::where('producteur_id', Auth::id())->where('statut', 'expirée')->count(),
        ];

        return view('livewire.offres.manage-offres', [
            'offres' => $offres,
            'stats' => $stats,
            'categories' => Offre::getCategoriesOptions(),
            'unites' => Offre::getUnitesOptions(),
            'regions' => Offre::getRegionsOptions(),
        ])->layout('layouts.admin');
    }
}
