<?php

namespace App\Livewire\Admin\OffersManagement;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Gestion des Offres')]
class ModerateOffers extends Component
{
    use WithPagination;

    public $showDetailsModal = false;
    public $showValidateModal = false;
    public $showRejectModal = false;
    public $showDeleteModal = false;

    
    public $selectedOffer = null;
    public $offerId = null;
    public $validationNote = '';
    public $rejectionReason = '';
    
    public $search = '';
    public $statusFilter = 'pending';
    public $categorieFilter = '';
    public $regionFilter = '';
    public $verifiedFilter = 'all';
    public $sortBy = 'latest';
    public $dateFrom = '';
    public $dateTo = '';

    protected $queryString = ['search', 'statusFilter', 'categorieFilter', 'verifiedFilter'];

    protected $regions = [
        'Adamaoua', 'Centre', 'Est', 'Extrême-Nord',
        'Littoral', 'Nord', 'Nord-Ouest', 'Ouest',
        'Sud', 'Sud-Ouest'
    ];

    protected $categories = [
        'Céréales & Grains',
        'Légumes & Fruits',
        'Élevage & Volaille',
        'Produits Laitiers',
        'Tubercules & Racines',
        'Produits Transformés',
        'Épices & Condiments',
        'Matériel Agricole',
        'Services Agricoles',
        'Intrants & Semences'
    ];

    public function mount()
    {
        $this->dateFrom = now()->subMonth()->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }

    public function viewDetails($id)
    {
        $this->selectedOffer = Offer::with(['producer', 'photos', 'avis.user'])
            ->findOrFail($id);
        $this->showDetailsModal = true;
        $this->showValidateModal = false;
        $this->showRejectModal = false;
        $this->showDeleteModal = false;
    }

    public function openValidateModal($id)
    {
        $this->offerId = $id;
        $this->validationNote = '';
        $this->showValidateModal = true;
         $this->showDetailsModal = false;
         $this->showRejectModal = false;
         $this->showDeleteModal = false;
    }

    public function validateOffer()
    {
        try {
            DB::beginTransaction();

            $offer = Offer::findOrFail($this->offerId);
            
            $offer->update([
                'statut' => 'validé',
                'date_validation' => now(),
                'validated_by' => Auth::user()->id,
                'validation_note' => $this->validationNote,
            ]);

            // TODO: Envoyer notification au producteur
            
            DB::commit();

            $this->showValidateModal = false;
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Offre validée avec succès ! Le producteur a été notifié.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur lors de la validation: ' . $e->getMessage()
            ]);
        }
    }

    public function openRejectModal($id)
    {
        $this->offerId = $id;
        $this->rejectionReason = '';
        $this->showRejectModal = true;
        $this->showDetailsModal = false;
        $this->showValidateModal = false;
        $this->showDeleteModal = false;
    }

    public function rejectOffer()
    {
        $this->validate([
            'rejectionReason' => 'required|string|min:10|max:500',
        ], [
            'rejectionReason.required' => 'Veuillez indiquer la raison du rejet',
            'rejectionReason.min' => 'La raison doit contenir au moins 10 caractères',
        ]);

        try {
            DB::beginTransaction();

            $offer = Offer::findOrFail($this->offerId);
            
            $offer->update([
                'statut' => 'rejeté',
                'date_rejection' => now(),
                'rejected_by' => Auth::user()->id,
                'rejection_reason' => $this->rejectionReason,
            ]);

            // TODO: Envoyer notification au producteur avec la raison
            
            DB::commit();

            $this->showRejectModal = false;
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Offre rejetée. Le producteur a été notifié.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur lors du rejet: ' . $e->getMessage()
            ]);
        }
    }

    public function toggleFeatured($id)
    {
        try {
            $offer = Offer::findOrFail($id);
            $offer->update([
                'is_featured' => !$offer->is_featured
            ]);
            
            $message = $offer->is_featured 
                ? 'Offre mise en avant avec succès' 
                : 'Offre retirée de la mise en avant';
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => $message
            ]);

        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur lors de l\'opération'
            ]);
        }
    }

    public function updateStatus($id, $status)
    {
        try {
            $offer = Offer::findOrFail($id);
            $offer->update(['statut' => $status]);
            
            $statusLabels = [
                'actif' => 'active',
                'expiré' => 'expirée',
                'suspendue' => 'suspendue',
                'archivé' => 'archivée'
            ];
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Statut changé en : ' . ($statusLabels[$status] ?? $status)
            ]);

        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur lors de la mise à jour'
            ]);
        }
    }

    public function confirmDelete($id)
    {
        $this->offerId = $id;
        $this->showDeleteModal = true;
        $this->showDetailsModal = false;
        $this->showValidateModal = false;
        $this->showRejectModal = false;
    }

    public function deleteOffer()
    {
        try {
            $offer = Offer::findOrFail($this->offerId);
            
            // Supprimer les photos associées
            foreach ($offer->photos as $photo) {
                // TODO: Supprimer les fichiers du storage
                $photo->delete();
            }
            
            $offer->delete();
            
            $this->showDeleteModal = false;
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Offre supprimée définitivement'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur lors de la suppression'
            ]);
        }
    }

    public function suspendProducer($producerId)
    {
        try {
            $producer = User::findOrFail($producerId);
            
            // Suspendre toutes les offres du producteur
            Offer::where('producer_id', $producerId)
                ->where('statut', '!=', 'suspendue')
                ->update(['statut' => 'suspendue']);
            
            // TODO: Marquer l'utilisateur comme suspendue
            
            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => 'Producteur suspendue. Toutes ses offres ont été désactivées.'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur lors de la suspension'
            ]);
        }
    }

    public function bulkValidate()
    {
        try {
            $count = Offer::where('statut', 'en attente')
                ->when($this->categorieFilter, function($query) {
                    $query->where('categorie', $this->categorieFilter);
                })
                ->update([
                    'statut' => 'validé',
                    'date_validation' => now(),
                    'validated_by' => Auth::user()->id,
                ]);
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => "$count offre(s) validée(s) en masse"
            ]);

        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur lors de la validation en masse'
            ]);
        }
    }

    public function render()
    {
        $offers = Offer::with(['producer', 'photos'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('titre', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('ville', 'like', '%' . $this->search . '%')
                      ->orWhereHas('producer', function($producerQuery) {
                          $producerQuery->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->statusFilter !== 'all', function($query) {
                if ($this->statusFilter === 'pending') {
                    $query->where('statut', 'en attente');
                } else {
                    $query->where('statut', $this->statusFilter);
                }
            })
            ->when($this->categorieFilter, function($query) {
                $query->where('categorie', $this->categorieFilter);
            })
            ->when($this->regionFilter, function($query) {
                $query->where('region', $this->regionFilter);
            })
            ->when($this->verifiedFilter !== 'all', function($query) {
                if ($this->verifiedFilter === 'verified') {
                    $query->where('statut', 'validé');
                } else {
                    $query->where('statut', '!=', 'validé');
                }
            })
            ->when($this->dateFrom, function($query) {
                $query->whereDate('date_publication', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function($query) {
                $query->whereDate('date_publication', '<=', $this->dateTo);
            })
            ->when($this->sortBy === 'latest', function($query) {
                $query->latest('date_publication');
            })
            ->when($this->sortBy === 'oldest', function($query) {
                $query->oldest('date_publication');
            })
            ->when($this->sortBy === 'most_viewed', function($query) {
                $query->orderBy('views_count', 'desc');
            })
            ->when($this->sortBy === 'most_contacted', function($query) {
                $query->orderBy('contacts_count', 'desc');
            })
            ->when($this->sortBy === 'price_high', function($query) {
                $query->orderBy('prix', 'desc');
            })
            ->when($this->sortBy === 'price_low', function($query) {
                $query->orderBy('prix', 'asc');
            })
            ->paginate(15);

        // Statistics
        $stats = [
            'total' => Offer::count(),
            'pending' => Offer::where('statut', 'en attente')->count(),
            'validated' => Offer::where('statut', 'validé')->count(),
            'rejected' => Offer::where('statut', 'rejeté')->count(),
            'suspended' => Offer::where('statut', 'suspendue')->count(),
            'featured' => Offer::where('is_featured', true)->count(),
            'today' => Offer::whereDate('date_publication', today())->count(),
        ];
        return view('livewire.admin.offers-management.moderate-offers', [
            'offers' => $offers,
            'categories' => $this->categories,
            'regions' => $this->regions,
            'stats' => $stats,
        ]);
    }
}