<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.main')] class extends Component {
    //
}; ?>
<div>
    
<body class="font-sans antialiased bg-white" x-data="{ mobileMenuOpen: false }">

    <x-layouts.header />

    <!-- Hero Section -->
    <section class="relative pt-24 pb-20 md:pt-32 md:pb-28 overflow-hidden gradient-bg">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\" 60\ " height=\"60\ " viewBox=\"0 0 60 60\ " xmlns=\"http://www.w3.org/2000/svg\ "%3E%3Cg fill=\"none\ " fill-rule=\"evenodd\ "%3E%3Cg fill=\"%23ffffff\
                " fill-opacity=\"0.4\ "%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\ "/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-white space-y-6 animate-fade-in-up">
                    <div class="inline-block bg-white/20 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                        🚀 Plateforme complète
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        Toutes les fonctionnalités pour <span class="text-white">dynamiser</span> le monde agropastoral
                    </h1>
                    <p class="text-lg md:text-xl text-green-50 leading-relaxed">
                        Découvrez comment Agrospace facilite la connexion entre producteurs et consommateurs agricoles grâce à des outils simples et puissants.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="#" class="bg-white text-primary px-8 py-4 rounded-lg font-semibold hover:bg-accent transition-all shadow-xl hover:shadow-2xl text-center">
                            Créer mon compte gratuitement
                        </a>
                        <a href="#offres" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-primary transition-all text-center">
                            Découvrir les fonctionnalités
                        </a>
                    </div>
                </div>

                <!-- Right Illustration -->
                <div class="hidden md:block animate-float">
                    <svg class="w-full h-auto" viewBox="0 0 500 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Dashboard mockup -->
                        <rect x="50" y="50" width="400" height="300" rx="20" fill="white" opacity="0.95"/>
                        <rect x="70" y="70" width="120" height="80" rx="10" fill="#1B5E20" opacity="0.3"/>
                        <rect x="210" y="70" width="120" height="80" rx="10" fill="#81C784" opacity="0.5"/>
                        <rect x="350" y="70" width="80" height="80" rx="10" fill="#4CAF50" opacity="0.4"/>
                        <rect x="70" y="170" width="360" height="20" rx="5" fill="#E0E0E0"/>
                        <rect x="70" y="210" width="360" height="20" rx="5" fill="#E0E0E0"/>
                        <rect x="70" y="250" width="360" height="20" rx="5" fill="#E0E0E0"/>
                        <circle cx="250" cy="320" r="20" fill="#1B5E20"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 1 - Gestion des Offres -->
    <section id="offres" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="space-y-6">
                    <div class="inline-block bg-primary/10 px-4 py-2 rounded-full text-primary font-semibold text-sm">
                        🌾 Gestion des Offres
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900">
                        Publiez et valorisez vos produits facilement
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Créez vos offres agricoles en quelques clics, ajoutez vos photos, précisez votre région et rendez vos produits visibles auprès des acheteurs intéressés.
                    </p>

                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Interface simple et rapide</h4>
                                <p class="text-gray-600">Créez une offre en moins de 2 minutes</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Ajout d'images et de catégories</h4>
                                <p class="text-gray-600">Illustrez vos produits pour plus d'impact</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Visibilité locale et nationale</h4>
                                <p class="text-gray-600">Touchez les acheteurs de votre région</p>
                            </div>
                        </li>
                    </ul>

                    <div class="pt-4">
                        <a href="#" class="inline-flex items-center text-primary font-semibold hover:underline">
                            Créer ma première offre
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Image Mockup -->
                <div class="bg-gradient-to-br from-primary/5 to-secondary/10 p-8 rounded-3xl">
                    <div class="bg-white rounded-2xl shadow-2xl p-6 space-y-4">
                        <div class="h-48 bg-gradient-to-br from-green-400 to-green-600 rounded-xl"></div>
                        <div class="space-y-3">
                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-3 bg-gray-100 rounded w-full"></div>
                            <div class="h-3 bg-gray-100 rounded w-5/6"></div>
                            <div class="flex gap-2 pt-2">
                                <div class="h-8 bg-primary/20 rounded-full w-24"></div>
                                <div class="h-8 bg-secondary/20 rounded-full w-24"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2 - Gestion des Demandes -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Image Mockup (Left on desktop) -->
                <div class="order-2 md:order-1 bg-gradient-to-br from-secondary/10 to-primary/5 p-8 rounded-3xl">
                    <div class="bg-white rounded-2xl shadow-2xl p-6">
                        <div class="flex items-center gap-3 mb-4 pb-4 border-b">
                            <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full"></div>
                            <div class="flex-1">
                                <div class="h-3 bg-gray-200 rounded w-32 mb-2"></div>
                                <div class="h-2 bg-gray-100 rounded w-24"></div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="bg-secondary/10 p-4 rounded-lg">
                                <div class="h-3 bg-gray-300 rounded w-full mb-2"></div>
                                <div class="h-3 bg-gray-300 rounded w-4/5"></div>
                            </div>
                            <div class="flex gap-2 justify-end">
                                <div class="h-10 bg-primary rounded-lg w-32"></div>
                                <div class="h-10 bg-gray-200 rounded-lg w-32"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Text Content (Right on desktop) -->
                <div class="order-1 md:order-2 space-y-6">
                    <div class="inline-block bg-secondary/20 px-4 py-2 rounded-full text-primary font-semibold text-sm">
                        🛒 Gestion des Demandes
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900">
                        Trouvez ce que vous recherchez, simplement
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Les consommateurs peuvent publier leurs besoins spécifiques, comme "Je cherche 50 poulets à Douala", et recevoir des propositions des producteurs locaux.
                    </p>

                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Recherche par région et catégorie</h4>
                                <p class="text-gray-600">Filtrez précisément vos besoins</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Publication rapide</h4>
                                <p class="text-gray-600">Exprimez vos besoins en quelques mots</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Alertes en temps réel</h4>
                                <p class="text-gray-600">Recevez les propositions instantanément</p>
                            </div>
                        </li>
                    </ul>

                    <div class="pt-4">
                        <a href="#" class="inline-flex items-center text-primary font-semibold hover:underline">
                            Publier une demande
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3 - Messagerie -->
    <section class="py-20 bg-emerald-50">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto text-center mb-16">
                <div class="inline-block bg-primary/10 px-4 py-2 rounded-full text-primary font-semibold text-sm mb-4">
                    💬 Messagerie Temps Réel
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Échangez en direct avec vos partenaires agricoles
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Discutez instantanément grâce à la messagerie intégrée. Posez vos questions, envoyez des photos ou négociez directement sans intermédiaire.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Interface intuitive</h3>
                    <p class="text-gray-600">Design type WhatsApp, familier et facile à utiliser</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all">
                    <div class="w-16 h-16 bg-secondary/20 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Notifications instantanées</h3>
                    <p class="text-gray-600">Ne ratez aucun message important</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all">
                    <div class="w-16 h-16 bg-accent rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Sécurité garantie</h3>
                    <p class="text-gray-600">Vos conversations restent privées et sécurisées</p>
                </div>
            </div>

            <!-- Chat Mockup with Animation -->
            <div class="max-w-3xl mx-auto" x-data="{ messages: [
                { text: 'Bonjour, vos tomates sont-elles encore disponibles ?', sender: 'them', delay: 0 },
                { text: 'Oui ! J\'ai encore 50kg de tomates bio.', sender: 'me', delay: 1000 },
                { text: 'Parfait ! Quel est votre prix ?', sender: 'them', delay: 2000 }
            ], visibleMessages: [] }" x-init="messages.forEach((msg, i) => { setTimeout(() => visibleMessages.push(msg), msg.delay) })">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                    <!-- Chat Header -->
                    <div class="bg-primary text-white p-4 flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl">👨🏾‍🌾</span>
                        </div>
                        <div>
                            <h4 class="font-semibold">Jean Nkeng</h4>
                            <p class="text-sm text-green-100">En ligne</p>
                        </div>
                    </div>

                    <!-- Chat Messages -->
                    <div class="p-6 space-y-4 h-64 overflow-y-auto bg-gray-50">
                        <template x-for="(message, index) in visibleMessages" :key="index">
                            <div :class="message.sender === 'me' ? 'flex justify-end' : 'flex justify-start'" x-transition>
                                <div :class="message.sender === 'me' ? 'bg-primary text-white' : 'bg-white'" 
                                     class="max-w-xs px-4 py-3 rounded-2xl shadow">
                                    <p x-text="message.text"></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Chat Input -->
                    <div class="p-4 bg-white border-t flex gap-2">
                        <input type="text" placeholder="Écrivez votre message..." class="flex-1 px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-primary">
                        <button class="bg-primary text-white p-2 rounded-full hover:bg-green-800 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4 - Carte Interactive -->
    <section class="py-20 bg-[#FAF7F0]">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="space-y-6">
                    <div class="inline-block bg-primary/10 px-4 py-2 rounded-full text-primary font-semibold text-sm">
                        🗺️ Carte Interactive
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900">
                        Repérez les acteurs agricoles près de vous
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Grâce à la carte interactive, visualisez les offres et demandes autour de votre région et découvrez de nouveaux partenaires agricoles.
                    </p>

                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Carte dynamique</h4>
                                <p class="text-gray-600">Navigation fluide et géolocalisation précise</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Filtres par catégorie et localisation</h4>
                                <p class="text-gray-600">Trouvez exactement ce que vous cherchez</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Vue régionale intuitive</h4>
                                <p class="text-gray-600">Zoomez sur votre zone d'intérêt</p>
                            </div>
                        </li>
                    </ul>

                    <div class="pt-4">
                        <a href="#" class="inline-flex items-center text-primary font-semibold hover:underline">
                            Explorer la carte
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Map Mockup -->
                <div class="bg-white p-4 rounded-3xl shadow-2xl">
                    <div class="relative h-96 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl overflow-hidden">
                        <!-- Map pins -->
                        <div class="absolute top-1/4 left-1/3 w-8 h-8 bg-primary rounded-full border-4 border-white shadow-lg animate-pulse"></div>
                        <div class="absolute top-1/2 left-1/2 w-8 h-8 bg-secondary rounded-full border-4 border-white shadow-lg"></div>
                        <div class="absolute top-2/3 left-2/3 w-8 h-8 bg-primary rounded-full border-4 border-white shadow-lg"></div>
                        <div class="absolute top-1/3 left-2/3 w-8 h-8 bg-secondary rounded-full border-4 border-white shadow-lg animate-pulse"></div>

                        <!-- Map lines (roads) -->
                        <svg class="absolute inset-0 w-full h-full opacity-30" viewBox="0 0 400 400">
                            <path d="M 0 200 Q 200 100 400 200" stroke="#1B5E20" stroke-width="3" fill="none"/>
                            <path d="M 200 0 Q 250 200 200 400" stroke="#1B5E20" stroke-width="3" fill="none"/>
                        </svg>

                        <!-- Info popup -->
                        <div class="absolute bottom-4 left-4 right-4 bg-white rounded-xl p-4 shadow-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-lg"></div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">Tomates bio - Bafoussam</h4>
                                    <p class="text-sm text-gray-600">50kg disponibles</p>
                                </div>
                                <button class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-800 transition-colors">
                                    Voir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 5 - Tableau de bord -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto text-center mb-16">
                <div class="inline-block bg-primary/10 px-4 py-2 rounded-full text-primary font-semibold text-sm mb-4">
                    📊 Tableau de Bord
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Gardez le contrôle sur vos activités
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Un tableau de bord clair et ergonomique pour suivre vos offres, demandes, statistiques et messages.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 mb-12">
                <!-- Stat Card 1 -->
                <div class="bg-gradient-to-br from-primary to-green-700 text-white p-6 rounded-2xl shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold bg-white/20 px-3 py-1 rounded-full">+12%</span>
                    </div>
                    <h3 class="text-3xl font-bold mb-1">24</h3>
                    <p class="text-green-100">Offres actives</p>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-gradient-to-br from-secondary to-green-400 text-white p-6 rounded-2xl shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold bg-white/20 px-3 py-1 rounded-full">+8%</span>
                    </div>
                    <h3 class="text-3xl font-bold mb-1">156</h3>
                    <p class="text-green-100">Messages échangés</p>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-gradient-to-br from-green-600 to-green-800 text-white p-6 rounded-2xl shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold bg-white/20 px-3 py-1 rounded-full">Nouveau</span>
                    </div>
                    <h3 class="text-3xl font-bold mb-1">38</h3>
                    <p class="text-green-100">Connexions établies</p>
                </div>
            </div>

            <!-- Dashboard Mockup -->
            <div class="bg-gray-50 p-8 rounded-3xl shadow-2xl">
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Chart Area -->
                    <div class="bg-white p-6 rounded-2xl">
                        <h4 class="font-semibold text-gray-900 mb-4">Activité des 7 derniers jours</h4>
                        <div class="h-48 flex items-end justify-around gap-2">
                            <div class="w-full bg-gradient-to-t from-primary to-secondary rounded-t-lg" style="height: 60%"></div>
                            <div class="w-full bg-gradient-to-t from-primary to-secondary rounded-t-lg" style="height: 80%"></div>
                            <div class="w-full bg-gradient-to-t from-primary to-secondary rounded-t-lg" style="height: 45%"></div>
                            <div class="w-full bg-gradient-to-t from-primary to-secondary rounded-t-lg" style="height: 90%"></div>
                            <div class="w-full bg-gradient-to-t from-primary to-secondary rounded-t-lg" style="height: 70%"></div>
                            <div class="w-full bg-gradient-to-t from-primary to-secondary rounded-t-lg" style="height: 85%"></div>
                            <div class="w-full bg-gradient-to-t from-primary to-secondary rounded-t-lg" style="height: 95%"></div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white p-6 rounded-2xl">
                        <h4 class="font-semibold text-gray-900 mb-4">Activités récentes</h4>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">Nouvelle offre publiée</p>
                                    <p class="text-xs text-gray-500">Il y a 2 heures</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-secondary/20 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">3 nouveaux messages</p>
                                    <p class="text-xs text-gray-500">Il y a 5 heures</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-accent rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">Offre consultée 12 fois</p>
                                    <p class="text-xs text-gray-500">Hier</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 6 - Blog & Ressources -->
    <section id="blog" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <div class="inline-block bg-primary/10 px-4 py-2 rounded-full text-primary font-semibold text-sm mb-4">
                    📰 Blog & Ressources
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Restez informé des dernières actualités agricoles
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Agrospace vous connecte aussi à l'information : innovations, subventions, formations et témoignages inspirants.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <!-- Article 1 -->
                <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all group">
                    <div class="h-48 bg-gradient-to-br from-primary to-secondary"></div>
                    <div class="p-6">
                        <span class="text-sm text-primary font-semibold">💡 Innovation</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-primary transition-colors">
                            Les nouvelles technologies au service de l'agriculture
                        </h3>
                        <p class="text-gray-600 mb-4">Comment les outils numériques transforment le secteur agricole camerounais...</p>
                        <a href="#" class="text-primary font-semibold hover:underline inline-flex items-center">
                            Lire l'article
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </article>

                <!-- Article 2 -->
                <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all group">
                    <div class="h-48 bg-gradient-to-br from-secondary to-green-300"></div>
                    <div class="p-6">
                        <span class="text-sm text-primary font-semibold">💰 Financement</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-primary transition-colors">
                            Subventions agricoles 2025 : comment en bénéficier
                        </h3>
                        <p class="text-gray-600 mb-4">Guide complet des aides disponibles pour les producteurs agricoles...</p>
                        <a href="#" class="text-primary font-semibold hover:underline inline-flex items-center">
                            Lire l'article
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </article>

                <!-- Article 3 -->
                <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all group">
                    <div class="h-48 bg-gradient-to-br from-green-600 to-primary"></div>
                    <div class="p-6">
                        <span class="text-sm text-primary font-semibold">🎓 Formation</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-primary transition-colors">
                            Formation gratuite : agriculture biologique
                        </h3>
                        <p class="text-gray-600 mb-4">Inscrivez-vous à notre prochaine session de formation aux pratiques bio...</p>
                        <a href="#" class="text-primary font-semibold hover:underline inline-flex items-center">
                            Lire l'article
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </article>
            </div>

            <div class="text-center">
                <a href="#" class="inline-block border-2 border-primary text-primary px-8 py-4 rounded-lg font-semibold hover:bg-primary hover:text-white transition-all">
                    Voir tous les articles du blog
                </a>
            </div>
        </div>
    </section>

    <!-- Section 7 - Sécurité & Fiabilité -->
    <section class="py-20 bg-green-700 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto text-center mb-12">
                <div class="inline-block bg-white/20 px-4 py-2 rounded-full font-semibold text-sm mb-4">
                    🔒 Sécurité Premium
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    Vos données, notre priorité
                </h2>
                <p class="text-xl text-green-50 max-w-3xl mx-auto">
                    Nous utilisons des technologies modernes pour protéger vos informations et garantir une expérience fluide et sécurisée.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Security Feature 1 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">🔐 Sécurité</h3>
                    <p class="text-green-100">Chiffrement SSL et protection des données personnelles</p>
                </div>

                <!-- Security Feature 2 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">🔄 Fiabilité</h3>
                    <p class="text-green-100">Disponibilité 99.9% et sauvegardes automatiques</p>
                </div>

                <!-- Security Feature 3 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">🌍 Disponibilité</h3>
                    <p class="text-green-100">Accessible 24/7 depuis n'importe quel appareil</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final Section -->
    <section class="py-20 gradient-cta text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\" 60\ " height=\"60\ " viewBox=\"0 0 60 60\ " xmlns=\"http://www.w3.org/2000/svg\ "%3E%3Cg fill=\"none\ " fill-rule=\"evenodd\ "%3E%3Cg fill=\"%23ffffff\
                " fill-opacity=\"0.4\ "%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\ "/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Rejoignez la communauté Agrospace dès aujourd'hui
            </h2>
            <p class="text-xl md:text-2xl text-green-50 mb-8 max-w-3xl mx-auto">
                et développez vos activités agricoles grâce à des outils modernes et une communauté engagée
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#" class="bg-white text-primary px-10 py-5 rounded-lg font-bold text-lg hover:bg-accent transition-all shadow-2xl hover:scale-105">
                    Créer un compte maintenant
                </a>
            </div>
            <p class="text-sm text-green-100 mt-6">
                ✓ C'est gratuit, rapide et sans engagement • ✓ Commencez en moins de 2 minutes
            </p>
        </div>
    </section>

    <!-- Footer -->
    <x-layouts.footer />

    <!-- Scroll to top button -->
    <button x-data="{ showButton: false }" x-init="window.addEventListener('scroll', () => { showButton = window.pageYOffset > 300 })" x-show="showButton" x-cloak @click="window.scrollTo({ top: 0, behavior: 'smooth' })" class="fixed bottom-8 right-8 bg-primary text-white w-12 h-12 rounded-full shadow-2xl hover:bg-green-800 transition-all hover:scale-110 flex items-center justify-center z-40">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

</body>
</div>
