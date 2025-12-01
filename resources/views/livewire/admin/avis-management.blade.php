<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- En-tête amélioré -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('reviews.title') }}</h1>
                    <p class="text-gray-600 mt-2">{{ __('reviews.subtitle') }}</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-100">
                        <p class="text-sm text-blue-800 font-medium">{{ __('reviews.average_rating') }}</p>
                        <div class="flex items-center mt-1">
                            <div class="text-2xl font-bold text-blue-900">{{ $stats['moyenne'] }}/5</div>
                            <div class="ml-3 flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $stats['moyenne'] ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cartes Statistiques Modernes -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-3m0 0v-3m0 3h-3m-4 2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v13a2 2 0 002 2h12zm-3-12l3 3m0 0l-3 3"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">{{ __('reviews.total_reviews') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">{{ __('reviews.visible_reviews') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['visible'] }}</p>
                        <p class="text-xs text-green-600 font-medium mt-1">
                            {{ $stats['total'] > 0 ? round(($stats['visible'] / $stats['total']) * 100, 1) : 0 }}% {{ __('reviews.of_total') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">{{ __('reviews.hidden_reviews') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['hidden'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">{{ __('reviews.verified_reviews') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['verified'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres et Recherche Modernes -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:space-x-4 space-y-4 lg:space-y-0">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="{{ __('reviews.search_placeholder') }}"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 flex-shrink-0">
                    <select wire:model.live="noteFilter"
                        class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 rounded-lg transition duration-150 ease-in-out">
                        <option value="all">{{ __('reviews.all_ratings') }}</option>
                        <option value="5">⭐ 5/5</option>
                        <option value="4">⭐⭐ 4/5</option>
                        <option value="3">⭐⭐⭐ 3/5</option>
                        <option value="2">⭐⭐⭐⭐ 2/5</option>
                        <option value="1">⭐⭐⭐⭐⭐ 1/5</option>
                    </select>

                    <select wire:model.live="visibilityFilter"
                        class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 rounded-lg transition duration-150 ease-in-out">
                        <option value="all">{{ __('reviews.all_statuses') }}</option>
                        <option value="true">{{ __('reviews.visible') }}</option>
                        <option value="false">{{ __('reviews.hidden') }}</option>
                    </select>

                    <select wire:model.live="verifiedFilter"
                        class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 rounded-lg transition duration-150 ease-in-out">
                        <option value="all">{{ __('reviews.verification') }}</option>
                        <option value="true">{{ __('reviews.verified') }}</option>
                        <option value="false">{{ __('reviews.not_verified') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tableau Modern -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('reviews.review') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('reviews.producer') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('reviews.consumer') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('reviews.status') }}</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('reviews.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($avis as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center">
                                                @for ($i = 0; $i < $item->note; $i++)
                                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                                <span class="ml-2 text-sm font-medium text-gray-900">{{ $item->note }}/5</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">#{{ $item->id }}</div>
                                            <div class="text-sm text-gray-500 max-w-xs truncate">{{ Str::words($item->commentaire, 2) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $item->producer->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $item->consumer->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col space-y-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->is_visible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $item->is_visible ? __('reviews.visible') : __('reviews.hidden') }}
                                        </span>
                                        @if($item->is_verified)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ __('reviews.verified') }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button wire:click="openDetailsModal({{ $item->id }})"
                                            class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ __('reviews.details') }}
                                        </button>
                                        @if (auth()->user()->isAdmin())
                                            <button wire:click="openToggleVisibilityModal({{ $item->id }})"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-indigo-700 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                                {{ $item->is_visible ? __('reviews.hide') : __('reviews.show') }}
                                            </button>
                                            <button wire:click="openDeleteModal({{ $item->id }})"
                                                class="inline-flex items-center px-3 py-1.5 border border-red-300 shadow-sm text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                {{ __('reviews.delete') }}
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900 mb-2">{{ __('reviews.no_reviews_found') }}</p>
                                        <p class="text-gray-500">{{ __('reviews.no_reviews_match') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                {{ $avis->links() }}
            </div>
        </div>

    </div>

    <!-- Modales -->
    <x-livewire.confirmation-modal wire:model="showToggleVisibilityModal" 
        title="{{ __('reviews.change_visibility') }}"
        :content="__('reviews.change_visibility_content', ['visibility' => $selectedAvis?->is_visible ? __('reviews.hidden') : __('reviews.visible')])"
        button-text="{{ __('reviews.confirm') }}" 
        button-color="bg-indigo-600 hover:bg-indigo-700" 
        wire:click="toggleVisibility"
        wire:loading.attr="disabled" />

    <x-livewire.confirmation-modal wire:model="showDeleteModal"
        title="{{ __('reviews.delete_review') }}"
        content="{{ __('reviews.delete_review_content') }}"
        button-text="{{ __('reviews.delete_permanently') }}" 
        button-color="bg-red-600 hover:bg-red-700" 
        wire:click="deleteAvis"
        wire:loading.attr="disabled" />

    <x-livewire.modal wire:model="showDetailsModal" maxWidth="sm:max-w-2xl">
        <x-slot name="title">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('reviews.review_details') }} #{{ $selectedAvis?->id }}
            </div>
        </x-slot>

        @if ($selectedAvis)
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('reviews.general_info') }}</h3>
                        <dl class="mt-2 space-y-2">
                            <div>
                                <dt class="text-xs text-gray-500">{{ __('reviews.producer') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $selectedAvis->producer->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">{{ __('reviews.consumer') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $selectedAvis->consumer->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">{{ __('reviews.rating') }}</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    <div class="flex items-center">
                                        @for ($i = 0; $i < $selectedAvis->note; $i++)
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                        <span class="ml-2">{{ $selectedAvis->note }}/5</span>
                                    </div>
                                </dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('reviews.status') }}</h3>
                        <dl class="mt-2 space-y-2">
                            <div>
                                <dt class="text-xs text-gray-500">{{ __('reviews.visibility') }}</dt>
                                <dd>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $selectedAvis->is_visible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $selectedAvis->is_visible ? __('reviews.visible') : __('reviews.hidden') }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">{{ __('reviews.verification') }}</dt>
                                <dd>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $selectedAvis->is_verified ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $selectedAvis->is_verified ? __('reviews.verified') : __('reviews.not_verified') }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">{{ __('reviews.creation_date') }}</dt>
                                <dd class="text-sm text-gray-900">{{ $selectedAvis->created_at->format('d/m/Y à H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-3">{{ __('reviews.comment') }}</h3>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $selectedAvis->commentaire }}</p>
                    </div>
                </div>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">{{ __('reviews.loading_details') }}</p>
        @endif

        <x-slot name="footer">
            <div class="flex justify-end space-x-3">
                <button x-on:click="$dispatch('close')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    {{ __('reviews.close') }}
                </button>
            </div>
        </x-slot>
    </x-livewire.modal>

</div>