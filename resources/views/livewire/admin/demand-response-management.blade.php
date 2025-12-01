<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- En-tête amélioré -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('demand-response.title') }}</h1>
                    <p class="text-gray-600 mt-2">{{ __('demand-response.subtitle') }}</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-lg border border-green-100">
                        <p class="text-sm text-green-800 font-medium">{{ __('demand-response.pending_responses') }}</p>
                        <div class="flex items-center mt-1">
                            <div class="text-2xl font-bold text-green-900">{{ $stats['pending'] }}</div>
                            <div class="ml-3 text-sm text-green-700">
                                {{ __('demand-response.out_of_total', ['total' => $stats['total']]) }}
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
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">{{ __('demand-response.total_responses') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">{{ __('demand-response.pending') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                        <p class="text-xs text-yellow-600 font-medium mt-1">
                            {{ $stats['total'] > 0 ? round(($stats['pending'] / $stats['total']) * 100, 1) : 0 }}% {{ __('demand-response.of_total') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">{{ __('demand-response.accepted') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['accepted'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">{{ __('demand-response.rejected') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['rejected'] }}</p>
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
                            placeholder="{{ __('demand-response.search_placeholder') }}"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out">
                    </div>
                </div>
                
                <div class="flex-shrink-0">
                    <select wire:model.live="statusFilter"
                        class="block w-full lg:w-48 pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 rounded-lg transition duration-150 ease-in-out">
                        <option value="all">{{ __('demand-response.all_statuses') }}</option>
                        <option value="pending">{{ __('demand-response.pending') }}</option>
                        <option value="accepted">{{ __('demand-response.accepted') }}</option>
                        <option value="rejected">{{ __('demand-response.rejected') }}</option>
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('demand-response.response') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('demand-response.producer') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('demand-response.demand') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('demand-response.price') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('demand-response.status') }}</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('demand-response.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($responses as $response)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">#{{ $response->id }}</div>
                                            <div class="text-sm text-gray-500 max-w-xs truncate">{{ Str::limit($response->message, 10) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $response->user->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ Str::limit($response->demand->title, 30) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-primary-600">{{ number_format($response->proposed_price, 0, ',', ' ') }} {{ __('demand-response.currency') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'accepted' => 'bg-green-100 text-green-800', 
                                            'rejected' => 'bg-red-100 text-red-800'
                                        ];
                                        $color = $statusColors[$response->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                        {{ ucfirst(__('demand-response.' . $response->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        @if ($response->status === 'pending' && auth()->user()->isConsumer())
                                            <button wire:click="openAcceptModal({{ $response->id }})"
                                                class="inline-flex items-center px-3 py-1.5 border border-green-300 shadow-sm text-sm font-medium rounded-lg text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                {{ __('demand-response.accept') }}
                                            </button>
                                            <button wire:click="openRejectModal({{ $response->id }})"
                                                class="inline-flex items-center px-3 py-1.5 border border-red-300 shadow-sm text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                {{ __('demand-response.reject') }}
                                            </button>
                                        @elseif ($response->status === 'accepted')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ __('demand-response.validated') }}
                                            </span>
                                        @elseif ($response->status === 'rejected')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ __('demand-response.rejected') }}
                                            </span>
                                        @endif
                                        <button wire:click="openDetailsModal({{ $response->id }})"
                                            class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ __('demand-response.details') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900 mb-2">{{ __('demand-response.no_responses_found') }}</p>
                                        <p class="text-gray-500">{{ __('demand-response.no_responses_match') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                {{ $responses->links() }}
            </div>
        </div>
    
    </div>
    
    <!-- Modales -->
    <x-livewire.confirmation-modal wire:model="showAcceptModal"
        title="{{ __('demand-response.accept_offer') }}"
        content="{{ __('demand-response.accept_offer_content') }}"
        button-text="{{ __('demand-response.yes_accept_offer') }}"
        button-color="bg-green-600 hover:bg-green-700"
        wire:click="acceptResponse"
        wire:loading.attr="disabled"
    />
    
    <x-livewire.confirmation-modal wire:model="showRejectModal"
        title="{{ __('demand-response.reject_offer') }}"
        content="{{ __('demand-response.reject_offer_content') }}"
        button-text="{{ __('demand-response.yes_reject_offer') }}"
        button-color="bg-red-600 hover:bg-red-700"
        wire:click="rejectResponse"
        wire:loading.attr="disabled"
    />
    
    <x-livewire.modal wire:model="showDetailsModal" maxWidth="sm:max-w-2xl">
        <x-slot name="title">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('demand-response.response_details') }} #{{ $selectedResponseId }}
            </div>
        </x-slot>
    
        @if ($selectedResponseId)
            @php
                $response = $responses->items()[array_search($selectedResponseId, array_column($responses->items(), 'id'))] ?? null;
            @endphp
            
            @if($response)
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">{{ __('demand-response.general_info') }}</h3>
                            <dl class="mt-2 space-y-2">
                                <div>
                                    <dt class="text-xs text-gray-500">{{ __('demand-response.producer') }}</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $response->user->name ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500">{{ __('demand-response.demand') }}</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $response->demand->title ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500">{{ __('demand-response.proposed_price') }}</dt>
                                    <dd class="text-sm font-semibold text-primary-600">{{ number_format($response->proposed_price, 0, ',', ' ') }} {{ __('demand-response.currency') }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">{{ __('demand-response.status') }}</h3>
                            <dl class="mt-2 space-y-2">
                                <div>
                                    <dt class="text-xs text-gray-500">{{ __('demand-response.status') }}</dt>
                                    <dd>
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'accepted' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800'
                                            ];
                                            $color = $statusColors[$response->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                            {{ ucfirst(__('demand-response.' . $response->status)) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500">{{ __('demand-response.creation_date') }}</dt>
                                    <dd class="text-sm text-gray-900">{{ $response->created_at->format('d/m/Y à H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-3">{{ __('demand-response.producer_message') }}</h3>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $response->message }}</p>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">{{ __('demand-response.loading_details') }}</p>
            @endif
        @else
            <p class="text-gray-500 text-center py-8">{{ __('demand-response.select_response_details') }}</p>
        @endif
    
        <x-slot name="footer">
            <div class="flex justify-end space-x-3">
                <button x-on:click="$dispatch('close')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    {{ __('demand-response.close') }}
                </button>
            </div>
        </x-slot>
    </x-livewire.modal>
    
</div>