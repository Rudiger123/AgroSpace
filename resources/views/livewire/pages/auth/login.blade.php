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
                'message' => 'Votre compte a été définitivement suspendu. Contactez le support.',
            ]);
            return;
        }

        if ($user->isSuspended()) {
            Auth::logout();
            Session::flush();
            ActivityLog::log('login_suspended', "Tentative de connexion bloquée (compte suspendu) : {$user->email}");
            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => 'Votre compte est temporairement suspendu. Vérifiez vos e-mails ou contactez le support.',
            ]);
            return;
        }

        // 3. Si tout est OK on continue
        Session::regenerate();
        ActivityLog::log('login', 'Connexion réussie');

        // 4. 2FA éventuel
        if ($user->hasTwoFactorEnabled()) {
            session(['two_factor_user_id' => $user->id]);
            Auth::logout(); // déconnexion temporaire pour le challenge 2FA
            return to_route('2fa.challenge');
        }

        session(['two_factor_authenticated' => true]);

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => "Bienvenue {$user->name} !",
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
                        <img src="{{ asset('images/logo.png') }}" class="h-10 w-10"
                            alt="Agrospace la plateforme de mise en relation des acteurs du secteur agropastorale">
                        <span class="text-2xl font-bold text-[#16a34a]">Agrospace</span>
                    </div>

                    <!-- Titre -->
                    <div class="mb-8">
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">
                            Bon retour parmi nous ! 👋
                        </h1>
                        <p class="text-gray-600">
                            Connectez-vous pour accéder à votre espace et continuer à développer votre activité
                            agricole.
                        </p>
                    </div>

                    <!-- Formulaire -->
                    <form wire:submit="login" class="space-y-5">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Adresse email
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
                                    placeholder="exemple@email.com"
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
                                    Mot de passe
                                </label>
                                <a href="{{ route('password.request') }}" wire:navigate
                                    class="text-sm text-[#16a34a] hover:text-[#15803d] font-medium transition">
                                    Mot de passe oublié ?
                                </a>
                            </div>
                            <div x-data.ignore="{ showPassword: false }" class="relative">
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
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l3.59 3.59m0 0a9.953 9.953 0 012.82-1.872" />
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
                                Se souvenir de moi
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full bg-[#16a34a] hover:bg-[#15803d] text-white py-4 rounded-xl font-semibold transition-all transform hover:scale-[1.02] shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <span wire:loading.remove>Se connecter</span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Connexion en cours...
                            </span>
                        </button>
                    </form>

                    <!-- Séparateur -->
                    {{-- <div class="flex items-center my-6">
                        <hr class="flex-1 border-gray-300" />
                        <span class="px-3 text-gray-400 text-sm font-medium">OU</span>
                        <hr class="flex-1 border-gray-300" />
                    </div> --}}

                    <!-- Boutons sociaux -->
                    {{-- <div class="grid grid-cols-2 gap-3">
                        <button type="button"
                            class="flex items-center justify-center gap-2 border-2 border-gray-300 rounded-xl py-3 hover:border-[#16a34a] hover:bg-gray-50 transition-all group">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg"
                                class="w-5 h-5" alt="Google" />
                            <span class="font-medium text-gray-700 group-hover:text-[#16a34a]">Google</span>
                        </button>
                        <button type="button"
                            class="flex items-center justify-center gap-2 border-2 border-gray-300 rounded-xl py-3 hover:border-[#16a34a] hover:bg-gray-50 transition-all group">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_%282019%29.png"
                                class="w-5 h-5" alt="Facebook" />
                            <span class="font-medium text-gray-700 group-hover:text-[#16a34a]">Facebook</span>
                        </button>
                    </div> --}}

                    <!-- Lien inscription -->
                    <p class="text-center text-gray-600 mt-8">
                        Vous n'avez pas encore de compte ?
                        <a href="{{ route('register') }}" wire:navigate
                            class="text-[#16a34a] hover:text-[#15803d] font-semibold transition">
                            Créer un compte gratuitement
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
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Colonne Droite : Carrousel (60%) - Masqué en mobile -->
            <div class="hidden lg:flex lg:w-[60%] relative overflow-hidden">
                <div x-data="{
                    slides: [{
                            image: 'images/photo-1625246333195-78d9c38ad449.jpeg',
                            title: 'Connectez-vous avec les producteurs locaux',
                            subtitle: 'Accédez à des centaines d\'offres agricoles vérifiées et établissez des partenariats durables.',
                            cta: 'Valorisez votre production dès aujourd\'hui'
                        },
                        {
                            image: 'images/photo-1574943320219-553eb213f72d.avif',
                            title: 'Développez votre réseau professionnel',
                            subtitle: 'Rejoignez une communauté de plus de 500 producteurs et consommateurs engagés.',
                            cta: 'Faites grandir votre activité agricole'
                        },
                        {
                            image: 'images/photo-1500382017468-9049fed747ef.jpeg',
                            title: 'Gagnez en visibilité et en efficacité',
                            subtitle: 'Des outils simples et puissants pour gérer vos offres, demandes et échanges en temps réel.',
                            cta: 'Simplifiez vos transactions agricoles'
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
                                        🌾 Agrospace - Votre réseau agricole
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
                                            <p class="text-sm text-gray-300">Producteurs actifs</p>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-3xl font-bold">1,200+</p>
                                            <p class="text-sm text-gray-300">Connexions créées</p>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-3xl font-bold">30+</p>
                                            <p class="text-sm text-gray-300">Régions couvertes</p>
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
