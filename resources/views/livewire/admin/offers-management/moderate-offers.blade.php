<div>
    <div class="min-h-screen bg-gradient-to-br from-primary-50 via-white to-earth-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Modération des Offres</h1>
                        <p class="mt-2 text-sm text-gray-600">Validez, rejetez ou gérez les offres publiées sur la
                            plateforme</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex space-x-3">
                        <button wire:click="bulkValidate"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-xl hover:from-green-700 hover:to-green-800 shadow-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Validation en masse
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-gray-600">Total</span>
                        <div class="bg-gray-100 rounded-lg p-2">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border border-orange-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-orange-600">En attente</span>
                        <div class="bg-orange-100 rounded-lg p-2">
                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-orange-600">{{ $stats['pending'] }}</p>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border border-green-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-green-600">Validées</span>
                        <div class="bg-green-100 rounded-lg p-2">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['validated'] }}</p>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border border-red-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-red-600">Rejetées</span>
                        <div class="bg-red-100 rounded-lg p-2">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border border-purple-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-purple-600">Suspendues</span>
                        <div class="bg-purple-100 rounded-lg p-2">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['suspended'] }}</p>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border border-yellow-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-yellow-600">En vedette</span>
                        <div class="bg-yellow-100 rounded-lg p-2">
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['featured'] }}</p>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-blue-600">Aujourd'hui</span>
                        <div class="bg-blue-100 rounded-lg p-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['today'] }}</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-7 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Rechercher une offre..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>

                    <div>
                        <select wire:model.live="statusFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="all">Tous statuts</option>
                            <option value="pending">⏳ En attente</option>
                            <option value="validé">✅ Validées</option>
                            <option value="rejeté">❌ Rejetées</option>
                            <option value="suspendue">🚫 Suspendues</option>
                            <option value="active">🟢 Actives</option>
                            <option value="expirée">⏰ Expirées</option>
                            <option value="vendue">⏰ Vendues</option>
                        </select>
                    </div>

                    <div>
                        <select wire:model.live="categorieFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">Toutes catégories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select wire:model.live="regionFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">Toutes régions</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region }}">{{ $region }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select wire:model.live="verifiedFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="all">Toutes</option>
                            <option value="verified">✓ Vérifiées</option>
                            <option value="unverified">⏳ Non vérifiées</option>
                        </select>
                    </div>

                    <div>
                        <select wire:model.live="sortBy"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="latest">Plus récentes</option>
                            <option value="oldest">Plus anciennes</option>
                            <option value="most_viewed">Plus vues</option>
                            <option value="most_contacted">Plus contactées</option>
                            <option value="price_high">Prix décroissant</option>
                            <option value="price_low">Prix croissant</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Offers Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-primary-50 to-earth-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Offre</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Producteur</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Prix & Qté</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Localisation</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Stats</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Statut</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($offers as $offer)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-start space-x-3">
                                            @if ($offer->photos->first())
                                                <img src="{{ $offer->photos->first()->url }}"
                                                    class="w-16 h-16 rounded-lg object-cover flex-shrink-0"
                                                    alt="{{ $offer->titre }}">
                                            @else
                                                <div
                                                    class="w-16 h-16 bg-gradient-to-br from-primary-100 to-earth-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-8 h-8 text-primary-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 truncate">
                                                    {{ $offer->titre }}</p>
                                                <p class="text-xs text-gray-500 line-clamp-2 mt-1">
                                                    {{ $offer->description }}</p>
                                                <div class="flex items-center space-x-2 mt-2">
                                                    <span
                                                        class="px-2 py-1 bg-primary-100 text-primary-700 rounded text-xs font-medium">
                                                        {{ $offer->categorie }}
                                                    </span>
                                                    @if ($offer->is_featured)
                                                        <span
                                                            class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-medium flex items-center">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                                </path>
                                                            </svg>
                                                            Vedette
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($offer->producer->name) }}&background=random"
                                                class="w-8 h-8 rounded-full" alt="{{ $offer->producer->name }}">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $offer->producer->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $offer->producer->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <p class="font-bold text-primary-600">
                                                {{ number_format($offer->prix, 0, ',', ' ') }} FCFA</p>
                                            <p class="text-gray-500 text-xs mt-1">{{ $offer->quantite }}
                                                {{ $offer->unite }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $offer->ville }}</div>
                                        <div class="text-xs text-gray-500">{{ $offer->region }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-gray-600 space-y-1">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                {{ $offer->views_count }} vues
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                {{ $offer->contacts_count }} contacts
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusConfig = [
                                                'en attente' => [
                                                    'bg' => 'bg-orange-100',
                                                    'text' => 'text-orange-700',
                                                    'icon' => '⏳',
                                                ],
                                                'validé' => [
                                                    'bg' => 'bg-green-100',
                                                    'text' => 'text-green-700',
                                                    'icon' => '✅',
                                                ],
                                                'rejeté' => [
                                                    'bg' => 'bg-red-100',
                                                    'text' => 'text-red-700',
                                                    'icon' => '❌',
                                                ],
                                                'suspendu' => [
                                                    'bg' => 'bg-purple-100',
                                                    'text' => 'text-purple-700',
                                                    'icon' => '🚫',
                                                ],
                                                'actif' => [
                                                    'bg' => 'bg-blue-100',
                                                    'text' => 'text-blue-700',
                                                    'icon' => '🟢',
                                                ],
                                                'expiré' => [
                                                    'bg' => 'bg-gray-100',
                                                    'text' => 'text-gray-700',
                                                    'icon' => '⏰',
                                                ],
                                            ];
                                            $config = $statusConfig[$offer->statut] ?? [
                                                'bg' => 'bg-gray-100',
                                                'text' => 'text-gray-700',
                                                'icon' => '',
                                            ];
                                        @endphp
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }} inline-block">
                                            {{ $config['icon'] }} {{ ucfirst($offer->statut) }}
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $offer->date_publication->format('d/m/Y') }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <button wire:click="viewDetails({{ $offer->id }})"
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                                title="Voir détails">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </button>

                                            @if ($offer->statut === 'en attente')
                                                <button wire:click="openValidateModal({{ $offer->id }})"
                                                    class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                                                    title="Valider">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </button>

                                                <button wire:click="openRejectModal({{ $offer->id }})"
                                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                    title="Rejeter">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            @endif

                                            <button wire:click="toggleFeatured({{ $offer->id }})"
                                                class="p-2 {{ $offer->is_featured ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg transition"
                                                title="{{ $offer->is_featured ? 'Retirer de la vedette' : 'Mettre en vedette' }}">
                                                <svg class="w-5 h-5"
                                                    fill="{{ $offer->is_featured ? 'currentColor' : 'none' }}"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <div x-data="{ open: false }" class="relative" x-cloak>
                                                <button @click="open = !open"
                                                    class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition"
                                                    title="Plus d'actions">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                        </path>
                                                    </svg>
                                                </button>

                                                <div x-show="open" @click.away="open = false" x-transition
                                                    class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 z-10 py-2">
                                                    <button wire:click="updateStatus({{ $offer->id }}, 'active')"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-green-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                            </path>
                                                        </svg>
                                                        Marquer active
                                                    </button>

                                                    <button wire:click="updateStatus({{ $offer->id }}, 'suspendue')"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-purple-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                            </path>
                                                        </svg>
                                                        Suspendre
                                                    </button>
                                                    <button wire:click="suspendProducer({{ $offer->producer_id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-orange-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                            </path>
                                                        </svg>
                                                        Suspendre producteur
                                                    </button>
                                                    <hr class="my-2">
                                                    <button wire:click="confirmDelete({{ $offer->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                                        <svg class="w-4 h-4 mr-2" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                        Supprimer définitivement
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                            </path>
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune offre trouvée</h3>
                                        <p class="text-gray-600">Essayez de modifier vos critères de recherche</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $offers->links() }}
            </div>
        </div>

        <!-- Validate Modal -->
        @if ($showValidateModal)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showValidateModal') }" x-cloak>
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                        class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">

                        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Valider cette offre</h3>
                        <p class="text-gray-600 text-center mb-6">Confirmez que cette offre est légitime et conforme
                            aux règles de la plateforme.</p>

                        <form wire:submit.prevent="validateOffer" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Note de validation
                                    (optionnelle)</label>
                                <textarea wire:model="validationNote" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="Ajoutez une note interne pour l'équipe..."></textarea>
                            </div>

                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-green-800">
                                        Le producteur recevra une notification confirmant la validation de son offre.
                                    </p>
                                </div>
                            </div>

                            <div class="flex space-x-3">
                                <button type="button" wire:click="$set('showValidateModal', false)"
                                    class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                                    Annuler
                                </button>
                                <button type="submit"
                                    class="flex-1 px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-green-800 transition">
                                    ✓ Valider l'offre
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Reject Modal -->
        @if ($showRejectModal)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showRejectModal') }" x-cloak>
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                        class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">

                        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Rejeter cette offre</h3>
                        <p class="text-gray-600 text-center mb-6">Veuillez indiquer la raison du rejet pour informer le
                            producteur.</p>

                        <form wire:submit.prevent="rejectOffer" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Raison du rejet *</label>
                                <textarea wire:model="rejectionReason" rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="Ex: Contenu inapproprié, informations incomplètes, prix anormalement bas, photos non conformes..."></textarea>
                                @error('rejectionReason')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-red-600 mr-2 flex-shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    <p class="text-sm text-red-800">
                                        Le producteur sera notifié du rejet avec la raison que vous avez indiquée.
                                    </p>
                                </div>
                            </div>

                            <div class="flex space-x-3">
                                <button type="button" wire:click="$set('showRejectModal', false)"
                                    class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                                    Annuler
                                </button>
                                <button type="submit"
                                    class="flex-1 px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold rounded-lg hover:from-red-700 hover:to-red-800 transition">
                                    ✗ Rejeter l'offre
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Delete Modal -->
        @if ($showDeleteModal)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showDeleteModal') }" x-cloak>
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                        class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">

                        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Supprimer définitivement</h3>
                        <p class="text-gray-600 text-center mb-6">Êtes-vous sûr de vouloir supprimer cette offre ?
                            Cette action est irréversible et supprimera également toutes les photos associées.</p>

                        <div class="flex space-x-3">
                            <button wire:click="$set('showDeleteModal', false)"
                                class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                                Annuler
                            </button>
                            <button wire:click="deleteOffer"
                                class="flex-1 px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Details Modal -->
        @if ($showDetailsModal && $selectedOffer)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showDetailsModal') }" x-cloak>
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                        class="inline-block w-full max-w-5xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl max-h-[90vh] overflow-y-auto">

                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">Détails de l'offre</h3>
                            <button wire:click="$set('showDetailsModal', false)"
                                class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Left Column - Photos -->
                            <div class="lg:col-span-1">
                                @if ($selectedOffer->photos->count() > 0)
                                    <div class="space-y-3">
                                        @foreach ($selectedOffer->photos as $photo)
                                            <img src="{{ $photo->url }}"
                                                class="w-full h-48 object-cover rounded-xl"
                                                alt="Photo {{ $loop->iteration }}">
                                        @endforeach
                                    </div>
                                @else
                                    <div
                                        class="w-full h-48 bg-gradient-to-br from-primary-100 to-earth-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-16 h-16 text-primary-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Producer Info -->
                                <div class="mt-6 bg-gradient-to-r from-primary-50 to-earth-50 rounded-xl p-4">
                                    <h4 class="font-semibold text-gray-900 mb-3">Producteur</h4>
                                    <div class="flex items-center space-x-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($selectedOffer->producer->name) }}&background=random"
                                            class="w-12 h-12 rounded-full"
                                            alt="{{ $selectedOffer->producer->name }}">
                                        <div>
                                            <p class="font-semibold text-gray-900">
                                                {{ $selectedOffer->producer->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $selectedOffer->producer->email }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-4 space-y-2 text-sm">
                                        <p class="text-gray-600">
                                            <strong>Inscrit:</strong>
                                            {{ $selectedOffer->producer->created_at->format('d/m/Y') }}
                                        </p>
                                        <p class="text-gray-600">
                                            <strong>Total offres:</strong>
                                            {{ $selectedOffer->producer->offers->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Details -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Title and Status -->
                                <div>
                                    <div class="flex items-start justify-between mb-3">
                                        <h4 class="text-2xl font-bold text-gray-900">{{ $selectedOffer->titre }}</h4>
                                        @php
                                            $statusConfig = [
                                                'en attente' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
                                                'validé' => ['bg' => 'bg-green-100', 'text' => 'text-green-700'],
                                                'rejeté' => ['bg' => 'bg-red-100', 'text' => 'text-red-700'],
                                                'suspendu' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
                                            ];
                                            $config = $statusConfig[$selectedOffer->statut] ?? [
                                                'bg' => 'bg-gray-100',
                                                'text' => 'text-gray-700',
                                            ];
                                        @endphp
                                        <span
                                            class="px-4 py-2 rounded-full text-sm font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                            {{ ucfirst($selectedOffer->statut) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-700 leading-relaxed">{{ $selectedOffer->description }}</p>
                                </div>

                                <!-- Info Grid -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-sm text-gray-600 mb-1">Catégorie</p>
                                        <p class="font-semibold text-gray-900">{{ $selectedOffer->categorie }}</p>
                                    </div>

                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-sm text-gray-600 mb-1">Prix</p>
                                        <p class="font-semibold text-primary-600 text-lg">
                                            {{ number_format($selectedOffer->prix, 0, ',', ' ') }} FCFA</p>
                                    </div>

                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-sm text-gray-600 mb-1">Quantité</p>
                                        <p class="font-semibold text-gray-900">{{ $selectedOffer->quantite }}
                                            {{ $selectedOffer->unite }}</p>
                                    </div>

                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-sm text-gray-600 mb-1">Localisation</p>
                                        <p class="font-semibold text-gray-900">{{ $selectedOffer->ville }},
                                            {{ $selectedOffer->region }}</p>
                                    </div>

                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-sm text-gray-600 mb-1">Statistiques</p>
                                        <p class="font-semibold text-gray-900">{{ $selectedOffer->views_count }} vues
                                            • {{ $selectedOffer->contacts_count }} contacts</p>
                                    </div>

                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-sm text-gray-600 mb-1">Publié le</p>
                                        <p class="font-semibold text-gray-900">
                                            {{ $selectedOffer->date_publication->format('d/m/Y à H:i') }}</p>
                                    </div>
                                </div>

                                <!-- Conditions de livraison -->
                                @if ($selectedOffer->conditions_livraison)
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <h5 class="font-semibold text-gray-900 mb-2">Conditions de livraison</h5>
                                        <p class="text-sm text-gray-700">{{ $selectedOffer->conditions_livraison }}
                                        </p>
                                    </div>
                                @endif>

                                <!-- Contact -->
                                @if ($selectedOffer->contact)
                                    <div class="bg-primary-50 border border-primary-200 rounded-lg p-4">
                                        <h5 class="font-semibold text-gray-900 mb-2">Contact</h5>
                                        <p class="text-sm text-gray-700">{{ $selectedOffer->contact }}</p>
                                    </div>
                                @endif

                                <!-- Actions Moderation -->
                                @if ($selectedOffer->statut === 'en attente')
                                    <div class="flex space-x-3 pt-4 border-t">
                                        <button wire:click="openValidateModal({{ $selectedOffer->id }})"
                                            class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-green-800 shadow-lg transition">
                                            ✓ Valider cette offre
                                        </button>
                                        <button wire:click="openRejectModal({{ $selectedOffer->id }})"
                                            class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold rounded-lg hover:from-red-700 hover:to-red-800 shadow-lg transition">
                                            ✗ Rejeter cette offre
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('alert', (event) => {
                    const data = event[0] || event;
                    Swal.fire({
                        icon: data.type,
                        title: data.type === 'success' ? 'Succès !' : data.type === 'error' ?
                            'Erreur !' : data.type === 'warning' ? 'Attention !' : 'Information',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                    });
                });
            });
        </script>
    @endpush
</div>
