<div class="p-6 min-h-[70vh]">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h1 class="text-3xl font-bold text-base">Gestion des Abonnés</h1>
            <button wire:click='bulkSendEmail' 
               class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200">
                ✉️ Envoyer une Newsletter
            </button>
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Search & Filters -->
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-1">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="🔍 Rechercher par nom ou email..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        >
                    </div>
                    <div class="flex gap-2">
                        <select wire:model.live="filter" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary-500">
                            <option value="all">Tous les abonnés</option>
                            <option value="active">✅ Abonnés actifs</option>
                            <option value="unsubscribed">❌ Désabonnés</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Bulk Actions -->
            @if(count($selectedSubscribers) > 0)
                <div class="p-2 bg-yellow-50 border-b border-yellow-200 flex items-center justify-between">
                    <span class="text-sm text-yellow-800">
                        {{ count($selectedSubscribers) }} abonné(s) sélectionné(s)
                    </span>
                    <button
                        wire:click="deleteSelected"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-1 px-3 rounded-md transition duration-200"
                    >
                        🗑️ Supprimer la sélection
                    </button>
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left w-8">
                                <input type="checkbox" wire:model.live="selectAll">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" wire:click="sortBy('name')">
                                Nom {!! $sortField === 'name' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' !!}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" wire:click="sortBy('email')">
                                Email {!! $sortField === 'email' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' !!}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" wire:click="sortBy('created_at')">
                                Date d'inscription {!! $sortField === 'created_at' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' !!}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($subscribers as $subscriber)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" value="{{ $subscriber->id }}" wire:model="selectedSubscribers">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $subscriber->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $subscriber->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $subscriber->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $subscriber->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $subscriber->isActive() ? 'Abonné' : 'Désabonné' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button
                                        wire:click="confirmDelete({{ $subscriber->id }})"
                                        class="text-red-600 hover:text-red-900 hover:underline"
                                    >
                                        🗑️ Supprimer
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">
                                    Aucun abonné ne correspond à votre recherche.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $subscribers->links() }}
            </div>
        </div>
    </div>

    @livewire('newsletter.admin-newsletter-send')
</div>
