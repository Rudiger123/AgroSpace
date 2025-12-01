{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? __('admin.dashboard') }} - {{ __('admin.title') }}</title>
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
            open: Alpine.$persist(window.innerWidth >= 1024),

            init() {
                // Écouter les changements de taille d'écran
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024) {
                        this.open = true;
                    } else {
                        this.open = false;
                    }
                });
            },

            toggle() {
                this.open = !this.open;
            },

            close() {
                this.open = false;
            },

            openSidebar() {
                this.open = true;
            }
        });
    });
</script>
</head>

<body class="font-sans antialiased" style="background: linear-gradient(135deg, #f8fffb 0%, #eefdf4 50%, #e5f9ed 100%);
">

    {{-- Sidebar avec son propre x-data --}}
   <aside x-data
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
                        <h1 class="text-xl font-bold">{{ __('admin.app_name') }}</h1>
                        <p class="text-xs text-green-200">{{ __('admin.admin_dashboard') }}</p>
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
                <span class="font-medium">{{ __('admin.dashboard') }}</span>
            </a>

            @if (auth()->user()->isAdmin())
                <a href="{{ route('users-management') }}" wire:navigate
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('users-management') ? 'bg-green-700 shadow-lg' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span class="font-medium">{{ __('admin.users') }}</span>
                    <span class="ml-auto bg-amber-400 text-amber-900 text-xs px-2 py-1 rounded-full font-semibold">
                        {{ \App\Models\User::count() }}
                    </span>
                </a>

                <a href="{{ route('demands.index') }}" wire:navigate
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('demands.index') ? 'bg-green-700 shadow-lg' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    <span class="font-medium">{{ __('admin.demands_management') }}</span>
                </a>

                <a href="{{ route('offers.moderate') }}" wire:navigate
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('offers.moderate') ? 'bg-green-700 shadow-lg' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                        </path>
                    </svg>
                    <span class="font-medium">{{ __('admin.offers_management') }}</span>
                </a>

                <a href="{{ route('admin.blog.index') }}" wire:navigate
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('admin.blog.*') ? 'bg-green-700 shadow-lg' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                        </path>
                    </svg>
                    <span class="font-medium">{{ __('admin.blog') }}</span>
                </a>

                <a href="{{ route('categories.index') }}" wire:navigate
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('categories.*') ? 'bg-green-700 shadow-lg' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span class="font-medium">{{ __('admin.categories') }}</span>
                </a>

                <a href="{{ route('tags.index') }}" wire:navigate
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('tags.*') ? 'bg-green-700 shadow-lg' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        </path>
                    </svg>
                    <span class="font-medium">{{ __('admin.tags') }}</span>
                </a>

                <a href="{{ route('admin.newsletter.list') }}" wire:navigate
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('admin.newsletter.list') ? 'bg-green-700 shadow-lg' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="font-medium">{{ __('admin.newsletters') }}</span>
                </a>

                <a href="{{ route('contacts.index') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('contacts.index') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z">
                    </path>
                </svg>
                <span class="font-medium">{{ __('admin.contacts') }}</span>
            </a>

                <a href="{{ route('notifications.index') }}" wire:navigate
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('notifications.index') ? 'bg-green-700 shadow-lg' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-5 5v-5zM4.93 4.93l9.07 9.07-9.07 9.07L4.93 4.93z">
                        </path>
                    </svg>
                    <span class="font-medium">{{ __('admin.notifications') }}</span>
                </a>
            @elseif (auth()->user()->isProducer())
                <a href="{{ route('offers-management') }}" wire:navigate
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('offers-management') ? 'bg-green-700 shadow-lg' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="font-medium">{{ __('admin.my_offers') }}</span>
                    <span
                        class="ml-auto bg-amber-400 text-amber-900 text-xs px-2 py-1 rounded-full font-semibold">{{ \App\Models\Offer::where('producer_id', Auth::id())->count() }}</span>
                </a>
            @else
                <a href="{{ route('demands-management') }}" wire:navigate
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('demands-management') ? 'bg-green-700 shadow-lg' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    <span class="font-medium">{{ __('admin.my_demands') }}</span>
                    <span
                        class="ml-auto bg-amber-400 text-amber-900 text-xs px-2 py-1 rounded-full font-semibold">{{ \App\Models\Demand::where('user_id', Auth::id())->count() }}</span>
                </a>
            @endif

            @if (auth()->user()->isAdmin() || auth()->user()->isConsumer())
                <a href="{{ route('admin.responses') }}" wire:navigate
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('admin.responses') ? 'bg-green-700 shadow-lg' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6">
                        </path>
                    </svg>
                    <span class="font-medium">{{ __('admin.my_responses') }}</span>
                </a>
            @endif

            @if (auth()->user()->isAdmin() || auth()->user()->isProducer())
                <a href="{{ route('admin.avis') }}" wire:navigate
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('admin.avis') ? 'bg-green-700 shadow-lg' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z">
                        </path>
                    </svg>
                    <span class="font-medium">{{ __('admin.my_reviews') }}</span>
                </a>
            @endif

            <a href="{{ route('offers-list') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('offers-list') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="font-medium">{{ __('admin.public_offers') }}</span>
            </a>

            <a href="{{ route('demands-list') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('demands-list') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                <span class="font-medium">{{ __('admin.public_demands') }}</span>
            </a>

            <a href="/chats" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('chats') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                    </path>
                </svg>
                <span class="font-medium">{{ __('admin.messages') }}</span>
            </a>

            <a href="{{ route('settings') }}" wire:navigate
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-green-700 {{ request()->routeIs('settings') ? 'bg-green-700 shadow-lg' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 001.066 1.066c.756.426.756 2.924 0 3.35a1.724 1.724 0 00-1.066 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.066-1.066c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-1.066z">
                    </path>
                </svg>
                <span class="font-medium">{{ __('admin.settings') }}</span>
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

    <div class="lg:ml-72 transition-all duration-300">

        {{-- Mobile Overlay --}}
        <div x-show="$store.sidebar.open" @click="$store.sidebar.close()"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden" x-cloak>
        </div>

        {{-- Header --}}
        <header class="bg-primary-50 shadow-sm sticky top-0 z-30">
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
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $header ?? __('admin.dashboard') }}</h2>
                        <p class="text-xs sm:text-sm text-gray-500 hidden sm:block">
                            {{ $subheader ?? __('admin.subheader') }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    {{-- Search Bar --}}
                    <div class="max-w-md">
                        @livewire('admin.global-search')
                    </div>

                    <div class="flex justify-center items-center">
                        <livewire:components.language-switcher />
                    </div>

                    <!-- Notification Bell -->
                    @auth
                        @livewire('notifications.notification-bell')
                    @endauth

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
                                        <p class="text-sm font-semibold text-gray-800">{{ __('admin.my_profile') }}</p>
                                        <p class="text-xs text-gray-500">{{ __('admin.manage_info') }}</p>
                                    </div>
                                </a>
                                <a href="{{ route('settings') }}" wire:navigate
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
                                        <p class="text-sm font-semibold text-gray-800">{{ __('admin.settings') }}</p>
                                        <p class="text-xs text-gray-500">{{ __('admin.configuration') }}</p>
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
                        <span class="text-sm font-semibold text-gray-700">{{ __('admin.copyright', ['year' => date('Y')]) }}</span>
                    </div>
                    <div class="flex items-center space-x-6 text-sm text-gray-500">
                        <a href="{{ route('documentation') }}" wire:navigate class="hover:text-green-600 transition">{{ __('admin.documentation') }}</a>
                        <a href="{{ route('documentation') }}" wire:navigate class="hover:text-green-600 transition">{{ __('admin.support') }}</a>
                        <a href="{{ route('documentation') }}" wire:navigate class="hover:text-green-600 transition">{{ __('admin.version') }}</a>
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
                    confirmButtonText: '{{ __('admin.ok') }}',
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
                    title: alertData.title || '{{ __('admin.information') }}',
                    text: alertData.text || '',
                    icon: alertData.icon || 'info',
                    confirmButtonText: alertData.confirmText || '{{ __('admin.ok') }}',
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
                let message = toastData.message || '{{ __('admin.operation_success') }}';

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
                    title: title || '{{ __('admin.confirm_logout') }}',
                    text: text || "{{ __('admin.confirm_logout_message') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ __('admin.yes_logout') }}',
                    cancelButtonText: '{{ __('admin.cancel') }}'
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
                    title: confirmData.title || '{{ __('admin.are_you_sure') }}',
                    text: confirmData.text || '{{ __('admin.irreversible_action') }}',
                    icon: confirmData.icon || 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#22c55e',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: confirmData.confirmText || '{{ __('admin.yes_continue') }}',
                    cancelButtonText: confirmData.cancelText || '{{ __('admin.cancel') }}',
                    reverseButtons: true
                }).then(function(result) {
                    if (result.isConfirmed && confirmData.method) {
                        // Re-dispatch vers Livewire avec la méthode
                        Livewire.dispatch(confirmData.method, confirmData.params || {});
                    }
                });
            });
        });

        // Additional keyboard shortcut handling
        document.addEventListener('DOMContentLoaded', function() {
            // Ctrl+K or Cmd+K is already handled in the component
            console.log('{{ __('admin.global_search_activated') }}');
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('refresh-page', () => {
                window.location.reload();
            });
        });
    </script>

    @stack('scripts')
</body>

</html>