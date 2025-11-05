<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $role_id = '';
    public bool $terms = false;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
            'terms' => ['accepted'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

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
                        <svg class="w-10 h-10 text-[#16a34a]" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18c-4 0-7-3-7-7V8.3l7-3.5 7 3.5V13c0 4-3 7-7 7z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        <span class="text-2xl font-bold text-[#16a34a]">Agrospace</span>
                    </div>

                    <!-- Titre -->
                    <div class="mb-8">
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">
                            Créez votre compte 🌾
                        </h1>
                        <p class="text-gray-600">
                            Rejoignez la communauté Agrospace et commencez à développer votre réseau agricole dès
                            aujourd'hui.
                        </p>
                    </div>

                    <!-- Formulaire -->
                    <form wire:submit="register" class="space-y-5">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nom complet
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" id="name" wire:model="name" placeholder="Jean Dupont"
                                    class="w-full pl-12 pr-4 py-3.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:border-transparent transition"
                                    required />
                            </div>
                            @error('name')
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
                                <input type="email" id="email" wire:model="email" placeholder="votre@email.com"
                                    class="w-full pl-12 pr-4 py-3.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:border-transparent transition"
                                    required />
                            </div>
                            @error('email')
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

                        <!-- Role -->
                        <div>
                            <label for="role_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Vous êtes un...
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <select wire:model="role_id" id="role_id"
                                    class="w-full pl-12 pr-4 py-3.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#16a34a] focus:border-transparent transition appearance-none cursor-pointer"
                                    required>
                                    <option value="">Sélectionnez votre profil</option>
                                    @foreach (App\Models\Role::where('name','!=','admin')->get() as $role)
                                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('role_id')
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
                        <div x-data.ignore="{ showPassword: false }">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Mot de passe
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

                        <!-- Password Confirmation -->
                        <div x-data.ignore="{ showPassword: false }">
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirmer le mot de passe
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <input :type="showPassword ? 'text' : 'password'" id="password_confirmation"
                                    wire:model="password_confirmation" placeholder="••••••••"
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

                        <!-- Terms & Conditions -->
                        <div>
                            <label class="flex items-start cursor-pointer group">
                                <input type="checkbox" wire:model="terms"
                                    class="w-5 h-5 text-[#16a34a] border-gray-300 rounded focus:ring-[#16a34a] focus:ring-2 transition-all cursor-pointer mt-0.5" />
                                <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">
                                    J'accepte les
                                    <a href="/terms" class="text-[#16a34a] font-semibold hover:underline">conditions
                                        d'utilisation</a>
                                    et la
                                    <a href="/privacy" class="text-[#16a34a] font-semibold hover:underline">politique
                                        de
                                        confidentialité</a>
                                </span>
                            </label>
                            @error('terms')
                                <p class="text-red-500 text-sm mt-2 ml-8 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full bg-[#16a34a] hover:bg-[#15803d] text-white py-4 rounded-xl font-semibold transition-all transform hover:scale-[1.02] shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <span wire:loading.remove>Créer mon compte</span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Création en cours...
                            </span>
                        </button>
                    </form>

                    <!-- Lien connexion -->
                    <p class="text-center text-gray-600 mt-6">
                        Vous avez déjà un compte ?
                        <a href="{{ route('login') }}" wire:navigate
                            class="text-[#16a34a] hover:text-[#15803d] font-semibold transition">
                            Se connecter
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
                            title: 'Rejoignez 500+ producteurs africains',
                            subtitle: 'Inscrivez-vous gratuitement et commencez à valoriser vos produits agricoles auprès d\'une communauté engagée.',
                            cta: 'Votre réseau agricole commence ici'
                        },
                        {
                            image: 'images/photo-1574943320219-553eb213f72d.avif',
                            title: 'Publiez vos offres en 2 minutes',
                            subtitle: 'Une interface simple et intuitive pour gérer vos produits, recevoir des demandes et échanger avec vos clients.',
                            cta: 'Simplifiez votre gestion agricole'
                        },
                        {
                            image: 'images/photo-1500382017468-9049fed747ef.jpeg',
                            title: 'Gagnez en visibilité locale',
                            subtitle: 'Connectez-vous avec des consommateurs, restaurants et distributeurs près de chez vous grâce à notre carte interactive.',
                            cta: 'Développez votre clientèle dès aujourd\'hui'
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
                                        ✨ Inscription gratuite et sans engagement
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
                                            <span class="text-gray-200">Messagerie instantanée intégrée</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5 text-green-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-gray-200">Tableau de bord personnalisé</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5 text-green-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-gray-200">Support dédié 7j/7</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Indicateurs de slides -->
                            <div class="absolute bottom-8 left-16 flex gap-2">
                                <template x-for="(slide, i) in slides" :key="i">
                                    <button @click="currentSlide =i"
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
