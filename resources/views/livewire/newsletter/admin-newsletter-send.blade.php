<div>
    {{-- resources/views/livewire/admin/modals/send-email-modal.blade.php (Refonte Agrospace) --}}
    <div x-data="{ show: @entangle('show') }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        {{-- Overlay --}}
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="$wire.close()"></div>

        {{-- Modal --}}
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl transform transition-all border border-green-200"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                {{-- Header --}}
                <div class="bg-gradient-to-r from-green-600 to-green-700 p-6 rounded-t-2xl flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white flex items-center space-x-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        <span>Envoi de Newsletter en Masse</span>
                    </h2>
                    <button type="button" @click="$wire.close()" class="text-white hover:text-green-200 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- Body --}}
                <form wire:submit="sendNewsletter">
                    <div class="p-6 space-y-6">

                        <div class="bg-green-50 p-4 rounded-xl border border-green-200">
                            <p class="text-sm font-semibold text-green-700">
                                🎯 Destinataires : <span class="font-bold text-green-900">{{ count($recipients) }} Abonnés Actifs</span>
                                <span class="text-xs text-green-600 block mt-1">L'envoi sera mis en file d'attente (Job) pour une exécution en arrière-plan.</span>
                            </p>
                        </div>

                        <div>
                            <label for="template" class="block text-sm font-medium text-gray-700 mb-2">Sélectionner un Modèle (Optionnel)</label>
                            <select wire:model.live="selectedTemplate" id="template"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150 bg-white">
                                <option value="">— Sans Modèle —</option>
                                <option value="welcome">🎉 Bienvenue Agrospace</option>
                                <option value="special_offer">🎁 Offre Spéciale</option>
                            </select>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Objet de l'Email <span class="text-red-500">*</span></label>
                            <input type="text" wire:model.live="subject" id="subject" placeholder="Ex: Les dernières actualités d'Agrospace"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150">
                            @error('subject') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Contenu du Message <span class="text-red-500">*</span></label>
                            <textarea wire:model.live="message" id="message" rows="10" placeholder="Rédigez ici votre newsletter..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150 font-mono text-sm"></textarea>
                            <p class="mt-2 text-xs text-gray-500">Utilisez <code class="bg-gray-200 px-1 py-0.5 rounded text-gray-800 font-bold">{nom}</code> pour la personnalisation (Nom de l'abonné).</p>
                            @error('message') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-4 flex justify-end space-x-4 border-t border-gray-100">
                            <button type="button" @click="$wire.close()"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-100 transition duration-150">
                                Annuler
                            </button>
                            <button type="submit"
                                class="flex items-center space-x-2 px-6 py-3 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                                wire:loading.attr="disabled"
                                wire:target="sendNewsletter">
                                <span wire:loading.remove wire:target="sendNewsletter">
                                    📤 Envoyer la Newsletter
                                </span>
                                <span wire:loading wire:target="sendNewsletter">
                                    <svg class="animate-spin h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Envoi en cours...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>