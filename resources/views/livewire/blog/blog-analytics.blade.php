<div>
    <div class="p-6 space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Statistiques du Blog</h1>
                <p class="text-sm text-gray-500 mt-1">Analyse des performances et engagement</p>
            </div>
            <div class="flex space-x-3">
                <button wire:click="refreshStats"
                    class="flex items-center space-x-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    <span>Actualiser</span>
                </button>
                <button wire:click="exportCsv"
                    class="flex items-center space-x-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span>Exporter CSV</span>
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-4 grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                <input type="date" wire:model="dateFrom"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                <input type="date" wire:model="dateTo"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Article</label>
                <select wire:model="selectedPost"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Tous les articles</option>
                    @foreach ($posts as $post)
                        <option value="{{ $post->id }}">{{ $post->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Auteur</label>
                <select wire:model="selectedAuthor"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Tous les auteurs</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut commentaires</label>
                <select wire:model="statusFilter"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="all">Tous</option>
                    <option value="pending">En attente</option>
                    <option value="approved">Approuvés</option>
                    <option value="rejected">Rejetés</option>
                    <option value="spam">Spam</option>
                </select>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-primary-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Articles publiés</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($stats['total_posts'] ?? 0) }}
                        </p>
                    </div>
                    <div class="bg-primary-100 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Commentaires</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">
                            {{ number_format($stats['total_comments'] ?? 0) }}</p>
                        <p class="text-xs text-blue-600 mt-1">{{ $stats['pending_comments'] ?? 0 }} en attente</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Vues totales</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($stats['total_views'] ?? 0) }}
                        </p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-pink-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Réactions</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">
                            {{ number_format($stats['total_reactions'] ?? 0) }}</p>
                        <p class="text-xs text-pink-600 mt-1">{{ $stats['total_shares'] ?? 0 }} partages</p>
                    </div>
                    <div class="bg-pink-100 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Views Chart -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Vues quotidiennes</h3>
                <div id="viewsChart" style="height: 300px;"></div>
            </div>

            <!-- Reactions Breakdown -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Répartition des réactions</h3>
                <div id="reactionsChart" style="height: 300px;"></div>
            </div>
        </div>

        <!-- Top Posts Table -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Top 5 des articles</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Article</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Vues</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Commentaires</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Réactions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topPosts as $post)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-800">{{ $post['title'] }}</td>
                                <td class="py-3 px-4 text-sm text-center font-semibold text-purple-600">
                                    {{ number_format($post['views']) }}</td>
                                <td class="py-3 px-4 text-sm text-center font-semibold text-blue-600">
                                    {{ number_format($post['comments']) }}</td>
                                <td class="py-3 px-4 text-sm text-center font-semibold text-pink-600">
                                    {{ number_format($post['reactions']) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">Aucun article trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Shares by Platform -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Partages par plateforme</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($sharesPlatform as $platform => $count)
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($count) }}</p>
                        <p class="text-sm text-gray-600 capitalize mt-1">{{ $platform }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Chart Data JSON -->
        <script type="application/json" id="stats-data">
            {!! json_encode([
                'views' => [
                    'dates' => $chartData['dates'] ?? [],
                    'values' => $chartData['views'] ?? []
                ],
                'reactions' => [
                    'labels' => array_keys($reactionBreakdown->toArray()),
                    'values' => array_values($reactionBreakdown->toArray())
                ]
            ]) !!}
        </script>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const statsData = JSON.parse(document.getElementById('stats-data').textContent);

                // Views Chart
                const viewsOptions = {
                    series: [{
                        name: 'Vues',
                        data: statsData.views.values
                    }],
                    chart: {
                        type: 'area',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#22c55e'],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.4,
                            opacityTo: 0.1,
                        }
                    },
                    xaxis: {
                        categories: statsData.views.dates,
                        labels: {
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: (val) => val + ' vues'
                        }
                    }
                };
                new ApexCharts(document.querySelector("#viewsChart"), viewsOptions).render();

                // Reactions Chart
                const reactionsOptions = {
                    series: statsData.reactions.values,
                    chart: {
                        type: 'donut',
                        height: 300
                    },
                    labels: statsData.reactions.labels,
                    colors: ['#22c55e', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6'],
                    legend: {
                        position: 'bottom',
                        fontSize: '12px'
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val) {
                            return Math.round(val) + '%'
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: (val) => val + ' réactions'
                        }
                    }
                };
                new ApexCharts(document.querySelector("#reactionsChart"), reactionsOptions).render();
            });

            window.addEventListener('stats-refreshed', () => {
                location.reload();
            });
        </script>
    @endpush
</div>
