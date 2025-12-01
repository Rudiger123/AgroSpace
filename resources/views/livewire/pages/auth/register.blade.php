<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    // Étape 1 : Infos Personnelles
    public string $name = '';
    public string $email = '';
    public $role_id = '';
    public bool $terms = false;

    // Étape 2 : Mot de passe
    public string $password = '';
    public string $password_confirmation = '';

    // État du formulaire
    public int $currentStep = 1;
    private int $totalSteps = 3;
    public bool $showTermsModal = false;

    // Règle de validation par étape
    public function getValidationRules($step)
    {
        return match ($step) {
            1 => [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'role_id' => ['required', 'exists:roles,id'],
            ],
            2 => [
                'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            ],
            3 => [
                'terms' => ['accepted'],
            ],
            default => [],
        };
    }

    /**
     * Valide et passe à l'étape suivante.
     */
    public function nextStep()
    {
        // 1. Valider l'étape actuelle
        $this->validate($this->getValidationRules($this->currentStep));

        // 2. Passer à l'étape suivante si elle existe
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            
            // Afficher automatiquement la modale au step 3
            if ($this->currentStep === 3) {
                $this->showTermsModal = true;
            }
        }
    }

    /**
     * Revenir à l'étape précédente.
     */
    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    /**
     * Accepter les conditions d'utilisation
     */
    public function acceptTerms()
    {
        $this->terms = true;
        $this->showTermsModal = false;
    }

    /**
     * Refuser les conditions d'utilisation
     */
    public function declineTerms()
    {
        $this->terms = false;
        $this->showTermsModal = false;
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        // 1. Valider l'étape finale (termes)
        $this->validate($this->getValidationRules(3));

        // 2. Valider toutes les étapes (pour garantir que l'utilisateur n'a pas bypassé la validation)
        $this->validate($this->getValidationRules(1));
        $this->validate($this->getValidationRules(2));

        // Données complètes
        $validatedData = [
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'password' => Hash::make($this->password),
        ];

        event(new Registered(($user = User::create($validatedData))));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div
        class="min-h-screen bg-gradient-to-br from-[#F9F6F1] to-[#E8F5E9] flex items-center justify-center overflow-hidden">
        <div class="container mx-auto h-screen flex">

            <!-- Colonne Gauche : Formulaire (40%) -->
            <div class="w-full lg:w-[40%] flex items-center justify-center p-4 lg:p-8 overflow-y-auto">
                <div class="w-full max-w-md">
                    <!-- Logo -->
                    <div class="flex items-center gap-2 mb-8">
                        <img src="/images/logo.png" alt="{{ __('auth.logo_alt') }}" class="w-10 h-10">
                        <span class="text-2xl font-bold text-[#16a34a]">{{ __('app.name') }}</span>
                    </div>

                    <!-- Titre -->
                    <div class="mb-8">
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">
                            {{ __('auth.create_account_title') }} 🌾
                        </h1>
                        <p class="text-gray-600">
                            {{ __('auth.create_account_subtitle') }}
                        </p>
                    </div>

                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold"
                                :class="{ 'text-primary-600': $wire.currentStep === 1 }">{{ __('auth.step_1') }}</span>
                            <span class="text-sm font-semibold"
                                :class="{ 'text-primary-600': $wire.currentStep === 2 }">{{ __('auth.step_2') }}</span>
                            <span class="text-sm font-semibold"
                                :class="{ 'text-primary-600': $wire.currentStep === 3 }">{{ __('auth.step_3') }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-primary-600 h-2.5 rounded-full transition-all duration-500"
                                :style="`width: ${($wire.currentStep / 3) * 100}%`">
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire -->
                    <form wire:submit="register">

                        <!-- STEP 1 -->
                        <div x-show="$wire.currentStep === 1" x-transition:enter.duration.500ms>
                            <h3 class="text-xl font-bold mb-4">{{ __('auth.step_1_title') }}</h3>

                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('auth.full_name') }}</label>
                                    <input id="name" type="text" wire:model="name" autofocus
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('auth.email_address') }}</label>
                                    <input id="email" type="email" wire:model="email"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="role_id" class="block text-sm font-medium text-gray-700">{{ __('auth.i_am') }}</label>
                                    <select id="role_id" wire:model="role_id"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">{{ __('auth.select_role') }}</option>
                                        @foreach (App\Models\Role::where('name', '!=', 'admin')->get() as $role)
                                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="button" wire:click="nextStep"
                                    class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200">
                                    {{ __('auth.next') }} &rarr;
                                </button>
                            </div>
                        </div>

                        <!-- STEP 2 -->
                        <div x-show="$wire.currentStep === 2" x-transition:enter.duration.500ms>
                            <h3 class="text-xl font-bold mb-4">{{ __('auth.step_2_title') }}</h3>

                            <div class="space-y-4">
                                <div x-data="{ showPassword: false }">
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        {{ __('auth.password') }}
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                        <input :type="showPassword ? 'text' : 'password'" id="password" wire:model="password"
                                            placeholder="••••••••"
                                            class="w-full pl-12 pr-12 py-3.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:border-transparent transition"
                                            required />
                                        <button type="button" @click="showPassword = !showPassword"
                                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#16a34a] transition">
                                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l3.59 3.59m0 0a9.953 9.953 0 012.82-1.872" />
                                            </svg>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div x-data="{ showPassword: false }">
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        {{ __('auth.confirm_password') }}
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <input :type="showPassword ? 'text' : 'password'" id="password_confirmation" wire:model="password_confirmation"
                                            placeholder="••••••••"
                                            class="w-full pl-12 pr-12 py-3.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:border-transparent transition"
                                            required />
                                        <button type="button" @click="showPassword = !showPassword"
                                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#16a34a] transition">
                                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l3.59 3.59m0 0a9.953 9.953 0 012.82-1.872" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-between">
                                <button type="button" wire:click="previousStep"
                                    class="border border-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-md transition duration-200 hover:bg-gray-50">
                                    &larr; {{ __('auth.previous') }}
                                </button>
                                <button type="button" wire:click="nextStep"
                                    class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200">
                                    {{ __('auth.next') }} &rarr;
                                </button>
                            </div>
                        </div>

                        <!-- STEP 3 -->
                        <div x-show="$wire.currentStep === 3" x-transition:enter.duration.500ms>
                            <h3 class="text-xl font-bold mb-4">{{ __('auth.step_3_title') }}</h3>

                            <div class="space-y-6">
                                <div class="bg-gray-50 p-4 rounded-lg border">
                                    <p class="text-sm font-semibold text-gray-700 mb-2">{{ __('auth.verify_info') }}</p>
                                    <p class="text-sm"><strong>{{ __('auth.name') }}:</strong> {{ $name }}</p>
                                    <p class="text-sm"><strong>{{ __('auth.email') }}:</strong> {{ $email }}</p>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="terms" type="checkbox" wire:model="terms" disabled
                                            class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="terms" class="font-medium text-gray-700">
                                            <span x-show="$wire.terms">{{ __('auth.terms_accepted') }}</span>
                                            <span x-show="!$wire.terms">{{ __('auth.terms_not_accepted') }}</span>
                                        </label>
                                        <button type="button" wire:click="$set('showTermsModal', true)"
                                            class="text-primary-600 hover:text-primary-700 underline ml-2">
                                            {{ __('auth.view_terms') }}
                                        </button>
                                    </div>
                                </div>
                                @error('terms')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-6 flex justify-between">
                                <button type="button" wire:click="previousStep"
                                    class="border border-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-md transition duration-200 hover:bg-gray-50">
                                    &larr; {{ __('auth.previous') }}
                                </button>
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200">
                                    {{ __('auth.register') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Lien connexion -->
                    <p class="text-center text-gray-600 mt-6">
                        {{ __('auth.already_have_account') }}
                        <a href="{{ route('login') }}" wire:navigate
                            class="text-[#16a34a] hover:text-[#15803d] font-semibold transition">
                            {{ __('auth.login') }}
                        </a>
                    </p>

                    <!-- Retour accueil -->
                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" wire:navigate
                            class="text-sm text-gray-500 hover:text-[#16a34a] transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            {{ __('auth.back_home') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Colonne Droite : Carrousel (60%) - Masqué en mobile -->
            <div class="hidden lg:flex lg:w-[60%] relative overflow-hidden">
                <div x-data="{
                    slides: [{
                            image: 'images/photo-1625246333195-78d9c38ad449.jpeg',
                            title: '{{ __('auth.reg_carousel_title_1') }}',
                            subtitle: '{{ __('auth.reg_carousel_subtitle_1') }}',
                            cta: '{{ __('auth.reg_carousel_cta_1') }}'
                        },
                        {
                            image: 'images/photo-1574943320219-553eb213f72d.avif',
                            title: '{{ __('auth.reg_carousel_title_2') }}',
                            subtitle: '{{ __('auth.reg_carousel_subtitle_2') }}',
                            cta: '{{ __('auth.reg_carousel_cta_2') }}'
                        },
                        {
                            image: 'images/photo-1500382017468-9049fed747ef.jpeg',
                            title: '{{ __('auth.reg_carousel_title_3') }}',
                            subtitle: '{{ __('auth.reg_carousel_subtitle_3') }}',
                            cta: '{{ __('auth.reg_carousel_cta_3') }}'
                        }
                    ],
                    currentSlide: 0
                }" x-init="setInterval(() => { currentSlide = (currentSlide + 1) % slides.length }, 5000)" class="w-full h-full relative">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="currentSlide === index" x-transition:enter="transition ease-out duration-1000"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-1000"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="absolute inset-0 w-full h-full">
                            <!-- Image de fond -->
                            <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover" />

                            <!-- Overlay gradient -->
                            <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-black/50 to-transparent">
                            </div>

                            <!-- Contenu -->
                            <div class="absolute inset-0 flex flex-col justify-center px-16 text-white">
                                <div class="max-w-2xl space-y-6">
                                    <!-- Badge -->
                                    <div
                                        class="inline-block bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-semibold">
                                        ✨ {{ __('auth.reg_badge') }}
                                    </div>

                                    <!-- Titre principal -->
                                    <h2 class="text-5xl font-bold leading-tight" x-text="slide.title"></h2>

                                    <!-- Sous-titre -->
                                    <p class="text-xl text-gray-200 leading-relaxed" x-text="slide.subtitle"></p>

                                    <!-- CTA Badge -->
                                    <div class="flex items-center gap-3 pt-4">
                                        <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-green-300 font-semibold text-lg" x-text="slide.cta"></span>
                                    </div>

                                    <!-- Bénéfices -->
                                    <div class="space-y-3 pt-4">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5 text-green-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-gray-200">{{ __('auth.benefit_1') }}</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5 text-green-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-gray-200">{{ __('auth.benefit_2') }}</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5 text-green-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-gray-200">{{ __('auth.benefit_3') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Indicateurs de slides -->
                            <div class="absolute bottom-8 left-16 flex gap-2">
                                <template x-for="(slide, i) in slides" :key="i">
                                    <button @click="currentSlide = i"
                                        :class="currentSlide === i ? 'w-12 bg-white' : 'w-3 bg-white/50'"
                                        class="h-3 rounded-full transition-all duration-300 hover:bg-white"></button>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale des Conditions d'Utilisation -->
    <div x-show="$wire.showTermsModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div x-show="$wire.showTermsModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 aria-hidden="true"></div>

            <!-- Espacer pour centrer la modale -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modale -->
            <div x-show="$wire.showTermsModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full sm:p-6">
                
                <!-- En-tête -->
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            {{ __('auth.terms_modal_title') }}
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                {{ __('auth.terms_modal_subtitle') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contenu des conditions -->
                <div class="mt-6 max-h-96 overflow-y-auto">
                    <div class="bg-gray-50 p-6 rounded-lg space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">{{ __('auth.terms_section_1_title') }}</h4>
                            <p class="text-sm text-gray-600">{{ __('auth.terms_section_1_content') }}</p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">{{ __('auth.terms_section_2_title') }}</h4>
                            <p class="text-sm text-gray-600">{{ __('auth.terms_section_2_content') }}</p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">{{ __('auth.terms_section_3_title') }}</h4>
                            <p class="text-sm text-gray-600">{{ __('auth.terms_section_3_content') }}</p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">{{ __('auth.terms_section_4_title') }}</h4>
                            <p class="text-sm text-gray-600">{{ __('auth.terms_section_4_content') }}</p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">{{ __('auth.terms_section_5_title') }}</h4>
                            <p class="text-sm text-gray-600">{{ __('auth.terms_section_5_content') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 sm:mt-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            wire:click="acceptTerms"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition duration-200">
                        {{ __('auth.accept_terms') }}
                    </button>
                    <button type="button" 
                            wire:click="declineTerms"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-200">
                        {{ __('auth.decline_terms') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>