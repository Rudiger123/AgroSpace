<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.main')] class extends Component {
    //
}; ?>

<div>
    <!-- Header -->
    <x-layouts.header />

    <!-- Hero Section -->
    <section id="blog-hero" class="relative pt-24 pb-20 md:pt-32 md:pb-28 overflow-hidden gradient-bg">
        <!-- Background SVG pattern -->
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div class="absolute inset-0"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.2\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>
        </div>

        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-white space-y-6 animate-fade-in-up">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        Connecter, Valoriser, Collaborer pour un monde agropastoral durable
                    </h1>
                    <p class="text-xl text-gray-50 mb-8">
                        Agrospace est la première plateforme qui relie les producteurs et consommateurs agricoles pour
                        créer un réseau collaboratif et local.
                    </p>
                    <a href="#"
                        class="inline-flex items-center gap-2 bg-white text-primary font-semibold px-8 py-4 rounded-lg 
                           shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 
                           hover:bg-gradient-to-r hover:from-green-500 hover:to-emerald-500 hover:text-white 
                           focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-offset-2">
                        <!-- SVG communauté -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m3-4a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                        Rejoindre la communauté
                    </a>

                </div>

                <!-- Right Illustration -->
                <div class="relative">
                    <div class="bg-gradient-to-br from-green-400 to-emerald-600 rounded-3xl p-8 shadow-2xl">
                        <svg class="w-full h-auto text-white" viewBox="0 0 400 300" fill="none">
                            <circle cx="200" cy="150" r="100" fill="currentColor" opacity="0.2" />
                            <path d="M150 150 L200 100 L250 150 L200 200 Z" fill="currentColor" opacity="0.3" />
                            <circle cx="150" cy="150" r="40" fill="currentColor" />
                            <circle cx="250" cy="150" r="40" fill="currentColor" />
                            <circle cx="200" cy="100" r="40" fill="currentColor" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Mission & Vision -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12">
                <div class="bg-[#F9FAF6] p-10 rounded-2xl">
                    <div class="w-16 h-16 bg-[#1B5E20] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Notre Mission</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Faciliter les échanges entre acteurs agricoles et valoriser la production locale grâce au
                        numérique. Nous créons des ponts entre ceux qui produisent et ceux qui consomment.
                    </p>
                </div>

                <div class="bg-emerald-50 p-10 rounded-2xl">
                    <div class="w-16 h-16 bg-[#81C784] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Notre Vision</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Devenir la référence africaine de la collaboration agropastorale et de la transformation
                        numérique du secteur. Un avenir où chaque acteur trouve sa place.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Nos Valeurs -->
    <section class="py-20 bg-[#F9FAF6]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Nos valeurs fondamentales</h2>
                <p class="text-xl text-gray-600">Les principes qui guident chacune de nos actions</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Valeur 1 -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="text-5xl mb-4">🌿</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Durabilité</h3>
                    <p class="text-gray-600">
                        Promouvoir une agriculture responsable et respectueuse de la nature pour les générations
                        futures.
                    </p>
                </div>

                <!-- Valeur 2 -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="text-5xl mb-4">🤝</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Collaboration</h3>
                    <p class="text-gray-600">
                        Créer des ponts entre producteurs et consommateurs pour renforcer l'écosystème agricole.
                    </p>
                </div>

                <!-- Valeur 3 -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="text-5xl mb-4">💡</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Innovation</h3>
                    <p class="text-gray-600">
                        Utiliser le numérique pour moderniser et faciliter les échanges dans le secteur agropastoral.
                    </p>
                </div>

                <!-- Valeur 4 -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="text-5xl mb-4">❤️</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Confiance</h3>
                    <p class="text-gray-600">
                        Garantir un espace sûr, authentique et humain où chaque membre se sent valorisé.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Notre Histoire -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">L'histoire d'Agrospace</h2>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        Né de la passion pour l'agriculture et l'innovation, Agrospace est un projet créé pour résoudre
                        un problème majeur : le manque de visibilité et de communication entre les acteurs du monde
                        agricole.
                    </p>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        Nous avons constaté que de nombreux producteurs talentueux restaient invisibles, tandis que des
                        consommateurs cherchaient désespérément des sources locales et fiables. Cette déconnexion nous a
                        motivés à créer une solution.
                    </p>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Aujourd'hui, nous construisons un réseau où les producteurs et les consommateurs peuvent
                        échanger, collaborer et croître ensemble. Agrospace, c'est le LinkedIn de l'agriculture
                        africaine.
                    </p>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-emerald-100 to-green-200 rounded-3xl p-8 shadow-xl">
                        <svg class="w-full h-auto text-[#1B5E20]" viewBox="0 0 400 400" fill="none">
                            <rect x="50" y="150" width="100" height="200" fill="currentColor" opacity="0.3"
                                rx="10" />
                            <rect x="250" y="100" width="100" height="250" fill="currentColor" opacity="0.5"
                                rx="10" />
                            <circle cx="200" cy="200" r="80" fill="currentColor" opacity="0.4" />
                            <path d="M100 250 Q200 200 300 250" stroke="currentColor" stroke-width="4"
                                fill="none" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- L'Équipe -->
    <section class="py-20 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Une équipe engagée pour un avenir vert 🌍</h2>
                <p class="text-xl text-gray-600">Des passionnés au service de l'agriculture durable</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Membre 1 -->
                <div
                    class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                    <div class="h-48 bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center">
                        <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center text-6xl">
                            👨‍💼
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Feutsop Rüdiger</h3>
                        <p class="text-[#1B5E20] font-semibold mb-4">Fondateur & Développeur principal</p>
                        <p class="text-gray-600">
                            Passionné par l'innovation technologique et l'agriculture, Rüdiger a créé Agrospace pour
                            transformer le secteur agricole africain grâce au numérique.
                        </p>
                    </div>
                </div>

                <!-- Membre 2 -->
                <div
                    class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                    <div class="h-48 bg-gradient-to-br from-emerald-400 to-green-600 flex items-center justify-center">
                        <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center text-6xl">
                            👩‍💼
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Marie Kouam</h3>
                        <p class="text-[#1B5E20] font-semibold mb-4">Responsable Communauté</p>
                        <p class="text-gray-600">
                            Experte en engagement communautaire, Marie veille à ce que chaque membre d'Agrospace trouve
                            sa place et crée des connexions authentiques.
                        </p>
                    </div>
                </div>

                <!-- Membre 3 -->
                <div
                    class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                    <div class="h-48 bg-gradient-to-br from-green-500 to-emerald-700 flex items-center justify-center">
                        <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center text-6xl">
                            👨‍🌾
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Jean Nkoulou</h3>
                        <p class="text-[#1B5E20] font-semibold mb-4">Expert Agropastoral</p>
                        <p class="text-gray-600">
                            Avec 15 ans d'expérience dans le secteur agricole, Jean apporte son expertise pour garantir
                            la pertinence et l'utilité de notre plateforme.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact & Chiffres -->
    <section class="py-20 bg-gradient-to-br from-emerald-50 to-green-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Notre impact en quelques chiffres</h2>
                <p class="text-xl text-gray-600">Des résultats concrets qui témoignent de notre engagement</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Chiffre 1 -->
                <div class="bg-white p-8 rounded-2xl text-center shadow-lg">
                    <div class="text-5xl mb-4">👥</div>
                    <div class="text-4xl font-bold text-[#1B5E20] mb-2">+500</div>
                    <p class="text-gray-600 font-medium">Utilisateurs inscrits</p>
                </div>

                <!-- Chiffre 2 -->
                <div class="bg-white p-8 rounded-2xl text-center shadow-lg">
                    <div class="text-5xl mb-4">🤝</div>
                    <div class="text-4xl font-bold text-[#1B5E20] mb-2">+120</div>
                    <p class="text-gray-600 font-medium">Connexions créées</p>
                </div>

                <!-- Chiffre 3 -->
                <div class="bg-white p-8 rounded-2xl text-center shadow-lg">
                    <div class="text-5xl mb-4">📍</div>
                    <div class="text-4xl font-bold text-[#1B5E20] mb-2">+30</div>
                    <p class="text-gray-600 font-medium">Régions couvertes</p>
                </div>

                <!-- Chiffre 4 -->
                <div class="bg-white p-8 rounded-2xl text-center shadow-lg">
                    <div class="text-5xl mb-4">📢</div>
                    <div class="text-4xl font-bold text-[#1B5E20] mb-2">+100</div>
                    <p class="text-gray-600 font-medium">Offres publiées/mois</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 bg-gradient-to-r from-[#1B5E20] to-green-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">
                Rejoignez la communauté Agrospace dès aujourd'hui
            </h2>
            <p class="text-xl text-green-50 mb-8">
                Contribuez à l'avenir durable de l'agriculture africaine et créez des connexions qui comptent vraiment.
            </p>
            <a href="/inscription"
                class="inline-block bg-white text-[#1B5E20] px-10 py-4 rounded-xl font-bold hover:bg-gray-100 transition shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                Créer un compte gratuitement
            </a>
            <p class="text-green-100 mt-4 text-sm">C'est rapide, simple et gratuit.</p>
        </div>
    </section>

    <x-layouts.footer />

</div>
