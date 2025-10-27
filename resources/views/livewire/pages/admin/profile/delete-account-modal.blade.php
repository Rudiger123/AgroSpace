<?php

use Livewire\Volt\Component;

new class extends Component {
    public $password = '';
    public $confirmation = '';

    protected $rules = [
        'password' => ['required', 'string', 'current_password'],
        'confirmation' => ['required', 'string', 'in:SUPPRIMER'],
    ];

    protected $messages = [
        'password.required' => 'Le mot de passe est obligatoire pour confirmer la suppression.',
        'password.current_password' => 'Le mot de passe est incorrect.',
        'confirmation.required' => 'Veuillez taper SUPPRIMER pour confirmer.',
        'confirmation.in' => 'Vous devez taper exactement SUPPRIMER pour confirmer.',
    ];

    /**
     * Validation en temps réel
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Supprimer le compte utilisateur
     */
    public function deleteAccount()
    {
        // Validation
        $this->validate();

        // Récupérer l'utilisateur
        $user = Auth::user();

        // Déconnecter l'utilisateur
        Auth::logout();

        // Supprimer le compte
        $user->delete();

        // Invalider la session
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Message flash
        session()->flash('message', 'Votre compte a été supprimé définitivement.');

        // Redirection vers la page d'accueil
        return redirect()->route('home');
    }
}; ?>

<div x-data.ignore="{ isOpen: false }">
    <button @click="isOpen = true"
        class="w-full flex items-center justify-between px-4 py-3 bg-red-50 text-red-700 rounded-lg 
                               hover:bg-red-100 border border-red-200 transition-all duration-200 transform hover:scale-105 shadow-sm hover:shadow-md">
        <span class="flex items-center space-x-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                </path>
            </svg>
            <span class="font-medium">Supprimer mon compte</span>
        </span>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

    {{-- Warning Suppression --}}
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mt-5">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700 font-medium">
                    Attention : La suppression de votre compte est définitive et irréversible.
                </p>
            </div>
        </div>
    </div>
    {{-- resources/views/livewire/profile/delete-account-modal.blade.php --}}
    <div>
        {{-- Modal Overlay --}}
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="isOpen = !isOpen"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50" style="display: none;"></div>

        {{-- Modal Content --}}
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 transform translate-y-4 scale-95"
            class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white"
                                        style="font-family: 'Poppins', sans-serif;">
                                        Supprimer le Compte
                                    </h2>
                                    <p class="text-white/80 text-sm">Action irréversible</p>
                                </div>
                            </div>
                            <button @click="isOpen = !isOpen"
                                class="p-2 hover:bg-white/10 rounded-lg transition-colors">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Form --}}
                    <form wire:submit="deleteAccount" class="p-6 space-y-5">

                        {{-- Avertissement --}}
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 mb-2">
                                        Attention : Cette action est définitive
                                    </h3>
                                    <div class="text-sm text-red-700 space-y-1">
                                        <p>• Toutes vos données seront supprimées</p>
                                        <p>• Vos offres et demandes seront perdues</p>
                                        <p>• Cette action ne peut pas être annulée</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Confirmation Text --}}
                        <div>
                            <label for="confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Pour confirmer, tapez <span class="font-bold text-red-600">SUPPRIMER</span> <span
                                    class="text-red-500">*</span>
                            </label>
                            <input type="text" id="confirmation" wire:model.live.debounce.300ms="confirmation"
                                class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all
                                @error('confirmation') border-red-500 @else border-gray-300 @enderror"
                                placeholder="Tapez SUPPRIMER">
                            @error('confirmation')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Mot de Passe --}}
                        <div x-data.ignore="{ showPassword: false }">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Votre mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" id="password"
                                    wire:model.live.debounce.300ms="password"
                                    class="w-full pl-10 pr-12 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all
                                    @error('password') border-red-500 @else border-gray-300 @enderror"
                                    placeholder="Entrez votre mot de passe">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-500">
                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Barre de progression --}}
                        <div wire:loading wire:target="deleteAccount"
                            class="relative h-1 bg-gray-200 rounded-full overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-red-700 animate-progress">
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex items-center justify-end space-x-3 pt-2">
                            <button type="button" @click="isOpen = !isOpen"
                                class="px-5 py-2.5 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200">
                                Annuler
                            </button>

                            <button type="submit" wire:loading.attr="disabled" wire:target="deleteAccount"
                                class="px-5 py-2.5 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 
                                   transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg
                                   disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none
                                   flex items-center space-x-2">
                                <svg wire:loading.remove wire:target="deleteAccount" class="w-5 h-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                <svg wire:loading wire:target="deleteAccount" class="animate-spin h-5 w-5"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>

                                <span wire:loading.remove wire:target="deleteAccount">Supprimer définitivement</span>
                                <span wire:loading wire:target="deleteAccount">Suppression...</span>
                            </button>
                        </div>
                    </form>
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
