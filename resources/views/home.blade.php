<x-app-main>

    <div class="bg-[#F5F5DC] text-[#37474F]" style="font-family: 'Inter', sans-serif;">

   

        {{-- Hero Section avec parallax et animations --}}
        <section x-data="{
            show: false,
            init() {
                setTimeout(() => { this.show = true }, 100)
            }
        }"
            class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-[#2E7D32] via-[#388E3C] to-[#1B5E20]">
            {{-- Effet de fond animé --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-[#FFB300] rounded-full blur-3xl animate-pulse"
                    style="animation-delay: 1s;"></div>
            </div>
    
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                {{-- Titre principal avec animation fade-in --}}
                <h1 x-show="show" x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6"
                    style="font-family: 'Poppins', sans-serif;">
                    Connectons les acteurs du<br>monde agropastoral
                </h1>
    
                {{-- Sous-titre avec délai --}}
                <p x-show="show" x-transition:enter="transition ease-out duration-1000 delay-300"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="text-lg sm:text-xl md:text-2xl text-white/90 mb-12 max-w-3xl mx-auto"
                    style="font-family: 'Inter', sans-serif;">
                    Découvrez les offres et demandes agricoles près de chez vous
                </p>
    
                {{-- CTA Button avec animation hover avancée --}}
                <div x-show="show" x-transition:enter="transition ease-out duration-1000 delay-600"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0">
                    <a href="#offers"
                        class="inline-block bg-[#FFB300] text-[#37474F] px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-[#2E7D32] transition-all duration-300 transform hover:scale-105 hover:shadow-2xl"
                        style="font-family: 'Inter', sans-serif;">
                        Explorer maintenant
                        <svg class="inline-block ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
    
                {{-- Scroll indicator --}}
                <div x-show="show" x-transition:enter="transition ease-out duration-1000 delay-1000"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
            </div>
        </section>
    
        {{-- Section Dernières Offres --}}
        <section id="offers" x-data="{
            currentSlide: 0,
            offers: [
                { id: 1, title: 'Vente de semences de maïs', description: 'Semences certifiées, haut rendement, adaptées au climat tropical' },
                { id: 2, title: 'Location de tracteur', description: 'Tracteur moderne disponible pour labour et semis' },
                { id: 3, title: 'Engrais biologiques', description: 'Compost et engrais naturels, production locale' },
                { id: 4, title: 'Formation en agriculture', description: 'Sessions de formation sur les techniques modernes' },
                { id: 5, title: 'Système d\'irrigation', description: 'Installation complète de système goutte à goutte' },
                { id: 6, title: 'Plants de tomates', description: 'Variétés résistantes et productives' }
            ],
            autoPlay: null,
            init() {
                this.autoPlay = setInterval(() => {
                    this.next()
                }, 4000)
            },
            next() {
                this.currentSlide = (this.currentSlide + 1) % this.offers.length
            },
            prev() {
                this.currentSlide = this.currentSlide === 0 ? this.offers.length - 1 : this.currentSlide - 1
            },
            visibleOffers() {
                let visible = []
                for (let i = 0; i < 3; i++) {
                    visible.push(this.offers[(this.currentSlide + i) % this.offers.length])
                }
                return visible
            }
        }" x-intersect="$el.classList.add('animate-fade-in-up')"
            class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Titre de section --}}
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#2E7D32] mb-4"
                        style="font-family: 'Poppins', sans-serif;">
                        Dernières Offres
                    </h2>
                    <p class="text-lg text-[#37474F]/80 max-w-2xl mx-auto">
                        Découvrez les opportunités proposées par notre communauté
                    </p>
                </div>
    
                {{-- Carrousel d'offres --}}
                <div class="relative">
                    {{-- Bouton Précédent --}}
                    <button @click="prev(); clearInterval(autoPlay)"
                        class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 bg-white rounded-full p-3 shadow-lg hover:bg-[#2E7D32] hover:text-white transition-all duration-300 transform hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>
    
                    {{-- Grille de cartes --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <template x-for="(offer, index) in visibleOffers()" :key="offer.id">
                            <div class="bg-[#F5F5DC] rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 cursor-pointer"
                                x-transition:enter="transition ease-out duration-500"
                                x-transition:enter-start="opacity-0 transform translate-x-8"
                                x-transition:enter-end="opacity-100 transform translate-x-0">
                                {{-- Image placeholder --}}
                                <div
                                    class="h-48 bg-gradient-to-br from-[#2E7D32] to-[#66BB6A] flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white/30" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
    
                                {{-- Contenu --}}
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-[#2E7D32] mb-3"
                                        style="font-family: 'Poppins', sans-serif;" x-text="offer.title"></h3>
                                    <p class="text-[#37474F]/80 mb-4 line-clamp-2" x-text="offer.description"></p>
                                    <button
                                        class="bg-[#2E7D32] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#FFB300] hover:text-[#37474F] transition-all duration-300 transform hover:scale-105">
                                        Voir plus
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
    
                    {{-- Bouton Suivant --}}
                    <button @click="next(); clearInterval(autoPlay)"
                        class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 bg-white rounded-full p-3 shadow-lg hover:bg-[#2E7D32] hover:text-white transition-all duration-300 transform hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
    
                {{-- Indicateurs --}}
                <div class="flex justify-center gap-2 mt-8">
                    <template x-for="(offer, index) in offers" :key="index">
                        <button @click="currentSlide = index; clearInterval(autoPlay)"
                            :class="currentSlide === index ? 'bg-[#2E7D32] w-8' : 'bg-gray-300 w-2'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                    </template>
                </div>
            </div>
        </section>
    
        {{-- Section Dernières Demandes --}}
        <section x-data="{
            demands: [
                { id: 1, title: 'Recherche fertilisant organique', description: 'Pour exploitation de 5 hectares, livraison souhaitée' },
                { id: 2, title: 'Besoin tracteur pour labour', description: 'Terrain de 10 hectares, intervention urgente' },
                { id: 3, title: 'Formation en irrigation', description: 'Pour équipe de 5 personnes, disponible weekends' },
                { id: 4, title: 'Achat semences riz', description: 'Variété locale résistante, quantité: 500kg' }
            ]
        }" x-intersect="$el.classList.add('animate-fade-in-up')"
            class="py-20 bg-[#F5F5DC]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Titre de section --}}
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#2E7D32] mb-4"
                        style="font-family: 'Poppins', sans-serif;">
                        Dernières Demandes
                    </h2>
                    <p class="text-lg text-[#37474F]/80 max-w-2xl mx-auto">
                        Répondez aux besoins de la communauté agropastorale
                    </p>
                </div>
    
                {{-- Grille de demandes --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                    <template x-for="demand in demands" :key="demand.id">
                        <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 cursor-pointer border-t-4 border-[#FFB300]"
                            x-intersect="$el.classList.add('animate-slide-up')">
                            {{-- Badge --}}
                            <div class="bg-[#FFB300] text-[#37474F] px-4 py-2 text-xs font-semibold">
                                DEMANDE ACTIVE
                            </div>
    
                            {{-- Contenu --}}
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-[#37474F] mb-3"
                                    style="font-family: 'Poppins', sans-serif;" x-text="demand.title"></h3>
                                <p class="text-[#37474F]/70 mb-4 text-sm line-clamp-3" x-text="demand.description"></p>
                                <button
                                    class="w-full bg-[#FFB300] text-[#37474F] px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#2E7D32] hover:text-white transition-all duration-300 transform hover:scale-105">
                                    Répondre
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
    
                {{-- CTA Global --}}
                <div class="text-center">
                    <a href="/demands/create"
                        class="inline-block bg-[#2E7D32] text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-[#FFB300] hover:text-[#37474F] transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Publier une demande
                        <svg class="inline-block ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    
        {{-- Section Rejoindre la Communauté --}}
        <section x-data="{ pulse: true }" x-intersect="$el.classList.add('animate-fade-in')"
            class="py-24 bg-gradient-to-r from-[#2E7D32] via-[#388E3C] to-[#1B5E20] relative overflow-hidden">
            {{-- Effet de fond animé --}}
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-10 right-10 w-64 h-64 bg-[#FFB300] rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-10 left-10 w-80 h-80 bg-white rounded-full blur-3xl animate-pulse"
                    style="animation-delay: 1.5s;"></div>
            </div>
    
            <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-6"
                    style="font-family: 'Poppins', sans-serif;">
                    Rejoignez la Communauté Agrospace
                </h2>
                <p class="text-xl text-white/90 mb-10 max-w-2xl mx-auto">
                    Faites partie du réseau et connectez-vous à d'autres acteurs du secteur agropastoral pour développer
                    ensemble une agriculture durable.
                </p>
                <a href="/register" :class="pulse ? 'animate-pulse' : ''" @mouseenter="pulse = false"
                    @mouseleave="pulse = true"
                    class="inline-block bg-[#FFB300] text-[#37474F] px-10 py-5 rounded-lg text-xl font-bold hover:bg-white transition-all duration-300 transform hover:scale-110 shadow-2xl"
                    style="font-family: 'Inter', sans-serif;">
                    Rejoindre maintenant
                    <svg class="inline-block ml-2 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </section>
    
        {{-- Footer --}}
        <footer class="bg-[#1B5E20] text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    {{-- Colonne 1: Logo et description --}}
                    <div>
                        <h3 class="text-2xl font-bold mb-4" style="font-family: 'Poppins', sans-serif;">
                            Agrospace
                        </h3>
                        <p class="text-white/80">
                            La plateforme qui connecte les acteurs du monde agropastoral pour un développement durable et
                            collaboratif.
                        </p>
                    </div>
    
                    {{-- Colonne 2: Liens rapides --}}
                    <div>
                        <h4 class="text-lg font-semibold mb-4" style="font-family: 'Poppins', sans-serif;">
                            Liens rapides
                        </h4>
                        <ul class="space-y-2">
                            <li><a href="/about"
                                    class="text-white/80 hover:text-[#FFB300] transition-colors duration-200">À propos</a>
                            </li>
                            <li><a href="/contact"
                                    class="text-white/80 hover:text-[#FFB300] transition-colors duration-200">Contact</a>
                            </li>
                            <li><a href="/terms"
                                    class="text-white/80 hover:text-[#FFB300] transition-colors duration-200">Conditions
                                    d'utilisation</a></li>
                            <li><a href="/privacy"
                                    class="text-white/80 hover:text-[#FFB300] transition-colors duration-200">Politique de
                                    confidentialité</a></li>
                        </ul>
                    </div>
    
                    {{-- Colonne 3: Réseaux sociaux --}}
                    <div>
                        <h4 class="text-lg font-semibold mb-4" style="font-family: 'Poppins', sans-serif;">
                            Suivez-nous
                        </h4>
                        <div class="flex space-x-4">
                            <a href="#"
                                class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#FFB300] transition-all duration-300 transform hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#FFB300] transition-all duration-300 transform hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#FFB300] transition-all duration-300 transform hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#FFB300] transition-all duration-300 transform hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
    
                {{-- Ligne de séparation --}}
                <div class="border-t border-white/20 pt-8">
                    <p class="text-center text-white/70 text-sm">
                        &copy; {{ date('Y') }} Agrospace. Tous droits réservés. Développé avec ❤️ pour l'agriculture
                        durable.
                    </p>
                </div>
            </div>
        </footer>
    
        @livewireScripts
    
        {{-- Styles personnalisés pour les animations --}}
        <style>
            @keyframes fade-in-up {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
    
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
    
            @keyframes slide-up {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
    
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
    
            @keyframes fade-in {
                from {
                    opacity: 0;
                }
    
                to {
                    opacity: 1;
                }
            }
    
            .animate-fade-in-up {
                animation: fade-in-up 0.8s ease-out forwards;
            }
    
            .animate-slide-up {
                animation: slide-up 0.6s ease-out forwards;
            }
    
            .animate-fade-in {
                animation: fade-in 1s ease-out forwards;
            }
    
            /* Smooth scroll */
            html {
                scroll-behavior: smooth;
            }
    
            /* Line clamp utility */
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
    
            .line-clamp-3 {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>
    </div>
    

</x-app-main>