<div>
    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header avec animations --}}
            <div class="mb-8 animate-fade-in">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h1
                            class="text-4xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent flex items-center space-x-3">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/30 animate-pulse-slow">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <span>{{ __('contacts.title') }}</span>
                        </h1>
                        <p class="mt-2 text-gray-600 text-lg">{{ __('contacts.subtitle') }}</p>
                    </div>

                    {{-- Actions rapides --}}
                    <div class="flex items-center space-x-3">
                        @if (count($selectedContacts) > 0)
                            <button wire:click="deleteSelected"
                                wire:confirm="{{ __('contacts.delete_selected_confirm', ['count' => count($selectedContacts)]) }}"
                                class="px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition-all duration-200 shadow-lg shadow-red-500/30 hover:shadow-xl hover:scale-105 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                <span>{{ __('contacts.delete_selected', ['count' => count($selectedContacts)]) }}</span>
                            </button>
                        @endif

                        <button wire:click="exportContacts"
                            class="px-4 py-2.5 bg-white hover:bg-gray-50 border-2 border-indigo-200 text-indigo-600 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <span>{{ __('contacts.export') }}</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Statistiques principales --}}
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
                {{-- Total --}}
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-indigo-200 cursor-pointer transform hover:-translate-y-1"
                    wire:click="$set('statusFilter', 'all')">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">{{ __('contacts.stats.total') }}</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                        <div class="mt-3 flex items-center text-xs text-gray-500">
                            <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                            {{ __('contacts.stats.all_statuses') }}
                        </div>
                    </div>
                </div>

                {{-- Nouveaux --}}
                <div class="group bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden cursor-pointer transform hover:-translate-y-1"
                    wire:click="$set('statusFilter', 'new')">
                    <div class="p-6 relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="flex items-center justify-between mb-4 relative z-10">
                            <div
                                class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-blue-100 mb-1 relative z-10">{{ __('contacts.stats.new') }}</p>
                        <p class="text-3xl font-bold text-white relative z-10">{{ $stats['new'] }}</p>
                        <div class="mt-3 flex items-center text-xs text-blue-100 relative z-10">
                            <span class="inline-block w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                            {{ __('contacts.stats.unread') }}
                        </div>
                    </div>
                </div>

                {{-- Ouverts --}}
                <div class="group bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden cursor-pointer transform hover:-translate-y-1"
                    wire:click="$set('statusFilter', 'opened')">
                    <div class="p-6 relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="flex items-center justify-between mb-4 relative z-10">
                            <div
                                class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-amber-100 mb-1 relative z-10">{{ __('contacts.stats.opened') }}</p>
                        <p class="text-3xl font-bold text-white relative z-10">{{ $stats['opened'] }}</p>
                        <div class="mt-3 flex items-center text-xs text-amber-100 relative z-10">
                            <span class="inline-block w-2 h-2 bg-white rounded-full mr-2"></span>
                            {{ __('contacts.stats.pending') }}
                        </div>
                    </div>
                </div>

                {{-- Répondus --}}
                <div class="group bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden cursor-pointer transform hover:-translate-y-1"
                    wire:click="$set('statusFilter', 'replied')">
                    <div class="p-6 relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="flex items-center justify-between mb-4 relative z-10">
                            <div
                                class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-green-100 mb-1 relative z-10">{{ __('contacts.stats.replied') }}</p>
                        <p class="text-3xl font-bold text-white relative z-10">{{ $stats['replied'] }}</p>
                        <div class="mt-3 flex items-center text-xs text-green-100 relative z-10">
                            <span class="inline-block w-2 h-2 bg-white rounded-full mr-2"></span>
                            {{ __('contacts.stats.processed') }}
                        </div>
                    </div>
                </div>

                {{-- Fermés --}}
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-gray-300 cursor-pointer transform hover:-translate-y-1"
                    wire:click="$set('statusFilter', 'closed')">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">{{ __('contacts.stats.closed') }}</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['closed'] }}</p>
                        <div class="mt-3 flex items-center text-xs text-gray-500">
                            <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                            {{ __('contacts.stats.archived') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats avancées --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-indigo-100">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-600">{{ __('contacts.advanced_stats.today') }}</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $advancedStats['today'] }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-purple-100">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-600">{{ __('contacts.advanced_stats.this_week') }}</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $advancedStats['this_week'] }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-pink-100">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-10 h-10 bg-pink-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-600">{{ __('contacts.advanced_stats.avg_response_time') }}</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ number_format($advancedStats['avg_response_time'] ?? 0, 1) }}h</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-green-100">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-600">{{ __('contacts.advanced_stats.response_rate') }}</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $advancedStats['response_rate'] }}%</p>
                </div>
            </div>

            {{-- Filtres et recherche --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Recherche --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('contacts.search.label') }}</label>
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="search"
                                placeholder="{{ __('contacts.search.placeholder') }}"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-400 transition-all duration-200">
                            <svg class="w-6 h-6 text-gray-400 absolute left-4 top-3.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            @if ($search)
                                <button wire:click="$set('search', '')"
                                    class="absolute right-3 top-3 p-1 hover:bg-gray-100 rounded-lg transition-colors">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- Filtre statut --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('contacts.status.label') }}</label>
                        <select wire:model.live="statusFilter"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-400 transition-all duration-200">
                            <option value="all">{{ __('contacts.status.all') }}</option>
                            <option value="new">{{ __('contacts.status.new') }}</option>
                            <option value="opened">{{ __('contacts.status.opened') }}</option>
                            <option value="replied">{{ __('contacts.status.replied') }}</option>
                            <option value="closed">{{ __('contacts.status.closed') }}</option>
                        </select>
                    </div>
                </div>

                @if ($search || $statusFilter !== 'all')
                    <div class="mt-4 flex items-center justify-between pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600">
                            <span class="font-semibold text-indigo-600">{{ $contacts->total() }}</span> {{ __('contacts.results_found') }}
                        </p>
                        <button wire:click="$set('search', ''); $set('statusFilter', 'all')"
                            class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex items-center space-x-1 px-3 py-1.5 hover:bg-indigo-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            <span>{{ __('contacts.reset') }}</span>
                        </button>
                    </div>
                @endif
            </div>

            {{-- Table des contacts --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left">
                                    <input type="checkbox" wire:model.live="selectAll"
                                        class="w-5 h-5 text-indigo-600 border-gray-300 rounded-lg focus:ring-indigo-500 cursor-pointer">
                                </th>
                                <th wire:click="sortBy('name')"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider cursor-pointer hover:bg-gray-200 transition-colors">
                                    <div class="flex items-center space-x-2">
                                        <span>{{ __('contacts.table.contact') }}</span>
                                        @if ($sortBy === 'name')
                                            <svg class="w-4 h-4 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        @endif
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    {{ __('contacts.table.subject_message') }}</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    {{ __('contacts.table.status') }}</th>
                                <th wire:click="sortBy('created_at')"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider cursor-pointer hover:bg-gray-200 transition-colors">
                                    <div class="flex items-center space-x-2">
                                        <span>{{ __('contacts.table.date') }}</span>
                                        @if ($sortBy === 'created_at')
                                            <svg class="w-4 h-4 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        @endif
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    {{ __('contacts.table.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($contacts as $contact)
                                <tr class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-200 {{ $contact->status === 'new' ? 'bg-blue-50/50' : '' }}"
                                    wire:key="contact-{{ $contact->id }}">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" wire:model.live="selectedContacts"
                                            value="{{ $contact->id }}"
                                            class="w-5 h-5 text-indigo-600 border-gray-300 rounded-lg focus:ring-indigo-500 cursor-pointer">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                                {{ strtoupper(substr($contact->name, 0, 2)) }}
                                            </div>
                                            <div class="ml-4">
                                                <div
                                                    class="text-sm font-semibold text-gray-900 flex items-center space-x-2">
                                                    <span>{{ $contact->name }}</span>
                                                    @if ($contact->status === 'new')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-500 text-white animate-pulse">
                                                            {{ __('contacts.status.new_badge') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-sm text-gray-500 flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    <span>{{ $contact->email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 max-w-md">
                                        <div class="text-sm font-semibold text-gray-900 mb-1 truncate">
                                            📝 {{ $contact->subject }}
                                        </div>
                                        <div class="text-sm text-gray-500 line-clamp-2">
                                            {{ Str::limit($contact->message, 80) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusConfig = [
                                                'new' => [
                                                    'bg' => 'bg-blue-500',
                                                    'text' => 'text-white',
                                                    'label' => __('contacts.status_labels.new'),
                                                    'icon' => '🆕',
                                                ],
                                                'opened' => [
                                                    'bg' => 'bg-amber-500',
                                                    'text' => 'text-white',
                                                    'label' => __('contacts.status_labels.opened'),
                                                    'icon' => '👁️',
                                                ],
                                                'replied' => [
                                                    'bg' => 'bg-green-500',
                                                    'text' => 'text-white',
                                                    'label' => __('contacts.status_labels.replied'),
                                                    'icon' => '✅',
                                                ],
                                                'closed' => [
                                                    'bg' => 'bg-gray-500',
                                                    'text' => 'text-white',
                                                    'label' => __('contacts.status_labels.closed'),
                                                    'icon' => '❌',
                                                ],
                                            ];
                                            $config = $statusConfig[$contact->status] ?? $statusConfig['new'];
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold {{ $config['bg'] }} {{ $config['text'] }} shadow-sm">
                                            <span class="mr-1">{{ $config['icon'] }}</span>
                                            {{ $config['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="font-medium text-gray-900">
                                            {{ $contact->created_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $contact->created_at->format('H:i') }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $contact->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <button wire:click="viewContact({{ $contact->id }})"
                                                class="p-2 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded-xl transition-all group"
                                                title="{{ __('contacts.actions.view') }}">
                                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </button>

                                            @if ($contact->status !== 'replied')
                                                <button wire:click="openReplyModal({{ $contact->id }})"
                                                    class="p-2 text-green-600 hover:text-green-900 hover:bg-green-50 rounded-xl transition-all group"
                                                    title="{{ __('contacts.actions.reply') }}">
                                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                                    </svg>
                                                </button>
                                            @endif

                                            <button wire:click="openDeleteModal({{ $contact->id }})"
                                                class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-xl transition-all group"
                                                title="{{ __('contacts.actions.delete') }}">
                                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 text-lg font-semibold mb-2">{{ __('contacts.no_messages') }}</p>
                                            <p class="text-gray-400 text-sm">{{ __('contacts.no_messages_description') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($contacts->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $contacts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Inclure les modals --}}
    {{-- MODAL VISUALISATION --}}
    @if ($showViewModal && $selectedContact)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showViewModal') }" x-show="show"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeViewModal"></div>

            {{-- Modal --}}
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative bg-white rounded-3xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 px-8 py-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center text-white font-bold text-2xl">
                                    {{ strtoupper(substr($selectedContact->name, 0, 2)) }}
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-white">{{ $selectedContact->name }}</h3>
                                    <p class="text-white/80 text-sm flex items-center space-x-2 mt-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span>{{ $selectedContact->email }}</span>
                                    </p>
                                </div>
                            </div>
                            <button wire:click="closeViewModal"
                                class="text-white/80 hover:text-white p-2 hover:bg-white/20 rounded-xl transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="p-8 overflow-y-auto max-h-[60vh] space-y-6">
                        {{-- Sujet --}}
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">{{ __('contacts.modal_view.subject') }}</label>
                            <p class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-xl p-4">
                                {{ $selectedContact->subject }}
                            </p>
                        </div>

                        {{-- Message --}}
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">{{ __('contacts.modal_view.message') }}</label>
                            <div
                                class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border-l-4 border-indigo-500">
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                                    {{ $selectedContact->message }}</p>
                            </div>
                        </div>

                        {{-- Métadonnées --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                                <p class="text-xs font-semibold text-blue-700 mb-1">{{ __('contacts.modal_view.received_date') }}</p>
                                <p class="text-sm text-blue-900">
                                    {{ $selectedContact->created_at->format('d/m/Y à H:i') }}</p>
                                <p class="text-xs text-blue-600 mt-1">
                                    {{ $selectedContact->created_at->diffForHumans() }}</p>
                            </div>

                            <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
                                <p class="text-xs font-semibold text-purple-700 mb-1">{{ __('contacts.modal_view.current_status') }}</p>
                                @php
                                    $statusLabels = [
                                        'new' => __('contacts.status_labels.new'),
                                        'opened' => __('contacts.status_labels.opened'),
                                        'replied' => __('contacts.status_labels.replied'),
                                        'closed' => __('contacts.status_labels.closed'),
                                    ];
                                @endphp
                                <p class="text-sm text-purple-900">
                                    {{ $statusLabels[$selectedContact->status] ?? $selectedContact->status }}</p>
                            </div>
                        </div>

                        {{-- Si répondu --}}
                        @if ($selectedContact->status === 'replied' && $selectedContact->reply_message)
                            <div class="bg-green-50 rounded-xl p-6 border-l-4 border-green-500">
                                <div class="flex items-center space-x-2 mb-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                    </svg>
                                    <p class="text-sm font-semibold text-green-700">{{ __('contacts.modal_view.reply_sent') }}</p>
                                </div>
                                <p class="text-sm text-green-900 mb-2">{{ $selectedContact->reply_message }}</p>
                                <p class="text-xs text-green-600">
                                    {{ __('contacts.modal_view.by') }} {{ $selectedContact->repliedBy->name ?? __('contacts.modal_view.unknown') }}
                                    {{ __('contacts.modal_view.on') }} {{ $selectedContact->replied_at?->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Footer Actions --}}
                    <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <button wire:click="closeViewModal"
                                class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition-all">
                                {{ __('contacts.buttons.close') }}
                            </button>
                            <div class="flex items-center space-x-3">
                                @if ($selectedContact->status !== 'closed')
                                    <button wire:click="markAsClosed({{ $selectedContact->id }})"
                                        class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-xl font-medium transition-all flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span>{{ __('contacts.buttons.close_status') }}</span>
                                    </button>
                                @endif

                                @if ($selectedContact->status !== 'replied')
                                    <button wire:click="openReplyModal({{ $selectedContact->id }}); closeViewModal()"
                                        class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-xl font-medium transition-all shadow-lg hover:shadow-xl flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                        </svg>
                                        <span>{{ __('contacts.buttons.reply') }}</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL RÉPONSE --}}
    @if ($showReplyModal && $selectedContact)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showReplyModal') }" x-show="show"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">

            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeReplyModal"></div>

            {{-- Modal --}}
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative bg-white rounded-3xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 px-8 py-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-white flex items-center space-x-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                    </svg>
                                    <span>{{ __('contacts.modal_reply.title') }}</span>
                                </h3>
                                <p class="text-white/80 text-sm mt-1">
                                    {{ __('contacts.modal_reply.to') }}: {{ $selectedContact->name }} ({{ $selectedContact->email }})
                                </p>
                            </div>
                            <button wire:click="closeReplyModal"
                                class="text-white/80 hover:text-white p-2 hover:bg-white/20 rounded-xl transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="p-8 overflow-y-auto max-h-[60vh] space-y-6">
                        {{-- Message original --}}
                        <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-gray-300">
                            <p class="text-xs font-semibold text-gray-500 mb-2">{{ __('contacts.modal_reply.original_message') }}</p>
                            <p class="text-sm font-semibold text-gray-900 mb-2">{{ $selectedContact->subject }}</p>
                            <p class="text-sm text-gray-600 line-clamp-3">{{ $selectedContact->message }}</p>
                        </div>

                        {{-- Sélection des destinataires --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                {{ __('contacts.modal_reply.select_recipients') }}
                            </label>
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-48 overflow-y-auto p-4 bg-gray-50 rounded-xl border-2 border-gray-200">

                                <label
                                        class="flex items-center space-x-3 p-3 bg-white hover:bg-indigo-50 rounded-xl cursor-pointer border-2 border-transparent hover:border-indigo-200 transition-all">
                                        <input type="checkbox"
                                            value="{{ $selectedContact->id }}" 
                                                @checked(true) disabled
                                            class="w-5 h-5 text-indigo-600 border-gray-300 rounded-lg focus:ring-indigo-500">
                                        <div class="flex items-center space-x-2 flex-1">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg flex items-center justify-center text-white text-xs font-bold">
                                                {{ strtoupper(substr($selectedContact->name, 0, 2)) }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 truncate">
                                                    {{ $selectedContact->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ $selectedContact->email }}</p>
                                            </div>
                                        </div>
                                    </label>
                            </div>
                            @error('selectedUsers')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror

                            @if (count($selectedUsers) > 0)
                                <p class="mt-2 text-sm text-green-600 font-medium">
                                    ✓ {{ __('contacts.modal_reply.recipients_selected', ['count' => count($selectedUsers)]) }}
                                </p>
                            @endif
                        </div>

                        {{-- Message de réponse --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                {{ __('contacts.modal_reply.your_reply') }}
                            </label>
                            <textarea wire:model="replyMessage" rows="8" placeholder="{{ __('contacts.modal_reply.reply_placeholder') }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-4 focus:ring-green-100 focus:border-green-400 transition-all resize-none"></textarea>
                            @error('replyMessage')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">
                                {{ strlen($replyMessage) }} {{ __('contacts.modal_reply.characters') }}
                            </p>
                        </div>

                        {{-- Options supplémentaires --}}
                        <div class="space-y-3 bg-indigo-50 rounded-xl p-4 border border-indigo-200">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" wire:model="ccToSender"
                                    class="w-5 h-5 text-indigo-600 border-gray-300 rounded-lg focus:ring-indigo-500">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ __('contacts.modal_reply.cc_sender') }}</p>
                                    <p class="text-xs text-gray-500">{{ $selectedContact->email }} {{ __('contacts.modal_reply.cc_sender_description') }}</p>
                                </div>
                            </label>

                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" wire:model="sendCopyToMe"
                                    class="w-5 h-5 text-indigo-600 border-gray-300 rounded-lg focus:ring-indigo-500">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ __('contacts.modal_reply.send_copy_to_me') }}</p>
                                    <p class="text-xs text-gray-500">{{ __('contacts.modal_reply.send_copy_to_me_description') }}</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <button wire:click="closeReplyModal"
                                class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition-all">
                                {{ __('contacts.buttons.cancel') }}
                            </button>
                            <button wire:click="sendReply" wire:loading.attr="disabled"
                                wire:loading.class="opacity-50 cursor-not-allowed"
                                class="px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-xl flex items-center space-x-2">
                                <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                <svg wire:loading class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span wire:loading.remove>{{ __('contacts.buttons.send_reply') }}</span>
                                <span wire:loading>{{ __('contacts.buttons.sending') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL SUPPRESSION --}}
    @if ($showDeleteModal && $selectedContact)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showDeleteModal') }" x-show="show"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">

            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeDeleteModal"></div>

            {{-- Modal --}}
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                    {{-- Icon --}}
                    <div class="flex justify-center pt-8">
                        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="px-8 py-6 text-center">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ __('contacts.modal_delete.title') }}</h3>
                        <p class="text-gray-600 mb-4">
                            {{ __('contacts.modal_delete.confirm_message', ['name' => $selectedContact->name]) }}
                        </p>
                        <p class="text-sm text-red-600 font-medium">
                            ⚠️ {{ __('contacts.modal_delete.warning') }}
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="bg-gray-50 px-8 py-6 rounded-b-3xl flex items-center justify-center space-x-4">
                        <button wire:click="closeDeleteModal"
                            class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition-all">
                            {{ __('contacts.buttons.cancel') }}
                        </button>
                        <button wire:click="deleteContact"
                            class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition-all shadow-lg hover:shadow-xl flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            <span>{{ __('contacts.buttons.delete') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Scripts Livewire --}}
    @script
        <script>
            $wire.on('contact-replied', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: '{{ __("contacts.notifications.reply_sent") }}',
                    text: event[0].message,
                    confirmButtonColor: '#10b981',
                    confirmButtonText: '{{ __("contacts.notifications.great") }}',
                    timer: 3000
                });
            });

            $wire.on('contact-deleted', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: '{{ __("contacts.notifications.deleted") }}',
                    text: event[0].message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            });

            $wire.on('contacts-deleted', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: '{{ __("contacts.notifications.multiple_deleted") }}',
                    text: event[0].message,
                    confirmButtonColor: '#6366f1',
                    timer: 3000
                });
            });

            $wire.on('contact-updated', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: '{{ __("contacts.notifications.updated") }}',
                    text: event[0].message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
            });

            $wire.on('contact-error', (event) => {
                Swal.fire({
                    icon: 'error',
                    title: '{{ __("contacts.notifications.error") }}',
                    text: event[0].message,
                    confirmButtonColor: '#ef4444'
                });
            });

            $wire.on('export-started', () => {
                Swal.fire({
                    icon: 'info',
                    title: '{{ __("contacts.notifications.export_started") }}',
                    text: '{{ __("contacts.notifications.export_description") }}',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        </script>
    @endscript
</div>