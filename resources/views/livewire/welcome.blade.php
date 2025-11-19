<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Helpers\SEO;

new #[Layout('layouts.main')] class extends Component {
    public function mount()
    {
        // Set SEO meta tags dynamically
        SEO::setTitle('AgroSpace - Plateforme Agricole Cameroun | Connecte Producteurs & Consommateurs');
        SEO::setDescription('Plateforme #1 au Cameroun pour connecter producteurs et consommateurs agricoles. Trouvez des offres locales, créez des partenariats durables. Inscription gratuite !');
        SEO::setKeywords('agriculture cameroun, producteur agricole, marché local, agrospace, vente directe producteur, agriculture durable afrique');
        SEO::setCanonical(url()->current());
        SEO::addImages([asset('images/agrospace.png')]);
    }
}; ?>

@push('meta')
    {{-- Primary Meta Tags --}}
    <title>AgroSpace - Plateforme Agricole au Cameroun | Connectez Producteurs et Consommateurs Locaux</title>
    <meta name="title" content="AgroSpace - Plateforme Agricole au Cameroun | Producteurs & Consommateurs">
    <meta name="description"
        content="Rejoignez AgroSpace, la plateforme n°1 au Cameroun pour connecter producteurs agricoles et consommateurs locaux. +2500 producteurs, +8000 échanges. Inscription gratuite !">
    <meta name="keywords"
        content="agriculture cameroun, producteur agricole cameroun, marché agricole local, agrospace, vente directe producteur, consommateur local, agriculture durable afrique, agropastoral cameroun, plateforme agricole">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="language" content="fr">
    <meta name="author" content="AgroSpace">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="AgroSpace - Plateforme Agricole #1 au Cameroun">
    <meta property="og:description"
        content="Connectez producteurs et consommateurs agricoles locaux. +2500 producteurs, +1200 consommateurs, +8000 échanges. Rejoignez-nous gratuitement !">
    <meta property="og:image" content="{{ asset('images/agrospace.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="AgroSpace">
    <meta property="og:locale" content="fr_CM">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="AgroSpace - Plateforme Agricole au Cameroun">
    <meta name="twitter:description"
        content="Rejoignez +2500 producteurs et +1200 consommateurs sur AgroSpace. Créez des partenariats agricoles durables au Cameroun.">
    <meta name="twitter:image" content="{{ asset('images/agrospace.png') }}">

    {{-- Additional SEO Meta --}}
    <meta name="geo.region" content="CM">
    <meta name="geo.placename" content="Cameroun">
    <meta name="geo.position" content="3.848;11.5021">
    <meta name="ICBM" content="3.848, 11.5021">
@endpush

<div>
    {{-- SEO: Breadcrumb Navigation --}}
    <nav aria-label="Fil d'Ariane" class="hidden">
        <ol itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="{{ url('/') }}">
                    <span itemprop="name">Accueil</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>
        </ol>
    </nav>

    <div x-data="{ testimonialIndex: 0 }">

        <x-layouts.header />

        {{-- Hero Section - Optimized for SEO --}}
        <section id="accueil" class="relative pt-24 pb-20 md:pt-32 md:pb-28 overflow-hidden gradient-bg" itemscope
            itemtype="https://schema.org/WPHeader">
            <div class="absolute inset-0 opacity-10 pointer-events-none" aria-hidden="true">
                <div class="absolute inset-0"
                    style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                </div>
            </div>

            <div class="container mx-auto px-4">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    {{-- Left Content --}}
                    <div class="text-white space-y-6 animate-fade-in-up">
                        {{-- SEO: Main H1 with primary keywords --}}
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                            Plateforme Agricole au Cameroun : Connectez <span class="text-secondary">Producteurs</span>
                            et <span class="text-secondary">Consommateurs</span> Locaux
                        </h1>

                        {{-- SEO: Descriptive subtitle --}}
                        <p class="text-lg md:text-xl text-green-50 leading-relaxed">
                            Découvrez, échangez et collaborez dans un écosystème agropastoral durable.
                            Plus de 2500 producteurs agricoles et 1200 consommateurs actifs au Cameroun.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            {{-- SEO: CTA with descriptive links --}}
                            <a href="{{ route('register') }}"
                                title="Créer un compte gratuit sur AgroSpace - Inscription producteur ou consommateur"
                                class="flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-emerald-500 
                                      text-white px-8 py-4 rounded-xl font-semibold 
                                      hover:from-green-700 hover:to-emerald-600 hover:scale-[1.03]
                                      transition-all duration-300 shadow-lg hover:shadow-2xl 
                                      text-center w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Créer mon compte gratuitement
                            </a>

                            <a href="{{ route('offers-list') }}"
                                title="Découvrir les offres agricoles disponibles au Cameroun"
                                class="flex items-center justify-center gap-2 bg-transparent border-2 border-white/80 
                                      text-white px-8 py-4 rounded-xl font-semibold 
                                      hover:bg-white hover:text-green-700 hover:border-white 
                                      transition-all duration-300 shadow-md hover:shadow-lg 
                                      text-center w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                                Découvrir les offres agricoles
                            </a>
                        </div>

                        {{-- SEO: Statistics with semantic markup --}}
                        <div class="flex items-center gap-8 pt-6 flex-wrap" role="region"
                            aria-label="Statistiques AgroSpace">
                            <div class="text-center" itemscope itemtype="https://schema.org/Number">
                                <div class="text-3xl font-bold" itemprop="value">2,500+</div>
                                <div class="text-sm text-green-100">Producteurs Agricoles</div>
                            </div>
                            <div class="text-center" itemscope itemtype="https://schema.org/Number">
                                <div class="text-3xl font-bold" itemprop="value">1,200+</div>
                                <div class="text-sm text-green-100">Consommateurs Locaux</div>
                            </div>
                            <div class="text-center" itemscope itemtype="https://schema.org/Number">
                                <div class="text-3xl font-bold" itemprop="value">8,000+</div>
                                <div class="text-sm text-green-100">Échanges Réalisés</div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Illustration --}}
                    <div class="hidden md:block">
                        <div class="relative">
                            {{-- <img src="{{ asset('images/hero/hero.png') }}"
                                alt="Illustration agriculture au Cameroun - Producteurs et consommateurs locaux sur AgroSpace"
                                width="400" height="300" class="w-full h-auto rounded-xl" loading="eager" />
                            --}}
                            <!-- Right Illustration -->
                            <div class="hidden md:block">
                                <div class="relative">
                                    <svg class="w-full h-auto" viewBox="0 0 500 400" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <!-- Farm landscape illustration -->
                                        <circle cx="250" cy="200" r="180" fill="#81C784"
                                            opacity="0.2" />
                                        <rect x="150" y="250" width="80" height="100" rx="8"
                                            fill="#F5F5DC" />
                                        <rect x="160" y="260" width="30" height="40" rx="4"
                                            fill="#1B5E20" opacity="0.3" />
                                        <polygon points="190,250 150,220 230,220" fill="#8B4513" />
                                        <circle cx="350" cy="150" r="40" fill="#FFD700"
                                            opacity="0.8" />
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
                </div>
            </div>
        </section>

        {{-- Features Section - SEO Optimized --}}
        <section id="fonctionnalites" class="py-20 bg-gray-50" itemscope itemtype="https://schema.org/ItemList">
            <div class="container mx-auto px-4">
                <header class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Pourquoi Choisir AgroSpace pour vos Échanges Agricoles au Cameroun ?
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Une plateforme conçue pour valoriser l'agriculture locale et créer des opportunités commerciales
                        durables entre producteurs et consommateurs
                    </p>
                </header>

                <div class="grid md:grid-cols-3 gap-8">
                    {{-- Feature 1 --}}
                    <article
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 group"
                        itemprop="itemListElement" itemscope itemtype="https://schema.org/Service">
                        <div class="bg-base/10 w-16 h-16 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform"
                            aria-hidden="true">
                            <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4" itemprop="name">
                            Connexion Directe Producteur-Consommateur
                        </h3>
                        <p class="text-gray-600 leading-relaxed" itemprop="description">
                            Mettez en relation producteurs et consommateurs proches de vous pour des échanges
                            authentiques et directs.
                            Éliminez les intermédiaires et établissez des partenariats commerciaux durables.
                        </p>
                    </article>

                    {{-- Feature 2 --}}
                    <article
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 group"
                        itemprop="itemListElement" itemscope itemtype="https://schema.org/Service">
                        <div class="bg-secondary/20 w-16 h-16 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform"
                            aria-hidden="true">
                            <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4" itemprop="name">
                            Valorisation des Produits Agricoles Locaux
                        </h3>
                        <p class="text-gray-600 leading-relaxed" itemprop="description">
                            Donnez de la visibilité à vos produits et services agricoles auprès d'une communauté
                            engagée.
                            Touchez des milliers de consommateurs locaux intéressés par l'agriculture camerounaise.
                        </p>
                    </article>

                    {{-- Feature 3 --}}
                    <article
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 group"
                        itemprop="itemListElement" itemscope itemtype="https://schema.org/Service">
                        <div class="bg-accent w-16 h-16 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform"
                            aria-hidden="true">
                            <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4" itemprop="name">
                            Opportunités Commerciales Durables
                        </h3>
                        <p class="text-gray-600 leading-relaxed" itemprop="description">
                            Trouvez des partenaires commerciaux, clients et projets locaux pour développer votre
                            activité agricole.
                            Accédez à un réseau de professionnels qualifiés dans tout le Cameroun.
                        </p>
                    </article>
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('register') }}"
                        title="Rejoindre la communauté AgroSpace - Producteurs et consommateurs agricoles"
                        class="inline-block bg-base text-white px-8 py-4 rounded-lg font-semibold hover:bg-green-800 transition-all shadow-lg hover:shadow-xl">
                        Explorer la communauté agricole
                    </a>
                </div>
            </div>
        </section>

        {{-- How It Works Section --}}
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <header class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Comment Fonctionne AgroSpace ? Guide Complet
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        En trois étapes simples, commencez à valoriser votre activité agricole et créez des partenariats
                        commerciaux au Cameroun
                    </p>
                </header>

                <div class="grid md:grid-cols-3 gap-8 relative">
                    {{-- Step 1 --}}
                    <article class="text-center relative">
                        <div class="bg-gradient-to-br from-base to-secondary w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl"
                            aria-label="Étape 1">
                            <span class="text-3xl font-bold text-white">1</span>
                        </div>
                        <div
                            class="bg-gray-50 p-8 rounded-xl h-64 flex flex-col justify-center hover:shadow-lg transition-shadow">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">
                                Créez Votre Profil Producteur ou Consommateur
                            </h3>
                            <p class="text-gray-600">
                                Inscrivez-vous gratuitement en tant que Producteur Agricole ou Consommateur Local.
                                Complétez votre profil professionnel en quelques clics et accédez à toutes les
                                fonctionnalités.
                            </p>
                        </div>
                    </article>

                    {{-- Step 2 --}}
                    <article class="text-center relative">
                        <div class="bg-gradient-to-br from-base to-secondary w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl"
                            aria-label="Étape 2">
                            <span class="text-3xl font-bold text-white">2</span>
                        </div>
                        <div
                            class="bg-gray-50 p-8 rounded-xl h-64 flex flex-col justify-center hover:shadow-lg transition-shadow">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">
                                Publiez vos Offres ou Demandes Agricoles
                            </h3>
                            <p class="text-gray-600">
                                Partagez vos produits agricoles, services ou recherchez ce dont vous avez besoin.
                                Ajoutez photos, descriptions détaillées et prix pour attirer les bons partenaires.
                            </p>
                        </div>
                    </article>

                    {{-- Step 3 --}}
                    <article class="text-center relative">
                        <div class="bg-gradient-to-br from-base to-secondary w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl"
                            aria-label="Étape 3">
                            <span class="text-3xl font-bold text-white">3</span>
                        </div>
                        <div
                            class="bg-gray-50 p-8 rounded-xl h-64 flex flex-col justify-center hover:shadow-lg transition-shadow">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">
                                Échangez Directement et Finalisez vos Transactions
                            </h3>
                            <p class="text-gray-600">
                                Utilisez la messagerie sécurisée intégrée pour discuter, négocier et finaliser vos
                                collaborations commerciales en toute simplicité.
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        {{-- Testimonials Section with Rich Snippets --}}
        <section id="temoignages" class="py-20 bg-gradient-to-br from-accent to-white" itemscope
            itemtype="https://schema.org/ReviewAction">
            <div class="container mx-auto px-4">
                <header class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Témoignages : Producteurs et Consommateurs Satisfaits
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Découvrez les histoires de réussite de notre communauté agricole camerounaise
                    </p>
                </header>

                <div class="max-w-4xl mx-auto" x-data="{
                    testimonials: [{
                            name: 'Marie Kouam',
                            role: 'Productrice Bio - Bafoussam',
                            text: 'Grâce à Agrospace, j\'ai trouvé un partenaire local en 3 jours ! Mes légumes bio sont maintenant distribués dans 5 restaurants de la région.',
                            avatar: '👩🏾‍🌾',
                            rating: 5
                        },
                        {
                            name: 'Jean Nkeng',
                            role: 'Restaurateur - Douala',
                            text: 'Enfin une plateforme qui me permet de m\'approvisionner directement auprès des producteurs locaux. La qualité est au rendez-vous et les prix sont justes.',
                            avatar: '👨🏾‍🍳',
                            rating: 5
                        },
                        {
                            name: 'Aïcha Mohamadou',
                            role: 'Coopérative d\'élevage - Maroua',
                            text: 'Nous avons multiplié nos ventes par 3 en 6 mois. Agrospace nous a permis d\'atteindre de nouveaux marchés et de valoriser nos produits laitiers.',
                            avatar: '👩🏾‍💼',
                            rating: 5
                        }
                    ],
                    currentIndex: 0
                }" x-init="setInterval(() => { currentIndex = (currentIndex + 1) % testimonials.length }, 5000)">

                    <div class="relative">
                        <template x-for="(testimonial, index) in testimonials" :key="index">
                            <div x-show="currentIndex === index" x-transition:enter="transition ease-out duration-500"
                                x-transition:enter-start="opacity-0 transform translate-x-8"
                                x-transition:enter-end="opacity-100 transform translate-x-0"
                                class="bg-white p-12 rounded-2xl shadow-2xl" itemscope
                                itemtype="https://schema.org/Review">
                                <div class="flex items-center mb-6">
                                    <div class="text-6xl mr-6" x-text="testimonial.avatar" aria-hidden="true"></div>
                                    <div>
                                        <h4 class="text-xl font-bold text-gray-900" x-text="testimonial.name"
                                            itemprop="author"></h4>
                                        <p class="text-base font-medium" x-text="testimonial.role"></p>
                                        <div class="flex items-center mt-2" itemprop="reviewRating" itemscope
                                            itemtype="https://schema.org/Rating">
                                            <template x-for="i in 5" :key="i">
                                                <svg class="w-5 h-5"
                                                    :class="i <= testimonial.rating ? 'text-yellow-400' : 'text-gray-300'"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            </template>
                                            <meta itemprop="ratingValue" :content="testimonial.rating">
                                            <meta itemprop="bestRating" content="5">
                                        </div>
                                    </div>
                                </div>
                                <blockquote class="text-lg text-gray-700 leading-relaxed italic"
                                    itemprop="reviewBody">
                                    <p x-text="'« ' + testimonial.text + ' »'"></p>
                                </blockquote>
                            </div>
                        </template>

                        {{-- Navigation dots --}}
                        <nav class="flex justify-center gap-3 mt-8" aria-label="Navigation témoignages">
                            <template x-for="(testimonial, index) in testimonials" :key="index">
                                <button @click="currentIndex = index"
                                    :class="currentIndex === index ? 'bg-base w-8' : 'bg-gray-300 w-3'"
                                    class="h-3 rounded-full transition-all duration-300"
                                    :aria-label="'Témoignage ' + (index + 1)"
                                    :aria-current="currentIndex === index ? 'true' : 'false'"></button>
                            </template>
                        </nav>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('register') }}" title="Rejoindre la communauté AgroSpace - Inscription gratuite"
                        class="inline-block bg-base text-white px-8 py-4 rounded-lg font-semibold hover:bg-green-800 transition-all shadow-lg hover:shadow-xl">
                        Rejoindre la communauté agricole
                    </a>
                </div>
            </div>
        </section>

        {{-- Blog Section with Article Schema --}}
        <section id="blog" class="py-20 bg-white" itemscope itemtype="https://schema.org/Blog">
            <div class="container mx-auto px-4">
                <header class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Blog Agriculture Cameroun : Actualités et Conseils
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Restez informé des dernières tendances, innovations et conseils pratiques pour le secteur
                        agricole camerounais
                    </p>
                </header>

                <div class="grid md:grid-cols-3 gap-8">
                    {{-- Article 1 --}}
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all group"
                        itemscope itemtype="https://schema.org/BlogPosting">
                        <img src="{{ asset('images/blog/agriculture-digitale-cameroun.jpg') }}"
                            alt="Agriculture digitale au Cameroun - Innovation technologique agricole"
                            class="h-48 w-full object-cover" width="400" height="192" loading="lazy"
                            itemprop="image" />
                        <div class="p-6">
                            <span class="text-sm text-base font-semibold" itemprop="keywords">🌱 Innovation
                                Agricole</span>
                            <h3 class="text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-base transition-colors"
                                itemprop="headline">
                                <a href="{{ route('blog.show', 'agriculture-digitale-cameroun') }}"
                                    title="Lire l'article sur l'agriculture digitale au Cameroun">
                                    L'Agriculture Digitale au Cameroun : Une Révolution en Marche
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-4" itemprop="description">
                                Découvrez comment la technologie numérique transforme les pratiques agricoles
                                camerounaises et crée de nouvelles opportunités pour les producteurs locaux...
                            </p>
                            <meta itemprop="datePublished" content="2025-01-15">
                            <meta itemprop="author" content="AgroSpace">
                            <a href="{{ route('blog.show', 'agriculture-digitale-cameroun') }}"
                                title="Lire l'article complet sur l'agriculture digitale"
                                class="text-base font-semibold hover:underline inline-flex items-center">
                                Lire l'article complet
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>

                    {{-- Article 2 --}}
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all group"
                        itemscope itemtype="https://schema.org/BlogPosting">
                        <img src="{{ asset('images/blog/partenariats-agricoles-cameroun.jpg') }}"
                            alt="Partenariats agropastoraux au Cameroun - Collaboration producteurs"
                            class="h-48 w-full object-cover" width="400" height="192" loading="lazy"
                            itemprop="image" />
                        <div class="p-6">
                            <span class="text-sm text-base font-semibold" itemprop="keywords">🤝 Collaboration</span>
                            <h3 class="text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-base transition-colors"
                                itemprop="headline">
                                <a href="{{ route('blog.show', 'partenariats-agropastoraux') }}"
                                    title="Guide partenariats agricoles au Cameroun">
                                    5 Conseils pour Réussir vos Partenariats Agropastoraux
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-4" itemprop="description">
                                Les meilleures pratiques et stratégies pour établir des relations commerciales durables
                                avec vos partenaires agricoles au Cameroun...
                            </p>
                            <meta itemprop="datePublished" content="2025-01-10">
                            <meta itemprop="author" content="AgroSpace">
                            <a href="{{ route('blog.show', 'partenariats-agropastoraux') }}"
                                title="Lire le guide complet sur les partenariats agricoles"
                                class="text-base font-semibold hover:underline inline-flex items-center">
                                Lire le guide complet
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>

                    {{-- Article 3 --}}
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all group"
                        itemscope itemtype="https://schema.org/BlogPosting">
                        <img src="{{ asset('images/blog/marches-agricoles-2025-cameroun.jpg') }}"
                            alt="Marchés agricoles 2025 Cameroun - Tendances et opportunités économiques"
                            class="h-48 w-full object-cover" width="400" height="192" loading="lazy"
                            itemprop="image" />
                        <div class="p-6">
                            <span class="text-sm text-base font-semibold" itemprop="keywords">📊 Économie
                                Agricole</span>
                            <h3 class="text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-base transition-colors"
                                itemprop="headline">
                                <a href="{{ route('blog.show', 'marches-agricoles-2025') }}"
                                    title="Analyse marchés agricoles 2025 Cameroun">
                                    Marchés Agricoles 2025 : Tendances et Opportunités au Cameroun
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-4" itemprop="description">
                                Analyse détaillée des perspectives économiques 2025 pour les producteurs agricoles et
                                les acteurs de la chaîne de valeur camerounaise...
                            </p>
                            <meta itemprop="datePublished" content="2025-01-05">
                            <meta itemprop="author" content="AgroSpace">
                            <a href="{{ route('blog.show', 'marches-agricoles-2025') }}"
                                title="Lire l'analyse complète des marchés agricoles 2025"
                                class="text-base font-semibold hover:underline inline-flex items-center">
                                Lire l'analyse complète
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('blog.index') }}" title="Voir tous les articles du blog agriculture Cameroun"
                        class="inline-block border-2 border-base text-base px-8 py-4 rounded-lg font-semibold hover:bg-base hover:text-white transition-all">
                        Voir tous les articles du blog
                    </a>
                </div>
            </div>
        </section>

        {{-- CTA Final Section --}}
        <section class="py-20 gradient-bg text-white relative overflow-hidden" itemscope
            itemtype="https://schema.org/Offer">
            <div class="absolute inset-0 opacity-10" aria-hidden="true">
                <div class="absolute inset-0"
                    style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                </div>
            </div>

            <div class="container mx-auto px-4 text-center relative z-10">
                <h2 class="text-4xl md:text-5xl font-bold mb-6" itemprop="name">
                    Rejoignez AgroSpace : Plateforme Agricole N°1 au Cameroun
                </h2>
                <p class="text-xl md:text-2xl text-green-50 mb-8 max-w-3xl mx-auto" itemprop="description">
                    Inscrivez-vous gratuitement et valorisez vos activités agricoles au sein d'un écosystème
                    professionnel durable et innovant
                </p>

                <meta itemprop="price" content="0">
                <meta itemprop="priceCurrency" content="XAF">
                <link itemprop="url" href="{{ route('register') }}">

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('register') }}"
                        title="Créer mon compte AgroSpace gratuitement - Inscription rapide"
                        class="bg-white text-base px-10 py-5 rounded-lg font-bold text-lg hover:bg-accent transition-all shadow-2xl hover:scale-105">
                        Créer mon compte gratuitement maintenant
                    </a>
                </div>
                <p class="text-sm text-green-100 mt-6">
                    ✓ Inscription 100% gratuite et rapide (moins d'1 minute) • ✓ Aucune carte bancaire requise • ✓ Accès
                    immédiat à toutes les fonctionnalités
                </p>
            </div>
        </section>

        {{-- Footer --}}
        <x-layouts.footer />

        {{-- Scroll to top button --}}
        <button x-data="{ showButton: false }" x-init="window.addEventListener('scroll', () => { showButton = window.pageYOffset > 300 })" x-show="showButton" x-cloak
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-8 right-8 bg-base text-white w-12 h-12 rounded-full shadow-2xl hover:bg-green-800 transition-all hover:scale-110 flex items-center justify-center z-40"
            aria-label="Retour en haut de la page" title="Retour en haut">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </button>
    </div>
</div>
