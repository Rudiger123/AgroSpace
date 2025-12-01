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
                                    {{ count($recipients) > 1 ? __('emails.bulk_email') : __('emails.send_email') }}
                                </h3>
                                <p class="text-sm text-blue-100">
                                    @if (count($recipients) > 1)
                                        {{ __('emails.send_to_count', ['count' => count($recipients)]) }}
                                    @elseif(count($recipients) === 1)
                                        {{ __('emails.recipient', ['name' => $recipients[0]->name]) }}
                                    @else
                                        {{ __('emails.compose_email') }}
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
                <form wire:submit="sendEmail" class="p-6 space-y-6">

                    {{-- Destinataires --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            {{ __('emails.recipients_count', ['count' => count($recipients)]) }}
                        </label>
                        <div
                            class="flex flex-wrap gap-2 p-4 bg-gray-50 rounded-lg border border-gray-200 max-h-32 overflow-y-auto">
                            @foreach ($recipients as $recipient)
                                <div
                                    class="flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg">
                                    <img src="{{ $recipient->avatar_url }}" class="w-6 h-6 rounded-full" alt="">
                                    <span class="text-sm font-medium text-gray-700">{{ $recipient->name }}</span>
                                    <span class="text-xs text-gray-500">({{ $recipient->email }})</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Template Selection --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ __('emails.email_template') }}
                        </label>
                        <select wire:model.live="selectedTemplate"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                            <option value="">{{ __('emails.create_custom_email') }}</option>
                            <option value="welcome">{{ __('emails.templates.welcome') }}</option>
                            <option value="verification">{{ __('emails.templates.verification') }}</option>
                            <option value="offer_approved">{{ __('emails.templates.offer_approved') }}</option>
                            <option value="offer_rejected">{{ __('emails.templates.offer_rejected') }}</option>
                            <option value="account_suspended">{{ __('emails.templates.account_suspended') }}</option>
                            <option value="newsletter">{{ __('emails.templates.newsletter') }}</option>
                            <option value="promotion">{{ __('emails.templates.promotion') }}</option>
                        </select>
                    </div>

                    {{-- Sujet --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ __('emails.email_subject') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="subject"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="{{ __('emails.subject_placeholder') }}">
                        @error('subject')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Message --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ __('emails.message') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="border border-gray-300 rounded-lg overflow-hidden">
                            {{-- Toolbar --}}
                            <div class="bg-gray-50 border-b border-gray-300 px-3 py-2 flex items-center gap-2">
                                <button type="button" class="p-2 hover:bg-gray-200 rounded transition" title="{{ __('emails.bold') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 12h12m-6-6v12"></path>
                                    </svg>
                                </button>
                                <button type="button" class="p-2 hover:bg-gray-200 rounded transition"
                                    title="{{ __('emails.italic') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                </button>
                                <div class="w-px h-6 bg-gray-300 mx-1"></div>
                                <span class="text-xs text-gray-500">{{ __('emails.variables') }}</span>
                            </div>

                            <textarea wire:model="message" rows="10" class="w-full px-4 py-3 outline-none resize-none"
                                placeholder="{{ __('emails.message_placeholder') }}"></textarea>
                        </div>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2">
                            {{ __('emails.tip') }}
                        </p>
                    </div>

                    {{-- Options --}}
                    <div
                        class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-100 space-y-3">
                        <h4 class="font-semibold text-gray-900 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 001.066 1.066c.756.426.756 2.924 0 3.35a1.724 1.724 0 00-1.066 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.066-1.066c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-1.066z">
                                </path>
                            </svg>
                            {{ __('emails.sending_options') }}
                        </h4>

                        <div class="flex items-center gap-3">
                            <input type="checkbox" wire:model="sendCopy" id="sendCopy"
                                class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <label for="sendCopy" class="text-sm text-gray-700 cursor-pointer">
                                {{ __('emails.send_copy') }}
                            </label>
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="checkbox" wire:model="scheduleEmail" id="scheduleEmail"
                                class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <label for="scheduleEmail" class="text-sm text-gray-700 cursor-pointer">
                                {{ __('emails.schedule_send') }}
                            </label>
                        </div>

                        @if ($scheduleEmail)
                            <div class="ml-7">
                                <input type="datetime-local" wire:model="scheduledAt"
                                    class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                        @endif
                    </div>

                    {{-- Preview Button --}}
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-amber-900">{{ __('emails.preview_before_send') }}</p>
                            <p class="text-xs text-amber-700 mt-1">{{ __('emails.check_email_before_send') }}</p>
                        </div>
                        <button type="button" wire:click="previewEmail"
                            class="px-4 py-2 bg-white border border-amber-300 text-amber-700 rounded-lg hover:bg-amber-50 transition text-sm font-semibold">
                            {{ __('emails.preview') }}
                        </button>
                    </div>

                    {{-- Footer Actions --}}
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <button type="button" wire:click="saveDraft"
                            class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            {{ __('emails.save_draft') }}
                        </button>

                        <div class="flex gap-3">
                            <button type="button" @click="$wire.close()"
                                class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition">
                                {{ __('emails.cancel') }}
                            </button>
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold hover:shadow-lg transition flex items-center gap-2"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    {{ $scheduleEmail ? __('emails.schedule') : __('emails.send') }}
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