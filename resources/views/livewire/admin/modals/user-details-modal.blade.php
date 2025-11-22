<div>
    {{-- resources/views/livewire/admin/modals/user-details-modal.blade.php --}}
    <div x-data="{ show: @entangle('show'), activeTab: 'info' }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        {{-- Overlay --}}
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="$wire.close()"></div>

        {{-- Modal --}}
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl transform transition-all max-h-[90vh] overflow-hidden flex flex-col"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                @if ($user)
                    {{-- Header avec cover --}}
                    <div class="bg-gradient-to-r from-green-600 via-emerald-500 to-green-600 h-32 relative">
                        <button @click="$wire.close()"
                            class="absolute top-4 right-4 text-white hover:bg-white/20 rounded-lg p-2 transition z-10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        {{-- Profile Info --}}
                        <div class="absolute -bottom-16 left-6 flex items-end gap-4">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                class="w-32 h-32 rounded-2xl ring-4 ring-white shadow-xl object-cover">
                            <div class="pb-2">
                                <div class="flex items-center gap-2 mb-1">
                                    <h2 class="text-2xl font-bold text-white drop-shadow-lg">{{ $user->name }}</h2>
                                    @if ($user->verified)
                                        <svg class="w-6 h-6 text-blue-400 drop-shadow" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                @php
                                    $roleBadge = $user->getRoleBadge();
                                    $statusBadge = $user->getStatusBadge();
                                @endphp
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-3 py-1 {{ $roleBadge['class'] }} rounded-full text-xs font-semibold shadow">
                                        {{ $roleBadge['label'] }}
                                    </span>
                                    <span
                                        class="px-3 py-1 {{ $statusBadge['class'] }} rounded-full text-xs font-semibold shadow">
                                        {{ $statusBadge['label'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tabs --}}
                    <div class="mt-20 px-6 border-b border-gray-200 bg-white">
                        <div class="flex gap-6">
                            <button @click="activeTab = 'info'"
                                :class="activeTab === 'info' ? 'border-green-600 text-green-600' :
                                    'border-transparent text-gray-500 hover:text-gray-700'"
                                class="pb-4 border-b-2 font-semibold text-sm transition flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Informations
                            </button>
                            <button @click="activeTab = 'activity'"
                                :class="activeTab === 'activity' ? 'border-green-600 text-green-600' :
                                    'border-transparent text-gray-500 hover:text-gray-700'"
                                class="pb-4 border-b-2 font-semibold text-sm transition flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                                Activité
                            </button>
                            <button @click="activeTab = 'history'"
                                :class="activeTab === 'history' ? 'border-green-600 text-green-600' :
                                    'border-transparent text-gray-500 hover:text-gray-700'"
                                class="pb-4 border-b-2 font-semibold text-sm transition flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Historique
                            </button>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 overflow-y-auto p-6 bg-gray-50">

                        {{-- Tab: Informations --}}
                        <div x-show="activeTab === 'info'" class="space-y-6" x-transition>

                            {{-- Contact Info --}}
                            <div
                                class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Coordonnées
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="flex items-center gap-3 bg-white p-4 rounded-lg shadow-sm">
                                        <div
                                            class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs text-gray-500 font-medium">Email</p>
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $user->email }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 bg-white p-4 rounded-lg shadow-sm">
                                        <div
                                            class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs text-gray-500 font-medium">Téléphone</p>
                                            <p class="text-sm font-semibold text-gray-900">
                                                {{ $user->phone ?? 'Non renseigné' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Location Info --}}
                            <div
                                class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Localisation
                                </h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                        <p class="text-xs text-gray-500 mb-1 font-medium">Région</p>
                                        <p class="text-lg font-bold text-gray-900">
                                            {{ $user->region ?? 'Non renseignée' }}</p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                        <p class="text-xs text-gray-500 mb-1 font-medium">Ville</p>
                                        <p class="text-lg font-bold text-gray-900">
                                            {{ $user->city ?? 'Non renseignée' }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Bio --}}
                            @if ($user->bio)
                                <div
                                    class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
                                    <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        Biographie
                                    </h3>
                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                        <p class="text-gray-700 leading-relaxed">{{ $user->bio }}</p>
                                    </div>
                                </div>
                            @endif

                            {{-- Account Details --}}
                            <div
                                class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Détails du compte
                                </h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                        <p class="text-xs text-gray-500 font-medium">Inscrit le</p>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $user->created_at->format('d/m/Y') }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                        <p class="text-xs text-gray-500 font-medium">Dernière activité</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $user->last_active }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab: Activity --}}
                        <div x-show="activeTab === 'activity'" class="space-y-6" x-transition>

                            {{-- Stats Cards --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div
                                    class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-4xl">📦</span>
                                        <span
                                            class="text-3xl font-bold text-green-600">{{ $user->offers_count ?? 0 }}</span>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-700">Offres publiées</p>
                                    <p class="text-xs text-gray-500">Total des annonces</p>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-4xl">📋</span>
                                        <span
                                            class="text-3xl font-bold text-blue-600">{{ $user->demands_count ?? 0 }}</span>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-700">Demandes créées</p>
                                    <p class="text-xs text-gray-500">Recherches actives</p>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-4xl">💬</span>
                                        <span
                                            class="text-3xl font-bold text-purple-600">{{ $user->messages_count ?? 0 }}</span>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-700">Messages échangés</p>
                                    <p class="text-xs text-gray-500">Conversations</p>
                                </div>
                            </div>

                            {{-- Recent Offers/Demands --}}
                            @if ($user->isProducer() && $user->offers && $user->offers->count() > 0)
                                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                            </path>
                                        </svg>
                                        Offres récentes
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach ($user->offers->take(5) as $offer)
                                            <div
                                                class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                                @if ($offer->image)
                                                    <img src="{{ $offer->image_url }}"
                                                        class="w-14 h-14 rounded-lg object-cover"
                                                        alt="{{ $offer->title }}">
                                                @else
                                                    <div
                                                        class="w-14 h-14 rounded-lg bg-green-100 flex items-center justify-center">
                                                        <span class="text-2xl">📦</span>
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-semibold text-gray-900 text-sm truncate">
                                                        {{ $offer->title }}</p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $offer->created_at->format('d/m/Y') }} •
                                                        {{ $offer->category->name ?? 'Non renseigné' }}
                                                </div>
                                                <div class="text-right">
                                                    <span
                                                        class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                                        {{ number_format($offer->price, 0, ',', ' ') }} FCFA
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @elseif($user->isConsumer() && $user->demands && $user->demands->count() > 0)
                                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg>
                                        Demandes récentes
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach ($user->demands->take(5) as $demand)
                                            <div
                                                class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                                <div
                                                    class="w-14 h-14 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                                                    <span class="text-2xl">📋</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-semibold text-gray-900 text-sm truncate">
                                                        {{ $demand->title }}</p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $demand->created_at->format('d/m/Y') }} •
                                                        {{ $demand->category->name ?? 'Non renseigné' }}
                                                </div>
                                                <div class="text-right">
                                                    <span
                                                        class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                                        {{ $demand->status }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="bg-white rounded-xl p-12 border border-gray-200 text-center">
                                    <div
                                        class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-600 font-medium">Aucune activité pour le moment</p>
                                    <p class="text-sm text-gray-400 mt-1">L'utilisateur n'a pas encore publié d'offres
                                        ou de demandes</p>
                                </div>
                            @endif
                        </div>

                        {{-- Tab: History --}}
                        <div x-show="activeTab === 'history'" class="space-y-4" x-transition>
                            <div class="bg-white rounded-xl p-12 border border-gray-200 text-center">
                                <div
                                    class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-lg font-semibold text-gray-600 mb-2">Historique des actions</p>
                                <p class="text-sm text-gray-400">Cette fonctionnalité sera disponible prochainement</p>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Actions --}}
                    <div class="border-t border-gray-200 px-6 py-4 bg-white">
                        <div class="flex items-center justify-between">
                            <div class="flex gap-2">
                                <button wire:click="sendEmail"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2 font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Envoyer un email
                                </button>

                                <button wire:click="editUser"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center gap-2 font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    Modifier
                                </button>
                            </div>

                            <button @click="$wire.close()"
                                class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                                Fermer
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
