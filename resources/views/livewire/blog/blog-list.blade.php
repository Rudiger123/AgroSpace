<div>
    <!-- Hero Section -->
    <section id="blog-hero" class="relative pt-24 pb-20 md:pt-32 md:pb-28 overflow-hidden gradient-bg">
        <!-- Background SVG pattern -->
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div class="absolute inset-0"
                style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.2"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
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
        
                    <!-- Statistiques Blog -->
                    <div class="flex items-center gap-8 pt-6 flex-wrap">
                        <div class="text-center">
                            <div class="text-3xl font-bold">{{ $posts->total() }}</div>
                            <div class="text-sm text-green-50">Articles publiés</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold">{{ $categories->count() }}</div>
                            <div class="text-sm text-green-50">Catégories</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold">{{ $popularTags->count() }}</div>
                            <div class="text-sm text-green-50">Tags disponibles</div>
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

    <!-- Main Content -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-4 gap-8">
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Search -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Rechercher</h3>
                        <div class="relative">
                            <input type="text" 
                                   wire:model.live.debounce.300ms="search" 
                                   placeholder="Rechercher des articles..."
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Catégories</h3>
                        <div class="space-y-2">
                            <button wire:click="updateFilter('category', '')" 
                                    class="w-full text-left px-3 py-2 rounded-lg transition-colors {{ empty($category) ? 'bg-green-100 text-green-800' : 'hover:bg-gray-100' }}">
                                Toutes les catégories
                            </button>
                            @foreach($categories as $cat)
                                <button wire:click="updateFilter('category', {{ $cat->id }})" 
                                        class="w-full text-left px-3 py-2 rounded-lg transition-colors flex justify-between items-center {{ $category == $cat->id ? 'bg-green-100 text-green-800' : 'hover:bg-gray-100' }}">
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-sm text-gray-500">{{ $cat->posts_count }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Popular Tags -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tags populaires</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($popularTags as $t)
                                <button wire:click="updateFilter('tag', {{ $t->id }})" 
                                        class="px-3 py-1 text-sm rounded-full transition-colors {{ $tag == $t->id ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-green-100' }}">
                                    {{ $t->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Recent Posts -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Articles récents</h3>
                        <div class="space-y-4">
                            @foreach($recentPosts as $recent)
                                <a href="{{ route('blog.show', $recent->slug) }}" 
                                   class="block group">
                                    <div class="flex gap-3">
                                        @if($recent->featured_image)
                                            <img src="{{ Storage::url($recent->featured_image) }}" 
                                                 alt="{{ $recent->title }}"
                                                 class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                                        @else
                                            <div class="w-16 h-16 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7.414A2 2 0 0013.414 6L12 4.586A2 2 0 0010.586 4H5a2 2 0 00-2 2v12a2 2 0 002 2h14z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900 group-hover:text-green-600 transition-colors line-clamp-2">
                                                {{ $recent->title }}
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $recent->formatted_published_date }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Articles List -->
                <div class="lg:col-span-3">
                    <!-- Sort and View Options -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                        <div class="flex items-center gap-4">
                            <span class="text-sm text-gray-600">Trier par :</span>
                            <select wire:model.change="sortBy" class="text-sm border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                                <option value="recent">Plus récents</option>
                                <option value="popular">Plus populaires</option>
                                <option value="likes">Plus aimés</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <button wire:click="toggleViewMode" 
                                    class="p-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                                @if($viewMode === 'grid')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                    </svg>
                                @endif
                            </button>
                        </div>
                    </div>

                    <!-- Clear Filters -->
                    @if($search || $category || $tag)
                        <div class="mb-6">
                            <button wire:click="clearFilters" 
                                    class="text-sm text-green-600 hover:text-green-800 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Effacer les filtres
                            </button>
                        </div>
                    @endif

                    <!-- Articles Grid/List -->
                    <div class="{{ $viewMode === 'grid' ? 'grid md:grid-cols-2 xl:grid-cols-3 gap-8' : 'space-y-8' }}">
                        @forelse($posts as $post)
                            <article class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                                <!-- Featured Image -->
                                @if($post->featured_image)
                                    <div class="relative overflow-hidden {{ $viewMode === 'list' ? 'w-full h-48' : 'h-48' }}">
                                        <img src="{{ Storage::url($post->featured_image) }}" 
                                             alt="{{ $post->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        <div class="absolute top-4 left-4">
                                            @if($post->category)
                                                <span class="px-3 py-1 text-xs font-medium text-white bg-green-600 rounded-full">
                                                    {{ $post->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center relative">
                                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7.414A2 2 0 0013.414 6L12 4.586A2 2 0 0010.586 4H5a2 2 0 00-2 2v12a2 2 0 002 2h14z"></path>
                                        </svg>
                                        <div class="absolute top-4 left-4">
                                            @if($post->category)
                                                <span class="px-3 py-1 text-xs font-medium text-white bg-green-600 rounded-full">
                                                    {{ $post->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Content -->
                                <div class="p-6">
                                    <!-- Meta -->
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <span>{{ $post->formatted_published_date }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $post->reading_time }} min de lecture</span>
                                    </div>

                                    <!-- Title -->
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors line-clamp-2">
                                        <a href="{{ route('blog.show', $post->slug) }}">
                                            {{ $post->title }}
                                        </a>
                                    </h3>

                                    <!-- Excerpt -->
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        {{ $post->excerpt }}
                                    </p>

                                    <!-- Tags -->
                                    @if($post->tags->count() > 0)
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            @foreach($post->tags->take(3) as $tag)
                                                <span class="px-2 py-1 text-xs text-green-600 bg-green-50 rounded-full">
                                                    {{ $tag->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Stats -->
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <div class="flex items-center gap-4">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                {{ number_format($post->views_count) }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                                {{ number_format($post->likes_count) }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                </svg>
                                                {{ number_format($post->comments_count) }}
                                            </span>
                                        </div>
                                        
                                        <a href="{{ route('blog.show', $post->slug) }}" 
                                           class="text-green-600 hover:text-green-800 font-medium">
                                            Lire plus
                                            <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun article trouvé</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Aucun article ne correspond à vos critères de recherche.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        // Smooth scroll pour le bouton hero
        document.querySelector('a[href="#articles"]').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#articles').scrollIntoView({
                behavior: 'smooth'
            });
        });
    </script>
@endpush