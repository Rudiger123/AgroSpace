<div>
    {{-- resources/views/livewire/admin/users-management.blade.php --}}
    <div x-data="usersManagement()" x-cloak>

        {{-- Modals --}}
        @livewire('admin.modals.create-edit-user-modal')
        @livewire('admin.modals.user-details-modal')
        @livewire('admin.modals.send-email-modal')

        {{-- Header avec dégradé moderne --}}
        <div class="bg-gradient-to-r from-green-600 via-green-700 to-emerald-600 shadow-xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    {{-- Titre --}}
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-white/20 backdrop-blur-sm rounded-2xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white tracking-tight">
                                Gestion des Utilisateurs
                            </h1>
                            <p class="text-sm sm:text-base text-green-100 mt-1">
                                Administrez tous les comptes de la plateforme AgroSpace
                            </p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-wrap gap-2 sm:gap-3 w-full sm:w-auto">
                        <button wire:click="exportUsers"
                            class="flex items-center gap-2 px-4 py-2.5 bg-white/10 backdrop-blur-md border-2 border-white/30 text-white rounded-xl font-semibold hover:bg-white/20 hover:scale-105 transition-all shadow-lg flex-1 sm:flex-none justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <span>Exporter</span>
                        </button>

                        <button wire:click="$dispatch('openCreateUserModal')"
                            class="flex items-center gap-2 px-4 py-2.5 bg-white text-green-600 rounded-xl font-semibold hover:bg-green-50 hover:scale-105 transition-all shadow-lg flex-1 sm:flex-none justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                            <span>Nouvel Utilisateur</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6">

            {{-- Stats Cards Modernes --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                {{-- Total --}}
                <div
                    class="bg-white rounded-2xl p-4 shadow-md hover:shadow-xl transition-all border-l-4 border-gray-500 group hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm text-gray-600 font-medium mb-1">Total</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="text-2xl">👥</span>
                        </div>
                    </div>
                </div>

                {{-- Actifs --}}
                <div
                    class="bg-white rounded-2xl p-4 shadow-md hover:shadow-xl transition-all border-l-4 border-green-500 group hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm text-gray-600 font-medium mb-1">Actifs</p>
                            <p class="text-2xl sm:text-3xl font-bold text-green-600">{{ $activeUsers }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Producteurs --}}
                <div
                    class="bg-white rounded-2xl p-4 shadow-md hover:shadow-xl transition-all border-l-4 border-emerald-500 group hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm text-gray-600 font-medium mb-1">Producteurs</p>
                            <p class="text-2xl sm:text-3xl font-bold text-emerald-600">{{ $producers }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="text-2xl">👨‍🌾</span>
                        </div>
                    </div>
                </div>

                {{-- Consommateurs --}}
                <div
                    class="bg-white rounded-2xl p-4 shadow-md hover:shadow-xl transition-all border-l-4 border-blue-500 group hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm text-gray-600 font-medium mb-1">Consommateurs</p>
                            <p class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $consumers }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="text-2xl">🛒</span>
                        </div>
                    </div>
                </div>

                {{-- Vérifiés --}}
                <div
                    class="bg-white rounded-2xl p-4 shadow-md hover:shadow-xl transition-all border-l-4 border-purple-500 group hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm text-gray-600 font-medium mb-1">Vérifiés</p>
                            <p class="text-2xl sm:text-3xl font-bold text-purple-600">{{ $verifiedUsers }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Nouveaux ce mois --}}
                <div
                    class="bg-white rounded-2xl p-4 shadow-md hover:shadow-xl transition-all border-l-4 border-indigo-500 group hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm text-gray-600 font-medium mb-1">Ce mois</p>
                            <p class="text-2xl sm:text-3xl font-bold text-indigo-600">{{ $newUsersThisMonth }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Graphiques ApexCharts --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-cloak>
                {{-- Répartition par rôle --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        Répartition par Rôle
                    </h3>
                    <div id="rolesChart"></div>
                </div>

                {{-- Répartition par région --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                        Top 5 Régions
                    </h3>
                    <div id="regionsChart"></div>
                </div>

                {{-- Croissance --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-purple-500 rounded-full animate-pulse"></div>
                        Croissance (6 mois)
                    </h3>
                    <div id="growthChart"></div>
                </div>
            </div>

            {{-- Filters & Search --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 sm:p-6">
                <div class="flex flex-col lg:flex-row gap-4">
                    {{-- Search --}}
                    <div class="flex-1">
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                placeholder="Rechercher par nom, email ou téléphone..."
                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" />
                        </div>
                    </div>

                    {{-- Filters --}}
                    <div class="flex flex-wrap gap-3">
                        <select wire:model.live="filterRole"
                            class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white font-medium">
                            <option value="">Tous les rôles</option>
                            <option value="producer">👨‍🌾 Producteurs</option>
                            <option value="consumer">🛒 Consommateurs</option>
                            <option value="admin">👨‍💼 Administrateurs</option>
                        </select>

                        <select wire:model.live="filterStatus"
                            class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white font-medium">
                            <option value="">Tous les statuts</option>
                            <option value="active">✅ Actifs</option>
                            <option value="suspended">⏸ Suspendus</option>
                            <option value="banned">🚫 Bannis</option>
                        </select>

                        <select wire:model.live="filterRegion"
                            class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white font-medium hidden sm:block">
                            <option value="">Toutes les régions</option>
                            @foreach (['Adamaoua', 'Centre', 'Est', 'Extrême-Nord', 'Littoral', 'Nord', 'Nord-Ouest', 'Ouest', 'Sud', 'Sud-Ouest'] as $region)
                                <option value="{{ $region }}">{{ $region }}</option>
                            @endforeach
                        </select>

                        <button wire:click="resetFilters"
                            class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-all flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            <span class="hidden sm:inline">Réinitialiser</span>
                        </button>
                    </div>
                </div>

                {{-- Bulk Actions --}}
                @if (count($selectedUsers) > 0)
                    <div
                        class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                        <p class="text-sm font-bold text-blue-900 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ count($selectedUsers) }} utilisateur(s) sélectionné(s)
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <button wire:click="confirmBulkSendEmail"
                                class="px-3 py-2 bg-white border-2 border-blue-300 text-blue-700 rounded-lg text-sm font-semibold hover:bg-blue-50 transition-all flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Envoyer email
                            </button>
                            <button wire:click="confirmBulkSuspend"
                                class="px-3 py-2 bg-white border-2 border-orange-300 text-orange-700 rounded-lg text-sm font-semibold hover:bg-orange-50 transition-all flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                    </path>
                                </svg>
                                Suspendre
                            </button>
                            <button wire:click="confirmBulkDelete"
                                class="px-3 py-2 bg-white border-2 border-red-300 text-red-700 rounded-lg text-sm font-semibold hover:bg-red-50 transition-all flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Supprimer
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Users Table Moderne --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[800px]">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4">
                                    <input type="checkbox" wire:model.live="selectAll"
                                        class="w-5 h-5 text-green-600 rounded-lg focus:ring-2 focus:ring-green-500" />
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Utilisateur
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider hidden sm:table-cell">
                                    Rôle
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider hidden md:table-cell">
                                    Statut
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider hidden lg:table-cell">
                                    Localisation
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider hidden xl:table-cell">
                                    Dernière connexion
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($users as $user)
                                <tr class="hover:bg-green-50/50 transition-all group">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" wire:model.live="selectedUsers"
                                            value="{{ $user->id }}"
                                            class="w-5 h-5 text-green-600 rounded-lg focus:ring-2 focus:ring-green-500" />
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if ($user->avatar)
                                                <img src="{{ Storage::url($user->avatar) }}"
                                                    alt="{{ $user->name }}"
                                                    class="w-12 h-12 rounded-xl ring-2 ring-green-100 object-cover" />
                                            @else
                                                <div
                                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white font-bold text-lg ring-2 ring-green-100">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <p class="font-bold text-gray-900 truncate">{{ $user->name }}
                                                    </p>
                                                    @if ($user->email_verified_at)
                                                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-600 truncate">{{ $user->email }}</p>
                                                @if ($user->phone)
                                                    <p class="text-xs text-gray-400 truncate">📞 {{ $user->phone }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 hidden sm:table-cell">
                                        @php
                                            $roleConfig = match ($user->role->name ?? 'user') {
                                                'producer' => [
                                                    'class' =>
                                                        'bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border border-green-200',
                                                    'label' => '👨‍🌾 Producteur',
                                                ],
                                                'consumer' => [
                                                    'class' =>
                                                        'bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 border border-blue-200',
                                                    'label' => '🛒 Consommateur',
                                                ],
                                                'admin' => [
                                                    'class' =>
                                                        'bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 border border-purple-200',
                                                    'label' => '👨‍💼 Admin',
                                                ],
                                                default => [
                                                    'class' => 'bg-gray-100 text-gray-700',
                                                    'label' => $user->role->name ?? 'Utilisateur',
                                                ],
                                            };
                                            //$roleConfig = $user->getRoleBadge();
                                        @endphp

                                        <span
                                            class="px-3 py-1.5 rounded-lg text-xs font-bold {{ $roleConfig['class'] }} inline-block">
                                            {{ $roleConfig['label'] }}
                                        </span>

                                    </td>
                                    <td class="px-6 py-4 hidden sm:table-cell">
                                        @php
                                            $statusConfig = $user->getStatusBadge();
                                        @endphp
                                        <span
                                            class="px-3 py-1.5 rounded-lg text-xs font-bold {{ $statusConfig['class'] }} inline-block">
                                            {{ $statusConfig['label'] }}
                                        </span>

                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        <div class="text-sm">
                                            <p class="font-semibold text-gray-900 flex items-center gap-1">
                                                📍 {{ $user->region ?? 'N/A' }}
                                            </p>
                                            <p class="text-gray-500 text-xs">{{ $user->city ?? 'N/A' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 hidden xl:table-cell">
                                        <div class="text-sm">
                                            @if ($user->last_login_at)
                                                <p class="text-gray-900 font-medium flex items-center gap-1">
                                                    <svg class="w-4 h-4 text-green-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $user->last_login_at->diffForHumans() }}
                                                </p>
                                            @else
                                                <p class="text-gray-400 italic flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                        </path>
                                                    </svg>
                                                    Jamais connecté
                                                </p>
                                            @endif
                                            <p class="text-xs text-gray-500 mt-1">
                                                <span class="font-semibold">{{ $user->offers_count }}</span> offres •
                                                <span class="font-semibold">{{ $user->demands_count }}</span> demandes
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2" x-data="{ open: false }">
                                            {{-- Voir --}}
                                            <button wire:click="viewUser({{ $user->id }})"
                                                class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-all"
                                                title="Voir le profil">
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

                                            {{-- Modifier (sauf pour admin) --}}
                                            @if (!$user->isAdmin())
                                                <button wire:click="editUser({{ $user->id }})"
                                                    class="p-2 text-green-600 hover:bg-green-100 rounded-lg transition-all"
                                                    title="Modifier">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </button>

                                                {{-- Menu actions --}}
                                                <div class="relative">
                                                    <button @click="open = !open"
                                                        class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-all"
                                                        title="Plus d'actions">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                            </path>
                                                        </svg>
                                                    </button>

                                                    <div x-show="open" @click.away="open = false"
                                                        x-transition:enter="transition ease-out duration-100"
                                                        x-transition:enter-start="opacity-0 scale-95"
                                                        x-transition:enter-end="opacity-100 scale-100"
                                                        x-transition:leave="transition ease-in duration-75"
                                                        x-transition:leave-start="opacity-100 scale-100"
                                                        x-transition:leave-end="opacity-0 scale-95"
                                                        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 py-2 z-50">

                                                        <button wire:click="sendEmail({{ $user->id }})"
                                                            class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 flex items-center gap-3 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                                </path>
                                                            </svg>
                                                            Envoyer un email
                                                        </button>

                                                        @if (!$user->email_verified_at)
                                                            <button
                                                                wire:click="confirmVerifyUser({{ $user->id }})"
                                                                class="w-full text-left px-4 py-2.5 text-sm text-blue-700 hover:bg-blue-50 flex items-center gap-3 transition-colors">
                                                                <svg class="w-4 h-4" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                                                    </path>
                                                                </svg>
                                                                Vérifier l'utilisateur
                                                            </button>
                                                        @endif

                                                        @if ($user->status === 'active')
                                                            <button
                                                                wire:click="confirmSuspendUser({{ $user->id }})"
                                                                class="w-full text-left px-4 py-2.5 text-sm text-orange-700 hover:bg-orange-50 flex items-center gap-3 transition-colors">
                                                                <svg class="w-4 h-4" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                                    </path>
                                                                </svg>
                                                                Suspendre
                                                            </button>
                                                        @elseif($user->status === 'suspended')
                                                            <button
                                                                wire:click="confirmReactivateUser({{ $user->id }})"
                                                                class="w-full text-left px-4 py-2.5 text-sm text-green-700 hover:bg-green-50 flex items-center gap-3 transition-colors">
                                                                <svg class="w-4 h-4" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                    </path>
                                                                </svg>
                                                                Réactiver
                                                            </button>
                                                        @endif

                                                        <button wire:click="viewHistory({{ $user->id }})"
                                                            class="w-full text-left px-4 py-2.5 text-sm text-purple-700 hover:bg-purple-50 flex items-center gap-3 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                </path>
                                                            </svg>
                                                            Voir l'historique
                                                        </button>

                                                        <div class="border-t border-gray-100 my-2"></div>

                                                        <button wire:click="confirmDelete({{ $user->id }})"
                                                            class="w-full text-left px-4 py-2.5 text-sm text-red-700 hover:bg-red-50 flex items-center gap-3 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                            Supprimer
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                {{-- Pour les admins, seulement voir --}}
                                                <span class="text-xs text-gray-400 italic ml-2">Admin</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-12 h-12 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-xl font-bold text-gray-900 mb-2">Aucun utilisateur trouvé
                                            </p>
                                            <p class="text-sm text-gray-500">Essayez de modifier vos critères de
                                                recherche</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        {{-- Modal Historique --}}
        @if ($showHistory && $selectedUser)
            <div x-data="{ showHistory: @entangle('showHistory') }" x-show="showHistory" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity duration-300">
                <div @click.away="showHistory = false"
                    class="bg-white rounded-3xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-hidden border-2 border-gray-100 animate-fadeIn m-4">

                    {{-- Header --}}
                    <div
                        class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Historique</h2>
                                <p class="text-green-100 text-sm">{{ $selectedUser->name }}</p>
                            </div>
                        </div>
                        <button @click="showHistory = false"
                            class="text-white/80 hover:text-white hover:bg-white/20 p-2 rounded-lg transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Content --}}
                    <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Type</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Titre</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Date</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @if ($selectedUser->isProducer())
                                        @forelse($offers as $offer)
                                            <tr class="hover:bg-green-50 transition-all">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-2">
                                                        <div
                                                            class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-green-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                        <span class="text-sm font-bold text-green-700">Offre</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                                    {{ $offer->titre }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                    {{ $offer->created_at->format('d/m/Y') }}</td>
                                                <td class="px-6 py-4">
                                                    <span
                                                        class="px-3 py-1 rounded-lg text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                                        {{ $offer->statut ?? 'Actif' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">
                                                    Aucune offre créée
                                                </td>
                                            </tr>
                                        @endforelse
                                    @endif

                                    @if ($selectedUser->isConsumer())
                                        @forelse($demands as $demand)
                                            <tr class="hover:bg-blue-50 transition-all">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-2">
                                                        <div
                                                            class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-blue-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                        <span class="text-sm font-bold text-blue-700">Demande</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                                    {{ $demand->title }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                    {{ $demand->created_at->format('d/m/Y') }}</td>
                                                <td class="px-6 py-4">
                                                    <span
                                                        class="px-3 py-1 rounded-lg text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                        {{ $demand->status ?? 'En attente' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">
                                                    Aucune demande faite
                                                </td>
                                            </tr>
                                        @endforelse
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                        <button @click="showHistory = false"
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-xl hover:scale-105">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Scripts ApexCharts --}}
    @push('scripts')
        <script>
            function usersManagement() {
                return {
                    showFilters: false,
                    init() {
                        this.initCharts();
                    },

                    initCharts() {
                        // Graphique répartition par rôle
                        const rolesData = @json($usersByRole);
                        if (rolesData.length > 0) {
                            const rolesChart = new ApexCharts(document.querySelector("#rolesChart"), {
                                series: rolesData.map(item => item.count),
                                chart: {
                                    type: 'donut',
                                    height: 280,
                                },
                                labels: rolesData.map(item => {
                                    const labels = {
                                        'producer': '👨‍🌾 Producteurs',
                                        'consumer': '🛒 Consommateurs',
                                        'admin': '👨‍💼 Admins'
                                    };
                                    return labels[item.role] || item.role;
                                }),
                                colors: ['#10b981', '#3b82f6', '#8b5cf6'],
                                legend: {
                                    position: 'bottom'
                                },
                                dataLabels: {
                                    enabled: true,
                                    formatter: function(val) {
                                        return Math.round(val) + "%"
                                    }
                                }
                            });
                            rolesChart.render();
                        }

                        // Graphique régions
                        const regionsData = @json($usersByRegion);
                        if (regionsData.length > 0) {
                            const regionsChart = new ApexCharts(document.querySelector("#regionsChart"), {
                                series: [{
                                    name: 'Utilisateurs',
                                    data: regionsData.map(item => item.count)
                                }],
                                chart: {
                                    type: 'bar',
                                    height: 280,
                                },
                                plotOptions: {
                                    bar: {
                                        borderRadius: 8,
                                        horizontal: true,
                                    }
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                xaxis: {
                                    categories: regionsData.map(item => item.region),
                                },
                                colors: ['#3b82f6']
                            });
                            regionsChart.render();
                        }

                        // Graphique croissance
                        const growthData = @json($usersGrowth);
                        if (growthData.length > 0) {
                            const growthChart = new ApexCharts(document.querySelector("#growthChart"), {
                                series: [{
                                    name: 'Nouveaux utilisateurs',
                                    data: growthData.map(item => item.count)
                                }],
                                chart: {
                                    type: 'area',
                                    height: 280,
                                    toolbar: {
                                        show: false
                                    }
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    curve: 'smooth',
                                    width: 3
                                },
                                xaxis: {
                                    categories: growthData.map(item => item.month),
                                },
                                colors: ['#8b5cf6'],
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        shadeIntensity: 1,
                                        opacityFrom: 0.7,
                                        opacityTo: 0.3,
                                    }
                                }
                            });
                            growthChart.render();
                        }
                    }
                }
            }
        </script>
    @endpush

    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        /* Responsive pour très petits écrans */
        @media (max-width: 360px) {
            .grid-cols-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</div>
