<?php

namespace App\Livewire\Admin\DemandsManagement;

use App\Models\Demand;
use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Gestion des Demandes')]
class DemandsManage extends Component
{
    use WithPagination;

    public $showDetailsModal = false;
    public $showVerifyModal = false;
    public $showDeleteModal = false;

    public $selectedDemand = null;
    public $demandId = null;
    public $verificationNote = '';

    public $search = '';
    public $statusFilter = 'all';
    public $categoryFilter = '';
    public $regionFilter = '';
    public $urgencyFilter = '';
    public $verifiedFilter = 'all';
    public $sortBy = 'latest';

    protected $queryString = ['search', 'statusFilter', 'categoryFilter', 'verifiedFilter'];

    protected $regions = [
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

    public function viewDetails($id)
    {
        $this->selectedDemand = Demand::with(['category', 'user', 'responses.user'])->findOrFail($id);
        $this->showDetailsModal = true;
    }

    public function openVerifyModal($id)
    {
        $this->verificationNote = '';
        $demand = Demand::findOrfail($id);

        if (!$demand) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Demande non trouvé.'
            ]);
            return;
        }

        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer la vérification',
            'text' => "Êtes-vous sûr de vouloir verifier la demande \"{$demand->title}\" ?",
            'icon' => 'question',
            'confirmText' => 'Oui, verifier',
            'cancelText' => 'Annuler',
            'method' => 'DemandVerified',
            'params' => ['demandId' => $id]
        ]);
    }

    #[On('DemandVerified')]
    public function verifyDemand($demandId)
    {
        try {
            $demand = Demand::findOrFail($demandId);
            $demand->update([
                'is_verified' => true,
                'verified_at' => now(),
            ]);

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Demande vérifiée avec succès'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur lors de la vérification'
            ]);
        }
    }

    public function unverifyDemand($id)
    {
        try {
            $demand = Demand::findOrFail($id);
            $demand->update([
                'is_verified' => false,
                'verified_at' => null,
            ]);

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Vérification retirée'
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
            $demand = Demand::findOrFail($id);
            $demand->update(['status' => $status]);

            $statusLabels = [
                'active' => 'active',
                'satisfied' => 'satisfaite',
                'expired' => 'expirée',
                'cancelled' => 'annulée'
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
        $this->demandId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteDemand()
    {
        try {
            $demand = Demand::findOrFail($this->demandId);
            $demand->delete();

            $this->showDeleteModal = false;

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Demande supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur lors de la suppression'
            ]);
        }
    }

    public function expireOldDemands()
    {
        $count = Demand::expired()->update(['status' => 'expired']);

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => "$count demande(s) expirée(s) mise(s) à jour"
        ]);
    }

    public function render()
    {
        $demands = Demand::with(['category', 'user', 'responses'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('city', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->when($this->regionFilter, function ($query) {
                $query->where('region', $this->regionFilter);
            })
            ->when($this->urgencyFilter, function ($query) {
                $query->where('urgency', $this->urgencyFilter);
            })
            ->when($this->verifiedFilter !== 'all', function ($query) {
                if ($this->verifiedFilter === 'verified') {
                    $query->where('is_verified', true);
                } else {
                    $query->where('is_verified', false);
                }
            })
            ->when($this->sortBy === 'latest', function ($query) {
                $query->latest();
            })
            ->when($this->sortBy === 'oldest', function ($query) {
                $query->oldest();
            })
            ->when($this->sortBy === 'most_viewed', function ($query) {
                $query->orderBy('views_count', 'desc');
            })
            ->when($this->sortBy === 'most_responses', function ($query) {
                $query->orderBy('contacts_received', 'desc');
            })
            ->paginate(15);

        $categories = Category::where('is_active', true)->get();

        // Statistics
        $stats = [
            'total' => Demand::count(),
            'active' => Demand::where('status', 'active')->count(),
            'verified' => Demand::where('is_verified', true)->count(),
            'pending_verification' => Demand::where('is_verified', false)->where('status', 'active')->count(),
            'satisfied' => Demand::where('status', 'satisfied')->count(),
            'expired' => Demand::where('status', 'expired')->count(),
            'responses' => Demand::sum('contacts_received'),
        ];

        return view('livewire.admin.demands-management.demands-manage', [
            'demands' => $demands,
            'categories' => $categories,
            'regions' => $this->regions,
            'stats' => $stats,
        ]);
    }
}
