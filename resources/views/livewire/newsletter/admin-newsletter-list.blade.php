<div class="p-6 space-y-8" x-data="{
    statsData: @js(['chartData' => $chartData, 'statusBreakdown' => $statusBreakdown]),
    chartSubscriptions: null,
    chartStatus: null,

    initCharts() {
        const primaryColor = '#22c55e'; // Green 500
        const primaryColor600 = '#16a34a';

        // --- 1. Subscription Trend Chart (Line/Area) ---
        const subscriptionsOptions = {
            series: [
                {
                    name: '{{ __("newsletter.subscriptions") }}',
                    data: this.statsData.chartData.subscriptions,
                },
                {
                    name: '{{ __("newsletter.unsubscriptions") }}',
                    data: this.statsData.chartData.unsubscriptions,
                },
            ],
            chart: {
                type: 'area',
                height: 350,
                toolbar: { show: false },
                zoom: { enabled: false },
            },
            colors: [primaryColor, '#ef4444'], // Vert Agrospace et Rouge Alerte
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
            yaxis: { title: { text: '{{ __("newsletter.number") }}' } },
            tooltip: {
                x: { format: 'dd MMM yyyy' },
                y: { formatter: (val) => val.toFixed(0) }
            },
            legend: { position: 'top' },
            grid: { borderColor: '#f1f1f1', strokeDashArray: 4 }
        };
        this.chartSubscriptions = new ApexCharts(document.querySelector('#subscriptionsChart'), subscriptionsOptions);
        this.chartSubscriptions.render();

        // --- 2. Status Breakdown Chart (Donut) ---
        const statusOptions = {
            series: this.statsData.statusBreakdown.values,
            chart: {
                type: 'donut',
                height: 300,
            },
            labels: this.statsData.statusBreakdown.labels,
            colors: [primaryColor600, '#a1a1aa'], // Vert 600 (active) et Gris 500 (unsubscribed)
            legend: { position: 'bottom', fontSize: '12px' },
            dataLabels: {
                enabled: true,
                formatter: (val) => Math.round(val) + '%'
            },
            tooltip: { y: { formatter: (val) => val.toFixed(0) + ' abonnés' } },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: '{{ __("newsletter.total_subscribers") }}',
                                color: '#1f2937',
                                formatter: (w) => w.globals.series.reduce((a, b) => a + b, 0).toLocaleString('fr-FR')
                            }
                        }
                    }
                }
            }
        };
        this.chartStatus = new ApexCharts(document.querySelector('#statusChart'), statusOptions);
        this.chartStatus.render();
    },

    updateCharts(event) {
        const data = event.detail.statsData;
        this.statsData = data;

        // Update Subscription Chart
        this.chartSubscriptions.updateOptions({
             xaxis: { categories: this.statsData.chartData.labels },
        });
        this.chartSubscriptions.updateSeries([
            { name: '{{ __("newsletter.subscriptions") }}', data: this.statsData.chartData.subscriptions },
            { name: '{{ __("newsletter.unsubscriptions") }}', data: this.statsData.chartData.unsubscriptions },
        ]);

        // Update Status Chart
        this.chartStatus.updateOptions({
            labels: this.statsData.statusBreakdown.labels,
        });
        this.chartStatus.updateSeries(this.statsData.statusBreakdown.values);
    }
}" x-init="initCharts" x-init="initCharts(); $wire.on('stats-updated', updateCharts)">
    
    <div class="flex items-center justify-between border-b pb-4 mb-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">📊 {{ __("newsletter.dashboard_title") }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __("newsletter.dashboard_subtitle") }}</p>
        </div>
        <div class="flex space-x-3">
            <button wire:click="bulkSendEmail"
                class="flex items-center space-x-2 px-6 py-3 bg-green-600 text-white rounded-xl shadow-lg hover:bg-green-700 transition duration-300 transform hover:scale-[1.02]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span>{{ __("newsletter.send_newsletter") }}</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-5 shadow-xl border border-gray-100">
            <p class="text-sm font-medium text-gray-500">{{ __("newsletter.total_subscribers") }}</p>
            <p class="text-4xl font-extrabold text-gray-900 mt-2">{{ $stats['total'] ?? 0 }}</p>
            <div class="text-xs text-gray-400 font-semibold mt-1 flex items-center">
                {{ __("newsletter.total_subscribers_hint") }}
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-xl border border-gray-100">
            <p class="text-sm font-medium text-gray-500">{{ __("newsletter.active_subscribers") }}</p>
            <p class="text-4xl font-extrabold text-green-600 mt-2">{{ $stats['active'] ?? 0 }}</p>
            <div class="text-xs text-green-500 font-semibold mt-1 flex items-center">
                {{ $stats['active_percentage'] ?? 0 }}% {{ __("newsletter.of_list") }}
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-xl border border-gray-100">
            <p class="text-sm font-medium text-gray-500">{{ __("newsletter.unsubscribed") }}</p>
            <p class="text-4xl font-extrabold text-red-600 mt-2">{{ $stats['unsubscribed'] ?? 0 }}</p>
            <div class="text-xs text-gray-400 font-semibold mt-1 flex items-center">
                {{ __("newsletter.excluded") }}
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-xl border border-gray-100">
            <p class="text-sm font-medium text-gray-500">{{ __("newsletter.activity_rate") }}</p>
            <p class="text-4xl font-extrabold text-blue-600 mt-2">{{ $stats['active_percentage'] ?? 0 }}%</p>
            <div class="text-xs text-gray-400 font-semibold mt-1 flex items-center">
                ({{ __("newsletter.active_over_total") }})
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">📈 {{ __("newsletter.subscription_trend") }}</h2>
                <select wire:model.live="dateRange" class="px-3 py-1 text-sm border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    <option value="7_days">{{ __("newsletter.last_7_days") }}</option>
                    <option value="30_days">{{ __("newsletter.last_30_days") }}</option>
                    <option value="90_days">{{ __("newsletter.last_90_days") }}</option>
                    <option value="all_time">{{ __("newsletter.all_time") }}</option>
                </select>
            </div>
            <div wire:ignore id="subscriptionsChart" @class(['min-h-[350px]', $dateRange == 'all_time' ? 'hidden' : ''])></div>
            <div @class(['p-10 text-center text-gray-500 italic', $dateRange == 'all_time' ? '' : 'hidden'])>
                {{ __("newsletter.trend_unavailable") }}
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4">🟢 {{ __("newsletter.status_breakdown") }}</h2>
            <div wire:ignore id="statusChart"></div>
        </div>
    </div>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-bold text-gray-800 mb-4">{{ __("newsletter.subscriber_list") }}</h2>
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="{{ __("newsletter.search_placeholder") }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150"
                    >
                </div>
                <div class="flex gap-4">
                    <select wire:model.live="filter" class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 shadow-sm bg-white">
                        <option value="all">{{ __("newsletter.all_statuses") }}</option>
                        <option value="active">{{ __("newsletter.active_subscribers") }}</option>
                        <option value="unsubscribed">{{ __("newsletter.unsubscribed") }}</option>
                    </select>

                    <button wire:click='confirmBulkDelete'
                        @class([
                            'px-4 py-2 text-white font-semibold rounded-xl transition duration-200',
                            'bg-red-600 hover:bg-red-700' => count($selectedSubscribers) > 0,
                            'bg-gray-400 cursor-not-allowed' => count($selectedSubscribers) === 0
                        ])
                        {{ count($selectedSubscribers) === 0 ? 'disabled' : '' }}
                    >
                        🗑️ {{ __("newsletter.delete") }} ({{ count($selectedSubscribers) }})
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded text-green-600 border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        </th>
                        <th wire:click="sortBy('name')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-green-600 transition duration-150">
                            {{ __("newsletter.name") }} {!! $sortField == 'name' ? ($sortDirection == 'asc' ? ' ▲' : ' ▼') : '' !!}
                        </th>
                        <th wire:click="sortBy('email')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-green-600 transition duration-150">
                            {{ __("newsletter.email") }} {!! $sortField == 'email' ? ($sortDirection == 'asc' ? ' ▲' : ' ▼') : '' !!}
                        </th>
                        <th wire:click="sortBy('created_at')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-green-600 transition duration-150">
                            {{ __("newsletter.subscribed_on") }} {!! $sortField == 'created_at' ? ($sortDirection == 'asc' ? ' ▲' : ' ▼') : '' !!}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __("newsletter.status") }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __("newsletter.actions") }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($this->subscribers as $subscriber)
                        <tr @class(['hover:bg-green-50 transition duration-150', 'bg-green-50/50' => in_array($subscriber->id, $selectedSubscribers)])>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" wire:model.live="selectedSubscribers" value="{{ $subscriber->id }}" class="rounded text-green-600 border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $subscriber->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $subscriber->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $subscriber->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                  @empty($subscriber->unsubscribed_at)
                                    bg-primary-600 text-green-50 border border-green-300
                                        @else
                                       bg-red-600 text-red-50 border border-red-300
                                    @endempty"
                                >
                                    @empty($subscriber->unsubscribed_at)
                                    {{ __("newsletter.subscribed") }}
                                        @else
                                        {{ __("newsletter.unsubscribed") }}
                                    @endempty
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button
                                    wire:click="confirmDelete({{ $subscriber->id }})"
                                    class="text-red-600 hover:text-red-900 hover:underline transition duration-150"
                                    title="{{ __("newsletter.delete_confirm") }}"
                                >
                                    🗑️ {{ __("newsletter.delete") }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic bg-gray-50">
                                {{ __("newsletter.no_results") }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $this->subscribers->links() }}
        </div>
    </div>

    @livewire('newsletter.admin-newsletter-send')
    
    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                // Gestionnaire d'événement pour les confirmations SweetAlert2
                Livewire.on('swal:confirm', event => {
                    Swal.fire({
                        title: event.title,
                        text: event.text,
                        icon: event.icon,
                        showCancelButton: true,
                        confirmButtonColor: '#16a34a', // primary: 600
                        cancelButtonColor: '#6b7280', // gray: 500
                        confirmButtonText: event.confirmText,
                        cancelButtonText: event.cancelText || '{{ __("newsletter.cancel") }}'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch(event.method, { params: event.params });
                        }
                    });
                });
                
                // Gestionnaire d'événement pour les toasts (à adapter à votre librairie)
                Livewire.on('toast', event => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: event.type || 'success',
                        title: event.message,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                });
            });
        </script>
    @endpush
</div>