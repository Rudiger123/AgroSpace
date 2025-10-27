<div class="p-6 bg-agro-white rounded-xl shadow-lg max-w-md mx-auto space-y-6">

    {{-- Messages dynamiques --}}
    @if (session()->has('success'))
        <div x-data.ignore="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="bg-green-100 text-green-700 p-3 rounded-lg shadow transition-all">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="text-xl font-bold text-agro-green">Sécurité du compte</h2>

    @if (!Auth::user()->two_factor_enabled)
        <button wire:click="enableTwoFactor"
            class="px-5 py-3 bg-agro-green text-white rounded-xl shadow hover:scale-105 transition transform">
            Activer la double authentification
        </button>
    @else
        <button wire:click="disableTwoFactor"
            class="px-5 py-3 bg-red-600 text-white rounded-xl shadow hover:scale-105 transition transform">
            Désactiver la double authentification
        </button>

        @if ($showQrCode && $google2faSvg)
            <div class="mt-4 text-center">
                <p class="mb-2 font-medium text-agro-green">Scannez ce QR Code avec Google Authenticator :</p>
                <div class="inline-block">{!! $google2faSvg !!}</div>

                @if ($showQrCode && $recoveryCodes)
                    <div class="mt-4 flex justify-between items-center">
                        <div>
                            <p class="font-medium mb-2">Codes de récupération :</p>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($recoveryCodes as $code)
                                    <li>{{ $code }}</li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Bouton Export CSV --}}
                        <div>
                            <button wire:click="exportRecoveryCodes"
                                class="px-4 py-2 bg-agro-green text-white rounded-xl shadow hover:scale-105 transition transform">
                                Export CSV
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    @endif
</div>
