<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink($this->only('email'));

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>
<div class=" min-h-screen flex items-center justify-center font-inter">

    {{-- Background Pattern --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-[#2E7D32]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-[#FFB300]/5 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md px-6">
        {{-- Logo --}}
        <div class="text-center mb-8" x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0">
            <a href="/" class="inline-flex items-center space-x-2 mb-2">
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" class="w-12 h-12" alt="{{ __('auth.logo_alt') }}">
                </div>
                <span class="text-3xl font-bold text-[#2E7D32]" style="font-family: 'Poppins', sans-serif;">
                    {{ __('app.name') }}
                </span>
            </a>
            <h2 class="text-2xl font-bold text-[#37474F] mt-4" style="font-family: 'Poppins', sans-serif;">
                {{ __('auth.forgot_password_title') }}
            </h2>
            <p class="text-[#37474F]/70 mt-2">
                {{ __('auth.forgot_password_subtitle') }}
            </p>
        </div>

        {{-- Reset Card --}}
        <div class="bg-white rounded-2xl shadow-xl p-8" x-transition:enter="transition ease-out duration-500 delay-150"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            {{-- Email Field --}}
            <form wire:submit.prevent="sendPasswordResetLink" class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium text-[#37474F] mb-2">
                        {{ __('auth.email_address') }}
                    </label>
                    <div class="relative">
                        <input type="email" id="email" wire:model.live.debounce.200ms="email"
                            class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all
                            name="email"
                            required autofocus placeholder="{{ __('auth.email_placeholder') }}">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                            </path>
                        </svg>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-[#2E7D32] text-white py-3 rounded-lg font-semibold hover:bg-[#1B5E20] focus:outline-none focus:ring-4 focus:ring-[#2E7D32]/50 transition-all transform hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove>
                        {{ __('auth.send_reset_link') }}
                    </span>
                    <span wire:loading class="flex items-center justify-center">
                        <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        {{ __('auth.sending') }}
                    </span>
                </button>
            </form>

        </div>

        {{-- Footer Links --}}
        <div class="text-center mt-6" x-transition:enter="transition ease-out duration-500 delay-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <a href="/login" wire:navigate
                class="text-sm text-[#2E7D32] font-semibold hover:text-[#1B5E20] transition-colors flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('auth.back_to_login') }}
            </a>
        </div>
    </div>
</div>
