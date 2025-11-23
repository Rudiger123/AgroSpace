<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white p-6 rounded-xl shadow-lg mb-6 flex space-x-4">
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Rechercher par message ou producteur..." class="flex-1 px-4 py-2 border rounded-lg">

            <select wire:model.live="statusFilter" class="px-4 py-2 border rounded-lg">
                <option value="all">Tous les Statuts</option>
                <option value="pending">En Attente</option>
                <option value="accepted">Accepté</option>
                <option value="rejected">Rejeté</option>
            </select>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($responses as $response)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $response->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $response->user->name ?? 'N/A' }} (Producteur)
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $response->demand->user->name ?? 'N/A' }} (Demandeur)
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $response->proposed_price ? number_format($response->proposed_price, 0, ',', ' ') . ' FCFA' : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $response->status_badge_color }}">
                                    {{ ucfirst($response->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                @if ($response->status === 'pending')
                                    <button wire:click="openAcceptModal({{ $response->id }})"
                                        class="text-green-600 hover:text-green-900">
                                        ✓ Accepter & Chat
                                    </button>
                                    <button wire:click="rejectResponse({{ $response->id }})"
                                        class="text-orange-600 hover:text-orange-900">
                                        ✗ Rejeter
                                    </button>
                                @endif
                                <button wire:click="contactProducer({{ $response->id }})"
                                    class="text-blue-600 hover:text-blue-900">
                                    💬 Contacter
                                </button>
                                <button onclick="..." class="text-gray-600 hover:text-gray-900">
                                    Détails
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">Aucune réponse de demande trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">{{ $responses->links() }}</div>
        </div>

    </div>

    {{-- Modal de Validation --}}
    <div x-show="$wire.showAcceptModal"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6 overflow-y-auto" style="display: none;">
        <div class="absolute inset-0 bg-gray-900 opacity-75 transition-opacity" wire:click="resetModals"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg relative z-10 p-6 sm:p-8 transform transition-all"
            @click.away="$wire.resetModals()">
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-green-100 mb-4">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
             
                <h3 class="text-xl font-bold text-gray-900">Valider cette offre à votre demande</h3>
                <p class="text-sm text-gray-500 mt-2">Vous serez rediriger vers le Chat instantané pour la communication avec le prospect</p>
            </div>
            
            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                <button wire:click="closeModals"
                    class="flex-1 px-5 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all">
                    Annuler
                </button>
                <button wire:click="acceptResponse"
                    class="flex-1 px-5 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 font-semibold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    ✅ Valider l'offre
                </button>
            </div>
        </div>
    </div>

</div>
