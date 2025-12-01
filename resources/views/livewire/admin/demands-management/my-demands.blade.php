<div>
    <div class="min-h-screen bg-gradient-to-br from-primary-50 via-white to-earth-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ __('demands.my_demands') }}</h1>
                        <p class="mt-2 text-sm text-gray-600">{{ __('demands.subtitle') }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <button wire:click="openCreateModal"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-xl hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            {{ __('demands.new_demand') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">{{ __('demands.total') }}</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $demands->total() }}</p>
                        </div>
                        <div class="bg-primary-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">{{ __('demands.active') }}</p>
                            <p class="text-2xl font-bold text-green-600">
                                {{ $demands->where('status', 'active')->count() }}</p>
                        </div>
                        <div class="bg-green-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">{{ __('demands.satisfied') }}</p>
                            <p class="text-2xl font-bold text-blue-600">
                                {{ $demands->where('status', 'satisfied')->count() }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">{{ __('demands.responses') }}</p>
                            <p class="text-2xl font-bold text-purple-600">{{ $demands->sum('contacts_received') }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ __('demands.search_placeholder') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>

                    <div>
                        <select wire:model.live="statusFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="all">{{ __('demands.all_statuses') }}</option>
                            <option value="active">{{ __('demands.active') }}</option>
                            <option value="satisfied">{{ __('demands.satisfied') }}</option>
                            <option value="expired">{{ __('demands.expired') }}</option>
                            <option value="cancelled">{{ __('demands.cancelled') }}</option>
                        </select>
                    </div>

                    <div>
                        <select wire:model.live="categoryFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">{{ __('demands.all_categories') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select wire:model.live="regionFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">{{ __('demands.all_regions') }}</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region }}">{{ $region }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select wire:model.live="urgencyFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">{{ __('demands.all_urgencies') }}</option>
                            <option value="high">🔴 {{ __('demands.high') }}</option>
                            <option value="medium">🟡 {{ __('demands.medium') }}</option>
                            <option value="low">🟢 {{ __('demands.low') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Demands List -->
            <div class="space-y-4">
                @forelse($demands as $demand)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                            <div class="flex-1">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 mt-1">
                                        <span class="text-3xl">{{ $demand->category->icon }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $demand->title }}</h3>
                                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $demand->description }}
                                        </p>

                                        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                    </path>
                                                </svg>
                                                {{ $demand->category->name }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $demand->city }}, {{ $demand->region }}
                                            </span>
                                            @if ($demand->quantity)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                        </path>
                                                    </svg>
                                                    {{ $demand->quantity }}
                                                </span>
                                            @endif
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                {{ __('demands.expires_on') }} {{ $demand->validity_date->format('d/m/Y') }}
                                            </span>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-2 mt-3">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold {{ $demand->status_badge_color }}">
                                                {{ ucfirst($demand->status) }}
                                            </span>
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold {{ $demand->urgency_badge_color }}">
                                                @if ($demand->urgency === 'high')
                                                    🔴 {{ __('demands.high') }}
                                                @elseif($demand->urgency === 'medium')
                                                    🟡 {{ __('demands.medium') }}
                                                @else
                                                    🟢 {{ __('demands.low') }}
                                                @endif
                                            </span>
                                            <span
                                                class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                                👁️ {{ $demand->views_count }} {{ __('demands.views') }}
                                            </span>
                                            <span
                                                class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                                                💬 {{ $demand->responses->count() }} {{ __('demands.responses') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 mt-4 md:mt-0 md:ml-4">
                                <button wire:click="viewDetails({{ $demand->id }})"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                    title="{{ __('demands.view_details') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>

                                @if ($demand->status === 'active')
                                    <button wire:click="openEditModal({{ $demand->id }})"
                                        class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg transition"
                                        title="{{ __('demands.edit') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>

                                    <button wire:click="updateStatus({{ $demand->id }}, 'satisfied')"
                                        class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                                        title="{{ __('demands.mark_satisfied') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>

                                    <button wire:click="updateStatus({{ $demand->id }}, 'cancelled')"
                                        class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition"
                                        title="{{ __('demands.cancel') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    </button>
                                @endif

                                <button wire:click="confirmDelete({{ $demand->id }})"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="{{ __('demands.delete') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('demands.no_demands_found') }}</h3>
                        <p class="text-gray-600 mb-6">{{ __('demands.start_first_demand') }}</p>
                        <button wire:click="openCreateModal"
                            class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            {{ __('demands.create_demand') }}
                        </button>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $demands->links() }}
            </div>
        </div>

        <!-- Create/Edit Modal -->
        @if ($showModal)
            <div x-data="{ show: @entangle('showModal') }" x-show="show" x-cloak class="fixed inset-0 z-50"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                {{-- Overlay avec backdrop blur --}}
                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" @click="show = false">
                </div>

                {{-- Modal Container --}}
                <div class="flex min-h-screen items-center justify-center px-4">
                    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl transform transition-all"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        @click.stop>

                        {{-- Header Premium --}}
                        <div
                            class="relative bg-gradient-to-r from-primary-600 via-primary-500 to-earth-500 px-6 sm:px-8 py-6 rounded-t-3xl overflow-hidden">
                            {{-- Pattern Background --}}
                            <div class="absolute inset-0 opacity-10"
                                style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                            </div>

                            <div class="relative flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            @if ($demandId)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            @endif
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-white">
                                            {{ $demandId ? __('demands.edit_demand') : __('demands.new_demand') }}
                                        </h3>
                                        <p class="text-sm text-primary-100 mt-1">
                                            {{ $demandId ? __('demands.update_info') : __('demands.publish_need') }}
                                        </p>
                                    </div>
                                </div>
                                <button @click="show = false"
                                    class="text-white/80 hover:text-white hover:bg-white/20 rounded-xl p-2.5 transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Body avec scroll --}}
                        <div class="max-h-[calc(100vh-200px)] overflow-y-auto custom-scrollbar">
                            <form wire:submit.prevent="saveDemand" class="px-6 pt-6 sm:px-8 sm:pt-8 space-y-8">

                                {{-- Section Informations Générales --}}
                                <div class="space-y-6">
                                    <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                        <div
                                            class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-5 h-5 text-primary-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-bold text-gray-900">{{ __('demands.general_info') }}</h4>
                                    </div>

                                    <div class="space-y-6">
                                        {{-- Titre --}}
                                        <div class="space-y-1.5">
                                            <label class="block text-sm font-bold text-gray-800 ml-1">
                                                {{ __('demands.demand_title') }}
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <input type="text" wire:model="title"
                                                    class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:ring-opacity-50"
                                                    placeholder="{{ __('demands.title_placeholder') }}">
                                                <div
                                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-gray-400">
                                                    <span x-text="($wire.title || '').length"></span>/255
                                                </div>
                                            </div>
                                            @error('title')
                                                <p
                                                    class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                    <span>⚠</span>{{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        {{-- Description --}}
                                        <div class="space-y-1.5">
                                            <label class="block text-sm font-bold text-gray-800 ml-1">
                                                {{ __('demands.detailed_description') }}
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <div class="relative">
                                                <textarea wire:model="description" rows="5"
                                                    class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:ring-opacity-50 resize-y min-h-[120px]"
                                                    placeholder="{{ __('demands.description_placeholder') }}"></textarea>
                                            </div>
                                            <div class="flex items-center justify-between mt-2">
                                                <p class="text-xs text-gray-500">{{ __('demands.min_chars') }}</p>
                                                <span class="text-xs"
                                                    :class="($wire.description || '').length >= 20 ? 'text-green-600' :
                                                        'text-gray-400'">
                                                    <span x-text="($wire.description || '').length"></span>/2000
                                                </span>
                                            </div>
                                            @error('description')
                                                <p
                                                    class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                    <span>⚠</span>{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Section Détails du Produit --}}
                                <div class="space-y-6">
                                    <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                        <div
                                            class="w-10 h-10 bg-earth-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-5 h-5 text-earth-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-bold text-gray-900">{{ __('demands.product_details') }}</h4>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        {{-- Catégorie --}}
                                        <div class="space-y-1.5">
                                            <label class="block text-sm font-bold text-gray-800 ml-1">
                                                {{ __('demands.category') }}
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <select wire:model="category_id"
                                                    class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 transition-all duration-200 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:ring-opacity-50">
                                                    <option value="">{{ __('demands.select_category') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->icon }}
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('category_id')
                                                <p
                                                    class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                    <span>⚠</span>{{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        {{-- Quantité --}}
                                        <div class="space-y-1.5">
                                            <label class="block text-sm font-bold text-gray-800 ml-1">
                                                {{ __('demands.quantity') }}
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <input type="text" wire:model="quantity"
                                                    class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:ring-opacity-50"
                                                    placeholder="{{ __('demands.quantity_placeholder') }}">
                                            </div>
                                            @error('quantity')
                                                <p
                                                    class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                    <span>⚠</span>{{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        {{-- Budget --}}
                                        <div class="space-y-1.5">
                                            <label class="block text-sm font-bold text-gray-800 ml-1">
                                                {{ __('demands.max_budget') }}
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <input type="number" wire:model="budget"
                                                    class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:ring-opacity-50"
                                                    placeholder="{{ __('demands.budget_placeholder') }}">
                                                <div
                                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">
                                                    FCFA
                                                </div>
                                            </div>
                                            @error('budget')
                                                <p
                                                    class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                    <span>⚠</span>{{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        {{-- Urgence --}}
                                        <div class="space-y-1.5">
                                            <label class="block text-sm font-bold text-gray-800 ml-1">
                                                {{ __('demands.urgency_level') }}
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <select wire:model="urgency"
                                                    class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 transition-all duration-200 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:ring-opacity-50">
                                                    <option value="low">🟢 {{ __('demands.low_urgency') }}</option>
                                                    <option value="medium">🟡 {{ __('demands.medium_urgency') }}</option>
                                                    <option value="high">🔴 {{ __('demands.high_urgency') }}</option>
                                                </select>
                                            </div>
                                            @error('urgency')
                                                <p
                                                    class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                    <span>⚠</span>{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Section Localisation --}}
                                <div class="space-y-6">
                                    <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-bold text-gray-900">{{ __('demands.location') }}</h4>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        {{-- Région --}}
                                        <div class="space-y-1.5">
                                            <label class="block text-sm font-bold text-gray-800 ml-1">
                                                {{ __('demands.region') }}
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <select wire:model="region"
                                                    class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 transition-all duration-200 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:ring-opacity-50">
                                                    <option value="">{{ __('demands.select_region') }}</option>
                                                    @foreach ($regions as $reg)
                                                        <option value="{{ $reg }}">{{ $reg }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('region')
                                                <p
                                                    class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                    <span>⚠</span>{{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        {{-- Ville --}}
                                        <div class="space-y-1.5">
                                            <label class="block text-sm font-bold text-gray-800 ml-1">
                                                {{ __('demands.city') }}
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <input type="text" wire:model="city"
                                                    class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:ring-opacity-50"
                                                    placeholder="{{ __('demands.city_placeholder') }}">
                                            </div>
                                            @error('city')
                                                <p
                                                    class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                    <span>⚠</span>{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Section Validité --}}
                                <div class="space-y-6">
                                    <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                        <div
                                            class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-bold text-gray-900">{{ __('demands.demand_validity') }}</h4>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        {{-- Date de validité --}}
                                        <div class="space-y-1.5">
                                            <label class="block text-sm font-bold text-gray-800 ml-1">
                                                {{ __('demands.validity_date') }}
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <input type="date" wire:model="validity_date"
                                                    min="{{ now()->format('Y-m-d') }}"
                                                    class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 transition-all duration-200 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:ring-opacity-50">
                                            </div>
                                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-purple-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ __('demands.validity_question') }}
                                            </p>
                                            @error('validity_date')
                                                <p
                                                    class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                    <span>⚠</span>{{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        {{-- Indicateur de statut --}}
                                        <div class="space-y-1.5">
                                            <label class="block text-sm font-bold text-gray-800 ml-1">
                                                {{ __('demands.demand_status') }}
                                            </label>
                                            <div
                                                class="flex items-center space-x-4 p-4 bg-gray-50 border-2 border-gray-200 rounded-xl">
                                                <div
                                                    class="flex items-center justify-center w-12 h-12 rounded-lg bg-gradient-to-r from-purple-500 to-purple-600">
                                                    <svg class="w-6 h-6 text-white" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900"
                                                        x-text="getValidityStatus()">
                                                    </p>
                                                    <p class="text-sm text-gray-600" x-text="getValidityDays()"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Footer Actions --}}
                                <div
                                    class="sticky bottom-0 -mx-8 -mb-8 px-8 py-6 bg-gray-50 border-t border-gray-200 flex items-center justify-between gap-4 mt-8 rounded-b-3xl">
                                    {{-- Message champs obligatoires --}}
                                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                        <span>{{ __('demands.required_fields') }}</span>
                                    </div>

                                    {{-- Boutons --}}
                                    <div class="flex items-center gap-4">
                                        {{-- Bouton Annuler --}}
                                        <button type="button" @click="show = false" wire:loading.attr="disabled"
                                            class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-white hover:shadow-sm transition-all focus:ring-2 focus:ring-gray-200">
                                            {{ __('demands.cancel') }}
                                        </button>

                                        {{-- Bouton Soumettre --}}
                                        <button type="submit" wire:loading.attr="disabled" wire:target="saveDemand"
                                            class="px-8 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-xl shadow-lg shadow-primary-500/30 hover:shadow-primary-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">

                                            {{-- State: Loading --}}
                                            <div wire:loading wire:target="saveDemand"
                                                class="flex items-center gap-2">
                                                <svg class="animate-spin h-5 w-5 text-white"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                                <span>{{ $demandId ? __('demands.updating') : __('demands.creating') }}</span>
                                            </div>

                                            {{-- State: Normal --}}
                                            <div wire:loading.remove wire:target="saveDemand"
                                                class="flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span>{{ $demandId ? __('demands.update') : __('demands.create_demand') }}</span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>


    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showDeleteModal') }">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                <div x-show="show" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">

                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 text-center mb-2">{{ __('demands.delete_demand') }}</h3>
                    <p class="text-gray-600 text-center mb-6">{{ __('demands.delete_confirmation') }}</p>

                    <div class="flex space-x-3">
                        <button wire:click="$set('showDeleteModal', false)"
                            class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                            {{ __('demands.cancel') }}
                        </button>
                        <button wire:click="deleteDemand"
                            class="flex-1 px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                            {{ __('demands.delete') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Details Modal -->
    @if ($showDetailsModal && $selectedDemand)
        <div x-data="{ show: @entangle('showDetailsModal') }" x-show="show" x-cloak class="fixed inset-0 z-50"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            {{-- Overlay avec backdrop blur --}}
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" @click="show = false">
            </div>

            {{-- Modal Container --}}
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl transform transition-all max-h-[90vh] overflow-hidden"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    @click.stop>

                    {{-- Header Premium --}}
                    <div
                        class="relative bg-gradient-to-r from-primary-600 via-primary-500 to-earth-500 px-6 sm:px-8 py-6 rounded-t-3xl overflow-hidden">
                        {{-- Pattern Background --}}
                        <div class="absolute inset-0 opacity-10"
                            style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                        </div>

                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-white">{{ __('demands.demand_details') }}</h3>
                                    <p class="text-sm text-primary-100 mt-1">
                                        {{ __('demands.complete_info_responses') }}
                                    </p>
                                </div>
                            </div>
                            <button @click="show = false"
                                class="text-white/80 hover:text-white hover:bg-white/20 rounded-xl p-2.5 transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Body avec scroll --}}
                    <div class="max-h-[calc(90vh-140px)] overflow-y-auto custom-scrollbar">
                        <div class="p-6 sm:p-8 space-y-8">

                            {{-- Header Info --}}
                            <div
                                class="bg-gradient-to-r from-primary-50 to-earth-50 rounded-2xl p-6 border border-primary-100">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-16 h-16 bg-white rounded-2xl shadow-lg flex items-center justify-center text-2xl">
                                            {{ $selectedDemand->category->icon }}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-xl font-bold text-gray-900 mb-3">{{ $selectedDemand->title }}
                                        </h4>
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <span
                                                class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $selectedDemand->status_badge_color }} border border-white/50">
                                                {{ ucfirst($selectedDemand->status) }}
                                            </span>
                                            <span
                                                class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $selectedDemand->urgency_badge_color }} border border-white/50">
                                                @if ($selectedDemand->urgency === 'high')
                                                    🔴 {{ __('demands.high_urgency') }}
                                                @elseif($selectedDemand->urgency === 'medium')
                                                    🟡 {{ __('demands.medium_urgency') }}
                                                @else
                                                    🟢 {{ __('demands.low_urgency') }}
                                                @endif
                                            </span>
                                            <span
                                                class="px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                                👁️ {{ $selectedDemand->views_count }} {{ __('demands.views') }}
                                            </span>
                                        </div>
                                        <p class="text-gray-700 leading-relaxed">{{ $selectedDemand->description }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Details Grid --}}
                            <div class="space-y-6">
                                <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                    <div class="w-10 h-10 bg-earth-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-earth-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ __('demands.detailed_info') }}</h4>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {{-- Catégorie --}}
                                    <div
                                        class="bg-gray-50 rounded-xl p-4 border border-gray-100 hover:border-gray-200 transition-colors">
                                        <div class="flex items-center text-gray-600 mb-2">
                                            <svg class="w-5 h-5 mr-3 text-primary-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                </path>
                                            </svg>
                                            <span class="text-sm font-semibold">{{ __('demands.category') }}</span>
                                        </div>
                                        <p class="text-gray-900 font-bold text-lg">
                                            {{ $selectedDemand->category->name }}</p>
                                    </div>

                                    {{-- Quantité --}}
                                    @if ($selectedDemand->quantity)
                                        <div
                                            class="bg-gray-50 rounded-xl p-4 border border-gray-100 hover:border-gray-200 transition-colors">
                                            <div class="flex items-center text-gray-600 mb-2">
                                                <svg class="w-5 h-5 mr-3 text-earth-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                    </path>
                                                </svg>
                                                <span class="text-sm font-semibold">{{ __('demands.quantity_requested') }}</span>
                                            </div>
                                            <p class="text-gray-900 font-bold text-lg">{{ $selectedDemand->quantity }}
                                            </p>
                                        </div>
                                    @endif

                                    {{-- Localisation --}}
                                    <div
                                        class="bg-gray-50 rounded-xl p-4 border border-gray-100 hover:border-gray-200 transition-colors">
                                        <div class="flex items-center text-gray-600 mb-2">
                                            <svg class="w-5 h-5 mr-3 text-blue-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="text-sm font-semibold">{{ __('demands.location') }}</span>
                                        </div>
                                        <p class="text-gray-900 font-bold text-lg">{{ $selectedDemand->city }},
                                            {{ $selectedDemand->region }}</p>
                                    </div>

                                    {{-- Budget --}}
                                    @if ($selectedDemand->budget)
                                        <div
                                            class="bg-gray-50 rounded-xl p-4 border border-gray-100 hover:border-gray-200 transition-colors">
                                            <div class="flex items-center text-gray-600 mb-2">
                                                <svg class="w-5 h-5 mr-3 text-green-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                <span class="text-sm font-semibold">{{ __('demands.max_budget') }}</span>
                                            </div>
                                            <p class="text-gray-900 font-bold text-lg">
                                                {{ number_format($selectedDemand->budget, 0, ',', ' ') }} FCFA
                                            </p>
                                        </div>
                                    @endif

                                    {{-- Date de validité --}}
                                    <div
                                        class="bg-gray-50 rounded-xl p-4 border border-gray-100 hover:border-gray-200 transition-colors">
                                        <div class="flex items-center text-gray-600 mb-2">
                                            <svg class="w-5 h-5 mr-3 text-purple-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span class="text-sm font-semibold">{{ __('demands.valid_until') }}</span>
                                        </div>
                                        <p class="text-gray-900 font-bold text-lg">
                                            {{ $selectedDemand->validity_date->format('d/m/Y') }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $selectedDemand->validity_date->diffForHumans() }}
                                        </p>
                                    </div>

                                    {{-- Date de création --}}
                                    <div
                                        class="bg-gray-50 rounded-xl p-4 border border-gray-100 hover:border-gray-200 transition-colors">
                                        <div class="flex items-center text-gray-600 mb-2">
                                            <svg class="w-5 h-5 mr-3 text-orange-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm font-semibold">{{ __('demands.published_on') }}</span>
                                        </div>
                                        <p class="text-gray-900 font-bold text-lg">
                                            {{ $selectedDemand->created_at->format('d/m/Y') }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $selectedDemand->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Responses Section --}}
                            <div class="space-y-6">
                                <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <h4 class="text-lg font-bold text-gray-900">{{ __('demands.received_responses') }}</h4>
                                        <span
                                            class="bg-primary-500 text-white text-sm font-semibold px-3 py-1 rounded-full">
                                            {{ $selectedDemand->responses->count() }}
                                        </span>
                                    </div>
                                </div>

                                @forelse($selectedDemand->responses as $response)
                                    <div
                                        class="bg-white border border-gray-200 rounded-2xl p-5 hover:border-primary-300 transition-colors shadow-sm">
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex items-center space-x-3">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($response->user->name) }}&background=22c55e&color=fff"
                                                    class="w-12 h-12 rounded-xl shadow-sm"
                                                    alt="{{ $response->user->name }}">
                                                <div>
                                                    <p class="font-bold text-gray-900">{{ $response->user->name }}</p>
                                                    <p class="text-sm text-gray-500 flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ $response->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                            <span
                                                class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $response->status_badge_color }} border border-white/50">
                                                {{ ucfirst($response->status) }}
                                            </span>
                                        </div>

                                        <p class="text-gray-700 mb-4 leading-relaxed">{{ $response->message }}</p>

                                        <div
                                            class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-4 border-t border-gray-100">
                                            @if ($response->proposed_price)
                                                <div class="flex items-center text-sm">
                                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                    <span class="font-semibold text-gray-700">{{ __('demands.proposed_price') }}:</span>
                                                    <span class="ml-2 text-gray-900 font-bold">
                                                        {{ number_format($response->proposed_price, 0, ',', ' ') }}
                                                        FCFA
                                                    </span>
                                                </div>
                                            @endif

                                            @if ($response->contact_phone)
                                                <div class="flex items-center text-sm">
                                                    <svg class="w-4 h-4 text-blue-600 mr-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                        </path>
                                                    </svg>
                                                    <span class="font-semibold text-gray-700">{{ __('demands.contact') }}:</span>
                                                    <span
                                                        class="ml-2 text-gray-900 font-mono">{{ $response->contact_phone }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div
                                        class="text-center py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                            </path>
                                        </svg>
                                        <h5 class="text-lg font-semibold text-gray-600 mb-2">{{ __('demands.no_responses_yet') }}</h5>
                                        <p class="text-gray-500 max-w-sm mx-auto">
                                            {{ __('demands.no_responses_description') }}
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('demandForm', () => ({
                getValidityStatus() {
                    const validityDate = this.$wire.get('validity_date');
                    if (!validityDate) return '⏳ {{ __('demands.date_not_set') }}';

                    const today = new Date();
                    const validUntil = new Date(validityDate);
                    const diffTime = validUntil - today;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    if (diffDays < 0) return '❌ {{ __('demands.expired') }}';
                    if (diffDays === 0) return '🟡 {{ __('demands.expires_today') }}';
                    if (diffDays <= 7) return '🟠 {{ __('demands.expires_soon') }}';
                    if (diffDays <= 30) return '🟢 {{ __('demands.valid') }}';
                    return '✅ {{ __('demands.long_term') }}';
                },

                getValidityDays() {
                    const validityDate = this.$wire.get('validity_date');
                    if (!validityDate) return '{{ __('demands.set_validity_date') }}';

                    const today = new Date();
                    const validUntil = new Date(validityDate);
                    const diffTime = validUntil - today;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    if (diffDays < 0) return '{{ __('demands.demand_expired') }}';
                    if (diffDays === 0) return '{{ __('demands.expires_today') }}';
                    if (diffDays === 1) return '{{ __('demands.one_day_left') }}';
                    return `${diffDays} {{ __('demands.days_left') }}`;
                }
            }));
        });
    </script>
</div>