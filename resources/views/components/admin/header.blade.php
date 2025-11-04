<header class="bg-white shadow-sm sticky top-0 z-30 glass-effect-1">
    <div class="px-4 sm:px-6 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 hover:text-base-600 lg:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Bienvenue sur Agrospace</h2>
                <p class="text-xs sm:text-sm text-gray-500 hidden sm:block">Gérez votre écosystème agropastoral en toute
                    simplicité</p>
            </div>
        </div>

        <div class="flex items-center space-x-3" x-data.ignore = "{ searchOpen: false }">
            <!-- Search Bar -->
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

            <!-- Notifications Dropdown -->
            <div class="relative" x-data.ignore="{ open: false }" x-cloak>
                <button @click="open = !open"
                    class="relative p-2.5 hover:bg-gray-100 rounded-xl transition-all duration-200 group">
                    <svg class="w-6 h-6 text-gray-600 group-hover:text-base-600 transition" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                    <span
                        class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse border-2 border-white"></span>
                    <span
                        class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">3</span>
                </button>

                <!-- Notifications Dropdown Menu -->
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">

                    <!-- Header -->
                    <div class="bg-gradient-to-r from-base-600 to-base-700 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-white font-bold text-lg">Notifications</h3>
                            <span class="bg-white text-base-600 text-xs font-bold px-2.5 py-1 rounded-full">3
                                nouvelles</span>
                        </div>
                    </div>

                    <!-- Notifications List -->
                    <div class="max-h-96 overflow-y-auto">
                        <template x-for="notif in notifications" :key="notif.id">
                            <div
                                class="px-6 py-4 hover:bg-gray-50 transition cursor-pointer border-b border-gray-100 last:border-b-0">
                                <div class="flex items-start space-x-3">
                                    <div :class="notif.color"
                                        class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span x-html="notif.icon" class="w-5 h-5 text-white"></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800" x-text="notif.title"></p>
                                        <p class="text-xs text-gray-500 mt-1" x-text="notif.message"></p>
                                        <p class="text-xs text-gray-400 mt-1.5" x-text="notif.time"></p>
                                    </div>
                                    <span x-show="!notif.read"
                                        class="w-2.5 h-2.5 bg-base-500 rounded-full flex-shrink-0 mt-1"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Footer -->
                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                        <button class="text-base-600 hover:text-base-700 font-semibold text-sm w-full text-center">
                            Voir toutes les notifications
                        </button>
                    </div>
                </div>
            </div>

            <!-- User Profile Dropdown -->
            <div class="relative" x-data.ignore="{ open: false }" x-cloak>
                <button @click="open = !open"
                    class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-xl transition-all duration-200">
                    @if (auth()->user()->avatar)
                <img src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                    class="w-9 h-9 rounded-full ring-2 ring-[#2E7D32]/20 group-hover:ring-[#2E7D32]/40 transition-all">
            @else
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-br from-agro-green to-primary flex items-center justify-center text-white font-semibold text-sm border-2 border-agro-green">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            @endif
                    <div class="hidden lg:block text-left">
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-500 hidden lg:block" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Profile Dropdown Menu -->
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">

                    <!-- Profile Header -->
                    <div class="bg-gradient-to-r from-base-600 to-base-700 px-6 py-5">
                        <div class="flex items-center space-x-4">
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
                                <p class="font-bold text-lg">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-base-100">{{ Auth::user()->email }}</p>
                                <span
                                    class="inline-block mt-2 bg-white/20 text-white text-xs px-3 py-1 rounded-full font-semibold">
                                    {{ Auth::user()->role->name }}
                                    <!-- 🛡️ Administrateur -->
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Items -->
                    <div class="py-2">
                        <a href="#"
                            class="flex items-center space-x-3 px-6 py-3 hover:bg-gray-50 transition group">
                            <div
                                class="w-10 h-10 bg-base-100 rounded-lg flex items-center justify-center group-hover:bg-base-200 transition">
                                <svg class="w-5 h-5 text-base-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">Mon Profil</p>
                                <p class="text-xs text-gray-500">Gérer vos informations</p>
                            </div>
                        </a>

                        <a href="#"
                            class="flex items-center space-x-3 px-6 py-3 hover:bg-gray-50 transition group">
                            <div
                                class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 001.066 1.066c.756.426.756 2.924 0 3.35a1.724 1.724 0 00-1.066 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.066-1.066c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-1.066z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">Paramètres</p>
                                <p class="text-xs text-gray-500">Configuration système</p>
                            </div>
                        </a>

                        <a href="#"
                            class="flex items-center space-x-3 px-6 py-3 hover:bg-gray-50 transition group">
                            <div
                                class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">Préférences</p>
                                <p class="text-xs text-gray-500">Personnalisation</p>
                            </div>
                        </a>

                        <a href="#"
                            class="flex items-center space-x-3 px-6 py-3 hover:bg-gray-50 transition group">
                            <div
                                class="w-10 h-10 bg-earth-100 rounded-lg flex items-center justify-center group-hover:bg-earth-200 transition">
                                <svg class="w-5 h-5 text-earth-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">Aide & Support</p>
                                <p class="text-xs text-gray-500">Centre d'assistance</p>
                            </div>
                        </a>
                    </div>

                    <!-- Logout -->
                    <div class="border-t border-gray-100 p-2">
                        <button
                            class="flex items-center space-x-3 px-6 py-3 hover:bg-red-50 transition w-full rounded-xl group">
                            <div
                                class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-200 transition">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <p class="text-sm font-semibold text-red-600">Déconnexion</p>
                                <p class="text-xs text-red-400">Se déconnecter du système</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
