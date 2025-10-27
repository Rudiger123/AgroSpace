<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Actions\Logout;

new class extends Component {
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    /**
     *  Déconnexion de l'utilisateur
     */
    public function logout(Logout $logout): void
    {
        $logout();
        // Message flash pour la page de connexion
        session()->flash('message', 'Vous avez été déconnecté avec succès.');
        $this->redirect('/');
    }
}; ?>
<aside x-data.ignore="{
    sidebarOpen: true,
    activeMenu: 'dashboard',
    submenuOpen: {}
}"
    :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="bg-white border-r border-[#E0E0E0] transition-all duration-300 ease-in-out 
       flex flex-col h-screen sticky top-0 shadow-soft">
    <!-- Header avec logo -->
    <div class="h-16 flex items-center justify-between px-4 border-b border-[#E0E0E0]">
        <a href="{{ route('home') }}" class="flex items-center space-x-3">
            <div
                class="w-10 h-10 bg-gradient-to-br from-[#2E7D32] to-[#1B5E20] rounded-lg flex items-center justify-center shadow-medium">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
            <span x-show="sidebarOpen" x-transition class="text-xl font-bold text-[#2E7D32] font-poppins">
                Agrospace
            </span>
        </a>

        <!-- Toggle button avec rotation -->
        <button @click="sidebarOpen = !sidebarOpen"
            class="p-2 rounded-lg hover:bg-[#F9F6EE] transition-all duration-200 group">
            <svg :class="sidebarOpen ? 'rotate-0' : 'rotate-180'"
                class="w-5 h-5 text-[#37474F] transition-transform duration-300 group-hover:text-[#2E7D32]"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7">
                </path>
            </svg>
        </button>
    </div>

    <!-- Navigation avec effets avancés -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto custom-scrollbar">
        <!-- Dashboard -->
        <a href="/dashboard" @click="activeMenu = 'dashboard'"
            :class="activeMenu === 'dashboard' ? 'bg-[#2E7D32] text-white shadow-medium' :
                'text-[#37474F] hover:bg-[#F9F6EE]'"
            class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 
               group relative overflow-hidden">
            <!-- Indicateur actif -->
            <div x-show="activeMenu === 'dashboard'" class="absolute left-0 top-0 h-full w-1 bg-white rounded-r">
            </div>

            <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>

            <span x-show="sidebarOpen" x-transition class="font-medium">
                Dashboard
            </span>

            <!-- Badge de notification -->
            <span x-show="sidebarOpen && activeMenu !== 'dashboard'"
                class="ml-auto px-2 py-0.5 bg-[#2E7D32] text-white text-xs rounded-full">
                3
            </span>
        </a>

        <!-- Menu avec sous-menu -->
        <div x-data.ignore="{ open: false }">
            <button @click="open = !open"
                class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 
                   text-[#37474F] hover:bg-[#F9F6EE] group">
                <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-200 group-hover:scale-110"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>

                <span x-show="sidebarOpen" x-transition class="font-medium flex-1 text-left">
                    Offres
                </span>

                <svg x-show="sidebarOpen" :class="open ? 'rotate-180' : 'rotate-0'"
                    class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                    </path>
                </svg>
            </button>

            <!-- Sous-menu avec animation -->
            <div x-show="open && sidebarOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0" class="ml-11 mt-1 space-y-1">
                <a href="/offers/all"
                    class="block px-4 py-2 text-sm text-[#37474F] hover:text-[#2E7D32] transition-colors rounded-lg hover:bg-[#F9F6EE]">
                    Toutes les offres
                </a>
                <a href="/offers/active"
                    class="block px-4 py-2 text-sm text-[#37474F] hover:text-[#2E7D32] transition-colors rounded-lg hover:bg-[#F9F6EE]">
                    Offres actives
                </a>
                <a href="/offers/archived"
                    class="block px-4 py-2 text-sm text-[#37474F] hover:text-[#2E7D32] transition-colors rounded-lg hover:bg-[#F9F6EE]">
                    Archives
                </a>
            </div>
        </div>
    </nav>

    <!-- Footer avec profil utilisateur -->
    <div class="p-4 border-t border-[#E0E0E0]">
        <div x-data.ignore="{ menuOpen: false }" class="relative">
            <button @click="menuOpen = !menuOpen"
                class="w-full flex items-center space-x-3 px-3 py-2 rounded-xl hover:bg-[#F9F6EE] transition-all duration-200 group">
                <img src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                    class="w-10 h-10 rounded-full ring-2 ring-[#2E7D32]/20 group-hover:ring-[#2E7D32]/40 transition-all">
                <div x-show="sidebarOpen" x-transition class="flex-1 text-left">
                    <p class="text-sm font-medium text-[#37474F]"> {{ $user->name }} </p>
                    <p class="text-xs text-[#37474F]/60"> {{ $user->email }} </p>
                </div>
            </button>

            <!-- Menu contextuel -->
            <div x-show="menuOpen" @click.away="menuOpen = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-xl shadow-strong border border-[#E0E0E0] overflow-hidden">
                <a href="/profile" class="block px-4 py-3 text-sm text-[#37474F] hover:bg-[#F9F6EE] transition-colors">
                    Mon Profil
                </a>
                <a href="/settings" class="block px-4 py-3 text-sm text-[#37474F] hover:bg-[#F9F6EE] transition-colors">
                    Paramètres
                </a>

                <div>
                    <button wire:click="logout" wire:confirm="Êtes-vous sûr de vouloir vous déconnecter ?"
                        class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                        <span class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            <span class="font-medium">Se déconnecter</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</aside>
