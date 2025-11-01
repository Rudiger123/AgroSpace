<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

  /**
 * Handle an incoming authentication request.
 */
public function login(): void
{
    $this->validate();

    $this->form->authenticate(); // Authentifie l'utilisateur
    $user = Auth::user();

    Session::regenerate(); // Sécurise la session

    // Vérifie si 2FA est activé
    if ($user->two_factor_enabled) {
        // Déconnecte temporairement l'utilisateur
        Auth::logout();

        // Stocke l'ID utilisateur dans la session pour le challenge 2FA
        session(['2fa:user:id' => $user->id]);

        // Redirige vers la page de challenge 2FA
        $this->redirectRoute('2fa.challenge');
        return; // On stoppe ici pour ne pas continuer vers le dashboard
    }

    // Sinon, accès normal au dashboard
    $this->redirectIntended(default: route('dashboard', absolute: false));
}

}; ?>

<div>
    <div class="min-h-screen bg-[#F9F6F1] flex items-center justify-center">
        <div class="container mx-auto px-4 flex flex-col md:flex-row gap-0 md:gap-10">
    
            <!-- Colonne Gauche : Formulaire -->
            <div class="w-full md:w-2/5 bg-white rounded-3xl shadow-xl p-10 flex flex-col justify-center">
                <h1 class="text-3xl font-bold text-[#16a34a] mb-2">Bienvenue sur Agrospace</h1>
                <p class="text-gray-600 mb-6">Connectez-vous ou créez un compte en 1 minute</p>
    
                <form wire:submit="login" class="space-y-5">
                    <!-- Email -->
                    <div class="relative">
                        <input type="email" wire:model="form.email" placeholder="Votre email"
                            class="w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#16a34a] transition" />
                        @error('form.email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
    
                    <!-- Password -->
                    <div x-data="{ showPassword: false }" class="relative">
                        <input :type="showPassword ? 'text' : 'password'" wire:model="form.password"
                            placeholder="Mot de passe"
                            class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#16a34a] transition" />
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#16a34a] transition">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l3.59 3.59">
                                </path>
                            </svg>
                        </button>
                        @error('form.password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
    
                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-[#16a34a] hover:bg-[#15803d] text-white py-3 rounded-lg font-semibold transition transform hover:scale-[1.02]">
                        Continuer
                    </button>
                </form>
    
                <!-- Séparateur -->
                <div class="flex items-center my-5">
                    <hr class="flex-1 border-gray-300" />
                    <span class="px-2 text-gray-400 text-sm">ou continuer avec</span>
                    <hr class="flex-1 border-gray-300" />
                </div>
    
                <!-- Boutons sociaux -->
                <div class="flex flex-col gap-3">
                    <button type="button"
                        class="flex items-center justify-center gap-2 w-full border border-gray-300 rounded-lg py-2 hover:shadow-lg transition">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg"
                            class="w-5 h-5" alt="Google" /> Google
                    </button>
                    <button type="button"
                        class="flex items-center justify-center gap-2 w-full border border-gray-300 rounded-lg py-2 hover:shadow-lg transition">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_%282019%29.png"
                            class="w-5 h-5" alt="Facebook" /> Facebook
                    </button>
                </div>
            </div>
    
            <!-- Colonne Droite : Carrousel -->
            <div class="w-full md:w-3/5 relative hidden md:block rounded-3xl overflow-hidden shadow-xl h-[500px]">
                <div x-data="{ images: [
                        { src: 'https://source.unsplash.com/900x700/?farm', text: 'Agriculture durable et innovante en Afrique' },
                        { src: 'https://source.unsplash.com/900x700/?crops', text: 'Technologie et productivité pour les producteurs locaux' },
                        { src: 'https://source.unsplash.com/900x700/?agriculture', text: 'Valorisation des cultures et des communautés' }
                    ], index: 0 }"
                    x-init="setInterval(() => { index = (index + 1) % images.length }, 5000)"
                    class="w-full h-full relative">
                    <template x-for="(img, i) in images" :key="i">
                        <div :class="{'opacity-100': index === i, 'opacity-0': index !== i}"
                            class="absolute inset-0 w-full h-full transition-opacity duration-1000">
                            <img :src="img.src" class="w-full h-full object-cover" />
                            <div
                                class="absolute inset-0 flex items-center justify-center text-center bg-black bg-opacity-30 p-4">
                                <p class="text-white text-xl font-semibold" x-text="img.text"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    </div>
    
</div>
