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
                            @if($featuredPost->cover_image)
                                <img src="{{ $featuredPost->cover_image_url }}" 
                                     alt="{{ $featuredPost->title }}"
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
                            <h3 class="text-3xl font-bold text-gray-900 mb-4 group-hover:text-green-600 transition">
                                {{ $featuredPost->title }}
                            </h3>
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
                                @if($post->cover_image)
                                    <img src="{{ $post->cover_image_url }}" 
                                         alt="{{ $post->title }}"
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
                    <p class="text-sm text-gray-600">{{ \App\Models\Post::count() }} articles</p>
                </a>

                <a href="#"
                    class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 text-center group">
                    <div class="text-5xl mb-4 group-hover:scale-110 transition">🚜</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Innovation & technologie</h3>
                    <p class="text-sm text-gray-600">{{ \App\Models\Comment::count() }} Commentaires</p>
                </a>

                <a href="#"
                    class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 text-center group">
                    <div class="text-5xl mb-4 group-hover:scale-110 transition">👩‍🌾</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Témoignages de producteurs</h3>
                    <p class="text-sm text-gray-600">{{ \App\Models\Post::count() }} likes</p>
                </a>

                <a href="#"
                    class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 text-center group">
                    <div class="text-5xl mb-4 group-hover:scale-110 transition">💰</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Financements & subventions</h3>
                    <p class="text-sm text-gray-600">{{ \App\Models\Post::count() }} views</p>
                </a>
            </div>
        </div>
    </section>

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
        