{{-- blog-analytics.blade.php --}}
<div class="p-6 space-y-8" x-data="{
    statsData: @js([
        'chartData' => $chartData,
        'reactionBreakdown' => $reactionBreakdown,
        'sharesPlatform' => $sharesPlatform,
    ]),
    chartViews: null,
    chartReactions: null,
    chartShares: null,

    initCharts() {
        // --- 1. Trafic (Views & Comments) Chart ---
        const trafficOptions = {
            series: [
                {
                    name: 'Vues',
                    data: this.statsData.chartData.views,
                },
                {
                    name: 'Commentaires',
                    data: this.statsData.chartData.comments,
                },
            ],
            chart: {
                type: 'area',
                height: 350,
                toolbar: { show: false },
                zoom: { enabled: false },
            },
            colors: ['#22c55e', '#f59e0b'], // Green-500 et Amber-500
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: { opacityFrom: 0.5, opacityTo: 0.1 }
            },
            xaxis: {
                categories: this.statsData.chartData.labels,
                labels: { rotate: -45, formatter: (val) => new Date(val).toLocaleDateString('fr-FR') },
                tooltip: { enabled: false }
            },
            yaxis: { title: { text: 'Compte' } },
            tooltip: {
                x: { format: 'dd MMM yyyy' },
                y: { formatter: (val) => val.toFixed(0) }
            },
            legend: { position: 'top' },
            grid: { borderColor: '#f1f1f1', strokeDashArray: 4 }
        };
        this.chartViews = new ApexCharts(document.querySelector('#trafficChart'), trafficOptions);
        this.chartViews.render();

        // --- 2. Reactions Breakdown Chart (Donut) ---
        const reactionsOptions = {
            series: this.statsData.reactionBreakdown.values,
            chart: {
                type: 'donut',
                height: 300,
            },
            labels: this.statsData.reactionBreakdown.labels,
            colors: ['#22c55e', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#a1a1aa'], // Agrospace palette
            legend: { position: 'bottom', fontSize: '12px' },
            dataLabels: {
                enabled: true,
                formatter: (val) => Math.round(val) + '%'
            },
            tooltip: { y: { formatter: (val) => val.toFixed(0) + ' réactions' } },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total J\'aime',
                                color: '#1f2937',
                                formatter: (w) => w.globals.series.reduce((a, b) => a + b, 0).toLocaleString('fr-FR')
                            }
                        }
                    }
                }
            }
        };
        this.chartReactions = new ApexCharts(document.querySelector('#reactionsChart'), reactionsOptions);
        this.chartReactions.render();
        
        // --- 3. Shares Platform Chart (Bar) ---
        const sharesOptions = {
            series: [{
                name: 'Partages',
                data: this.statsData.sharesPlatform.values,
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: { show: false },
            },
            colors: ['#16a34a'], // Green-600
            plotOptions: {
                bar: {
                    horizontal: true,
                    borderRadius: 4,
                }
            },
            dataLabels: { enabled: false },
            xaxis: {
                categories: this.statsData.sharesPlatform.labels,
                title: { text: 'Nombre de Partages' }
            },
        };
        this.chartShares = new ApexCharts(document.querySelector('#sharesChart'), sharesOptions);
        this.chartShares.render();
    },

    updateCharts(data) {
        this.statsData = data.statsData;

        // Update Traffic Chart
        this.chartViews.updateOptions({
             xaxis: { categories: this.statsData.chartData.labels },
        });
        this.chartViews.updateSeries([
            { name: 'Vues', data: this.statsData.chartData.views },
            { name: 'Commentaires', data: this.statsData.chartData.comments },
        ]);

        // Update Reactions Chart
        this.chartReactions.updateOptions({
            labels: this.statsData.reactionBreakdown.labels,
        });
        this.chartReactions.updateSeries(this.statsData.reactionBreakdown.values);
        
        // Update Shares Chart
        this.chartShares.updateOptions({
             xaxis: { categories: this.statsData.sharesPlatform.labels },
        });
        this.chartShares.updateSeries([{
            name: 'Partages',
            data: this.statsData.sharesPlatform.values,
        }]);
    }
}" x-init="initCharts" x-init="initCharts(); $wire.on('stats-updated', updateCharts)">
    
    <div class="flex items-center justify-between border-b pb-4 mb-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">🚀 {{ __('blog.analytics.title') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('blog.analytics.description') }}</p>
        </div>
        <div class="flex space-x-3">
            <button wire:click="refreshStats"
                class="flex items-center space-x-2 px-4 py-2 bg-green-600 text-white rounded-xl shadow-lg hover:bg-green-700 transition duration-300 transform hover:scale-[1.02]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                <span>{{ __('blog.analytics.refresh') }}</span>
            </button>
            <button wire:click="exportCsv"
                class="flex items-center space-x-2 px-4 py-2 bg-gray-600 text-white rounded-xl shadow-lg hover:bg-gray-700 transition duration-300 transform hover:scale-[1.02]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
                <span>{{ __('blog.analytics.export_csv') }}</span>
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
        <h2 class="text-lg font-bold text-gray-800 mb-4">{{ __('blog.analytics.filters.title') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">📅 {{ __('blog.analytics.filters.date_from') }}</label>
                <input type="date" wire:model.live="dateFrom"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">📅 {{ __('blog.analytics.filters.date_to') }}</label>
                <input type="date" wire:model.live="dateTo"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150">
            </div>
            <div class="md:col-span-2 flex items-end">
                <span class="text-xs text-gray-400">{{ __('blog.analytics.filters.selected_period', ['from' => $dateFrom ? Carbon\Carbon::parse($dateFrom)->format('d/m/Y') : 'N/A', 'to' => $dateTo ? Carbon\Carbon::parse($dateTo)->format('d/m/Y') : 'N/A']) }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">📰 {{ __('blog.analytics.filters.filter_by_post') }}</label>
                <select wire:model.live="selectedPost"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150 bg-white">
                    <option value="">{{ __('blog.analytics.filters.all_posts') }}</option>
                    @foreach ($posts as $post)
                        <option value="{{ $post->id }}">{{ Str::limit($post->title, 35) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">🧑‍💻 {{ __('blog.analytics.filters.filter_by_author') }}</label>
                <select wire:model.live="selectedAuthor"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150 bg-white">
                    <option value="">{{ __('blog.analytics.filters.all_authors') }}</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">💬 {{ __('blog.analytics.filters.comment_status') }}</label>
                <select wire:model.live="statusFilter"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150 bg-white">
                    <option value="all">{{ __('blog.analytics.filters.all_comments') }}</option>
                    <option value="approved">{{ __('blog.analytics.filters.approved') }}</option>
                    <option value="pending">{{ __('blog.analytics.filters.pending') }}</option>
                    <option value="rejected">{{ __('blog.analytics.filters.rejected') }}</option>
                    <option value="spam">{{ __('blog.analytics.filters.spam') }}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-6 gap-6">
        <div class="bg-white rounded-2xl p-5 shadow-xl border border-gray-100 lg:col-span-2">
            <p class="text-sm font-medium text-gray-500">{{ __('blog.analytics.stats.published_posts') }}</p>
            <p class="text-4xl font-extrabold text-gray-900 mt-2">{{ number_format($stats['total_posts'] ?? 0, 0, ',', ' ') }}</p>
            <div class="text-xs text-green-500 font-semibold mt-1 flex items-center">
                <span class="mr-1">📈</span> {{ __('blog.analytics.stats.filtered_coverage') }}
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-xl border border-gray-100">
            <p class="text-sm font-medium text-gray-500">{{ __('blog.analytics.stats.total_views') }}</p>
            <p class="text-3xl font-extrabold text-green-600 mt-2">{{ number_format($stats['total_views'] ?? 0, 0, ',', ' ') }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ __('blog.analytics.stats.period') }}</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-xl border border-gray-100">
            <p class="text-sm font-medium text-gray-500">{{ __('blog.analytics.stats.comments') }}</p>
            <p class="text-3xl font-extrabold text-amber-600 mt-2">{{ number_format($stats['total_comments'] ?? 0, 0, ',', ' ') }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ number_format($stats['pending_comments'] ?? 0, 0, ',', ' ') }} {{ __('blog.analytics.stats.pending') }}</p>
        </div>
        
        <div class="bg-white rounded-2xl p-5 shadow-xl border border-gray-100">
            <p class="text-sm font-medium text-gray-500">{{ __('blog.analytics.stats.total_likes') }}</p>
            <p class="text-3xl font-extrabold text-pink-600 mt-2">{{ number_format($stats['total_reactions'] ?? 0, 0, ',', ' ') }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ __('blog.analytics.stats.total_engagement') }}</p>
        </div>
        
        <div class="bg-white rounded-2xl p-5 shadow-xl border border-gray-100">
            <p class="text-sm font-medium text-gray-500">{{ __('blog.analytics.stats.total_shares') }}</p>
            <p class="text-3xl font-extrabold text-blue-600 mt-2">{{ number_format($stats['total_shares'] ?? 0, 0, ',', ' ') }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ __('blog.analytics.stats.external_visibility') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-4">📈 {{ __('blog.analytics.charts.traffic_trend') }}</h2>
        <div wire:ignore id="trafficChart"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4">❤️ {{ __('blog.analytics.charts.reaction_breakdown') }}</h2>
            <div wire:ignore id="reactionsChart"></div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4">🌐 {{ __('blog.analytics.charts.shares_by_platform') }}</h2>
            <div wire:ignore id="sharesChart"></div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4">🏆 {{ __('blog.analytics.charts.top_posts') }}</h2>
            <div class="space-y-3">
                @forelse($topPosts as $post)
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl border border-green-200 hover:bg-green-100 transition duration-150">
                        <p class="text-sm font-medium text-gray-800 truncate mr-4" title="{{ $post->title }}">
                            {{ Str::limit($post->title, 35) }}
                        </p>
                        <div class="flex items-center space-x-3 text-xs font-semibold">
                            <span class="text-gray-600 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path><path d="M15 7v4a2 2 0 01-2 2h-2l-3 3v-3H9l-3 3v-3H4a2 2 0 01-2-2V5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2h-2l-3 3v-3H4a2 2 0 01-2-2V5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2h-2l-3 3v-3H4a2 2 0 01-2-2V5z" fill-rule="evenodd" clip-rule="evenodd" d="M18 10a2 2 0 00-2-2h-3a2 2 0 00-2 2v4a2 2 0 002 2h3a2 2 0 002-2v-4z"></path></svg>
                                {{ $post->comments_count }}
                            </span>
                            <span class="text-gray-600 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                                {{ $post->views_count }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 p-4 text-center">{{ __('blog.analytics.charts.no_articles') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>