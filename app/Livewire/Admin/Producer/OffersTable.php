<?php

namespace App\Livewire\Admin\Producer;

use App\Models\Offer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class OffersTable extends Component
{
    use WithPagination;
    use WithFileUploads;
    // Recherche et filtres
    public $search = '';
    public $categoryFilter = '';
    public $regionFilter = '';
    public $perPage = 12;
    // Modal states
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showDetailsModal = false;
    // Données du formulaire
    public $offerId;
    public $title = '';
    public $description = '';
    public $image;
    public $croppedImage;
    public $existingImage = '';
    public $category = '';
    public $price = '';
    public $region = '';
    public $contact = '';
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
    ];
    /**
     * Règles de validation
     */
    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'category' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'region' => 'required|string',
            'contact' => 'required|string|max:255',
            'croppedImage' => 'nullable|string', // Base64 de l'image recadrée
        ];
    }
    protected $messages = [
        'title.required' => 'Le titre est obligatoire.',
        'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
        'description.required' => 'La description est obligatoire.',
        'description.min' => 'La description doit contenir au moins 10 caractères.',
        'category.required' => 'Veuillez sélectionner une catégorie.',
        'region.required' => 'Veuillez sélectionner une région.',
        'contact.required' => 'Les informations de contact sont obligatoires.',
        'price.numeric' => 'Le prix doit être un nombre.',
        'price.min' => 'Le prix ne peut pas être négatif.',
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
    /**
     * Ouvrir le modal de création
     */
    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }
    /**
     * Ouvrir le modal de details
     */
    public function openDetailsModal($offerId)
    {
        $offer = Offer::findOrFail($offerId);
        $this->offerId = $offer->id;
        $this->title = $offer->title;
        $this->description = $offer->description;
        $this->existingImage = $offer->image;
        $this->category = $offer->category;
        $this->price = $offer->price;
        $this->region = $offer->region;
        $this->contact = $offer->contact;
        $this->showDetailsModal = true;
    }
    /**
     * Ouvrir le modal d'édition
     */
    public function openEditModal($offerId)
    {
        $this->resetForm();

        $offer = Offer::findOrFail($offerId);

        // Vérifier que l'utilisateur est propriétaire
        if ($offer->user_id !== Auth::user()->id) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'title' => 'Accès refusé',
                'text' => 'Vous ne pouvez modifier que vos propres offres.'
            ]);
            return;
        }
        $this->offerId = $offer->id;
        $this->title = $offer->title;
        $this->description = $offer->description;
        $this->existingImage = $offer->image;
        $this->category = $offer->category;
        $this->price = $offer->price;
        $this->region = $offer->region;
        $this->contact = $offer->contact;
        $this->showEditModal = true;
    }
    /**
     * Ouvrir le modal de suppression
     */
    public function openDeleteModal($offerId)
    {
        $offer = Offer::findOrFail($offerId);

        // Vérifier que l'utilisateur est propriétaire
        if ($offer->user_id !== Auth::user()->id) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'title' => 'Accès refusé',
                'text' => 'Vous ne pouvez supprimer que vos propres offres.'
            ]);
            return;
        }
        $this->offerId = $offerId;
        $this->showDeleteModal = true;
    }
    /**
     * Créer une nouvelle offre
     */
    public function createOffer()
    {
        $this->validate();
        // Traiter l'image recadrée
        $imagePath = $this->processCroppedImage();
        Offer::create([
            'user_id' => Auth::user()->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $imagePath,
            'category' => $this->category,
            'price' => $this->price,
            'region' => $this->region,
            'contact' => $this->contact,
        ]);
        $this->showCreateModal = false;
        $this->resetForm();
        $this->dispatch('showAlert', [
            'type' => 'success',
            'title' => 'Offre créée',
            'text' => 'Votre offre a été publiée avec succès !'
        ]);
    }
    /**
     * Mettre à jour une offre
     */
    public function updateOffer()
    {
        $this->validate();
        $offer = Offer::findOrFail($this->offerId);
        // Vérifier la propriété
        if ($offer->user_id !== Auth::user()->id) {
            return;
        }
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'price' => $this->price,
            'region' => $this->region,
            'contact' => $this->contact,
        ];
        // Traiter la nouvelle image si fournie
        if ($this->croppedImage) {
            // Supprimer l'ancienne image
            if ($offer->image && Storage::exists($offer->image)) {
                Storage::delete($offer->image);
            }

            $data['image'] = $this->processCroppedImage();
        }
        $offer->update($data);
        $this->showEditModal = false;
        $this->resetForm();
        $this->dispatch('showAlert', [
            'type' => 'success',
            'title' => 'Offre modifiée',
            'text' => 'Les modifications ont été enregistrées.'
        ]);
    }
    /**
     * Supprimer une offre
     */
    public function deleteOffer()
    {
        $offer = Offer::findOrFail($this->offerId);
        // Vérifier la propriété
        if ($offer->user_id !== Auth::user()->id) {
            return;
        }
        $offer->delete();
        $this->showDeleteModal = false;
        $this->offerId = null;
        $this->dispatch('showAlert', [
            'type' => 'success',
            'title' => 'Offre supprimée',
            'text' => 'L\'offre a été supprimée définitivement.'
        ]);
    }
    /**
     * Traiter l'image recadrée en base64
     */
    private function processCroppedImage()
    {
        if (!$this->croppedImage) {
            return;
        }
        // Décoder l'image base64
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->croppedImage));

        // Créer un nom de fichier unique
        $filename = 'offers/' . uniqid() . '.jpg';

        // Sauvegarder l'image avec Intervention Image pour optimisation
        $image = Image::make($imageData);
        $image->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->encode('jpg', 85);

        Storage::put($filename, (string) $image);

        return $filename;
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
            'offerId',
            'title',
            'description',
            'image',
            'croppedImage',
            'existingImage',
            'category',
            'price',
            'region',
            'contact',
        ]);
        $this->resetValidation();
    }
    /**
     * Render
     */
    public function render()
    {
        $offers = Offer::with('user')
            ->when($this->search, fn ($q) => $q->search($this->search))
            ->when($this->categoryFilter, fn ($q) => $q->category($this->categoryFilter))
            ->when($this->regionFilter, fn ($q) => $q->region($this->regionFilter))
            ->latest()
            ->paginate($this->perPage);
        return view('livewire.pages.admin.producer.offers-table', [
            'offers' => $offers
        ])->layout('layouts.admin');
    }
}
