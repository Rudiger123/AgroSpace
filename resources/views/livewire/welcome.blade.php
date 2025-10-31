<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.guest')] class extends Component {
    //
}; ?>
<div>

    <body class="font-sans antialiased bg-white" x-data="{ mobileMenuOpen: false, testimonialIndex: 0 }">

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
                        <a href="#accueil"
                            class="text-gray-700 hover:text-primary transition-colors font-medium">Accueil</a>
                        <a href="#fonctionnalites"
                            class="text-gray-700 hover:text-primary transition-colors font-medium">Fonctionnalités</a>
                        <a href="#temoignages"
                            class="text-gray-700 hover:text-primary transition-colors font-medium">Témoignages</a>
                        <a href="#blog"
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Inscription</span>
                        </a>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden text-gray-700 focus:outline-none">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div x-show="mobileMenuOpen" x-cloak x-transition class="md:hidden mt-4 pb-4 space-y-3">
                    <a href="#accueil" @click="mobileMenuOpen = false"
                        class="block text-gray-700 hover:text-primary font-medium py-2">Accueil</a>
                    <a href="#fonctionnalites" @click="mobileMenuOpen = false"
                        class="block text-gray-700 hover:text-primary font-medium py-2">Fonctionnalités</a>
                    <a href="#temoignages" @click="mobileMenuOpen = false"
                        class="block text-gray-700 hover:text-primary font-medium py-2">Témoignages</a>
                    <a href="#blog" @click="mobileMenuOpen = false"
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

        <!-- Hero Section -->
        <section id="accueil" class="relative pt-24 pb-20 md:pt-32 md:pb-28 overflow-hidden gradient-bg">
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <div class="absolute inset-0"
                    style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                </div>
            </div>

            <div class="container mx-auto px-4">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="text-white space-y-6 animate-fade-in-up">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                            La plateforme qui connecte <span class="text-secondary">producteurs</span> et <span
                                class="text-secondary">consommateurs</span> agricoles en Afrique
                        </h1>
                        <p class="text-lg md:text-xl text-green-50 leading-relaxed">
                            Découvrez, échangez, collaborez dans un écosystème agropastoral durable.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <!-- 🌱 Bouton principal -->
                            <a href="#"
                                class="flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-emerald-500 
                                      text-white px-8 py-4 rounded-xl font-semibold 
                                      hover:from-green-700 hover:to-emerald-600 hover:scale-[1.03]
                                      transition-all duration-300 shadow-lg hover:shadow-2xl 
                                      text-center w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Créer mon compte gratuitement
                            </a>

                            <!-- 🌾 Bouton secondaire -->
                            <a href="#fonctionnalites"
                                class="flex items-center justify-center gap-2 bg-transparent border-2 border-white/80 
                                      text-white px-8 py-4 rounded-xl font-semibold 
                                      hover:bg-white hover:text-green-700 hover:border-white 
                                      transition-all duration-300 shadow-md hover:shadow-lg 
                                      text-center w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                                Découvrir les offres
                            </a>
                        </div>

                        <div class="flex items-center gap-8 pt-6 flex-wrap">
                            <div class="text-center">
                                <div class="text-3xl font-bold">2,500+</div>
                                <div class="text-sm text-green-100">Producteurs</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold">1,200+</div>
                                <div class="text-sm text-green-100">Consommateurs</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold">8,000+</div>
                                <div class="text-sm text-green-100">Échanges</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Illustration -->
                    <div class="hidden md:block">
                        <div class="relative">
                            <svg class="w-full h-auto" viewBox="0 0 500 400" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <!-- Farm landscape illustration -->
                                <circle cx="250" cy="200" r="180" fill="#81C784" opacity="0.2" />
                                <rect x="150" y="250" width="80" height="100" rx="8" fill="#F5F5DC" />
                                <rect x="160" y="260" width="30" height="40" rx="4" fill="#1B5E20"
                                    opacity="0.3" />
                                <polygon points="190,250 150,220 230,220" fill="#8B4513" />
                                <circle cx="350" cy="150" r="40" fill="#FFD700" opacity="0.8" />
                                <path d="M 100 320 Q 150 300 200 320 T 300 320 T 400 320" stroke="#81C784"
                                    stroke-width="3" fill="none" />
                                <circle cx="120" cy="300" r="15" fill="#4CAF50" />
                                <circle cx="140" cy="310" r="12" fill="#4CAF50" />
                                <circle cx="380" cy="290" r="18" fill="#4CAF50" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pourquoi Agrospace Section -->
        <section id="fonctionnalites" class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Pourquoi choisir Agrospace ?</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">Une plateforme conçue pour valoriser
                        l'agriculture locale et créer des opportunités durables</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 group">
                        <div
                            class="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Connexion humaine</h3>
                        <p class="text-gray-600 leading-relaxed">Mettez en relation producteurs et consommateurs
                            proches de vous pour des échanges authentiques et directs.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 group">
                        <div
                            class="bg-secondary/20 w-16 h-16 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Valorisation locale</h3>
                        <p class="text-gray-600 leading-relaxed">Donnez de la visibilité à vos produits et services
                            auprès d'une communauté engagée et locale.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 group">
                        <div
                            class="bg-accent w-16 h-16 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Opportunités durables</h3>
                        <p class="text-gray-600 leading-relaxed">Trouvez des partenaires, clients et projets locaux
                            pour développer votre activité de manière durable.</p>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <a href="#"
                        class="inline-block bg-primary text-white px-8 py-4 rounded-lg font-semibold hover:bg-green-800 transition-all shadow-lg hover:shadow-xl">
                        Explorer la communauté
                    </a>
                </div>
            </div>
        </section>

        <!-- Comment ça marche Section -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Comment fonctionne Agrospace ?</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">En trois étapes simples, commencez à valoriser
                        votre activité agricole</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 relative">
                    <!-- Step 1 -->
                    <div class="text-center relative">
                        <div
                            class="bg-gradient-to-br from-primary to-secondary w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                            <span class="text-3xl font-bold text-white">1</span>
                        </div>
                        <div
                            class="bg-gray-50 p-8 rounded-xl h-64 flex flex-col justify-center hover:shadow-lg transition-shadow">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Créez votre profil</h3>
                            <p class="text-gray-600">Inscrivez-vous en tant que Producteur ou Consommateur et complétez
                                votre profil en quelques clics.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center relative">
                        <div
                            class="bg-gradient-to-br from-primary to-secondary w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                            <span class="text-3xl font-bold text-white">2</span>
                        </div>
                        <div
                            class="bg-gray-50 p-8 rounded-xl h-64 flex flex-col justify-center hover:shadow-lg transition-shadow">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Publiez votre offre</h3>
                            <p class="text-gray-600">Partagez vos produits, services ou recherchez ce dont vous avez
                                besoin sur la plateforme.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center relative">
                        <div
                            class="bg-gradient-to-br from-primary to-secondary w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                            <span class="text-3xl font-bold text-white">3</span>
                        </div>
                        <div
                            class="bg-gray-50 p-8 rounded-xl h-64 flex flex-col justify-center hover:shadow-lg transition-shadow">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Échangez directement</h3>
                            <p class="text-gray-600">Utilisez la messagerie intégrée pour discuter et finaliser vos
                                collaborations en toute simplicité.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Témoignages Section -->
        <section id="temoignages" class="py-20 bg-gradient-to-br from-accent to-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Ils nous font confiance</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">Découvrez les histoires de réussite de notre
                        communauté</p>
                </div>

                <div class="max-w-4xl mx-auto" x-data="{
                    testimonials: [{
                            name: 'Marie Kouam',
                            role: 'Productrice Bio - Bafoussam',
                            text: 'Grâce à Agrospace, j\'ai trouvé un partenaire local en 3 jours ! Mes légumes bio sont maintenant distribués dans 5 restaurants de la région.',
                            avatar: '👩🏾‍🌾'
                        },
                        {
                            name: 'Jean Nkeng',
                            role: 'Restaurateur - Douala',
                            text: 'Enfin une plateforme qui me permet de m\'approvisionner directement auprès des producteurs locaux. La qualité est au rendez-vous et les prix sont justes.',
                            avatar: '👨🏾‍🍳'
                        },
                        {
                            name: 'Aïcha Mohamadou',
                            role: 'Coopérative d\'élevage - Maroua',
                            text: 'Nous avons multiplié nos ventes par 3 en 6 mois. Agrospace nous a permis d\'atteindre de nouveaux marchés et de valoriser nos produits laitiers.',
                            avatar: '👩🏾‍💼'
                        }
                    ],
                    currentIndex: 0
                }" x-init="setInterval(() => { currentIndex = (currentIndex + 1) % testimonials.length }, 5000)">

                    <div class="relative">
                        <template x-for="(testimonial, index) in testimonials" :key="index">
                            <div x-show="currentIndex === index" x-transition:enter="transition ease-out duration-500"
                                x-transition:enter-start="opacity-0 transform translate-x-8"
                                x-transition:enter-end="opacity-100 transform translate-x-0"
                                class="bg-white p-12 rounded-2xl shadow-2xl">
                                <div class="flex items-center mb-6">
                                    <div class="text-6xl mr-6" x-text="testimonial.avatar"></div>
                                    <div>
                                        <h4 class="text-xl font-bold text-gray-900" x-text="testimonial.name"></h4>
                                        <p class="text-primary font-medium" x-text="testimonial.role"></p>
                                    </div>
                                </div>
                                <p class="text-lg text-gray-700 leading-relaxed italic"
                                    x-text="'« ' + testimonial.text + ' »'"></p>
                            </div>
                        </template>

                        <!-- Navigation dots -->
                        <div class="flex justify-center gap-3 mt-8">
                            <template x-for="(testimonial, index) in testimonials" :key="index">
                                <button @click="currentIndex = index"
                                    :class="currentIndex === index ? 'bg-primary w-8' : 'bg-gray-300 w-3'"
                                    class="h-3 rounded-full transition-all duration-300"></button>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <a href="#"
                        class="inline-block bg-primary text-white px-8 py-4 rounded-lg font-semibold hover:bg-green-800 transition-all shadow-lg hover:shadow-xl">
                        Rejoindre la communauté
                    </a>
                </div>
            </div>
        </section>

        <!-- Blog Section -->
        <section id="blog" class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Les dernières actualités agricoles</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">Restez informé des tendances et innovations du
                        secteur</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Article 1 -->
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all group">
                        <div class="h-48 bg-gradient-to-br from-primary to-secondary"></div>
                        <div class="p-6">
                            <span class="text-sm text-primary font-semibold">🌱 Innovation</span>
                            <h3
                                class="text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-primary transition-colors">
                                L'agriculture digitale au Cameroun : une révolution en marche
                            </h3>
                            <p class="text-gray-600 mb-4">Découvrez comment la technologie transforme les pratiques
                                agricoles et crée de nouvelles opportunités...</p>
                            <a href="#"
                                class="text-primary font-semibold hover:underline inline-flex items-center">
                                Lire plus
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>

                    <!-- Article 2 -->
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all group">
                        <div class="h-48 bg-gradient-to-br from-secondary to-green-300"></div>
                        <div class="p-6">
                            <span class="text-sm text-primary font-semibold">🤝 Collaboration</span>
                            <h3
                                class="text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-primary transition-colors">
                                5 conseils pour réussir vos partenariats agropastoraux
                            </h3>
                            <p class="text-gray-600 mb-4">Les meilleures pratiques pour établir des relations durables
                                avec vos partenaires commerciaux...</p>
                            <a href="#"
                                class="text-primary font-semibold hover:underline inline-flex items-center">
                                Lire plus
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>

                    <!-- Article 3 -->
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all group">
                        <div class="h-48 bg-gradient-to-br from-green-600 to-primary"></div>
                        <div class="p-6">
                            <span class="text-sm text-primary font-semibold">📊 Économie</span>
                            <h3
                                class="text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-primary transition-colors">
                                Marchés agricoles 2025 : tendances et opportunités
                            </h3>
                            <p class="text-gray-600 mb-4">Analyse des perspectives économiques pour les producteurs et
                                les acteurs de la chaîne de valeur...</p>
                            <a href="#"
                                class="text-primary font-semibold hover:underline inline-flex items-center">
                                Lire plus
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>
                </div>

                <div class="text-center mt-12">
                    <a href="#"
                        class="inline-block border-2 border-primary text-primary px-8 py-4 rounded-lg font-semibold hover:bg-primary hover:text-white transition-all">
                        Voir tous les articles
                    </a>
                </div>
            </div>
        </section>

        <!-- CTA Final Section -->
        <section class="py-20 gradient-bg text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0"
                    style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                </div>
            </div>

            <div class="container mx-auto px-4 text-center relative z-10">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Rejoignez la communauté Agrospace dès aujourd'hui
                </h2>
                <p class="text-xl md:text-2xl text-green-50 mb-8 max-w-3xl mx-auto">
                    et valorisez vos activités agricoles au sein d'un écosystème durable et innovant
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="#"
                        class="bg-white text-primary px-10 py-5 rounded-lg font-bold text-lg hover:bg-accent transition-all shadow-2xl hover:scale-105">
                        Créer mon compte maintenant
                    </a>
                </div>
                <p class="text-sm text-green-100 mt-6">
                    ✓ C'est gratuit et ça prend moins d'une minute • ✓ Aucune carte bancaire requise
                </p>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-300 py-16">
            <div class="container mx-auto px-4">
                <div class="grid md:grid-cols-4 gap-12 mb-12">
                    <!-- Logo & Slogan -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-8 h-8 text-secondary" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18c-4 0-7-3-7-7V8.3l7-3.5 7 3.5V13c0 4-3 7-7 7z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <span class="text-2xl font-bold text-white">Agrospace</span>
                        </div>
                        <p class="text-gray-400 leading-relaxed">
                            Connecter les acteurs de l'agriculture pour un avenir durable et prospère.
                        </p>
                        <div class="flex space-x-4 pt-4">
                            <a href="#"
                                class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Liens rapides -->
                    <div>
                        <h4 class="text-white font-bold text-lg mb-4">Liens rapides</h4>
                        <ul class="space-y-3">
                            <li><a href="#accueil" class="hover:text-secondary transition-colors">Accueil</a></li>
                            <li><a href="#fonctionnalites"
                                    class="hover:text-secondary transition-colors">Fonctionnalités</a></li>
                            <li><a href="#temoignages" class="hover:text-secondary transition-colors">Témoignages</a>
                            </li>
                            <li><a href="#blog" class="hover:text-secondary transition-colors">Blog</a></li>
                            <li><a href="#" class="hover:text-secondary transition-colors">Contact</a></li>
                        </ul>
                    </div>

                    <!-- Ressources -->
                    <div>
                        <h4 class="text-white font-bold text-lg mb-4">Ressources</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="hover:text-secondary transition-colors">Centre d'aide</a>
                            </li>
                            <li><a href="#" class="hover:text-secondary transition-colors">Guide utilisateur</a>
                            </li>
                            <li><a href="#" class="hover:text-secondary transition-colors">Conditions
                                    d'utilisation</a></li>
                            <li><a href="#" class="hover:text-secondary transition-colors">Politique de
                                    confidentialité</a></li>
                            <li><a href="#" class="hover:text-secondary transition-colors">Mentions légales</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h4 class="text-white font-bold text-lg mb-4">Contact</h4>
                        <ul class="space-y-3">
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-secondary mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Bafoussam, Cameroun</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-secondary mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <a href="mailto:contact@agrospace.cm"
                                    class="hover:text-secondary transition-colors">contact@agrospace.cm</a>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-secondary mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>+237 6XX XX XX XX</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                    <p>© 2025 Agrospace – Tous droits réservés. Fait avec ❤️ pour l'agriculture africaine.</p>
                </div>
            </div>
        </footer>

        <!-- Scroll to top button -->
        <button x-data="{ showButton: false }" x-init="window.addEventListener('scroll', () => { showButton = window.pageYOffset > 300 })" x-show="showButton" x-cloak
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-8 right-8 bg-primary text-white w-12 h-12 rounded-full shadow-2xl hover:bg-green-800 transition-all hover:scale-110 flex items-center justify-center z-40">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </button>

    </body>
</div>
