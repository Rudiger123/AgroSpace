<?php

namespace App\Livewire\Admin\DemandsManagement;

use App\Events\Notifications\DemandCreated;
use App\Models\Demand;
use App\Models\Category;
use App\Models\User;
use App\Notifications\DemandCreatedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Layout("layouts.app")]
#[Title("Demands Management")]
class MyDemands extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showDeleteModal = false;
    public $showDetailsModal = false;

    public $demandId = null;
    public $title = '';
    public $description = '';
    public $category_id = '';
    public $quantity = '';
    public $city = '';
    public $region = '';
    public $validity_date = '';
    public $budget = '';
    public $urgency = 'medium';

    public $search = '';
    public $statusFilter = 'all';
    public $categoryFilter = '';
    public $regionFilter = '';
    public $urgencyFilter = '';

    public $selectedDemand = null;

    protected $queryString = ['search', 'statusFilter', 'categoryFilter'];

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

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'nullable|string|max:100',
            'city' => 'required|string|max:100',
            'region' => 'required|in:' . implode(',', $this->regions),
            'validity_date' => 'required|date|after:today',
            'budget' => 'nullable|numeric|min:0',
            'urgency' => 'required|in:low,medium,high',
        ];
    }

    public function mount()
    {
        // Set default validity date to 30 days from now
        $this->validity_date = now()->addDays(30)->format('Y-m-d');
    }

    public function openCreateModal()
    {
        $this->reset(['demandId', 'title', 'description', 'category_id', 'quantity', 'city', 'budget', 'urgency']);
        $this->region = '';
        $this->validity_date = now()->addDays(30)->format('Y-m-d');
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $demand = Demand::findOrFail($id);

        if ($demand->user_id !== Auth::user()->id) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => __('demands.unauthorized_edit')
            ]);
            return;
        }

        $this->demandId = $demand->id;
        $this->title = $demand->title;
        $this->description = $demand->description;
        $this->category_id = $demand->category_id;
        $this->quantity = $demand->quantity;
        $this->city = $demand->city;
        $this->region = $demand->region;
        $this->validity_date = $demand->validity_date->format('Y-m-d');
        $this->budget = $demand->budget;
        $this->urgency = $demand->urgency;

        $this->showModal = true;
    }

    public function saveDemand()
    {
        $this->validate();

        try {
            if ($this->demandId) {
                $demand = Demand::findOrFail($this->demandId);

                if ($demand->user_id !== Auth::user()->id) {
                    $this->dispatch('toast', [
                        'type' => 'error',
                        'message' => __('common.unauthorized_action')
                    ]);
                    return;
                }

                $demand->update([
                    'title' => $this->title,
                    'description' => $this->description,
                    'category_id' => $this->category_id,
                    'quantity' => $this->quantity,
                    'city' => $this->city,
                    'region' => $this->region,
                    'validity_date' => $this->validity_date,
                    'budget' => $this->budget,
                    'urgency' => $this->urgency,
                ]);

                $message = __('demands.update_success');
            } else {
                $demand = Demand::create([
                    'user_id' => Auth::user()->id,
                    'title' => $this->title,
                    'description' => $this->description,
                    'category_id' => $this->category_id,
                    'quantity' => $this->quantity,
                    'city' => $this->city,
                    'region' => $this->region,
                    'validity_date' => $this->validity_date,
                    'budget' => $this->budget,
                    'urgency' => $this->urgency,
                    'status' => 'active',
                ]);

                $message = __('demands.create_success');
                // Déclencher l'événement de notification
                // event(new DemandCreated($demand, Auth::user()));
                $this->notification($demand, Auth::user());
            }

            $this->showModal = false;
            $this->reset(['demandId', 'title', 'description', 'category_id', 'quantity', 'city', 'budget', 'urgency']);

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => $message
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => __('common.error_occurred', ['error' => $e->getMessage()])
            ]);
        }
    }

    public function notification(Demand $demand, User $user): void
    {
        try {
            Log::info('🎯 ' . __('notifications.processing_start'), [
                'demand_id' => $demand->id,
                'user_id' => $user->id
            ]);

            // Récupérer tous les administrateurs
            $admins = User::where('role_id', 1) // ID 1 = Administrateur
                ->where('status', 'active') // Seulement les admins actifs
                ->get();

            Log::info('👥 ' . __('notifications.admins_found'), [
                'count' => $admins->count(),
                'demand_id' => $demand->id
            ]);

            $notificationsSent = 0;

            // Envoyer la notification à chaque administrateur
            foreach ($admins as $admin) {
                try {
                    $admin->notify(new DemandCreatedNotification(
                        $demand,
                        $user
                    ));

                    $notificationsSent++;

                    Log::debug('✅ ' . __('notifications.sent_success'), [
                        'admin_id' => $admin->id,
                        'demand_id' => $demand->id
                    ]);
                } catch (\Exception $e) {
                    Log::error('❌ ' . __('notifications.send_error'), [
                        'admin_id' => $admin->id,
                        'demand_id' => $demand->id,
                        'error' => $e->getMessage()
                    ]);
                    // Continuer avec les autres admins même si un échoue
                }
            }

            Log::info('📊 ' . __('notifications.summary'), [
                'demand_id' => $demand->id,
                'admins_total' => $admins->count(),
                'notifications_sent' => $notificationsSent,
                'notifications_skipped' => $admins->count() - $notificationsSent
            ]);
        } catch (\Exception $e) {
            Log::error('💥 ' . __('notifications.critical_error'), [
                'demand_id' => $demand->id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
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

            if ($demand->user_id !== Auth::user()->id) {
                $this->dispatch('toast', [
                    'type' => 'error',
                    'message' => __('common.unauthorized_action')
                ]);
                return;
            }

            $demand->delete();
            $this->showDeleteModal = false;

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => __('demands.delete_success')
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => __('common.delete_error')
            ]);
        }
    }

    public function viewDetails($id)
    {
        $this->selectedDemand = Demand::with(['category', 'responses.user'])->findOrFail($id);
        $this->showDetailsModal = true;
    }

    public function updateStatus($id, $status)
    {
        try {
            $demand = Demand::findOrFail($id);

            if ($demand->user_id !== Auth::user()->id) {
                $this->dispatch('toast', [
                    'type' => 'error',
                    'message' => __('common.unauthorized_action')
                ]);
                return;
            }

            $demand->update(['status' => $status]);

            $statusLabels = [
                'active' => __('demands.status_active'),
                'satisfied' => __('demands.status_satisfied'),
                'cancelled' => __('demands.status_cancelled')
            ];

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => __('demands.marked_as', ['status' => $statusLabels[$status] ?? $status])
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => __('common.update_error')
            ]);
        }
    }

    public function render()
    {
        $demands = Demand::with(['category', 'responses'])
            ->where('user_id', Auth::user()->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('city', 'like', '%' . $this->search . '%');
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
            ->latest()
            ->paginate(10);

        $categories = Category::where('is_active', true)->where('type', 'demand')->get();

        return view('livewire.admin.demands-management.my-demands', [
            'demands' => $demands,
            'categories' => $categories,
            'regions' => $this->regions
        ]);
    }
}