<?php

// app/Livewire/NotificationsDropdown.php

namespace App\Livewire\Notification;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsDropdown extends Component
{
    public $notifications = [];
    public $unreadCount = 0;
    public $isOpen = false;

    protected $listeners = [
        'notificationReceived' => 'handleNotificationReceived',
    ];

    public function mount()
    {
        $this->loadNotifications();
    }

    /**
     * Charger les notifications
     */
    public function loadNotifications()
    {
        $this->notifications = Auth::user()
            ->notifications()
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'data' => $notification->data,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans(),
                ];
            })
            ->toArray();

        $this->unreadCount = Auth::user()->unreadNotifications()->count();
    }

    /**
     * Gérer une nouvelle notification (depuis Echo)
     */
    public function handleNotificationReceived($data)
    {
        // Ajouter la notification en haut de la liste
        array_unshift($this->notifications, [
            'id' => uniqid(),
            'type' => $data['type'],
            'data' => [
                'title' => $data['title'],
                'message' => $data['message'],
                'action_url' => $data['action_url'] ?? null,
            ],
            'read_at' => null,
            'created_at' => 'À l\'instant',
        ]);

        $this->unreadCount++;

        // Limiter à 10 notifications
        $this->notifications = array_slice($this->notifications, 0, 10);

        // Afficher toast
        $this->dispatch('showToast', [
            'title' => $data['title'],
            'message' => $data['message'],
            'type' => $data['type'],
        ]);
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($notificationId)
    {
        $notification = Auth::user()
            ->notifications()
            ->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    /**
     * Marquer toutes comme lues
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }

    /**
     * Basculer l'ouverture du dropdown
     */
    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('livewire.notification.notifications-dropdown');
    }
}
