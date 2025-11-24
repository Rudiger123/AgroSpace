<div x-data="{
    show: @entangle($attributes->wire('model')),
    focusables() {
        // Liste des éléments focusables à l'intérieur de la modale
        return [...this.$el.querySelectorAll('input, select, textarea, button:not([disabled]), a[href], [tabindex]:not([tabindex=&quot;-1&quot;])')];
    },
    firstFocusable() { return this.focusables()[0] },
    lastFocusable() { return this.focusables().slice(-1)[0] },
    trap(event) {
        if (this.focusables().length === 0) return;

        if (event.key === 'Tab') {
            event.preventDefault();

            if (event.shiftKey) {
                if (document.activeElement === this.firstFocusable()) {
                    this.lastFocusable().focus();
                } else {
                    // Recherche l'élément focusable précédent
                    let index = this.focusables().indexOf(document.activeElement);
                    if (index > 0) {
                        this.focusables()[index - 1].focus();
                    }
                }
            } else {
                if (document.activeElement === this.lastFocusable()) {
                    this.firstFocusable().focus();
                } else {
                    // Recherche l'élément focusable suivant
                    let index = this.focusables().indexOf(document.activeElement);
                    if (index < this.focusables().length - 1) {
                        this.focusables()[index + 1].focus();
                    }
                }
            }
        }
    }
}" x-init="$watch('show', value => {
    if (value) {
        document.body.classList.add('overflow-hidden');
        $nextTick(() => firstFocusable()?.focus());
    } else {
        document.body.classList.remove('overflow-hidden');
    }
})" x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false" x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()" x-show="show" style="display: none;"
    class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false" x-transition.opacity>
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
    </div>

    <!-- Modal Content -->
    <div x-show="show"
        class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
        x-transition.duration.300ms>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle {{ $maxWidth ?? 'sm:max-w-lg' }} w-full"
            role="dialog" aria-modal="true"
            aria-labelledby="{{ $attributes->get('id') ? $attributes->get('id') . '-title' : 'modal-title' }}"
            x-on:keydown.tab="trap">
            <div class="bg-white p-4 sm:p-6">
                <!-- Header (Titre) -->
                @if (isset($title))
                    <div class="flex items-center justify-between pb-4 border-b">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="{{ $attributes->get('id') }}-title">
                            {{ $title }}
                        </h3>
                        <button x-on:click="show = false" type="button"
                            class="text-gray-400 hover:text-gray-500 transition">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Contenu Principal -->
                <div class="mt-4">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer (Actions) -->
            @if (isset($footer))
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse sm:justify-start gap-3">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>


</div>
