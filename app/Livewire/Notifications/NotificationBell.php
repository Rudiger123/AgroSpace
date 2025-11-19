<?php

namespace App\Livewire\Notifications;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationBell extends Component
{
    public int $unreadCount = 0;
    public bool $showDropdown = false;

    protected $listeners = [
        'notificationReceived' => 'incrementUnreadCount',
        'notificationRead' => 'decrementUnreadCount',
        'allNotificationsRead' => 'resetUnreadCount',
        'echo:notifications.{userId},notification' => 'handleBroadcastNotification',
    ];

    /**
     * Mount the component.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->updateUnreadCount();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.notifications.notification-bell');
    }

    /**
     * Update the unread notifications count.
     *
     * @return void
     */
    public function updateUnreadCount(): void
    {
        if (Auth::check()) {
            $this->unreadCount = Auth::user()
                ->unreadNotifications()
                ->count();
        }
    }

    /**
     * Increment the unread count.
     *
     * @return void
     */
    public function incrementUnreadCount(): void
    {
        $this->unreadCount++;
    }

    /**
     * Decrement the unread count.
     *
     * @return void
     */
    public function decrementUnreadCount(): void
    {
        if ($this->unreadCount > 0) {
            $this->unreadCount--;
        }
    }

    /**
     * Reset the unread count to zero.
     *
     * @return void
     */
    public function resetUnreadCount(): void
    {
        $this->unreadCount = 0;
    }

    /**
     * Toggle dropdown visibility.
     *
     * @return void
     */
    public function toggleDropdown(): void
    {
        $this->showDropdown = !$this->showDropdown;
        
        if ($this->showDropdown) {
            $this->dispatch('dropdownOpened');
        }
    }

    /**
     * Handle broadcast notification received via Echo.
     *
     * @param array $notification
     * @return void
     */
    public function handleBroadcastNotification(array $notification): void
    {
        $this->incrementUnreadCount();
        
        // Show toast notification
        $this->dispatch('showToast', [
            'type' => 'info',
            'message' => $notification['message'] ?? 'Nouvelle notification',
        ]);
    }

    /**
     * Get the dynamic listener for user-specific channel.
     *
     * @return array
     */
    public function getListeners()
    {
        $listeners = [
            'notificationReceived' => 'incrementUnreadCount',
            'notificationRead' => 'decrementUnreadCount',
            'allNotificationsRead' => 'resetUnreadCount',
        ];

        if (Auth::check()) {
            $userId = Auth::id();
            $listeners["echo-private:notifications.{$userId},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated"] = 'handleBroadcastNotification';
        }

        return $listeners;
    }
}
