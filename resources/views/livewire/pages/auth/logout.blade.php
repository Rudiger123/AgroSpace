<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Actions\Logout;

new class extends Component {
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    protected $listeners = [
        'logout' => 'logout',
    ];

    // Confirmation de la deconnection
    public function confirmLogout()
    {
        $this->dispatch('confirm-logout', title: 'Confirmer la déconnexion', text: 'Êtes-vous sûr de vouloir vous déconnecter ?');
    }

    /**
     *  Déconnexion de l'utilisateur
     */
    public function logout(Logout $logout): void
    {
        $logout();
        // Message flash pour la page de connexion
        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Vous avez été déconnecté avec succès.',
        ]);

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => 'Vous avez été déconnecté avec succès.',
        ]);

        $this->redirect('/', navigate: true);
    }
}; ?>

<button wire:click ="confirmLogout"
    class="flex items-center space-x-3 px-4 py-2.5 hover:bg-red-50 transition w-full rounded-lg">
    <div class="w-9 h-9 bg-red-100 rounded-lg flex items-center justify-center">
        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
            </path>
        </svg>
    </div>
    <div class="text-left">
        <p class="text-sm font-semibold text-red-600">Déconnexion</p>
        <p class="text-xs text-red-400">Se déconnecter</p>
    </div>
</button>
