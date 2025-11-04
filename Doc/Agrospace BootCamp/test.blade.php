<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrospace - Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        base: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        earth: {
                            50: '#fef3e2',
                            100: '#fde6c6',
                            200: '#fbd08d',
                            300: '#f9b854',
                            400: '#f7a01b',
                            500: '#d88715',
                            600: '#b06d11',
                            700: '#88530d',
                            800: '#603a09',
                            900: '#382105',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
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
            0%, 100% {
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
        .glass-effect-1 {
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
</head>
<body class="bg-gradient-to-br from-base-50 via-white to-earth-50 font-sans" x-data="dashboard()">
    
    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 h-screen w-72 bg-gradient-to-b from-base-800 to-base-900 text-white shadow-2xl z-50 transition-transform duration-300" 
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
        
        <!-- Logo -->
        <div class="p-6 border-b border-base-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-white rounded-xl p-2 animate-pulse-slow">
                        <svg class="w-8 h-8 text-base-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Agrospace</h1>
                        <p class="text-xs text-base-200">Admin Dashboard</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-white hover:bg-base-700 p-2 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="p-4 space-y-2 overflow-y-auto h-[calc(100vh-180px)]">
            <template x-for="item in menuItems" :key="item.name">
                <a :href="item.href" 
                   @click.prevent="currentPage = item.name"
                   :class="currentPage === item.name ? 'bg-base-700 shadow-lg' : 'hover:bg-base-700/50'"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 cursor-pointer group">
                    <span x-html="item.icon" class="w-5 h-5"></span>
                    <span class="font-medium" x-text="item.name"></span>
                    <span x-show="item.badge" 
                          class="ml-auto bg-earth-400 text-earth-900 text-xs px-2 py-1 rounded-full font-semibold"
                          x-text="item.badge"></span>
                </a>
            </template>
        </nav>

        <!-- User Profile -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-base-700 bg-base-900/50">
            <div class="flex items-center space-x-3">
                <img src="https://ui-avatars.com/api/?name=Admin&background=22c55e&color=fff" 
                     class="w-10 h-10 rounded-full ring-2 ring-white" alt="Admin">
                <div class="flex-1">
                    <p class="font-semibold text-sm">Admin Principal</p>
                    <p class="text-xs text-base-200">admin@agrospace.cm</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:ml-72 transition-all duration-300">
        
        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"></div>
        
        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-30 glass-effect-1">
            <div class="px-4 sm:px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 hover:text-base-600 lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Bienvenue sur Agrospace</h2>
                        <p class="text-xs sm:text-sm text-gray-500 hidden sm:block">Gérez votre écosystème agropastoral en toute simplicité</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <!-- Search Bar -->
                    <div class="hidden md:flex items-center bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl px-4 py-2.5 space-x-3 border border-gray-200 hover:border-base-300 transition-all duration-300 shadow-sm hover:shadow-md w-80">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" placeholder="Rechercher des offres, producteurs..." class="bg-transparent outline-none text-sm w-full placeholder-gray-400 font-medium">
                    </div>
                    
                    <!-- Notifications Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="relative p-2.5 hover:bg-gray-100 rounded-xl transition-all duration-200 group">
                            <svg class="w-6 h-6 text-gray-600 group-hover:text-base-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse border-2 border-white"></span>
                            <span class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">3</span>
                        </button>
                        
                        <!-- Notifications Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                            
                            <!-- Header -->
                            <div class="bg-gradient-to-r from-base-600 to-base-700 px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-white font-bold text-lg">Notifications</h3>
                                    <span class="bg-white text-base-600 text-xs font-bold px-2.5 py-1 rounded-full">3 nouvelles</span>
                                </div>
                            </div>
                            
                            <!-- Notifications List -->
                            <div class="max-h-96 overflow-y-auto">
                                <template x-for="notif in notifications" :key="notif.id">
                                    <div class="px-6 py-4 hover:bg-gray-50 transition cursor-pointer border-b border-gray-100 last:border-b-0">
                                        <div class="flex items-start space-x-3">
                                            <div :class="notif.color" class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span x-html="notif.icon" class="w-5 h-5 text-white"></span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-800" x-text="notif.title"></p>
                                                <p class="text-xs text-gray-500 mt-1" x-text="notif.message"></p>
                                                <p class="text-xs text-gray-400 mt-1.5" x-text="notif.time"></p>
                                            </div>
                                            <span x-show="!notif.read" class="w-2.5 h-2.5 bg-base-500 rounded-full flex-shrink-0 mt-1"></span>
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
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-xl transition-all duration-200">
                            <img src="https://ui-avatars.com/api/?name=Admin&background=22c55e&color=fff" 
                                 class="w-9 h-9 rounded-full ring-2 ring-base-200" alt="Admin">
                            <div class="hidden lg:block text-left">
                                <p class="text-sm font-semibold text-gray-800">Admin Principal</p>
                                <p class="text-xs text-gray-500">Administrateur</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-500 hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Profile Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                            
                            <!-- Profile Header -->
                            <div class="bg-gradient-to-r from-base-600 to-base-700 px-6 py-5">
                                <div class="flex items-center space-x-4">
                                    <img src="https://ui-avatars.com/api/?name=Admin&background=ffffff&color=22c55e" 
                                         class="w-16 h-16 rounded-full ring-4 ring-white/30" alt="Admin">
                                    <div class="text-white">
                                        <p class="font-bold text-lg">Admin Principal</p>
                                        <p class="text-xs text-base-100">admin@agrospace.cm</p>
                                        <span class="inline-block mt-2 bg-white/20 text-white text-xs px-3 py-1 rounded-full font-semibold">
                                            🛡️ Administrateur
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Menu Items -->
                            <div class="py-2">
                                <a href="#" class="flex items-center space-x-3 px-6 py-3 hover:bg-gray-50 transition group">
                                    <div class="w-10 h-10 bg-base-100 rounded-lg flex items-center justify-center group-hover:bg-base-200 transition">
                                        <svg class="w-5 h-5 text-base-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-800">Mon Profil</p>
                                        <p class="text-xs text-gray-500">Gérer vos informations</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="flex items-center space-x-3 px-6 py-3 hover:bg-gray-50 transition group">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 001.066 1.066c.756.426.756 2.924 0 3.35a1.724 1.724 0 00-1.066 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.066-1.066c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-1.066z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-800">Paramètres</p>
                                        <p class="text-xs text-gray-500">Configuration système</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="flex items-center space-x-3 px-6 py-3 hover:bg-gray-50 transition group">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-800">Préférences</p>
                                        <p class="text-xs text-gray-500">Personnalisation</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="flex items-center space-x-3 px-6 py-3 hover:bg-gray-50 transition group">
                                    <div class="w-10 h-10 bg-earth-100 rounded-lg flex items-center justify-center group-hover:bg-earth-200 transition">
                                        <svg class="w-5 h-5 text-earth-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                                <button class="flex items-center space-x-3 px-6 py-3 hover:bg-red-50 transition w-full rounded-xl group">
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-200 transition">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
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

        <!-- Dashboard Content -->
        <main class="p-4 sm:p-6 space-y-4 sm:space-y-6">
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <template x-for="(stat, index) in stats" :key="index">
                    <div class="bg-white rounded-2xl p-6 shadow-lg card-hover animate-fadeInUp glass-effect-1"
                         :style="'animation-delay: ' + (index * 100) + 'ms'">
                        <div class="flex items-center justify-between mb-4">
                            <div :class="stat.bgColor" class="w-12 h-12 rounded-xl flex items-center justify-center">
                                <span x-html="stat.icon" :class="stat.iconColor" class="w-6 h-6"></span>
                            </div>
                            <span :class="stat.trend === 'up' ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100'" 
                                  class="text-sm font-semibold px-3 py-1 rounded-full flex items-center space-x-1">
                                <span x-text="stat.change"></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          :d="stat.trend === 'up' ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3'"></path>
                                </svg>
                            </span>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1" x-text="stat.label"></h3>
                        <p class="text-3xl font-bold text-gray-800" x-text="stat.value"></p>
                        <p class="text-xs text-gray-500 mt-2" x-text="stat.description"></p>
                    </div>
                </template>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Activity Chart -->
                <div class="bg-white rounded-2xl p-6 shadow-lg glass-effect-1 animate-fadeInUp" style="animation-delay: 400ms">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Activité de la plateforme</h3>
                            <p class="text-sm text-gray-500">Offres et demandes par mois</p>
                        </div>
                        <select class="bg-gray-100 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 outline-none">
                            <option>6 derniers mois</option>
                            <option>12 derniers mois</option>
                            <option>Cette année</option>
                        </select>
                    </div>
                    <div class="h-64 flex items-end justify-between space-x-2">
                        <template x-for="(month, index) in activityData" :key="index">
                            <div class="flex-1 flex flex-col items-center space-y-2">
                                <div class="w-full flex flex-col space-y-1">
                                    <div class="bg-base-500 rounded-t-lg transition-all duration-500 hover:bg-base-600" 
                                         :style="'height: ' + (month.offres * 2) + 'px'"
                                         @mouseenter="hoveredBar = 'offres-' + index"
                                         @mouseleave="hoveredBar = null">
                                    </div>
                                    <div class="bg-earth-400 rounded-t-lg transition-all duration-500 hover:bg-earth-500" 
                                         :style="'height: ' + (month.demandes * 2) + 'px'"
                                         @mouseenter="hoveredBar = 'demandes-' + index"
                                         @mouseleave="hoveredBar = null">
                                    </div>
                                </div>
                                <span class="text-xs text-gray-600 font-medium" x-text="month.month"></span>
                            </div>
                        </template>
                    </div>
                    <div class="flex items-center justify-center space-x-6 mt-4 pt-4 border-t">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-base-500 rounded"></div>
                            <span class="text-sm text-gray-600">Offres</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-earth-400 rounded"></div>
                            <span class="text-sm text-gray-600">Demandes</span>
                        </div>
                    </div>
                </div>

                <!-- Categories Distribution -->
                <div class="bg-white rounded-2xl p-6 shadow-lg glass-effect-1 animate-fadeInUp" style="animation-delay: 500ms">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Catégories populaires</h3>
                        <p class="text-sm text-gray-500">Distribution des offres par catégorie</p>
                    </div>
                    <div class="space-y-4">
                        <template x-for="(cat, index) in categories" :key="index">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-2">
                                        <span x-html="cat.icon" class="w-5 h-5 text-base-600"></span>
                                        <span class="text-sm font-medium text-gray-700" x-text="cat.name"></span>
                                    </div>
                                    <span class="text-sm font-bold text-gray-800" x-text="cat.count"></span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-base-500 to-base-600 h-2 rounded-full transition-all duration-700 ease-out" 
                                         :style="'width: ' + cat.percentage + '%'"
                                         x-transition></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Recent Activities & Top Users -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Recent Activities -->
                <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-lg glass-effect-1 animate-fadeInUp" style="animation-delay: 600ms">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Activités récentes</h3>
                            <p class="text-sm text-gray-500">Dernières actions sur la plateforme</p>
                        </div>
                        <button class="text-base-600 hover:text-base-700 text-sm font-semibold">Voir tout →</button>
                    </div>
                    <div class="space-y-4">
                        <template x-for="(activity, index) in recentActivities" :key="index">
                            <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                                <div :class="activity.color" class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span x-html="activity.icon" class="w-5 h-5 text-white"></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800" x-text="activity.title"></p>
                                    <p class="text-sm text-gray-500" x-text="activity.description"></p>
                                    <p class="text-xs text-gray-400 mt-1" x-text="activity.time"></p>
                                </div>
                                <span :class="activity.badge.color" 
                                      class="px-3 py-1 rounded-full text-xs font-semibold"
                                      x-text="activity.badge.text"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Top Producers -->
                <div class="bg-white rounded-2xl p-6 shadow-lg glass-effect-1 animate-fadeInUp" style="animation-delay: 700ms">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Top Producteurs</h3>
                        <p class="text-sm text-gray-500">Les plus actifs ce mois</p>
                    </div>
                    <div class="space-y-4">
                        <template x-for="(producer, index) in topProducers" :key="index">
                            <div class="flex items-center space-x-3 p-3 rounded-xl hover:bg-base-50 transition cursor-pointer">
                                <div class="relative">
                                    <img :src="'https://ui-avatars.com/api/?name=' + producer.name + '&background=' + producer.color + '&color=fff'" 
                                         class="w-12 h-12 rounded-full ring-2 ring-white shadow" :alt="producer.name">
                                    <span class="absolute -bottom-1 -right-1 bg-base-500 text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center border-2 border-white" 
                                          x-text="index + 1"></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate" x-text="producer.name"></p>
                                    <p class="text-xs text-gray-500" x-text="producer.location"></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-base-600" x-text="producer.offres"></p>
                                    <p class="text-xs text-gray-400">offres</p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-base-600 to-base-700 rounded-2xl p-8 shadow-2xl animate-fadeInUp" style="animation-delay: 800ms">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                    <div class="text-white">
                        <h3 class="text-2xl font-bold mb-2">🚀 Développez votre écosystème</h3>
                        <p class="text-base-100 text-sm">Connectez plus de producteurs et consommateurs dès aujourd'hui</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button class="bg-white text-base-600 hover:bg-base-50 px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Nouvelle Offre</span>
                        </button>
                        <button class="bg-base-500 text-white hover:bg-base-400 px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span>Inviter des utilisateurs</span>
                        </button>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script>
        function dashboard() {
            return {
                sidebarOpen: window.innerWidth >= 1024,
                currentPage: 'Dashboard',
                hoveredBar: null,
                notifications: [
                    {
                        id: 1,
                        title: 'Nouvelle inscription',
                        message: 'Marie Fotso vient de s\'inscrire comme productrice',
                        time: 'Il y a 5 minutes',
                        color: 'bg-base-500',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path></svg>',
                        read: false
                    },
                    {
                        id: 2,
                        title: 'Nouvelle offre',
                        message: 'Kouam Jean a publié "1 tonne de Maïs Bio"',
                        time: 'Il y a 12 minutes',
                        color: 'bg-blue-500',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"></path></svg>',
                        read: false
                    },
                    {
                        id: 3,
                        title: 'Message important',
                        message: 'Vous avez reçu un message de Paul Ngono',
                        time: 'Il y a 1 heure',
                        color: 'bg-earth-500',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path></svg>',
                        read: false
                    },
                    {
                        id: 4,
                        title: 'Demande satisfaite',
                        message: 'La demande "50 poulets de chair" a été pourvue',
                        time: 'Il y a 2 heures',
                        color: 'bg-green-500',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
                        read: true
                    }
                ],
                menuItems: [
                    { name: 'Dashboard', href: '#', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>' },
                    { name: 'Utilisateurs', href: '#', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>', badge: '247' },
                    { name: 'Offres', href: '#', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>', badge: '156' },
                    { name: 'Demandes', href: '#', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>', badge: '89' },
                    { name: 'Messages', href: '#', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>', badge: '12' },
                    { name: 'Blog', href: '#', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>' },
                    { name: 'Carte', href: '#', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>' },
                    { name: 'Statistiques', href: '#', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>' },
                    { name: 'Paramètres', href: '#', icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 001.066 1.066c.756.426.756 2.924 0 3.35a1.724 1.724 0 00-1.066 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.066-1.066c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-1.066z"></path></svg>' },
                ],
                stats: [
                    {
                        label: 'Utilisateurs actifs',
                        value: '2,847',
                        change: '+12%',
                        trend: 'up',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
                        bgColor: 'bg-base-100',
                        iconColor: 'text-base-600',
                        description: '247 nouveaux ce mois'
                    },
                    {
                        label: 'Offres publiées',
                        value: '1,562',
                        change: '+8%',
                        trend: 'up',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                        bgColor: 'bg-blue-100',
                        iconColor: 'text-blue-600',
                        description: '156 cette semaine'
                    },
                    {
                        label: 'Demandes actives',
                        value: '892',
                        change: '+15%',
                        trend: 'up',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>',
                        bgColor: 'bg-earth-100',
                        iconColor: 'text-earth-600',
                        description: '89 aujourd\'hui'
                    },
                    {
                        label: 'Taux de conversion',
                        value: '68%',
                        change: '+5%',
                        trend: 'up',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
                        bgColor: 'bg-purple-100',
                        iconColor: 'text-purple-600',
                        description: 'Demandes satisfaites'
                    }
                ],
                activityData: [
                    { month: 'Mai', offres: 95, demandes: 78 },
                    { month: 'Juin', offres: 110, demandes: 85 },
                    { month: 'Juil', offres: 88, demandes: 92 },
                    { month: 'Août', offres: 125, demandes: 105 },
                    { month: 'Sept', offres: 105, demandes: 88 },
                    { month: 'Oct', offres: 132, demandes: 115 }
                ],
                categories: [
                    { 
                        name: 'Céréales & Grains', 
                        count: 342, 
                        percentage: 85,
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>'
                    },
                    { 
                        name: 'Légumes & Fruits', 
                        count: 298, 
                        percentage: 74,
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                    },
                    { 
                        name: 'Élevage & Volaille', 
                        count: 267, 
                        percentage: 66,
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>'
                    },
                    { 
                        name: 'Produits Transformés', 
                        count: 189, 
                        percentage: 47,
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>'
                    },
                    { 
                        name: 'Services Agricoles', 
                        count: 156, 
                        percentage: 39,
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>'
                    }
                ],
                recentActivities: [
                    {
                        title: 'Nouvelle offre publiée',
                        description: 'Kouam Jean a publié "1 tonne de Maïs Bio - Douala"',
                        time: 'Il y a 5 minutes',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"></path></svg>',
                        color: 'bg-base-500',
                        badge: { text: 'Offre', color: 'bg-base-100 text-base-700' }
                    },
                    {
                        title: 'Nouveau producteur inscrit',
                        description: 'Marie Fotso a rejoint Agrospace depuis Bafoussam',
                        time: 'Il y a 12 minutes',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path></svg>',
                        color: 'bg-blue-500',
                        badge: { text: 'Nouveau', color: 'bg-blue-100 text-blue-700' }
                    },
                    {
                        title: 'Demande satisfaite',
                        description: 'La demande "50 poulets de chair" a été pourvue',
                        time: 'Il y a 1 heure',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
                        color: 'bg-green-500',
                        badge: { text: 'Succès', color: 'bg-green-100 text-green-700' }
                    },
                    {
                        title: 'Article publié',
                        description: 'Nouvel article: "Les techniques modernes de culture du cacao"',
                        time: 'Il y a 2 heures',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"></path><path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"></path></svg>',
                        color: 'bg-purple-500',
                        badge: { text: 'Blog', color: 'bg-purple-100 text-purple-700' }
                    },
                    {
                        title: 'Message reçu',
                        description: 'Un consommateur s\'intéresse à votre offre de bananes plantain',
                        time: 'Il y a 3 heures',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path><path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path></svg>',
                        color: 'bg-earth-500',
                        badge: { text: 'Message', color: 'bg-earth-100 text-earth-700' }
                    }
                ],
                topProducers: [
                    { name: 'Kouam Jean', location: 'Douala, Littoral', offres: 47, color: '22c55e' },
                    { name: 'Marie Fotso', location: 'Bafoussam, Ouest', offres: 38, color: '3b82f6' },
                    { name: 'Paul Ngono', location: 'Yaoundé, Centre', offres: 35, color: 'f59e0b' },
                    { name: 'Fatima Hassan', location: 'Garoua, Nord', offres: 29, color: 'ef4444' },
                    { name: 'Ibrahim Mahamat', location: 'Maroua, Extrême-Nord', offres: 24, color: '8b5cf6' }
                ]
            }
        }
    </script>
</body>
</html>