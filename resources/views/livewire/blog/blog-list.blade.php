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
    @if($featuredPost)
        <section class="py-16 bg-gradient-to-br from-yellow-50 via-white to-green-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center mb-8">
                    <svg class="w-8 h-8 text-yellow-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <h2 class="text-3xl font-bold text-gray-900">À la une</h2>
                </div>

                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden hover:shadow-3xl transition-all duration-300 group">
                    <div class="grid md:grid-cols-2 gap-0">
                        <div class="relative h-64 md:h-full overflow-hidden">
                             @if($featuredPost->featured_image)
                                   <img src="{{ Storage::url($featuredPost->featured_image) }}" alt="{{ $featuredPost->title }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center">
                                    <svg class="w-32 h-32 text-white opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7.414A2 2 0 0013.414 6L12 4.586A2 2 0 0010.586 4H5a2 2 0 00-2 2v12a2 2 0 002 2h14z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="inline-block bg-yellow-400 text-yellow-900 text-xs font-bold px-4 py-2 rounded-full shadow-lg">
                                    ⭐ Article vedette
                                </span>
                            </div>
                        </div>
                        <div class="p-8 md:p-12 flex flex-col justify-center">
                            @if($featuredPost->category)
                                <span class="inline-block bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full mb-4 w-fit">
                                    {{ $featuredPost->category->name }}
                                </span>
                            @endif
                            <a href="{{ route('blog.show', $featuredPost->slug) }}" wire:navigate
                             class="text-3xl font-bold text-gray-900 mb-4 group-hover:text-green-600 transition">
                                {{ $featuredPost->title }}
                            </a>
                            @if($featuredPost->subtitle)
                                <p class="text-lg text-gray-700 mb-4 font-medium">{{ $featuredPost->subtitle }}</p>
                            @endif
                            <p class="text-gray-600 mb-6 leading-relaxed line-clamp-3">
                                {{ $featuredPost->excerpt }}
                            </p>
                            <div class="flex items-center text-sm text-gray-500 mb-6 space-x-4">
                                <span class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>{{ $featuredPost->author->name }}</span>
                                </span>
                                <span>{{ $featuredPost->published_at->isoFormat('D MMMM YYYY') }}</span>
                                <span>{{ $featuredPost->reading_time_text }}</span>
                            </div>
                            <a href="{{ route('blog.show', $featuredPost->slug) }}" wire:navigate
                                class="inline-flex items-center space-x-2 bg-gradient-to-r from-green-600 to-green-700 text-white px-8 py-4 rounded-xl font-semibold hover:from-green-700 hover:to-green-800 transition-all shadow-lg hover:shadow-xl transform hover:scale-105 w-fit">
                                <span>Lire l'article complet</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Recherche et filtres -->
    <section class="py-12 bg-white" id="articles">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Barre de recherche -->
            <div class="max-w-2xl mx-auto mb-8">
                <div class="relative">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Rechercher un article ou un thème..."
                        class="w-full px-6 py-4 pr-12 rounded-xl border-2 border-gray-200 focus:border-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 transition shadow-sm">
                    <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Filtres par catégorie -->
            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button wire:click="selectCategory('tous')"
                    class="px-6 py-3 rounded-full font-semibold transition-all transform hover:scale-105 shadow-md hover:shadow-lg {{ $selectedCategory === 'tous' ? 'bg-gradient-to-r from-green-600 to-green-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-green-100' }}">
                    📚 Tous
                </button>
                @foreach($categories as $category)
                    <button wire:click="selectCategory({{ $category->id }})"
                        class="px-6 py-3 rounded-full font-semibold transition-all transform hover:scale-105 shadow-md hover:shadow-lg {{ $selectedCategory == $category->id ? 'bg-gradient-to-r from-green-600 to-green-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-green-100' }}">
                        {{ $category->icon ?? '📁' }} {{ $category->name }}
                        <span class="ml-1 text-xs opacity-75">({{ $category->posts()->count() }})</span>
                    </button>
                @endforeach
            </div>

            <!-- Tags populaires -->
            @if($popularTags->isNotEmpty())
                <div class="flex flex-wrap justify-center gap-2 mb-8">
                    <span class="text-sm text-gray-600 self-center mr-2">Tags populaires:</span>
                    @foreach($popularTags->take(10) as $tag)
                        <button wire:click="selectTag({{ $tag->id }})"
                            class="px-3 py-1 text-sm rounded-full transition-all {{ $selectedTag == $tag->id ? 'bg-green-500 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                            #{{ $tag->name }}
                        </button>
                    @endforeach
                </div>
            @endif

            <!-- Options de tri -->
            <div class="flex flex-wrap items-center justify-between mb-8 gap-4">
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Trier par:</span>
                    <div class="flex items-center space-x-2">
                        <button wire:click="$set('sortBy', 'recent')"
                            class="px-4 py-2 text-sm rounded-lg transition {{ $sortBy === 'recent' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Plus récents
                        </button>
                        <button wire:click="$set('sortBy', 'popular')"
                            class="px-4 py-2 text-sm rounded-lg transition {{ $sortBy === 'popular' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Plus populaires
                        </button>
                        <button wire:click="$set('sortBy', 'likes')"
                            class="px-4 py-2 text-sm rounded-lg transition {{ $sortBy === 'likes' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Plus aimés
                        </button>
                    </div>
                </div>

                @if($search || $selectedCategory !== 'tous' || $selectedTag)
                    <button wire:click="resetFilters"
                        class="flex items-center space-x-2 text-sm text-red-600 hover:text-red-700 font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Effacer les filtres</span>
                    </button>
                @endif
            </div>

            <!-- Loading state -->
            <div wire:loading.delay class="text-center py-12 w-full">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-green-600"></div>
                <p class="text-gray-600 mt-4">Chargement des articles...</p>
            </div>

            <!-- Grille d'articles -->
            <div wire:loading.remove class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($posts as $post)
                    <article class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                        <a href="{{ route('blog.show', $post->slug) }}" wire:navigate>
                            <div class="relative h-48 overflow-hidden">
                                @if($post->featured_image)
                                   <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7.414A2 2 0 0013.414 6L12 4.586A2 2 0 0010.586 4H5a2 2 0 00-2 2v12a2 2 0 002 2h14z" />
                                        </svg>
                                    </div>
                                @endif
                                @if($post->category)
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-block bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                            {{ $post->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </a>
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3 space-x-3">
                                <span class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $post->published_at->diffForHumans() }}</span>
                                </span>
                                <span>•</span>
                                <span>{{ $post->reading_time_text }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight group-hover:text-green-600 transition line-clamp-2">
                                <a href="{{ route('blog.show', $post->slug) }}" wire:navigate>
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-4 text-sm leading-relaxed line-clamp-3">
                                {{ $post->excerpt }}
                            </p>

                            <!-- Tags -->
                            @if($post->tags->isNotEmpty())
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($post->tags->take(3) as $tag)
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                                            #{{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Stats & Author -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center space-x-3 text-sm text-gray-500">
                                    <span class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>{{ number_format($post->views_count) }}</span>
                                    </span>
                                    <span class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        <span>{{ number_format($post->likes_count) }}</span>
                                    </span>
                                    <span class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <span>{{ number_format($post->comments_count) }}</span>
                                    </span>
                                </div>
                                <a href="{{ route('blog.show', $post->slug) }}" wire:navigate
                                   class="text-green-600 hover:text-green-700 font-semibold text-sm flex items-center space-x-1 group">
                                    <span>Lire</span>
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucun article trouvé</h3>
                        <p class="text-gray-500 mb-4">Aucun article ne correspond à vos critères de recherche.</p>
                        @if($search || $selectedCategory !== 'tous' || $selectedTag)
                            <button wire:click="resetFilters" 
                                class="inline-flex items-center space-x-2 bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition font-semibold">
                                <span>Réinitialiser les filtres</span>
                            </button>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>

    <!-- Thématiques populaires -->
    <section class="py-20 bg-gradient-to-br from-green-50 via-emerald-50 to-yellow-50 relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-72 h-72 bg-green-400 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-yellow-400 rounded-full blur-3xl"></div>
        </div>
    
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Header -->
            <div class="text-center mb-16 animate-fade-in-up">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl mb-6 shadow-2xl transform hover:scale-110 transition-transform">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4 tracking-tight">
                    L'Impact d'<span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-green-700">AgroSpace</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Une communauté dynamique qui partage, apprend et grandit ensemble
                </p>
            </div>
    
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Stat 1: Articles Publiés -->
                <div class="group">
                    <a href="{{ route('blog.index') }}"
                       class="block bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border-2 border-transparent hover:border-green-200 overflow-hidden relative">
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-green-600/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div class="relative">
                            <!-- Icon -->
                            <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            
                            <!-- Label -->
                            <h3 class="text-base font-bold text-gray-600 mb-2 uppercase tracking-wide">Articles Publiés</h3>
                            
                            <!-- Value -->
                            <p class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-green-700 mb-2">
                                {{ number_format($stats['total_posts'] ?? 0) }}
                            </p>
                            
                            <!-- Additional Info -->
                            <div class="flex items-center space-x-2 text-sm text-green-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-semibold">+{{ $stats['posts_this_month'] ?? 0 }} ce mois</span>
                            </div>
                        </div>
                    </a>
                </div>
    
                <!-- Stat 2: Vues Totales -->
                <div class="group">
                    <div class="bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border-2 border-transparent hover:border-blue-200 overflow-hidden relative cursor-pointer">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-blue-600/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            
                            <h3 class="text-base font-bold text-gray-600 mb-2 uppercase tracking-wide">Vues Totales</h3>
                            
                            <p class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-700 mb-2">
                                {{ number_format($stats['total_views'] ?? 0) }}
                            </p>
                            
                            <div class="flex items-center space-x-2 text-sm text-blue-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-semibold">Aujourd'hui: {{ number_format($stats['views_today'] ?? 0) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Stat 3: Commentaires -->
                <div class="group">
                    <a href="{{ route('blog.index') }}#comments"
                       class="block bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border-2 border-transparent hover:border-purple-200 overflow-hidden relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-purple-600/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            
                            <h3 class="text-base font-bold text-gray-600 mb-2 uppercase tracking-wide">Commentaires</h3>
                            
                            <p class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-purple-700 mb-2">
                                {{ number_format($stats['total_comments'] ?? 0) }}
                            </p>
                            
                            <div class="flex items-center space-x-2 text-sm text-purple-600">
                                <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                                    <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path>
                                </svg>
                                <span class="font-semibold">{{ $stats['approved_comments'] ?? 0 }} approuvés</span>
                            </div>
                        </div>
                    </a>
                </div>
    
                <!-- Stat 4: Réactions (Likes) -->
                <div class="group">
                    <div class="bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 border-2 border-transparent hover:border-red-200 overflow-hidden relative cursor-pointer">
                        <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-pink-600/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-pink-200 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            
                            <h3 class="text-base font-bold text-gray-600 mb-2 uppercase tracking-wide">Réactions</h3>
                            
                            <p class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-pink-600 mb-2">
                                {{ number_format($stats['total_likes'] ?? 0) }}
                            </p>
                            
                            <div class="flex items-center space-x-2 text-sm text-red-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                </svg>
                                <span class="font-semibold">Articles appréciés</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Secondary Stats Row -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Partages -->
                <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-md hover:shadow-lg transition-all border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-teal-100 to-teal-200 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold uppercase">Partages</p>
                            <p class="text-2xl font-black text-teal-600">{{ number_format($stats['total_shares'] ?? 0) }}</p>
                        </div>
                    </div>
                </div>
    
                <!-- Tags -->
                <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-md hover:shadow-lg transition-all border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-100 to-orange-200 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold uppercase">Tags</p>
                            <p class="text-2xl font-black text-yellow-600">{{ number_format($stats['tags_count'] ?? 0) }}</p>
                        </div>
                    </div>
                </div>
    
                <!-- Catégories -->
                <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-md hover:shadow-lg transition-all border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold uppercase">Catégories</p>
                            <p class="text-2xl font-black text-indigo-600">{{ number_format($stats['categories_count'] ?? 0) }}</p>
                        </div>
                    </div>
                </div>
    
                <!-- Auteurs Actifs -->
                <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-md hover:shadow-lg transition-all border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-100 to-pink-200 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold uppercase">Auteurs</p>
                            <p class="text-2xl font-black text-pink-600">{{ number_format($stats['active_authors'] ?? 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Call to Action -->
            {{-- <div class="mt-12 bg-gradient-to-r from-green-600 via-green-500 to-yellow-500 rounded-3xl p-8 md:p-12 shadow-2xl text-center text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10">
                    <h3 class="text-3xl md:text-4xl font-black mb-4">Rejoignez Notre Communauté</h3>
                    <p class="text-lg text-green-100 mb-8 max-w-2xl mx-auto">
                        Partagez vos connaissances, apprenez des experts et participez à la révolution agricole
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <a href="{{ route('register') }}" 
                           class="px-8 py-4 bg-white text-green-600 rounded-xl font-bold hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <span>Créer un Compte</span>
                        </a>
                        <a href="{{ route('blog.index') }}" 
                           class="px-8 py-4 bg-green-800 text-white rounded-xl font-bold hover:bg-green-900 transition-all transform hover:scale-105 shadow-lg flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span>Explorer les Articles</span>
                        </a>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
    
    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    
        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out;
        }
    </style>

    <!-- Newsletter -->
    <section class="py-20 bg-gradient-to-r from-emerald-500 via-green-600 to-green-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-12 shadow-2xl">
                <h2 class="text-4xl font-bold text-white mb-6">
                    📬 Restez informé des dernières nouvelles
                </h2>
                <p class="text-xl text-green-50 mb-8">
                    Recevez les innovations agricoles et les histoires inspirantes directement dans votre boîte mail.
                </p>

                <form class="max-w-xl mx-auto">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="email" placeholder="Votre adresse email"
                            class="flex-1 px-6 py-4 rounded-xl border-0 focus:ring-2 focus:ring-white focus:outline-none shadow-lg">
                        <button type="submit"
                            class="bg-[#1B5E20] text-green-50 px-8 py-4 rounded-xl font-bold hover:bg-earth-500 transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                            S'abonner
                        </button>
                    </div>
                    <p class="text-green-100 text-sm mt-4">
                        ✅ Aucune publicité • Désabonnement facile
                    </p>
                </form>
            </div>
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
            <a href="{{ route('register') }}"
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

</div>

@push('styles')
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
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out forwards;
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
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
    
    /* Smooth scroll */
    html {
        scroll-behavior: smooth;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Smooth scroll pour le bouton hero
        const heroButton = document.querySelector('a[href="#articles"]');
        if (heroButton) {
            heroButton.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector('#articles');
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        }
    });
</script>
@endpush
        