<div>
    {{-- resources/views/livewire/admin/users-management.blade.php --}}
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-6 lg:py-8" x-data.ignore="usersManagement()" x-cloak>

        {{-- Modals --}}
        @livewire('admin.modals.create-edit-user-modal')
        @livewire('admin.modals.user-details-modal')
        @livewire('admin.modals.send-email-modal')

        <!-- Header Gestion Utilisateurs -->
        <div class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-5">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">

                    <!-- Titre et sous-titre -->
                    <div class="flex flex-col flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 tracking-tight truncate">
                            Gestion des Utilisateurs
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1 hidden sm:block">
                            Visualisez, modifiez et gérez tous les comptes de la plateforme Agrospace.
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 sm:gap-3 w-full sm:w-auto">

                        <!-- Exporter -->
                        <button wire:click="exportUsers"
                            class="flex items-center gap-1 sm:gap-2 px-3 sm:px-4 py-2 bg-white border border-green-600 text-green-600 rounded-lg font-medium hover:bg-green-50 hover:shadow transition-all text-sm sm:text-base flex-1 sm:flex-none justify-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <span class="hidden xs:inline">Exporter</span>
                        </button>

                        <!-- Ajouter un nouvel utilisateur -->
                        <button wire:click="$dispatch('openCreateUserModal')"
                            class="flex items-center gap-1 sm:gap-2 px-3 sm:px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-lg font-medium hover:shadow-lg transition-all text-sm sm:text-base flex-1 sm:flex-none justify-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                            <span class="hidden xs:inline">Nouvel Utilisateur</span>
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-6 lg:py-8">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 mb-6 sm:mb-8">
                <div
                    class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm text-gray-600 font-medium truncate">Total</p>
                            <p class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 truncate">
                                {{ $totalUsers }}</p>
                        </div>
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                            <span class="text-sm sm:text-base lg:text-lg">👥</span>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm text-gray-600 font-medium truncate">Actifs</p>
                            <p class="text-lg sm:text-xl lg:text-2xl font-bold text-green-600 truncate">
                                {{ $activeUsers }}</p>
                        </div>
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-green-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm text-gray-600 font-medium truncate">Producteurs</p>
                            <p class="text-lg sm:text-xl lg:text-2xl font-bold text-green-600 truncate">
                                {{ $producers }}</p>
                        </div>
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                            <span class="text-sm sm:text-base lg:text-lg">👨‍🌾</span>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm text-gray-600 font-medium truncate">Consommateurs</p>
                            <p class="text-lg sm:text-xl lg:text-2xl font-bold text-blue-600 truncate">
                                {{ $consumers }}</p>
                        </div>
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                            <span class="text-sm sm:text-base lg:text-lg">🛒</span>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm text-gray-600 font-medium truncate">Vérifiés</p>
                            <p class="text-lg sm:text-xl lg:text-2xl font-bold text-purple-600 truncate">
                                {{ $verifiedUsers }}</p>
                        </div>
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-purple-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filters & Search --}}
            <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 mb-4 sm:mb-6">
                <div class="flex flex-col lg:flex-row gap-3 sm:gap-4">
                    {{-- Search --}}
                    <div class="flex-1 min-w-0">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                placeholder="Rechercher par nom ou email..."
                                class="w-full pl-10 pr-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none text-sm sm:text-base" />
                        </div>
                    </div>

                    {{-- Filters --}}
                    <div class="flex flex-wrap gap-2 sm:gap-3">
                        <select wire:model.live="filterRole"
                            class="flex-1 min-w-[120px] px-3 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none bg-white text-sm">
                            <option value="">Tous les rôles</option>
                            <option value="producer">Producteurs</option>
                            <option value="consumer">Consommateurs</option>
                            <option value="admin">Administrateurs</option>
                        </select>

                        <select wire:model.live="filterStatus"
                            class="flex-1 min-w-[120px] px-3 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none bg-white text-sm">
                            <option value="">Tous les statuts</option>
                            <option value="active">Actifs</option>
                            <option value="suspended">Suspendus</option>
                            <option value="banned">Bannis</option>
                        </select>

                        <select wire:model.live="filterRegion"
                            class="flex-1 min-w-[140px] px-3 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none bg-white text-sm hidden sm:block">
                            <option value="">Toutes les régions</option>
                            @foreach (['Adamaoua', 'Centre', 'Est', 'Extrême-Nord', 'Littoral', 'Nord', 'Nord-Ouest', 'Ouest', 'Sud', 'Sud-Ouest'] as $region)
                                <option value="{{ $region }}">{{ $region }}</option>
                            @endforeach
                        </select>

                        <button @click="showFilters = !showFilters"
                            class="px-3 py-2.5 sm:py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                </path>
                            </svg>
                            <span class="hidden sm:inline">Filtres</span>
                        </button>

                        <button wire:click="resetFilters"
                            class="px-3 py-2.5 sm:py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Bulk Actions --}}
                @if (count($selectedUsers) > 0)
                    <div
                        class="mt-3 sm:mt-4 p-3 sm:p-4 bg-blue-50 border border-blue-200 rounded-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-3">
                        <p class="text-xs sm:text-sm text-blue-700 font-medium">
                            {{ count($selectedUsers) }} utilisateur(s) sélectionné(s)
                        </p>
                        <div class="flex flex-wrap gap-1 sm:gap-2">
                            <button wire:click="bulkSendEmail"
                                class="px-2 py-1.5 bg-white border border-blue-300 text-blue-700 rounded-lg text-xs sm:text-sm font-medium hover:bg-blue-50 transition flex items-center gap-1">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Envoyer email
                            </button>
                            <button wire:click="confirmBulkSuspend"
                                class="px-2 py-1.5 bg-white border border-orange-300 text-orange-700 rounded-lg text-xs sm:text-sm font-medium hover:bg-orange-50 transition flex items-center gap-1">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                    </path>
                                </svg>
                                Suspendre
                            </button>
                            <button wire:click="confirmBulkDelete"
                                class="px-2 py-1.5 bg-white border border-red-300 text-red-700 rounded-lg text-xs sm:text-sm font-medium hover:bg-red-50 transition flex items-center gap-1">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
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

            {{-- Users Table --}}
            <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[800px]">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-3 sm:px-4 lg:px-6 py-3 text-left">
                                    <input type="checkbox" wire:model.live="selectAll"
                                        class="w-4 h-4 text-green-600 rounded focus:ring-green-500" />
                                </th>
                                <th
                                    class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Utilisateur
                                </th>
                                <th
                                    class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">
                                    Rôle
                                </th>
                                <th
                                    class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">
                                    Statut
                                </th>
                                <th
                                    class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">
                                    Localisation
                                </th>
                                <th
                                    class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden xl:table-cell">
                                    Activité
                                </th>
                                <th
                                    class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-3 sm:px-4 lg:px-6 py-3">
                                        <input type="checkbox" wire:model.live="selectedUsers"
                                            value="{{ $user->id }}"
                                            class="w-4 h-4 text-green-600 rounded focus:ring-green-500" />
                                    </td>
                                    <td class="px-3 sm:px-4 lg:px-6 py-3">
                                        <div class="flex items-center space-x-2 sm:space-x-3 min-w-0">
                                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full ring-2 ring-gray-100 flex-shrink-0" />
                                            <div class="min-w-0 flex-1">
                                                <div class="flex items-center gap-1 sm:gap-2">
                                                    <p
                                                        class="font-semibold text-gray-900 text-sm sm:text-base truncate">
                                                        {{ $user->name }}</p>
                                                    @if ($user->verified)
                                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-blue-500 flex-shrink-0"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <p class="text-xs sm:text-sm text-gray-500 truncate">
                                                    {{ $user->email }}</p>
                                                <p class="text-xs text-gray-400 truncate">{{ $user->phone }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-4 lg:px-6 py-3 hidden sm:table-cell">
                                        @php
                                            $roleConfig = match ($user->role->name) {
                                                'producer' => [
                                                    'class' => 'bg-green-100 text-green-700',
                                                    'label' => '👨‍🌾 Producteur',
                                                ],
                                                'consumer' => [
                                                    'class' => 'bg-blue-100 text-blue-700',
                                                    'label' => '🛒 Consommateur',
                                                ],
                                                'admin' => [
                                                    'class' => 'bg-purple-100 text-purple-700',
                                                    'label' => '👨‍💼 Admin',
                                                ],
                                                default => [
                                                    'class' => 'bg-gray-100 text-gray-700',
                                                    'label' => $user->role,
                                                ],
                                            };
                                        @endphp
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold {{ $roleConfig['class'] }} truncate inline-block max-w-[120px]">
                                            {{ $roleConfig['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 sm:px-4 lg:px-6 py-3 hidden md:table-cell">
                                        @php
                                            $statusConfig = match ($user->status) {
                                                'active' => [
                                                    'class' => 'bg-green-100 text-green-700',
                                                    'label' => '✓ Actif',
                                                ],
                                                'suspended' => [
                                                    'class' => 'bg-orange-100 text-orange-700',
                                                    'label' => '⏸ Suspendu',
                                                ],
                                                'banned' => [
                                                    'class' => 'bg-red-100 text-red-700',
                                                    'label' => '⛔ Banni',
                                                ],
                                                default => [
                                                    'class' => 'bg-gray-100 text-gray-700',
                                                    'label' => $user->status,
                                                ],
                                            };
                                        @endphp
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusConfig['class'] }} truncate inline-block max-w-[100px]">
                                            {{ $statusConfig['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 sm:px-4 lg:px-6 py-3 hidden lg:table-cell">
                                        <div class="text-sm">
                                            <p
                                                class="font-medium text-gray-900 text-xs sm:text-sm truncate max-w-[120px]">
                                                {{ $user->region }}</p>
                                            <p class="text-gray-500 text-xs truncate max-w-[120px]">
                                                {{ $user->city }}</p>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-4 lg:px-6 py-3 hidden xl:table-cell">
                                        <div class="text-sm">
                                            <p class="text-gray-900 text-xs sm:text-sm">{{ $user->last_active }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <span class="font-medium">{{ $user->offers_count }}</span> offres •
                                                <span class="font-medium">{{ $user->demands_count }}</span> demandes
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-4 lg:px-6 py-3">
                                        <div class="flex items-center gap-1 sm:gap-2" x-data.ignore="{ open: false }"
                                            x-cloak>
                                            <button wire:click="viewUser({{ $user->id }})"
                                                class="p-1.5 sm:p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                                title="Voir le profil">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button wire:click="editUser({{ $user->id }})"
                                                class="p-1.5 sm:p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                                                title="Modifier">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <div class="relative">
                                                <button @click="open = !open"
                                                    class="p-1.5 sm:p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition"
                                                    title="Plus d'actions">
                                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
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
                                                    class="absolute right-0 mt-2 w-40 sm:w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-1 z-50">
                                                    <button wire:click="sendEmail({{ $user->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                        Envoyer un email
                                                    </button>

                                                    @if (!$user->verified)
                                                        <button wire:click="verifyUser({{ $user->id }})"
                                                            class="w-full text-left px-4 py-2 text-sm text-blue-700 hover:bg-blue-50 flex items-center gap-2">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                                                </path>
                                                            </svg>
                                                            Vérifier l'utilisateur
                                                        </button>
                                                    @endif

                                                    @if ($user->status === 'active')
                                                        <button wire:click="confirmSuspendUser({{ $user->id }})"
                                                            class="w-full text-left px-4 py-2 text-sm text-orange-700 hover:bg-orange-50 flex items-center gap-2">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                                </path>
                                                            </svg>
                                                            Suspendre
                                                        </button>
                                                    @elseif($user->status === 'suspended')
                                                        <button
                                                            wire:click="confirmReactivateUser({{ $user->id }})"
                                                            class="w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-50 flex items-center gap-2">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                </path>
                                                            </svg>
                                                            Réactiver
                                                        </button>
                                                    @endif

                                                    <button wire:click="viewHistory({{ $user->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Voir l'historique
                                                    </button>

                                                    <div class="border-t border-gray-100 my-1"></div>

                                                    <button wire:click="confirmDelete({{ $user->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50 flex items-center gap-2">
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
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 sm:px-6 py-8 sm:py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-300 mb-3 sm:mb-4"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                            <p class="text-base sm:text-lg font-semibold text-gray-600">Aucun
                                                utilisateur trouvé</p>
                                            <p class="text-xs sm:text-sm text-gray-500 mt-1">Essayez de modifier vos
                                                filtres de recherche</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 border-t border-gray-200 bg-gray-50">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        {{-- Preloader Livewire pour Agrospace --}}
        <div wire:loading
            class="fixed inset-0 z-[9999] flex items-center justify-center min-h-screen bg-white/20 backdrop-blur-sm"
            style="transition: opacity 0.3s ease-in-out;">

            <div class="relative flex items-center justify-center h-screen">

                {{-- Cercle fixe (fond) --}}
                <div class="absolute w-32 h-32 border-4 border-green-400/40 rounded-full"></div>

                {{-- Cercle animé tournant --}}
                <div
                    class="absolute w-32 h-32 border-4 border-transparent border-t-green-600 border-r-green-600 rounded-full animate-spin">
                </div>

                {{-- Logo Agrospace --}}
                <div class="relative z-10 animate-pulse">
                    <img src="{{ asset('images/logo.png') }}" alt="Agrospace Logo" class="w-16 h-16 rounded-full" />
                </div>

            </div>
        </div>


        @if ($showHistory)
            <div x-data="{ showHistory: @entangle('showHistory') }" x-show="showHistory" x-cloak @click.away="showHistory = false"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm transition-opacity duration-300">
                <div
                    class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl p-6 max-h-[90vh] overflow-y-auto border border-green-100 animate-fadeIn">
                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Historique de {{ $selectedUser->name }}</h2>
                        <button @click="showHistory = false" class="text-gray-400 hover:text-gray-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Table pour Offres ou Demandes --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-green-50">
                                <tr>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Titre
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                {{-- Offres pour Producteur --}}
                                @if ($selectedUser->isProducer())
                                    @forelse($offers as $offer)
                                        <tr class="hover:bg-green-50 transition">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-2">
                                                    <svg class="h-5 w-5 text-green-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 17v-6a2 2 0 012-2h6m-6 0V3m0 8H5a2 2 0 00-2 2v6a2 2 0 002 2h6" />
                                                    </svg>
                                                    <span class="text-sm font-medium text-green-700">Offre</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">{{ $offer->title }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-500">
                                                {{ $offer->created_at->format('d/m/Y') }}</td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                    {{ $offer->status ?? 'Actif' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-3 text-gray-400 italic text-center">
                                                Aucune offre créée.</td>
                                        </tr>
                                    @endforelse
                                @endif

                                {{-- Demandes pour Consommateur --}}
                                @if ($selectedUser->isConsumer())
                                    @forelse($demands as $demand)
                                        <tr class="hover:bg-blue-50 transition">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-2">
                                                    <svg class="h-5 w-5 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span class="text-sm font-medium text-blue-700">Demande</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">{{ $demand->title }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-500">
                                                {{ $demand->created_at->format('d/m/Y') }}</td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                    {{ $demand->status ?? 'En attente' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-3 text-gray-400 italic text-center">
                                                Aucune demande faite.</td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- Footer --}}
                    <div class="mt-6 flex justify-end">
                        <button wire:click="$set('showHistory', false)"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition shadow-md">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        @endif




    </div>

    <script>
        function usersManagement() {
            return {
                showFilters: false,
                init() {
                    // Initialisation si nécessaire
                }
            }
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Amélioration responsive pour les très petits écrans */
        @media (max-width: 360px) {
            .grid-cols-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</div>
