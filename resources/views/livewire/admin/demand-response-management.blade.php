<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white p-6 rounded-xl shadow-lg mb-6 flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
    <input type="text" wire:model.live.debounce.300ms="search"
    placeholder="Rechercher par message ou producteur..."
    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition shadow-sm">
    
            <select wire:model.live="statusFilter"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition shadow-sm">
                <option value="all">Tous les Statuts</option>
                <option value="pending">En Attente</option>
                <option value="accepted">Accepté</option>
                <option value="rejected">Rejeté</option>
            </select>
        </div>
    
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Producteur</th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Demande Concernée</th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prix Proposé</th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut</th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($responses as $response)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $response->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $response->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $response->demand->title ?? 'Demande supprimée' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-primary-600">
                                    {{ number_format($response->proposed_price, 0, ',', ' ') }} F CFA
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $response->status_badge_color }}">
                                        {{ ucfirst($response->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if ($response->status === 'pending' && auth()->user()->isConsumer())
                                        <button wire:click="openAcceptModal({{ $response->id }})"
                                            class="text-green-600 hover:text-green-900 mr-3 transition">Accepter</button>
                                        <button wire:click="openRejectModal({{ $response->id }})"
                                            class="text-red-600 hover:text-red-900 transition">Rejeter</button>
                                    @elseif ($response->status === 'accepted')
                                        <span class="text-gray-500 italic">Validée</span>
                                    @elseif ($response->status === 'rejected')
                                        <span class="text-gray-500 italic">Rejetée</span>
                                    @endif
                                    <button wire:click="openDetailsModal({{ $response->id }})"
                                        class="text-indigo-600 hover:text-indigo-900 ml-3 transition">Détails</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">Aucune réponse trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $responses->links() }}</div>
        </div>
    
    </div>
    
    <!-- Modale de Confirmation d'ACCEPTATION -->
    <x-livewire.confirmation-modal wire:model="showAcceptModal"
        title="Accepter cette Offre ?"
        content="En acceptant, la réponse sera marquée comme 'acceptée' et une conversation de chat instantané sera créée entre le consommateur (vous) et le producteur. Le producteur sera notifié par email."
        button-text="Oui, Accepter l'Offre"
        button-color="bg-green-600 hover:bg-green-700"
        wire:click="acceptResponse"
        wire:loading.attr="disabled"
    />
    
    <!-- Modale de Confirmation de REJET -->
    <x-livewire.confirmation-modal wire:model="showRejectModal"
        title="Rejeter cette Offre ?"
        content="Confirmez-vous le rejet de cette réponse ? Le statut passera à 'rejeté' et le producteur en sera informé par email. Cette action est irréversible."
        button-text="Oui, Rejeter l'Offre"
        button-color="bg-red-600 hover:bg-red-700"
        wire:click="rejectResponse"
        wire:loading.attr="disabled"
    />
    
    <!-- Modale de Détails (Utilisation de la modale générique) -->
    <x-livewire.modal wire:model="showDetailsModal" maxWidth="sm:max-w-xl">
        <x-slot name="title">
            Détails de la Réponse #{{ $selectedResponseId }}
        </x-slot>
    
        @if ($selectedResponseId)
            @php
                $response = $responses->items()[array_search($selectedResponseId, array_column($responses->items(), 'id'))] ?? null;
            @endphp
            
            @if($response)
                <div class="space-y-4 text-gray-700">
                    <p><strong>Producteur:</strong> {{ $response->user->name ?? 'N/A' }}</p>
                    <p><strong>Demande:</strong> {{ $response->demand->titre ?? 'N/A' }}</p>
                    <p><strong>Prix Proposé:</strong> <span class="font-bold text-primary-600">{{ number_format($response->proposed_price, 0, ',', ' ') }} F CFA</span></p>
                    <p><strong>Statut:</strong> <span class="font-semibold text-sm px-2 py-1 rounded-full {{ $response->status_badge_color }}">{{ ucfirst($response->status) }}</span></p>
                    <div class="bg-gray-50 p-4 rounded-lg border">
                        <p class="font-semibold mb-2">Message du Producteur:</p>
                        <p class="italic text-gray-600 whitespace-pre-wrap">{{ $response->message }}</p>
                    </div>
                    <p class="text-xs text-gray-400">Réponse créée le {{ $response->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            @else
                <p>Chargement des détails...</p>
            @endif
        @else
            <p>Sélectionnez une réponse pour voir les détails.</p>
        @endif
    
        <x-slot name="footer">
             <button x-on:click="$dispatch('close')"
                class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:w-auto sm:text-sm transition duration-150 ease-in-out">
                Fermer
            </button>
        </x-slot>
    </x-livewire.modal>
    
    
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('alert', (event) => {
                    const data = event[0] || event;
                    Swal.fire({
                        icon: data.type,
                        title: data.type === 'success' ? 'Succès !' : data.type === 'error' ?
                            'Erreur !' : data.type === 'warning' ? 'Attention !' : 'Information',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                    });
                });
    
                // Écouteur pour fermer la modale après redirection/action réussie
                Livewire.on('toast', (event) => {
                    const data = event[0] || event;
                    Swal.fire({
                        icon: data.type,
                        title: data.message,
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