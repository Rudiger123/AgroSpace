<?php

// app/Livewire/DashboardStats.php

namespace App\Livewire;

use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class DashboardStats extends Component
{
    public $totalOffers = 0;
    public $activeUsers = 0;
    public $unreadMessages = 0;
    public $totalConversations = 0;
    public $onlineUsers = 0;
    public $todayMessages = 0;

    /**
     * Rafraîchir les statistiques
     * Appelé automatiquement via wire:poll
     */
    public function refresh()
    {
        // Utiliser le cache pour optimiser les requêtes
        $this->totalOffers = Cache::remember('stats.total_offers', 300, function () {
            // Remplacer par votre logique métier
            return \App\Models\Offer::count();
        });

        $this->activeUsers = Cache::remember('stats.active_users', 60, function () {
            return User::where('is_online', true)->count();
        });

        $this->unreadMessages = Auth::user()->unreadMessagesCount();

        $this->totalConversations = Cache::remember(
            'stats.conversations.' . Auth::id(),
            300,
            function () {
                return Conversation::forUser(Auth::user())->count();
            }
        );

        $this->onlineUsers = User::where('is_online', true)->count();

        $this->todayMessages = Message::whereDate('created_at', today())->count();
    }

    public function mount()
    {
        $this->refresh();
    }

    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}
