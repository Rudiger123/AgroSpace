<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

new class extends Component {

   //Etat pour suivre si on a scrollé
   public $scrolled = false;
    
}; ?>

<div 
    x-data.ignore="{
        open: false,
        scrolled: false,
        toggleMenu() { this.open = !this.open },
        closeMenu() { this.open = false },
    }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 30)"
    :class="scrolled ? 'bg-gradient-to-br from-[#2E7D32] via-[#388E3C] to-[#1B5E20]' : 'bg-transparent'"
    class="fixed w-full top-0 z-50 transition-all duration-300"
>
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <a href="/" class="flex items-center space-x-2">
                <img src="{{ asset('agrospace.png') }}" alt="AgroSpace Logo" class="h-8 w-8 object-contain">
                <span class="text-2xl font-bold text-green-900">AgroSpace</span>
            </a>
        </div>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex items-center space-x-8">
            <a href="/" class="text-gray-700 dark:text-gray-200 hover:text-green-600 font-medium transition">Accueil</a>
            <a href="/offers" class="text-gray-700 dark:text-gray-200 hover:text-green-600 font-medium transition">Offres</a>
            <a href="/demands" class="text-gray-700 dark:text-gray-200 hover:text-green-600 font-medium transition">Demandes</a>
            </nav>

        <!-- Actions -->
        <div class="flex items-center space-x-4">
            <!-- Langue -->
            <div x-data="{ openLang: false }" class="relative">
                <button @click="openLang = !openLang" class="flex items-center space-x-1 text-gray-700 dark:text-gray-200 hover:text-green-600">
                    <span class="fi fi-fr"></span>
                    <span class="hidden sm:inline">FR</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div 
                    x-show="openLang"
                    @click.away="openLang = false"
                    x-transition
                    class="absolute right-0 mt-2 w-24 bg-white dark:bg-green-800 rounded-lg shadow-lg overflow-hidden border border-gray-100 dark:border-green-900"
                >
                    <a href="#" class="block px-3 py-2 hover:bg-green-100 dark:hover:bg-green-700">🇫🇷 FR</a>
                    <a href="#" class="block px-3 py-2 hover:bg-green-100 dark:hover:bg-green-700">🇬🇧 EN</a>
                </div>
            </div>

            <!-- Thème -->
            <button 
                @click="document.documentElement.classList.toggle('dark')" 
                class="p-2 rounded-full hover:bg-green-600 dark:bg-green-700 transition"
            >
                <svg x-show="!document.documentElement.classList.contains('dark')" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700 dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-12.66l-.71.71M4.05 19.95l.71-.71M21 12h1M2 12H1m16.95 7.95l-.71-.71M4.05 4.05l.71.71M12 5a7 7 0 100 14 7 7 0 000-14z" />
                </svg>
                <svg x-show="document.documentElement.classList.contains('dark')" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
                </svg>
            </button>

            <!-- Connexion -->
            @guest
            <a href="{{ route('login', absolute: false) }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">Connexion</a>
            <a href="{{ route('register', absolute: false) }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">Create Account</a>
            @else
                <div x-data="{ openUser: false }" class="relative">
                    <button @click="openUser = !openUser" class="flex items-center space-x-2">
                        <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.png') }}" class="h-8 w-8 rounded-full object-cover">
                        <span class="text-gray-700 dark:text-gray-200 text-sm font-medium">{{ Auth::user()->name }}</span>
                    </button>
                    <div 
                        x-show="openUser"
                        @click.away="openUser = false"
                        x-transition
                        class="absolute right-0 mt-2 w-48 text-white bg-gradient-to-br from-[#2E7D32] via-[#388E3C] to-[#1B5E20] rounded-lg shadow-lg border border-green-400"
                    >
                        <a href="/dashboard" class="block px-4 py-2 hover:bg-[#388E3C] rounded-lg">Dashboard</a
                    </div>
                </div>
            @endguest

            <!-- Menu mobile -->
            <button @click="toggleMenu" class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-green-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </header>

    <!-- Menu mobile -->
    <nav 
        x-show="open" 
        x-transition
        class="md:hidden bg-green-400 dark:bg-green-900 border-t border-gray-100 dark:border-gray-700"
    >
        <div class="px-4 py-3 space-y-2">
            <a href="/" class="block py-2 text-gray-700 dark:text-gray-200 hover:text-green-600">Accueil</a>
            <a href="/offers" class="block py-2 text-gray-700 dark:text-gray-200 hover:text-green-600">Offres</a>
            <a href="/demands" class="block py-2 text-gray-700 dark:text-gray-200 hover:text-green-600">Demandes</a>
          <a href="/about" class="block py-2 text-gray-700 dark:text-gray-200 hover:text-green-600">À propos</a>
            <a href="/contact" class="block py-2 text-gray-700 dark:text-gray-200 hover:text-green-600">Contact</a>
        </div>
    </nav>
</div>
