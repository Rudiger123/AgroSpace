<div class="min-h-screen flex items-center justify-center bg-accent py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        @if($subscriber && $subscriber->isActive())
            <div class="bg-white shadow-lg rounded-lg p-8 border border-gray-200">
                <div class="text-center mb-6">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-base mb-4">Voulez-vous vous désabonner ?</h2>
                    <p class="text-gray-600">
                        Vous êtes sur le point de vous désabonner de la newsletter pour :
                    </p>
                    <p class="font-semibold text-primary-700 mt-2">{{ $subscriber->email }}</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button
                        wire:click="unsubscribe"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-md transition duration-200 ease-in-out transform hover:scale-105"
                    >
                        ✅ Oui, me désabonner
                    </button>
                    <a
                        href="{{ url('/') }}"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-md transition duration-200 ease-in-out transform hover:scale-105 text-center"
                    >
                        ❌ Annuler
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white shadow-lg rounded-lg p-8 border border-gray-200 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-base mb-4">Déjà désabonné</h2>
                <p class="text-gray-600 mb-6">
                    Vous êtes déjà désabonné de notre newsletter.
                </p>
                <a href="{{ url('/') }}" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200">
                    Retour à l'accueil
                </a>
            </div>
        @endif
    </div>
</div>

@script
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('swal:success', (event) => {
            Swal.fire({
                title: event.title,
                text: event.text,
                icon: event.icon,
                confirmButtonColor: '#1B5E20',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'rounded-lg'
                }
            }).then(() => {
                window.location.href = '{{ url("/") }}';
            });
        });
    });
</script>
@endscript