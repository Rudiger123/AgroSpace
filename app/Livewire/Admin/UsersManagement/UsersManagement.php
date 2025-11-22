<?php

namespace App\Livewire\Admin\UsersManagement;

use App\Models\User;
use App\Notifications\UserSuspendedNotification;
use App\Notifications\UserReactivatedNotification;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
#[Title('Gestion des Utilisateurs - Agrospace')]
class UsersManagement extends Component
{
    use WithPagination;

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
    public $suspendedUsers;
    public $newUsersThisMonth;
    
    // Stats pour graphiques
    public $usersByRole = [];
    public $usersByRegion = [];
    public $usersGrowth = [];

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
        $this->loadChartData();
    }

    public function loadStats()
    {
        $this->totalUsers = User::count();
        $this->activeUsers = User::where('status', 'active')->count();
        $this->suspendedUsers = User::where('status', 'suspended')->count();
        
        $this->producers = User::whereHas('role', function ($query) {
            $query->where('name', 'producer');
        })->count();

        $this->consumers = User::whereHas('role', function ($query) {
            $query->where('name', 'consumer');
        })->count();

        $this->verifiedUsers = User::whereNotNull('email_verified_at')->count();
        
        $this->newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    public function loadChartData()
    {
        // Utilisateurs par rôle
        $this->usersByRole = User::select('role_id', DB::raw('count(*) as count'))
            ->with('role')
            ->groupBy('role_id')
            ->get()
            ->map(function ($item) {
                return [
                    'role' => $item->role->name ?? 'Unknown',
                    'count' => $item->count
                ];
            })->toArray();

        // Utilisateurs par région (top 5)
        $this->usersByRegion = User::select('region', DB::raw('count(*) as count'))
            ->whereNotNull('region')
            ->groupBy('region')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->toArray();

        // Croissance des utilisateurs (6 derniers mois)
        $this->usersGrowth = collect(range(5, 0))->map(function ($monthsAgo) {
            $date = now()->subMonths($monthsAgo);
            return [
                'month' => $date->format('M Y'),
                'count' => User::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            ];
        })->toArray();
    }

    #[On('refresh-users')]
    public function refreshUsers()
    {
        $this->loadStats();
        $this->loadChartData();
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
        $currentUserId = Auth::id();
        
        return User::query()
            // Ne pas afficher l'utilisateur connecté s'il est admin
            ->when(Auth::user()->isAdmin(), function ($query) use ($currentUserId) {
                $query->where('id', '!=', $currentUserId);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterRole, fn ($query) => $query->whereHas('role', function ($q) {
                $q->where('name', $this->filterRole);
            }))
            ->when($this->filterStatus, fn ($query) => $query->where('status', $this->filterStatus))
            ->when($this->filterRegion, fn ($query) => $query->where('region', $this->filterRegion))
            ->with(['role'])
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
        // Vérifier que l'utilisateur n'est pas un admin
        $user = User::find($userId);
        
        if ($user && $user->isAdmin()) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Vous ne pouvez pas modifier un administrateur.'
            ]);
            return;
        }
        
        $this->dispatch('openEditUserModal', userId: $userId);
    }

    public function sendEmail($userId)
    {
        $this->dispatch('openSendEmailModal', userIds: [$userId]);
    }

    public function confirmVerifyUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Utilisateur non trouvé.'
            ]);
            return;
        }

        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer la vérification',
            'text' => "Êtes-vous sûr de vouloir vérifier l'utilisateur \"{$user->name}\" ?",
            'icon' => 'question',
            'confirmText' => 'Oui, vérifier',
            'cancelText' => 'Annuler',
            'method' => 'verifyUser',
            'params' => ['userId' => $userId]
        ]);
    }

    #[On('verifyUser')]
    public function verifyUser($userId)
    {
        try {
            $user = User::findOrFail($userId);

            $user->email_verified_at = now();
            $user->save();

            $this->loadStats();

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => "L'utilisateur {$user->name} a été vérifié avec succès."
            ]);
        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'title' => 'Erreur',
                'text' => 'Une erreur est survenue lors de la vérification : ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    public function confirmSuspendUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Utilisateur non trouvé.'
            ]);
            return;
        }

        // Ne pas pouvoir suspendre un admin
        if ($user->isAdmin()) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Vous ne pouvez pas suspendre un administrateur.'
            ]);
            return;
        }

        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer la suspension',
            'text' => "Êtes-vous sûr de vouloir suspendre l'utilisateur \"{$user->name}\" ? Il recevra une notification par email et sera déconnecté immédiatement.",
            'icon' => 'warning',
            'confirmText' => 'Oui, suspendre',
            'cancelText' => 'Annuler',
            'method' => 'suspendUser',
            'params' => ['userId' => $userId]
        ]);
    }

    #[On('suspendUser')]
    public function suspendUser($userId)
    {
        try {
            $user = User::findOrFail($userId);

            // Suspendre l'utilisateur
            $user->status = 'suspended';
            $user->suspended_at = now();
            $user->suspended_by = Auth::id();
            $user->save();

            // Envoyer notification par email
            $user->notify(new UserSuspendedNotification());

            // Déconnecter l'utilisateur s'il est connecté
            $this->logoutUser($user);

            $this->loadStats();
            $this->loadChartData();

            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => "L'utilisateur {$user->name} a été suspendu et déconnecté. Une notification lui a été envoyée."
            ]);
        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'title' => 'Erreur',
                'text' => 'Une erreur est survenue lors de la suspension : ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    public function confirmReactivateUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Utilisateur non trouvé.'
            ]);
            return;
        }

        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer la réactivation',
            'text' => "Êtes-vous sûr de vouloir réactiver l'utilisateur \"{$user->name}\" ? Il recevra une notification par email.",
            'icon' => 'question',
            'confirmText' => 'Oui, réactiver',
            'cancelText' => 'Annuler',
            'method' => 'reactivateUser',
            'params' => ['userId' => $userId]
        ]);
    }

    #[On('reactivateUser')]
    public function reactivateUser($userId)
    {
        try {
            $user = User::findOrFail($userId);

            // Réactiver l'utilisateur
            $user->status = 'active';
            $user->reactivated_at = now();
            $user->reactivated_by = Auth::id();
            $user->save();

            // Envoyer notification par email
            $user->notify(new UserReactivatedNotification());

            $this->loadStats();
            $this->loadChartData();

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => "L'utilisateur {$user->name} a été réactivé. Une notification lui a été envoyée."
            ]);
        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'title' => 'Erreur',
                'text' => 'Une erreur est survenue lors de la réactivation : ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    /**
     * Déconnecter un utilisateur en supprimant toutes ses sessions
     */
    private function logoutUser(User $user)
    {
        try {
            // Supprimer toutes les sessions de l'utilisateur
            DB::table('sessions')
                ->where('user_id', $user->id)
                ->delete();

            // Révoquer tous les tokens API si vous utilisez Sanctum
            if (method_exists($user, 'tokens')) {
                $user->tokens()->delete();
            }
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la déconnexion de l\'utilisateur : ' . $e->getMessage());
        }
    }

    public function confirmDelete($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Utilisateur non trouvé.'
            ]);
            return;
        }

        // Ne pas pouvoir supprimer un admin
        if ($user->isAdmin()) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Vous ne pouvez pas supprimer un administrateur.'
            ]);
            return;
        }

        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer la suppression',
            'text' => "Êtes-vous sûr de vouloir supprimer l'utilisateur \"{$user->name}\" ? Cette action est irréversible.",
            'icon' => 'warning',
            'confirmText' => 'Oui, supprimer',
            'cancelText' => 'Annuler',
            'method' => 'deleteUser',
            'params' => ['userId' => $userId]
        ]);
    }

    #[On('deleteUser')]
    public function deleteUser($userId)
    {
        try {
            DB::transaction(function () use ($userId) {
                $user = User::find($userId);

                if ($user && !$user->isAdmin()) {
                    // Déconnecter l'utilisateur
                    $this->logoutUser($user);

                    // Supprimer les relations
                    if (method_exists($user, 'offers')) {
                        $user->offers()->delete();
                    }
                    if (method_exists($user, 'demands')) {
                        $user->demands()->delete();
                    }

                    $userName = $user->name;

                    // Supprimer l'avatar
                    if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                        Storage::disk('public')->delete($user->avatar);
                    }
                    
                    $user->delete();

                    $this->loadStats();
                    $this->loadChartData();

                    $this->dispatch('toast', [
                        'type' => 'success',
                        'message' => "L'utilisateur \"{$userName}\" a été supprimé avec succès."
                    ]);
                }
            });
        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'title' => 'Erreur',
                'text' => 'Une erreur est survenue lors de la suppression : ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    public function viewHistory($userId)
    {
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
    public function confirmBulkSendEmail()
    {
        if (empty($this->selectedUsers)) {
            $this->dispatch('alert', [
                'title' => 'Aucune sélection',
                'text' => 'Veuillez sélectionner au moins un utilisateur.',
                'icon' => 'warning'
            ]);
            return;
        }

        $count = count($this->selectedUsers);
        $userText = $count > 1 ? "ces {$count} utilisateurs" : "cet utilisateur";

        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer l\'envoi d\'email',
            'text' => "Êtes-vous sûr de vouloir envoyer un email à {$userText} ?",
            'icon' => 'question',
            'confirmText' => 'Oui, envoyer',
            'cancelText' => 'Annuler',
            'method' => 'bulkSendEmail',
            'params' => []
        ]);
    }

    #[On('bulkSendEmail')]
    public function bulkSendEmail()
    {
        if (empty($this->selectedUsers)) {
            return;
        }

        $this->dispatch('openSendEmailModal', userIds: $this->selectedUsers);

        $this->dispatch('toast', [
            'type' => 'info',
            'message' => count($this->selectedUsers) . " utilisateur(s) sélectionné(s) pour l'envoi d'email."
        ]);
    }

    public function confirmBulkSuspend()
    {
        if (empty($this->selectedUsers)) {
            $this->dispatch('alert', [
                'title' => 'Aucune sélection',
                'text' => 'Veuillez sélectionner au moins un utilisateur.',
                'icon' => 'warning'
            ]);
            return;
        }

        $count = count($this->selectedUsers);
        $userText = $count > 1 ? "ces {$count} utilisateurs" : "cet utilisateur";

        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer la suspension multiple',
            'text' => "Êtes-vous sûr de vouloir suspendre {$userText} ? Ils recevront tous une notification par email et seront déconnectés.",
            'icon' => 'warning',
            'confirmText' => 'Oui, suspendre',
            'cancelText' => 'Annuler',
            'method' => 'bulkSuspend',
            'params' => []
        ]);
    }

    #[On('bulkSuspend')]
    public function bulkSuspend()
    {
        if (empty($this->selectedUsers)) {
            return;
        }

        try {
            $users = User::whereIn('id', $this->selectedUsers)
                ->whereHas('role', function ($query) {
                    $query->where('name', '!=', 'admin');
                })
                ->get();

            $affected = 0;
            foreach ($users as $user) {
                $user->status = 'suspended';
                $user->suspended_at = now();
                $user->suspended_by = Auth::id();
                $user->save();

                // Envoyer notification
                $user->notify(new UserSuspendedNotification());

                // Déconnecter
                $this->logoutUser($user);

                $affected++;
            }

            $this->loadStats();
            $this->loadChartData();
            $this->selectedUsers = [];
            $this->selectAll = false;

            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => "{$affected} utilisateur(s) suspendu(s) et déconnecté(s). Notifications envoyées."
            ]);
        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'title' => 'Erreur',
                'text' => 'Une erreur est survenue : ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    public function confirmBulkDelete()
    {
        if (empty($this->selectedUsers)) {
            $this->dispatch('alert', [
                'title' => 'Aucune sélection',
                'text' => 'Veuillez sélectionner au moins un utilisateur à supprimer.',
                'icon' => 'warning'
            ]);
            return;
        }

        $count = count($this->selectedUsers);
        $userText = $count > 1 ? "ces {$count} utilisateurs" : "cet utilisateur";

        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer la suppression multiple',
            'text' => "Êtes-vous sûr de vouloir supprimer {$userText} ? Cette action est irréversible.",
            'icon' => 'warning',
            'confirmText' => 'Oui, supprimer',
            'cancelText' => 'Annuler',
            'method' => 'bulkDelete',
            'params' => []
        ]);
    }

    #[On('bulkDelete')]
    public function bulkDelete()
    {
        if (empty($this->selectedUsers)) {
            return;
        }

        try {
            DB::transaction(function () {
                $users = User::whereIn('id', $this->selectedUsers)
                    ->whereHas('role', function ($query) {
                        $query->where('name', '!=', 'admin');
                    })
                    ->get();

                $count = 0;
                foreach ($users as $user) {
                    // Déconnecter
                    $this->logoutUser($user);

                    // Supprimer relations
                    if (method_exists($user, 'offers')) {
                        $user->offers()->delete();
                    }
                    if (method_exists($user, 'demands')) {
                        $user->demands()->delete();
                    }
                    
                    $user->delete();
                    $count++;
                }

                $this->loadStats();
                $this->loadChartData();
                $this->selectedUsers = [];
                $this->selectAll = false;

                $this->dispatch('toast', [
                    'type' => 'success',
                    'message' => "{$count} utilisateur(s) supprimé(s) définitivement."
                ]);
            });
        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'title' => 'Erreur',
                'text' => 'Une erreur est survenue : ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    public function exportUsers()
    {
        $users = $this->getFilteredUsers()->get();

        $fileName = 'agrospace_users_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

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
                'Dernière connexion',
                'Offres',
                'Demandes'
            ]);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone,
                    $user->role->name ?? 'N/A',
                    $user->status,
                    $user->region,
                    $user->city,
                    $user->email_verified_at ? 'Oui' : 'Non',
                    $user->created_at->format('Y-m-d H:i:s'),
                    $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'Jamais',
                    $user->offers_count ?? 0,
                    $user->demands_count ?? 0,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}