<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\ActivityLog;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    public function login()
    {
        $this->validate();

        // 1. Authentification classique
        $this->form->authenticate();
        $user = Auth::user();

        // 2. Vérification du statut
        if ($user->isBanned()) {
            Auth::logout();
            Session::flush();
            ActivityLog::log('login_banned', "Tentative de connexion bloquée (compte banni) : {$user->email}");
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => __('auth.login_banned_message'),
            ]);
            return;
        }

        if ($user->isSuspended()) {
            Auth::logout();
            Session::flush();
            ActivityLog::log('login_suspended', "Tentative de connexion bloquée (compte suspendu) : {$user->email}");
            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => __('auth.login_suspended_message'),
            ]);
            return;
        }

        // 3. Si tout est OK on continue
        Session::regenerate();
        ActivityLog::log('login', __('auth.login_success'));

        // 4. 2FA éventuel
        if ($user->hasTwoFactorEnabled()) {
            session(['two_factor_user_id' => $user->id]);
            Auth::logout(); // déconnexion temporaire pour le challenge 2FA
            return to_route('2fa.challenge');
        }

        session(['two_factor_authenticated' => true]);

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => __('auth.welcome_message', ['name' => $user->name]),
        ]);

        return redirect()->intended($this->redirectPath());
    }

    protected function redirectPath()
    {
        $user = Auth::user();

        return match ($user->role->name) {
            'admin' => route('dashboard'),
            'producer' => route('dashboard'),
            'consumer' => route('dashboard'),
            default => route('dashboard'),
        };
    }
}; ?>

<div>

    <div
        class="min-h-screen bg-gradient-to-br from-[#F9F6F1] to-[#E8F5E9] flex items-center justify-center overflow-hidden">
        <div class="container mx-auto h-screen flex">

            <!-- Colonne Gauche : Formulaire (40%) -->
            <div class="w-full lg:w-[40%] flex items-center justify-center p-4 lg:p-8">
                <div class="w-full max-w-md">
                    <!-- Logo -->
                    <div class="flex items-center gap-2 mb-8">
                        <img src="{{ asset('images/logo.png') }}" class="h-10 w-10" alt="{{ __('auth.logo_alt') }}">
                        <span class="text-2xl font-bold text-[#16a34a]">{{ __('app.name') }}</span>
                    </div>

                    <!-- Titre -->
                    <div class="mb-8">
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">
                            {{ __('auth.welcome_back') }} 👋
                        </h1>
                        <p class="text-gray-600">
                            {{ __('auth.login_subtitle') }}
                        </p>
                    </div>

                    <!-- Formulaire -->
                    <form wire:submit="login" class="space-y-5">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __('auth.email_address') }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input type="email" id="email" wire:model="form.email"
                                    placeholder="{{ __('auth.email_placeholder') }}"
                                    class="w-full pl-12 pr-4 py-3.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:border-transparent transition"
                                    required />
                            </div>
                            @error('form.email')
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

                        <!-- Password -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="password" class="block text-sm font-semibold text-gray-700">
                                    {{ __('auth.password') }}
                                </label>
                                <a href="{{ route('password.request') }}" wire:navigate
                                    class="text-sm text-[#16a34a] hover:text-[#15803d] font-medium transition">
                                    {{ __('auth.forgot_password') }}
                                </a>
                            </div>
                            <div x-data="{ showPassword: false }" class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input :type="showPassword ? 'text' : 'password'" id="password"
                                    wire:model="form.password" placeholder="••••••••"
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
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            @error('form.password')
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

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input type="checkbox" wire:model="form.remember" id="remember"
                                class="w-4 h-4 text-[#16a34a] border-gray-300 rounded focus:ring-[#16a34a]" />
                            <label for="remember" class="ml-2 text-sm text-gray-700">
                                {{ __('auth.remember_me') }}
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full bg-[#16a34a] hover:bg-[#15803d] text-white py-4 rounded-xl font-semibold transition-all transform hover:scale-[1.02] shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <span wire:loading.remove>{{ __('auth.login') }}</span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                {{ __('auth.logging_in') }}
                            </span>
                        </button>
                    </form>

                    <!-- Lien inscription -->
                    <p class="text-center text-gray-600 mt-8">
                        {{ __('auth.no_account') }}
                        <a href="{{ route('register') }}" wire:navigate
                            class="text-[#16a34a] hover:text-[#15803d] font-semibold transition">
                            {{ __('auth.create_account') }}
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
                            title: '{{ __('auth.carousel_title_1') }}',
                            subtitle: '{{ __('auth.carousel_subtitle_1') }}',
                            cta: '{{ __('auth.carousel_cta_1') }}'
                        },
                        {
                            image: 'images/photo-1574943320219-553eb213f72d.avif',
                            title: '{{ __('auth.carousel_title_2') }}',
                            subtitle: '{{ __('auth.carousel_subtitle_2') }}',
                            cta: '{{ __('auth.carousel_cta_2') }}'
                        },
                        {
                            image: 'images/photo-1500382017468-9049fed747ef.jpeg',
                            title: '{{ __('auth.carousel_title_3') }}',
                            subtitle: '{{ __('auth.carousel_subtitle_3') }}',
                            cta: '{{ __('auth.carousel_cta_3') }}'
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
                                        🌾 {{ __('auth.carousel_badge') }}
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

                                    <!-- Stats -->
                                    <div class="flex gap-8 pt-6">
                                        <div class="space-y-1">
                                            <p class="text-3xl font-bold">500+</p>
                                            <p class="text-sm text-gray-300">{{ __('auth.active_producers') }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-3xl font-bold">1,200+</p>
                                            <p class="text-sm text-gray-300">{{ __('auth.connections_created') }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-3xl font-bold">30+</p>
                                            <p class="text-sm text-gray-300">{{ __('auth.covered_regions') }}</p>
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

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

</div>
