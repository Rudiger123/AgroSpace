<?php

namespace App\Livewire\Notifications;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationList extends Component
{
    use WithPagination;

    public int $limit = 10;
    public bool $showOnlyUnread = false;

    protected $listeners = [
        'dropdownOpened' => 'refreshNotifications',
        'markAllAsRead' => 'markAllAsRead',
    ];

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $notifications = $this->getNotifications();

        return view('livewire.notifications.notification-list', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * Get notifications based on filters.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getNotifications()
    {
        if (!Auth::check()) {
            return collect();
        }

        $query = Auth::user()->notifications();

        if ($this->showOnlyUnread) {
            $query->whereNull('read_at');
        }

        return $query->take($this->limit)->get();
    }

    /**
     * Refresh notifications list.
     *
     * @return void
     */
    public function refreshNotifications(): void
    {
        // Just trigger a re-render
        $this->render();
    }

    /**
     * Mark a single notification as read.
     *
     * @param string $notificationId
     * @return void
     */
    public function markAsRead(string $notificationId): void
    {
        if (!Auth::check()) {
            return;
        }

        $notification = Auth::user()
            ->notifications()
            ->where('id', $notificationId)
            ->first();

        if ($notification && !$notification->read_at) {
            $notification->markAsRead();
            $this->dispatch('notificationRead');
        }
    }

    /**
     * Mark all notifications as read.
     *
     * @return void
     */
    public function markAllAsRead(): void
    {
        if (!Auth::check()) {
            return;
        }

        Auth::user()->unreadNotifications->markAsRead();
        $this->dispatch('allNotificationsRead');

        $this->dispatch('showToast', [
            'type' => 'success',
            'message' => 'Toutes les notifications ont été marquées comme lues',
        ]);
    }

    /**
     * Delete a notification.
     *
     * @param string $notificationId
     * @return void
     */
    public function deleteNotification(string $notificationId): void
    {
        if (!Auth::check()) {
            return;
        }

        $notification = Auth::user()
            ->notifications()
            ->where('id', $notificationId)
            ->first();

        if ($notification) {
            // If it was unread, decrease the counter
            if (!$notification->read_at) {
                $this->dispatch('notificationRead');
            }

            $notification->delete();

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => 'Notification supprimée',
            ]);
        }
    }

    /**
     * Handle notification click (mark as read and redirect).
     *
     * @param string $notificationId
     * @param string|null $actionUrl
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function handleNotificationClick(string $notificationId, ?string $actionUrl = null)
    {
        $this->markAsRead($notificationId);

        if ($actionUrl) {
            return redirect($actionUrl);
        }
    }

    /**
     * Toggle show only unread filter.
     *
     * @return void
     */
    public function toggleUnreadFilter(): void
    {
        $this->showOnlyUnread = !$this->showOnlyUnread;
    }

    public function getIconSvg(string $type, string $color)
    {
        $svgs = [
            'offer' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>',
            'article' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h10l4 4v12a2 2 0 01-2 2z" />
                         </svg>',
            'message' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m-4 4h6" />
                          </svg>',
            'default' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V8a6 6 0 10-12 0v6c0 .386-.149.735-.395 1.001L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                         </svg>',
        ];

        return $svgs[$type] ?? $svgs['default'];
    }

    public function getIconConfig(string $type, string $color)
    {
        $icons = [
            'offer' => 'fa-solid fa-tag text-green-500',
            'article' => 'fa-solid fa-newspaper text-blue-500',
            'message' => 'fa-solid fa-envelope text-yellow-500',
            'default' => 'fa-solid fa-bell text-gray-500',
        ];

        return $icons[$type] ?? $icons['default'];
    }
}
