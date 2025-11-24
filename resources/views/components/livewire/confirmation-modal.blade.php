@props([
    'id' => 'confirmation-modal',
    'maxWidth' => 'sm:max-w-lg',
    'title' => 'Confirmer l\'action',
    'content' => 'Êtes-vous sûr de vouloir effectuer cette action ?',
    'buttonText' => 'Confirmer',
    'buttonColor' => 'bg-red-600 hover:bg-red-700',
])

<x-livewire.modal :id="$id" :wire:model="$attributes->get('wire:model')" :maxWidth="$maxWidth">
    <x-slot name="title">
        <div class="flex items-center">
            <!-- Icône d'Alerte -->
            <div
                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.836 2.83 2.603 2.83h13.792c1.767 0 3.473-1.33 2.603-2.83l-6.892-11.353c-.767-1.265-2.603-1.265-3.37 0L12 9z" />
                </svg>
            </div>
            <h3 class="ml-4 text-lg leading-6 font-bold text-gray-900" id="{{ $id }}-title">
                {{ $title }}
            </h3>
        </div>
    </x-slot>

    <!-- Contenu -->
    <div class="mt-2 text-sm text-gray-500">
        {{ $content }}
    </div>

    <x-slot name="footer">
        <!-- Bouton d'Annulation -->
        <button type="button" x-on:click="$dispatch('close')"
            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm transition duration-150 ease-in-out">
            Annuler
        </button>

        <!-- Bouton de Confirmation (Action) -->
        <button {{ $attributes->except('wire:model') }} type="button"
            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-3 {{ $buttonColor }} text-base font-medium text-white focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition duration-150 ease-in-out">
            {{ $buttonText }}
        </button>
    </x-slot>


</x-livewire.modal>
