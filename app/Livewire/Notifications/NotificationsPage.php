<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Notification Management')]
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
                'message' => __('notifications.marked_read'),
            ]);
        } catch (\Exception $e) {
            // Toast Erreur
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => __('notifications.unable_to_mark_read'),
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
                'message' => __('notifications.deleted'),
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => __('notifications.delete_error'),
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
                'message' => __('notifications.all_marked_read'),
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => __('notifications.mark_all_error'),
            ]);
        }
    }

    public function confirmDeleteAll()
    {
        $this->dispatch('swal:confirm', [
            'title' => __('notifications.confirm_delete_all_title'),
            'text' => __('notifications.confirm_delete_all_text'),
            'icon' => 'question',
            'confirmText' => __('notifications.confirm_delete'),
            'cancelText' => __('notifications.cancel'),
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
                'message' => __('notifications.all_deleted'),
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => __('notifications.delete_all_error'),
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