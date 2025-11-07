<?php

namespace App\Livewire\Admin\UsersManagement;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            ->when($this->filterRole, fn($query) => $query->whereHas('role', function ($q) {
                $q->where('name', $this->filterRole);
            }))
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

    /**
     * Confirmation pour vérifier un utilisateur
     */
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
            'params' => ['userId' => $userId] // Toujours passer un tableau
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

    /**
     * Confirmation pour suspendre un utilisateur
     */
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

        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer la suspension',
            'text' => "Êtes-vous sûr de vouloir suspendre l'utilisateur \"{$user->name}\" ?",
            'icon' => 'warning',
            'confirmText' => 'Oui, suspendre',
            'cancelText' => 'Annuler',
            'method' => 'suspendUser',
            'params' => ['userId' => $userId] // Toujours passer un tableau
        ]);
    }

    #[On('suspendUser')]
    public function suspendUser($userId)
    {
        try {
            $user = User::findOrFail($userId);

            $user->status = 'suspended';
            $user->save();

            $this->loadStats();

            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => "L'utilisateur {$user->name} a été suspendu."
            ]);
        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'title' => 'Erreur',
                'text' => 'Une erreur est survenue lors de la suspension : ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    /**
     * Confirmation pour réactiver un utilisateur
     */
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
            'text' => "Êtes-vous sûr de vouloir réactiver l'utilisateur \"{$user->name}\" ?",
            'icon' => 'question',
            'confirmText' => 'Oui, réactiver',
            'cancelText' => 'Annuler',
            'method' => 'reactivateUser',
            'params' => ['userId' => $userId] // Toujours passer un tableau
        ]);
    }

    #[On('reactivateUser')]
    public function reactivateUser($userId)
    {
        try {
            $user = User::findOrFail($userId);

            $user->status = 'active';
            $user->save();
            $this->loadStats();

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => "L'utilisateur {$user->name} a été réactivé."
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
     * Confirmation de suppression d'un utilisateur
     */
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

        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer la suppression',
            'text' => "Êtes-vous sûr de vouloir supprimer l'utilisateur \"{$user->name}\" ? Cette action est irréversible.",
            'icon' => 'warning',
            'confirmText' => 'Oui, supprimer',
            'cancelText' => 'Annuler',
            'method' => 'deleteUser',
            'params' => ['userId' => $userId] // Toujours passer un tableau
        ]);
    }

    /**
     * Suppression effective de l'utilisateur
     */
    #[On('deleteUser')]
    public function deleteUser($userId)
    {
        try {
            DB::transaction(function () use ($userId) {
                $user = User::find($userId);

                if ($user) {
                    // Supprimer les relations si nécessaire
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

    /**
     * Confirmation pour l'envoi d'email en masse
     */
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
            'params' => [] // Tableau vide pour les méthodes sans paramètres
        ]);
    }

    #[On('bulkSendEmail')]
    public function bulkSendEmail()
    {
        if (empty($this->selectedUsers)) {
            $this->dispatch('alert', [
                'title' => 'Erreur',
                'text' => 'Aucun utilisateur sélectionné.',
                'icon' => 'error'
            ]);
            return;
        }

        // Dispatch event pour ouvrir modal d'envoi d'email en masse
        $this->dispatch('openSendEmailModal', userIds: $this->selectedUsers);

        $this->dispatch('toast', [
            'type' => 'info',
            'message' => count($this->selectedUsers) . " utilisateur(s) sélectionné(s) pour l'envoi d'email."
        ]);
    }

    /**
     * Confirmation pour la suspension en masse
     */
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
            'text' => "Êtes-vous sûr de vouloir suspendre {$userText} ?",
            'icon' => 'warning',
            'confirmText' => 'Oui, suspendre',
            'cancelText' => 'Annuler',
            'method' => 'bulkSuspend',
            'params' => [] // Tableau vide pour les méthodes sans paramètres
        ]);
    }

    #[On('bulkSuspend')]
    public function bulkSuspend()
    {
        if (empty($this->selectedUsers)) {
            $this->dispatch('alert', [
                'title' => 'Erreur',
                'text' => 'Aucun utilisateur sélectionné.',
                'icon' => 'error'
            ]);
            return;
        }

        try {
            $affected = User::whereIn('id', $this->selectedUsers)
                ->whereHas('role', function ($query) {
                    $query->where('name', '!=', 'admin');
                })
                ->update(['status' => 'suspended']);

            $this->loadStats();
            $this->selectedUsers = [];
            $this->selectAll = false;

            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => "{$affected} utilisateur(s) suspendu(s) avec succès."
            ]);
        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'title' => 'Erreur',
                'text' => 'Une erreur est survenue lors de la suspension : ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    /**
     * Confirmation pour la suppression en masse
     */
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
            'params' => [] // Tableau vide pour les méthodes sans paramètres
        ]);
    }

    #[On('bulkDelete')]
    public function bulkDelete()
    {
        if (empty($this->selectedUsers)) {
            $this->dispatch('alert', [
                'title' => 'Erreur',
                'text' => 'Aucun utilisateur sélectionné.',
                'icon' => 'error'
            ]);
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
                    if (method_exists($user, 'offers')) {
                        $user->offers()->delete();
                    }
                    if (method_exists($user, 'demands')) {
                        $user->demands()->delete();
                    }
                    if (method_exists($user, 'messages')) {
                        $user->messages()->delete();
                    }
                    $user->delete();
                    $count++;
                }

                $this->loadStats();
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
                'text' => 'Une erreur est survenue lors de la suppression : ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
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
                    $user->role->name ?? $user->role,
                    $user->status,
                    $user->region,
                    $user->city,
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
