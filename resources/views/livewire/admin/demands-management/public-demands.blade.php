<div>
    <div class="min-h-screen bg-gradient-to-br from-primary-50 via-white to-earth-50">
        <style>
            .gradient-bg-demands {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #6B8DD6 100%);
            }

            .glass-effect {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            /* Animations supplémentaires */
            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-10px);
                }
            }

            .animate-float {
                animation: float 3s ease-in-out infinite;
            }
        </style>
        <!-- Hero Section pour Demandes -->
        <div class="gradient-bg-demands text-white py-16 relative overflow-hidden">
            <!-- Background pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0"
                    style="background-image: url('data:image/svg+xml,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"none\" fill-rule=\"evenodd\"><g fill=\"%23ffffff\" fill-opacity=\"0.1\"><circle cx=\"30\" cy=\"30\" r=\"4\"/></g></g></svg>');">
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 animate-fadeIn">
                        {{ __('public_demands.title') }}
                    </h1>
                    <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto">
                        {{ __('public_demands.subtitle') }}
                    </p>

                    <!-- Barre de recherche principale améliorée -->
                    <div class="max-w-4xl mx-auto">
                        <div class="relative group">
                            <input type="text" wire:model.live.debounce.500ms="search"
                                placeholder="{{ __('public_demands.search_placeholder') }}"
                                class="w-full px-6 py-4 pl-16 text-gray-800 rounded-2xl shadow-2xl focus:ring-4 focus:ring-blue-300 focus:outline-none transform group-hover:scale-[1.02] transition-all duration-300 border-2 border-transparent focus:border-blue-400">
                            <svg class="w-6 h-6 text-gray-400 absolute left-6 top-1/2 transform -translate-y-1/2 group-hover:text-blue-500 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <button
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all font-semibold shadow-lg hover:shadow-xl active:scale-95">
                                {{ __('public_demands.search_button') }}
                            </button>
                        </div>
                    </div>

                    <!-- Quick filters créatifs -->
                    <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                        <span class="text-blue-200 text-sm font-medium bg-white/10 px-3 py-1 rounded-full">{{ __('public_demands.quick_filters') }}</span>
                        @foreach ($categories as $category)
                            <button wire:click="$set('categoryFilter', '{{ $category->id }}')"
                                class="bg-white/15 hover:bg-white/25 text-white px-4 py-2 rounded-full text-sm font-medium transition-all backdrop-blur-sm hover:scale-105 active:scale-95 border border-white/10 hover:border-white/20 flex items-center gap-2">
                                <span class="text-lg">{{ $category->icon }}</span>
                                {{ $category->name }}
                            </button>
                        @endforeach
                        <button wire:click="$set('urgencyFilter', 'high')"
                            class="bg-red-500/80 hover:bg-red-500 text-white px-4 py-2 rounded-full text-sm font-medium transition-all backdrop-blur-sm hover:scale-105 active:scale-95 flex items-center gap-2">
                            {{ __('public_demands.urgent_filter') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Filtres Avancés Modernes -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
                <div
                    class="bg-white/95 backdrop-blur-lg rounded-2xl shadow-xl border border-gray-100/50 p-6 mb-6 glass-effect">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ __('public_demands.advanced_filters') }}</h3>
                        <button wire:click="resetAllFilters"
                            class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 hover:border-red-300 hover:text-red-700 transition-all duration-300 group relative">
                            <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform duration-500"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            {{ __('public_demands.clear_all') }}
                            @if ($this->hasActiveFilters())
                                <span
                                    class="bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full min-w-[20px] transform group-hover:scale-110 transition-transform">
                                    {{ $this->countActiveFilters() }}
                                </span>
                            @endif
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                        <!-- Catégorie -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('public_demands.category_label') }}</label>
                            <select wire:model.live="categoryFilter"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white/80">
                                <option value="">{{ __('public_demands.all_categories') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Région -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('public_demands.region_label') }}</label>
                            <select wire:model.live="regionFilter"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white/80">
                                <option value="">{{ __('public_demands.all_regions') }}</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region }}">{{ $region }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Urgence -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('public_demands.urgency_label') }}</label>
                            <select wire:model.live="urgencyFilter"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white/80">
                                <option value="">{{ __('public_demands.all_levels') }}</option>
                                <option value="high">{{ __('public_demands.high_urgency') }}</option>
                                <option value="medium">{{ __('public_demands.medium_urgency') }}</option>
                                <option value="low">{{ __('public_demands.low_urgency') }}</option>
                            </select>
                        </div>

                        <!-- Tri -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('public_demands.sort_by_label') }}</label>
                            <select wire:model.live="sortBy"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white/80">
                                <option value="latest">{{ __('public_demands.latest') }}</option>
                                <option value="urgent">{{ __('public_demands.most_urgent') }}</option>
                                <option value="popular">{{ __('public_demands.most_viewed') }}</option>
                                <option value="expiring">{{ __('public_demands.expiring_soon') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Demands Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse($demands as $demand)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-200 overflow-hidden group">
                        <!-- Header with Category Icon -->
                        <div class="bg-gradient-to-r from-primary-50 to-earth-50 p-4 border-b">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-4xl">{{ $demand->category->icon }}</span>
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold {{ $demand->urgency_badge_color }}">
                                    @if ($demand->urgency === 'high')
                                        {{ __('public_demands.urgency_high') }}
                                    @elseif($demand->urgency === 'medium')
                                        {{ __('public_demands.urgency_medium') }}
                                    @else
                                        {{ __('public_demands.urgency_low') }}
                                    @endif
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-900 text-lg line-clamp-2 mb-1">{{ $demand->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $demand->category->name }}</p>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <p class="text-gray-700 text-sm mb-4 line-clamp-3">{{ $demand->description }}</p>

                            <!-- Info Tags -->
                            <div class="space-y-2 mb-4">
                                @if ($demand->quantity)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                </path>
                                        </svg>
                                        <span class="font-medium">{{ __('public_demands.quantity') }}</span>
                                        <span class="ml-1">{{ $demand->quantity }}</span>
                                    </div>
                                @endif

                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ __('public_demands.location') }}</span>
                                    <span class="ml-1">{{ $demand->city }}, {{ $demand->region }}</span>
                                </div>

                                @if ($demand->budget)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-primary-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                        <span class="font-medium">{{ __('public_demands.budget') }}</span>
                                        <span class="ml-1">{{ number_format($demand->budget, 0, ',', ' ') }}
                                            FCFA</span>
                                    </div>
                                @endif

                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="font-medium">{{ __('public_demands.expires') }}</span>
                                    <span class="ml-1">{{ $demand->validity_date->diffForHumans() }}</span>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-4 pb-4 border-b">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    {{ $demand->views_count }} {{ __('public_demands.views') }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                        </path>
                                    </svg>
                                    {{ $demand->contacts_received }} {{ __('public_demands.responses') }}
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                <button wire:click="viewDetails({{ $demand->id }})"
                                    class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition text-sm">
                                    {{ __('public_demands.view_details') }}
                                </button>
                                <button wire:click="openResponseModal({{ $demand->id }})"
                                    class="flex-1 px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-lg hover:from-primary-700 hover:to-primary-800 transition text-sm">
                                    {{ __('public_demands.respond') }}
                                </button>
                            </div>
                        </div>

                        <!-- Demandeur Info -->
                        <div class="bg-gray-50 px-4 py-3 border-t flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($demand->user->name) }}&background=random"
                                class="w-8 h-8 rounded-full" alt="{{ $demand->user->name }}">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $demand->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ __('public_demands.published') }} {{ $demand->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('public_demands.no_demand_found') }}</h3>
                            <p class="text-gray-600">{{ __('public_demands.try_changing_criteria') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $demands->links() }}
            </div>
        </div>

        <!-- Response Modal -->
        @if ($showResponseModal && $selectedDemand)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showResponseModal') }">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>

                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">

                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">{{ __('public_demands.respond_to_demand') }}</h3>
                            <button wire:click="$set('showResponseModal', false)"
                                class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Demand Info -->
                        <div class="bg-gradient-to-r from-primary-50 to-earth-50 rounded-xl p-4 mb-6">
                            <div class="flex items-start space-x-3">
                                <span class="text-3xl">{{ $selectedDemand->category->icon }}</span>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 mb-1">{{ $selectedDemand->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $selectedDemand->category->name }} •
                                        {{ $selectedDemand->city }}, {{ $selectedDemand->region }}</p>
                                    @if ($selectedDemand->quantity)
                                        <p class="text-sm text-gray-700 mt-2"><strong>{{ __('public_demands.quantity') }}:</strong>
                                            {{ $selectedDemand->quantity }}</p>
                                    @endif
                                    @if ($selectedDemand->budget)
                                        <p class="text-sm text-gray-700 mt-1"><strong>{{ __('public_demands.max_budget') }}:</strong>
                                            {{ number_format($selectedDemand->budget, 0, ',', ' ') }} FCFA</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <form wire:submit.prevent="submitResponse" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('public_demands.your_proposal') }} *</label>
                                <textarea wire:model="message" rows="5"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="{{ __('public_demands.proposal_placeholder') }}"></textarea>
                                @error('message')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('public_demands.proposed_price') }}
                                        (FCFA)</label>
                                    <input type="number" wire:model="proposed_price"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="{{ __('public_demands.price_placeholder') }}">
                                    @error('proposed_price')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('public_demands.contact_phone') }}</label>
                                    <input type="text" wire:model="contact_phone"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="{{ __('public_demands.phone_placeholder') }}">
                                    @error('contact_phone')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('public_demands.contact_email') }}</label>
                                <input type="email" wire:model="contact_email"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="{{ __('public_demands.email_placeholder') }}">
                                @error('contact_email')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-blue-800">
                                        {{ __('public_demands.contact_info_notice') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 pt-4 border-t">
                                <button type="button" wire:click="$set('showResponseModal', false)"
                                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                                    {{ __('public_demands.cancel') }}
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-lg hover:from-primary-700 hover:to-primary-800 shadow-lg transition">
                                    {{ __('public_demands.send_proposal') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Details Modal -->
        @if ($showDetailsModal && $selectedDemand)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showDetailsModal') }">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>

                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="inline-block w-full max-w-3xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl max-h-[90vh] overflow-y-auto">

                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">{{ __('public_demands.demand_details') }}</h3>
                            <button wire:click="$set('showDetailsModal', false)"
                                class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <!-- Header -->
                            <div class="bg-gradient-to-r from-primary-50 to-earth-50 rounded-xl p-6">
                                <div class="flex items-start space-x-4">
                                    <span class="text-5xl">{{ $selectedDemand->category->icon }}</span>
                                    <div class="flex-1">
                                        <h4 class="text-2xl font-bold text-gray-900 mb-2">{{ $selectedDemand->title }}
                                        </h4>
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold {{ $selectedDemand->urgency_badge_color }}">
                                                @if ($selectedDemand->urgency === 'high')
                                                    {{ __('public_demands.urgency_high') }}
                                                @elseif($selectedDemand->urgency === 'medium')
                                                    {{ __('public_demands.urgency_medium') }}
                                                @else
                                                    {{ __('public_demands.urgency_low') }}
                                                @endif
                                            </span>
                                            <span
                                                class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                                👁️ {{ $selectedDemand->views_count }} {{ __('public_demands.views') }}
                                            </span>
                                        </div>
                                        <p class="text-gray-700 leading-relaxed">{{ $selectedDemand->description }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Details Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center text-gray-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                            </path>
                                        </svg>
                                        <span class="text-sm font-medium">{{ __('public_demands.category') }}</span>
                                    </div>
                                    <p class="text-gray-900 font-semibold">{{ $selectedDemand->category->icon }}
                                        {{ $selectedDemand->category->name }}</p>
                                </div>

                                @if ($selectedDemand->quantity)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center text-gray-600 mb-1">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                </path>
                                            </svg>
                                            <span class="text-sm font-medium">{{ __('public_demands.quantity') }}</span>
                                        </div>
                                        <p class="text-gray-900 font-semibold">{{ $selectedDemand->quantity }}</p>
                                    </div>
                                @endif

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center text-gray-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">{{ __('public_demands.location') }}</span>
                                    </div>
                                    <p class="text-gray-900 font-semibold">{{ $selectedDemand->city }},
                                        {{ $selectedDemand->region }}</p>
                                </div>

                                @if ($selectedDemand->budget)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center text-gray-600 mb-1">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            <span class="text-sm font-medium">{{ __('public_demands.max_budget') }}</span>
                                        </div>
                                        <p class="text-gray-900 font-semibold">
                                            {{ number_format($selectedDemand->budget, 0, ',', ' ') }} FCFA</p>
                                    </div>
                                @endif

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center text-gray-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-sm font-medium">{{ __('public_demands.valid_until') }}</span>
                                    </div>
                                    <p class="text-gray-900 font-semibold">
                                        {{ $selectedDemand->validity_date->format('d/m/Y') }}
                                        ({{ $selectedDemand->validity_date->diffForHumans() }})</p>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center text-gray-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span class="text-sm font-medium">{{ __('public_demands.requester') }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2 mt-2">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($selectedDemand->user->name) }}&background=random"
                                            class="w-8 h-8 rounded-full" alt="{{ $selectedDemand->user->name }}">
                                        <span
                                            class="text-gray-900 font-semibold">{{ $selectedDemand->user->name }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="bg-primary-50 border border-primary-200 rounded-xl p-6">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div>
                                        <h5 class="font-bold text-gray-900 mb-1">{{ __('public_demands.you_can_respond') }}
                                        </h5>
                                        <p class="text-sm text-gray-600">{{ __('public_demands.respond_to_user', ['name' => $selectedDemand->user->name]) }}</p>
                                    </div>
                                    <button wire:click="openResponseModal({{ $selectedDemand->id }})"
                                        class="px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-lg hover:from-primary-700 hover:to-primary-800 shadow-lg transition whitespace-nowrap">
                                        {{ __('public_demands.respond_now') }}
                                    </button>
                                </div>
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
                        title: data.type === 'success' ? '{{ __("public_demands.success") }}' : data.type === 'error' ?
                            '{{ __("public_demands.error") }}' : '{{ __("public_demands.info") }}',
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