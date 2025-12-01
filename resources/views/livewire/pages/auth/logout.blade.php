<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Actions\Logout;

new class extends Component {
    public $user;
    public $showLogoutModal = false;

    public function mount()
    {
        $this->user = Auth::user();
    }

    // Confirmation de la deconnection
    public function confirmLogout()
    {
        $this->showLogoutModal = true;
    }

    // Annuler la déconnexion
    public function cancelLogout()
    {
        $this->showLogoutModal = false;
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
            'message' => __('auth.logout_success'),
        ]);

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('auth.logout_success'),
        ]);

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <!-- Bouton de déconnexion -->
    <button wire:click="confirmLogout"
        class="flex items-center space-x-3 px-4 py-2.5 hover:bg-red-50 transition w-full rounded-lg">
        <div class="w-9 h-9 bg-red-100 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                </path>
            </svg>
        </div>
        <div class="text-left">
            <p class="text-sm font-semibold text-red-600">{{ __('auth.logout') }}</p>
            <p class="text-xs text-red-400">{{ __('auth.logout_subtext') }}</p>
        </div>
    </button>

    <!-- Modale de confirmation -->
    <div x-data="{ show: @entangle('showLogoutModal') }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;">

        <!-- Overlay -->
        <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm" @click="show = false">
        </div>

        <!-- Modale -->
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">

                <!-- Contenu de la modale -->
                <div class="bg-white px-6 pt-6 pb-4">
                    <!-- Icône -->
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                    </div>

                    <!-- Titre et description -->
                    <div class="mt-5 text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            {{ __('auth.logout_confirm_title') }}
                        </h3>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{ __('auth.logout_confirm_text') }}
                        </p>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div
                    class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:space-x-3 space-y-3 space-y-reverse sm:space-y-0">
                    <!-- Bouton Annuler -->
                    <button type="button" wire:click="cancelLogout"
                        class="flex-1 inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        {{ __('auth.logout_cancel') }}
                    </button>

                    <!-- Bouton Déconnexion -->
                    <button type="button" wire:click="logout"
                        class="flex-1 inline-flex justify-center items-center px-4 py-2.5 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 shadow-lg shadow-red-500/30">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        {{ __('auth.logout_confirm_button') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
