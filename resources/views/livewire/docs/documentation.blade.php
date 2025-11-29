<?php

use Livewire\Volt\Component;

new #[Layout('layouts.main')] class extends Component {
    public $activeTab = 0;

    public $docs = [];

    public function mount()
    {
        $this->docs = [
            [
                'title' => 'Installation & Prérequis',
                'description' => 'Découvrez comment installer AgroSpace sur votre serveur en quelques minutes.',
                'videos' => ['https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
                'content' => '
                    <h2>Étape 1 : Cloner le projet</h2>
                    <pre><code>git clone https://github.com/votre-repo/agrospace.git
cd agrospace</code></pre>

                    <h2>Étape 2 : Installer les dépendances</h2>
                    <pre><code>composer install
npm install && npm run build</code></pre>

                    <h2>Étape 3 : Configuration</h2>
                    <p>Copiez le fichier <code>.env.example</code> vers <code>.env</code>.</p>
                ',
                'images' => [],
            ],

            [
                'title' => 'Configuration de la base de données',
                'description' => 'Paramétrez votre connexion MySQL/PostgreSQL et lancez les migrations.',
                'videos' => [],
                'content' => '
                    <h2>Configuration du fichier .env</h2>
                    <pre><code>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agrospace
DB_USERNAME=root
DB_PASSWORD=</code></pre>

                    <h2>Lancer les migrations</h2>
                    <pre><code>php artisan migrate --seed</code></pre>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 my-4">
                        <p class="text-blue-700"><strong>💡 Astuce :</strong> Utilisez --seed pour les données de test.</p>
                    </div>
                ',
                'images' => [],
            ],

            [
                'title' => 'Gestion des cultures',
                'description' => 'Apprenez à créer, modifier et suivre vos parcelles agricoles.',
                'videos' => ['https://www.youtube.com/watch?v=exemple1'],
                'content' => '
                    <h2>Créer une nouvelle culture</h2>
                    <p>Rendez-vous dans Cultures > Nouvelle culture</p>
                    <ol>
                        <li>Sélectionnez le type de culture</li>
                        <li>Définissez la superficie</li>
                        <li>Choisissez la date de semis</li>
                    </ol>
                ',
                'images' => [],
            ],

            [
                'title' => 'Irrigation intelligente',
                'description' => 'Optimisez votre consommation d\'eau avec nos systèmes IoT.',
                'videos' => [],
                'content' => '
                    <h2>Capteurs IoT</h2>
                    <p>Connectez vos capteurs d\'humidité du sol via l\'interface IoT.</p>
                ',
                'images' => [],
            ],

            [
                'title' => 'Rapports & Analytics',
                'description' => 'KPIs, rendements, comparaisons saisonnières.',
                'videos' => [],
                'content' => '
                    <h2>Tableau de bord Analytics</h2>
                    <ul>
                        <li>Rendement par hectare</li>
                        <li>Coûts de production</li>
                        <li>Comparaisons saisonnières</li>
                    </ul>
                ',
                'images' => [],
            ],

            /**
             * NOUVELLE SECTION DOCUMENTATION : USER MANAGEMENT
             */
            [
                'title' => 'Gestion des utilisateurs (User Management)',
                'description' => 'Découvrez comment gérer les comptes, permissions et rôles.',
                'videos' => ['https://www.youtube.com/watch?v=exemple-users'],
                'content' => '
                    <h2>Introduction</h2>
                    <p>Le module User Management vous permet de gérer les utilisateurs, les rôles et les permissions du système.</p>

                    <h2>Fonctionnalités principales</h2>
                    <ul>
                        <li>Créer des utilisateurs</li>
                        <li>Assigner des rôles</li>
                        <li>Activer / Désactiver un compte</li>
                        <li>Réinitialisation de mot de passe</li>
                        <li>Historique des connexions</li>
                        <li>Permissions avancées</li>
                    </ul>

                    <h2>Créer un utilisateur</h2>
                    <pre><code>php artisan make:user --name="Jean Dupont"</code></pre>

                    <h2>Exemple workflow</h2>
                    <ol>
                        <li>Admin ouvre "User Management"</li>
                        <li>Choisit "Créer un utilisateur"</li>
                        <li>Remplit nom, email, rôle</li>
                        <li>Valide → Envoi email d\'activation</li>
                    </ol>

                    <h2>Sécurité</h2>
                    <div class="bg-red-50 border-l-4 border-red-500 p-4">
                        <p><strong>Important :</strong> Les permissions doivent être gérées via Spatie Permissions pour garantir un contrôle robuste.</p>
                    </div>
                ',
                'images' => [],
            ],
        ];
    }

    public function setTab($index)
    {
        $this->activeTab = $index;
    }
}; ?>

<div>

    <style>
        /* Animation de fade */
        .fade-enter {
            opacity: 0;
            transform: translateY(10px);
        }

        .fade-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        /* Style pour les vidéos responsive */
        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 */
            height: 0;
            overflow: hidden;
        }

        .video-container iframe,
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 0.75rem;
        }
    </style>

    <div class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen antialiased" x-data="{
        activeSection: 0,
        sections: {{ count($docs ?? []) }},
        goToSection(index) {
            if (index >= 0 && index < this.sections) {
                this.activeSection = index;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },
        nextSection() {
            if (this.activeSection < this.sections - 1) {
                this.activeSection++;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },
        prevSection() {
            if (this.activeSection > 0) {
                this.activeSection--;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    }">

        {{-- Header --}}
        <header class="bg-white border-b border-slate-200 sticky top-0 z-40 backdrop-blur-sm bg-white/90">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    {{-- Logo & Title --}}
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-slate-900">AgroSpace</h1>
                            <p class="text-xs text-slate-500">Documentation</p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center space-x-4">
                        <a href="{{ url('/') }}" wire:navigate
                            class="text-sm text-slate-600 hover:text-slate-900 transition-colors">
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">

                {{-- SIDEBAR - Navigation verticale --}}
                <aside class="lg:w-80 flex-shrink-0">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                        {{-- Titre sidebar --}}
                        <div class="p-6 border-b border-slate-200 bg-gradient-to-r from-primary-50 to-emerald-50">
                            <h2 class="text-lg font-semibold text-slate-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                Table des matières
                            </h2>
                        </div>

                        {{-- Navigation tabs --}}
                        <nav class="p-4 max-h-[calc(100vh-16rem)] overflow-y-auto">
                            <ul class="space-y-2">
                                @foreach ($docs ?? [] as $index => $doc)
                                    <li>
                                        <button @click="goToSection({{ $index }})"
                                            :class="activeSection === {{ $index }} ?
                                                'bg-primary-50 text-primary-700 border-primary-200 shadow-sm' :
                                                'text-slate-700 hover:bg-slate-50 border-transparent'"
                                            class="w-full text-left px-4 py-3 rounded-xl border-2 transition-all duration-200 group">
                                            <div class="flex items-start space-x-3">
                                                {{-- Icône ou numéro --}}
                                                <div :class="activeSection === {{ $index }} ?
                                                    'bg-primary-600 text-white' :
                                                    'bg-slate-200 text-slate-600 group-hover:bg-slate-300'"
                                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-semibold flex-shrink-0 transition-colors">
                                                    {{ $index + 1 }}
                                                </div>

                                                <div class="flex-1 min-w-0">
                                                    <p class="font-medium text-sm truncate">
                                                        {{ $doc['title'] ?? 'Section ' . ($index + 1) }}
                                                    </p>
                                                    @if (!empty($doc['description']))
                                                        <p class="text-xs mt-0.5 opacity-75 line-clamp-2">
                                                            {{ Str::limit($doc['description'], 60) }}
                                                        </p>
                                                    @endif
                                                </div>

                                                {{-- Indicateur actif --}}
                                                <svg x-show="activeSection === {{ $index }}"
                                                    class="w-5 h-5 text-primary-600 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>

                        {{-- Progress indicator --}}
                        <div class="p-4 border-t border-slate-200 bg-slate-50">
                            <div class="flex items-center justify-between text-xs text-slate-600 mb-2">
                                <span>Progression</span>
                                <span x-text="`${activeSection + 1} / ${sections}`"></span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-primary-500 to-emerald-500 h-2 rounded-full transition-all duration-300"
                                    :style="`width: ${((activeSection + 1) / sections) * 100}%`"></div>
                            </div>
                        </div>
                    </div>
                </aside>

                {{-- CONTENU PRINCIPAL --}}
                <main class="flex-1 min-w-0">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                        {{-- Contenu des sections --}}
                        <div class="p-8 lg:p-12">
                            @foreach ($docs ?? [] as $index => $doc)
                                <article x-show="activeSection === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform translate-y-4"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    class="prose prose-slate max-w-none">

                                    {{-- En-tête de section --}}
                                    <div class="not-prose mb-8">
                                        <div class="flex items-center space-x-3 mb-4">
                                            <span
                                                class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-emerald-500 text-white font-bold text-lg shadow-lg shadow-primary-500/30">
                                                {{ $index + 1 }}
                                            </span>
                                            <div>
                                                <h1 class="text-3xl lg:text-4xl font-bold text-slate-900 m-0">
                                                    {{ $doc['title'] ?? 'Section ' . ($index + 1) }}
                                                </h1>
                                            </div>
                                        </div>

                                        @if (!empty($doc['description']))
                                            <p class="text-lg text-slate-600 leading-relaxed">
                                                {{ $doc['description'] }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Vidéos --}}
                                    @if (!empty($doc['videos']) && is_array($doc['videos']))
                                        <div class="not-prose mb-8 space-y-6">
                                            @foreach ($doc['videos'] as $videoIndex => $video)
                                                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200">
                                                    <div class="flex items-center mb-4">
                                                        <svg class="w-5 h-5 text-primary-600 mr-2" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                            </path>
                                                        </svg>
                                                        <h3 class="text-sm font-semibold text-slate-700">
                                                            Vidéo
                                                            {{ count($doc['videos']) > 1 ? $videoIndex + 1 : '' }}
                                                        </h3>
                                                    </div>

                                                    <div class="video-container shadow-xl">
                                                        @if (Str::contains($video, ['youtube.com', 'youtu.be']))
                                                            {{-- YouTube embed --}}
                                                            @php
                                                                $videoId = null;
                                                                if (
                                                                    preg_match(
                                                                        '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/',
                                                                        $video,
                                                                        $matches,
                                                                    )
                                                                ) {
                                                                    $videoId = $matches[1];
                                                                }
                                                            @endphp
                                                            @if ($videoId)
                                                                <iframe
                                                                    src="https://www.youtube.com/embed/{{ $videoId }}"
                                                                    frameborder="0"
                                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                    allowfullscreen>
                                                                </iframe>
                                                            @endif
                                                        @elseif(Str::endsWith($video, ['.mp4', '.webm', '.ogg']))
                                                            {{-- Video HTML5 --}}
                                                            <video controls class="rounded-xl">
                                                                <source src="{{ $video }}"
                                                                    type="video/{{ pathinfo($video, PATHINFO_EXTENSION) }}">
                                                                Votre navigateur ne supporte pas la lecture de vidéos.
                                                            </video>
                                                        @else
                                                            {{-- Iframe générique --}}
                                                            <iframe src="{{ $video }}" frameborder="0"
                                                                allowfullscreen></iframe>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Contenu textuel / HTML --}}
                                    @if (!empty($doc['content']))
                                        <div class="prose-content">
                                            @if (is_string($doc['content']))
                                                {!! $doc['content'] !!}
                                            @else
                                                {{ $doc['content'] }}
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Images additionnelles --}}
                                    @if (!empty($doc['images']) && is_array($doc['images']))
                                        <div class="not-prose mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                                            @foreach ($doc['images'] as $image)
                                                <div
                                                    class="group relative overflow-hidden rounded-xl border-2 border-slate-200 hover:border-primary-300 transition-all duration-300">
                                                    <img src="{{ $image }}" alt="Image documentation"
                                                        class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-300">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                </article>
                            @endforeach
                        </div>

                        {{-- Navigation Précédent / Suivant --}}
                        <div class="px-8 lg:px-12 py-6 bg-slate-50 border-t border-slate-200">
                            <div class="flex items-center justify-between">
                                {{-- Bouton Précédent --}}
                                <button @click="prevSection()" :disabled="activeSection === 0"
                                    :class="activeSection === 0 ?
                                        'opacity-40 cursor-not-allowed' :
                                        'hover:bg-slate-100 hover:border-slate-300 hover:shadow-md'"
                                    class="group flex items-center space-x-2 px-6 py-3 bg-white border-2 border-slate-200 rounded-xl transition-all duration-200">
                                    <svg class="w-5 h-5 text-slate-600 group-hover:text-slate-900 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    <span
                                        class="font-medium text-slate-700 group-hover:text-slate-900 transition-colors">
                                        Précédent
                                    </span>
                                </button>

                                {{-- Indicateur position --}}
                                <div class="hidden sm:flex items-center space-x-2 text-sm text-slate-500">
                                    <span x-text="activeSection + 1"></span>
                                    <span>/</span>
                                    <span x-text="sections"></span>
                                </div>

                                {{-- Bouton Suivant --}}
                                <button @click="nextSection()" :disabled="activeSection === sections - 1"
                                    :class="activeSection === sections - 1 ?
                                        'opacity-40 cursor-not-allowed' :
                                        'hover:bg-primary-600 hover:shadow-lg hover:shadow-primary-500/30'"
                                    class="group flex items-center space-x-2 px-6 py-3 bg-primary-500 text-white rounded-xl transition-all duration-200">
                                    <span class="font-medium">
                                        Suivant
                                    </span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Footer info --}}
                    <div class="mt-6 px-4 text-center">
                        <p class="text-sm text-slate-500">
                            © {{ date('Y') }} AgroSpace. Documentation générée automatiquement.
                        </p>
                    </div>
                </main>

            </div>
        </div>

    </div>

</div>
