<div>
    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-yellow-50" x-data="{
        liked: {{ $isLiked ? 'true' : 'false' }},
        bookmarked: false,
        showShareMenu: false,
        showReportModal: false,
        readingProgress: 0,
        timeSpent: 0,
        startTime: Date.now(),
        showTableOfContents: false,
        activeSection: '',
    
        init() {
            // Tracker le temps de lecture
            setInterval(() => {
                this.timeSpent = Math.floor((Date.now() - this.startTime) / 1000);
                @this.updateReadingProgress(this.readingProgress, this.timeSpent);
            }, 5000);
    
            // Observer le scroll pour la progression
            this.updateProgress();
            window.addEventListener('scroll', () => {
                this.updateProgress();
                this.highlightActiveSection();
            });
    
            // Générer la table des matières
            this.generateTableOfContents();
        },
    
        updateProgress() {
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            this.readingProgress = Math.min(100, Math.floor((scrollTop / (documentHeight - windowHeight)) * 100));
        },
    
        highlightActiveSection() {
            const sections = document.querySelectorAll('h2[id], h3[id]');
            let current = '';
            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                if (rect.top <= 150) {
                    current = section.id;
                }
            });
            this.activeSection = current;
        },
    
        generateTableOfContents() {
            const content = document.querySelector('#article-content');
            if (!content) return;
    
            const headings = content.querySelectorAll('h2, h3');
            headings.forEach((heading, index) => {
                if (!heading.id) {
                    heading.id = 'section-' + index;
                }
            });
        },
    
        scrollToSection(id) {
            const element = document.getElementById(id);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },
    
        shareOn(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent('{{ $post->title }}');
            let shareUrl = '';
    
            switch (platform) {
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${title}%20${url}`;
                    break;
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                    break;
                case 'email':
                    shareUrl = `mailto:?subject=${title}&body=${url}`;
                    break;
            }
    
            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
                @this.share(platform);
            }
    
            this.showShareMenu = false;
        },
    
        copyLink() {
            navigator.clipboard.writeText(window.location.href);
            @this.share('copy_link');
            this.showShareMenu = false;
    
            // Notification visuelle
            const notification = document.createElement('div');
            notification.className = 'fixed top-24 right-4 bg-green-600 text-white px-6 py-3 rounded-xl shadow-2xl z-50 animate-slideInRight';
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }
    }">
        {{-- Barre de progression de lecture --}}
        <div class="fixed top-0 left-0 h-1 bg-gradient-to-r from-green-500 via-green-600 to-yellow-500 z-50 transition-all duration-300 shadow-lg"
            :style="`width: ${readingProgress}%`"></div>

        {{-- Header sticky avec actions --}}
        <div class="sticky top-0 bg-white/95 backdrop-blur-xl shadow-lg z-40 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    {{-- Navigation --}}
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('blog.index') }}" wire:navigate
                            class="flex items-center space-x-2 text-gray-600 hover:text-green-600 transition group">
                            <div class="p-2 rounded-xl bg-gray-100 group-hover:bg-green-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                            </div>
                            <span class="font-medium hidden md:inline">Retour</span>
                        </a>

                        {{-- Breadcrumb mobile hidden --}}
                        <div class="hidden lg:flex items-center text-sm text-gray-500 space-x-2">
                            <a href="{{ route('blog.index') }}" class="hover:text-green-600 transition">Blog</a>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            @if ($post->category)
                                <a href="{{ route('blog.index', ['category' => $post->category->id]) }}"
                                    class="hover:text-green-600 transition">
                                    {{ $post->category->name }}
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center space-x-2">
                        {{-- Like --}}
                        <button
                            @auth
wire:click="toggleLike"
                            @click="liked = !liked"
                        @else
                            @click="window.location.href='{{ route('login') }}'" @endauth
                            class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all transform hover:scale-105"
                            :class="liked ? 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' :
                                'bg-gray-100 text-gray-700 hover:bg-red-50'">
                            <svg class="w-5 h-5 transition-transform" :class="liked && 'scale-110'"
                                :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                            <span class="font-semibold"
                                x-text="liked ? {{ $likesCount + 1 }} : {{ $likesCount }}"></span>
                        </button>

                        {{-- Commentaires --}}
                        <a href="#comments"
                            class="hidden md:flex items-center space-x-2 px-4 py-2 rounded-xl bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            <span class="font-semibold">{{ number_format($commentsCount) }}</span>
                        </a>

                        {{-- Partager --}}
                        <div class="relative" @click.away="showShareMenu = false">
                            <button @click="showShareMenu = !showShareMenu"
                                class="flex items-center space-x-2 px-4 py-2 rounded-xl bg-gradient-to-r from-green-500 to-green-600 text-white hover:from-green-600 hover:to-green-700 transition shadow-lg hover:shadow-xl transform hover:scale-105">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                    </path>
                                </svg>
                                <span class="font-semibold hidden md:inline">Partager</span>
                            </button>

                            {{-- Menu de partage --}}
                            <div x-show="showShareMenu" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-2xl border border-gray-200 py-3 z-50"
                                style="display: none;">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">Partager cet article</p>
                                </div>

                                <div class="p-2 space-y-1">
                                    <button @click="shareOn('whatsapp')"
                                        class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-green-50 transition group">
                                        <div
                                            class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white group-hover:scale-110 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-700">WhatsApp</span>
                                    </button>

                                    <button @click="shareOn('facebook')"
                                        class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-blue-50 transition group">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white group-hover:scale-110 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-700">Facebook</span>
                                    </button>

                                    <button @click="shareOn('twitter')"
                                        class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-sky-50 transition group">
                                        <div
                                            class="w-10 h-10 rounded-full bg-sky-500 flex items-center justify-center text-white group-hover:scale-110 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-700">Twitter</span>
                                    </button>

                                    <button @click="shareOn('linkedin')"
                                        class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-blue-50 transition group">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-700 flex items-center justify-center text-white group-hover:scale-110 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-700">LinkedIn</span>
                                    </button>

                                    <div class="border-t border-gray-100 my-2"></div>

                                    <button @click="copyLink"
                                        class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition group">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gray-500 flex items-center justify-center text-white group-hover:scale-110 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-700">Copier le lien</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Table des matières (mobile) --}}
                        <button @click="showTableOfContents = !showTableOfContents"
                            class="lg:hidden p-2 rounded-xl bg-gray-100 hover:bg-gray-200 transition">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hero Section avec image de couverture --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-green-900 via-green-800 to-green-900">
            {{-- Image de fond avec overlay --}}
            @if ($post->cover_image)
                <div class="absolute inset-0">
                    <img src="{{ $post->cover_image_url }}" alt="{{ $post->title }}"
                        class="w-full h-full object-cover opacity-30" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent"></div>
                </div>
            @endif

            <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
                {{-- Catégorie --}}
                @if ($post->category)
                    <a href="{{ route('blog.index', ['category' => $post->category_id]) }}" wire:navigate
                        class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white hover:bg-white/30 transition mb-6">
                        <span class="text-2xl">{{ $post->category->icon ?? '📁' }}</span>
                        <span class="font-semibold">{{ $post->category->name }}</span>
                    </a>
                @endif

                {{-- Titre --}}
                <h1 class="text-4xl md:text-6xl font-black text-white mb-6 leading-tight animate-fadeInUp">
                    {{ $post->title }}
                </h1>

                {{-- Sous-titre --}}
                @if ($post->subtitle)
                    <p class="text-xl md:text-2xl text-gray-200 mb-8 max-w-3xl animate-fadeInUp"
                        style="animation-delay: 0.1s">
                        {{ $post->subtitle }}
                    </p>
                @endif

                {{-- Métadonnées --}}
                <div class="flex flex-wrap items-center gap-6 text-gray-200 animate-fadeInUp"
                    style="animation-delay: 0.2s">
                    {{-- Auteur --}}
                    <div class="flex items-center space-x-3">
                        <img src="{{ $post->author->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) . '&background=22c55e&color=fff' }}"
                            alt="{{ $post->author->name }}" class="w-12 h-12 rounded-full ring-4 ring-white/30" />
                        <div>
                            <p class="font-bold text-white">{{ $post->author->name }}</p>
                            <p class="text-sm">{{ $post->published_at->isoFormat('D MMMM YYYY') }}</p>
                        </div>
                    </div>

                    <div class="hidden md:flex items-center space-x-6">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $post->reading_time_text }}</span>
                        </div>
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
                    </div>
                </div>

                {{-- Tags --}}
                @if ($post->tags->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mt-6 animate-fadeInUp" style="animation-delay: 0.3s">
                        @foreach ($post->tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" wire:navigate
                                class="px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white hover:bg-white/30 transition text-sm font-medium">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Contenu principal --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid lg:grid-cols-12 gap-8">

                {{-- Sidebar gauche (Table des matières) --}}
                <aside class="hidden lg:block lg:col-span-3">
                    <div class="sticky top-24 space-y-6">
                        {{-- Table des matières --}}
                        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                            <div class="flex items-center space-x-2 mb-4">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                                <h3 class="font-bold text-gray-900">Sommaire</h3>
                            </div>
                            <nav class="space-y-2" id="table-of-contents">
                                {{-- Généré dynamiquement par Alpine.js --}}
                            </nav>
                        </div>

                        {{-- Stats de l'article --}}
                        <div
                            class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                            <h3 class="font-bold mb-4 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                                <span>Engagement</span>
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-white/80">Vues</span>
                                    <span class="font-bold text-xl">{{ number_format($viewsCount) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-white/80">Likes</span>
                                    <span class="font-bold text-xl">{{ number_format($likesCount) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-white/80">Commentaires</span>
                                    <span class="font-bold text-xl">{{ number_format($commentsCount) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-white/80">Partages</span>
                                    <span class="font-bold text-xl">{{ number_format($sharesCount) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

                {{-- Contenu principal --}}
                <main class="lg:col-span-9 space-y-8">

                    {{-- Corps de l'article --}}
                    <article
                        class="bg-white rounded-2xl shadow-lg p-8 md:p-12 border border-gray-100 animate-fadeInUp">
                        <div id="article-content"
                            class="prose prose-lg prose-green max-w-none
                               prose-headings:font-bold prose-headings:text-gray-900
                               prose-h2:text-3xl prose-h2:mt-12 prose-h2:mb-6 prose-h2:border-l-4 prose-h2:border-green-500 prose-h2:pl-4
                               prose-h3:text-2xl prose-h3:mt-8 prose-h3:mb-4
                               prose-p:text-gray-700 prose-p:leading-relaxed prose-p:mb-4
                               prose-a:text-green-600 prose-a:no-underline hover:prose-a:underline
                               prose-strong:text-gray-900 prose-strong:font-bold
                               prose-ul:my-6 prose-li:my-2
                               prose-img:rounded-2xl prose-img:shadow-xl prose-img:my-8
                               prose-blockquote:border-l-4 prose-blockquote:border-green-500 prose-blockquote:bg-green-50 prose-blockquote:py-4 prose-blockquote:px-6 prose-blockquote:rounded-r-xl prose-blockquote:italic
                               prose-code:bg-gray-100 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:text-sm">
                            {!! $post->content !!}
                        </div>
                    </article>

                    {{-- Actions et stats --}}
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center space-x-4">
                                {{-- Like --}}
                                <button
                                    @auth
wire:click="toggleLike"
                                    @click="liked = !liked"
                                @else
                                    @click="window.location.href='{{ route('login') }}'" @endauth
                                    class="flex items-center space-x-2 px-6 py-3 rounded-xl transition-all transform hover:scale-105"
                                    :class="liked ? 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' :
                                        'bg-gray-100 text-gray-700 hover:bg-red-50'">
                                    <svg class="w-6 h-6" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                    <span class="font-bold"
                                        x-text="liked ? {{ $likesCount + 1 }} : {{ $likesCount }}"></span>
                                </button>

                                {{-- Commentaires --}}
                                <a href="#comments"
                                    class="flex items-center space-x-2 px-6 py-3 rounded-xl bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                    <span class="font-bold">{{ number_format($commentsCount) }}</span>
                                </a>

                                {{-- Partages --}}
                                <button @click="showShareMenu = true"
                                    class="flex items-center space-x-2 px-6 py-3 rounded-xl bg-green-100 text-green-700 hover:bg-green-200 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                        </path>
                                    </svg>
                                    <span class="font-bold">{{ number_format($sharesCount) }}</span>
                                </button>
                            </div>

                            {{-- Bookmark --}}
                            <button @click="bookmarked = !bookmarked" class="p-3 rounded-xl transition-all"
                                :class="bookmarked ? 'bg-yellow-100 text-yellow-700' :
                                    'bg-gray-100 text-gray-700 hover:bg-yellow-50'">
                                <svg class="w-6 h-6" :fill="bookmarked ? 'currentColor' : 'none'"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Navigation articles précédent/suivant --}}
                    <div class="grid md:grid-cols-2 gap-6">
                        @if ($previousPost)
                            <a href="{{ route('blog.show', $previousPost->slug) }}" wire:navigate
                                class="group bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl hover:border-green-200 transition-all">
                                <div class="flex items-center space-x-2 text-sm text-gray-500 mb-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    <span>Article précédent</span>
                                </div>
                                <h3 class="font-bold text-gray-900 group-hover:text-green-600 transition line-clamp-2">
                                    {{ $previousPost->title }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-2">{{ $previousPost->reading_time_text }}</p>
                            </a>
                        @endif

                        @if ($nextPost)
                            <a href="{{ route('blog.show', $nextPost->slug) }}" wire:navigate
                                class="group bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl hover:border-green-200 transition-all {{ !$previousPost ? 'md:col-start-2' : '' }}">
                                <div class="flex items-center justify-end space-x-2 text-sm text-gray-500 mb-3">
                                    <span>Article suivant</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                                <h3
                                    class="font-bold text-gray-900 text-right group-hover:text-green-600 transition line-clamp-2">
                                    {{ $nextPost->title }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-2 text-right">{{ $nextPost->reading_time_text }}
                                </p>
                            </a>
                        @endif
                    </div>

                    {{-- Articles similaires --}}
                    @if ($relatedPosts->isNotEmpty())
                        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                            <div class="flex items-center space-x-3 mb-6">
                                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                <h3 class="text-2xl font-bold text-gray-900">Articles similaires</h3>
                            </div>
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($relatedPosts as $related)
                                    <a href="{{ route('blog.show', $related->slug) }}" wire:navigate class="group">
                                        <div
                                            class="bg-gray-50 rounded-xl overflow-hidden hover:shadow-lg transition-all">
                                            @if ($related->cover_image)
                                                <div class="aspect-video overflow-hidden">
                                                    <img src="{{ $related->cover_image_url }}"
                                                        alt="{{ $related->title }}"
                                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                                </div>
                                            @else
                                                <div
                                                    class="aspect-video bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                                                    <svg class="w-16 h-16 text-white opacity-50" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="p-4">
                                                <h4
                                                    class="font-bold text-gray-900 group-hover:text-green-600 transition line-clamp-2 mb-2">
                                                    {{ $related->title }}
                                                </h4>
                                                <p class="text-sm text-gray-600 line-clamp-2 mb-3">
                                                    {{ $related->excerpt }}
                                                </p>
                                                <div class="flex items-center justify-between text-xs text-gray-500">
                                                    <span>{{ $related->published_at->diffForHumans() }}</span>
                                                    <span>{{ $related->reading_time_text }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Section commentaires --}}
                    <div id="comments" class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-bold text-gray-900 flex items-center space-x-3">
                                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                                <span>Commentaires ({{ number_format($commentsCount) }})</span>
                            </h3>
                            @if ($this->comments->count() > 5)
                                <button wire:click="$toggle('showAllComments')"
                                    class="text-sm text-green-600 hover:text-green-700 font-semibold">
                                    {{ $showAllComments ? 'Voir moins' : 'Voir tous les commentaires' }}
                                </button>
                            @endif
                        </div>

                        {{-- Formulaire d'ajout de commentaire --}}
                        @auth
                            <div class="mb-8">
                                <form wire:submit="addComment">
                                    @if ($replyingTo)
                                        <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-xl">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm text-blue-700 flex items-center space-x-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6">
                                                        </path>
                                                    </svg>
                                                    <span>Réponse à un commentaire</span>
                                                </p>
                                                <button type="button" wire:click="cancelReply"
                                                    class="text-blue-700 hover:text-blue-900">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex items-start space-x-4">
                                        <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=22c55e&color=fff' }}"
                                            alt="{{ auth()->user()->name }}"
                                            class="w-12 h-12 rounded-full ring-2 ring-green-500" />
                                        <div class="flex-1">
                                            <textarea id="comment-input" wire:model="commentContent" placeholder="Partagez votre avis ou posez une question..."
                                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none @error('commentContent') border-red-500 @enderror"
                                                rows="4"></textarea>
                                            @error('commentContent')
                                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                            <div class="flex items-center justify-between mt-4">
                                                <p class="text-sm text-gray-500">
                                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                    Support Markdown activé
                                                </p>
                                                <button type="submit"
                                                    class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition font-semibold flex items-center space-x-2 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                                                    wire:loading.attr="disabled">
                                                    <span wire:loading.remove wire:target="addComment">Publier</span>
                                                    <span wire:loading wire:target="addComment">Publication...</span>
                                                    <svg wire:loading.remove wire:target="addComment" class="w-5 h-5"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div
                                class="mb-8 p-8 bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
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

                        {{-- Liste des commentaires --}}
                        @if ($this->comments->isEmpty())
                            <div class="text-center py-12">
                                <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-700 mb-2">Aucun commentaire pour le moment
                                </h4>
                                <p class="text-gray-500">Soyez le premier à partager votre avis !</p>
                            </div>
                        @else
                            {{-- <div class="space-y-6">
                            @foreach ($this->comments as $comment)
                                @include('livewire.blog.partials.comment-item', ['comment' => $comment, 'level' => 0])
                            @endforeach
                        </div> --}}
                        @endif
                    </div>

                </main>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                }

                to {
                    transform: translateX(0);
                }
            }

            .animate-fadeInUp {
                animation: fadeInUp 0.8s ease-out forwards;
                opacity: 0;
            }

            .animate-slideInRight {
                animation: slideInRight 0.3s ease-out;
            }

            /* Smooth scroll */
            html {
                scroll-behavior: smooth;
            }

            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 10px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
                background: #22c55e;
                border-radius: 5px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #16a34a;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Générer automatiquement la table des matières
                const content = document.getElementById('article-content');
                const toc = document.getElementById('table-of-contents');

                if (content && toc) {
                    const headings = content.querySelectorAll('h2, h3');
                    headings.forEach((heading, index) => {
                        if (!heading.id) {
                            heading.id = 'section-' + index;
                        }

                        const link = document.createElement('a');
                        link.href = '#' + heading.id;
                        link.textContent = heading.textContent;
                        link.className = heading.tagName === 'H2' ?
                            'block text-sm font-medium text-gray-700 hover:text-green-600 py-2 border-l-2 border-transparent hover:border-green-500 pl-3 transition' :
                            'block text-sm text-gray-600 hover:text-green-600 py-2 pl-6 transition';

                        toc.appendChild(link);
                    });
                }

                // Focus automatique sur le champ de commentaire lors d'une réponse
                window.addEventListener('focusCommentInput', () => {
                    setTimeout(() => {
                        document.getElementById('comment-input')?.focus();
                    }, 100);
                });
            });
        </script>
    @endpush
</div>
