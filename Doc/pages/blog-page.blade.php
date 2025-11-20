<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.main')] class extends Component {
    //
}; ?>

<div x-data="blogData()">

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
                        Actualités & <span class="text-secondary">Innovations</span> du monde agropastoral
                    </h1>
                    <p class="text-lg md:text-xl text-gray-50 leading-relaxed">
                        Découvrez les tendances, les conseils et les histoires inspirantes de la communauté Agrospace.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <!-- Bouton principal -->
                        <a href="#articles"
                            class="flex items-center justify-center gap-2 bg-[#1B5E20] text-white px-8 py-4 rounded-xl font-semibold 
                                   hover:bg-[#2E7D32] hover:scale-[1.03] transition-all duration-300 shadow-lg hover:shadow-2xl 
                                   text-center w-full sm:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                            Lire les derniers articles
                        </a>
                    </div>
    
                    <!-- Statistiques Blog (optionnel) -->
                    <div class="flex items-center gap-8 pt-6 flex-wrap">
                        <div class="text-center">
                            <div class="text-3xl font-bold">200+</div>
                            <div class="text-sm text-green-50">Articles publiés</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold">50+</div>
                            <div class="text-sm text-green-50">Experts contributeurs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold">10,000+</div>
                            <div class="text-sm text-green-50">Lecteurs engagés</div>
                        </div>
                    </div>
                </div>
    
                <!-- Right Illustration -->
                <div class="hidden md:block">
                    <div class="relative">
                        <svg class="w-full h-auto" viewBox="0 0 500 400" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <!-- Illustration blog : documents, articles, innovation -->
                            <circle cx="250" cy="200" r="180" fill="#81C784" opacity="0.15" />
                            <rect x="160" y="180" width="180" height="120" rx="8" fill="#F5F5DC" />
                            <line x1="180" y1="200" x2="320" y2="200" stroke="#1B5E20" stroke-width="2"/>
                            <line x1="180" y1="220" x2="320" y2="220" stroke="#1B5E20" stroke-width="2"/>
                            <line x1="180" y1="240" x2="320" y2="240" stroke="#1B5E20" stroke-width="2"/>
                            <polygon points="200,150 240,100 280,150" fill="#FFD700" opacity="0.8" />
                            <circle cx="120" cy="300" r="15" fill="#4CAF50" />
                            <circle cx="380" cy="290" r="18" fill="#4CAF50" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <!-- Article en vedette -->
    <section class="py-16 bg-[#FAF7F0]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">À la une 🌾</h2>
            </div>

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-300">
                <div class="grid md:grid-cols-2 gap-0">
                    <div
                        class="h-64 md:h-full bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center">
                        <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="p-8 md:p-12 flex flex-col justify-center">
                        <span
                            class="inline-block bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full mb-4 w-fit">
                            Article du mois
                        </span>
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">
                            Comment l'agriculture numérique transforme le Cameroun
                        </h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            L'adoption des technologies digitales dans le secteur agricole camerounais connaît une
                            croissance remarquable. Découvrez comment les plateformes comme Agrospace révolutionnent la
                            collaboration entre producteurs et consommateurs, créant de nouvelles opportunités pour
                            tous.
                        </p>
                        <div class="flex items-center text-sm text-gray-500 mb-6">
                            <span class="mr-4">Par Marie Kouam</span>
                            <span>15 Octobre 2025</span>
                        </div>
                        <a href="#"
                            class="inline-block bg-[#1B5E20] text-white px-6 py-3 rounded-lg hover:bg-[#2E7D32] transition w-fit">
                            Lire l'article complet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recherche et filtres -->
    <section class="py-12 bg-white" id="articles">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Barre de recherche -->
            <div class="max-w-2xl mx-auto mb-8">
                <div class="relative">
                    <input type="text" x-model="searchQuery" placeholder="Rechercher un article ou un thème..."
                        class="w-full px-6 py-4 pr-12 rounded-xl border-2 border-gray-200 focus:border-[#1B5E20] focus:outline-none transition shadow-sm">
                    <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Filtres par catégorie -->
            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button @click="selectedCategory = 'tous'"
                    :class="selectedCategory === 'tous' ? 'bg-[#1B5E20] text-white' :
                        'bg-gray-100 text-gray-700 hover:bg-green-100'"
                    class="px-6 py-2 rounded-full font-medium transition">
                    Tous
                </button>
                <button @click="selectedCategory = 'innovations'"
                    :class="selectedCategory === 'innovations' ? 'bg-[#1B5E20] text-white' :
                        'bg-gray-100 text-gray-700 hover:bg-green-100'"
                    class="px-6 py-2 rounded-full font-medium transition">
                    🌱 Innovations
                </button>
                <button @click="selectedCategory = 'formations'"
                    :class="selectedCategory === 'formations' ? 'bg-[#1B5E20] text-white' :
                        'bg-gray-100 text-gray-700 hover:bg-green-100'"
                    class="px-6 py-2 rounded-full font-medium transition">
                    🎓 Formations
                </button>
                <button @click="selectedCategory = 'subventions'"
                    :class="selectedCategory === 'subventions' ? 'bg-[#1B5E20] text-white' :
                        'bg-gray-100 text-gray-700 hover:bg-green-100'"
                    class="px-6 py-2 rounded-full font-medium transition">
                    💰 Subventions
                </button>
                <button @click="selectedCategory = 'temoignages'"
                    :class="selectedCategory === 'temoignages' ? 'bg-[#1B5E20] text-white' :
                        'bg-gray-100 text-gray-700 hover:bg-green-100'"
                    class="px-6 py-2 rounded-full font-medium transition">
                    🤝 Témoignages
                </button>
            </div>

            <!-- Grille d'articles -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <template x-for="article in filteredArticles" :key="article.id">
                    <div
                        class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="h-48 bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center"
                            :class="article.bgColor">
                            <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    :d="article.icon" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <span
                                class="inline-block bg-green-100 text-[#1B5E20] text-xs font-bold px-3 py-1 rounded-full mb-3"
                                x-text="article.categoryLabel"></span>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight" x-text="article.title"></h3>
                            <p class="text-gray-600 mb-4 text-sm leading-relaxed" x-text="article.excerpt"></p>
                            <div class="flex items-center text-xs text-gray-500 mb-4">
                                <span class="mr-3" x-text="article.author"></span>
                                <span x-text="article.date"></span>
                            </div>
                            <a href="#"
                                class="inline-block text-[#1B5E20] font-semibold hover:text-[#2E7D32] transition">
                                Lire l'article →
                            </a>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Message si aucun résultat -->
            <div x-show="filteredArticles.length === 0" class="text-center py-12">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-500 text-lg">Aucun article trouvé pour cette recherche.</p>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center items-center space-x-2 mt-12">
                <button class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
                    Précédent
                </button>
                <button class="px-4 py-2 rounded-lg bg-[#1B5E20] text-white">1</button>
                <button
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">2</button>
                <button
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">3</button>
                <button class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
                    Suivant
                </button>
            </div>
        </div>
    </section>

    <!-- Thématiques populaires -->
    <section class="py-20 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Explorez par thématique</h2>
                <p class="text-xl text-gray-600">Trouvez les sujets qui vous intéressent</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <a href="#"
                    class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 text-center group">
                    <div class="text-5xl mb-4 group-hover:scale-110 transition">🌱</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Agriculture durable</h3>
                    <p class="text-sm text-gray-600">24 articles</p>
                </a>

                <a href="#"
                    class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 text-center group">
                    <div class="text-5xl mb-4 group-hover:scale-110 transition">🚜</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Innovation & technologie</h3>
                    <p class="text-sm text-gray-600">18 articles</p>
                </a>

                <a href="#"
                    class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 text-center group">
                    <div class="text-5xl mb-4 group-hover:scale-110 transition">👩‍🌾</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Témoignages de producteurs</h3>
                    <p class="text-sm text-gray-600">32 articles</p>
                </a>

                <a href="#"
                    class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 text-center group">
                    <div class="text-5xl mb-4 group-hover:scale-110 transition">💰</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Financements & subventions</h3>
                    <p class="text-sm text-gray-600">15 articles</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-20 bg-gradient-to-r from-emerald-400 to-green-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">
                📬 Restez informé des dernières nouvelles
            </h2>
            <p class="text-xl text-green-50 mb-8">
                Recevez les innovations agricoles et les histoires inspirantes directement dans votre boîte mail.
            </p>

            <form class="max-w-xl mx-auto">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="email" placeholder="Votre adresse email"
                        class="flex-1 px-6 py-4 rounded-xl border-0 focus:ring-2 focus:ring-white focus:outline-none">
                    <button type="submit"
                        class="bg-[#1B5E20] text-primary-100 px-8 py-4 rounded-xl font-bold hover:bg-green-600 transition shadow-lg">
                        S'abonner
                    </button>
                </div>
                <p class="text-green-100 text-sm mt-4">
                    Aucune publicité. Vous pouvez vous désabonner à tout moment.
                </p>
            </form>
        </div>
    </section>

    <!-- Call to Action final -->
    <section class="py-20 bg-[#1B5E20]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">
                Agrospace, c'est plus qu'une plateforme
            </h2>
            <p class="text-xl text-green-100 mb-8">
                C'est une communauté agricole qui avance ensemble vers un avenir durable et prospère.
            </p>
            <a href="/inscription"
                class="inline-block bg-white text-[#1B5E20] px-10 py-4 rounded-xl font-bold hover:bg-gray-100 transition shadow-xl transform hover:-translate-y-1">
                Rejoindre la communauté
            </a>
            <p class="text-green-200 mt-4">
                Inscrivez-vous gratuitement et connectez-vous aux producteurs et consommateurs près de chez vous.
            </p>
        </div>
    </section>

    <!-- Footer -->
    <x-layouts.footer />

    @push('scripts')
        <script>
            function blogData() {
                return {
                    searchQuery: '',
                    selectedCategory: 'tous',
                    articles: [{
                            id: 1,
                            title: "Les 5 tendances de l'agriculture durable en 2025",
                            excerpt: "L'agriculture durable évolue rapidement. Découvrez les innovations qui transforment le secteur et comment les adopter dans votre exploitation.",
                            category: "innovations",
                            categoryLabel: "Innovations",
                            author: "Jean Nkoulou",
                            date: "20 Oct 2025",
                            icon: "M13 10V3L4 14h7v7l9-11h-7z",
                            bgColor: "from-green-400 to-emerald-600"
                        },
                        {
                            id: 2,
                            title: "Comment accéder aux subventions agricoles au Cameroun",
                            excerpt: "Guide complet pour identifier et obtenir les financements disponibles pour votre projet agricole. Toutes les étapes expliquées simplement.",
                            category: "subventions",
                            categoryLabel: "Subventions",
                            author: "Marie Kouam",
                            date: "18 Oct 2025",
                            icon: "M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
                            bgColor: "from-yellow-400 to-orange-500"
                        },
                        {
                            id: 3,
                            title: "Témoignage : De 2 hectares à une coopérative florissante",
                            excerpt: "L'histoire inspirante de Paul Mbarga qui a transformé sa petite exploitation en une coopérative prospère grâce à la collaboration locale.",
                            category: "temoignages",
                            categoryLabel: "Témoignages",
                            author: "Rüdiger Feutsop",
                            date: "15 Oct 2025",
                            icon: "M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z",
                            bgColor: "from-blue-400 to-indigo-500"
                        },
                        {
                            id: 4,
                            title: "Formation gratuite : Gestion moderne d'une exploitation",
                            excerpt: "Inscrivez-vous à notre formation en ligne pour apprendre les bases de la gestion agricole moderne et optimiser votre production.",
                            category: "formations",
                            categoryLabel: "Formations",
                            author: "Jean Nkoulou",
                            date: "12 Oct 2025",
                            icon: "M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253",
                            bgColor: "from-purple-400 to-pink-500"
                        },
                        {
                            id: 5,
                            title: "L'irrigation intelligente : économiser l'eau et augmenter les rendements",
                            excerpt: "Découvrez comment les systèmes d'irrigation modernes peuvent réduire votre consommation d'eau de 40% tout en améliorant vos récoltes.",
                            category: "innovations",
                            categoryLabel: "Innovations",
                            author: "Marie Kouam",
                            date: "10 Oct 2025",
                            icon: "M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z",
                            bgColor: "from-cyan-400 to-blue-500"
                        },
                        {
                            id: 6,
                            title: "Appel à projets : Fonds d'innovation agricole 2025",
                            excerpt: "Le gouvernement camerounais lance un nouveau programme de financement pour les projets agricoles innovants. Candidatez avant le 30 novembre.",
                            category: "subventions",
                            categoryLabel: "Subventions",
                            author: "Rüdiger Feutsop",
                            date: "8 Oct 2025",
                            icon: "M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z",
                            bgColor: "from-red-400 to-pink-500"
                        },
                        {
                            id: 7,
                            title: "Portrait : Sophie, éleveuse innovante de la région de l'Ouest",
                            excerpt: "Rencontrez Sophie Tchuente, une éleveuse qui a révolutionné l'élevage de volailles dans sa région grâce aux techniques modernes.",
                            category: "temoignages",
                            categoryLabel: "Témoignages",
                            author: "Marie Kouam",
                            date: "5 Oct 2025",
                            icon: "M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z",
                            bgColor: "from-green-400 to-teal-500"
                        },
                        {
                            id: 8,
                            title: "Webinaire : Marketing digital pour producteurs agricoles",
                            excerpt: "Apprenez à vendre vos produits en ligne et à toucher de nouveaux clients grâce aux outils numériques. Session interactive le 25 octobre.",
                            category: "formations",
                            categoryLabel: "Formations",
                            author: "Jean Nkoulou",
                            date: "3 Oct 2025",
                            icon: "M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z",
                            bgColor: "from-indigo-400 to-purple-500"
                        },
                        {
                            id: 9,
                            title: "Blockchain et agriculture : traçabilité et transparence",
                            excerpt: "Comment la blockchain transforme la chaîne d'approvisionnement agricole et renforce la confiance des consommateurs.",
                            category: "innovations",
                            categoryLabel: "Innovations",
                            author: "Rüdiger Feutsop",
                            date: "1 Oct 2025",
                            icon: "M13 10V3L4 14h7v7l9-11h-7z",
                            bgColor: "from-emerald-400 to-green-600"
                        }
                    ],
                    get filteredArticles() {
                        let filtered = this.articles;

                        // Filtre par catégorie
                        if (this.selectedCategory !== 'tous') {
                            filtered = filtered.filter(article => article.category === this.selectedCategory);
                        }

                        // Filtre par recherche
                        if (this.searchQuery.trim() !== '') {
                            const query = this.searchQuery.toLowerCase();
                            filtered = filtered.filter(article =>
                                article.title.toLowerCase().includes(query) ||
                                article.excerpt.toLowerCase().includes(query) ||
                                article.categoryLabel.toLowerCase().includes(query)
                            );
                        }

                        return filtered;
                    }
                }
            }
        </script>
    @endpush


</div>
