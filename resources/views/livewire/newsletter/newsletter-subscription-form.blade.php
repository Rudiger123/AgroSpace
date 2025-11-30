<section class="py-20 bg-gradient-to-r from-green-600 to-green-800">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-12 shadow-2xl border border-green-300/50">
            <h2 class="text-4xl font-extrabold text-white mb-6">
                🌱 {{ __("newsletter.join_community") }}
            </h2>
            <p class="text-xl text-green-100 mb-8">
                {{ __("newsletter.subscribe_description") }}
            </p>

            <form wire:submit="subscribe" class="max-w-2xl mx-auto">
                <div class="flex flex-col sm:flex-row gap-4 bg-white p-2 rounded-2xl shadow-xl">
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
                        class="flex-1 px-5 py-3 rounded-xl border-none focus:ring-green-500 focus:border-green-500 shadow-inner placeholder-gray-400"
                        placeholder="{{ __("newsletter.name_placeholder") }}"
                    >
                    <input type="email" wire:model.debounce.300ms="email" placeholder="{{ __("newsletter.email_placeholder") }}"
                        class="flex-1 px-5 py-3 rounded-xl border-none focus:ring-green-500 focus:border-green-500 shadow-inner placeholder-gray-400">
                    <button type="submit"
                        class="bg-green-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-green-700 transition-all shadow-lg transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ __("newsletter.subscribe") }}</span>
                        <span wire:loading>...</span>
                    </button>
                </div>
                
                {{-- Affichage des erreurs / messages --}}
                @error('name') <p class="text-red-300 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
                @error('email') <p class="text-red-300 text-sm mt-2 font-medium">{{ $message }}</p> @enderror

                @if (session()->has('toast'))
                    <p class="text-green-200 text-sm mt-4 font-semibold">
                        ✅ {{ session('toast')['message'] }}
                    </p>
                @else
                    <p class="text-green-200 text-sm mt-4">
                        🔒 {{ __("newsletter.privacy_respect") }}
                    </p>
                @endif
            </form>
        </div>
    </div>
</section>