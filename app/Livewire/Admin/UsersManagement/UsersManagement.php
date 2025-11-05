<?php

namespace App\Livewire\Admin\UsersManagement;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
#[Title('Gestion des Utilisateurs - Agrospace')]
class UsersManagement extends Component
{
    use WithPagination;

    protected $listeners = [
        'deleteUser' => 'deleteUser',
    ];

    // Filtres
    #[Url(as: 'q')]
    public $search = '';

    #[Url]
    public $filterRole = '';

    #[Url]
    public $filterStatus = '';

    #[Url]
    public $filterRegion = '';

    // Sélection multiple
    public $selectedUsers = [];
    public $selectAll = false;

    // Stats
    public $totalUsers;
    public $activeUsers;
    public $producers;
    public $consumers;
    public $verifiedUsers;
    // View History
    public $selectedUser;
    public $offers = [];
    public $demands = [];
    public $showHistory = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterRole' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterRegion' => ['except' => ''],
    ];

    public function mount()
    {
        $this->loadStats();
    }

    public function sleep()
    {
        sleep(13);
    }

    public function loadStats()
    {
        $this->totalUsers = User::count();
        $this->activeUsers = User::where('status', 'active')->count();
        $this->producers = User::whereHas('role', function ($query) {
            $query->where('name', 'producer');
        })->count();

        $this->consumers = User::whereHas('role', function ($query) {
            $query->where('name', 'consumer');
        })->count();

        $this->verifiedUsers = User::whereNotNull('email_verified_at')->count();
    }

    #[On('refresh-users')]
    public function refreshUsers()
    {
        $this->loadStats();
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterRole()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedFilterRegion()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedUsers = $this->getFilteredUsers()->pluck('id')->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterRole', 'filterStatus', 'filterRegion']);
        $this->resetPage();
    }

    private function getFilteredUsers()
    {
        return User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterRole, fn($query) => $query->ByRole($this->filterRole))
            ->when($this->filterStatus, fn($query) => $query->where('status', $this->filterStatus))
            ->when($this->filterRegion, fn($query) => $query->where('region', $this->filterRegion))
            ->withCount(['offers', 'demands'])
            ->orderBy('created_at', 'desc');
    }

    public function render()
    {
        $users = $this->getFilteredUsers()->paginate(10);

        return view('livewire.admin.users-management.users-management', [
            'users' => $users,
        ]);
    }

    // Actions individuelles
    public function viewUser($userId)
    {
        $this->dispatch('openUserDetailsModal', userId: $userId);
    }

    public function editUser($userId)
    {
        $this->dispatch('openEditUserModal', userId: $userId);
    }

    public function sendEmail($userId)
    {
        $this->dispatch('openSendEmailModal', userIds: [$userId]);
    }


    public function verifyUser($userId)
    {
        $user = User::findOrFail($userId);

        $user->email_verified_at = now();
        $user->save();

        $this->loadStats();

        session()->flash('success', "L'utilisateur {$user->name} a été vérifié avec succès.");
    }

    public function suspendUser($userId)
    {
        $user = User::findOrFail($userId);

        $user->status = 'suspended';
        $user->save();

        $this->loadStats();

        session()->flash('warning', "L'utilisateur {$user->name} a été suspendu.");
    }

    public function reactivateUser($userId)
    {
        $user = User::findOrFail($userId);

        $user->status = 'active';
        $user->save();
        $this->loadStats();

        session()->flash('success', "L'utilisateur {$user->name} a été réactivé.");
    }

    public function deleteUser()
    {
        try {
            if (!$this->selectedUser) {
                throw new \Exception('Aucun utilisateur sélectionné');
            }

            $userName = $this->selectedUser->name;
            $userEmail = $this->selectedUser->email;
            $user = $this->selectedUser;

            // Empêcher l'administrateur de se supprimer lui-même
            if ($this->selectedUser->id === Auth::user()->id) {
                $this->alert('error', 'Vous ne pouvez pas supprimer votre propre compte !');
                return;
            }

            // Supprimer l'utilisateur et toutes ses données associées
            DB::transaction(function () use ($user) {
                $user->offers()->delete();
                $user->demands()->delete();
                $user->delete();
            });

            // Message de succès
            $this->alert('success', "L'utilisateur {$userName} ({$userEmail}) a été supprimé avec succès.");

            // Réinitialiser la sélection
            $this->selectedUser = null;
        } catch (\Exception $e) {
            Log::error('Erreur suppression utilisateur: ' . $e->getMessage());
            $this->alert('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    public function confirmDelete($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->dispatch('show-admin-delete-confirmation', [
            'userName' => $this->selectedUser->name,
            'userEmail' => $this->selectedUser->email
        ]);
    }


    public function viewHistory($userId)
    {
        // Récupérer l'utilisateur avec ses relations selon son rôle
        $this->selectedUser = User::with(['offers', 'demands'])->findOrFail($userId);

        if ($this->selectedUser->isProducer()) {
            $this->offers = $this->selectedUser->offers()->latest()->get();
        }

        if ($this->selectedUser->isConsumer()) {
            $this->demands = $this->selectedUser->demands()->latest()->get();
        }

        $this->showHistory = true;
    }

    // Actions en masse
    public function bulkSendEmail()
    {
        if (empty($this->selectedUsers)) {
            session()->flash('error', 'Aucun utilisateur sélectionné.');
            return;
        }

        $users = User::whereIn('id', $this->selectedUsers)->get();

        // Dispatch event pour ouvrir modal d'envoi d'email en masse
        $this->dispatch('openBulkEmailModal', userIds: $this->selectedUsers);

        session()->flash('success', count($this->selectedUsers) . " utilisateur(s) sélectionné(s) pour l'envoi d'email.");
    }

    public function bulkSuspend()
    {
        if (empty($this->selectedUsers)) {
            session()->flash('error', 'Aucun utilisateur sélectionné.');
            return;
        }

        User::whereIn('id', $this->selectedUsers)
            ->where('role', '!=', 'admin') // Ne pas suspendre les admins
            ->update(['status' => 'suspended']);

        $this->loadStats();
        $count = count($this->selectedUsers);
        $this->selectedUsers = [];
        $this->selectAll = false;

        session()->flash('warning', "{$count} utilisateur(s) suspendu(s) avec succès.");
    }

    public function bulkDelete()
    {
        if (empty($this->selectedUsers)) {
            session()->flash('error', 'Aucun utilisateur sélectionné.');
            return;
        }

        DB::transaction(function () {
            $users = User::whereIn('id', $this->selectedUsers)
                ->where('role', '!=', 'admin') // Ne pas supprimer les admins
                ->get();

            foreach ($users as $user) {
                $user->offers()->delete();
                $user->demands()->delete();
                $user->messages()->delete();
                $user->delete();
            }
        });

        $this->loadStats();
        $count = count($this->selectedUsers);
        $this->selectedUsers = [];
        $this->selectAll = false;

        session()->flash('success', "{$count} utilisateur(s) supprimé(s) définitivement.");
    }

    public function exportUsers()
    {
        // Export en CSV
        $users = $this->getFilteredUsers()->get();

        $fileName = 'agrospace_users_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            // En-têtes CSV
            fputcsv($file, [
                'ID',
                'Nom',
                'Email',
                'Téléphone',
                'Rôle',
                'Statut',
                'Région',
                'Ville',
                'Vérifié',
                'Date d\'inscription',
                'Dernière activité',
                'Offres',
                'Demandes'
            ]);

            // Données
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone,
                    $user->role,
                    $user->status,
                    $user->location,
                    $user->email_verified_at ? 'Oui' : 'Non',
                    $user->created_at->format('Y-m-d H:i:s'),
                    $user->last_active_at ? $user->last_active_at->diffForHumans() : 'Jamais',
                    $user->offers_count ?? 0,
                    $user->demands_count ?? 0,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
