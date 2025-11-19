<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Helpers\SEO;             // déjà créé

new #[Layout('layouts.main')] class extends Component
{
    public function mount()
    {
        SEO::setTitle('Espace Consommateurs - AgroSpace Cameroun | Produits Agricoles Locaux');
        SEO::setDescription('Rejoignez AgroSpace en tant que consommateur : accédez à des offres agricoles locales, contactez directement les producteurs, soutenez l’agriculture de proximité. Inscription 100 % gratuite.');
        SEO::setKeywords('consommateur agricole Cameroun, produits locaux, circuits courts, achat direct producteur, AgroSpace consommateur, marché local');
        SEO::setCanonical(url()->current());
        SEO::setImage(asset('images/agrospace-consumer-og.jpg')); // 1200×630
        SEO::setType('website');
    }
}; ?>

@push('meta')
    {{-- Primary Meta Tags --}}
    <title>Espace Consommateurs - AgroSpace Cameroun | Produits Agricoles Locaux</title>
    <meta name="title" content="Espace Consommateurs - AgroSpace Cameroun | Produits Agricoles Locaux">
    <meta name="description" content="Rejoignez AgroSpace en tant que consommateur : accédez à des offres agricoles locales, contactez directement les producteurs, soutenez l’agriculture de proximité. Inscription 100 % gratuite.">
    <meta name="keywords" content="consommateur agricole Cameroun, produits locaux, circuits courts, achat direct producteur, AgroSpace consommateur, marché local">
    <meta name="robots" content="index, follow">
    <meta name="language" content="fr">
    <meta name="author" content="AgroSpace">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Espace Consommateurs - AgroSpace Cameroun | Produits Agricoles Locaux">
    <meta property="og:description" content="Accédez à des offres agricoles locales, contactez directement les producteurs, soutenez l’agriculture de proximité. Inscription 100 % gratuite.">
    <meta property="og:image" content="{{ asset('images/agrospace-consumer-og.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="AgroSpace">
    <meta property="og:locale" content="fr_CM">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="Espace Consommateurs - AgroSpace Cameroun | Produits Agricoles Locaux">
    <meta name="twitter:description" content="Accédez à des offres agricoles locales, contactez directement les producteurs, soutenez l’agriculture de proximité.">
    <meta name="twitter:image" content="{{ asset('images/agrospace-consumer-og.jpg') }}">

    {{-- Geo-tags --}}
    <meta name="geo.region" content="CM">
    <meta name="geo.placename" content="Cameroun">
    <meta name="geo.position" content="3.848;11.5021">
    <meta name="ICBM" content="3.848, 11.5021">
@endpush

<div>
    <!-- Header Navigation -->
    <x-layouts.header />

    <!-- Hero Section -->
    <section class="relative pt-24 pb-20 md:pt-32 md:pb-28 overflow-hidden gradient-bg" itemscope itemtype="https://schema.org/WPHeader">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-6 animate-fade-in-up">
                    <div class="inline-block bg-base/10 px-4 py-2 rounded-full text-white font-semibold text-sm mb-4">
                        🛒 Espace Consommateurs
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-50 leading-tight">
                        Trouvez facilement les <span class="text-[#1B5E20]">producteurs agricoles</span> près de chez vous
                    </h1>
                    <p class="text-lg md:text-xl text-gray-50 leading-relaxed">
                        Accédez à des offres vérifiées, contactez directement les producteurs et soutenez l'agriculture
                        locale en toute simplicité.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="/register?type=consommateur"
                            class="bg-base text-white px-8 py-4 rounded-lg font-bold hover:bg-green-800 transition-all shadow-xl hover:shadow-2xl text-center text-lg">
                            Créer un compte Consommateur
                        </a>
                        <a href="/offres"
                            class="bg-white border-2 border-base text-base px-8 py-4 rounded-lg font-semibold hover:bg-base hover:text-white transition-all text-center">
                            Parcourir les offres
                        </a>
                    </div>
                    <div class="flex items-center gap-6 pt-6 text-sm text-gray-50">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">100% Gratuit</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Contact direct</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Produits locaux</span>
                        </div>
                    </div>
                </div>

                <!-- Right Illustration -->
                <div class="hidden md:block animate-float">
                    <svg class="w-full h-auto" viewBox="0 0 500 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Shopping illustration -->
                        <circle cx="250" cy="200" r="160" fill="#81C784" opacity="0.2" />
                        <rect x="180" y="150" width="140" height="180" rx="15" fill="#FFFFFF"
                            stroke="#1B5E20" stroke-width="3" />
                        <circle cx="250" cy="100" r="40" fill="#FFD700" opacity="0.8" />
                        <rect x="200" y="180" width="100" height="15" rx="5" fill="#E0E0E0" />
                        <rect x="200" y="210" width="80" height="15" rx="5" fill="#E0E0E0" />
                        <rect x="200" y="240" width="90" height="15" rx="5" fill="#E0E0E0" />
                        <circle cx="380" cy="280" r="50" fill="#4CAF50" opacity="0.6" />
                        <circle cx="120" cy="260" r="40" fill="#4CAF50" opacity="0.6" />
                        <path d="M 100 350 Q 250 330 400 350" stroke="#81C784" stroke-width="4" fill="none" />
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Avantages Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Les avantages pour les consommateurs agricoles</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Agrospace simplifie votre recherche de produits agricoles et vous met en relation directe avec les
                    producteurs
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Avantage 1 -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 border-t-4 border-base group">
                    <div
                        class="w-16 h-16 bg-base/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Recherche simplifiée</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Trouvez rapidement des offres selon vos besoins grâce à des filtres puissants et une interface
                        intuitive.
                    </p>
                </div>

                <!-- Avantage 2 -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 border-t-4 border-secondary group">
                    <div
                        class="w-16 h-16 bg-secondary/20 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Connexion locale</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Découvrez les producteurs proches de votre région et soutenez l'économie locale en circuit
                        court.
                    </p>
                </div>

                <!-- Avantage 3 -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 border-t-4 border-base group">
                    <div
                        class="w-16 h-16 bg-base/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Communication directe</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Contactez les producteurs sans intermédiaires via la messagerie instantanée intégrée.
                    </p>
                </div>

                <!-- Avantage 4 -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 border-t-4 border-secondary group">
                    <div
                        class="w-16 h-16 bg-secondary/20 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Confiance & transparence</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Des profils vérifiés, des avis authentiques et des échanges humains pour une confiance totale.
                    </p>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="/register?type=consommateur"
                    class="inline-block bg-base text-white px-10 py-5 rounded-lg font-bold text-lg hover:bg-green-800 transition-all shadow-xl hover:shadow-2xl hover:scale-105">
                    Rejoindre la communauté
                </a>
            </div>
        </div>
    </section>

    <!-- Fonctionnalités Section -->
    <section class="py-20 bg-emerald-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Ce que vous pouvez faire sur Agrospace</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Des outils simples et efficaces pour trouver exactement ce dont vous avez besoin
                </p>
            </div>

            <!-- Feature 1 -->
            <div class="grid md:grid-cols-2 gap-12 items-center mb-20">
                <div class="space-y-6">
                    <div class="inline-block bg-base/10 px-4 py-2 rounded-full text-base font-semibold text-sm">
                        🛒 Parcourir
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900">Parcourir les offres disponibles</h3>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Accédez à des centaines d'offres agricoles selon la catégorie, la région ou le prix. Filtrez par
                        type de produit, distance ou disponibilité.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Filtres avancés par catégorie et localisation</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Photos et descriptions détaillées</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Carte interactive pour visualiser les producteurs</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-2xl">
                    <div class="space-y-4">
                        <div
                            class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:shadow-lg transition-shadow cursor-pointer">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex-shrink-0">
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900">Tomates Bio - 50kg</h4>
                                <p class="text-sm text-gray-600">Producteur: Marie K. • Bafoussam</p>
                                <p class="text-base font-bold mt-1">2,500 FCFA/kg</p>
                            </div>
                        </div>
                        <div
                            class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:shadow-lg transition-shadow cursor-pointer">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex-shrink-0">
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900">Maïs frais - 100kg</h4>
                                <p class="text-sm text-gray-600">Producteur: Jean N. • Douala</p>
                                <p class="text-base font-bold mt-1">1,800 FCFA/kg</p>
                            </div>
                        </div>
                        <div
                            class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:shadow-lg transition-shadow cursor-pointer">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex-shrink-0">
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900">Lait frais - 20L/jour</h4>
                                <p class="text-sm text-gray-600">Producteur: Aïcha M. • Maroua</p>
                                <p class="text-base font-bold mt-1">1,200 FCFA/L</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="grid md:grid-cols-2 gap-12 items-center mb-20">
                <div class="order-2 md:order-1 bg-white p-8 rounded-3xl shadow-2xl">
                    <div class="bg-gradient-to-br from-base/10 to-secondary/20 p-8 rounded-2xl">
                        <div class="bg-white p-6 rounded-xl shadow-lg">
                            <h4 class="font-bold text-gray-900 mb-4">📢 Nouvelle demande</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm text-gray-600">Type de produit</label>
                                    <div class="h-10 bg-gray-100 rounded-lg mt-1"></div>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Quantité souhaitée</label>
                                    <div class="h-10 bg-gray-100 rounded-lg mt-1"></div>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Localisation</label>
                                    <div class="h-10 bg-gray-100 rounded-lg mt-1"></div>
                                </div>
                                <button class="w-full bg-base text-white py-3 rounded-lg font-semibold">
                                    Publier ma demande
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-1 md:order-2 space-y-6">
                    <div
                        class="inline-block bg-secondary/20 px-4 py-2 rounded-full text-base font-semibold text-sm">
                        📢 Demandes
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900">Créer vos propres demandes</h3>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Publiez vos besoins spécifiques pour être contacté par des producteurs proches. Décrivez ce que
                        vous recherchez et recevez des propositions personnalisées.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Formulaire simple et rapide</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4
                                                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d=" M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0
                                    00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Recevez plusieurs propositions</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Comparez et choisissez la meilleure offre</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="inline-block bg-base/10 px-4 py-2 rounded-full text-base font-semibold text-sm">
                        💬 Messagerie
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900">Échanger via la messagerie intégrée</h3>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Posez vos questions, demandez des précisions, ou négociez directement avec les producteurs via
                        une messagerie instantanée sécurisée.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Messagerie instantanée temps réel</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Partage de photos et documents</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Historique complet des conversations</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-2xl">
                    <div class="bg-base text-white p-4 rounded-t-2xl flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl">👨🏾‍🌾</span>
                        </div>
                        <div>
                            <h4 class="font-semibold">Marie Kouam</h4>
                            <p class="text-xs text-green-100">En ligne</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-4 bg-gray-50 min-h-64">
                        <div class="flex justify-start">
                            <div class="bg-white rounded-2xl rounded-bl-none px-4 py-3 shadow max-w-xs">
                                <p class="text-sm text-gray-800">Bonjour, mes tomates sont disponibles dès demain matin
                                    !</p>
                                <span class="text-xs text-gray-500">10:24</span>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <div class="bg-base text-white rounded-2xl rounded-br-none px-4 py-3 shadow max-w-xs">
                                <p class="text-sm">Parfait ! Quelle est la quantité minimum ?</p>
                                <span class="text-xs text-green-100">10:25</span>
                            </div>
                        </div>
                        <div class="flex justify-start">
                            <div class="bg-white rounded-2xl rounded-bl-none px-4 py-3 shadow max-w-xs">
                                <p class="text-sm text-gray-800">10kg minimum. Je peux livrer si vous êtes à Bafoussam
                                    😊</p>
                                <span class="text-xs text-gray-500">10:26</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-white border-t flex gap-2">
                        <input type="text" placeholder="Écrivez votre message..."
                            class="flex-1 px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-base">
                        <button class="bg-base text-white p-2 rounded-full hover:bg-green-800 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Comment ça marche Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Comment profiter d'Agrospace ?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Rejoignez la communauté en 3 étapes simples et commencez à trouver les meilleurs produits locaux
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <!-- Étape 1 -->
                <div class="relative">
                    <div
                        class="bg-gradient-to-br from-green-50 to-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all h-full">
                        <div
                            class="absolute -top-6 left-8 w-16 h-16 bg-gradient-to-br from-base to-secondary rounded-full flex items-center justify-center shadow-xl">
                            <span class="text-3xl font-bold text-white">1</span>
                        </div>
                        <div class="pt-8">
                            <div
                                class="w-16 h-16 bg-base/10 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Créez votre compte
                                consommateur</h3>
                            <p class="text-gray-600 text-center leading-relaxed">
                                Simple, gratuit et rapide. Renseignez vos informations de base en moins de 2 minutes.
                            </p>
                        </div>
                    </div>
                    <!-- Arrow -->
                    <div class="hidden md:block absolute top-12 -right-4 text-secondary animate-pulse">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>
                </div>

                <!-- Étape 2 -->
                <div class="relative">
                    <div
                        class="bg-gradient-to-br from-green-50 to-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all h-full">
                        <div
                            class="absolute -top-6 left-8 w-16 h-16 bg-gradient-to-br from-base to-secondary rounded-full flex items-center justify-center shadow-xl">
                            <span class="text-3xl font-bold text-white">2</span>
                        </div>
                        <div class="pt-8">
                            <div
                                class="w-16 h-16 bg-secondary/20 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Recherchez ou publiez vos
                                besoins</h3>
                            <p class="text-gray-600 text-center leading-relaxed">
                                En quelques clics, trouvez les bonnes opportunités ou publiez votre demande spécifique.
                            </p>
                        </div>
                    </div>
                    <!-- Arrow -->
                    <div class="hidden md:block absolute top-12 -right-4 text-secondary animate-pulse">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>
                </div>

                <!-- Étape 3 -->
                <div class="relative">
                    <div
                        class="bg-gradient-to-br from-green-50 to-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all h-full">
                        <div
                            class="absolute -top-6 left-8 w-16 h-16 bg-gradient-to-br from-base to-secondary rounded-full flex items-center justify-center shadow-xl">
                            <span class="text-3xl font-bold text-white">3</span>
                        </div>
                        <div class="pt-8">
                            <div
                                class="w-16 h-16 bg-base/10 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Discutez avec les producteurs
                            </h3>
                            <p class="text-gray-600 text-center leading-relaxed">
                                Échangez directement et commencez à collaborer localement sans intermédiaires.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="/register?type=consommateur"
                    class="inline-block bg-base text-white px-10 py-5 rounded-lg font-bold text-lg hover:bg-green-800 transition-all shadow-xl hover:shadow-2xl hover:scale-105">
                    Créer mon compte gratuitement
                </a>
                <p class="text-sm text-gray-600 mt-4">✓ Aucune carte bancaire requise • ✓ Sans engagement</p>
            </div>
        </div>
    </section>

    <!-- Témoignages Section -->
    <section class="py-20 bg-[#FAF7F0]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Ils ont trouvé ce qu'ils cherchaient grâce à
                    Agrospace</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Découvrez les expériences de consommateurs qui ont simplifié leur approvisionnement agricole
                </p>
            </div>

            <div class="max-w-5xl mx-auto" x-data="{
                testimonials: [{
                        name: 'Sophie Mbarga',
                        location: 'Restauratrice - Yaoundé',
                        text: 'J\'ai trouvé un producteur de légumes bio à moins de 10 km en seulement 2 jours ! La qualité est exceptionnelle et les prix sont justes. Je recommande Agrospace à tous les professionnels.',
                        avatar: '👩🏾‍🍳',
                        rating: 5
                    },
                    {
                        name: 'Thomas Ekani',
                        location: 'Particulier - Douala',
                        text: 'En tant que consommateur soucieux de l\'origine de mes produits, Agrospace m\'a permis de créer des liens directs avec des producteurs locaux. C\'est rassurant et économique !',
                        avatar: '👨🏾',
                        rating: 5
                    },
                    {
                        name: 'Hôtel Le Palmier',
                        location: 'Établissement hôtelier - Kribi',
                        text: 'Nous approvisionnons maintenant notre cuisine avec des produits frais locaux grâce à Agrospace. Nos clients apprécient la démarche et la qualité. Une vraie révolution !',
                        avatar: '🏨',
                        rating: 5
                    }
                ],
                currentIndex: 0
            }" x-init="setInterval(() => { currentIndex = (currentIndex + 1) % testimonials.length }, 6000)">

                <div class="relative">
                    <template x-for="(testimonial, index) in testimonials" :key="index">
                        <div x-show="currentIndex === index" x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            class="bg-white p-12 rounded-3xl shadow-2xl">

                            <div class="flex flex-col md:flex-row items-center gap-8">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-32 h-32 bg-gradient-to-br from-base to-secondary rounded-full flex items-center justify-center text-6xl shadow-xl">
                                        <span x-text="testimonial.avatar"></span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 text-center md:text-left">
                                    <!-- Stars -->
                                    <div class="flex justify-center md:justify-start gap-1 mb-4">
                                        <template x-for="i in 5">
                                            <svg class="w-6 h-6 text-yellow-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </template>
                                    </div>

                                    <!-- Quote -->
                                    <p class="text-xl text-gray-700 leading-relaxed mb-6 italic"
                                        x-text="'« ' + testimonial.text + ' »'"></p>

                                    <!-- Author -->
                                    <div>
                                        <h4 class="text-xl font-bold text-gray-900" x-text="testimonial.name"></h4>
                                        <p class="text-base font-medium" x-text="testimonial.location"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Navigation dots -->
                    <div class="flex justify-center gap-3 mt-8">
                        <template x-for="(testimonial, index) in testimonials" :key="index">
                            <button @click="currentIndex = index"
                                :class="currentIndex === index ? 'bg-base w-12' : 'bg-gray-300 w-3'"
                                class="h-3 rounded-full transition-all duration-300"></button>
                        </template>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="/register?type=consommateur"
                    class="inline-block bg-base text-white px-10 py-5 rounded-lg font-bold text-lg hover:bg-green-800 transition-all shadow-xl hover:shadow-2xl hover:scale-105">
                    Créer mon compte gratuitement
                </a>
            </div>
        </div>
    </section>

    <!-- Statistiques Section -->
    <section class="py-20 bg-gradient-to-br from-secondary/20 to-green-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Une communauté grandissante</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Des chiffres qui témoignent de la confiance des consommateurs africains
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8" x-data="{ inView: false }" x-intersect="inView = true">
                <!-- Stat 1 -->
                <div
                    class="bg-white p-10 rounded-3xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 text-center">
                    <div class="w-20 h-20 bg-base/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-base" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <p class="text-5xl font-bold text-green-700 mb-3 animate-count" x-show="inView">+1,000</p>
                    <p class="text-xl text-gray-700 font-semibold">Offres agricoles actives</p>
                    <p class="text-sm text-gray-500 mt-2">Disponibles dans toutes les régions</p>
                </div>

                <!-- Stat 2 -->
                <div
                    class="bg-white p-10 rounded-3xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 text-center">
                    <div class="w-20 h-20 bg-secondary/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-base" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <p class="text-5xl font-bold text-green-700 mb-3 animate-count" x-show="inView">+500</p>
                    <p class="text-xl text-gray-700 font-semibold">Producteurs disponibles</p>
                    <p class="text-sm text-gray-500 mt-2">Vérifiés et fiables</p>
                </div>

                <!-- Stat 3 -->
                <div
                    class="bg-white p-10 rounded-3xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 text-center">
                    <div class="w-20 h-20 bg-base/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-base" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                    </div>
                    <p class="text-5xl font-bold text-green-700 mb-3 animate-count" x-show="inView">+300</p>
                    <p class="text-xl text-gray-700 font-semibold">Consommateurs satisfaits</p>
                    <p class="text-sm text-gray-500 mt-2">Et ce nombre grandit chaque jour</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final Section -->
    <section class="py-20 gradient-cta text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div class="absolute inset-0"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>
        </div>

        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Rejoignez Agrospace et trouvez les meilleurs producteurs agricoles autour de vous
            </h2>
            <p class="text-xl md:text-2xl text-green-50 mb-10 max-w-3xl mx-auto">
                Des milliers de consommateurs ont déjà trouvé ce qu'ils cherchaient. C'est gratuit, simple et local.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="/register?type=consommateur"
                    class="bg-white text-base px-12 py-6 rounded-lg font-bold text-xl hover:bg-yellow-300 transition-all shadow-2xl hover:scale-105">
                    Créer un compte Consommateur
                </a>
                <a href="/offres"
                    class="bg-transparent border-2 border-white text-white px-12 py-6 rounded-lg font-bold text-xl hover:bg-white hover:text-base transition-all">
                    Découvrir les offres
                </a>
            </div>
            <p class="text-sm text-green-100 mt-8">
                ✓ C'est gratuit, simple et local • ✓ Sans intermédiaires • ✓ Produits frais et de qualité
            </p>
        </div>
    </section>
    <x-layouts.footer />
</div>
