<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.main')] class extends Component {
    //
}; ?>

<div>

    <x-layouts.header/>

     <!-- Hero Section -->
     <section class="relative pt-24 pb-20 md:pt-32 md:pb-28 overflow-hidden gradient-bg">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-white space-y-6 animate-fade-in-up">
                    <div class="inline-block bg-white/20 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                        🌾 Espace Producteurs
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        Vous produisez, <span class="text-yellow-300">Agrospace</span> vous connecte à vos futurs clients
                    </h1>
                    <p class="text-lg md:text-xl text-green-50 leading-relaxed">
                        Valorisez vos produits agricoles, gagnez en visibilité et trouvez de nouvelles opportunités sans intermédiaires.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="/register?type=producteur" class="bg-white text-base px-8 py-4 rounded-lg font-bold hover:bg-yellow-300 hover:text-base transition-all shadow-xl hover:shadow-2xl text-center text-lg">
                            Devenir Producteur sur Agrospace
                        </a>
                        <a href="/fonctionnalites" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-base transition-all text-center">
                            Découvrir la plateforme
                        </a>
                    </div>
                    <div class="flex items-center gap-6 pt-6 text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>100% Gratuit</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Sans intermédiaires</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Simple & Rapide</span>
                        </div>
                    </div>
                </div>

                <!-- Right Illustration -->
                <div class="hidden md:block animate-float">
                    <svg class="w-full h-auto" viewBox="0 0 500 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Farmer illustration -->
                        <circle cx="250" cy="200" r="150" fill="#81C784" opacity="0.3"/>
                        <rect x="200" y="180" width="100" height="120" rx="10" fill="#F5F5DC"/>
                        <circle cx="250" cy="140" r="30" fill="#FFE4B5"/>
                        <rect x="190" y="300" width="120" height="60" rx="8" fill="#8B4513"/>
                        <circle cx="150" cy="320" r="40" fill="#4CAF50" opacity="0.6"/>
                        <circle cx="350" cy="300" r="35" fill="#4CAF50" opacity="0.6"/>
                        <circle cx="250" cy="80" r="30" fill="#FFD700" opacity="0.8"/>
                        <path d="M 100 350 Q 250 320 400 350" stroke="#81C784" stroke-width="4" fill="none"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Avantages Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Les avantages pour les producteurs agricoles</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Agrospace vous donne tous les outils pour faire grandir votre activité et toucher de nouveaux clients
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Avantage 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 border-t-4 border-base group">
                    <div class="w-16 h-16 bg-base/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Visibilité régionale et nationale</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Soyez découvert par de nouveaux clients dans votre région et au-delà grâce à notre plateforme.
                    </p>
                </div>

                <!-- Avantage 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 border-t-4 border-secondary group">
                    <div class="w-16 h-16 bg-secondary/20 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Gestion simple de vos offres</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Créez, modifiez ou supprimez vos annonces facilement depuis votre tableau de bord.
                    </p>
                </div>

                <!-- Avantage 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 border-t-4 border-base group">
                    <div class="w-16 h-16 bg-base/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Communication directe</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Discutez, négociez et construisez des relations durables avec vos clients via la messagerie intégrée.
                    </p>
                </div>

                <!-- Avantage 4 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 border-t-4 border-secondary group">
                    <div class="w-16 h-16 bg-secondary/20 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Tableau de bord intuitif</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Suivez vos activités, vos vues et vos messages en un coup d'œil avec des statistiques claires.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Témoignages Section -->
    <section class="py-20 bg-emerald-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Ils font déjà confiance à Agrospace</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Découvrez les témoignages de producteurs qui ont transformé leur activité grâce à notre plateforme
                </p>
            </div>

            <div class="max-w-5xl mx-auto" x-data="{
                testimonials: [
                    {
                        name: 'Marie Kouam',
                        location: 'Productrice Bio - Bafoussam',
                        text: 'Grâce à Agrospace, j\'ai trouvé un partenaire en 3 jours ! Mes légumes bio sont maintenant distribués dans 5 restaurants de la région. La plateforme est simple et les clients sont sérieux.',
                        avatar: '👩🏾‍🌾',
                        rating: 5
                    },
                    {
                        name: 'Jean Nkeng',
                        location: 'Éleveur de volailles - Douala',
                        text: 'Avant Agrospace, je perdais beaucoup de temps à chercher des clients. Maintenant, ce sont eux qui me contactent directement. J\'ai augmenté mes ventes de 40% en 2 mois !',
                        avatar: '👨🏾‍🌾',
                        rating: 5
                    },
                    {
                        name: 'Aïcha Mohamadou',
                        location: 'Coopérative laitière - Maroua',
                        text: 'Nous avons multiplié nos ventes par 3 en 6 mois. Agrospace nous a permis d\'atteindre de nouveaux marchés sans frais d\'intermédiaires. C\'est révolutionnaire pour nous !',
                        avatar: '👩🏾‍💼',
                        rating: 5
                    }
                ],
                currentIndex: 0
            }" x-init="setInterval(() => { currentIndex = (currentIndex + 1) % testimonials.length }, 6000)">
                
                <div class="relative">
                    <template x-for="(testimonial, index) in testimonials" :key="index">
                        <div x-show="currentIndex === index" 
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             class="bg-white p-12 rounded-3xl shadow-2xl">
                            
                            <div class="flex flex-col md:flex-row items-center gap-8">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <div class="w-32 h-32 bg-gradient-to-br from-base to-secondary rounded-full flex items-center justify-center text-6xl shadow-xl">
                                        <span x-text="testimonial.avatar"></span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 text-center md:text-left">
                                    <!-- Stars -->
                                    <div class="flex justify-center md:justify-start gap-1 mb-4">
                                        <template x-for="i in 5">
                                            <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </template>
                                    </div>

                                    <!-- Quote -->
                                    <p class="text-xl text-gray-700 leading-relaxed mb-6 italic" x-text="'« ' + testimonial.text + ' »'"></p>

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
                <a href="/register?type=producteur" class="inline-block bg-base text-white px-10 py-5 rounded-lg font-bold text-lg hover:bg-green-800 transition-all shadow-xl hover:shadow-2xl hover:scale-105">
                    Rejoindre Agrospace maintenant
                </a>
            </div>
        </div>
    </section>

    <!-- Fonctionnalités Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Tout ce dont vous avez besoin pour développer votre activité</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Des outils simples et puissants pour gérer votre présence en ligne et connecter avec vos clients
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
                <!-- Features List -->
                <div class="space-y-6">
                    <div class="flex items-start gap-4 p-6 bg-gray-50 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="flex-shrink-0 w-12 h-12 bg-base/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">📦 Créez vos offres facilement</h4>
                            <p class="text-gray-600">Publiez vos produits en quelques clics avec photos et descriptions détaillées.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-6 bg-gray-50 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="flex-shrink-0 w-12 h-12 bg-secondary/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">🖼️ Ajoutez photos et descriptions</h4>
                            <p class="text-gray-600">Mettez en valeur vos produits avec des visuels attrayants et des informations complètes.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-6 bg-gray-50 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="flex-shrink-0 w-12 h-12 bg-base/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">🧭 Indiquez votre localisation</h4>
                            <p class="text-gray-600">Les clients locaux vous trouvent facilement grâce à la carte interactive.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-6 bg-gray-50 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="flex-shrink-0 w-12 h-12 bg-secondary/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">💬 Échangez directement</h4>
                            <p class="text-gray-600">Messagerie instantanée pour négocier et construire des relations durables.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-6 bg-gray-50 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="flex-shrink-0 w-12 h-12 bg-base/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">📊 Analysez vos statistiques</h4>
                            <p class="text-gray-600">Tableau de bord détaillé pour suivre vos performances et optimiser votre visibilité.</p>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Mockup -->
                <div class="bg-gradient-to-br from-base/10 to-secondary/20 p-8 rounded-3xl">
                    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-base to-green-600 p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-bold">Tableau de Bord Producteur</h3>
                                    <p class="text-sm text-green-100">Gérez votre activité en un clin d'œil</p>
                                </div>
                                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Cards -->
                        <div class="p-6 grid grid-cols-2 gap-4">
                            <div class="bg-green-50 p-4 rounded-xl">
                                <p class="text-sm text-gray-600 mb-1">Offres actives</p>
                                <p class="text-3xl font-bold text-base">12</p>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-xl">
                                <p class="text-sm text-gray-600 mb-1">Vues ce mois</p>
                                <p class="text-3xl font-bold text-blue-600">348</p>
                            </div>
                            <div class="bg-yellow-50 p-4 rounded-xl">
                                <p class="text-sm text-gray-600 mb-1">Messages</p>
                                <p class="text-3xl font-bold text-yellow-600">27</p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-xl">
                                <p class="text-sm text-gray-600 mb-1">Connexions</p>
                                <p class="text-3xl font-bold text-purple-600">8</p>
                            </div>
                        </div>

                        <!-- Chart Area -->
                        <div class="p-6 border-t">
                            <p class="text-sm text-gray-600 mb-4 font-semibold">Activité des 7 derniers jours</p>
                            <div class="h-32 flex items-end justify-around gap-2">
                                <div class="w-full bg-gradient-to-t from-base to-secondary rounded-t-lg" style="height: 60%"></div>
                                <div class="w-full bg-gradient-to-t from-base to-secondary rounded-t-lg" style="height: 80%"></div>
                                <div class="w-full bg-gradient-to-t from-base to-secondary rounded-t-lg" style="height: 45%"></div>
                                <div class="w-full bg-gradient-to-t from-base to-secondary rounded-t-lg" style="height: 90%"></div>
                                <div class="w-full bg-gradient-to-t from-base to-secondary rounded-t-lg" style="height: 70%"></div>
                                <div class="w-full bg-gradient-to-t from-base to-secondary rounded-t-lg" style="height: 85%"></div>
                                <div class="w-full bg-gradient-to-t from-base to-secondary rounded-t-lg" style="height: 95%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Parcours Section -->
    <section class="py-20 bg-[#FAF7F0]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Comment ça marche ?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Rejoignez Agrospace en 3 étapes simples et commencez à développer votre activité dès aujourd'hui
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <!-- Étape 1 -->
                <div class="relative">
                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all h-full">
                        <div class="absolute -top-6 left-8 w-16 h-16 bg-gradient-to-br from-base to-secondary rounded-full flex items-center justify-center shadow-xl">
                            <span class="text-3xl font-bold text-white">1</span>
                        </div>
                        <div class="pt-8">
                            <div class="w-16 h-16 bg-base/10 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Créez votre compte producteur</h3>
                            <p class="text-gray-600 text-center leading-relaxed">
                                Inscrivez-vous gratuitement, renseignez vos informations et ajoutez votre photo de profil.
                            </p>
                        </div>
                    </div>
                    <!-- Arrow -->
                    <div class="hidden md:block absolute top-12 -right-4 text-secondary animate-pulse-slow">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </div>

                <!-- Étape 2 -->
                <div class="relative">
                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all h-full">
                        <div class="absolute -top-6 left-8 w-16 h-16 bg-gradient-to-br from-base to-secondary rounded-full flex items-center justify-center shadow-xl">
                            <span class="text-3xl font-bold text-white">2</span>
                        </div>
                        <div class="pt-8">
                            <div class="w-16 h-16 bg-secondary/20 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Publiez votre première offre</h3>
                            <p class="text-gray-600 text-center leading-relaxed">
                                Ajoutez vos produits, prix indicatifs, photos et localisation en quelques clics.
                            </p>
                        </div>
                    </div>
                    <!-- Arrow -->
                    <div class="hidden md:block absolute top-12 -right-4 text-secondary animate-pulse-slow">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </div>

                <!-- Étape 3 -->
                <div class="relative">
                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all h-full">
                        <div class="absolute -top-6 left-8 w-16 h-16 bg-gradient-to-br from-base to-secondary rounded-full flex items-center justify-center shadow-xl">
                            <span class="text-3xl font-bold text-white">3</span>
                        </div>
                        <div class="pt-8">
                            <div class="w-16 h-16 bg-base/10 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-8 h-8 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Recevez vos premiers contacts</h3>
                            <p class="text-gray-600 text-center leading-relaxed">
                                Discutez directement via la messagerie intégrée et finalisez vos ventes.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="/register?type=producteur" class="inline-block bg-base text-white px-10 py-5 rounded-lg font-bold text-lg hover:bg-green-800 transition-all shadow-xl hover:shadow-2xl hover:scale-105">
                    Commencer gratuitement
                </a>
                <p class="text-sm text-gray-600 mt-4">✓ Aucune carte bancaire requise • ✓ Inscription en 2 minutes</p>
            </div>
        </div>
    </section>

    <!-- Chiffres & Impact Section -->
    <section class="py-20 bg-gradient-to-br from-secondary/20 to-green-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Une communauté agricole en pleine croissance</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Des chiffres qui témoignent de la confiance des producteurs africains
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Stat 1 -->
                <div class="bg-white p-10 rounded-3xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 text-center">
                    <div class="w-20 h-20 bg-base/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <p class="text-5xl font-bold text-green-700 mb-3">+500</p>
                    <p class="text-xl text-gray-700 font-semibold">Producteurs inscrits</p>
                    <p class="text-sm text-gray-500 mt-2">Et le nombre ne cesse de croître chaque jour</p>
                </div>

                <!-- Stat 2 -->
                <div class="bg-white p-10 rounded-3xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 text-center">
                    <div class="w-20 h-20 bg-secondary/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <p class="text-5xl font-bold text-green-700 mb-3">+1,200</p>
                    <p class="text-xl text-gray-700 font-semibold">Connexions créées</p>
                    <p class="text-sm text-gray-500 mt-2">Entre producteurs et consommateurs locaux</p>
                </div>

                <!-- Stat 3 -->
                <div class="bg-white p-10 rounded-3xl shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 text-center">
                    <div class="w-20 h-20 bg-base/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-5xl font-bold text-green-700 mb-3">+30</p>
                    <p class="text-xl text-gray-700 font-semibold">Régions couvertes</p>
                    <p class="text-sm text-gray-500 mt-2">À travers tout le Cameroun et au-delà</p>
                </div>
            </div>

            <!-- Trust badges -->
            <div class="mt-16 text-center">
                <p class="text-gray-600 mb-6 font-semibold">Ils nous font confiance :</p>
                <div class="flex flex-wrap justify-center items-center gap-8 opacity-60">
                    <div class="bg-white px-8 py-4 rounded-lg shadow">
                        <p class="text-lg font-bold text-gray-700">Coopératives Agricoles</p>
                    </div>
                    <div class="bg-white px-8 py-4 rounded-lg shadow">
                        <p class="text-lg font-bold text-gray-700">Fermiers Indépendants</p>
                    </div>
                    <div class="bg-white px-8 py-4 rounded-lg shadow">
                        <p class="text-lg font-bold text-gray-700">Éleveurs</p>
                    </div>
                    <div class="bg-white px-8 py-4 rounded-lg shadow">
                        <p class="text-lg font-bold text-gray-700">Apiculteurs</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final Section -->
    <section class="py-20 gradient-cta text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Rejoignez la communauté Agrospace et valorisez vos produits agricoles dès aujourd'hui
            </h2>
            <p class="text-xl md:text-2xl text-green-50 mb-10 max-w-3xl mx-auto">
                Des milliers de producteurs ont déjà choisi Agrospace pour développer leur activité. Pourquoi pas vous ?
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="/register?type=producteur" class="bg-white text-base px-12 py-6 rounded-lg font-bold text-xl hover:bg-yellow-300 transition-all shadow-2xl hover:scale-105">
                    S'inscrire comme Producteur
                </a>
                <a href="/offres" class="bg-transparent border-2 border-white text-white px-12 py-6 rounded-lg font-bold text-xl hover:bg-white hover:text-base transition-all">
                    Découvrir les offres
                </a>
            </div>
            <p class="text-sm text-green-100 mt-8">
                ✓ Gratuit à vie • ✓ Aucune commission • ✓ Support dédié 7j/7
            </p>
        </div>
    </section>

    <x-layouts.footer/>
</div>
