<aside
    class="fixed left-0 top-0 h-screen w-72 bg-gradient-to-b from-base-800 to-base-900 text-white shadow-2xl z-50 transition-transform duration-300"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

    <!-- Logo -->
    <div class="p-6 border-b border-base-700">
        <div class="flex items-center justify-between">
            <a href="/" class="flex items-center space-x-3">
                <div class="bg-white rounded-xl p-2 animate-pulse-slow">
                    <img src="{{ asset('images/logo.png') }}" class="w-10 h-10" alt="Agrospace">
                </div>
                <div>
                    <h1 class="text-xl font-bold">Agrospace</h1>
                    <p class="text-xs text-base-200">Admin Dashboard</p>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-white hover:bg-base-700 p-2 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="p-4 space-y-2 overflow-y-auto h-[calc(100vh-180px)]">
        <template x-for="item in menuItems" :key="item.name">
            <a :href="item.href" @click="currentPage = item.name"
                :class="currentPage === item.name ? 'bg-base-700 shadow-lg' : 'hover:bg-base-700/50'"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 cursor-pointer group">
                <span x-html="item.icon" class="w-5 h-5"></span>
                <span class="font-medium" x-text="item.name"></span>
                <span x-show="item.badge"
                    class="ml-auto bg-earth-400 text-earth-900 text-xs px-2 py-1 rounded-full font-semibold"
                    x-text="item.badge"></span>
            </a>
        </template>
    </nav>

    <!-- User Profile -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-base-700 bg-base-900/50">
        <div class="flex items-center space-x-3">
            @if (auth()->user()->avatar)
                <img src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                    class="w-10 h-10 rounded-full ring-2 ring-[#2E7D32]/20 group-hover:ring-[#2E7D32]/40 transition-all">
            @else
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-br from-agro-green to-primary flex items-center justify-center text-white font-semibold text-sm border-2 border-agro-green">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            @endif
            <div class="flex-1">
                <p class="font-semibold text-sm">{{ Auth::user()->name }}</p>
                <p class="text-xs text-base-200">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</aside>
