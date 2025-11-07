<div>
    {{-- resources/views/livewire/admin/dashboard.blade.php --}}
    <div>
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            @foreach ($stats as $index => $stat)
                <div class="bg-white rounded-2xl p-6 shadow-lg card-hover animate-fadeInUp glass-effect"
                    style="animation-delay: {{ $index * 100 }}ms">
                    <div class="flex items-center justify-between mb-4">
                        <div class="{{ $stat['bgColor'] }} w-12 h-12 rounded-xl flex items-center justify-center">
                            {!! $stat['icon'] !!}
                        </div>
                        <span
                            class="{{ $stat['trend'] === 'up' ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100' }} text-sm font-semibold px-3 py-1 rounded-full flex items-center space-x-1">
                            <span>{{ $stat['change'] }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if ($stat['trend'] === 'up')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                @endif
                            </svg>
                        </span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-1">{{ $stat['label'] }}</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $stat['value'] }}</p>
                    <p class="text-xs text-gray-500 mt-2">{{ $stat['description'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            {{-- Activity Chart --}}
            <div class="bg-white rounded-2xl p-6 shadow-lg glass-effect animate-fadeInUp"
                style="animation-delay: 400ms">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Activité de la plateforme</h3>
                        <p class="text-sm text-gray-500">Offres et demandes par mois</p>
                    </div>
                    <select wire:model.live="activityPeriod"
                        class="bg-gray-100 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 outline-none">
                        <option value="6">6 derniers mois</option>
                        <option value="12">12 derniers mois</option>
                        <option value="year">Cette année</option>
                    </select>
                </div>
                <div class="h-64 flex items-end justify-between space-x-2">
                    @foreach ($activityData as $month)
                        <div class="flex-1 flex flex-col items-center space-y-2">
                            <div class="w-full flex flex-col space-y-1">
                                <div class="bg-green-500 rounded-t-lg transition-all duration-500 hover:bg-green-600"
                                    style="height: {{ $month['offres'] * 2 }}px" title="Offres: {{ $month['offres'] }}">
                                </div>
                                <div class="bg-amber-400 rounded-t-lg transition-all duration-500 hover:bg-amber-500"
                                    style="height: {{ $month['demandes'] * 2 }}px"
                                    title="Demandes: {{ $month['demandes'] }}">
                                </div>
                            </div>
                            <span class="text-xs text-gray-600 font-medium">{{ $month['month'] }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center justify-center space-x-6 mt-4 pt-4 border-t">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded"></div>
                        <span class="text-sm text-gray-600">Offres</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-amber-400 rounded"></div>
                        <span class="text-sm text-gray-600">Demandes</span>
                    </div>
                </div>
            </div>

            {{-- Categories Distribution --}}
            <div class="bg-white rounded-2xl p-6 shadow-lg glass-effect animate-fadeInUp"
                style="animation-delay: 500ms">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Catégories populaires</h3>
                    <p class="text-sm text-gray-500">Distribution des offres par catégorie</p>
                </div>
                <div class="space-y-4">
                    @foreach ($categories as $cat)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    {!! $cat['icon'] !!}
                                    <span class="text-sm font-medium text-gray-700">{{ $cat['name'] }}</span>
                                </div>
                                <span class="text-sm font-bold text-gray-800">{{ $cat['count'] }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all duration-700 ease-out"
                                    style="width: {{ $cat['percentage'] }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Recent Activities & Top Users --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            {{-- Recent Activities --}}
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-lg glass-effect animate-fadeInUp"
                style="animation-delay: 600ms">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Activités récentes</h3>
                        <p class="text-sm text-gray-500">Dernières actions sur la plateforme</p>
                    </div>
                    <button wire:click="loadMoreActivities"
                        class="text-green-600 hover:text-green-700 text-sm font-semibold">
                        Voir tout →
                    </button>
                </div>
                <div class="space-y-4">
                    @foreach ($recentActivities as $activity)
                        <div
                            class="flex items-start space-x-4 p-4 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                            <div
                                class="{{ $activity['color'] }} w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                                {!! $activity['icon'] !!}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800">{{ $activity['title'] }}</p>
                                <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $activity['time'] }}</p>
                            </div>
                            <span
                                class="{{ $activity['badge']['color'] }} px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $activity['badge']['text'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Top Producers --}}
            <div class="bg-white rounded-2xl p-6 shadow-lg glass-effect animate-fadeInUp"
                style="animation-delay: 700ms">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Top Producteurs</h3>
                    <p class="text-sm text-gray-500">Les plus actifs ce mois</p>
                </div>
                <div class="space-y-4">
                    @foreach ($topProducers as $index => $producer)
                        <div
                            class="flex items-center space-x-3 p-3 rounded-xl hover:bg-green-50 transition cursor-pointer">
                            <div class="relative">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($producer['name']) }}&background={{ $producer['color'] }}&color=fff"
                                    class="w-12 h-12 rounded-full ring-2 ring-white shadow"
                                    alt="{{ $producer['name'] }}">
                                <span
                                    class="absolute -bottom-1 -right-1 bg-green-500 text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center border-2 border-white">
                                    {{ $index + 1 }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $producer['name'] }}</p>
                                <p class="text-xs text-gray-500">{{ $producer['location'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-green-600">{{ $producer['offres'] }}</p>
                                <p class="text-xs text-gray-400">offres</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-2xl p-8 shadow-2xl animate-fadeInUp"
            style="animation-delay: 800ms">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                <div class="text-white text-center md:text-left">
                    <h3 class="text-2xl font-bold mb-2">🚀 Développez votre écosystème</h3>
                    <p class="text-green-100 text-sm">Connectez plus de producteurs et consommateurs dès aujourd'hui</p>
                </div>
                <div class="flex flex-wrap gap-3 justify-center">
                    <button
                        class="bg-white text-green-600 hover:bg-green-50 px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span>Nouvelle Offre</span>
                    </button>
                    <button wire:click="inviteUsers"
                        class="bg-green-500 text-white hover:bg-green-400 px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        <span>Inviter des utilisateurs</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
