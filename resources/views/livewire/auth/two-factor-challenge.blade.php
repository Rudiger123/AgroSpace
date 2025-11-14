<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 via-white to-green-50 px-4">
    <div class="max-w-md w-full">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-20 h-20 bg-primary-500 rounded-2xl shadow-lg mb-4 animate-pulse">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Authentification à deux facteurs</h1>
            <p class="text-gray-600">
                @if ($useRecoveryCode)
                    Entrez un code de récupération pour vous connecter
                @else
                    Entrez le code de votre application d'authentification
                @endif
            </p>
        </div>

        <!-- Carte principale -->
        <div class="bg-white rounded-2xl shadow-xl p-8">

            <!-- Alerte tentatives -->
            @if ($attempts > 0)
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-sm text-yellow-700">
                            <strong>{{ $attempts }}</strong> tentative(s) échouée(s).
                            Il vous reste <strong>{{ $maxAttempts - $attempts }}</strong> tentative(s).
                        </p>
                    </div>
                </div>
            @endif

            <!-- Formulaire Code Authentificateur -->
            @if (!$useRecoveryCode)
                <form wire:submit.prevent="verify" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Code d'authentification <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" wire:model.defer="code" placeholder="000000" maxlength="6"
                                pattern="[0-9]{6}" inputmode="numeric" autocomplete="one-time-code" autofocus
                                class="w-full px-4 py-4 text-center text-2xl font-mono tracking-widest border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        @error('code')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">
                            Ouvrez votre application d'authentification (Google Authenticator, Authy, etc.)
                        </p>
                    </div>

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full bg-primary-500 text-white py-4 rounded-xl hover:bg-primary-600 transition font-semibold shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2">
                        <span wire:loading.remove wire:target="verify">Vérifier le code</span>
                        <span wire:loading wire:target="verify" class="flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Vérification...
                        </span>
                    </button>
                </form>
            @else
                <!-- Formulaire Code de Récupération -->
                <form wire:submit.prevent="verify" class="space-y-6">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded">
                        <div class="flex">
                            <svg class="w-5 h-5 text-blue-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-blue-700">
                                    Les codes de récupération sont des codes uniques générés lors de l'activation de la
                                    2FA. Chaque code ne peut être utilisé qu'une seule fois.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Code de récupération <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" wire:model.defer="recovery_code" placeholder="XXXXXXXXXXXX"
                                maxlength="20" autocomplete="off" autofocus
                                class="w-full px-4 py-4 text-center text-xl font-mono tracking-wider uppercase border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        @error('recovery_code')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">
                            Entrez l'un de vos codes de récupération sauvegardés
                        </p>
                    </div>

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full bg-primary-500 text-white py-4 rounded-xl hover:bg-primary-600 transition font-semibold shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2">
                        <span wire:loading.remove wire:target="verify">Vérifier le code de récupération</span>
                        <span wire:loading wire:target="verify" class="flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Vérification...
                        </span>
                    </button>
                </form>
            @endif

            <!-- Bouton Basculer -->
            <div class="mt-6 text-center">
                <button wire:click="toggleRecoveryCode" type="button"
                    class="text-primary-600 hover:text-primary-700 font-medium text-sm inline-flex items-center space-x-2">
                    @if ($useRecoveryCode)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Utiliser le code d'authentification</span>
                    @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                            </path>
                        </svg>
                        <span>Utiliser un code de récupération</span>
                    @endif
                </button>
            </div>

            <!-- Séparateur -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">ou</span>
                </div>
            </div>

            <!-- Bouton Déconnexion -->
            <button wire:click="logout" type="button"
                class="w-full border-2 border-gray-300 text-gray-700 py-3 rounded-xl hover:bg-gray-50 transition font-medium flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Retour à la connexion</span>
            </button>
        </div>

        <!-- Info aide -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Vous avez perdu vos codes de récupération ?
                <a href="mailto:support@agrospace.cm" class="text-primary-600 hover:text-primary-700 font-medium">
                    Contactez le support
                </a>
            </p>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto-focus sur le champ
            document.addEventListener('livewire:load', function() {
                const input = document.querySelector('input[autofocus]');
                if (input) {
                    input.focus();
                }
            });

            // Suggestion d'utiliser les codes de récupération
            window.addEventListener('suggest-recovery', event => {
                Swal.fire({
                    icon: 'warning',
                    title: 'Plusieurs tentatives échouées',
                    text: event.detail.message,
                    confirmButtonText: 'Utiliser un code de récupération',
                    cancelButtonText: 'Continuer',
                    showCancelButton: true,
                    confirmButtonColor: '#22c55e',
                    cancelButtonColor: '#6b7280'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('toggleRecoveryCode');
                    }
                });
            });

            // Notifications
            window.addEventListener('notify', event => {
                const data = event.detail;
                Swal.fire({
                    icon: data.type,
                    title: data.type === 'success' ? 'Succès!' : 'Erreur!',
                    text: data.message,
                    timer: data.type === 'success' ? 2000 : null,
                    showConfirmButton: data.type !== 'success',
                    confirmButtonColor: '#22c55e'
                });
            });
        </script>
    @endpush
</div>
