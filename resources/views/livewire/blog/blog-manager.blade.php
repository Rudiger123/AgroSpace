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


                <!-- Actions -->
                <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 sm:gap-3 w-full sm:w-auto">
                    <button wire:click="openCreateModal"
                        class="bg-primary-500 text-white px-6 py-3 rounded-xl hover:bg-primary-600 transition shadow-lg hover:shadow-xl flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span>Nouvel Article</span>
                    </button>
                    <!-- comments manager -->
                    <a href="{{ route('admin.blog.comments.index') }}" wire:navigate
                        class="flex items-center gap-1 sm:gap-2 px-3 sm:px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-300 text-white rounded-lg font-medium hover:shadow-lg transition-all text-sm sm:text-base flex-1 sm:flex-none justify-center">
                        <svg class="w-8 h-8 text-primary-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </a>

                    <!-- analytics -->
                    <a href="{{ route('admin.blog.blog.analytics') }}"
                        class="flex items-center gap-1 sm:gap-2 px-3 sm:px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-lg font-medium hover:shadow-lg transition-all text-sm sm:text-base flex-1 sm:flex-none justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="hidden xs:inline">Analytics</span>
                    </a>

                </div>
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
    <!-- Modal Créer/Éditer Article -->
    <div x-show="$wire.showCreateModal || $wire.showEditModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-cloak
        class="fixed inset-0 bg-gradient-to-br from-black/60 via-black/50 to-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 overflow-y-auto">

        <div x-show="$wire.showCreateModal || $wire.showEditModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95 -translate-y-4"
            x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
            class="bg-white rounded-3xl shadow-2xl max-w-6xl w-full max-h-[95vh] overflow-hidden my-8 border border-gray-100"
            @click.away="$wire.closeModals()">

            <!-- Modal Header avec Design Moderne -->
            <div class="relative overflow-hidden">
                <!-- Gradient Background avec Pattern -->
                <div class="absolute inset-0 bg-gradient-to-br from-green-600 via-green-500 to-yellow-500">
                    <div class="absolute inset-0 opacity-20"
                        style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                    </div>
                </div>

                <div class="relative px-8 py-8">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-5">
                            <!-- Icon avec Animation -->
                            <div
                                class="bg-white/20 backdrop-blur-md rounded-2xl p-4 shadow-2xl border border-white/30 transform hover:scale-110 transition-transform duration-300">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </div>
                            <div class="pt-1">
                                <h3 class="text-3xl font-black text-white mb-2 tracking-tight"
                                    x-text="$wire.showCreateModal ? '✨ Créer un Nouvel Article' : '✏️ Modifier l\'Article'">
                                </h3>
                                {{-- <p class="text-green-100 text-base font-medium max-w-md leading-relaxed">
                                    {{ $showEditModal ? 'Mettez à jour les informations de votre article pour tenir votre communauté informée' : 'Partagez vos connaissances et inspirez la communauté AgroSpace' }}
                                </p> --}}
                            </div>
                        </div>
                        <button wire:click="closeModals"
                            class="text-white/90 hover:text-white hover:bg-white/20 backdrop-blur-sm rounded-xl p-3 transition-all duration-200 transform hover:scale-110 hover:rotate-90 group">
                            <svg class="w-6 h-6 transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Decorative Wave -->
                <div class="absolute bottom-0 left-0 right-0">
                    <svg class="w-full h-6 text-white" preserveAspectRatio="none" viewBox="0 0 1200 120"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                            fill="currentColor"></path>
                    </svg>
                </div>
            </div>

            <form wire:submit="save" @submit.prevent>
                <!-- Body avec Scrollbar Personnalisée -->
                <div class="overflow-y-auto max-h-[calc(95vh-250px)] px-8 py-8 space-y-8 custom-scrollbar">

                    <!-- Section 1: Informations Principales -->
                    <div
                        class="bg-gradient-to-br from-green-50 via-white to-yellow-50 rounded-2xl p-8 border-2 border-green-100 shadow-lg">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-3 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">Informations Principales</h4>
                                <p class="text-sm text-gray-600">Les détails essentiels de votre article</p>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Titre -->
                            <div class="group">
                                <label for="title"
                                    class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                        </path>
                                    </svg>
                                    <span>Titre de l'Article</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" wire:model.live="title" id="title"
                                        wire:blur="generateSlug"
                                        class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-300 text-base bg-white hover:border-green-300 group-hover:shadow-lg placeholder-gray-400"
                                        placeholder="Ex: Les meilleures techniques de culture du maïs">
                                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </div>
                                    <!-- Character Counter -->
                                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-xs text-gray-400"
                                        x-data="{ length: $wire.entangle('title').length }">
                                        <span x-text="length"></span>/100
                                    </div>
                                </div>
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Slug -->
                            <div class="group">
                                <label for="slug"
                                    class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                        </path>
                                    </svg>
                                    <span>URL (Slug)</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" wire:model="slug" id="slug"
                                        class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-300 text-base bg-white hover:border-green-300 group-hover:shadow-lg placeholder-gray-400"
                                        placeholder="les-meilleures-techniques-culture-mais">
                                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Généré automatiquement à partir du titre</span>
                                </p>
                                @error('slug')
                                    <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Classification -->
                    <div
                        class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 rounded-2xl p-8 border-2 border-blue-100 shadow-lg">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-3 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">Classification</h4>
                                <p class="text-sm text-gray-600">Catégorie et tags pour organiser votre contenu</p>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Catégorie -->
                            <div class="group">
                                <label for="category_id"
                                    class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                    <span>Catégorie</span>
                                </label>
                                <div class="relative">
                                    <select wire:model="category_id" id="category_id"
                                        class="w-full pl-12 pr-10 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 text-base bg-white hover:border-blue-300 group-hover:shadow-lg appearance-none cursor-pointer">
                                        <option value="">🗂️ Sélectionner une catégorie</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->icon ?? '📁' }}
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="absolute left-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                    </div>
                                    <div
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('category_id')
                                    <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Tags -->
                            <div class="group">
                                <label for="tags"
                                    class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                        </path>
                                    </svg>
                                    <span>Tags</span>
                                </label>
                                <div class="relative">
                                    <select wire:model="tags" id="tags" multiple
                                        class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 text-base bg-white hover:border-blue-300 group-hover:shadow-lg">
                                        @foreach ($allTags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->icon ?? '🏷️' }}
                                                {{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute left-4 top-4 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Maintenez Ctrl (Cmd sur Mac) pour sélectionner plusieurs tags</span>
                                </p>
                                @error('tags')
                                    <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Image de Couverture -->
                    <div
                        class="bg-gradient-to-br from-purple-50 via-white to-pink-50 rounded-2xl p-8 border-2 border-purple-100 shadow-lg">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl p-3 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">Image de Couverture</h4>
                                <p class="text-sm text-gray-600">Choisissez une image attractive pour votre article</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @if ($existing_image)
                                <div class="relative group inline-block">
                                    <img src="{{ Storage::url($existing_image) }}" alt="Image actuelle"
                                        class="w-40 h-40 rounded-2xl object-cover shadow-2xl border-4 border-white ring-2 ring-purple-200 transform transition-transform group-hover:scale-105">
                                    <button type="button" wire:click="$set('existing_image', '')"
                                        class="absolute -top-3 -right-3 w-10 h-10 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 opacity-0 group-hover:opacity-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    <div
                                        class="absolute inset-0 bg-black/50 backdrop-blur-sm rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <p class="text-white font-semibold text-sm">Supprimer</p>
                                    </div>
                                </div>
                            @endif

                            <div
                                class="border-2 border-dashed border-purple-300 rounded-2xl p-8 hover:border-purple-500 transition-all duration-300 bg-white/50 hover:bg-white/80 cursor-pointer group">
                                <label for="featured_image" class="cursor-pointer block">
                                    <div class="flex flex-col items-center space-y-4">
                                        <div
                                            class="w-20 h-20 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                                            <svg class="w-10 h-10 text-purple-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-base font-bold text-gray-900 mb-1">Cliquez pour télécharger
                                                ou
                                                glissez-déposez</p>
                                            <p class="text-sm text-gray-500">PNG, JPG, GIF jusqu'à 2MB</p>
                                        </div>
                                        <input type="file" wire:model="featured_image" id="featured_image"
                                            accept="image/*" class="hidden">
                                    </div>
                                </label>
                            </div>
                            @error('featured_image')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Section 4: Résumé -->
                    <div
                        class="bg-gradient-to-br from-yellow-50 via-white to-orange-50 rounded-2xl p-8 border-2 border-yellow-100 shadow-lg">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl p-3 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">Résumé</h4>
                                <p class="text-sm text-gray-600">Un aperçu concis de votre article</p>
                            </div>
                        </div>

                        <div class="group">
                            <label for="excerpt"
                                class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                <span>Description Courte</span>
                            </label>
                            <div class="relative">
                                <textarea wire:model="excerpt" id="excerpt" rows="4"
                                    class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-500 transition-all duration-300 text-base resize-none bg-white hover:border-yellow-300 group-hover:shadow-lg placeholder-gray-400"
                                    placeholder="Rédigez un résumé captivant de votre article (optionnel, généré automatiquement si vide)..."></textarea>
                                <div class="absolute bottom-4 right-4 text-xs text-gray-400 bg-white px-2 py-1 rounded-lg"
                                    x-data="{ length: $wire.entangle('excerpt').length }">
                                    <span x-text="length"></span>/200
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Sera généré automatiquement depuis le contenu si laissé vide</span>
                            </p>
                            @error('excerpt')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Section 5: Contenu Principal -->
                    <div
                        class="bg-gradient-to-br from-gray-50 via-white to-slate-50 rounded-2xl p-8 border-2 border-gray-200 shadow-lg">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="bg-gradient-to-br from-gray-700 to-gray-900 rounded-xl p-3 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900">Contenu de l'Article</h4>
                                    <p class="text-sm text-gray-600">Rédigez le corps de votre article</p>
                                </div>
                            </div>
                            <!-- Toolbar Preview -->
                            <div class="flex items-center space-x-2 bg-gray-100 rounded-lg px-4 py-2">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                    </path>
                                </svg>
                                <span class="text-xs font-medium text-gray-600">Markdown supporté</span>
                            </div>
                        </div>

                        <div class="group">
                            <label for="content"
                                class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span>Texte Principal</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div wire:ignore>
                                <textarea wire:model="content" id="content" rows="16"
                                    class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-100 focus:border-gray-500 transition-all duration-300 text-base resize-none bg-white hover:border-gray-300 group-hover:shadow-lg placeholder-gray-400 font-mono"
                                    placeholder="Rédigez votre article ici...

# Titre Principal
## Sous-titre

Votre contenu en **gras** ou *italique*

- Liste à puces
- Élément 2

1. Liste numérotée
2. Élément 2"></textarea>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <p class="text-xs text-gray-500 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Utilisez le format Markdown pour le formatage</span>
                                </p>
                                <div class="text-xs text-gray-400" x-data="{ length: $wire.entangle('content').length }">
                                    <span x-text="length"></span> caractères
                                </div>
                            </div>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Section 6: Options de Publication -->
                    <div
                        class="bg-gradient-to-br from-teal-50 via-white to-cyan-50 rounded-2xl p-8 border-2 border-teal-100 shadow-lg">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl p-3 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">Options de Publication</h4>
                                <p class="text-sm text-gray-600">Planifiez la publication de votre article</p>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Toggle Publier -->
                            <div
                                class="bg-white rounded-xl p-6 border-2 border-teal-100 hover:border-teal-300 transition-all">
                                <label class="flex items-center justify-between cursor-pointer group">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-teal-100 to-cyan-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-gray-900">Publier maintenant</p>
                                            <p class="text-xs text-gray-500">L'article sera visible immédiatement</p>
                                        </div>
                                    </div>
                                    <div class="relative">
                                        <input type="checkbox" wire:model="published" class="peer sr-only"
                                            name="is_published" id="is_published">
                                        <div
                                            class="w-14 h-7 rounded-full bg-gray-300 peer-checked:bg-gradient-to-r peer-checked:from-teal-500 peer-checked:to-cyan-500 transition-all shadow-inner">
                                        </div>
                                        <div
                                            class="absolute top-0.5 left-0.5 h-6 w-6 bg-white rounded-full shadow-lg transition-all peer-checked:translate-x-7 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-gray-400 peer-checked:text-teal-500 hidden peer-checked:block"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Date de publication -->
                            <div class="group">
                                <label for="published_at"
                                    class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span>Date et Heure de Publication</span>
                                </label>
                                <div class="relative">
                                    <input type="datetime-local" wire:model="published_at" id="published_at"
                                        class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-teal-100 focus:border-teal-500 transition-all duration-300 text-base bg-white hover:border-teal-300 group-hover:shadow-lg">
                                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-teal-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Laissez vide pour publication immédiate</span>
                                </p>
                                @error('published_at')
                                    <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 7: SEO (Optimisation) -->
                    <div
                        class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 rounded-2xl p-8 border-2 border-indigo-100 shadow-lg">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl p-3 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">Optimisation SEO</h4>
                                <p class="text-sm text-gray-600">Améliorez votre visibilité sur les moteurs de
                                    recherche
                                </p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <!-- Meta Title -->
                            <div class="group">
                                <label for="meta_title"
                                    class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                        </path>
                                    </svg>
                                    <span>Meta Title</span>
                                </label>
                                <div class="relative">
                                    <input type="text" wire:model="meta_title" id="meta_title"
                                        class="w-full pl-12 pr-20 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-300 text-base bg-white hover:border-indigo-300 group-hover:shadow-lg placeholder-gray-400"
                                        placeholder="Titre optimisé pour les moteurs de recherche">
                                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-xs"
                                        x-data="{ length: $wire.entangle('meta_title').length }">
                                        <span :class="length > 60 ? 'text-green-600' : 'text-gray-400'"
                                            x-text="length"></span>
                                        <span class="text-gray-400">/60</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Idéalement entre 50-60 caractères</span>
                                </p>
                                @error('meta_title')
                                    <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Meta Description -->
                            <div class="group">
                                <label for="meta_description"
                                    class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                    <span>Meta Description</span>
                                </label>
                                <div class="relative">
                                    <textarea wire:model="meta_description" id="meta_description" rows="3"
                                        class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-300 text-base resize-none bg-white hover:border-indigo-300 group-hover:shadow-lg placeholder-gray-400"
                                        placeholder="Description concise pour les résultats de recherche (150-160 caractères recommandés)"></textarea>
                                    <div class="absolute bottom-4 right-4 text-xs bg-white px-2 py-1 rounded-lg"
                                        x-data="{ length: $wire.entangle('meta_description').length }">
                                        <span
                                            :class="length >= 150 && length <= 160 ? 'text-green-600' : 'text-gray-400'"
                                            x-text="length"></span>
                                        <span class="text-gray-400">/160</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Optimal entre 150-160 caractères pour un affichage complet</span>
                                </p>
                                @error('meta_description')
                                    <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Footer Sticky avec Actions -->
                <div
                    class="sticky bottom-0 bg-gradient-to-r from-white via-gray-50 to-white border-t-2 border-gray-200 px-8 py-6 rounded-b-3xl shadow-2xl backdrop-blur-lg">
                    <div class="flex items-center justify-between">
                        <!-- Info Section -->
                        <div class="flex items-center space-x-4">
                            <div
                                class="hidden md:flex items-center space-x-3 bg-blue-50 px-4 py-3 rounded-xl border border-blue-200">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-xs font-semibold text-blue-900">Sauvegarde automatique</p>
                                    <p class="text-xs text-blue-600">Vos modifications sont enregistrées</p>
                                </div>
                            </div>

                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-3">
                            <button type="button" wire:click="closeModals"
                                class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all font-semibold flex items-center space-x-2 group">
                                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Annuler</span>
                            </button>

                            <button type="submit" wire:loading.attr="disabled"
                                class="relative px-6 py-3 bg-gradient-to-r from-green-500 via-green-600 to-green-700 text-white rounded-xl hover:from-green-600 hover:via-green-700 hover:to-green-800 transition-all font-bold shadow-xl hover:shadow-2xl disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105 active:scale-95 flex items-center space-x-3 overflow-hidden group">
                                <!-- Animated Background -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-green-400 to-yellow-400 opacity-0 group-hover:opacity-20 transition-opacity">
                                </div>

                                <!-- Icon and Text -->
                                <div class="relative flex items-center space-x-3">
                                    <svg wire:loading.remove wire:target="save"
                                        class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <svg wire:loading wire:target="save" class="w-6 h-6 animate-spin" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>

                                    <span wire:loading.remove wire:target="save" class="text-lg">
                                        <span
                                            x-text="$wire.showCreateModal ? '✨ Créer l\'Article' : '💾 Mettre à Jour'"></span>
                                    </span>
                                    <span wire:loading wire:target="save" class="text-lg">
                                        Enregistrement en cours...
                                    </span>
                                </div>

                                <!-- Shine Effect -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-30 transform -skew-x-12 group-hover:translate-x-full transition-all duration-1000">
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom Scrollbar Styles -->
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
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

        /* Animation pour le champ de saisie */
        @keyframes pulse-border {

            0%,
            100% {
                border-color: rgba(34, 197, 94, 0.3);
            }

            50% {
                border-color: rgba(34, 197, 94, 0.6);
            }
        }

        input:focus,
        textarea:focus,
        select:focus {
            animation: pulse-border 2s ease-in-out infinite;
        }

        /* Animation pour les icônes */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        /* .group:hover svg {
            animation: float 2s ease-in-out infinite;
        } */

        /* Gradient Animation */
        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* File Upload Hover Effect */
        input[type="file"]:hover {
            cursor: pointer;
        }

        /* Smooth transitions for all interactive elements */
        * {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>



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
        <div x-data="{ scrollProgress: 0 }" x-init="$watch('scrollProgress', value => {
            const modal = $el.querySelector('.modal-content');
            modal.addEventListener('scroll', () => {
                const winScroll = modal.scrollTop;
                const height = modal.scrollHeight - modal.clientHeight;
                scrollProgress = (winScroll / height) * 100;
            });
        })"
            class="fixed inset-0 bg-gradient-to-br from-black/70 via-black/60 to-black/70 backdrop-blur-md z-50 flex items-center justify-center p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">

            <div class="bg-white rounded-3xl shadow-2xl max-w-5xl w-full max-h-[95vh] overflow-hidden border border-gray-100 transform"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                <!-- Header avec Gradient et Barre de Progression -->
                <div class="sticky top-0 z-20 bg-white border-b border-gray-200 shadow-lg">
                    <!-- Progress Bar -->
                    <div class="h-1 bg-gray-200">
                        <div class="h-full bg-gradient-to-r from-green-500 via-green-600 to-yellow-500 transition-all duration-300 shadow-lg"
                            :style="`width: ${scrollProgress}%`"></div>
                    </div>

                    <!-- Header Content -->
                    <div class="relative bg-gradient-to-r from-green-600 via-green-500 to-yellow-500 px-8 py-6">
                        <div class="absolute inset-0 opacity-20"
                            style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                        </div>

                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="bg-white/20 backdrop-blur-md rounded-2xl p-3 shadow-2xl border border-white/30">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h2
                                        class="text-2xl font-black text-white tracking-tight flex items-center space-x-2">
                                        <span>✨ Prévisualisation</span>
                                    </h2>
                                    <p class="text-green-100 text-sm font-medium">Aperçu de votre article avant
                                        publication</p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-3">
                                <!-- Bouton Plein Écran -->
                                <button onclick="document.querySelector('.modal-content').requestFullscreen()"
                                    class="p-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-xl transition-all transform hover:scale-110">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                                        </path>
                                    </svg>
                                </button>

                                <!-- Bouton Fermer -->
                                <button wire:click="closeModals"
                                    class="p-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-xl transition-all transform hover:scale-110 hover:rotate-90 group">
                                    <svg class="w-6 h-6 transition-transform" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs Navigation -->
                    <div class="bg-white px-8 py-3 border-b border-gray-100 flex items-center space-x-2">
                        <button
                            class="px-4 py-2 bg-green-100 text-green-700 rounded-lg font-semibold text-sm flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>Vue Bureau</span>
                        </button>
                        {{-- <button
                            class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg font-semibold text-sm flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>Vue Mobile</span>
                        </button> --}}
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="modal-content overflow-y-auto max-h-[calc(95vh-160px)] bg-gray-50 custom-scrollbar">
                    @if ($selectedPost)
                        <div class="max-w-4xl mx-auto px-6 py-12">
                            <!-- Article Header -->
                            <article class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">

                                <!-- Featured Image -->
                                @if ($selectedPost->featured_image)
                                    <div class="relative h-96 overflow-hidden group">
                                        <img src="{{ Storage::url($selectedPost->featured_image) }}"
                                            alt="{{ $selectedPost->title }}"
                                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                                        </div>

                                        <!-- Category Badge on Image -->
                                        @if ($selectedPost->category)
                                            <div class="absolute top-6 left-6">
                                                <span
                                                    class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-green-500/90 backdrop-blur-sm border border-white/30 text-white font-semibold text-sm shadow-xl">
                                                    <span
                                                        class="text-lg">{{ $selectedPost->category->icon ?? '📁' }}</span>
                                                    <span>{{ $selectedPost->category->name }}</span>
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <!-- Article Content -->
                                <div class="p-8 md:p-12">
                                    <!-- Title -->
                                    <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 leading-tight">
                                        {{ $selectedPost->title }}
                                    </h1>

                                    <!-- Meta Info -->
                                    <div
                                        class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-8 pb-8 border-b-2 border-gray-100">
                                        <!-- Author -->
                                        <div class="flex items-center space-x-3">
                                            <img src="{{ $selectedPost->author->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($selectedPost->author->name) . '&background=22c55e&color=fff' }}"
                                                alt="{{ $selectedPost->author->name }}"
                                                class="w-12 h-12 rounded-full ring-2 ring-green-500">
                                            <div>
                                                <p class="font-bold text-gray-900">{{ $selectedPost->author->name }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $selectedPost->author->role->name ?? 'Auteur' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center space-x-4 text-gray-500">
                                            <!-- Date -->
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-5 h-5 text-green-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <span
                                                    class="font-medium">{{ $selectedPost->published_at?->format('d F Y') ?? 'Non publié' }}</span>
                                            </div>

                                            <!-- Reading Time -->
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-5 h-5 text-green-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="font-medium">{{ $selectedPost->reading_time ?? 5 }}
                                                    min</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Excerpt -->
                                    @if ($selectedPost->excerpt)
                                        <div
                                            class="bg-gradient-to-r from-green-50 to-yellow-50 border-l-4 border-green-500 rounded-r-2xl p-6 mb-8">
                                            <p class="text-lg text-gray-700 leading-relaxed italic">
                                                {{ $selectedPost->excerpt }}
                                            </p>
                                        </div>
                                    @endif

                                    <!-- Main Content -->
                                    <div
                                        class="prose prose-lg prose-green max-w-none
                                       prose-headings:font-bold prose-headings:text-gray-900
                                       prose-h2:text-3xl prose-h2:mt-12 prose-h2:mb-6 prose-h2:pb-4 prose-h2:border-b-4 prose-h2:border-green-500
                                       prose-h3:text-2xl prose-h3:mt-8 prose-h3:mb-4 prose-h3:text-green-700
                                       prose-p:text-gray-700 prose-p:leading-relaxed prose-p:mb-6
                                       prose-a:text-green-600 prose-a:no-underline hover:prose-a:underline prose-a:font-semibold
                                       prose-strong:text-gray-900 prose-strong:font-bold
                                       prose-ul:my-6 prose-li:my-2 prose-li:text-gray-700
                                       prose-img:rounded-2xl prose-img:shadow-2xl prose-img:my-8 prose-img:border-4 prose-img:border-green-100
                                       prose-blockquote:border-l-4 prose-blockquote:border-green-500 prose-blockquote:bg-green-50 prose-blockquote:py-4 prose-blockquote:px-6 prose-blockquote:rounded-r-xl prose-blockquote:italic prose-blockquote:text-gray-700
                                       prose-code:bg-gray-100 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:text-sm prose-code:text-green-600">
                                        {!! $selectedPost->content !!}
                                    </div>

                                    <!-- Tags Section -->
                                    @if ($selectedPost->tags && $selectedPost->tags->count() > 0)
                                        <div class="mt-12 pt-8 border-t-2 border-gray-100">
                                            <div class="flex items-center space-x-3 mb-4">
                                                <svg class="w-6 h-6 text-green-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                    </path>
                                                </svg>
                                                <h3 class="text-xl font-bold text-gray-900">Tags</h3>
                                            </div>
                                            <div class="flex flex-wrap gap-3">
                                                @foreach ($selectedPost->tags as $tag)
                                                    <span
                                                        class="inline-flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-yellow-100 to-orange-100 border border-yellow-200 text-yellow-800 rounded-xl font-semibold text-sm hover:shadow-lg transition-all transform hover:scale-105">
                                                        <span>🏷️</span>
                                                        <span>#{{ $tag->name }}</span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Social Share Section -->
                                    <div class="mt-12 pt-8 border-t-2 border-gray-100">
                                        <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-2xl p-8">
                                            <div
                                                class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                                                <div class="flex items-center space-x-4">
                                                    <div
                                                        class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                                                        <svg class="w-8 h-8 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="text-xl font-bold text-gray-900">Partagez cet
                                                            article</h4>
                                                        <p class="text-sm text-gray-600">Faites découvrir ce contenu à
                                                            votre communauté</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-3">
                                                    <button
                                                        class="w-12 h-12 bg-blue-600 hover:bg-blue-700 rounded-xl flex items-center justify-center text-white transition-all transform hover:scale-110 shadow-lg">
                                                        <svg class="w-6 h-6" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                                        </svg>
                                                    </button>
                                                    <button
                                                        class="w-12 h-12 bg-sky-500 hover:bg-sky-600 rounded-xl flex items-center justify-center text-white transition-all transform hover:scale-110 shadow-lg">
                                                        <svg class="w-6 h-6" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                                        </svg>
                                                    </button>
                                                    <button
                                                        class="w-12 h-12 bg-green-600 hover:bg-green-700 rounded-xl flex items-center justify-center text-white transition-all transform hover:scale-110 shadow-lg">
                                                        <svg class="w-6 h-6" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                                        </svg>
                                                    </button>
                                                    <button
                                                        class="w-12 h-12 bg-blue-700 hover:bg-blue-800 rounded-xl flex items-center justify-center text-white transition-all transform hover:scale-110 shadow-lg">
                                                        <svg class="w-6 h-6" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <!-- Call to Action -->
                            <div
                                class="mt-8 bg-gradient-to-r from-green-600 via-green-500 to-yellow-500 rounded-3xl p-8 shadow-2xl text-center text-white">
                                <h3 class="text-2xl font-black mb-3">Prêt à publier votre article ?</h3>
                                <p class="text-green-100 mb-6">Partagez vos connaissances avec la communauté AgroSpace
                                </p>
                                <button wire:click="closeModals"
                                    class="px-8 py-4 bg-white text-green-600 rounded-xl font-bold hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg">
                                    Retour à l'édition
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Custom Scrollbar Styles -->
        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 10px;
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
        </style>
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
