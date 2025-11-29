<div class="min-h-screen flex items-center justify-center bg-green-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <svg class="mx-auto w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <h1 class="mt-4 text-3xl font-extrabold text-gray-900">{{ __("newsletter.unsubscribe_title") }}</h1>
        </div>

        @if($subscriber && $subscriber->isActive())
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-green-200 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __("newsletter.unsubscribe_confirm") }}</h2>
                <p class="text-gray-600 mb-6">
                    {{ __("newsletter.currently_subscribed") }}
                </p>
                <p class="font-semibold text-green-700 bg-green-100 p-2 rounded-lg inline-block mb-8">{{ $subscriber->email }}</p>

                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <button wire:click="unsubscribe"
                        class="bg-red-600 text-white font-semibold py-3 px-8 rounded-xl hover:bg-red-700 transition duration-200 shadow-md transform hover:scale-[1.02]"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="unsubscribe">{{ __("newsletter.unsubscribe_yes") }}</span>
                        <span wire:loading wire:target="unsubscribe">{{ __("newsletter.unsubscribing") }}</span>
                    </button>
                    <a href="{{ url('/') }}"
                        class="bg-gray-200 text-gray-700 font-semibold py-3 px-8 rounded-xl hover:bg-gray-300 transition duration-200 shadow-md flex items-center justify-center transform hover:scale-[1.02]">
                        {{ __("newsletter.unsubscribe_no") }}
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-200 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __("newsletter.status_confirmation") }}</h2>
                <p class="text-gray-600 mb-6">
                    @if($subscriber && !$subscriber->isActive())
                        {{ __("newsletter.already_unsubscribed") }}
                    @else
                        {{ __("newsletter.invalid_link") }}
                    @endif
                </p>
                <a href="{{ url('/') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-xl transition duration-200 shadow-md">
                    {{ __("newsletter.back_home") }}
                </a>
            </div>
        @endif
    </div>
</div>