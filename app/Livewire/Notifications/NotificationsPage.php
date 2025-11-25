<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('La gestion des Notifications')]
class NotificationsPage extends Component
{
    use WithPagination;

    public $filter = 'all'; // 'all', 'unread', 'read'

    protected $queryString = ['filter'];

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function markAsRead($id)
    {
        try {
            $notification = Auth::user()->notifications()->findOrFail($id);
            $notification->markAsRead();

            $this->dispatch('refreshNotifications');

            // Toast Succès
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'Notification marquée comme lue.',
            ]);
        } catch (\Exception $e) {
            // Toast Erreur
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Impossible de modifier cette notification.',
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $notification = Auth::user()->notifications()->findOrFail($id);
            $notification->delete();

            $this->dispatch('refreshNotifications');

            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'Notification supprimée avec succès.',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Une erreur est survenue lors de la suppression.',
            ]);
        }
    }

    public function markAllRead()
    {
        try {
            Auth::user()->unreadNotifications->markAsRead();

            $this->dispatch('refreshNotifications');

            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'Toutes les notifications ont été marquées comme lues.',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Erreur lors de la mise à jour des notifications.',
            ]);
        }
    }

    public function confirmDeleteAll()
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer la suppréssion',
            'text' => "Êtes-vous sûr de vouloir supprimer toutes les notifications de l'utilisateur ?",
            'icon' => 'question',
            'confirmText' => 'Oui, supprimer',
            'cancelText' => 'Annuler',
            'method' => 'deleteAll',
            'params' => []
        ]);
    }

    #[On('deleteAll')]
    public function deleteAll()
    {
        try {
            Auth::user()->notifications()->delete();

            $this->dispatch('refreshNotifications');
            $this->resetPage();

            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'Toutes les notifications ont été supprimées.',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Impossible de vider les notifications.',
            ]);
        }
    }

    public function render()
    {
        $query = Auth::user()->notifications();

        if ($this->filter === 'unread') {
            $query->whereNull('read_at');
        } elseif ($this->filter === 'read') {
            $query->whereNotNull('read_at');
        }

        return view('livewire.notifications.notifications-page', [
            'notifications' => $query->paginate(10)
        ]);
    }
}
