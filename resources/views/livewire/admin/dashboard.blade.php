<div>
    {{-- Inclure ApexCharts depuis CDN --}}
    @push('styles')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <style>
            .agrospace-gradient {
                background: linear-gradient(135deg, #1e4620 0%, #2d5a2f 50%, #3a7040 100%);
            }
            .agrospace-card {
                background: linear-gradient(to bottom right, #ffffff 0%, #f8faf7 100%);
                border-left: 4px solid #2d5a2f;
                transition: all 0.3s ease;
            }
            .agrospace-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 24px rgba(45, 90, 47, 0.15);
            }
            .stat-icon-wrapper {
                background: linear-gradient(135deg, #d4e7d4 0%, #e8f5e8 100%);
                transition: all 0.3s ease;
            }
            .agrospace-card:hover .stat-icon-wrapper {
                transform: scale(1.1) rotate(5deg);
            }
            .chart-card {
                background: white;
                border-radius: 16px;
                box-shadow: 0 4px 16px rgba(30, 70, 32, 0.08);
                border: 1px solid #e8f5e8;
                transition: all 0.3s ease;
            }
            .chart-card:hover {
                box-shadow: 0 8px 24px rgba(30, 70, 32, 0.12);
            }
            .agrospace-badge {
                background: linear-gradient(135deg, #2d5a2f 0%, #3a7040 100%);
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 20px;
                font-weight: 600;
                display: inline-block;
                box-shadow: 0 2px 8px rgba(45, 90, 47, 0.3);
            }
            .table-header {
                background: linear-gradient(to right, #f0f7f0 0%, #e8f5e8 100%);
                border-bottom: 2px solid #2d5a2f;
            }
            .status-badge {
                padding: 0.375rem 0.75rem;
                border-radius: 12px;
                font-size: 0.813rem;
                font-weight: 600;
                letter-spacing: 0.3px;
            }
        </style>
    @endpush

    {{-- En-tête Hero avec gradient AgroSpace --}}
    <div class="agrospace-gradient py-8 mb-8 shadow-lg">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">
                    🌾 Bienvenue sur AgroSpace
                </h1>
                <p class="text-xl text-green-100">
                    Votre écosystème agropastoral intelligent
                </p>
            </div>
        </div>
    </div>

    <div class="pb-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Cartes de statistiques AgroSpace -->
            <div class="grid grid-cols-1 gap-6 mb-10 md:grid-cols-2 lg:grid-cols-4">
                <!-- Carte : Utilisateurs (Admin) -->
                @if (auth()->user()->isAdmin())
                    <div class="agrospace-card p-7 rounded-2xl shadow-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-green-700 uppercase tracking-wide mb-2">Utilisateurs Totaux</p>
                                <p class="text-4xl font-bold text-green-900">{{ App\Models\User::count() }}</p>
                                <p class="text-xs text-green-600 mt-2">👥 Communauté active</p>
                            </div>
                            <div class="stat-icon-wrapper p-4 rounded-2xl">
                                <svg class="w-10 h-10 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Carte : Offres (Admin/Producer) -->
                @if (auth()->user()->isAdmin() || auth()->user()->isProducer())
                    <div class="agrospace-card p-7 rounded-2xl shadow-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-green-700 uppercase tracking-wide mb-2">Offres Actives</p>
                                <p class="text-4xl font-bold text-green-900">
                                    @if (auth()->user()->isAdmin())
                                        {{ App\Models\Offer::where('statut', 'active')->count() }}
                                    @else
                                        {{ auth()->user()->offers()->where('statut', 'active')->count() }}
                                    @endif
                                </p>
                                <p class="text-xs text-green-600 mt-2">📦 Produits disponibles</p>
                            </div>
                            <div class="stat-icon-wrapper p-4 rounded-2xl">
                                <svg class="w-10 h-10 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Carte : Demandes (Admin/Consumer) -->
                @if (auth()->user()->isAdmin() || auth()->user()->isConsumer())
                    <div class="agrospace-card p-7 rounded-2xl shadow-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-green-700 uppercase tracking-wide mb-2">Demandes Actives</p>
                                <p class="text-4xl font-bold text-green-900">
                                    @if (auth()->user()->isAdmin())
                                        {{ App\Models\Demand::where('status', 'active')->count() }}
                                    @else
                                        {{ auth()->user()->demands()->where('status', 'active')->count() }}
                                    @endif
                                </p>
                                <p class="text-xs text-green-600 mt-2">🔍 Recherches en cours</p>
                            </div>
                            <div class="stat-icon-wrapper p-4 rounded-2xl">
                                <svg class="w-10 h-10 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Carte : Mes Offres (Producer) -->
                @if (auth()->user()->isProducer())
                    <div class="agrospace-card p-7 rounded-2xl shadow-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-green-700 uppercase tracking-wide mb-2">Mes Offres</p>
                                <p class="text-4xl font-bold text-green-900">
                                    {{ auth()->user()->offers()->count() }}
                                </p>
                                <p class="text-xs text-green-600 mt-2">🌱 Catalogue complet</p>
                            </div>
                            <div class="stat-icon-wrapper p-4 rounded-2xl">
                                <svg class="w-10 h-10 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Graphiques Analytics -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">

                <!-- Graphiques Admin -->
                @if (auth()->user()->isAdmin())
                    <div class="chart-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-green-900">📈 Évolution des Offres & Demandes</h3>
                            <span class="agrospace-badge text-xs">12 mois</span>
                        </div>
                        <div id="offersDemandsChart"></div>
                    </div>

                    <div class="chart-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-green-900">🗺️ Offres par Région</h3>
                            <span class="agrospace-badge text-xs">Distribution</span>
                        </div>
                        <div id="regionDistributionChart"></div>
                    </div>

                    <div class="chart-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-green-900">👥 Répartition des Utilisateurs</h3>
                            <span class="agrospace-badge text-xs">Par rôle</span>
                        </div>
                        <div id="usersRoleChart"></div>
                    </div>

                    <div class="chart-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-green-900">⚡ Activité Récente</h3>
                            <span class="agrospace-badge text-xs">30 jours</span>
                        </div>
                        <div id="activityChart"></div>
                    </div>
                @endif

                <!-- Graphiques Producteur -->
                @if (auth()->user()->isProducer())
                    <div class="chart-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-green-900">📊 Performance des Offres</h3>
                            <span class="agrospace-badge text-xs">Top 8</span>
                        </div>
                        <div id="offersPerformanceChart"></div>
                    </div>

                    <div class="chart-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-green-900">⭐ Distribution des Notes</h3>
                            <span class="agrospace-badge text-xs">Avis clients</span>
                        </div>
                        <div id="ratingsDistributionChart"></div>
                    </div>

                    <div class="chart-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-green-900">🏷️ Ventes par Catégorie</h3>
                            <span class="agrospace-badge text-xs">Performance</span>
                        </div>
                        <div id="salesCategoryChart"></div>
                    </div>

                    <div class="chart-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-green-900">📞 Contacts Reçus</h3>
                            <span class="agrospace-badge text-xs">30 jours</span>
                        </div>
                        <div id="contactsChart"></div>
                    </div>
                @endif

                <!-- Graphiques Consommateur -->
                @if (auth()->user()->isConsumer())
                    <div class="chart-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-green-900">📋 Mes Demandes</h3>
                            <span class="agrospace-badge text-xs">12 mois</span>
                        </div>
                        <div id="demandsChart"></div>
                    </div>

                    <div class="chart-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-green-900">💰 Budget vs Prix Proposés</h3>
                            <span class="agrospace-badge text-xs">Comparaison</span>
                        </div>
                        <div id="budgetComparisonChart"></div>
                    </div>

                    <div class="chart-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-green-900">✉️ Réponses aux Demandes</h3>
                            <span class="agrospace-badge text-xs">Statut</span>
                        </div>
                        <div id="responsesChart"></div>
                    </div>

                    <div class="chart-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-green-900">🔍 Activité de Recherche</h3>
                            <span class="agrospace-badge text-xs">30 jours</span>
                        </div>
                        <div id="consumerActivityChart"></div>
                    </div>
                @endif
            </div>

            <!-- Tableaux de données -->
            <div class="mt-10">

                <!-- Section Offres Récentes (Admin/Producer) -->
                @if (auth()->user()->isAdmin() || auth()->user()->isProducer())
                    <div class="chart-card p-8 mb-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-green-900">
                                🌿 {{ auth()->user()->isAdmin() ? 'Offres Récentes' : 'Mes Offres Récentes' }}
                            </h3>
                            <span class="text-sm text-green-600 font-semibold">Dernières 5 entrées</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="table-header">
                                        <th class="px-6 py-4 text-left text-sm font-bold text-green-900 uppercase tracking-wider">
                                            Titre</th>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-green-900 uppercase tracking-wider">
                                            Prix</th>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-green-900 uppercase tracking-wider">
                                            Statut</th>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-green-900 uppercase tracking-wider">
                                            Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-green-100">
                                    @php
                                        $recentOffers = auth()->user()->isAdmin()
                                            ? App\Models\Offer::latest()->take(5)->get()
                                            : auth()->user()->offers()->latest()->take(5)->get();
                                    @endphp

                                    @forelse ($recentOffers as $offer)
                                        <tr class="hover:bg-green-50 transition-colors duration-150">
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                                {{ $offer->titre }}</td>
                                            <td class="px-6 py-4 text-sm font-bold text-green-700">
                                                {{ number_format($offer->prix, 0, ',', ' ') }} FCFA</td>
                                            <td class="px-6 py-4">
                                                <span class="status-badge
                                            {{ $offer->statut === 'active' ? 'bg-green-100 text-green-800' : ($offer->statut === 'en attente' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ ucfirst($offer->statut) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $offer->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center">
                                                <div class="text-green-600">
                                                    <svg class="mx-auto h-12 w-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                    </svg>
                                                    <p class="text-sm font-medium">Aucune offre disponible pour le moment</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- Section Demandes Récentes (Admin/Consumer) -->
                @if (auth()->user()->isAdmin() || auth()->user()->isConsumer())
                    <div class="chart-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-green-900">
                                📝 {{ auth()->user()->isAdmin() ? 'Demandes Récentes' : 'Mes Demandes Récentes' }}
                            </h3>
                            <span class="text-sm text-green-600 font-semibold">Dernières 5 entrées</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="table-header">
                                        <th class="px-6 py-4 text-left text-sm font-bold text-green-900 uppercase tracking-wider">
                                            Titre</th>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-green-900 uppercase tracking-wider">
                                            Budget</th>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-green-900 uppercase tracking-wider">
                                            Urgence</th>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-green-900 uppercase tracking-wider">
                                            Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-green-100">
                                    @php
                                        $recentDemands = auth()->user()->isAdmin()
                                            ? App\Models\Demand::latest()->take(5)->get()
                                            : auth()->user()->demands()->latest()->take(5)->get();
                                    @endphp

                                    @forelse ($recentDemands as $demand)
                                        <tr class="hover:bg-green-50 transition-colors duration-150">
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                                {{ $demand->title }}</td>
                                            <td class="px-6 py-4 text-sm font-bold text-green-700">
                                                {{ number_format($demand->budget, 0, ',', ' ') }} FCFA</td>
                                            <td class="px-6 py-4">
                                                <span class="status-badge
                                            {{ $demand->urgency === 'high' ? 'bg-red-100 text-red-800' : ($demand->urgency === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                    {{ ucfirst($demand->urgency) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="status-badge
                                            {{ $demand->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($demand->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center">
                                                <div class="text-green-600">
                                                    <svg class="mx-auto h-12 w-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    <p class="text-sm font-medium">Aucune demande disponible pour le moment</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Palette de couleurs AgroSpace
                const agroColors = {
                    primary: '#2d5a2f',      // Vert profond
                    secondary: '#3a7040',    // Vert moyen
                    success: '#4a8f4d',      // Vert clair
                    accent: '#8b7355',       // Beige terre
                    light: '#d4e7d4',        // Vert très clair
                    gradient1: ['#1e4620', '#2d5a2f', '#3a7040'],
                    gradient2: ['#3a7040', '#4a8f4d', '#5da860']
                };

                @if (auth()->user()->isAdmin())
                    // Graphique Évolution Offres/Demandes
                    new ApexCharts(document.querySelector("#offersDemandsChart"), {
                        series: [{
                            name: 'Offres',
                            data: {!! json_encode($stats['offers_trend'] ?? []) !!}
                        }, {
                            name: 'Demandes',
                            data: {!! json_encode($stats['demands_trend'] ?? []) !!}
                        }],
                        chart: { 
                            height: 350, 
                            type: 'line', 
                            zoom: { enabled: false },
                            toolbar: { show: true },
                            fontFamily: 'Inter, sans-serif'
                        },
                        colors: [agroColors.primary, agroColors.success],
                        stroke: { curve: 'smooth', width: 4 },
                        xaxis: { 
                            categories: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                            labels: { style: { colors: agroColors.primary, fontWeight: 600 } }
                        },
                        yaxis: { labels: { style: { colors: agroColors.primary, fontWeight: 600 } } },
                        legend: { 
                            position: 'top',
                            labels: { colors: agroColors.primary }
                        },
                        grid: { borderColor: agroColors.light }
                    }).render();

                    // Graphique Répartition par région
                    new ApexCharts(document.querySelector("#regionDistributionChart"), {
                        series: {!! json_encode($stats['region_distribution'] ?? []) !!},
                        chart: { type: 'donut', height: 350 },
                        labels: ['Centre', 'Littoral', 'Ouest', 'Nord', 'Adamaoua', 'Est', 'Sud', 'Nord-Ouest', 'Sud-Ouest', 'Extrême-Nord'],
                        colors: ['#1e4620', '#2d5a2f', '#3a7040', '#4a8f4d', '#5da860', '#8b7355', '#a68a6a', '#c1a080', '#d4b896', '#e8cfac'],
                        legend: { 
                            position: 'bottom',
                            labels: { colors: agroColors.primary }
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            color: agroColors.primary,
                                            fontSize: '18px',
                                            fontWeight: 700
                                        }
                                    }
                                }
                            }
                        }
                    }).render();

                    // Graphique Utilisateurs par rôle
                    new ApexCharts(document.querySelector("#usersRoleChart"), {
                        series: {!! json_encode($stats['users_by_role'] ?? []) !!},
                        chart: { type: 'pie', height: 350 },
                        labels: ['Producteurs', 'Consommateurs', 'Admins'],
                        colors: [agroColors.primary, agroColors.success, agroColors.accent],
                        legend: { 
                            position: 'bottom',
                            labels: { colors: agroColors.primary }
                        }
                    }).render();

                    // Graphique Activité
                    new ApexCharts(document.querySelector("#activityChart"), {
                        series: [{ name: 'Connexions', data: {!! json_encode($stats['login_activity'] ?? []) !!} }],
                        chart: { 
                            height: 350, 
                            type: 'area',
                            toolbar: { show: true }
                        },
                        colors: [agroColors.primary],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'light',
                                type: 'vertical',
                                shadeIntensity: 0.5,
                                gradientToColors: [agroColors.light],
                                opacityFrom: 0.7,
                                opacityTo: 0.3
                            }
                        },
                        xaxis: { 
                            categories: Array.from({ length: 30 }, (_, i) => i + 1),
                            labels: { style: { colors: agroColors.primary } }
                        },
                        yaxis: { labels: { style: { colors: agroColors.primary } } },
                        stroke: { curve: 'smooth', width: 3 },
                        grid: { borderColor: agroColors.light }
                    }).render();
                @endif

                @if (auth()->user()->isProducer())
                    // Performance des offres
                    new ApexCharts(document.querySelector("#offersPerformanceChart"), {
                        series: [{
                            name: 'Vues',
                            data: {!! json_encode($stats['views_data'] ?? []) !!}
                        }, {
                            name: 'Contacts',
                            data: {!! json_encode($stats['contacts_data'] ?? []) !!}
                        }],
                        chart: { 
                            height: 350, 
                            type: 'bar',
                            toolbar: { show: true }
                        },
                        colors: [agroColors.primary, agroColors.success],
                        plotOptions: { 
                            bar: { 
                                borderRadius: 8, 
                                columnWidth: '65%',
                                dataLabels: { position: 'top' }
                            } 
                        },
                        xaxis: { 
                            categories: {!! json_encode($stats['offers_titles'] ?? []) !!},
                            labels: { 
                                style: { colors: agroColors.primary, fontWeight: 600 },
                                rotate: -45
                            }
                        },
                        yaxis: { labels: { style: { colors: agroColors.primary } } },
                        grid: { borderColor: agroColors.light }
                    }).render();

                    // Distribution des notes
                    new ApexCharts(document.querySelector("#ratingsDistributionChart"), {
                        series: [{ data: [5, 10, 15, 25, 45] }],
                        chart: { height: 350, type: 'bar' },
                        colors: [agroColors.accent],
                        plotOptions: { 
                            bar: { 
                                borderRadius: 8, 
                                columnWidth: '60%',
                                distributed: true
                            } 
                        },
                        xaxis: { 
                            categories: ['1★', '2★', '3★', '4★', '5★'],
                            labels: { style: { colors: agroColors.primary, fontSize: '14px', fontWeight: 700 } }
                        },
                        yaxis: { labels: { style: { colors: agroColors.primary } } },
                        legend: { show: false },
                        grid: { borderColor: agroColors.light }
                    }).render();

                    // Ventes par catégorie
                    new ApexCharts(document.querySelector("#salesCategoryChart"), {
                        series: {!! json_encode($stats['sales_by_category'] ?? []) !!},
                        chart: { type: 'polarArea', height: 350 },
                        labels: {!! json_encode($stats['categories'] ?? []) !!},
                        colors: agroColors.gradient2,
                        stroke: { colors: ['#fff'], width: 2 },
                        fill: { opacity: 0.85 },
                        legend: { 
                            position: 'bottom',
                            labels: { colors: agroColors.primary }
                        }
                    }).render();

                    // Contacts reçus
                    new ApexCharts(document.querySelector("#contactsChart"), {
                        series: [{ name: 'Contacts', data: {!! json_encode($stats['contacts_trend'] ?? []) !!} }],
                        chart: { 
                            height: 350, 
                            type: 'line',
                            toolbar: { show: true }
                        },
                        colors: [agroColors.success],
                        stroke: { curve: 'smooth', width: 4 },
                        markers: { size: 5, colors: [agroColors.primary] },
                        xaxis: { 
                            categories: Array.from({ length: 30 }, (_, i) => i + 1),
                            labels: { style: { colors: agroColors.primary } }
                        },
                        yaxis: { labels: { style: { colors: agroColors.primary } } },
                        grid: { borderColor: agroColors.light }
                    }).render();
                @endif

                @if (auth()->user()->isConsumer())
                    // Évolution des demandes
                    new ApexCharts(document.querySelector("#demandsChart"), {
                        series: [{
                            name: 'Demandes Actives',
                            data: {!! json_encode($stats['active_demands'] ?? []) !!}
                        }, {
                            name: 'Demandes Satisfaites',
                            data: {!! json_encode($stats['fulfilled_demands'] ?? []) !!}
                        }],
                        chart: { 
                            height: 350, 
                            type: 'area',
                            toolbar: { show: true }
                        },
                        colors: [agroColors.primary, agroColors.success],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                opacityFrom: 0.6,
                                opacityTo: 0.2
                            }
                        },
                        stroke: { curve: 'smooth', width: 3 },
                        xaxis: { 
                            categories: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                            labels: { style: { colors: agroColors.primary } }
                        },
                        yaxis: { labels: { style: { colors: agroColors.primary } } },
                        legend: { 
                            labels: { colors: agroColors.primary }
                        },
                        grid: { borderColor: agroColors.light }
                    }).render();

                    // Budget vs Prix
                    new ApexCharts(document.querySelector("#budgetComparisonChart"), {
                        series: [{
                            name: 'Budget Max',
                            data: {!! json_encode($stats['budget_data'] ?? []) !!}
                        }, {
                            name: 'Prix Moyen Proposé',
                            data: {!! json_encode($stats['proposed_prices'] ?? []) !!}
                        }],
                        chart: { 
                            height: 350, 
                            type: 'bar',
                            toolbar: { show: true }
                        },
                        colors: [agroColors.primary, agroColors.success],
                        plotOptions: { 
                            bar: { 
                                borderRadius: 8, 
                                columnWidth: '65%' 
                            } 
                        },
                        xaxis: { 
                            categories: {!! json_encode($stats['demands_titles'] ?? []) !!},
                            labels: { 
                                style: { colors: agroColors.primary },
                                rotate: -45
                            }
                        },
                        yaxis: { labels: { style: { colors: agroColors.primary } } },
                        grid: { borderColor: agroColors.light }
                    }).render();

                    // Réponses
                    new ApexCharts(document.querySelector("#responsesChart"), {
                        series: {!! json_encode($stats['responses_data'] ?? []) !!},
                        chart: { type: 'pie', height: 350 },
                        labels: ['Acceptées', 'En attente', 'Rejetées'],
                        colors: [agroColors.success, agroColors.accent, '#dc2626'],
                        legend: { 
                            position: 'bottom',
                            labels: { colors: agroColors.primary }
                        }
                    }).render();

                    // Activité
                    new ApexCharts(document.querySelector("#consumerActivityChart"), {
                        series: [{ name: 'Recherches', data: {!! json_encode($stats['search_activity'] ?? []) !!} }],
                        chart: { 
                            height: 350, 
                            type: 'line',
                            toolbar: { show: true }
                        },
                        colors: [agroColors.accent],
                        stroke: { curve: 'smooth', width: 4 },
                        markers: { size: 5, colors: [agroColors.primary] },
                        xaxis: { 
                            categories: Array.from({ length: 30 }, (_, i) => i + 1),
                            labels: { style: { colors: agroColors.primary } }
                        },
                        yaxis: { labels: { style: { colors: agroColors.primary } } },
                        grid: { borderColor: agroColors.light }
                    }).render();
                @endif
            });
        </script>
    @endpush
</div>