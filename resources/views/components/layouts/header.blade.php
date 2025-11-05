<!-- Header Navigation -->
<header class="fixed top-0 left-0 right-0 z-50 glass-effect shadow-sm" x-data="{ mobileMenuOpen: false, userMenuOpen: false, notifOpen: false }" x-cloak>
    <nav class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="#" class="flex items-center space-x-2 group">
                <img src="{{ asset('images/logo.png') }}" alt="Agrospace" class="w-12 h-12">
                <span class="text-2xl font-bold text-primary">AgroSpace</span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" wire:navigate
                    class="text-gray-700 hover:text-primary transition-colors font-medium">Accueil</a>
                <a href="{{ route('features') }}" wire:navigate
                    class="text-gray-700 hover:text-primary transition-colors font-medium">Fonctionnalités</a>
                <a href="{{ route('producer.page') }}" wire:navigate
                    class="text-gray-700 hover:text-primary transition-colors font-medium">Producteurs</a>
                <a href="{{ route('consumer.page') }}" wire:navigate
                    class="text-gray-700 hover:text-primary transition-colors font-medium">Consommateurs</a>
                <a href="{{ route('about.page') }}" wire:navigate
                    class="text-gray-700 hover:text-primary transition-colors font-medium">À propos</a>
                <a href="{{ route('blog.page') }}" wire:navigate
                    class="text-gray-700 hover:text-primary transition-colors font-medium">Blog</a>

                <!-- Authentication Section -->
                @auth
                    <!-- Notifications Bell -->
                    <div class="relative">
                        <button @click="notifOpen = !notifOpen"
                            class="relative p-2 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            <span
                                class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">2</span>
                        </button>

                        <!-- Notifications Dropdown -->
                        <div x-show="notifOpen" @click.away="notifOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden">

                            <div class="bg-gradient-to-r from-green-600 to-emerald-500 px-4 py-3">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-white font-bold">Notifications</h3>
                                    <span class="bg-white text-green-600 text-xs font-bold px-2 py-1 rounded-full">2
                                        nouvelles</span>
                                </div>
                            </div>

                            <div class="max-h-80 overflow-y-auto">
                                <div class="px-4 py-3 hover:bg-gray-50 transition cursor-pointer border-b border-gray-100">
                                    <div class="flex items-start space-x-3">
                                        <div
                                            class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-800">Nouvelle offre disponible</p>
                                            <p class="text-xs text-gray-500">Maïs bio disponible à Douala</p>
                                            <p class="text-xs text-gray-400 mt-1">Il y a 5 min</p>
                                        </div>
                                        <span class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0 mt-1"></span>
                                    </div>
                                </div>

                                <div class="px-4 py-3 hover:bg-gray-50 transition cursor-pointer">
                                    <div class="flex items-start space-x-3">
                                        <div
                                            class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-800">Nouveau message</p>
                                            <p class="text-xs text-gray-500">Un producteur vous a contacté</p>
                                            <p class="text-xs text-gray-400 mt-1">Il y a 1h</p>
                                        </div>
                                        <span class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0 mt-1"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 py-2 bg-gray-50 border-t border-gray-100">
                                <a href="#"
                                    class="text-green-600 hover:text-green-700 font-semibold text-sm block text-center">
                                    Voir toutes les notifications
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="relative">
                        <button @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center space-x-2 p-1.5 hover:bg-gray-100 rounded-lg transition">
                            @if (auth()->user()->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                                    class="w-10 h-10 rounded-full ring-2 ring-[#2E7D32]/20 group-hover:ring-[#2E7D32]/40 transition-all">
                            @else
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-br from-agro-green to-primary flex items-center justify-center text-white font-semibold text-sm border-2 border-agro-green">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="text-left">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">
                                    @if (auth()->user()->role === 'producer')
                                        Producteur
                                    @elseif(auth()->user()->role === 'consumer')
                                        Consommateur
                                    @else
                                        Administrateur
                                    @endif
                                </p>
                            </div>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <!-- User Dropdown Menu -->
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden">

                            <!-- Profile Header -->
                            <div class="bg-gradient-to-r from-green-600 to-emerald-500 px-4 py-4">
                                <div class="flex items-center space-x-3">
                                    @if (auth()->user()->avatar)
                                        <img src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                                            class="w-10 h-10 rounded-full ring-2 ring-[#2E7D32]/20 group-hover:ring-[#2E7D32]/40 transition-all">
                                    @else
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-agro-green to-primary flex items-center justify-center text-white font-semibold text-sm border-2 border-agro-green">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="text-white">
                                        <p class="font-bold">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-green-100">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-2">
                                <a href="{{ route('dashboard') }}"
                                    class="flex items-center space-x-3 px-4 py-2.5 hover:bg-gray-50 transition">
                                    <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Tableau de bord</p>
                                        <p class="text-xs text-gray-500">Vue d'ensemble</p>
                                    </div>
                                </a>

                                <a href="{{ route('profile') }}" wire:navigate
                                    class="flex items-center space-x-3 px-4 py-2.5 hover:bg-gray-50 transition">
                                    <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Mon Profil</p>
                                        <p class="text-xs text-gray-500">Informations personnelles</p>
                                    </div>
                                </a>

                                @if (auth()->user()->role === 'producer')
                                    <a href="{{ route('offers.index') }}" wire:navigate
                                        class="flex items-center space-x-3 px-4 py-2.5 hover:bg-gray-50 transition">
                                        <div class="w-9 h-9 bg-amber-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">Mes Offres</p>
                                            <p class="text-xs text-gray-500">Gérer mes produits</p>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->role === 'consumer')
                                    <a href="{{ route('demands.index') }}" wire:navigate
                                        class="flex items-center space-x-3 px-4 py-2.5 hover:bg-gray-50 transition">
                                        <div class="w-9 h-9 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">Mes Demandes</p>
                                            <p class="text-xs text-gray-500">Gérer mes recherches</p>
                                        </div>
                                    </a>
                                @endif

                                <a href="#" wire:navigate
                                    class="flex items-center space-x-3 px-4 py-2.5 hover:bg-gray-50 transition">
                                    <div class="w-9 h-9 bg-teal-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Messages</p>
                                        <p class="text-xs text-gray-500">Conversations</p>
                                    </div>
                                </a>

                                <a href="#" wire:navigate
                                    class="flex items-center space-x-3 px-4 py-2.5 hover:bg-gray-50 transition">
                                    <div class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 001.066 1.066c.756.426.756 2.924 0 3.35a1.724 1.724 0 00-1.066 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.066-1.066c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-1.066z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Paramètres</p>
                                        <p class="text-xs text-gray-500">Configuration</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Boutons pour utilisateurs non connectés -->
                    <a href="{{ route('login') }}" wire:navigate
                        class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-semibold 
                        text-white bg-gradient-to-r from-green-600 to-emerald-500 
                        hover:from-green-700 hover:to-emerald-600 transition-all duration-300 
                        shadow-md hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-green-300 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.847.632 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Connexion</span>
                    </a>

                    <a href="{{ route('register') }}" wire:navigate
                        class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-semibold 
                        text-green-700 border-2 border-green-600 
                        hover:bg-green-600 hover:text-white transition-all duration-300 
                        shadow-sm hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-300 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Inscription</span>
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-700 focus:outline-none">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden mt-4 pb-4 space-y-3">
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false" wire:navigate
                class="block text-gray-700 hover:text-primary font-medium py-2">Accueil</a>
            <a href="{{ route('features') }}" @click="mobileMenuOpen = false" wire:navigate
                class="block text-gray-700 hover:text-primary font-medium py-2">Fonctionnalités</a>
            <a href="{{ route('producer.page') }}" @click="mobileMenuOpen = false" wire:navigate
                class="block text-gray-700 hover:text-primary font-medium py-2">Producteurs</a>
            <a href="{{ route('consumer.page') }}" @click="mobileMenuOpen = false" wire:navigate
                class="block text-gray-700 hover:text-primary font-medium py-2">Consommateurs</a>
            <a href="{{ route('about.page') }}" @click="mobileMenuOpen = false" wire:navigate
                class="block text-gray-700 hover:text-primary font-medium py-2">À propos</a>
            <a href="{{ route('blog.page') }}" @click="mobileMenuOpen = false" wire:navigate
                class="block text-gray-700 hover:text-primary font-medium py-2">Blog</a>

            @auth
                <div class="border-t border-gray-200 pt-3 mt-3">
                    <div class="flex items-center space-x-3 px-2 py-2 bg-gray-50 rounded-lg mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=22c55e&color=fff"
                            class="w-10 h-10 rounded-full" alt="{{ auth()->user()->name }}">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false" wire:navigate
                        class="block text-gray-700 hover:text-primary font-medium py-2">📊 Tableau de bord</a>
                    <a href="{{ route('profile') }}" @click="mobileMenuOpen = false" wire:navigate
                        class="block text-gray-700 hover:text-primary font-medium py-2">👤 Mon Profil</a>
                    <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false" wire:navigate
                        class="block text-gray-700 hover:text-primary font-medium py-2">💬 Messages</a>
                    <a href="{{ route('profile') }}" @click="mobileMenuOpen = false" wire:navigate
                        class="block text-gray-700 hover:text-primary font-medium py-2">⚙️ Paramètres</a>

                    <form class="mt-3">
                        @csrf
                        <button type="submit" class="w-full text-left text-red-600 hover:text-red-700 font-medium py-2">
                            🚪 Déconnexion
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-200 pt-3 mt-3 space-y-2">
                    <a href="{{ route('login') }}" wire:navigate
                        class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-semibold 
                        text-white bg-gradient-to-r from-green-600 to-emerald-500 
                        hover:from-green-700 hover:to-emerald-600 transition-all duration-300 
                        shadow-md hover:shadow-xl text-sm w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.847.632 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Connexion</span>
                    </a>

                    <a href="{{ route('register') }}" wire:navigate
                        class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-semibold 
                        text-green-700 border-2 border-green-600 
                        hover:bg-green-600 hover:text-white transition-all duration-300 
                        shadow-sm hover:shadow-lg text-sm w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Inscription</span>
                    </a>
                </div>
            @endauth
        </div>
    </nav>
</header>

<style>
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .text-primary {
        color: #22c55e;
    }

    [x-cloak] {
        display: none !important;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }
</style>

<script>
    // Pour Alpine.js - si vous utilisez CDN
    document.addEventListener('alpine:init', () => {
        // Configuration globale si nécessaire
    });
</script>
