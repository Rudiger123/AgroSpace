<?php

namespace App\Livewire\Admin\consumer;

use Illuminate\Support\Facades\Auth;
use App\Models\Demand;
use Livewire\Component;
use Livewire\WithPagination;

class DemandsTable extends Component
{
    use WithPagination;
    // Recherche et filtres
    public $search = '';
    public $categoryFilter = '';
    public $regionFilter = '';
    public $sortBy = 'latest';
    public $perPage = 15;
    // Modal states
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showDetailsModal = false;
    // Données du formulaire
    public $demandId;
    public $product = '';
    public $description = '';
    public $category = '';
    public $quantity = '';
    public $region = '';
    public $contact = '';
    // Demande sélectionnée pour les détails
    public $selectedDemand;
    // Listes pour les sélecteurs
    public $categories = [
        'Céréales',
        'Légumes',
        'Fruits',
        'Bétail',
        'Volailles',
        'Produits Laitiers',
        'Équipements',
        'Semences',
        'Engrais',
        'Services',
        'Main d\'œuvre',
        'Transport',
        'Autres'
    ];
    public $regions = [
        'Adamaoua',
        'Centre',
        'Est',
        'Extrême-Nord',
        'Littoral',
        'Nord',
        'Nord-Ouest',
        'Ouest',
        'Sud',
        'Sud-Ouest'
    ];
    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'regionFilter' => ['except' => ''],
        'sortBy' => ['except' => 'latest'],
    ];
    /**
     * Règles de validation
     */
    protected function rules()
    {
        return [
            'product' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'category' => 'required|string',
            'quantity' => 'nullable|integer|min:1',
            'region' => 'required|string',
            'contact' => 'required|string|max:255',
        ];
    }
    protected $messages = [
        'product.required' => 'Le nom du produit est obligatoire.',
        'product.max' => 'Le nom du produit ne peut pas dépasser 255 caractères.',
        'description.required' => 'La description est obligatoire.',
        'description.min' => 'La description doit contenir au moins 10 caractères.',
        'category.required' => 'Veuillez sélectionner une catégorie.',
        'region.required' => 'Veuillez sélectionner une région.',
        'contact.required' => 'Les informations de contact sont obligatoires.',
        'quantity.integer' => 'La quantité doit être un nombre entier.',
        'quantity.min' => 'La quantité doit être au moins 1.',
    ];
    /**
     * Réinitialiser la pagination lors de la recherche
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }
    public function updatingRegionFilter()
    {
        $this->resetPage();
    }
    public function updatingSortBy()
    {
        $this->resetPage();
    }
    /**
     * Ouvrir le modal de création
     */
    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }
    /**
     * Ouvrir le modal d'édition
     */
    public function openEditModal($demandId)
    {
        $this->resetForm();

        $demand = Demand::findOrFail($demandId);

        // Vérifier que l'utilisateur est propriétaire
        if ($demand->user_id !== Auth::user()->id) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'title' => 'Accès refusé',
                'text' => 'Vous ne pouvez modifier que vos propres demandes.'
            ]);
            return;
        }
        $this->demandId = $demand->id;
        $this->product = $demand->product;
        $this->description = $demand->description;
        $this->category = $demand->category;
        $this->quantity = $demand->quantity;
        $this->region = $demand->region;
        $this->contact = $demand->contact;
        $this->showEditModal = true;
    }
    /**
     * Ouvrir le modal de détails
     */
    public function openDetailsModal($demandId)
    {
        $this->selectedDemand = Demand::with('user')->findOrFail($demandId);
        $this->showDetailsModal = true;
    }
    /**
     * Ouvrir le modal de suppression
     */
    public function openDeleteModal($demandId)
    {
        $demand = Demand::findOrFail($demandId);

        // Vérifier que l'utilisateur est propriétaire
        if ($demand->user_id !== Auth::user()->id) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'title' => 'Accès refusé',
                'text' => 'Vous ne pouvez supprimer que vos propres demandes.'
            ]);
            return;
        }
        $this->demandId = $demandId;
        $this->showDeleteModal = true;
    }
    /**
     * Créer une nouvelle demande
     */
    public function createDemand()
    {
        $this->validate();
        Demand::create([
            'user_id' => Auth::user()->id,
            'product' => $this->product,
            'description' => $this->description,
            'category' => $this->category,
            'quantity' => $this->quantity,
            'region' => $this->region,
            'contact' => $this->contact,
        ]);
        $this->showCreateModal = false;
        $this->resetForm();
        $this->dispatch('showAlert', [
            'type' => 'success',
            'title' => 'Demande créée',
            'text' => 'Votre demande a été publiée avec succès !'
        ]);
    }
    /**
     * Mettre à jour une demande
     */
    public function updateDemand()
    {
        $this->validate();
        $demand = Demand::findOrFail($this->demandId);
        // Vérifier la propriété
        if ($demand->user_id !== Auth::user()->id) {
            return;
        }
        $demand->update([
            'product' => $this->product,
            'description' => $this->description,
            'category' => $this->category,
            'quantity' => $this->quantity,
            'region' => $this->region,
            'contact' => $this->contact,
        ]);
        $this->showEditModal = false;
        $this->resetForm();
        $this->dispatch('showAlert', [
            'type' => 'success',
            'title' => 'Demande modifiée',
            'text' => 'Les modifications ont été enregistrées.'
        ]);
    }
    /**
     * Supprimer une demande
     */
    public function deleteDemand()
    {
        $demand = Demand::findOrFail($this->demandId);
        // Vérifier la propriété
        if ($demand->user_id !== Auth::user()->id) {
            return;
        }
        $demand->delete();
        $this->showDeleteModal = false;
        $this->demandId = null;
        $this->dispatch('showAlert', [
            'type' => 'success',
            'title' => 'Demande supprimée',
            'text' => 'La demande a été supprimée définitivement.'
        ]);
    }
    /**
     * Fermer les modals
     */
    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->showDetailsModal = false;
        $this->resetForm();
    }
    /**
     * Réinitialiser le formulaire
     */
    private function resetForm()
    {
        $this->reset([
            'demandId',
            'product',
            'description',
            'category',
            'quantity',
            'region',
            'contact',
            'selectedDemand',
        ]);
        $this->resetValidation();
    }
    /**
     * Render
     */
    public function render()
    {
        $query = Demand::with('user')
            ->when($this->search, fn ($q) => $q->search($this->search))
            ->when($this->categoryFilter, fn ($q) => $q->category($this->categoryFilter))
            ->when($this->regionFilter, fn ($q) => $q->region($this->regionFilter));
        // Tri
        $demands = match ($this->sortBy) {
            'oldest' => $query->oldest()->paginate($this->perPage),
            'product_asc' => $query->orderBy('product', 'asc')->paginate($this->perPage),
            'product_desc' => $query->orderBy('product', 'desc')->paginate($this->perPage),
            default => $query->latest()->paginate($this->perPage),
        };
        return view('livewire.pages.admin.consumer.demands-table', [
            'demands' => $demands
        ])->layout('layouts.admin');
    }
}
