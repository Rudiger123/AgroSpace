<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '🌿🌿✨Agrospace🌿🌿✨ - Connectons les acteurs du monde agropastoral') }}</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-inter antialiased bg-agro-white text-agro-gray">
    {{-- Header Component --}}

    <div class="flex">
        <aside x-data="{
            sidebarOpen: true,
            activeMenu: 'dashboard',
            submenuOpen: {}
        }" :class="sidebarOpen ? 'w-64' : 'w-20'"
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
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
                    <div x-show="activeMenu === 'dashboard'"
                        class="absolute left-0 top-0 h-full w-1 bg-white rounded-r">
                    </div>

                    <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-200 group-hover:scale-110"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <div x-data="{ open: false }">
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
                        <img src="https://ui-avatars.com/api/?name=Admin&background=2E7D32&color=fff" alt="Avatar"
                            class="w-10 h-10 rounded-full ring-2 ring-[#2E7D32]/20 group-hover:ring-[#2E7D32]/40 transition-all">
                        <div x-show="sidebarOpen" x-transition class="flex-1 text-left">
                            <p class="text-sm font-medium text-[#37474F]">Admin</p>
                            <p class="text-xs text-[#37474F]/60">admin@agrospace.com</p>
                        </div>
                    </button>

                    <!-- Menu contextuel -->
                    <div x-show="menuOpen" @click.away="menuOpen = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-xl shadow-strong border border-[#E0E0E0] overflow-hidden">
                        <a href="/profile"
                            class="block px-4 py-3 text-sm text-[#37474F] hover:bg-[#F9F6EE] transition-colors">
                            Mon Profil
                        </a>
                        <a href="/settings"
                            class="block px-4 py-3 text-sm text-[#37474F] hover:bg-[#F9F6EE] transition-colors">
                            Paramètres
                        </a>

                        <livewire:logout>
                    </div>
                </div>
            </div>
        </aside>

        <style>
            /* Scrollbar personnalisée */
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #E0E0E0;
                border-radius: 3px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #2E7D32;
            }
        </style>


        <div class="flex-1 flex flex-col overflow-hidden">

            <header x-data="{
                searchOpen: false,
                notificationsOpen: false,
                notifications: [
                    { id: 1, type: 'success', message: 'Nouvelle offre publiée', time: '5 min', unread: true },
                    { id: 2, type: 'info', message: '3 nouveaux utilisateurs', time: '1h', unread: true },
                    { id: 3, type: 'warning', message: 'Maintenance prévue', time: '2h', unread: false }
                ],
                unreadCount: 2
            }"
                class="h-16 bg-white border-b border-[#E0E0E0] px-6 flex items-center justify-between sticky top-0 shadow-soft"> {{-- J'ai retire le z-40 --}}
                <!-- Recherche améliorée -->
                <div class="flex-1 max-w-xl mx-6">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-[#37474F]/40" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        <input type="text" @focus="searchOpen = true"
                            @blur="setTimeout(() => searchOpen = false, 200)"
                            placeholder="Rechercher des offres, utilisateurs, projets..."
                            class="w-full pl-10 pr-4 py-2.5 bg-[#F9F6EE] border border-transparent rounded-xl
                           focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/30 focus:bg-white focus:border-[#2E7D32]
                           transition-all duration-200 placeholder-[#37474F]/40">

                        <!-- Suggestions de recherche -->
                        <div x-show="searchOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-strong border border-[#E0E0E0] overflow-hidden">
                            <div class="p-2 space-y-1">
                                <a href="#"
                                    class="block px-3 py-2 rounded-lg hover:bg-[#F9F6EE] transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-4 h-4 text-[#2E7D32]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm text-[#37474F]">Recherches récentes</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="flex items-center space-x-3">
                    <!-- Bouton action rapide -->
                    <button
                        class="px-4 py-2 bg-[#2E7D32] text-white rounded-lg font-medium hover:bg-[#1B5E20] 
                           transition-all duration-200 transform hover:scale-105 shadow-soft hover:shadow-medium
                           flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Nouvelle offre</span>
                    </button>

                    <!-- Notifications avec badge -->
                    <div class="relative">
                        <button @click="notificationsOpen = !notificationsOpen"
                            class="relative p-2.5 rounded-xl hover:bg-[#F9F6EE] transition-all duration-200 group">
                            <svg class="w-6 h-6 text-[#37474F] group-hover:text-[#2E7D32] transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            <!-- Badge avec animation pulse -->
                            <span x-show="unreadCount > 0"
                                class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full 
           flex items-center justify-center animate-pulse"
                                x-text="unreadCount"></span>
                        </button>

                        <!-- Panel notifications -->
                        <div x-show="notificationsOpen" @click.away="notificationsOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
                            class="absolute right-0 top-full mt-2 w-80 bg-white rounded-xl shadow-strong border border-[#E0E0E0] overflow-hidden">
                            <!-- Header -->
                            <div class="px-4 py-3 border-b border-[#E0E0E0] flex items-center justify-between">
                                <h3 class="font-semibold text-[#37474F] font-poppins">Notifications</h3>
                                <button @click="unreadCount = 0; notifications.forEach(n => n.unread = false)"
                                    class="text-xs text-[#2E7D32] hover:text-[#1B5E20] font-medium">
                                    Tout marquer comme lu
                                </button>
                            </div>

                            <!-- Liste notifications -->
                            <div class="max-h-96 overflow-y-auto">
                                <template x-for="notification in notifications" :key="notification.id">
                                    <div :class="notification.unread ? 'bg-[#F9F6EE]' : 'bg-white'"
                                        class="px-4 py-3 hover:bg-[#F9F6EE] transition-colors cursor-pointer border-b border-[#E0E0E0] last:border-b-0">
                                        <div class="flex items-start space-x-3">
                                            <!-- Icône selon le type -->
                                            <div :class="{
                                                'bg-green-100 text-green-600': notification.type === 'success',
                                                'bg-blue-100 text-blue-600': notification.type === 'info',
                                                'bg-orange-100 text-orange-600': notification.type === 'warning'
                                            }"
                                                class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                            </div>

                                            <div class="flex-1">
                                                <p class="text-sm text-[#37474F] font-medium"
                                                    x-text="notification.message">
                                                </p>
                                                <p class="text-xs text-[#37474F]/60 mt-1"
                                                    x-text="'Il y a ' + notification.time"></p>
                                            </div>

                                            <!-- Indicateur non lu -->
                                            <div x-show="notification.unread"
                                                class="w-2 h-2 bg-[#2E7D32] rounded-full flex-shrink-0 mt-2"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Footer -->
                            <div class="px-4 py-3 border-t border-[#E0E0E0] text-center">
                                <a href="/notifications"
                                    class="text-sm text-[#2E7D32] hover:text-[#1B5E20] font-medium">
                                    Voir toutes les notifications
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Toggle thème -->
                    <button x-data="{ darkMode: false }" @click="darkMode = !darkMode"
                        class="p-2.5 rounded-xl hover:bg-[#F9F6EE] transition-all duration-200 group relative overflow-hidden">
                        <svg x-show="!darkMode"
                            class="w-6 h-6 text-[#37474F] group-hover:text-[#FFB300] transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                        <svg x-show="darkMode" x-cloak class="w-6 h-6 text-[#FFB300] transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </button>
                </div>
            </header>

            <main>
                {{ $slot }}
            </main>

        </div>
    </div>

    @livewireScripts
</body>

</html>
