<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <div
        class="min-h-screen flex items-center justify-center font-inter">

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
                    <div class="w-12 h-12 bg-primary-50 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" class="w-12 h-12"
                            alt="{{ __('auth.logo_alt') }}">
                    </div>
                    <span class="text-3xl font-bold text-[#2E7D32]" style="font-family: 'Poppins', sans-serif;">
                        {{ __('app.name') }}
                    </span>
                </a>

                <p class="text-[#37474F]/70 mt-2">
                    {{ __('auth.verify_email_message') }}
                </p>
            </div>

            {{-- Reset Card --}}
            <div class="bg-white rounded-2xl shadow-xl p-8"
                x-transition:enter="transition ease-out duration-500 delay-150"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0">
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ __('auth.verification_link_sent') }}
                    </div>
                @endif
                <button wire:click="sendVerification"
                    class="w-full bg-[#2E7D32] text-white py-3 rounded-lg font-semibold hover:bg-[#1B5E20] focus:outline-none focus:ring-4 focus:ring-[#2E7D32]/50 transition-all transform hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                    {{ __('auth.resend_verification_email') }}
                </button>

                <button wire:click="logout"
                    class="underline w-full mt-3 text-sm text-center text-gray-600  hover:text-gray-900 rounded-md">
                    {{ __('auth.log_out') }}
                </button>
            </div>

        </div>

    </div>


</div>