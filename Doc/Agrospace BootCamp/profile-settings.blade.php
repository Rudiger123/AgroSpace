<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component {
    public $user;

    // États des modals
    public $showChangePasswordModal = false;
    public $showDeleteAccountModal = false;

    public function mount()
    {
        $this->user = Auth::user();
    }

    /**
     * Ouvre le modal de changement de mot de passe
     */
    public function openChangePasswordModal()
    {
        $this->showChangePasswordModal = true;
    }

    /**
     * Ferme le modal de changement de mot de passe
     */
    public function closeChangePasswordModal()
    {
        $this->showChangePasswordModal = false;
    }

    /**
     * Ouvre le modal de suppression de compte
     */
    public function openDeleteAccountModal()
    {
        $this->showDeleteAccountModal = true;
    }

    /**
     * Ferme le modal de suppression de compte
     */
    public function closeDeleteAccountModal()
    {
        $this->showDeleteAccountModal = false;
    }

    /**
     * Déconnexion de l'utilisateur
     */
    public function logout()
    {
        Auth::logout();

        // Invalider la session
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Message flash pour la page de connexion
        session()->flash('message', 'Vous avez été déconnecté avec succès.');

        // Redirection vers la page de connexion
        return redirect()->route('login');
    }
}; ?>

<div>
    {{-- resources/views/livewire/profile/profile-settings.blade.php --}}
    <div class="min-h-screen bg-gradient-to-br from-[#F9F6EE] to-[#E8E5DC] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#2E7D32] mb-2" style="font-family: 'Poppins', sans-serif;">
                    Paramètres du Compte
                </h1>
                <p class="text-gray-600">Gérez vos informations personnelles et votre sécurité</p>
            </div>

            {{-- Message Flash de Succès --}}
            @if (session()->has('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform translate-y-2"
                    class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                        <button @click="show = false" class="ml-auto flex-shrink-0 text-green-500 hover:text-green-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <div class="space-y-6">

                {{-- Section Informations Personnelles --}}
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-800" style="font-family: 'Poppins', sans-serif;">
                            Informations Personnelles
                        </h2>
                        <svg class="w-6 h-6 text-[#2E7D32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Nom</span>
                            <span class="text-gray-800">{{ $user->name }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Email</span>
                            <span class="text-gray-800">{{ $user->email }}</span>
                        </div>
                        <div class="flex justify-between py-3">
                            <span class="text-gray-600 font-medium">Membre depuis</span>
                            <span class="text-gray-800">{{ $user->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Section Sécurité --}}
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-800" style="font-family: 'Poppins', sans-serif;">
                            Sécurité
                        </h2>
                        <svg class="w-6 h-6 text-[#2E7D32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>

                    @livewire('pages.admin.profile.changepasswordmodal')

                </div>

                {{-- Section Actions du Compte --}}
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-800" style="font-family: 'Poppins', sans-serif;">
                            Actions du Compte
                        </h2>
                        <svg class="w-6 h-6 text-[#2E7D32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>

                    <div class="space-y-4">
                        {{-- Bouton Déconnexion --}}
                        <button wire:click="logout" wire:confirm="Êtes-vous sûr de vouloir vous déconnecter ?"
                            class="w-full flex items-center justify-between px-4 py-3 bg-gray-100 text-gray-700 rounded-lg 
                               hover:bg-gray-200 transition-all duration-200 transform hover:scale-105 shadow-sm hover:shadow-md">
                            <span class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                <span class="font-medium">Se déconnecter</span>
                            </span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>

                        {{-- Bouton Suppression de Compte --}}

                        @livewire('pages.admin.profile.delete-account-modal')
                      
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
