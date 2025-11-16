{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - Agrospace Admin</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Page Specific Styles -->
    @stack('styles')

    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slideIn {
            animation: slideIn 0.4s ease-out;
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        // Store global Alpine.js
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                open: Alpine.$persist(true),

                init() {
                    // Fermer sur mobile au chargement
                    if (window.innerWidth < 1024) {
                        this.open = false;
                    }

                    // Écouter les changements de taille d'écran
                    window.addEventListener('resize', () => {
                        if (window.innerWidth < 1024) {
                            this.open = false;
                        }
                    });
                },

                toggle() {
                    console.log('toggle');
                    this.open = !this.open;
                },

                close() {
                    console.log('close')
                    this.open = false;
                }
            });
        });
    </script>
</head>

<body class="bg-gradient-to-br from-green-50 via-white to-amber-50 font-sans antialiased">

    {{-- Sidebar avec son propre x-data --}}
    <aside x-data="{}"
        x-bind:class="$store.sidebar.open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed left-0 top-0 h-screen w-72 bg-gradient-to-b from-green-800 to-green-900 text-white shadow-2xl z-50 transition-transform duration-300">

        {{-- Logo --}}
        <div class="p-6 border-b border-green-700">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" wire:navigate class="flex items-center space-x-3">
                    <div class="bg-white rounded-xl p-2 animate-pulse-slow">
                        <img class="w-8 h-8 text-green-600" src="{{ asset('images/logo.png') }}" alt="">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Agrospace</h1>
                        <p class="text-xs text-green-200">Admin Dashboard</p>
                    </div>
                </a>
                {{-- Bouton fermer sidebar --}}
                <button @click="$store.sidebar.close()"
                    class="lg:hidden text-white hover:bg-green-700 p-2 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>


        {{-- Navigation --}}
        <nav class="p-4 space-y-2 overflow-y-auto h-[calc(100vh-180px)]">
            <a href="{{ route('dashboard') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('dashboard') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('users-management') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('users-management') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                <span class="font-medium">Utilisateurs</span>
                <span
                    class="ml-auto bg-amber-400 text-amber-900 text-xs px-2 py-1 rounded-full font-semibold">247</span>
            </a>

            <a href="{{ route('offers-management') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('offers-management') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="font-medium">Mes Offres</span>
                <span
                    class="ml-auto bg-amber-400 text-amber-900 text-xs px-2 py-1 rounded-full font-semibold">156</span>
            </a>

            <a href="{{ route('offers-list') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('offers-list') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="font-medium">Offres Publiques</span>
                <span
                    class="ml-auto bg-amber-400 text-amber-900 text-xs px-2 py-1 rounded-full font-semibold">156</span>
            </a>

            <a href="{{ route('demands-management') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('demands-management') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                <span class="font-medium">Mes Demandes</span>
                <span class="ml-auto bg-amber-400 text-amber-900 text-xs px-2 py-1 rounded-full font-semibold">89</span>
            </a>

            <a href="{{ route('demands-list') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('demands-list') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                <span class="font-medium">Liste des Demandes</span>
                <span class="ml-auto bg-amber-400 text-amber-900 text-xs px-2 py-1 rounded-full font-semibold">89</span>
            </a>

            <a href="{{ route('demands.index') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('demands.index') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                <span class="font-medium">Gestion Demandes</span>
            </a>

            <a href="{{ route('offers.moderate') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('offers.moderate') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                <span class="font-medium">Gestion des Offres</span>
            </a>

            <a href="/chats" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('chats') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                    </path>
                </svg>
                <span class="font-medium">Messages</span>
                <span
                    class="ml-auto bg-amber-400 text-amber-900 text-xs px-2 py-1 rounded-full font-semibold">12</span>
            </a>

            <a href="{{ route('admin.blog.index') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('admin.blog.*') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                    </path>
                </svg>
                <span class="font-medium">Blog</span>
            </a>

            <a href="{{ route('categories.index') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('categories.*') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                    </path>
                </svg>
                <span class="font-medium">Catégories</span>
            </a>

            <a href="{{ route('tags.index') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('tags.*') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                    </path>
                </svg>
                <span class="font-medium">Tags</span>
            </a>


            <a href="#" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('admin.map') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                    </path> {{-- Alpine.js Persist Plugin --}}


                </svg>
                <span class="font-medium">Carte</span>
            </a>

            <a href="#" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('admin.statistics') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                <span class="font-medium">Statistiques</span>
            </a>

            <a href="#" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('admin.settings') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 001.066 1.066c.756.426.756 2.924 0 3.35a1.724 1.724 0 00-1.066 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.066-1.066c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-1.066z">
                    </path>
                </svg>
                <span class="font-medium">Paramètres</span>
            </a>
        </nav>

        {{-- User Profile --}}
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-green-700 bg-green-900/50">
            <div class="flex items-center space-x-3">

                @if (auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar"
                        class="w-10 h-10 rounded-full ring-2  ring-white group-hover:ring-[#2E7D32]/40 transition-all">
                @else
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-br from-agro-green to-primary flex items-center justify-center text-white font-semibold text-sm border-2 border-white">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-green-200 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main Content Area - SANS x-data parent --}}
    <div class="lg:ml-72 transition-all duration-300">

        {{-- Mobile Overlay --}}
        <div x-data="{}" x-show="$store.sidebar.open" @click="$store.sidebar.close()"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden" x-cloak>
        </div>

        {{-- Header avec son propre x-data --}}
        <header class="bg-white shadow-sm sticky top-0 z-30 glass-effect">
            <div class="px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    {{-- Bouton mobile --}}
                    <button @click="$store.sidebar.toggle()" class="lg:hidden text-gray-600 hover:text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    {{-- Bouton desktop --}}
                    <button @click="$store.sidebar.toggle()"
                        class="hidden lg:block text-gray-600 hover:text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $header ?? 'Dashboard' }}</h2>
                        <p class="text-xs sm:text-sm text-gray-500 hidden sm:block">
                            {{ $subheader ?? 'Gérez votre écosystème agropastoral' }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    {{-- Search Bar --}}
                    <div class="flex-1 max-w-xl mx-6">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-[#37474F]/40" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>

                            <input type="text" placeholder="Rechercher des offres, utilisateurs, projets..."
                                class="w-full pl-10 pr-4 py-2.5 bg-[#F9F6EE] border border-transparent rounded-xl
                               focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/30 focus:bg-white focus:border-[#2E7D32]
                               transition-all duration-200 placeholder-[#37474F]/40">


                        </div>
                    </div>

                    {{-- Notifications Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="relative p-2.5 hover:bg-gray-100 rounded-xl transition-all duration-200 group">
                            <svg class="w-6 h-6 text-gray-600 group-hover:text-green-600 transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            <span
                                class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">3</span>
                        </button>

                        {{-- Notifications Dropdown Menu --}}
                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100" x-cloak
                            class="absolute right-0 mt-2 w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-white font-bold text-lg">Notifications</h3>
                                    <span class="bg-white text-green-600 text-xs font-bold px-2.5 py-1 rounded-full">3
                                        nouvelles</span>
                                </div>
                            </div>
                            <div class="max-h-96 overflow-y-auto p-2">
                                {{-- Notification items --}}
                                <div class="px-4 py-3 hover:bg-gray-50 transition cursor-pointer rounded-lg">
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
                                            <p class="text-sm font-semibold text-gray-800">Nouvelle offre disponible
                                            </p>
                                            <p class="text-xs text-gray-500">Maïs bio disponible à Douala</p>
                                            <p class="text-xs text-gray-400 mt-1">Il y a 5 min</p>
                                        </div>
                                        <span class="w-2.5 h-2.5 bg-green-500 rounded-full flex-shrink-0 mt-1"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                                <a href="#"
                                    class="text-green-600 hover:text-green-700 font-semibold text-sm block text-center">
                                    Voir toutes les notifications
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- User Profile Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center space-x-2 p-1.5 hover:bg-gray-100 rounded-xl transition-all duration-200">
                            @if (auth()->user()->avatar)
                                <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar"
                                    class="w-9 h-9 rounded-full ring-2  ring-white group-hover:ring-[#2E7D32]/40 transition-all">
                            @else
                                <div
                                    class="w-9 h-9 rounded-full bg-agro-green flex items-center justify-center text-white font-semibold text-sm border-2 border-white">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="hidden lg:block text-left">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->role->name }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-500 hidden lg:block" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        {{-- Profile Dropdown --}}
                        <div x-show="open" @click.away="open = false" x-transition x-cloak
                            class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-green-600 to-green-700 px-4 py-4">
                                <div class="flex items-center space-x-3">
                                    @if (auth()->user()->avatar)
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar"
                                            class="w-12 h-12 rounded-full ring-2 ring-white/30 group-hover:ring-[#2E7D32]/40 transition-all">
                                    @else
                                        <div
                                            class="w-12 h-12 rounded-full ring-2 ring-white/30 bg-gradient-to-br from-agro-green to-primary flex items-center justify-center text-white font-semibold text-sm border-2">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="text-white">
                                        <p class="font-bold">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-green-100">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('profile') }}" wire:navigate
                                    class="flex items-center space-x-3 px-4 py-2.5 hover:bg-gray-50 transition">
                                    <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Mon Profil</p>
                                        <p class="text-xs text-gray-500">Gérer vos informations</p>
                                    </div>
                                </a>
                                <a href="#"
                                    class="flex items-center space-x-3 px-4 py-2.5 hover:bg-gray-50 transition">
                                    <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
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
                            <div class="border-t border-gray-100 p-2">
                                <div>
                                    @livewire('pages.auth.logout')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>


        {{-- Main Content Area - SANS x-data parent pour Livewire --}}
        <main class="p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="border-t border-gray-200 bg-white mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="flex items-center space-x-2 mb-4 md:mb-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Agrospace © {{ date('Y') }}</span>
                    </div>
                    <div class="flex items-center space-x-6 text-sm text-gray-500">
                        <a href="#" class="hover:text-green-600 transition">Documentation</a>
                        <a href="#" class="hover:text-green-600 transition">Support</a>
                        <a href="#" class="hover:text-green-600 transition">Version 1.0.0</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    {{-- Preloader Livewire pour Agrospace --}}
    <div wire:loading
        class="fixed inset-0 z-[9999] flex items-center justify-center min-h-screen bg-black/20 backdrop-blur-sm"
        style="transition: opacity 0.3s ease-in-out;">

        <div class="relative flex items-center justify-center h-screen">

            {{-- Cercle fixe (fond) --}}
            <div class="absolute w-32 h-32 border-4 border-green-400/40 rounded-full"></div>

            {{-- Cercle animé tournant --}}
            <div
                class="absolute w-32 h-32 border-4 border-transparent border-t-green-600 border-r-green-600 rounded-full animate-spin">
            </div>

            {{-- Logo Agrospace --}}
            <div class="relative z-10 animate-pulse">
                <img src="{{ asset('images/logo.png') }}" alt="Agrospace Logo" class="w-16 h-16 rounded-full" />
            </div>

        </div>
    </div>


    @livewireScripts

    {{-- Toast Notifications --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('showAlert', (data) => {
                Swal.fire({
                    title: data[0].title,
                    text: data[0].text,
                    icon: data[0].type,
                    confirmButtonColor: '#2E7D32',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'px-6 py-3 rounded-lg font-medium',
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp animate__faster'
                    }
                });
            });
        });

        // Dans votre layout principal ou dans un script spécifique
        document.addEventListener('DOMContentLoaded', function() {

            // Alertes classiques
            Livewire.on('alert', function(data) {
                let alertData = data;
                if (Array.isArray(data)) {
                    alertData = data[0] || {};
                }

                Swal.fire({
                    title: alertData.title || 'Information',
                    text: alertData.text || '',
                    icon: alertData.icon || 'info',
                    confirmButtonText: alertData.confirmText || 'OK',
                    confirmButtonColor: '#22c55e'
                });
            });

            // Toasts
            Livewire.on('toast', function(data) {
                let toastData = data;
                if (Array.isArray(data)) {
                    toastData = data[0] || {};
                }

                let type = toastData.type || 'info';
                let message = toastData.message || 'Opération réussie';

                Toast.fire({
                    icon: type,
                    title: message
                });
            });

            // Écouteur pour la deconnexion
            window.addEventListener('confirm-logout', event => {
                const {
                    title,
                    text
                } = event.detail;

                Swal.fire({
                    title: title || 'Confirmer la déconnexion',
                    text: text || "Êtes-vous sûr de vouloir vous déconnecter ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, deconnexion !',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('logout');
                    }
                });
            });

            // Dans votre app.js - version simplifiée
            Livewire.on('swal:confirm', function(data) {
                let confirmData = data;
                if (Array.isArray(data)) {
                    confirmData = data[0] || {};
                }

                Swal.fire({
                    title: confirmData.title || 'Êtes-vous sûr ?',
                    text: confirmData.text || 'Cette action est irréversible.',
                    icon: confirmData.icon || 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#22c55e',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: confirmData.confirmText || 'Oui, continuer',
                    cancelButtonText: confirmData.cancelText || 'Annuler',
                    reverseButtons: true
                }).then(function(result) {
                    if (result.isConfirmed && confirmData.method) {
                        // Re-dispatch vers Livewire avec la méthode
                        Livewire.dispatch(confirmData.method, confirmData.params || {});
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
