<div class="min-h-screen flex items-center justify-center bg-agro-gray/10 p-4">
    <div class="bg-agro-white rounded-xl shadow-lg max-w-md w-full p-6 space-y-6">
        <h2 class="text-2xl font-bold text-agro-green text-center">Code de vérification 2FA</h2>

        @if (session()->has('message'))
            <div x-data.ignore="{ show: true }" x-init="setTimeout(() => show=false, 5000)" x-show="show"
                class="p-3 bg-green-100 text-green-800 rounded">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="verify" class="space-y-4">
            <div>
                <label for="code" class="block text-agro-gray font-medium">Code à 6 chiffres</label>
                <input type="text" id="code" wire:model.defer="code" maxlength="6"
                    class="w-full px-4 py-3 border border-agro-gray rounded-lg focus:outline-none focus:ring-2 focus:ring-agro-green focus:border-transparent text-center text-lg tracking-widest"
                    placeholder="••••••">
                @error('code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-agro-green text-agro-white py-3 rounded-lg font-semibold hover:bg-green-700 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                Vérifier
            </button>
        </form>

        <p class="text-center text-sm text-agro-gray">
            Si vous n’avez pas reçu le code, vérifiez votre application Authenticator.
        </p>
    </div>
</div>
