<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.main')] class extends Component {
    //
}; ?>
<div>

    <div x-data="{ testimonialIndex: 0 }">

        <x-layouts.header />

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
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <x-layouts.footer />


        <!-- Scroll to top button -->
        <button x-data="{ showButton: false }" x-init="window.addEventListener('scroll', () => { showButton = window.pageYOffset > 300 })" x-show="showButton" x-cloak
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-8 right-8 bg-primary text-white w-12 h-12 rounded-full shadow-2xl hover:bg-green-800 transition-all hover:scale-110 flex items-center justify-center z-40">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </button>

    </div>
</div>
