 <!-- Header Navigation -->
 <header class="fixed top-0 left-0 right-0 z-50 glass-effect shadow-sm">
     <nav class="container mx-auto px-4 py-4">
         <div class="flex items-center justify-between">
             <!-- Logo -->
             <a href="#" class="flex items-center space-x-2 group">
                 <svg class="w-8 h-8 text-primary group-hover:scale-110 transition-transform" fill="currentColor"
                     viewBox="0 0 24 24">
                     <path
                         d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18c-4 0-7-3-7-7V8.3l7-3.5 7 3.5V13c0 4-3 7-7 7z" />
                     <circle cx="12" cy="12" r="3" />
                 </svg>
                 <span class="text-2xl font-bold text-primary">Agrospace</span>
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
                     class="text-gray-700 hover:text-primary transition-colors font-medium">consommateurs</a>
                 <a href="{{ route('about.page') }}" wire:navigate
                     class="text-gray-700 hover:text-primary transition-colors font-medium">about</a>
                 <a href="{{ route('blog.page') }}" wire:navigate
                     class="text-gray-700 hover:text-primary transition-colors font-medium">Blog</a>
                 <!-- Bouton Connexion -->
                 <a href="{{ route('login') }}"
                     class="flex items-center justify-center gap-2 px-5 sm:px-6 py-2.5 rounded-xl font-semibold 
 text-white bg-gradient-to-r from-green-600 to-emerald-500 
 hover:from-green-700 hover:to-emerald-600 transition-all duration-300 
 shadow-md hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-green-300 
 text-sm sm:text-base w-full sm:w-auto">
                     <!-- Icône utilisateur -->
                     <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.847.632 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                     </svg>
                     <span>Connexion</span>
                 </a>

                 <!-- Bouton Inscription -->
                 <a href="{{ route('register') }}"
                     class="flex items-center justify-center gap-2 px-5 sm:px-6 py-2.5 rounded-xl font-semibold 
 text-green-700 border-2 border-green-600 
 hover:bg-green-600 hover:text-white transition-all duration-300 
 shadow-sm hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-300 
 text-sm sm:text-base w-full sm:w-auto">
                     <!-- Icône plus -->
                     <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                     </svg>
                     <span>Inscription</span>
                 </a>
             </div>

             <!-- Mobile Menu Button -->
             <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-700 focus:outline-none">
                 <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M4 6h16M4 12h16M4 18h16" />
                 </svg>
                 <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                 </svg>
             </button>
         </div>

         <!-- Mobile Menu -->
         <div x-show="mobileMenuOpen" x-cloak x-transition class="md:hidden mt-4 pb-4 space-y-3">
             <a href="#accueil" @click="mobileMenuOpen = false"
                 class="block text-gray-700 hover:text-primary font-medium py-2">Accueil</a>
             <a href="{{ route('features') }}" @click="mobileMenuOpen = false"
                 class="block text-gray-700 hover:text-primary font-medium py-2">Fonctionnalités</a>
             <a href="{{ route('producer.page') }}" @click="mobileMenuOpen = false"
                 class="block text-gray-700 hover:text-primary font-medium py-2">Producteurs</a>
             <a href="{{ route('consumer.page') }}" @click="mobileMenuOpen = false"
                 class="block text-gray-700 hover:text-primary font-medium py-2">consommateurs</a>
             <a href="{{ route('about.page') }}" @click="mobileMenuOpen = false"
                 class="block text-gray-700 hover:text-primary font-medium py-2">about</a>
             <a href="{{ route('blog.page') }}" @click="mobileMenuOpen = false"
                 class="block text-gray-700 hover:text-primary font-medium py-2">Blog</a>
             <!-- Bouton Connexion -->
             <a href="{{ route('login') }}"
                 class="flex items-center justify-center gap-2 px-5 sm:px-6 py-2.5 rounded-xl font-semibold 
 text-white bg-gradient-to-r from-green-600 to-emerald-500 
 hover:from-green-700 hover:to-emerald-600 transition-all duration-300 
 shadow-md hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-green-300 
 text-sm sm:text-base w-full sm:w-auto">
                 <!-- Icône utilisateur -->
                 <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.847.632 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                 </svg>
                 <span>Connexion</span>
             </a>

             <!-- Bouton Inscription -->
             <a href="{{ route('register') }}"
                 class="flex items-center justify-center gap-2 px-5 sm:px-6 py-2.5 rounded-xl font-semibold 
 text-green-700 border-2 border-green-600 
 hover:bg-green-600 hover:text-white transition-all duration-300 
 shadow-sm hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-300 
 text-sm sm:text-base w-full sm:w-auto">
                 <!-- Icône plus -->
                 <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                 </svg>
                 <span>Inscription</span>
             </a>
         </div>
     </nav>
 </header>
