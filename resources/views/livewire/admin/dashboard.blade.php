<div class="min-h-screen bg-gradient-to-br from-slate-50 via-green-50 to-emerald-50">
    {{-- Header avec animation --}}
    <div class="bg-white shadow-lg border-b border-green-100" x-data="{ scrolled: false }" 
         @scroll.window="scrolled = window.pageYOffset > 20">
         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 transition-all duration-300"
         :class="scrolled ? 'py-4' : 'py-6'">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <!-- Section utilisateur -->
            <div class="flex items-center space-x-4">
                <!-- Avatar avec effet amélioré -->
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full blur-lg opacity-70 group-hover:opacity-100 transition-all duration-300 animate-pulse"></div>
                    <div class="relative h-20 w-20 rounded-full ring-4 ring-white shadow-xl overflow-hidden bg-white p-1">
                        <img src="{{ auth()->user()->avatar_url }}" 
                             alt="Avatar de {{ auth()->user()->name }}" 
                             class="h-full w-full rounded-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                    <!-- Badge de statut -->
                    <div class="absolute -bottom-1 -right-1 h-6 w-6 rounded-full bg-green-500 border-2 border-white flex items-center justify-center">
                        <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Informations utilisateur -->
                <div class="space-y-2">
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                            Bonjour, {{ auth()->user()->name }}! 👋
                        </h1>
                        <p class="text-gray-600 mt-1 max-w-md">
                            Bienvenue sur votre tableau de bord. Voici un aperçu de votre activité récente.
                        </p>
                    </div>
                    
                    <!-- Badge de rôle et informations supplémentaires -->
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ auth()->user()->getRoleBadge()['class'] }}">
                            {!! auth()->user()->getRoleBadge()['label'] !!}
                        </span>
                        
                        <!-- Date d'inscription ou autre information -->
                        <span class="inline-flex items-center text-xs text-gray-500">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Membre depuis {{ auth()->user()->created_at->format('M Y') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Contrôles et actions -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full lg:w-auto">
                <!-- Sélecteur de période -->
                <div class="relative">
                    <select wire:model.live="dateRange" 
                            class="appearance-none rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm pl-4 pr-10 py-2.5 bg-white transition-all duration-200 hover:shadow-md">
                        <option value="7">7 derniers jours</option>
                        <option value="30">30 derniers jours</option>
                        <option value="90">90 derniers jours</option>
                        <option value="365">Cette année</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Stats Cards avec animations --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" 
             x-data="{ 
                 animateValue(el, start, end, duration) {
                     let startTimestamp = null;
                     const step = (timestamp) => {
                         if (!startTimestamp) startTimestamp = timestamp;
                         const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                         el.innerText = Math.floor(progress * (end - start) + start).toLocaleString('fr-FR');
                         if (progress < 1) window.requestAnimationFrame(step);
                     };
                     window.requestAnimationFrame(step);
                 }
             }"
             x-init="
                 $nextTick(() => {
                     document.querySelectorAll('[data-countup]').forEach(el => {
                         animateValue(el, 0, parseInt(el.dataset.countup), 1500);
                     });
                 });
             ">
            
            @foreach($stats as $key => $value)
                <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1"
                     x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false">
                    
                    {{-- Gradient background animé --}}
                    <div class="absolute inset-0 bg-gradient-to-br opacity-0 group-hover:opacity-10 transition-opacity duration-300"
                         style="background: linear-gradient(135deg, {{ $this->getStatColor($key) }})"></div>
                    
                    <div class="p-6 relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 rounded-xl transition-all duration-300"
                                 :class="hovered ? 'bg-gradient-to-br {{ $this->getStatGradient($key) }} shadow-lg scale-110' : 'bg-gray-100'">
                                <svg class="w-6 h-6 transition-colors duration-300"
                                     :class="hovered ? 'text-white' : 'text-gray-600'">
                                    {!! $this->getStatIcon($key) !!}
                                </svg>
                            </div>
                            
                            @if($this->getStatTrend($key))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                           {{ $this->getStatTrend($key) > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="{{ $this->getStatTrend($key) > 0 ? 'M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z' : 'M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z' }}" clip-rule="evenodd"/>
                                    </svg>
                                    {{ abs($this->getStatTrend($key)) }}%
                                </span>
                            @endif
                        </div>
                        
                        <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide mb-2">
                            {{ $this->getStatLabel($key) }}
                        </h3>
                        
                        <div class="flex items-baseline">
                            <p class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent"
                               data-countup="{{ $value }}">0</p>
                        </div>
                        
                        {{-- Barre de progression animée --}}
                        <div class="mt-4 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r {{ $this->getStatGradient($key) }} rounded-full transition-all duration-1000 ease-out"
                                 x-data="{ width: 0 }"
                                 x-init="setTimeout(() => width = {{ $this->getStatProgress($key, $value) }}, 100)"
                                 :style="`width: ${width}%`"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Chart 1: Principal --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">
                        {{ $this->getMainChartTitle() }}
                    </h2>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            En direct
                        </span>
                    </div>
                </div>
                
                <div x-data="{
                    chart: null,
                    initChart() {
                        const options = {
                            series: [{
                                name: '{{ $this->getMainChartLabel() }}',
                                data: @js($chartData[$this->getMainChartKey()]['counts'] ?? [])
                            }],
                            chart: {
                                type: 'area',
                                height: 350,
                                toolbar: { show: false },
                                animations: {
                                    enabled: true,
                                    easing: 'easeinout',
                                    speed: 800,
                                    animateGradually: { enabled: true, delay: 150 }
                                }
                            },
                            dataLabels: { enabled: false },
                            stroke: { curve: 'smooth', width: 3 },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.7,
                                    opacityTo: 0.2,
                                    stops: [0, 90, 100]
                                }
                            },
                            colors: ['#10b981'],
                            xaxis: {
                                categories: @js($chartData[$this->getMainChartKey()]['dates'] ?? []),
                                labels: { style: { colors: '#6b7280', fontSize: '12px' } }
                            },
                            yaxis: {
                                labels: { style: { colors: '#6b7280', fontSize: '12px' } }
                            },
                            grid: {
                                borderColor: '#f3f4f6',
                                strokeDashArray: 4
                            },
                            tooltip: {
                                theme: 'light',
                                x: { show: true },
                                y: {
                                    formatter: (val) => val.toLocaleString('fr-FR')
                                }
                            }
                        };
                        this.chart = new ApexCharts(this.$refs.chart1, options);
                        this.chart.render();
                    }
                }" x-init="setTimeout(() => initChart(), 100)">
                    <div x-ref="chart1"></div>
                </div>
            </div>

            {{-- Chart 2: Donut/Pie --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300">
                <h2 class="text-xl font-bold text-gray-900 mb-6">
                    {{ $this->getSecondaryChartTitle() }}
                </h2>
                
                <div x-data="{
                    chart: null,
                    initChart() {
                        const options = {
                            series: @js($chartData[$this->getSecondaryChartKey()]['counts'] ?? []),
                            chart: {
                                type: 'donut',
                                height: 350,
                                animations: {
                                    enabled: true,
                                    easing: 'easeinout',
                                    speed: 800,
                                    animateGradually: { enabled: true, delay: 150 }
                                }
                            },
                            labels: @js($chartData[$this->getSecondaryChartKey()][array_keys($chartData[$this->getSecondaryChartKey()])[0]] ?? []),
                            colors: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'],
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '70%',
                                        labels: {
                                            show: true,
                                            total: {
                                                show: true,
                                                label: 'Total',
                                                fontSize: '22px',
                                                fontWeight: 600,
                                                color: '#1f2937',
                                                formatter: (w) => {
                                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toLocaleString('fr-FR');
                                                }
                                            }
                                        }
                                    }
                                }
                            },
                            legend: {
                                position: 'bottom',
                                fontSize: '14px',
                                markers: { radius: 12 }
                            },
                            dataLabels: {
                                enabled: true,
                                formatter: (val) => val.toFixed(1) + '%'
                            },
                            tooltip: {
                                theme: 'light',
                                y: {
                                    formatter: (val) => val.toLocaleString('fr-FR')
                                }
                            }
                        };
                        this.chart = new ApexCharts(this.$refs.chart2, options);
                        this.chart.render();
                    }
                }" x-init="setTimeout(() => initChart(), 200)">
                    <div x-ref="chart2"></div>
                </div>
            </div>
        </div>

        {{-- Charts Row 2 --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            {{-- Radial Chart --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Taux de Réussite</h2>
                
                <div x-data="{
                    chart: null,
                    initChart() {
                        const options = {
                            series: [{{ $this->getSuccessRate() }}],
                            chart: {
                                type: 'radialBar',
                                height: 280,
                                animations: {
                                    enabled: true,
                                    easing: 'easeinout',
                                    speed: 800
                                }
                            },
                            plotOptions: {
                                radialBar: {
                                    startAngle: -135,
                                    endAngle: 135,
                                    hollow: {
                                        size: '70%',
                                        background: 'transparent'
                                    },
                                    track: {
                                        background: '#f3f4f6',
                                        strokeWidth: '100%'
                                    },
                                    dataLabels: {
                                        show: true,
                                        name: {
                                            show: true,
                                            fontSize: '14px',
                                            color: '#6b7280',
                                            offsetY: -10
                                        },
                                        value: {
                                            fontSize: '30px',
                                            fontWeight: 700,
                                            color: '#1f2937',
                                            formatter: (val) => val + '%'
                                        }
                                    }
                                }
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'dark',
                                    type: 'horizontal',
                                    shadeIntensity: 0.5,
                                    gradientToColors: ['#10b981'],
                                    inverseColors: false,
                                    opacityFrom: 1,
                                    opacityTo: 1,
                                    stops: [0, 100]
                                }
                            },
                            stroke: { lineCap: 'round' },
                            labels: ['Performance']
                        };
                        this.chart = new ApexCharts(this.$refs.chart3, options);
                        this.chart.render();
                    }
                }" x-init="setTimeout(() => initChart(), 300)">
                    <div x-ref="chart3"></div>
                </div>
            </div>

            {{-- Bar Chart --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300">
                <h2 class="text-lg font-bold text-gray-900 mb-6">
                    {{ $this->getBarChartTitle() }}
                </h2>
                
                <div x-data="{
                    chart: null,
                    initChart() {
                        const options = {
                            series: @js($this->getBarChartSeries()),
                            chart: {
                                type: 'bar',
                                height: 280,
                                toolbar: { show: false },
                                animations: {
                                    enabled: true,
                                    easing: 'easeinout',
                                    speed: 800
                                }
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '60%',
                                    borderRadius: 8
                                }
                            },
                            dataLabels: { enabled: false },
                            stroke: {
                                show: true,
                                width: 2,
                                colors: ['transparent']
                            },
                            colors: ['#10b981', '#3b82f6'],
                            xaxis: {
                                categories: @js($this->getBarChartCategories()),
                                labels: { style: { colors: '#6b7280', fontSize: '12px' } }
                            },
                            yaxis: {
                                labels: { style: { colors: '#6b7280', fontSize: '12px' } }
                            },
                            grid: {
                                borderColor: '#f3f4f6',
                                strokeDashArray: 4
                            },
                            fill: { opacity: 1 },
                            tooltip: {
                                theme: 'light',
                                y: {
                                    formatter: (val) => val.toLocaleString('fr-FR')
                                }
                            },
                            legend: {
                                position: 'top',
                                horizontalAlign: 'right',
                                markers: { radius: 12 }
                            }
                        };
                        this.chart = new ApexCharts(this.$refs.chart4, options);
                        this.chart.render();
                    }
                }" x-init="setTimeout(() => initChart(), 400)">
                    <div x-ref="chart4"></div>
                </div>
            </div>
        </div>

        {{-- Tables Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Activity Table --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Activité Récente
                    </h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentActivity as $activity)
                                <tr class="hover:bg-green-50 transition-colors duration-150 cursor-pointer"
                                    x-data="{ hovered: false }" 
                                    @mouseenter="hovered = true" 
                                    @mouseleave="hovered = false">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                              :class="hovered ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                                            {{ $activity->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-900 truncate max-w-xs">
                                            {{ $activity->description }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                            <p class="text-sm">Aucune activité récente</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Top Items Table --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        {{ $this->getTopItemsTitle() }}
                    </h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th>
                                    
                                </th>
                                @foreach($this->getTopItemsHeaders() as $header)
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ $header }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($this->getTopItemsData() as $index => $item)
                                <tr class="hover:bg-blue-50 transition-colors duration-150 cursor-pointer"
                                    x-data="{ hovered: false }" 
                                    @mouseenter="hovered = true" 
                                    @mouseleave="hovered = false">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 relative">
                                                <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full blur opacity-50 transition-opacity duration-300"
                                                     :class="hovered ? 'opacity-75' : 'opacity-50'"></div>
                                                <div class="relative h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold">
                                                    {{ $index + 1 }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @foreach($this->formatTopItemRow($item) as $cell)
                                        <td class="px-6 py-4">
                                            {!! $cell !!}
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($this->getTopItemsHeaders()) + 1 }}" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            <p class="text-sm">Aucune donnée disponible</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>