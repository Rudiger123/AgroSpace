<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use App\Helpers\SEO;

new #[Layout('layouts.main')] class extends Component {
    #[Rule('required|min:3|max:255')]
    public string $name = '';

    #[Rule('required|email|max:255')]
    public string $email = '';

    #[Rule('required|min:5|max:255')]
    public string $subject = '';

    #[Rule('required|min:10|max:2000')]
    public string $message = '';

    public bool $success = false;
    public bool $isFormOpen = false;
    public bool $showTooltip = false;

    public function mount()
    {
        SEO::setTitle('Contactez AgroSpace - Assistance & Partenariats | Cameroun');
        SEO::setDescription('Une question ? Un projet ? Notre équipe dédiée est à votre écoute. Contactez AgroSpace, la plateforme leader de l\'agrobusiness au Cameroun.');
        SEO::setKeywords('contact agrospace, support client, aide agriculture, partenariat cameroun, douala, yaoundé, service client');
        SEO::setCanonical(url()->current());
        SEO::addImages([asset('images/agrospace.png')]);
    }

    public function toggleForm()
    {
        $this->isFormOpen = !$this->isFormOpen;
        $this->showTooltip = false;
    }

    public function submit()
    {
        $this->validate();
        // Simulation d'envoi (Mail::to(...))
        $this->reset(['name', 'email', 'subject', 'message']);
        $this->success = true;
        $this->isFormOpen = false;
        
        // Réouvrir automatiquement après envoi pour confirmation
        $this->dispatch('form-submitted');
    }
}; ?>

@push('meta')
    <meta name="theme-color" content="#16a34a">
@endpush

<div class="bg-gray-50 font-sans text-gray-900 antialiased selection:bg-green-100 selection:text-green-900">
    {{-- TOGGLE CONTACT FLOATING --}}
    <div class="fixed bottom-24 right-8 z-50 space-y-4" 
         x-data="{
             showSuccess: false,
             init() {
                 Livewire.on('form-submitted', () => {
                     this.showSuccess = true;
                     setTimeout(() => this.showSuccess = false, 4000);
                 });
             }
         }" x-cloak>
        
        {{-- NOTIFICATION DE SUCCÈS --}}
        <div x-show="showSuccess" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-10 scale-90"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-10 scale-90"
             class="bg-green-500 text-white p-4 rounded-2xl shadow-2xl max-w-xs border border-green-300">
            <div class="flex items-center gap-3">
                <div class="bg-green-400 p-2 rounded-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-sm">Message envoyé !</p>
                    <p class="text-green-100 text-xs">Nous vous recontactons rapidement</p>
                </div>
            </div>
        </div>

        {{-- FORMULAIRE FLOTTANT --}}
        <div x-show="$wire.isFormOpen" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-10 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-10 scale-95"
             class="bg-white rounded-3xl shadow-2xl p-6 border border-gray-200 w-80 md:w-96 max-h-[85vh] overflow-y-auto">
            
            {{-- EN-TÊTE DU FORMULAIRE --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Contact Rapide</h3>
                    <p class="text-sm text-gray-600">Remplissez ce formulaire rapide</p>
                </div>
                <button @click="$wire.toggleForm()" 
                        class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-full hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- FORMULAIRE --}}
            <form wire:submit="submit" class="space-y-4">
                {{-- Nom --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Nom complet *</label>
                    <input type="text" wire:model="name" 
                           class="w-full px-3 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-2 transition-all duration-200 outline-none text-sm placeholder-gray-400">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Email *</label>
                    <input type="email" wire:model="email" 
                           class="w-full px-3 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-2 transition-all duration-200 outline-none text-sm placeholder-gray-400">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Sujet --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Sujet *</label>
                    <select wire:model="subject" 
                            class="w-full px-3 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-2 transition-all duration-200 outline-none text-sm appearance-none">
                        <option value="">Choisir un sujet...</option>
                        <option value="Support technique">🛠️ Support Technique</option>
                        <option value="Question générale">ℹ️ Question Générale</option>
                        <option value="Partenariat">🤝 Partenariat</option>
                        <option value="Presse">📢 Presse</option>
                        <option value="Autre">✨ Autre</option>
                    </select>
                    @error('subject') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Message --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Message *</label>
                    <textarea wire:model="message" rows="3" 
                              class="w-full px-3 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-2 transition-all duration-200 outline-none text-sm placeholder-gray-400 resize-none"></textarea>
                    @error('message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Bouton d'envoi --}}
                <button type="submit" wire:loading.attr="disabled"
                        class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <span wire:loading.remove>Envoyer le message</span>
                    <span wire:loading>Envoi en cours...</span>
                    <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>
        </div>

        {{-- BOUTON TOGGLE PRINCIPAL --}}
        <div class="relative">
            {{-- TOOLTIP --}}
            <div x-show="$wire.showTooltip" x-transition 
                 class="absolute bottom-full right-0 mb-3 bg-gray-900 text-white text-sm px-3 py-2 rounded-xl whitespace-nowrap shadow-xl">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    Contact rapide
                </div>
                <div class="absolute top-full right-4 -mt-1 border-4 border-transparent border-t-gray-900"></div>
            </div>

            {{-- BOUTON PRINCIPAL --}}
            <button @click="$wire.toggleForm()" 
                    @mouseenter="$wire.showTooltip = true" 
                    @mouseleave="$wire.showTooltip = false"
                    :class="$wire.isFormOpen ? 'bg-red-500 hover:bg-red-600 rotate-45' : 'bg-green-600 hover:bg-green-700'"
                    class="w-14 h-14 rounded-2xl shadow-2xl text-white transition-all duration-300 transform hover:scale-110 hover:-translate-y-1 flex items-center justify-center group relative overflow-hidden">
                
                {{-- Effet de brillance --}}
                <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer"></span>
                
                {{-- Icône --}}
                <svg class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!$wire.isFormOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    <path x-show="$wire.isFormOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- BOUTON SCROLL TOP (inchangé)
    <div x-data="{ show: false }" @scroll.window="show = window.scrollY > 500" class="fixed bottom-8 right-8 z-50">
        <button x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-10" @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                class="bg-green-600 text-white w-12 h-12 rounded-full shadow-lg hover:bg-green-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center focus:outline-none focus:ring-4 focus:ring-green-500/30">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
        </button>
    </div> --}}

    {{-- STYLES D'ANIMATION --}}
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        .animate-shimmer {
            animation: shimmer 2s infinite;
        }
    </style>
</div>