<div>
    {{-- resources/views/livewire/admin/modals/send-email-modal.blade.php --}}
    <div x-data="{ show: @entangle('show') }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        {{-- Overlay --}}
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="$wire.close()"></div>

        {{-- Modal --}}
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-3xl transform transition-all"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                {{-- Header --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-5 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">
                                    {{ count($recipients) > 1 ? 'Envoi d\'email groupé' : 'Envoyer un email' }}
                                </h3>
                                <p class="text-sm text-blue-100">
                                    @if (count($recipients) > 1)
                                        Envoyer à {{ count($recipients) }} destinataire(s)
                                    @elseif(count($recipients) === 1)
                                        Destinataire: {{ $recipients[0]->name }}
                                    @else
                                        Composez votre email
                                    @endif
                                </p>
                            </div>
                        </div>
                        <button @click="$wire.close()" class="text-white hover:bg-white/20 rounded-lg p-2 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Body --}}
                <form wire:submit="sendNewsletter" class="p-6 space-y-6">

                    {{-- Destinataires --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Destinataires ({{ count($recipients) }})
                        </label>
                        <div
                            class="flex flex-wrap gap-2 p-4 bg-gray-50 rounded-lg border border-gray-200 max-h-32 overflow-y-auto">
                            @foreach ($recipients as $recipient)
                                <div
                                    class="flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg">
                                    <span class="text-sm font-medium text-gray-700">{{ $recipient->name }}</span>
                                    <span class="text-xs text-gray-500">({{ $recipient->email }})</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Template Selection --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Modèle d'email (optionnel)
                        </label>
                        <select wire:model.live="selectedTemplate"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                            <option value="">Créer un email personnalisé</option>
                            <option value="welcome">🎉 Email de bienvenue</option>
                            <option value="verification">✅ Vérification de compte</option>
                            <option value="offer_approved">📦 Offre approuvée</option>
                            <option value="offer_rejected">❌ Offre rejetée</option>
                            <option value="account_suspended">⏸ Compte suspendu</option>
                            <option value="newsletter">📰 Newsletter</option>
                            <option value="promotion">🎁 Promotion spéciale</option>
                        </select>
                    </div>

                    {{-- Sujet --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Objet de l'email <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="subject"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="Ex: Bienvenue sur Agrospace 🌾">
                        @error('subject')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Message --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <div class="border border-gray-300 rounded-lg overflow-hidden">
                            {{-- Toolbar --}}
                            <div class="bg-gray-50 border-b border-gray-300 px-3 py-2 flex items-center gap-2">
                                <button type="button" class="p-2 hover:bg-gray-200 rounded transition" title="Gras">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 12h12m-6-6v12"></path>
                                    </svg>
                                </button>
                                <button type="button" class="p-2 hover:bg-gray-200 rounded transition"
                                    title="Italique">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                </button>
                                <div class="w-px h-6 bg-gray-300 mx-1"></div>
                                <span class="text-xs text-gray-500">Variables: {nom}, {email}, {role}</span>
                            </div>

                            <textarea wire:model="message" rows="10" class="w-full px-4 py-3 outline-none resize-none"
                                placeholder="Bonjour {nom},&#10;&#10;Nous sommes ravis de vous accueillir sur Agrospace...&#10;&#10;Cordialement,&#10;L'équipe Agrospace"></textarea>
                        </div>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2">
                            💡 Astuce: Utilisez les Templates puis personnaliser
                        </p>
                    </div>

                    {{-- Footer Actions --}}
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">

                        <div class="flex gap-3">
                            <button type="button" @click="$wire.close()"
                                class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition">
                                Annuler
                            </button>
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold hover:shadow-lg transition flex items-center gap-2"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    📤 Envoyer la Newsletter
                                </span>
                                <span wire:loading>
                                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </span>
                                <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
