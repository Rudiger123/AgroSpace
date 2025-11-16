<div>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-agro-green font-poppins">Gestion du Blog</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        @can('create', App\Models\Post::class)
                            <button wire:click="create" 
                                    class="inline-flex items-center px-6 py-3 bg-agro-green text-white rounded-xl hover:bg-green-700 transition-all duration-300 shadow-lg hover:shadow-xl font-inter font-medium group">
                                <svg class="w-5 h-5 mr-2 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Nouvel article
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- List Mode -->
            @if($mode === 'list')
                <!-- Filters Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border border-gray-100">
                    <div class="grid md:grid-cols-4 gap-6">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-agro-gray mb-2 font-inter">Rechercher</label>
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.300ms="search" 
                                       placeholder="Titre, contenu..."
                                       class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                                <svg class="absolute left-3 top-3.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Category Filter -->
                        <div>
                            <label class="block text-sm font-medium text-agro-gray mb-2 font-inter">Catégorie</label>
                            <select wire:model.live="filterCategory" 
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                                <option value="">Toutes</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Status Filter -->
                        <div>
                            <label class="block text-sm font-medium text-agro-gray mb-2 font-inter">Statut</label>
                            <select wire:model.live="filterStatus" 
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                                <option value="">Tous</option>
                                <option value="published">Publié</option>
                                <option value="draft">Brouillon</option>
                                <option value="scheduled">Programmé</option>
                            </select>
                        </div>
                        
                        <!-- Author Filter -->
                        @if(Auth::user()->isAdmin() && $authors->count() > 0)
                            <div>
                                <label class="block text-sm font-medium text-agro-gray mb-2 font-inter">Auteur</label>
                                <select wire:model.live="filterAuthor" 
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                                    <option value="">Tous</option>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
    
                <!-- Articles Grid -->
                <div class="grid gap-6">
                    @forelse($posts as $post)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4 flex-1">
                                        <!-- Image -->
                                        <div class="flex-shrink-0">
                                            @if($post->featured_image)
                                                <img src="{{ Storage::url($post->featured_image) }}" 
                                                     alt="{{ $post->title }}"
                                                     class="w-20 h-20 rounded-xl object-cover shadow-md">
                                            @else
                                                <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-agro-green to-green-600 flex items-center justify-center shadow-md">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7.414A2 2 0 0013.414 6L12 4.586A2 2 0 0010.586 4H5a2 2 0 00-2 2v12a2 2 0 002 2h14z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
    
                                        <!-- Content -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-3 mb-2">
                                                <h3 class="text-lg font-semibold text-agro-gray truncate font-poppins">
                                                    {{ $post->title }}
                                                </h3>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                    {{ $post->published ? 'bg-green-100 text-green-800' : 'bg-earth-100 text-earth-800' }} font-inter">
                                                    {{ $post->published ? 'Publié' : 'Brouillon' }}
                                                </span>
                                            </div>
                                            
                                            <p class="text-gray-600 text-sm mb-3 line-clamp-2 font-inter">
                                                {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                                            </p>
                                            
                                            <div class="flex items-center space-x-6 text-sm text-gray-500">
                                                <div class="flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    <span class="font-inter">{{ $post->author->name }}</span>
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span class="font-inter">{{ $post->published_at?->format('d/m/Y') ?? 'Non publié' }}</span>
                                                </div>
                                                <div class="flex items-center space-x-4">
                                                    <span class="flex items-center space-x-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                        <span class="font-inter">{{ number_format($post->views_count) }}</span>
                                                    </span>
                                                    <span class="flex items-center space-x-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                        </svg>
                                                        <span class="font-inter">{{ number_format($post->likes_count) }}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <!-- Actions -->
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('blog.show', $post->slug) }}" 
                                           target="_blank"
                                           class="p-2 text-gray-400 hover:text-agro-green transition-colors duration-200 rounded-lg hover:bg-green-50"
                                           title="Voir">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        @can('update', $post)
                                            <button wire:click="edit({{ $post->id }})" 
                                                    class="p-2 text-gray-400 hover:text-blue-600 transition-colors duration-200 rounded-lg hover:bg-blue-50"
                                                    title="Modifier">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                        @endcan
                                        
                                        <button wire:click="togglePublish({{ $post->id }})" 
                                                class="p-2 {{ $post->published ? 'text-yellow-400 hover:text-yellow-600' : 'text-green-400 hover:text-green-600' }} transition-colors duration-200 rounded-lg {{ $post->published ? 'hover:bg-yellow-50' : 'hover:bg-green-50' }}"
                                                title="{{ $post->published ? 'Dépublier' : 'Publier' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                        
                                        @can('delete', $post)
                                            <button wire:click="confirmDelete({{ $post->id }})" 
                                                    class="p-2 text-gray-400 hover:text-red-600 transition-colors duration-200 rounded-lg hover:bg-red-50"
                                                    title="Supprimer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Empty State -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                            <div class="max-w-md mx-auto">
                                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-agro-green to-green-600 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-agro-gray mb-2 font-poppins">Aucun article</h3>
                                <p class="text-gray-600 mb-6 font-inter">
                                    Commencez par créer votre premier article pour partager vos connaissances.
                                </p>
                                <button wire:click="create" 
                                        class="inline-flex items-center px-6 py-3 bg-agro-green text-white rounded-xl hover:bg-green-700 transition-all duration-300 shadow-lg hover:shadow-xl font-inter font-medium">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Créer un article
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>
    
                <!-- Pagination -->
                @if($posts->hasPages())
                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
                @endif
            @endif
    
            <!-- Create/Edit Form -->
            @if($mode === 'create' || $mode === 'edit')
                <div class="max-w-6xl mx-auto">
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                        <!-- Form Header -->
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h2 class="text-2xl font-bold text-agro-gray font-poppins">
                                    {{ $mode === 'create' ? 'Créer un nouvel article' : 'Modifier l\'article' }}
                                </h2>
                                <button wire:click="cancel" 
                                        class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
    
                        <!-- Form Body -->
                        <form wire:submit.prevent="save">
                            <div class="p-6 space-y-6 max-h-[80vh] overflow-y-auto">
                                <!-- Title and Slug -->
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="title" class="block text-sm font-medium text-agro-gray mb-2 font-inter">
                                            Titre <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               wire:model="title" 
                                               id="title"
                                               wire:blur="generateSlug"
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white font-inter"
                                               placeholder="Titre de l'article">
                                        @error('title')
                                            <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="slug" class="block text-sm font-medium text-agro-gray mb-2 font-inter">
                                            Slug <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               wire:model="slug" 
                                               id="slug"
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white font-inter"
                                               placeholder="slug-de-l-article">
                                        @error('slug')
                                            <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
    
                                <!-- Category and Tags -->
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="category_id" class="block text-sm font-medium text-agro-gray mb-2 font-inter">
                                            Catégorie
                                        </label>
                                        <select wire:model="category_id" 
                                                id="category_id"
                                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white font-inter">
                                            <option value="">Sélectionner une catégorie</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="tags" class="block text-sm font-medium text-agro-gray mb-2 font-inter">
                                            Tags
                                        </label>
                                        <select wire:model="tags" 
                                                id="tags"
                                                multiple
                                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white font-inter">
                                            @foreach($allTags as $tag)
                                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                            @endforeach
                                        </select>
                                        <p class="mt-2 text-sm text-gray-500 font-inter">Maintenez Ctrl pour sélectionner plusieurs tags</p>
                                        @error('tags')
                                            <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
    
                                <!-- Featured Image -->
                                <div>
                                    <label class="block text-sm font-medium text-agro-gray mb-2 font-inter">
                                        Image de couverture
                                    </label>
                                    <div class="flex items-center gap-4">
                                        @if($existing_image)
                                            <div class="relative">
                                                <img src="{{ Storage::url($existing_image) }}" 
                                                     alt="Image actuelle"
                                                     class="w-24 h-24 rounded-xl object-cover shadow-md">
                                                <button type="button" 
                                                        wire:click="$set('existing_image', '')"
                                                        class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors">
                                                    ✕
                                                </button>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <input type="file" 
                                                   wire:model="featured_image" 
                                                   accept="image/*"
                                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-agro-green file:text-white hover:file:bg-green-700">
                                            <p class="mt-2 text-sm text-gray-500 font-inter">PNG, JPG, GIF jusqu'à 2MB</p>
                                        </div>
                                    </div>
                                    @error('featured_image')
                                        <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                                    @enderror
                                </div>
    
                                <!-- Excerpt -->
                                <div>
                                    <label for="excerpt" class="block text-sm font-medium text-agro-gray mb-2 font-inter">
                                        Résumé
                                    </label>
                                    <textarea wire:model="excerpt" 
                                              id="excerpt"
                                              rows="3"
                                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white font-inter"
                                              placeholder="Résumé de l'article (optionnel, généré automatiquement si vide)"></textarea>
                                    @error('excerpt')
                                        <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                                    @enderror
                                </div>
    
                                <!-- Content -->
                                <div>
                                    <label for="content" class="block text-sm font-medium text-agro-gray mb-2 font-inter">
                                        Contenu <span class="text-red-500">*</span>
                                    </label>
                                    <div wire:ignore>
                                        <textarea wire:model="content" 
                                                  id="content"
                                                  rows="12"
                                                  class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white font-inter"
                                                  placeholder="Contenu de l'article"></textarea>
                                    </div>
                                    @error('content')
                                        <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                                    @enderror
                                </div>
    
                                <!-- Publishing Options -->
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="flex items-center space-x-3">
                                        <input type="checkbox" 
                                               wire:model="published" 
                                               id="published"
                                               class="w-4 h-4 text-agro-green focus:ring-agro-green border-gray-300 rounded">
                                        <label for="published" class="text-sm font-medium text-agro-gray font-inter">
                                            Publier maintenant
                                        </label>
                                    </div>
                                    
                                    <div>
                                        <label for="published_at" class="block text-sm font-medium text-agro-gray mb-2 font-inter">
                                            Date de publication
                                        </label>
                                        <input type="datetime-local" 
                                               wire:model="published_at" 
                                               id="published_at"
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white font-inter">
                                        @error('published_at')
                                            <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
    
                                <!-- SEO -->
                                <div class="border-t border-gray-200 pt-6">
                                    <h3 class="text-lg font-semibold text-agro-gray mb-4 font-poppins">Optimisation SEO</h3>
                                    
                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="meta_title" class="block text-sm font-medium text-agro-gray mb-2 font-inter">
                                                Meta Title
                                            </label>
                                            <input type="text" 
                                                   wire:model="meta_title" 
                                                   id="meta_title"
                                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white font-inter"
                                                   placeholder="Titre pour les moteurs de recherche">
                                            @error('meta_title')
                                                <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="meta_description" class="block text-sm font-medium text-agro-gray mb-2 font-inter">
                                                Meta Description
                                            </label>
                                            <textarea wire:model="meta_description" 
                                                      id="meta_description"
                                                      rows="3"
                                                      class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white font-inter"
                                                      placeholder="Description pour les moteurs de recherche"></textarea>
                                            @error('meta_description')
                                                <p class="mt-2 text-sm text-red-600 font-inter">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <!-- Form Footer -->
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-4">
                                <button type="button" wire:click="cancel" 
                                        class="px-6 py-3 text-sm font-medium text-agro-gray bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-agro-green transition-all duration-200 font-inter">
                                    Annuler
                                </button>
                                <button type="submit" 
                                        class="px-6 py-3 text-sm font-medium text-white bg-agro-green border border-transparent rounded-xl hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-agro-green transition-all duration-200 shadow-lg hover:shadow-xl font-inter">
                                    {{ $mode === 'create' ? 'Créer l\'article' : 'Mettre à jour' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
    
            <!-- Delete Confirmation Modal -->
            @if($showDeleteModal)
                <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full animate-scale-in">
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            
                            <h3 class="text-xl font-semibold text-agro-gray mb-2 font-poppins">Confirmer la suppression</h3>
                            <p class="text-gray-600 mb-6 font-inter">
                                Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.
                            </p>
                            
                            <div class="flex items-center justify-center gap-4">
                                <button wire:click="closeDeleteModal" 
                                        class="px-6 py-3 text-sm font-medium text-agro-gray bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 font-inter">
                                    Annuler
                                </button>
                                <button wire:click="delete({{ $selectedPost->id ?? 0 }})" 
                                        wire:loading.attr="disabled"
                                        class="px-6 py-3 text-sm font-medium text-white bg-red-600 border border-transparent rounded-xl hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 font-inter">
                                    <span wire:loading.remove>Supprimer</span>
                                    <span wire:loading>
                                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
    
            <!-- Preview Modal -->
            @if($showPreviewModal)
                <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-bold text-agro-gray font-poppins">Prévisualisation</h2>
                                <button wire:click="closePreviewModal" 
                                        class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
    
                            <div class="prose max-w-none">
                                @if($selectedPost)
                                    <article class="bg-white rounded-lg">
                                        @if($selectedPost->featured_image)
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
                                            @if($selectedPost->category)
                                                <span>•</span>
                                                <span class="px-2 py-1 bg-agro-green text-white rounded-full text-xs">
                                                    {{ $selectedPost->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="text-gray-700 leading-relaxed font-inter">
                                            {!! $selectedPost->content !!}
                                        </div>
                                        
                                        @if($selectedPost->tags->count() > 0)
                                            <div class="mt-8 pt-6 border-t border-gray-200">
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($selectedPost->tags as $tag)
                                                        <span class="px-3 py-1 bg-earth-100 text-earth-800 rounded-full text-sm font-inter">
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
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Focus sur le titre quand on crée/modifie
            Livewire.on('focus-title', () => {
                setTimeout(() => {
                    const titleInput = document.getElementById('title');
                    if (titleInput) titleInput.focus();
                }, 300);
            });
        });
    
        // Initialisation CKEditor
        if (typeof ClassicEditor !== 'undefined') {
            ClassicEditor
                .create(document.querySelector('#content'), {
                    toolbar: {
                        items: [
                            'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 
                            'numberedList', '|', 'outdent', 'indent', '|', 'imageUpload',
                            'blockQuote', 'insertTable', 'mediaEmbed', 'undo', 'redo'
                        ]
                    },
                    language: 'fr',
                    image: {
                        toolbar: [
                            'imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side'
                        ]
                    }
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('content', editor.getData());
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
    @endpush
    
    <style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .prose {
        max-width: none;
    }
    
    .prose h1, .prose h2, .prose h3 {
        font-family: 'Poppins', sans-serif;
        color: #1B5E20;
    }
    
    .prose p {
        font-family: 'Inter', sans-serif;
        color: #37474F;
    }
    
    .animate-scale-in {
        animation: scaleIn 0.2s ease-out;
    }
    
    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    /* Scrollbar personnalisée */
    ::-webkit-scrollbar {
        width: 6px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    </style>
</div>