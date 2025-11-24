<?php

namespace App\Livewire\Admin\DemandsManagement;

use App\Models\Demand;
use App\Models\Category;
use App\Notifications\DemandActivated;
use Illuminate\Support\Facades\DB;
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

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'categoryFilter' => ['except' => ''],
        'verifiedFilter' => ['except' => 'all']
    ];

    protected $regions = [
        'Adamaoua', 'Centre', 'Est', 'Extrême-Nord', 'Littoral',
        'Nord', 'Nord-Ouest', 'Ouest', 'Sud', 'Sud-Ouest'
    ];

    public function viewDetails($id)
    {
        $this->selectedDemand = Demand::with(['category', 'user', 'responses.user'])->findOrFail($id);
        $this->showDetailsModal = true;
    }

    public function openVerifyModal($id)
    {
        $this->verificationNote = '';
        $demand = Demand::findOrFail($id);

        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer la vérification',
            'text' => "Êtes-vous sûr de vouloir vérifier la demande \"{$demand->title}\" ?",
            'icon' => 'question',
            'confirmText' => 'Oui, vérifier',
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

            // Rafraîchir les graphiques
            $this->dispatch('refreshCharts');
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

            // Rafraîchir les graphiques
            $this->dispatch('refreshCharts');
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
            $previousStatus = $demand->status;

            $demand->update(['status' => $status]);

            // --- NOTIFICATION LOGIC ---
            if ($status === 'active' && $previousStatus !== 'active') {
                if ($demand->user) {
                    // $demand->user->notify(new DemandActivated($demand));
                }
            }

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

            // Rafraîchir les graphiques
            $this->dispatch('refreshCharts');
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

            // Rafraîchir les graphiques
            $this->dispatch('refreshCharts');
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur lors de la suppression'
            ]);
        }
    }

    public function expireOldDemands()
    {
        $count = Demand::where('status', 'active')
            ->whereDate('validity_date', '<', now())
            ->update(['status' => 'expired']);

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => "$count demande(s) expirée(s) mise(s) à jour"
        ]);

        // Rafraîchir les graphiques
        $this->dispatch('refreshCharts');
    }

    // Réinitialiser la pagination lors du changement de filtres
    public function updated($property)
    {
        if (in_array($property, ['search', 'statusFilter', 'categoryFilter', 'regionFilter', 'urgencyFilter', 'verifiedFilter', 'sortBy'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = Demand::with(['category', 'user', 'responses'])
            ->when($this->search, function ($q) {
                $q->where(function ($subQ) {
                    $subQ->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('city', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->statusFilter !== 'all', fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->categoryFilter, fn ($q) => $q->where('category_id', $this->categoryFilter))
            ->when($this->regionFilter, fn ($q) => $q->where('region', $this->regionFilter))
            ->when($this->urgencyFilter, fn ($q) => $q->where('urgency', $this->urgencyFilter))
            ->when($this->verifiedFilter !== 'all', function ($q) {
                $this->verifiedFilter === 'verified' ? $q->where('is_verified', true) : $q->where('is_verified', false);
            });

        // Sorting
        $query->when($this->sortBy === 'latest', fn ($q) => $q->latest())
              ->when($this->sortBy === 'oldest', fn ($q) => $q->oldest())
              ->when($this->sortBy === 'most_viewed', fn ($q) => $q->orderByDesc('views_count'))
              ->when($this->sortBy === 'most_responses', fn ($q) => $q->orderByDesc('contacts_received'));

        $demands = $query->paginate(15);
        $categories = Category::where('is_active', true)->where('type', 'demand')->get();

        // Statistics & Charts Data
        $stats = [
            'total' => Demand::count(),
            'active' => Demand::where('status', 'active')->count(),
            'verified' => Demand::where('is_verified', true)->count(),
            'pending' => Demand::where('is_verified', false)->where('status', 'active')->count(),
            'responses' => Demand::sum('contacts_received'),
        ];

        // Chart 1: Status Distribution
        $statuses = ['active', 'satisfied', 'expired', 'cancelled'];
        $statusChartData = [];

        foreach ($statuses as $status) {
            $statusChartData[$status] = Demand::where('status', $status)->count();
        }

        // Chart 2: Top Categories
        $categoryChartData = Demand::select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->category->name ?? 'Inconnu',
                    'total' => $item->total
                ];
            })
            ->toArray();

        // Données par défaut si vide
        if (empty($categoryChartData)) {
            $categoryChartData = [['name' => 'Aucune donnée', 'total' => 0]];
        }

        return view('livewire.admin.demands-management.demands-manage', [
            'demands' => $demands,
            'categories' => $categories,
            'regions' => $this->regions,
            'stats' => $stats,
            'chartData' => [
                'status' => $statusChartData,
                'categories' => $categoryChartData
            ]
        ]);
    }
}
