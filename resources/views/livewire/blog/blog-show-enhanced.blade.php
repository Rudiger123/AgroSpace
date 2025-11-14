<div>
    <!-- Article Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumb -->
            <nav class="flex items-center text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
                <a href="{{ route('blog.index') }}" class="hover:text-gray-700">Blog</a>
                <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                @if($post->category)
                    <a href="{{ route('blog.index', ['category' => $post->category->id]) }}" 
                       class="hover:text-gray-700">{{ $post->category->name }}</a>
                    <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                @endif
                <span class="text-gray-900">{{ $post->title }}</span>
            </nav>

            <!-- Title and Meta -->
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    {{ $post->title }}
                </h1>
                
                @if($post->excerpt)
                    <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                        {{ $post->excerpt }}
                    </p>
                @endif

                <!-- Author and Date -->
                <div class="flex items-center justify-center gap-6 text-gray-600 mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="font-medium text-gray-900">{{ $post->author->name }}</div>
                            <div class="text-sm">{{ $post->formatted_published_date }}</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 text-sm">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $post->reading_time }} min de lecture
                        </span>
                        @if($post->views_count > 0)
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ number_format($viewsCount) }} vues
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Tags -->
                @if($post->tags->count() > 0)
                    <div class="flex flex-wrap justify-center gap-2 mb-8">
                        @foreach($post->tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag->id]) }}" 
                               class="px-3 py-1 text-sm bg-green-100 text-green-800 rounded-full hover:bg-green-200 transition-colors">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </header>

    <!-- Featured Image -->
    @if($post->featured_image)
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <img src="{{ Storage::url($post->featured_image) }}" 
                 alt="{{ $post->title }}"
                 class="w-full h-auto rounded-2xl shadow-lg">
        </div>
    @endif

    <!-- Article Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-4 gap-12">
            
            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <!-- Table of Contents -->
                <div class="sticky top-8 bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Sommaire</h3>
                    <nav class="space-y-2">
                        <a href="#content" class="block text-sm text-gray-600 hover:text-green-600 py-1">
                            Introduction
                        </a>
                        @if($post->category)
                            <a href="{{ route('blog.index', ['category' => $post->category->id]) }}" 
                               class="block text-sm text-gray-600 hover:text-green-600 py-1">
                                {{ $post->category->name }}
                            </a>
                        @endif
                    </nav>
                </div>

                <!-- Share Article -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Partager</h3>
                    <div class="space-y-3">
                        <button wire:click="share('facebook')" 
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </button>
                        
                        <button wire:click="share('twitter')" 
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            Twitter
                        </button>
                        
                        <button wire:click="share('linkedin')" 
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            LinkedIn
                        </button>
                        
                        <button wire:click="share('whatsapp')" 
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            WhatsApp
                        </button>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Article Body -->
                <article id="content" class="bg-white rounded-xl shadow-sm p-8 mb-8">
                    <div class="prose prose-lg max-w-none">
                        {!! $post->content !!}
                    </div>
                </article>

                <!-- Engagement Stats -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <!-- Like Button -->
                            <button wire:click="toggleLike" 
                                    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors {{ $isLiked ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700 hover:bg-red-50' }}">
                                <svg class="w-5 h-5" fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span>{{ number_format($likesCount) }}</span>
                            </button>

                            <!-- Comments Count -->
                            <div class="flex items-center gap-2 text-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <span>{{ number_format($commentsCount) }} commentaires</span>
                            </div>

                            <!-- Shares Count -->
                            <div class="flex items-center gap-2 text-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                </svg>
                                <span>{{ number_format($sharesCount) }} partages</span>
                            </div>
                        </div>

                        <!-- Share Button -->
                        <button wire:click="$set('showShareModal', true)" 
                                class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                            </svg>
                            Partager
                        </button>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    @if($previousPost)
                        <a href="{{ route('blog.show', $previousPost->slug) }}" 
                           class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow group">
                            <div class="flex items-center gap-3 text-sm text-gray-500 mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Article précédent
                            </div>
                            <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition-colors">
                                {{ $previousPost->title }}
                            </h3>
                        </a>
                    @endif

                    @if($nextPost)
                        <a href="{{ route('blog.show', $nextPost->slug) }}" 
                           class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow group">
                            <div class="flex items-center justify-end gap-3 text-sm text-gray-500 mb-2">
                                Article suivant
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 text-right group-hover:text-green-600 transition-colors">
                                {{ $nextPost->title }}
                            </h3>
                        </a>
                    @endif
                </div>

                <!-- Related Posts -->
                @if($relatedPosts->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Articles similaires</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            @foreach($relatedPosts as $related)
                                <a href="{{ route('blog.show', $related->slug) }}" 
                                   class="group">
                                    <div class="flex gap-4">
                                        @if($related->featured_image)
                                            <img src="{{ Storage::url($related->featured_image) }}" 
                                                 alt="{{ $related->title }}"
                                                 class="w-24 h-24 rounded-lg object-cover flex-shrink-0">
                                        @else
                                            <div class="w-24 h-24 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7.414A2 2 0 0013.414 6L12 4.586A2 2 0 0010.586 4H5a2 2 0 00-2 2v12a2 2 0 002 2h14z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 group-hover:text-green-600 transition-colors mb-2">
                                                {{ $related->title }}
                                            </h4>
                                            <p class="text-sm text-gray-600 mb-2 line-clamp-2">
                                                {{ $related->excerpt }}
                                            </p>
                                            <div class="text-xs text-gray-500">
                                                {{ $related->formatted_published_date }} • {{ $related->reading_time }} min
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Comments Section -->
                <div class="bg-white rounded-xl shadow-sm p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">
                            Commentaires ({{ number_format($commentsCount) }})
                        </h3>
                        @if($comments->count() > 5)
                            <button wire:click="$set('showAllComments', {{ !$showAllComments }})" 
                                    class="text-sm text-green-600 hover:text-green-800">
                                {{ $showAllComments ? 'Voir moins' : 'Voir tous' }}
                            </button>
                        @endif
                    </div>

                    <!-- Add Comment Form -->
                    @auth
                        <div class="mb-8">
                            <form wire:submit.prevent="addComment">
                                <div class="mb-4">
                                    <textarea wire:model="commentContent" 
                                              id="comment-input"
                                              rows="4"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                              placeholder="Ajouter un commentaire..."
                                              {{ $replyingTo ? 'autofocus' : '' }}></textarea>
                                    @error('commentContent')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                @if($replyingTo)
                                    <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                                        <p class="text-sm text-blue-800">
                                            Répondre au commentaire #{{ $replyingTo }}
                                        </p>
                                        <button type="button" wire:click="cancelReply" 
                                                class="text-sm text-blue-600 hover:text-blue-800">
                                            Annuler
                                        </button>
                                    </div>
                                @endif
                                
                                <div class="flex justify-end">
                                    <button type="submit" 
                                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                        Publier
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mb-8 p-6 bg-gray-50 rounded-lg text-center">
                            <p class="text-gray-600 mb-4">Connectez-vous pour laisser un commentaire</p>
                            <a href="{{ route('login') }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                Se connecter
                            </a>
                        </div>
                    @endauth

                    <!-- Comments List -->
                    <div class="space-y-6">
                        @forelse($comments as $comment)
                            <div class="border-l-2 border-gray-200 pl-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                                            <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-700 mb-3">{{ $comment->content }}</p>
                                        <div class="flex items-center gap-4 text-sm">
                                            <button class="text-gray-500 hover:text-green-600">
                                                J'aime
                                            </button>
                                            @auth
                                                <button wire:click="replyTo({{ $comment->id }})" 
                                                        class="text-gray-500 hover:text-green-600">
                                                    Répondre
                                                </button>
                                            @endauth
                                        </div>
                                    </div>
                                </div>

                                <!-- Replies -->
                                @if($comment->replies->count() > 0)
                                    <div class="mt-4 ml-10 space-y-3">
                                        @foreach($comment->replies as $reply)
                                            <div class="flex items-start gap-3">
                                                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="font-medium text-gray-900 text-sm">{{ $reply->user->name }}</span>
                                                        <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-sm text-gray-700">{{ $reply->content }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun commentaire</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Soyez le premier à commenter cet article.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Share Modal -->
    @if($showShareModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Partager l'article</h3>
                    <button wire:click="$set('showShareModal', false)" 
                            class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lien de partage</label>
                    <div class="flex">
                        <input type="text" value="{{ $shareUrl }}" 
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg bg-gray-50"
                               readonly>
                        <button onclick="navigator.clipboard.writeText('{{ $shareUrl }}')" 
                                class="px-4 py-2 bg-green-600 text-white rounded-r-lg hover:bg-green-700 transition-colors">
                            Copier
                        </button>
                    </div>
                </div>
                
                <div class="text-center">
                    <p class="text-sm text-gray-600">Partagez cet article avec votre réseau</p>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        // Reading progress tracking
        let startTime = Date.now();
        let maxScroll = 0;
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = Math.round((scrollTop / docHeight) * 100);
            
            maxScroll = Math.max(maxScroll, scrollPercent);
            
            const timeSpent = Math.round((Date.now() - startTime) / 1000);
            
            @this.updateReadingProgress(maxScroll, timeSpent);
        });
        
        // Focus comment input when replying
        window.addEventListener('focusCommentInput', function() {
            setTimeout(() => {
                document.getElementById('comment-input').focus();
            }, 100);
        });
    </script>
@endpush