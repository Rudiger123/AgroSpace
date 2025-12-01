<div class="min-h-screen bg-gray-50/50 py-8" x-data="demandsManagement()" x-init="initCharts()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Header & Actions -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('demands.title') }}</h1>
                <p class="mt-1 text-sm text-gray-600">{{ __('demands.subtitle') }}</p>
            </div>
            <button wire:click="expireOldDemands"
                class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-orange-300 hover:text-orange-600 shadow-sm transition-all group">
                <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-orange-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('demands.clean_expired') }}
            </button>
        </div>

        <!-- Section Graphiques & Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Graphique 1: Statuts -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-700 mb-4">{{ __('demands.status_chart_title') }}</h3>
                <div id="statusChart" class="h-64" wire:ignore></div>
            </div>

            <!-- Graphique 2: Catégories -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-700 mb-4">{{ __('demands.category_chart_title') }}</h3>
                <div id="categoryChart" class="h-64" wire:ignore></div>
            </div>

            <!-- KPI Cards Verticales -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                <div
                    class="bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl p-6 text-white shadow-lg shadow-orange-200 relative overflow-hidden">
                    <div class="absolute right-0 top-0 opacity-10 transform translate-x-2 -translate-y-2">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-orange-100 text-sm font-medium">{{ __('demands.active_requests') }}</p>
                    <p class="text-4xl font-bold mt-2">{{ $stats['active'] }}</p>
                    <p class="text-xs text-orange-100 mt-1 bg-white/20 inline-block px-2 py-0.5 rounded-lg">
                        {{ $stats['pending'] }} {{ __('demands.pending_verification') }}
                    </p>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ __('demands.total_interactions') }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['responses'] }}</p>
                        <p class="text-xs text-green-600 mt-1 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            {{ __('demands.generated_responses') }}
                        </p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres (Style Uniformisé) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                <div class="lg:col-span-2 form-group">
                    <label
                        class="text-xs font-bold text-gray-500 ml-1 mb-1 block uppercase tracking-wide">{{ __('demands.search_label') }}</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="{{ __('demands.search_placeholder') }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 focus:bg-white transition-all shadow-sm">
                    </div>
                </div>

                <div class="form-group">
                    <label
                        class="text-xs font-bold text-gray-500 ml-1 mb-1 block uppercase tracking-wide">{{ __('demands.status_label') }}</label>
                    <select wire:model.live="statusFilter"
                        class="w-full py-2.5 px-3 bg-gray-50 border-gray-200 rounded-xl text-gray-700 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 focus:bg-white transition-all shadow-sm cursor-pointer">
                        <option value="all">{{ __('demands.all') }}</option>
                        <option value="active">{{ __('demands.active') }}</option>
                        <option value="satisfied">{{ __('demands.satisfied') }}</option>
                        <option value="expired">{{ __('demands.expired') }}</option>
                        <option value="cancelled">{{ __('demands.cancelled') }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label
                        class="text-xs font-bold text-gray-500 ml-1 mb-1 block uppercase tracking-wide">{{ __('demands.verification_label') }}</label>
                    <select wire:model.live="verifiedFilter"
                        class="w-full py-2.5 px-3 bg-gray-50 border-gray-200 rounded-xl text-gray-700 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 focus:bg-white transition-all shadow-sm cursor-pointer">
                        <option value="all">{{ __('demands.all_verif') }}</option>
                        <option value="verified">✓ {{ __('demands.verified') }}</option>
                        <option value="unverified">⏳ {{ __('demands.unverified') }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label
                        class="text-xs font-bold text-gray-500 ml-1 mb-1 block uppercase tracking-wide">{{ __('demands.category_label') }}</label>
                    <select wire:model.live="categoryFilter"
                        class="w-full py-2.5 px-3 bg-gray-50 border-gray-200 rounded-xl text-gray-700 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 focus:bg-white transition-all shadow-sm cursor-pointer">
                        <option value="">{{ __('demands.all_categories') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="text-xs font-bold text-gray-500 ml-1 mb-1 block uppercase tracking-wide">{{ __('demands.sort_label') }}</label>
                    <select wire:model.live="sortBy"
                        class="w-full py-2.5 px-3 bg-gray-50 border-gray-200 rounded-xl text-gray-700 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 focus:bg-white transition-all shadow-sm cursor-pointer">
                        <option value="latest">{{ __('demands.recent') }}</option>
                        <option value="oldest">{{ __('demands.oldest') }}</option>
                        <option value="most_viewed">{{ __('demands.popular') }}</option>
                        <option value="most_responses">{{ __('demands.most_responses') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tableau (Responsive) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('demands.request') }}</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('demands.requester') }}</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('demands.info') }}</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('demands.status') }}</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('demands.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($demands as $demand)
                            <tr class="hover:bg-orange-50/30 transition-colors duration-150 group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 bg-orange-100 text-2xl flex items-center justify-center rounded-xl">
                                            {{ $demand->category->icon }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-gray-900 truncate max-w-[200px]"
                                                title="{{ $demand->title }}">
                                                {{ $demand->title }}
                                            </p>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span
                                                    class="text-xs text-gray-500">{{ $demand->category->name }}</span>
                                                @if ($demand->urgency === 'high')
                                                    <span class="w-2 h-2 rounded-full bg-red-500"
                                                        title="{{ __('demands.urgent') }}"></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($demand->user->name) }}&background=random&size=32"
                                            class="w-8 h-8 rounded-full ring-2 ring-white" alt="">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $demand->user->name }}</p>
                                            <p class="text-xs text-gray-400">
                                                {{ $demand->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center text-xs text-gray-600">
                                            <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $demand->city }}
                                        </div>
                                        <div class="flex items-center text-xs text-gray-500">
                                            <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            {{ $demand->views_count }} •
                                            {{ $demand->responses_count ?? $demand->responses->count() }} {{ __('demands.rep') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        @php
                                            $statusClasses = [
                                                'active' => 'bg-green-100 text-green-700 border-green-200',
                                                'satisfied' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                'expired' => 'bg-gray-100 text-gray-700 border-gray-200',
                                                'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                            ];
                                            $statusClass =
                                                $statusClasses[$demand->status] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $statusClass }}">
                                            {{ ucfirst($demand->status) }}
                                        </span>
                                        @if ($demand->is_verified)
                                            <span class="text-[10px] font-semibold text-blue-600 flex items-center">
                                                <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                {{ __('demands.verified') }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div
                                        class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <button wire:click="viewDetails({{ $demand->id }})"
                                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                            title="{{ __('demands.details') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>

                                        <div x-data="{ open: false }" class="relative">
                                            <button @click="open = !open"
                                                class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <div x-show="open" @click.away="open = false"
                                                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 z-50 py-1"
                                                x-cloak>
                                                @if (!$demand->is_verified)
                                                    <button wire:click="openVerifyModal({{ $demand->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 flex items-center">
                                                        {{ __('demands.verify') }}
                                                    </button>
                                                @else
                                                    <button wire:click="unverifyDemand({{ $demand->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700 flex items-center">
                                                        {{ __('demands.unverify') }}
                                                    </button>
                                                @endif
                                                <div class="border-t border-gray-100 my-1"></div>
                                                <button wire:click="updateStatus({{ $demand->id }}, 'active')"
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700">{{ __('demands.mark_active') }}</button>
                                                {{-- <button wire:click="updateStatus({{ $demand->id }}, 'satisfied')"
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700">Marquer
                                                    Satisfaite</button> --}}
                                                {{-- <button wire:click="updateStatus({{ $demand->id }}, 'cancelled')"
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-700">Annuler</button>
                                                <div class="border-t border-gray-100 my-1"></div> --}}
                                                <button wire:click="confirmDelete({{ $demand->id }})"
                                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">{{ __('demands.delete') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div
                                        class="bg-orange-50 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-orange-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ __('demands.no_requests_found') }}</h3>
                                    <p class="text-gray-500 mt-1">{{ __('demands.adjust_filters') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $demands->links() }}
        </div>
    </div>

    {{-- Details Modal (Redesign) --}}
    @if ($showDetailsModal && $selectedDemand)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showDetailsModal') }">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
                @click="$wire.set('showDetailsModal', false)"></div>

            <div class="flex min-h-screen items-center justify-center p-4">
                <div
                    class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl transform transition-all overflow-hidden">

                    {{-- Modal Header --}}
                    <div class="relative bg-gradient-to-r from-orange-500 to-red-600 px-8 py-6">
                        <div class="absolute inset-0 opacity-10"
                            style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'3\' cy=\'3\' r=\'3\'/%3E%3Ccircle cx=\'13\' cy=\'13\' r=\'3\'/%3E%3C/g%3E%3C/svg%3E');">
                        </div>
                        <div class="relative flex justify-between items-start">
                            <div class="flex gap-5">
                                <div
                                    class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-4xl shadow-lg border border-white/30">
                                    {{ $selectedDemand->category->icon }}
                                </div>
                                <div class="text-white pt-1">
                                    <h3 class="text-2xl font-bold leading-tight">{{ $selectedDemand->title }}</h3>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span
                                            class="bg-white/20 backdrop-blur px-3 py-1 rounded-full text-xs font-medium border border-white/20">
                                            {{ $selectedDemand->category->name }}
                                        </span>
                                        <span
                                            class="bg-white/20 backdrop-blur px-3 py-1 rounded-full text-xs font-medium border border-white/20">
                                            {{ ucfirst($selectedDemand->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button wire:click="$set('showDetailsModal', false)"
                                class="text-white/70 hover:text-white hover:bg-white/20 rounded-full p-2 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-8 max-h-[70vh] overflow-y-auto custom-scrollbar">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            {{-- Main Content --}}
                            <div class="lg:col-span-2 space-y-6">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-3">
                                        {{ __('demands.description') }}</h4>
                                    <p
                                        class="text-gray-600 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100">
                                        {{ $selectedDemand->description }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                        <p class="text-xs text-gray-500 font-bold uppercase">{{ __('demands.budget') }}</p>
                                        <p class="text-lg font-bold text-gray-900">
                                            {{ $selectedDemand->budget ? number_format($selectedDemand->budget) . ' FCFA' : __('demands.not_specified') }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                        <p class="text-xs text-gray-500 font-bold uppercase">{{ __('demands.quantity') }}</p>
                                        <p class="text-lg font-bold text-gray-900">
                                            {{ $selectedDemand->quantity ?? __('demands.not_specified') }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                        <p class="text-xs text-gray-500 font-bold uppercase">{{ __('demands.location') }}</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $selectedDemand->city }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                        <p class="text-xs text-gray-500 font-bold uppercase">{{ __('demands.validity') }}</p>
                                        <p class="text-lg font-bold text-gray-900">
                                            {{ $selectedDemand->validity_date->format('d/m/Y') }}</p>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-3">{{ __('demands.responses') }}
                                        ({{ $selectedDemand->responses->count() }})</h4>
                                    <div class="space-y-3">
                                        @forelse($selectedDemand->responses as $response)
                                            <div
                                                class="flex gap-4 bg-white border border-gray-100 p-4 rounded-xl shadow-sm">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($response->user->name) }}&background=random"
                                                    class="w-10 h-10 rounded-full">
                                                <div class="flex-1">
                                                    <div class="flex justify-between items-start">
                                                        <h5 class="font-bold text-gray-900">
                                                            {{ $response->user->name }}</h5>
                                                        <span
                                                            class="text-xs text-gray-400">{{ $response->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-gray-600 text-sm mt-1">{{ $response->message }}</p>
                                                    @if ($response->proposed_price)
                                                        <p class="text-xs font-bold text-green-600 mt-2">{{ __('demands.offer') }}:
                                                            {{ number_format($response->proposed_price) }} FCFA</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center text-gray-400 py-4 italic">{{ __('demands.no_responses') }}</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            {{-- Sidebar Info --}}
                            <div class="space-y-6">
                                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
                                    <h5 class="font-bold text-gray-900 mb-4">{{ __('demands.requester') }}</h5>
                                    <div class="flex items-center gap-3 mb-4">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($selectedDemand->user->name) }}&background=random"
                                            class="w-12 h-12 rounded-full ring-4 ring-orange-50">
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $selectedDemand->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $selectedDemand->user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="border-t border-gray-100 pt-4 text-sm space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">{{ __('demands.registered_on') }}</span>
                                            <span
                                                class="font-medium">{{ $selectedDemand->user->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100">
                                    <h5 class="font-bold text-blue-900 mb-2">{{ __('demands.stats') }}</h5>
                                    <div class="flex justify-between items-center py-2 border-b border-blue-200/50">
                                        <span class="text-blue-700">{{ __('demands.views') }}</span>
                                        <span
                                            class="font-bold text-blue-900">{{ $selectedDemand->views_count }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-blue-700">{{ __('demands.contacts') }}</span>
                                        <span
                                            class="font-bold text-blue-900">{{ $selectedDemand->contacts_received }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Modal (Redesign) --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showDeleteModal') }">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
                    <div class="p-8 text-center">
                        <div
                            class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ __('demands.delete_confirm_title') }}</h3>
                        <p class="text-gray-500 mb-8 leading-relaxed">{{ __('demands.delete_confirm_message') }}</p>

                        <div class="grid grid-cols-2 gap-4">
                            <button wire:click="$set('showDeleteModal', false)"
                                class="w-full py-3 px-4 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-xl transition-colors">
                                {{ __('demands.cancel') }}
                            </button>
                            <button wire:click="deleteDemand"
                                class="w-full py-3 px-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-200 transition-transform hover:scale-[1.02]">
                                {{ __('demands.delete') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

   <!-- Scripts Alpine.js et ApexCharts -->
<script>
    // Gestionnaire global des charts pour la gestion des demandes
    function demandsManagement() {
        return {
            statusChart: null,
            categoryChart: null,
            chartsInitialized: false,

            initCharts() {
                // Détruire les graphiques existants
                this.destroyCharts();

                const chartsData = @json($chartData);

                // 1. Chart des statuts (Donut)
                const statusOptions = {
                    series: Object.values(chartsData.status),
                    labels: Object.keys(chartsData.status).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                    chart: {
                        type: 'donut',
                        height: 250,
                        fontFamily: 'inherit',
                        animations: { enabled: true }
                    },
                    colors: ['#22c55e', '#3b82f6', '#ef4444', '#f97316', '#94a3b8'],
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '65%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: '{{ __("demands.total") }}',
                                        color: '#6b7280'
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: { enabled: false },
                    legend: { position: 'bottom', fontSize: '12px' },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return value + ' {{ __("demands.requests") }}';
                            }
                        }
                    }
                };

                // 2. Chart des catégories (Bar)
                const categoryOptions = {
                    series: [{
                        name: '{{ __("demands.requests") }}',
                        data: chartsData.categories.map(c => c.total)
                    }],
                    chart: {
                        type: 'bar',
                        height: 250,
                        toolbar: { show: false },
                        fontFamily: 'inherit',
                        animations: { enabled: true }
                    },
                    colors: ['#f97316'],
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: true,
                            barHeight: '50%'
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        textAnchor: 'start',
                        style: { colors: ['#fff'] },
                        formatter: function(val, opt) {
                            return val;
                        },
                        offsetX: 0
                    },
                    xaxis: {
                        categories: chartsData.categories.map(c => c.name),
                        labels: { show: false }
                    },
                    yaxis: {
                        labels: { show: false }
                    },
                    grid: {
                        borderColor: '#f1f5f9',
                        xaxis: { lines: { show: false } },
                        yaxis: { lines: { show: false } }
                    },
                    tooltip: {
                        y: {
                            formatter: function(value, { seriesIndex, dataPointIndex }) {
                                return chartsData.categories[dataPointIndex].name + ': ' + value + ' {{ __("demands.requests") }}';
                            }
                        }
                    }
                };

                // Initialiser les graphiques
                this.statusChart = new ApexCharts(document.querySelector("#statusChart"), statusOptions);
                this.categoryChart = new ApexCharts(document.querySelector("#categoryChart"), categoryOptions);

                this.statusChart.render();
                this.categoryChart.render();
                this.chartsInitialized = true;
            },

            destroyCharts() {
                if (this.statusChart) {
                    this.statusChart.destroy();
                    this.statusChart = null;
                }
                if (this.categoryChart) {
                    this.categoryChart.destroy();
                    this.categoryChart = null;
                }
            },

            refreshCharts() {
                // Petit délai pour s'assurer que les données sont mises à jour
                setTimeout(() => {
                    this.initCharts();
                }, 100);
            }
        }
    }

    // Initialisation au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        // Cette partie sera exécutée dans le contexte Alpine
    });

    // Écouter les événements Livewire
    document.addEventListener('livewire:init', function() {
        Livewire.on('refreshCharts', () => {
            const alpineComponent = document.querySelector('[x-data="demandsManagement()"]');
            if (alpineComponent && alpineComponent.__x) {
                alpineComponent.__x.$data.refreshCharts();
            }
        });
    });
</script>

    <style>
        .form-group label {
            font-size: 0.75rem;
            line-height: 1rem;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>
</div>