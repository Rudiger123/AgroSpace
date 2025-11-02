<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

new class extends Component {
    public $current_password = '';
    public $password = '';
    public $password_confirmation = '';

    protected function rules()
    {
        return [
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', Password::defaults(), 'confirmed'],
        ];
    }

    protected $messages = [
        'current_password.required' => 'L\'ancien mot de passe est obligatoire.',
        'current_password.current_password' => 'L\'ancien mot de passe est incorrect.',
        'password.required' => 'Le nouveau mot de passe est obligatoire.',
        'password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
    ];

    /**
     * Validation en temps réel
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Changer le mot de passe
     */
    public function changePassword()
    {
        // Validation
        try {
            $validated = $this->validate();
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Mettre à jour le mot de passe
        $user->password = Hash::make($this->password);
        $user->save();

        // Message flash de succès
        session()->flash('success', 'Votre mot de passe a été modifié avec succès!');

        // Émettre un événement pour actualiser le parent
        $this->dispatch('password-changed');
    }
}; ?>

<div x-data.ignore="{ isOpen: false }">

    <div class="space-y-4">
        {{-- Bouton Changement de Mot de Passe --}}
        <button @click="isOpen = true"
            class="w-full flex items-center justify-between px-4 py-3 bg-[#2E7D32] text-white rounded-lg 
                               hover:bg-[#1B5E20] transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
            <span class="flex items-center space-x-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                    </path>
                </svg>
                <span class="font-medium">Modifier mon mot de passe</span>
            </span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        {{-- Info Sécurité --}}
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Utilisez un mot de passe fort avec au moins 8 caractères, incluant des
                        majuscules, minuscules et chiffres.
                    </p>
                </div>
            </div>
        </div>
    </div>
    {{-- resources/views/livewire/profile/change-password-modal.blade.php --}}
    <div>
        {{-- Modal Overlay --}}
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="isOpen = !isOpen"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40" style="display: none;"></div>

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
                    <div class="bg-gradient-to-r from-[#2E7D32] to-[#1B5E20] px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white"
                                        style="font-family: 'Poppins', sans-serif;">
                                        Changer de Mot de Passe
                                    </h2>
                                    <p class="text-white/80 text-sm">Sécurisez votre compte</p>
                                </div>
                            </div>
                            <button @click = "isOpen = false"
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
                    <form wire:submit="changePassword" class="p-6 space-y-5">
                        {{-- Message Flash de Succès --}}
                        @if (session()->has('success'))
                            <x-flash-message>
                                {{ session('success') }}
                            </x-flash-message>
                        @endif
                        {{-- Ancien Mot de Passe --}}
                        <div x-data.ignore="{ showPassword: false }">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Ancien mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" id="current_password"
                                    wire:model.live.debounce.300ms="current_password"
                                    class="w-full pl-10 pr-12 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all
                                    border-gray-300 "
                                    placeholder="Votre ancien mot de passe">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#2E7D32]">
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
                            @error('current_password')
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

                        {{-- Nouveau Mot de Passe --}}
                        <div x-data.ignore="{ showPassword: false }">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Nouveau mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" id="password"
                                    wire:model.live.debounce.300ms="password"
                                    class="w-full pl-10 pr-12 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all
                                     border-gray-300"
                                    placeholder="Minimum 8 caractères">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#2E7D32]">
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
                            @else
                                {{-- Indicateur de Force du Mot de Passe --}}
                                @if ($password)
                                    <div class="mt-2" x-data="{
                                        strength: 0,
                                        getStrength() {
                                            let pass = '{{ $password }}';
                                            if (!pass) return 0;
                                            let str = 0;
                                            if (pass.length >= 8) str++;
                                            if (pass.length >= 12) str++;
                                            if (/[a-z]/.test(pass) && /[A-Z]/.test(pass)) str++;
                                            if (/\d/.test(pass)) str++;
                                            if (/[^a-zA-Z\d]/.test(pass)) str++;
                                            return Math.min(str, 4);
                                        }
                                    }" x-init="strength = getStrength()">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex-1 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                                <div class="h-full transition-all duration-300 rounded-full"
                                                    :class="{
                                                        'w-1/4 bg-red-500': strength === 1,
                                                        'w-2/4 bg-orange-500': strength === 2,
                                                        'w-3/4 bg-yellow-500': strength === 3,
                                                        'w-full bg-green-500': strength === 4
                                                    }">
                                                </div>
                                            </div>
                                            <span class="text-xs font-medium"
                                                :class="{
                                                    'text-red-500': strength === 1,
                                                    'text-orange-500': strength === 2,
                                                    'text-yellow-500': strength === 3,
                                                    'text-green-500': strength === 4
                                                }"
                                                x-text="strength === 1 ? 'Faible' : strength === 2 ? 'Moyen' : strength === 3 ? 'Bon' : 'Fort'"></span>
                                        </div>
                                    </div>
                                @endif
                            @enderror
                        </div>

                        {{-- Confirmation Mot de Passe --}}
                        <div x-data.ignore="{ showPassword: false }">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmer le nouveau mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" id="password_confirmation"
                                    wire:model.live.debounce.300ms="password_confirmation"
                                    class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all"
                                    placeholder="Retapez le nouveau mot de passe">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#2E7D32]">
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
                        </div>

                        {{-- Barre de progression --}}
                        <div wire:loading wire:target="changePassword"
                            class="relative h-1 bg-gray-200 rounded-full overflow-hidden">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-[#2E7D32] to-[#4CAF50] animate-progress">
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex items-center justify-end space-x-3 pt-2">
                            <button type="button" @click="isOpen = !isOpen"
                                class="px-5 py-2.5 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200">
                                Annuler
                            </button>

                            <button type="submit" wire:loading.attr="disabled" wire:target="changePassword"
                                class="px-5 py-2.5 bg-[#2E7D32] text-white rounded-lg font-medium hover:bg-[#1B5E20] 
                                   transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg
                                   disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none
                                   flex items-center space-x-2">
                                <svg wire:loading.remove wire:target="changePassword" class="w-5 h-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>

                                <svg wire:loading wire:target="changePassword" class="animate-spin h-5 w-5"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>

                                <span wire:loading.remove wire:target="changePassword">Valider</span>
                                <span wire:loading wire:target="changePassword">Enregistrement...</span>
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

        @keyframes progress {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .animate-progress {
            animation: progress 1.5s ease-in-out infinite;
        }
    </style>
</div>
