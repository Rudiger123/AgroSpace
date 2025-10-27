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
    class="h-16 bg-white border-b border-[#E0E0E0] px-6 flex items-center justify-between sticky top-0 shadow-soft z-auto"> {{-- J'ai retire le z-40 --}}
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