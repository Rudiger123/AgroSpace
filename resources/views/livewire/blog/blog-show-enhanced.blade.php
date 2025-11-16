<div x-data="{
    showAuthorModal: false,
    showShareModal: {{ $showShareModal ? 'true' : 'false' }},
    scrollProgress: 0,

    init() {
        window.addEventListener('scroll', () => {
            const winScroll = document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            this.scrollProgress = (winScroll / height) * 100;
        });
    }
}">

    <x-layouts.header />

    <!-- Barre de progression de lecture -->
    <div class="fixed top-0 left-0 w-full h-1 bg-gray-200 z-50">
        <div class="h-full bg-gradient-to-r from-green-500 via-green-600 to-yellow-500 transition-all duration-300 shadow-lg"
            :style="`width: ${scrollProgress}%`"></div>
    </div>

    <!-- Hero Header avec image de fond -->
    <header class="relative bg-gradient-to-br from-gray-900 via-green-900 to-gray-900 overflow-hidden">
        <!-- Background pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot ;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>
        </div>

        <!-- Image de couverture en arrière-plan -->
        @if ($post->featured_image)
            <div class="absolute inset-0">
                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover opacity-20">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
            </div>
        @endif

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <!-- Breadcrumb moderne -->
            <nav class="flex items-center text-sm text-gray-300 mb-8 space-x-2" aria-label="Breadcrumb">
                <a href="{{ route('blog.index') }}" wire:navigate
                    class="hover:text-white transition flex items-center space-x-1 group">
                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Blog</span>
                </a>
                @if ($post->category)
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <a href="{{ route('blog.index', ['category' => $post->category->id]) }}" wire:navigate
                        class="hover:text-white transition">{{ $post->category->name }}</a>
                @endif
            </nav>

            <!-- Catégorie badge -->
            @if ($post->category)
                <div class="mb-6">
                    <span
                        class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-green-500/20 backdrop-blur-sm border border-green-500/30 text-green-300 font-semibold text-sm">
                        <span class="text-xl">{{ $post->category->icon ?? '📁' }}</span>
                        <span>{{ $post->category->name }}</span>
                    </span>
                </div>
            @endif

            <!-- Titre -->
            <h1 class="text-4xl md:text-6xl font-black text-white mb-6 leading-tight">
                {{ $post->title }}
            </h1>

            <!-- Sous-titre/Excerpt -->
            @if ($post->excerpt)
                <p class="text-xl md:text-2xl text-gray-200 mb-8 leading-relaxed max-w-4xl">
                    {{ $post->excerpt }}
                </p>
            @endif

            <!-- Métadonnées de l'auteur -->
            <div class="flex flex-wrap items-center gap-6 text-gray-300">
                <!-- Auteur avec avatar cliquable -->
                <button @click="showAuthorModal = true"
                    class="flex items-center space-x-3 hover:bg-white/10 rounded-xl p-2 -ml-2 transition group">
                    <div class="relative">
                        <img src="{{ $post->author->avatar_url ?? 'https://ui-avatars.com/api/?name= ' . urlencode($post->author->name) . '&background=22c55e&color=fff' }}"
                            alt="{{ $post->author->name }}"
                            class="w-14 h-14 rounded-full ring-4 ring-white/20 group-hover:ring-white/40 transition">
                        @if ($post->author->is_verified ?? false)
                            <div class="absolute -bottom-1 -right-1 bg-blue-500 rounded-full p-1 ring-2 ring-gray-900">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="text-left">
                        <p class="font-bold text-white text-lg group-hover:text-green-400 transition">
                            {{ $post->author->name }}</p>
                        <p class="text-sm text-gray-400">{{ $post->author->role?->name }}</p>
                    </div>
                </button>

                <div class="hidden md:flex items-center space-x-6 text-sm">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>{{ $post->published_at->isoFormat('D MMMM YYYY') }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $post->reading_time ?? 5 }} min de lecture</span>
                    </div>
                    @if ($viewsCount > 0)
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            <span>{{ number_format($viewsCount) }} vues</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tags -->
            @if ($post->tags && $post->tags->count() > 0)
                <div class="flex flex-wrap gap-2 mt-6">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('blog.index', ['tag' => $tag->id]) }}" wire:navigate
                            class="px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white/20 transition text-sm font-medium">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </header>

    <!-- Actions flottantes (sticky) -->
    {{-- <div class="sticky top-20 z-40 bg-white/95 backdrop-blur-xl shadow-lg border-b border-gray-200"> --}}
    <div class="sticky top-20 z-40 bg-transparent">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Like -->
                    <button wire:click="toggleLike"
                        class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all transform hover:scale-105 {{ $isLiked ? 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-red-50' }}">
                        <svg class="w-5 h-5 {{ $isLiked ? 'animate-bounce' : '' }}"
                            fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                        <span class="font-bold">{{ number_format($likesCount) }}</span>
                    </button>

                    <!-- Commentaires -->
                    <a href="#comments"
                        class="flex items-center space-x-2 px-4 py-2 rounded-xl bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <span class="font-bold">{{ number_format($commentsCount) }}</span>
                    </a>

                    <!-- Partages -->
                    <div class="flex items-center space-x-2 px-4 py-2 rounded-xl bg-green-100 text-green-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                            </path>
                        </svg>
                        <span class="font-bold">{{ number_format($sharesCount) }}</span>
                    </div>
                </div>

                <!-- Bouton Partager -->
                <button wire:click="$set('showShareModal', true)" @click="showShareModal = true"
                    class="flex items-center ml-1 space-x-2 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition shadow-lg hover:shadow-xl transform hover:scale-105 font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                        </path>
                    </svg>
                    <span md:display-none>Share</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Article Body -->
        <article id="content" class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 mb-12 border border-gray-100">
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
                {!! $post->content !!}
            </div>
        </article>

        <!-- Navigation articles précédent/suivant -->
        <div class="grid md:grid-cols-2 gap-6 mb-12">
            @if ($previousPost ?? false)
                <a href="{{ route('blog.show', $previousPost->slug) }}" wire:navigate
                    class="group bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-2xl hover:border-green-200 transition-all transform hover:-translate-y-1">
                    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-3">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span class="font-medium">Article précédent</span>
                    </div>
                    <h3 class="font-bold text-gray-900 group-hover:text-green-600 transition line-clamp-2 text-lg">
                        {{ $previousPost->title }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">{{ $previousPost->reading_time ?? 5 }} min de lecture</p>
                </a>
            @endif

            @if ($nextPost ?? false)
                <a href="{{ route('blog.show', $nextPost->slug) }}" wire:navigate
                    class="group bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-2xl hover:border-green-200 transition-all transform hover:-translate-y-1 {{ !isset($previousPost) ? 'md:col-start-2' : '' }}">
                    <div class="flex items-center justify-end space-x-2 text-sm text-gray-500 mb-3">
                        <span class="font-medium">Article suivant</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                    <h3
                        class="font-bold text-gray-900 text-right group-hover:text-green-600 transition line-clamp-2 text-lg">
                        {{ $nextPost->title }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-2 text-right">{{ $nextPost->reading_time ?? 5 }} min de lecture
                    </p>
                </a>
            @endif
        </div>

        <!-- Articles similaires -->
        @if (isset($relatedPosts) && $relatedPosts->count() > 0)
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 mb-12 border border-gray-100">
                <div class="flex items-center space-x-3 mb-8">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <h3 class="text-3xl font-bold text-gray-900">Articles similaires</h3>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach ($relatedPosts as $related)
                        <a href="{{ route('blog.show', $related->slug) }}" wire:navigate
                            class="group bg-gray-50 rounded-2xl overflow-hidden hover:shadow-xl transition-all">
                            <div class="flex gap-4 p-4">
                                @if ($related->featured_image)
                                    <div class="w-32 h-32 flex-shrink-0 overflow-hidden rounded-xl">
                                        <img src="{{ Storage::url($related->featured_image) }}"
                                            alt="{{ $related->title }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                @else
                                    <div
                                        class="w-32 h-32 flex-shrink-0 rounded-xl bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-white opacity-50" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7.414A2 2 0 0013.414 6L12 4.586A2 2 0 0010.586 4H5a2 2 0 00-2 2v12a2 2 0 002 2h14z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4
                                        class="font-bold text-gray-900 group-hover:text-green-600 transition mb-2 line-clamp-2">
                                        {{ $related->title }}
                                    </h4>
                                    <p class="text-sm text-gray-600 line-clamp-2 mb-2">
                                        {{ $related->excerpt }}
                                    </p>
                                    <div class="flex items-center space-x-3 text-xs text-gray-500">
                                        <span>{{ $related->formatted_published_date ?? $related->published_at->format('d M Y') }}</span>
                                        <span>•</span>
                                        <span>{{ $related->reading_time ?? 5 }} min</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Section commentaires -->
        <div id="comments" class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 border border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-3xl font-bold text-gray-900 flex items-center space-x-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                    <span>Commentaires ({{ number_format($commentsCount) }})</span>
                </h3>
                @if (isset($comments) && $comments->count() > 5)
                    <button wire:click="$toggle('showAllComments')"
                        class="text-sm text-green-600 hover:text-green-700 font-semibold">
                        {{ $showAllComments ?? false ? 'Voir moins' : 'Voir tous les commentaires' }}
                    </button>
                @endif
            </div>

            <!-- Formulaire d'ajout de commentaire -->
            @auth
                <div class="mb-8">
                    <form wire:submit.prevent="addComment">
                        @if ($replyingTo ?? false)
                            <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-xl">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-blue-700 flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                        </svg>
                                        <span>Réponse à un commentaire</span>
                                    </p>
                                    <button type="button" wire:click="cancelReply"
                                        class="text-blue-700 hover:text-blue-900 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-start space-x-4">
                            <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name= ' . urlencode(auth()->user()->name) . '&background=22c55e&color=fff' }}"
                                alt="{{ auth()->user()->name }}"
                                class="w-12 h-12 rounded-full ring-2 ring-green-500 flex-shrink-0">
                            <div class="flex-1">
                                <textarea wire:model="commentContent" placeholder="Partagez votre avis ou posez une question..."
                                    class="w-full
                                    px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent
                                    transition-all resize-none"
                                    rows="3"></textarea>
                                @error('commentContent')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center space-x-2">
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition font-semibold flex items-center space-x-2 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                    @if ($replyingTo ?? false)
                                        <span wire:loading.remove wire:target="addComment">Répondre</span>
                                    @else
                                        <span wire:loading.remove wire:target="addComment">Publier</span>
                                    @endif
                                    <span wire:loading wire:target="addComment">publication...</span>
                                    <svg wire:loading.remove wire:target="addComment" class="w-5 h-5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </button>
                                <button type="button" wire:click="$set('commentContent', '')"
                                    class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                                    Annuler
                                </button>
                            </div>
                            <div class="text-sm text-gray-500">
                                <span x-data="{ count: $wire.commentContent.length }" x-init="$watch('$wire.commentContent', value => count = value.length)" x-text="count"></span>
                                / 500 caractères
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="mb-8 p-8 bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-blue-900 mb-2 text-lg">Connectez-vous pour commenter</h4>
                        <p class="text-blue-700 mb-4">Partagez votre expérience avec la communauté AgroSpace
                        </p>
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center space-x-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition font-semibold shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            <span>Se connecter</span>
                        </a>
                    </div>
                </div>
            @endauth

            <!-- Liste des commentaires -->
            <div class="space-y-6">
                @forelse(($comments ?? collect())->take($showAllComments ?? false ? -1 : 5) as $comment)
                    <div
                        class="flex items-start space-x-4 p-4 {{ $comment->parent_id ? 'ml-8 bg-gray-50 rounded-xl' : 'bg-white' }}">
                        <img src="{{ $comment->user->avatar_url ?? 'https://ui-avatars.com/api/?name= ' . urlencode($comment->user->name) . '&background=22c55e&color=fff' }}"
                            alt="{{ $comment->user->name }}"
                            class="w-10 h-10 rounded-full ring-2 ring-green-500 flex-shrink-0">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="font-bold text-gray-900">{{ $comment->user->name }}</span>
                                @if ($comment->user->is_verified ?? false)
                                    <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                                <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700 mb-3">{{ $comment->content }}</p>
                            <div class="flex items-center space-x-4">
                                @auth
                                    <button wire:click="replyTo({{ $comment->id }})"
                                        class="text-sm text-green-600 hover:text-green-700 font-medium transition">
                                        Répondre
                                    </button>
                                @endauth
                                @if ($comment->replies_count > 0)
                                    <button wire:click="toggleReplies({{ $comment->id }})"
                                        class="text-sm text-gray-600 hover:text-gray-700 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                        <span>{{ $comment->replies_count }}
                                            réponse{{ $comment->replies_count > 1 ? 's' : '' }}</span>
                                    </button>
                                @endif
                            </div>

                            <!-- Réponses -->
                            @if (($showReplies ?? false) && $comment->replies)
                                <div class="mt-4 space-y-4">
                                    @foreach ($comment->replies as $reply)
                                        <div
                                            class="flex items-start space-x-3 p-3 bg-white rounded-xl border border-gray-100">
                                            <img src="{{ $reply->user->avatar_url ?? 'https://ui-avatars.com/api/?name= ' . urlencode($reply->user->name) . '&background=22c55e&color=fff' }}"
                                                alt="{{ $reply->user->name }}"
                                                class="w-8 h-8 rounded-full ring-1 ring-green-500 flex-shrink-0">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2 mb-1">
                                                    <span
                                                        class="font-semibold text-gray-900 text-sm">{{ $reply->user->name }}</span>
                                                    <span
                                                        class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-sm text-gray-700">{{ $reply->content }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <p class="text-gray-500">Aucun commentaire pour le moment. Soyez le premier à commenter !</p>
                    </div>
                @endforelse

                @if (($comments ?? collect())->count() > 5 && !($showAllComments ?? false))
                    <div class="text-center pt-6 border-t border-gray-100">
                        <button wire:click="$set('showAllComments', true)"
                            class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition-all transform hover:scale-105 font-semibold shadow-lg">
                            Voir les {{ $comments->count() - 5 }} commentaires restants
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <x-layouts.footer />

    <!-- Modale Auteur -->
    <div x-show="showAuthorModal" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        @click.away="showAuthorModal = false">

        <div x-show="showAuthorModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-gradient-to-br from-white to-green-50 rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden border border-green-200">

            <!-- Header -->
            <div class="px-8 py-6 border-b border-green-200 bg-gradient-to-r from-green-50 to-green-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">À propos de l'auteur</h2>
                    <button @click="showAuthorModal = false"
                        class="p-2 text-gray-400 hover:text-gray-600 transition-colors rounded-full hover:bg-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Contenu -->
            <div class="p-8 overflow-y-auto max-h-[calc(90vh-120px)]">
                <div class="flex items-center space-x-6 mb-6">
                    <img src="{{ $post->author->avatar_url ?? 'https://ui-avatars.com/api/?name= ' . urlencode($post->author->name) . '&background=22c55e&color=fff' }}"
                        alt="{{ $post->author->name }}"
                        class="w-24 h-24 rounded-full ring-4 ring-green-500 shadow-xl">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $post->author->name }}</h3>
                        <p class="text-green-600 font-semibold">{{ $post->author->role->name ?? 'Producteur' }}</p>
                        @if ($post->author->is_verified ?? false)
                            <div class="flex items-center space-x-1 mt-1">
                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-blue-600 font-medium">Compte vérifié</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="prose prose-green max-w-none">
                    <p class="text-gray-700 mb-4">
                        {{ $post->author->bio ?? 'Passionné par l\'agriculture et la transmission des savoirs.' }}</p>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-green-50 rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $authorPostsCount ?? 0 }}</div>
                            <div class="text-sm text-gray-600">Articles publiés</div>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $authorFollowersCount ?? 0 }}</div>
                            <div class="text-sm text-gray-600">Abonnés</div>
                        </div>
                    </div>

                    {{-- social Links --}}
                    {{-- @if ($post->author->social_links ?? false)
                        <div class="flex space-x-3">
                            @foreach ($post->author->social_links as $platform => $link)
                                <a href="{{ $link }}" target="_blank" rel="noopener noreferrer"
                                    class="w-10 h-10 bg-gray-100 hover:bg-green-500 text-gray-600 hover:text-white rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                                    @if ($platform === 'twitter')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                        </svg>
                                    @elseif($platform === 'linkedin')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                        </svg>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif --}}
                    @php
                        $socials = [
                            'twitter' => 'lien du compte twitter',
                            'linkedin' => 'lien du compte linkedin',
                        ];
                    @endphp
                    @if ($socials)
                        <div class="flex space-x-3">
                            @foreach ($socials as $platform => $link)
                                <a href="{{ $link }}" target="_blank" rel="noopener noreferrer"
                                    class="w-10 h-10 bg-gray-100 hover:bg-green-500 text-gray-600 hover:text-white rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                                    @if ($platform === 'twitter')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                        </svg>
                                    @elseif($platform === 'linkedin')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                        </svg>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modale Partage -->
    <div x-show="showShareModal" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        @click.away="showShareModal = false">

        <div x-show="showShareModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-gradient-to-br from-white to-green-50 rounded-3xl shadow-2xl w-full max-w-lg border border-green-200">

            <!-- Header -->
            <div class="px-8 py-6 border-b border-green-200 bg-gradient-to-r from-green-50 to-green-100 rounded-t-3xl">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">Partager l'article</h2>
                    <button @click="showShareModal = false"
                        class="p-2 text-gray-400 hover:text-gray-600 transition-colors rounded-full hover:bg-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Contenu -->
            <div class="p-8">
                <p class="text-gray-600 mb-6">Partagez cet article avec votre communauté</p>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <button wire:click="share('facebook')"
                        class="flex items-center justify-center space-x-3 p-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all transform hover:scale-105">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        <span class="font-semibold">Facebook</span>
                    </button>

                    <button wire:click="share('twitter')"
                        class="flex items-center justify-center space-x-3 p-4 bg-blue-400 hover:bg-blue-500 text-white rounded-xl transition-all transform hover:scale-105">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                        </svg>
                        <span class="font-semibold">Twitter</span>
                    </button>

                    <button wire:click="share('linkedin')"
                        class="flex items-center justify-center space-x-3 p-4 bg-blue-700 hover:bg-blue-800 text-white rounded-xl transition-all transform hover:scale-105">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                        <span class="font-semibold">LinkedIn</span>
                    </button>

                    <button wire:click="share('whatsapp')"
                        class="flex items-center justify-center space-x-3 p-4 bg-green-500 hover:bg-green-600 text-white rounded-xl transition-all transform hover:scale-105">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0024.003 12.17c0-3.16-1.24-6.132-3.49-8.37z" />
                        </svg>
                        <span class="font-semibold">WhatsApp</span>
                    </button>
                </div>

                <div class="relative">
                    <input type="text" value="{{ url()->current() }}"
                        class="w-full px-4 py-3 pr-12 bg-gray-100 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        readonly>
                    <button onclick="navigator.clipboard.writeText('{{ url()->current() }}')"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2 text-gray-600 hover:text-green-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
