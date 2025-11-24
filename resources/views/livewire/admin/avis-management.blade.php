<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Avis & Évaluations</h1>
            <p class="text-gray-600 mt-2">Vue d'ensemble et modération de tous les retours consommateurs.</p>
        </div>

        <!-- Cartes Statistiques avec Stat-Card -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <x-admin.stat-card title="Avis Totaux" :value="$stats['total']" color="indigo"
                icon="<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17 20h5v-3m0 0v-3m0 3h-3m-4 2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v13a2 2 0 002 2h12zm-3-12l3 3m0 0l-3 3' />" />

            <x-admin.stat-card title="Note Moyenne" :value="$stats['moyenne'] . ' / 5'" color="green"
                icon="<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11.05 16.5a2.25 2.25 0 01-3.6 0l-.82-1.36-1.55-.22a2.25 2.25 0 01-1.25-3.83l.86-.84L4.85 8.7a2.25 2.25 0 011.02-3.66l1.36-.25 1.76-1.02a2.25 2.25 0 012.51 0l1.76 1.02 1.36.25a2.25 2.25 0 011.02 3.66l-.66 1.09.86.84a2.25 2.25 0 01-1.25 3.83l-1.55.22-.82 1.36a2.25 2.25 0 01-3.6 0z' />"
                description="Basé sur les avis visibles." />

            <x-admin.stat-card title="Avis Visibles" :value="$stats['visible']" color="yellow"
                icon="<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z' /><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' />"
                description="{{ round(($stats['visible'] / $stats['total']) * 100, 1) }}% du total." />

            <x-admin.stat-card title="Taux de Vérification" :value="$stats['verified_rate']" color="blue"
                icon="<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' />"
                description="Avis liés à des transactions réelles." />
        </div>
        <!-- Fin Cartes Statistiques -->


        <!-- Distribution des notes (ApexCharts) -->
        <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Distribution des Notes</h2>
            <div id="ratingsChart" style="height: 300px;"></div>
        </div>
        <!-- Fin Distribution des notes -->

        <!-- Filtres et Recherche -->
        <div
            class="bg-white p-6 rounded-xl shadow-lg mb-6 flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Rechercher par commentaire ou auteur..."
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition shadow-sm">

            <select wire:model.live="noteFilter"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition shadow-sm">
                <option value="all">Toutes les Notes</option>
                <option value="5">⭐ (5/5)</option>
                <option value="4">⭐⭐ (4/5)</option>
                <option value="3">⭐⭐⭐ (3/5)</option>
                <option value="2">⭐⭐⭐⭐ (2/5)</option>
                <option value="1">⭐⭐⭐⭐⭐ (1/5)</option>
            </select>

            <select wire:model.live="visibilityFilter"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition shadow-sm">
                <option value="all">Visibilité (Tous)</option>
                <option value="true">Visible</option>
                <option value="false">Masqué</option>
            </select>

            <select wire:model.live="verifiedFilter"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition shadow-sm">
                <option value="all">Vérification (Tous)</option>
                <option value="true">Vérifié</option>
                <option value="false">Non Vérifié</option>
            </select>
        </div>
        <!-- Fin Filtres et Recherche -->


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
                                Auteur (Consommateur)</th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Note</th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Commentaire</th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Visibilité</th>
                            <th class="px-6 py-3 bg-gray-50">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($avis as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $item->producer->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $item->consumer->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 flex items-center">
                                    @for ($i = 0; $i < $item->note; $i++)
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                    @for ($i = 0; $i < 5 - $item->note; $i++)
                                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ str($item->commentaire)->limit(50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->is_visible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $item->is_visible ? 'Visible' : 'Masqué' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="openDetailsModal({{ $item->id }})"
                                        class="bg-primary-50 text-primary-600 px-4 py-2 rounded-lg hover:bg-primary-100 transition font-medium text-sm">
                                        Details
                                    </button>
                                    @if (auth()->user()->isAdmin())
                                        <button wire:click="openToggleVisibilityModal({{ $item->id }})"
                                            class="text-indigo-600 hover:text-indigo-900 mr-3 transition">
                                            {{ $item->is_visible ? 'Masquer' : 'Rendre visible' }}
                                        </button>
                                        <button wire:click="openDeleteModal({{ $item->id }})"
                                            class="text-red-600 hover:text-red-900 transition">
                                            Supprimer
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500">Aucun avis trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $avis->links() }}</div>
        </div>

    </div>

    <!-- Modale de Confirmation de Visibilité -->
    <x-livewire.confirmation-modal wire:model="showToggleVisibilityModal" title="Changer la Visibilité de l'Avis"
        content="Confirmez-vous le changement de visibilité de cet avis ? Il sera {{ $selectedAvis?->is_visible ? 'masqué' : 'rendu visible' }} sur la plateforme."
        button-text="Confirmer" button-color="bg-indigo-600 hover:bg-indigo-700" wire:click="toggleVisibility"
        wire:loading.attr="disabled" />

    <!-- Modale de Confirmation de Suppression -->
    <x-livewire.confirmation-modal id="delete-avis-modal" wire:model="showDeleteModal"
        title="Supprimer l'Avis Définitivement ?"
        content="Attention ! Cette action est irréversible. Êtes-vous certain de vouloir supprimer cet avis ?"
        button-text="Supprimer Définitivement" button-color="bg-red-600 hover:bg-red-700" wire:click="deleteAvis"
        wire:loading.attr="disabled" />

    <!-- Modale des details -->
    <!-- Modale de Détails (Utilisation de la modale générique) -->
    <x-livewire.modal wire:model="showDetailsModal" maxWidth="sm:max-w-xl">
        <x-slot name="title">
            Détails de la Réponse #{{ $selectedAvis?->id }}
        </x-slot>

        @if ($selectedAvis)
            <div class="space-y-4 text-gray-700">
                <p><strong>Producteur:</strong> {{ $selectedAvis->producer->name ?? 'N/A' }}</p>
                <p><strong>Utilisateur:</strong> {{ $selectedAvis->consumer->name ?? 'N/A' }}</p>
                <p><strong>notes:</strong> <span class="font-bold text-primary-600">{{ $selectedAvis->note }}

                        Etoile(s)
                    </span></p>
                <p><strong>Statut:</strong>
                    <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->is_visible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $item->is_visible ? 'Visible' : 'Masqué' }}
                    </span>
                </p>
                <div class="bg-gray-50 p-4 rounded-lg border">
                    <p class="font-semibold mb-2">Commentaire :</p>
                    <p class="italic text-gray-600 whitespace-pre-wrap">{{ $selectedAvis->commentaire }}</p>
                </div>
                <p class="text-xs text-gray-400">Réponse créée le
                    {{ $selectedAvis->created_at->format('d/m/Y à H:i') }}</p>
            </div>
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
        <!-- Initialisation du Graphique -->
        <script>
            document.addEventListener('livewire:initialized', () => {
                // Fonction pour rendre le graphique
                function renderChart(data) {
                    var options = {
                        chart: {
                            type: 'bar',
                            height: 300,
                            toolbar: {
                                show: false
                            },
                        },
                        series: [{
                            name: 'Nombre d\'Avis',
                            data: data.data
                        }],
                        xaxis: {
                            categories: data.labels,
                            title: {
                                text: 'Note (Étoiles)'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Nombre'
                            },
                            tickAmount: Math.max(...data.data) > 5 ? 5 : Math.max(...data
                                .data) // Ticks pour la lisibilité
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        colors: ['#3B82F6'], // Blue-500
                        grid: {
                            show: false
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " avis"
                                }
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#ratingsChart"), options);
                    chart.render();
                }

                // Initialiser le graphique avec les données initiales
                let initialStats = @js($stats['distribution']);
                if (initialStats && document.getElementById('ratingsChart')) {
                    renderChart(initialStats);
                }

                // Ré-initialiser ou mettre à jour le graphique si les données Livewire changent
                Livewire.hook('element.updated', (el, component) => {
                    if (el.id === 'ratingsChart') {
                        let newStats = component.get('stats.distribution');
                        if (newStats) {
                            document.querySelector("#ratingsChart").innerHTML = ''; // Nettoyer
                            renderChart(newStats); // Rendre avec les nouvelles données
                        }
                    }
                });


            });
        </script>
    @endpush


</div>
