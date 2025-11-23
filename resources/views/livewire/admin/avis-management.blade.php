<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Avis & Évaluations</h1>
            <p class="text-gray-600 mt-2">Vue d'ensemble et modération de tous les retours consommateurs.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-xl shadow-md border-t-4 border-indigo-500">
                <p class="text-sm font-medium text-gray-500">Avis Totaux</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-t-4 border-green-500">
                <p class="text-sm font-medium text-gray-500">Note Moyenne</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $stats['moyenne'] }} / 5</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-t-4 border-yellow-500">
                <p class="text-sm font-medium text-gray-500">Avis Visibles</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $stats['visible'] }}</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-t-4 border-blue-500">
                <p class="text-sm font-medium text-gray-500">Taux Vérifié</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ round(($stats['verified_rate'] / max(1, $stats['total'])) * 100) }}%</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Distribution des Notes</h3>
            {{-- Intégration du graphique ApexCharts --}}
            <div x-data="{
                chart: null,
                init() {
                    let data = @js($stats['distribution']['data']);
                    let labels = @js($stats['distribution']['labels']);
                    
                    this.chart = new ApexCharts(this.$refs.chart, {
                        series: [{
                            name: 'Nombre d\'avis',
                            data: data
                        }],
                        chart: { type: 'bar', height: 350, toolbar: { show: false } },
                        plotOptions: { bar: { horizontal: false, columnWidth: '70%', endingShape: 'rounded' } },
                        dataLabels: { enabled: false },
                        stroke: { show: true, width: 2, colors: ['transparent'] },
                        xaxis: { categories: labels },
                        fill: { opacity: 1, colors: ['#4f46e5'] },
                        tooltip: { y: { formatter: function (val) { return val + ' avis' } } }
                    }).render();
                }
            }" x-init="init" class="mt-4">
                <div x-ref="chart"></div>
            </div>
            {{-- Ajoutez le CDN d'ApexCharts dans votre layout principal pour que cela fonctionne --}}
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg mb-6 flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher par commentaire, producteur ou consommateur..."
                class="flex-1 px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            
            <select wire:model.live="noteFilter" class="px-4 py-2 border rounded-lg">
                <option value="all">Toutes les notes</option>
                <option value="5">⭐ (5/5)</option>
                <option value="4">⭐⭐ (4/5)</option>
                <option value="3">⭐⭐⭐ (3/5)</option>
                <option value="2">⭐⭐⭐⭐ (2/5)</option>
                <option value="1">⭐⭐⭐⭐⭐ (1/5)</option>
            </select>
            
            <select wire:model.live="visibilityFilter" class="px-4 py-2 border rounded-lg">
                <option value="all">Visibilité</option>
                <option value="true">Visible</option>
                <option value="false">Masqué</option>
            </select>
            
            <select wire:model.live="verifiedFilter" class="px-4 py-2 border rounded-lg">
                <option value="all">Type</option>
                <option value="true">Achat Vérifié</option>
                <option value="false">Non Vérifié</option>
            </select>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($avis as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $item->producer->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $item->consumer->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <span class="text-yellow-500 font-bold">{{ $item->note }}</span>/5
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ str($item->commentaire)->limit(50) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->is_visible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $item->is_visible ? 'Visible' : 'Masqué' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="openToggleVisibilityModal({{ $item->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    {{ $item->is_visible ? 'Masquer' : 'Rendre visible' }}
                                </button>
                                <button onclick="..." class="text-red-600 hover:text-red-900">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-8 text-gray-500">Aucun avis trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">{{ $avis->links() }}</div>
        </div>
        
        </div>
</div>