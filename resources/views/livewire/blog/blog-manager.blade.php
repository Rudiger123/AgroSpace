<div x-data>


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="max-w-7xl mx-auto mb-8">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center space-x-3">
                        <span class="bg-primary-500 text-white p-2 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <svg class="inline-block w-10 h-10 mr-4 text-agro-yellow" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </svg>
                        </span>
                        <span> Gestion du Blog</span>
                    </h1>
                    <p class="text-gray-500 mt-1"> Créez, éditez et gérez vos articles avec style</p>
                </div>
                <button wire:click="openCreateModal"
                    class="bg-primary-500 text-white px-6 py-3 rounded-xl hover:bg-primary-600 transition shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Nouvel Article</span>
                </button>
            </div>
        </div>

        <!-- Statistiques élégantes -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div
                class="bg-gradient-to-br from-agro-green to-primary-600 rounded-xl p-6 text-agro-white shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-agro-beige text-sm font-inter">Total Articles</p>
                        <p class="text-3xl font-bold font-poppins">{{ $posts->total() }}</p>
                    </div>
                    <svg class="w-8 h-8 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                        <path fill-rule="evenodd"
                            d="M4 5a2 2 0 012-2 1 1 0 000 2H6a2 2 0 00-2 2v6a2 2 0 002 2h2a1 1 0 100-2H6V5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <div
                class="bg-primary-100 rounded-xl p-6 text-agro-green shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-700 text-sm font-inter">Publiés</p>
                        <p class="text-3xl font-bold font-poppins">
                            {{ \App\Models\Post::where('published', true)->count() }}</p>
                    </div>
                    <svg class="w-8 h-8 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div
                class="bg-gradient-to-br from-earth-200 to-earth-600 rounded-xl p-6 text-agro-white shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-100 text-sm font-inter">Brouillons</p>
                        <p class="text-3xl font-bold font-poppins">
                            {{ \App\Models\Post::where('published', false)->count() }}</p>
                    </div>
                    <svg class="w-8 h-8 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                </div>
            </div>
            <div
                class="bg-gradient-to-br from-secondary to-primary-600 rounded-xl p-6 text-agro-white shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-100 text-sm font-inter">Vues totales</p>
                        <p class="text-3xl font-bold font-poppins">
                            {{ number_format(\App\Models\Post::sum('views_count')) }}</p>
                    </div>
                    <svg class="w-8 h-8 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd"
                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Barre de recherche et filtres moderne -->
        <div class="bg-agro-white rounded-2xl shadow-xl border border-primary-100 mb-8 overflow-hidden">
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                    <!-- Recherche -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-bold text-agro-gray mb-3 font-inter">Rechercher</label>
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.500ms="search"
                                placeholder="Titre, contenu, auteur..."
                                class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-primary-400"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                            @if ($search)
                                <button wire:click="$set('search', '')"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-primary-400 hover:text-primary-600 transition-colors duration-300">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <label class="block text-sm font-bold text-agro-gray mb-3 font-inter">Catégorie</label>
                        <select wire:model.live="filterCategory"
                            class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                            <option value="">Toutes les catégories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Statut -->
                    <div>
                        <label class="block text-sm font-bold text-agro-gray mb-3 font-inter">Statut</label>
                        <select wire:model.live="filterStatus"
                            class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                            <option value="">Tous les statuts</option>
                            <option value="published">Publiés</option>
                            <option value="draft">Brouillons</option>
                            <option value="scheduled">Programmés</option>
                        </select>
                    </div>

                    <!-- Auteur -->
                    @if (Auth::user()->isAdmin() && $authors->count() > 0)
                        <div>
                            <label class="block text-sm font-bold text-agro-gray mb-3 font-inter">Auteur</label>
                            <select wire:model.live="filterAuthor"
                                class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                <option value="">Tous les auteurs</option>
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <!-- Filtres rapides -->
                <div class="mt-6 flex flex-wrap gap-3">
                    <button wire:click="$set('filterStatus', '')"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ empty($filterStatus) ? 'bg-agro-green text-agro-white shadow-lg' : 'bg-primary-100 text-agro-gray hover:bg-primary-200' }}">
                        Tous les articles
                    </button>
                    <button wire:click="$set('filterStatus', 'published')"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ $filterStatus === 'published' ? 'bg-agro-green text-agro-white shadow-lg' : 'bg-primary-100 text-agro-gray hover:bg-primary-200' }}">
                        Publiés
                    </button>
                    <button wire:click="$set('filterStatus', 'draft')"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ $filterStatus === 'draft' ? 'bg-agro-green text-agro-white shadow-lg' : 'bg-primary-100 text-agro-gray hover:bg-primary-200' }}">
                        Brouillons
                    </button>
                    <button wire:click="$set('sortDirection', $sortDirection === 'asc' ? 'desc' : 'asc')"
                        class="px-4 py-2 rounded-full text-sm font-medium bg-primary-100 text-agro-gray hover:bg-primary-200 transition-all duration-300">
                        <svg class="inline-block w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path x-show="$sortDirection === 'asc'" fill-rule="evenodd"
                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                            <path x-show="$sortDirection === 'desc'" fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $sortDirection === 'asc' ? 'Plus ancien' : 'Plus récent' }}
                    </button>
                </div>
            </div>
        </div>



        <!-- Grille d'articles moderne -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <div wire:key="post-{{ $post->id }}"
                    class="group bg-agro-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-primary-100 overflow-hidden">

                    <!-- Image avec effet de survol -->
                    <div class="relative h-48 overflow-hidden">
                        @if ($post->featured_image)
                            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-agro-green to-primary-700 flex items-center justify-center">
                                <svg class="w-10 h-10 text-agro-white opacity-50" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif

                        <!-- Overlay au survol -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-70 transition-opacity duration-300">
                        </div>

                        <!-- Boutons d'action au survol -->
                        <div
                            class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="flex gap-2">
                                <button wire:click="preview({{ $post->id }})"
                                    class="w-10 h-10 bg-agro-white bg-opacity-90 hover:bg-agro-white text-agro-green rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                @can('update', $post)
                                    <button wire:click="openEditModal({{ $post->id }})"
                                        class="w-10 h-10 bg-agro-white bg-opacity-90 hover:bg-agro-white text-agro-green rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </button>
                                @endcan
                            </div>
                        </div>

                        <!-- Statut -->
                        <div class="absolute top-4 left-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold backdrop-blur-sm
                                {{ $post->published ? 'bg-green-500 bg-opacity-90 text-agro-white' : 'bg-gray-500 bg-opacity-90 text-agro-white' }}">
                                <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <circle cx="10" cy="10" r="10" />
                                </svg>
                                {{ $post->published ? 'Publié' : 'Brouillon' }}
                            </span>
                            @if ($post->is_featured)
                                <span class="inline-block  px-4 py-2">
                                    ⭐
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="p-6">
                        <div class="mb-4">
                            <a href="{{ route('blog.show', $post->slug) }}" wire:navigate
                                class="text-xl font-bold text-agro-gray mb-2 font-poppins group-hover:text-agro-green transition-colors duration-300">
                                {{ $post->title }}
                            </a>

                            <p class="text-agro-gray text-sm font-inter line-clamp-2">
                                {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                            </p>
                        </div>

                        <!-- Méta informations -->
                        <div class="flex items-center justify-between text-sm text-primary-600 mb-4">
                            <div class="flex items-center gap-4">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $post->author->name }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $post->published_at?->format('d/m/Y') ?? 'Non publié' }}
                                </span>
                            </div>
                            @if ($post->category)
                                <span
                                    class="px-2 py-1 bg-primary-100 text-{{ $category->color }} rounded-full text-xs font-medium">
                                    {{ $post->category->icon }}{{ $post->category->name }}
                                </span>
                            @endif
                        </div>

                        <!-- Tags -->
                        @if ($post->tags->count() > 0)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach ($post->tags->take(3) as $tag)
                                    <span
                                        class="px-2 py-1 bg-earth-100 text-{{ $tag->color }} rounded-full text-xs font-medium">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                                @if ($post->tags->count() > 3)
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">
                                        +{{ $post->tags->count() - 3 }}
                                    </span>
                                @endif
                            </div>
                        @endif

                        <!-- Statistiques -->
                        <div class="flex items-center justify-between pt-4 border-t border-primary-100">
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ number_format($post->views_count) }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ number_format($post->likes_count) }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ number_format($post->comments_count ?? 0) }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button wire:click="togglePublish({{ $post->id }})"
                                    class="w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110
                                               {{ $post->published ? 'bg-green-100 text-green-600 hover:bg-green-200' : 'bg-green-100 text-green-600 hover:bg-green-200' }}"
                                    title="{{ $post->published ? 'Dépublier' : 'Publier' }}">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                @can('update', $post)
                                    <button wire:click="toggleFeatured({{ $post->id }})"
                                        class="p-2 {{ $post->is_featured ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg transition"
                                        title="{{ $post->is_featured ? 'Retirer de la vedette' : 'Mettre en vedette' }}">
                                        <svg class="w-5 h-5" fill="{{ $post->is_featured ? 'currentColor' : 'none' }}"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                            </path>
                                        </svg>
                                    </button>
                                @endcan
                                @can('delete', $post)
                                    <button wire:click="confirmDelete({{ $post->id }})"
                                        class="w-8 h-8 rounded-full flex items-center justify-center bg-red-100 text-red-600 hover:bg-red-200 transition-all duration-300 transform hover:scale-110"
                                        title="Supprimer">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <!-- Effet de lueur au survol -->
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-agro-green to-primary-700 opacity-0 group-hover:opacity-5 transition-opacity duration-500 pointer-events-none">
                    </div>
                </div>
            @empty
                <!-- État vide magnifique -->
                <div
                    class="col-span-full bg-agro-white rounded-2xl shadow-lg border border-primary-100 p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="relative w-32 h-32 mx-auto mb-8">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-agro-green to-primary-700 rounded-full animate-pulse">
                            </div>
                            <div
                                class="relative w-full h-full bg-agro-white rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-agro-green" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd"
                                        d="M4 5a2 2 0 012-2 1 1 0 000 2H6a2 2 0 00-2 2v6a2 2 0 002 2h2a1 1 0 100-2H6V5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-agro-gray mb-4 font-poppins">Aucun article trouvé</h3>
                        <p class="text-agro-gray mb-8 font-inter">
                            Commencez votre aventure blogging en créant votre premier article magnifique.
                        </p>
                        <button wire:click="openCreateModal"
                            class="group bg-gradient-to-r from-agro-green to-primary-700 hover:from-primary-700 hover:to-base text-agro-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-agro-green focus:ring-opacity-50 font-poppins">
                            <svg class="inline-block w-4 h-4 mr-2 group-hover:rotate-12 transition-transform duration-300"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Créer mon premier article
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination moderne -->
        @if ($posts->hasPages())
            <div class="mt-12 flex justify-center">
                <div class="bg-agro-white rounded-2xl shadow-lg border border-primary-100 px-8 py-4">
                    {{ $posts->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Créer/Éditer Offre -->
    <div x-show="$wire.showCreateModal || $wire.showEditModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-cloak
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 overflow-y-auto">

        <div x-show="$wire.showCreateModal || $wire.showEditModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto my-8"
            @click.away="$wire.closeModals()">

            <!-- Modal Header with Gradient -->
            <div class="relative bg-gradient-to-r from-primary-600 via-primary-500 to-earth-500 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white"
                                x-text="$wire.showCreateModal ? '➕ Créer une nouvel Article' : '✏️ Modifier l\'article'">
                            </h3>
                            <p class="text-primary-100 text-sm mt-1">
                                {{ $showEditModal ? 'Mettez à jour les informations de l\'article' : 'Publiez votre article' }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="closeModals"
                        class="text-white/80 hover:text-white hover:bg-white/20 rounded-xl p-2 transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Decorative Wave -->
                <div class="absolute bottom-0 left-0 right-0">
                    <svg class="w-full h-4 text-white" preserveAspectRatio="none" viewBox="0 0 1200 120"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                            fill="currentColor"></path>
                    </svg>
                </div>
            </div>

            <form wire:submit="save" @submit.prevent>

                <!-- Body -->
                <div class="p-6 space-y-6">

                    <!-- Titre et Slug -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-bold text-agro-gray mb-3 font-inter">
                                Titre <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" wire:model="title" id="title" wire:blur="generateSlug"
                                    class="w-full pl-12 pr-4 py-4 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter text-lg bg-primary-50 focus:bg-white"
                                    placeholder="Titre de l'article">
                                <i
                                    class="fas fa-heading absolute left-4 top-1/2 transform -translate-y-1/2 text-primary-400"></i>
                            </div>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-bold text-agro-gray mb-3 font-inter">
                                Slug <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" wire:model="slug" id="slug"
                                    class="w-full pl-12 pr-4 py-4 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter text-lg bg-primary-50 focus:bg-white"
                                    placeholder="slug-de-l-article">
                                <i
                                    class="fas fa-link absolute left-4 top-1/2 transform -translate-y-1/2 text-primary-400"></i>
                            </div>
                            @error('slug')
                                <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Catégorie et Tags -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="category_id" class="block text-sm font-bold text-agro-gray mb-3 font-inter">
                                Catégorie
                            </label>
                            <select wire:model="category_id" id="category_id"
                                class="w-full px-4 py-4 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter text-lg">
                                <option value="">Sélectionner une catégorie</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tags" class="block text-sm font-bold text-agro-gray mb-3 font-inter">
                                Tags
                            </label>
                            <div class="relative">
                                <select wire:model="tags" id="tags" multiple
                                    class="w-full px-4 py-4 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter text-lg bg-primary-50 focus:bg-white">
                                    @foreach ($allTags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-tags absolute left-4 top-4 text-primary-400 pointer-events-none"></i>
                            </div>
                            <p class="mt-2 text-sm text-primary-500 font-inter">Maintenez Ctrl pour sélectionner
                                plusieurs tags</p>
                            @error('tags')
                                <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Image de couverture -->
                    <div>
                        <label class="block text-sm font-bold text-agro-gray mb-3 font-inter">
                            Image de couverture
                        </label>
                        <div class="flex items-center gap-6">
                            @if ($existing_image)
                                <div class="relative group">
                                    <img src="{{ Storage::url($existing_image) }}" alt="Image actuelle"
                                        class="w-24 h-24 rounded-xl object-cover shadow-lg">
                                    <button type="button" wire:click="$set('existing_image', '')"
                                        class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-agro-white rounded-full flex items-center justify-center text-sm hover:bg-red-600 transition-all duration-300 transform hover:scale-110 opacity-0 group-hover:opacity-100">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endif
                            <div class="flex-1">
                                <div class="relative">
                                    <input type="file" wire:model="featured_image" accept="image/*"
                                        class="w-full px-4 py-4 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter text-lg bg-primary-50 focus:bg-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-agro-green file:text-agro-white hover:file:bg-green-700">
                                    <i
                                        class="fas fa-image absolute left-4 top-1/2 transform -translate-y-1/2 text-primary-400 pointer-events-none"></i>
                                </div>
                                <p class="mt-2 text-sm text-primary-500 font-inter">PNG, JPG, GIF jusqu'à 2MB</p>
                            </div>
                        </div>
                        @error('featured_image')
                            <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Résumé -->
                    <div>
                        <label for="excerpt" class="block text-sm font-bold text-agro-gray mb-3 font-inter">
                            Résumé
                        </label>
                        <textarea wire:model="excerpt" id="excerpt" rows="3"
                            class="w-full px-6 py-4 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter text-lg resize-none"
                            placeholder="Résumé de l'article (optionnel, généré automatiquement si vide)"></textarea>
                        @error('excerpt')
                            <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contenu -->
                    <div>
                        <label for="content" class="block text-sm font-bold text-agro-gray mb-3 font-inter">
                            Contenu <span class="text-red-500">*</span>
                        </label>
                        <div wire:ignore>
                            <textarea wire:model="content" id="content" rows="12"
                                class="w-full px-6 py-4 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter text-lg resize-none"
                                placeholder="Contenu de l'article"></textarea>
                        </div>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Options de publication -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <label class="flex items-center cursor-pointer select-none space-x-3">

                            <span class="text-gray-800 font-medium">
                                Publier maintenant
                            </span>

                            <div class="relative">
                                <input type="checkbox" wire:model= "published" class="peer sr-only"
                                    name="is_published" id="is_published">

                                <!-- Background -->
                                <div
                                    class="w-12 h-6 rounded-full bg-gray-300 peer-checked:bg-green-600 transition-colors">
                                </div>

                                <!-- Circle -->
                                <div
                                    class="absolute top-0.5 left-0.5 h-5 w-5 bg-white rounded-full shadow
                                                transition-all peer-checked:translate-x-6">
                                </div>
                            </div>

                        </label>

                        <div>
                            <label for="published_at" class="block text-sm font-bold text-agro-gray mb-3 font-inter">
                                Date de publication
                            </label>
                            <div class="relative">
                                <input type="datetime-local" wire:model="published_at" id="published_at"
                                    class="w-full pl-12 pr-4 py-4 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter text-lg bg-primary-50 focus:bg-white">
                                <i
                                    class="fas fa-calendar absolute left-4 top-1/2 transform -translate-y-1/2 text-primary-400"></i>
                            </div>
                            @error('published_at')
                                <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- SEO -->
                    <div class="border-t-2 border-primary-200 pt-8">
                        <h3 class="text-xl font-bold text-agro-gray mb-6 font-poppins flex items-center gap-3">
                            <i class="fas fa-search text-agro-green"></i>
                            Optimisation SEO
                        </h3>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="meta_title"
                                    class="block text-sm font-bold text-agro-gray mb-3 font-inter">
                                    Meta Title
                                </label>
                                <input type="text" wire:model="meta_title" id="meta_title"
                                    class="w-full px-6 py-4 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter text-lg bg-primary-50 focus:bg-white"
                                    placeholder="Titre pour les moteurs de recherche">
                                @error('meta_title')
                                    <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="meta_description"
                                    class="block text-sm font-bold text-agro-gray mb-3 font-inter">
                                    Meta Description
                                </label>
                                <textarea wire:model="meta_description" id="meta_description" rows="3"
                                    class="w-full px-6 py-4 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter text-lg resize-none bg-primary-50 focus:bg-white"
                                    placeholder="Description pour les moteurs de recherche"></textarea>
                                @error('meta_description')
                                    <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>


                </div>

                <!-- Footer -->
                <div
                    class="sticky bottom-0 bg-white border-t px-6 py-4 flex items-center justify-end space-x-3 rounded-b-2xl">
                    <button type="button" wire:click="closeModals"
                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-medium">
                        Annuler
                    </button>
                    <button type="submit" wire:loading.attr="disabled"
                        class="px-6 py-3 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition font-medium shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center space-x-2">
                        <span wire:loading.remove
                            x-text="$wire.showCreateModal ? 'Créer l\'offre' : 'Mettre à jour'"></span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Traitement...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>



    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full animate-scale-in">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-semibold text-agro-gray mb-2 font-poppins">Confirmer la suppression</h3>
                    <p class="text-gray-600 mb-6 font-inter">
                        Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.
                    </p>

                    <div class="flex items-center justify-center gap-4">
                        <button wire:click="closeModals"
                            class="px-6 py-3 text-sm font-medium text-agro-gray bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 font-inter">
                            Annuler
                        </button>
                        <button wire:click="delete({{ $selectedPost->id ?? 0 }})" wire:loading.attr="disabled"
                            class="px-6 py-3 text-sm font-medium text-white bg-red-600 border border-transparent rounded-xl hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 font-inter">
                            <span wire:loading.remove>Supprimer</span>
                            <span wire:loading>
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Preview Modal -->
    @if ($showPreviewModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-agro-gray font-poppins">Prévisualisation</h2>
                        <button wire:click="closeModals"
                            class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="prose max-w-none">
                        @if ($selectedPost)
                            <article class="bg-white rounded-lg">
                                @if ($selectedPost->featured_image)
                                    <img src="{{ Storage::url($selectedPost->featured_image) }}"
                                        alt="{{ $selectedPost->title }}"
                                        class="w-full h-64 object-cover rounded-lg mb-6">
                                @endif

                                <h1 class="text-3xl font-bold text-agro-gray mb-4 font-poppins">
                                    {{ $selectedPost->title }}
                                </h1>

                                <div class="flex items-center space-x-4 text-sm text-gray-600 mb-6 font-inter">
                                    <span>Par {{ $selectedPost->author->name }}</span>
                                    <span>•</span>
                                    <span>{{ $selectedPost->published_at?->format('d F Y') ?? 'Non publié' }}</span>
                                    @if ($selectedPost->category)
                                        <span>•</span>
                                        <span class="px-2 py-1 bg-agro-green text-white rounded-full text-xs">
                                            {{ $selectedPost->category->name }}
                                        </span>
                                    @endif
                                </div>

                                <div class="text-gray-700 leading-relaxed font-inter">
                                    {!! $selectedPost->content !!}
                                </div>

                                @if ($selectedPost->tags->count() > 0)
                                    <div class="mt-8 pt-6 border-t border-gray-200">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($selectedPost->tags as $tag)
                                                <span
                                                    class="px-3 py-1 bg-earth-100 text-earth-800 rounded-full text-sm font-inter">
                                                    #{{ $tag->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </article>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        /* Scrollbar personnalisée */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #22c55e, #16a34a);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #16a34a, #15803d);
        }

        /* Animations */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
        }

        /* Effet de lueur */
        .group:hover .group-hover\:shadow-glow {
            box-shadow: 0 0 20px rgba(46, 125, 50, 0.3);
        }
    </style>
</div>
