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
                        <img src="/images/logo.png" alt="Agrospace" class="w-10 h-10 text-[#16a34a]">
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

                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold"
                                :class="{ 'text-primary-600': $wire.currentStep === 1 }">1. Infos Personnelles</span>
                            <span class="text-sm font-semibold"
                                :class="{ 'text-primary-600': $wire.currentStep === 2 }">2. Mot de passe</span>
                            <span class="text-sm font-semibold"
                                :class="{ 'text-primary-600': $wire.currentStep === 3 }">3. Confirmation</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-primary-600 h-2.5 rounded-full transition-all duration-500"
                                :style="`width: ${($wire.currentStep / $wire.totalSteps) * 100}%`">
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire -->
                    <form wire:submit="register">

                        <div x-show="$wire.currentStep === 1" x-transition:enter.duration.500ms>
                            <h3 class="text-xl font-bold mb-4">Étape 1/3 : Qui êtes-vous ?</h3>

                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nom
                                        complet</label>
                                    <input id="name" type="text" wire:model="name" autofocus
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse
                                        email</label>
                                    <input id="email" type="email" wire:model="email"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="role_id" class="block text-sm font-medium text-gray-700">Je suis
                                        un/une</label>
                                    <select id="role_id" wire:model="role_id"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">Sélectionnez votre rôle</option>
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
                                    Suivant &rarr;
                                </button>
                            </div>
                        </div>

                        <div x-show="$wire.currentStep === 2" x-transition:enter.duration.500ms>
                            <h3 class="text-xl font-bold mb-4">Étape 2/3 : Sécurisez votre compte</h3>

                            <div class="space-y-4">
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
                            </div>

                            <div class="mt-6 flex justify-between">
                                <button type="button" wire:click="previousStep"
                                    class="border border-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-md transition duration-200 hover:bg-gray-50">
                                    &larr; Précédent
                                </button>
                                <button type="button" wire:click="nextStep"
                                    class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200">
                                    Suivant &rarr;
                                </button>
                            </div>
                        </div>

                        <div x-show="$wire.currentStep === 3" x-transition:enter.duration.500ms>
                            <h3 class="text-xl font-bold mb-4">Étape 3/3 : Finalisation</h3>

                            <div class="space-y-6">
                                <div class="bg-gray-50 p-4 rounded-lg border">
                                    <p class="text-sm font-semibold text-gray-700 mb-2">Vérifiez vos informations :</p>
                                    <p class="text-sm"><strong>Nom:</strong> {{ $name }}</p>
                                    <p class="text-sm"><strong>Email:</strong> {{ $email }}</p>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="terms" type="checkbox" wire:model="terms"
                                            class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="terms" class="font-medium text-gray-700">J'accepte les <a
                                                href="#" class="text-primary-600 hover:underline">Conditions
                                                Générales d'Utilisation</a>.</label>
                                    </div>
                                </div>
                                @error('terms')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-6 flex justify-between">
                                <button type="button" wire:click="previousStep"
                                    class="border border-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-md transition duration-200 hover:bg-gray-50">
                                    &larr; Précédent
                                </button>
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200">
                                    S'inscrire
                                </button>
                            </div>
                        </div>
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
