{{-- resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Agrospace') }} - @yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100 antialiased">
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
            {{-- Logo --}}
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-green-600">Agrospace</h1>
                <p class="text-sm text-gray-500">Plateforme agricole</p>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-green-50 text-green-600' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition {{ request()->routeIs('chat.*') ? 'bg-green-50 text-green-600' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span>Messagerie</span>
                    @if (auth()->user()->unreadMessagesCount() > 0)
                        <span class="ml-auto px-2 py-1 text-xs font-bold text-white bg-red-500 rounded-full">
                            {{ auth()->user()->unreadMessagesCount() }}
                        </span>
                    @endif
                </a>

                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span>Offres</span>
                </a>

                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Profil</span>
                </a>
            </nav>

            {{-- User info + logout --}}
            <div class="p-4 border-t border-gray-200">
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition">
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Top bar --}}
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">@yield('title', 'Dashboard')</h2>
                        <p class="text-sm text-gray-500">@yield('subtitle', 'Bienvenue sur Agrospace')</p>
                    </div>

                    <div class="flex items-center gap-4">
                        {{-- Barre de recherche --}}
                        <div class="relative hidden md:block">
                            <input type="search" placeholder="Rechercher..."
                                class="pl-10 pr-4 py-2 w-64 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        {{-- Notifications dropdown --}}
                        @livewire('notification.notifications-dropdown')
                    </div>
                </div>
            </header>

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Toast container (pour notifications) --}}
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    @livewireScripts

    @stack('scripts')
</body>

</html>
