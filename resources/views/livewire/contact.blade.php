<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use App\Helpers\SEO;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\NewContactNotification;
use Illuminate\Support\Facades\Notification;

new #[Layout('layouts.main')] class extends Component {
    #[Rule('required|min:3|max:255')]
    public string $name = '';

    #[Rule('required|email|max:255')]
    public string $email = '';

    #[Rule('required|min:5|max:255')]
    public string $subject = '';

    #[Rule('required|min:10|max:2000')]
    public string $message = '';

    public bool $success = false;

    public function mount()
    {
        SEO::setTitle(__('contactfull.title'));
        SEO::setDescription(__('contactfull.description'));
        SEO::setKeywords(__('contactfull.keywords'));
        SEO::setCanonical(url()->current());
        SEO::addImages([asset('images/agrospace.png')]);
    }

    public function submit()
    {
        $this->validate();

        // Créer le contact
        $contact = Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => 'new',
        ]);
        // Notifier les admins
        $admins = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->get();

        Notification::send($admins, new NewContactNotification($contact));
        $this->reset(['name', 'email', 'subject', 'message']);
        $this->success = true;
    }
}; ?>

@push('meta')
    <meta name="theme-color" content="#16a34a">
@endpush

<div class="bg-gray-50 font-sans text-gray-900 antialiased selection:bg-green-100 selection:text-green-900">
    <x-layouts.header />

    <section class="relative pt-24 pb-20 md:pt-32 md:pb-28 overflow-hidden gradient-bg">
        <div class="absolute inset-0 opacity-10 pointer-events-none" aria-hidden="true">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,...')"></div>
        </div>

        <div class="container mx-auto px-4 text-center text-white">
            <span
                class="inline-block py-1 px-3 rounded-full bg-green-500/20 border border-green-500/30 text-green-300 text-sm font-semibold mb-4">
                {!! __('contactfull.header.team') !!}
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                {!! __('contactfull.header.title') !!}
            </h1>
            <p class="text-lg md:text-xl text-green-50 max-w-2xl mx-auto mt-4">
                {{ __('contactfull.header.subtitle') }}
            </p>
        </div>
    </section>

    {{-- SECTION CONTACT PRINCIPALE --}}
    <section class="py-20 lg:py-28 relative z-20">
        <div class="container mx-auto px-4">
            <div div class="grid md:grid-cols-2 gap-12 items-start"">

                {{-- COLONNE GAUCHE : INFOS & ILLUSTRATION (5 colonnes) --}}
                <div class="space-y-10">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __('contactfull.channels.title') }}</h2>
                        <p class="text-gray-600 text-lg">
                            {{ __('contactfull.channels.description') }}
                        </p>
                    </div>

                    <div class="grid gap-6">
                        {{-- Carte Adresse --}}
                        <div
                            class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-green-200 transition-all duration-300 flex items-start space-x-5">
                            <div
                                class="bg-green-50 p-4 rounded-xl group-hover:bg-green-600 transition-colors duration-300">
                                <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3
                                    class="font-bold text-gray-900 text-lg group-hover:text-green-700 transition-colors">
                                    {{ __('contactfull.contact_cards.headquarters.title') }}</h3>
                                <p class="text-gray-600 mt-1">{!! __('contactfull.contact_cards.headquarters.address') !!}</p>
                            </div>
                        </div>

                        {{-- Carte Email --}}
                        <a href="mailto:contact@agrospace.cm"
                            class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-green-200 transition-all duration-300 flex items-start space-x-5">
                            <div
                                class="bg-green-50 p-4 rounded-xl group-hover:bg-green-600 transition-colors duration-300">
                                <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3
                                    class="font-bold text-gray-900 text-lg group-hover:text-green-700 transition-colors">
                                    {{ __('contactfull.contact_cards.email.title') }}</h3>
                                <p class="text-gray-600 mt-1">contact@agrospace.cm</p>
                                <span
                                    class="inline-block mt-2 text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-md">{{ __('contactfull.contact_cards.email.response_time') }}</span>
                            </div>
                        </a>

                        {{-- Carte Téléphone --}}
                        <div
                            class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-green-200 transition-all duration-300 flex items-start space-x-5">
                            <div
                                class="bg-green-50 p-4 rounded-xl group-hover:bg-green-600 transition-colors duration-300">
                                <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3
                                    class="font-bold text-gray-900 text-lg group-hover:text-green-700 transition-colors">
                                    {{ __('contactfull.contact_cards.customer_service.title') }}</h3>
                                <p class="text-gray-600 mt-1">{{ __('contactfull.contact_cards.customer_service.phone') }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ __('contactfull.contact_cards.customer_service.schedule') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Carte Stylisée (Map Placeholder) --}}
                    <div class="relative h-64 w-full bg-emerald-900 rounded-3xl overflow-hidden shadow-2xl group">
                        <div
                            class="absolute inset-0 opacity-30 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]">
                        </div>
                        {{-- Carte abstraite du Cameroun (SVG simplifié) --}}
                        <div class="absolute inset-0 flex items-center justify-center opacity-40">
                            <svg viewBox="0 0 200 300" class="h-full w-auto fill-emerald-700">
                                {{-- Forme simplifiée du Cameroun --}}
                                <path d="M50,280 L30,200 L10,150 L20,80 L80,10 L150,30 L180,100 L160,200 L120,280 Z" />
                            </svg>
                        </div>
                        {{-- Points chauds animés --}}
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <span class="relative flex h-4 w-4">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span
                                    class="relative inline-flex rounded-full h-4 w-4 bg-green-500 border-2 border-white"></span>
                            </span>
                            <span
                                class="absolute top-6 left-0 whitespace-nowrap text-xs font-bold text-white bg-black/50 px-2 py-1 rounded backdrop-blur-sm">{{ __('contactfull.contact_cards.map.title') }}</span>
                        </div>
                        <div class="absolute top-1/3 right-1/3">
                            <span class="relative flex h-3 w-3">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                <span
                                    class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500 border-2 border-white"></span>
                            </span>
                        </div>

                        <div
                            class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/80 to-transparent text-white">
                            <p class="font-semibold text-sm">{{ __('contactfull.contact_cards.map.regions') }}</p>
                        </div>
                    </div>
                </div>

                {{-- COLONNE DROITE : FORMULAIRE (7 colonnes) --}}
                <div class="">
                    <div
                        class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 border border-gray-100 relative overflow-hidden">
                        {{-- Décoration d'arrière-plan du formulaire --}}
                        <div
                            class="absolute top-0 right-0 w-40 h-40 bg-green-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -translate-y-1/2 translate-x-1/2">
                        </div>

                        <div class="relative z-10">
                            <div class="mb-10">
                                <h2 class="text-3xl font-bold text-gray-900 mb-3">{{ __('contactfull.form.title') }}</h2>
                                <p class="text-gray-600">{!! __('contactfull.form.description') !!}</p>
                            </div>

                            @if ($success)
                                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                                    class="mb-8 p-4 rounded-xl bg-green-50 border border-green-200 flex items-center gap-4 animate-fade-in-up">
                                    <div class="bg-green-100 p-2 rounded-full text-green-600 shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-green-800">{{ __('contactfull.form.success.title') }}</h4>
                                        <p class="text-green-700 text-sm">{{ __('contactfull.form.success.message') }}</p>
                                    </div>
                                </div>
                            @endif

                            <form wire:submit="submit" class="space-y-8">
                                <div class="grid md:grid-cols-2 gap-8">
                                    {{-- Nom --}}
                                    <div class="space-y-2 group">
                                        <label for="name"
                                            class="text-sm font-semibold text-gray-700 group-focus-within:text-green-600 transition-colors">{{ __('contactfull.fields.full_name') }} <span class="text-red-500">{{ __('contactfull.fields.required') }}</span></label>
                                        <div class="relative">
                                            <input type="text" id="name" wire:model="name"
                                                class="w-full pl-4 pr-4 py-4 bg-gray-50 border-transparent rounded-xl focus:bg-white focus:border-green-500 focus:ring-4 transition-all duration-300 outline-none font-medium placeholder-gray-400"
                                                placeholder="{{ __('contactfull.placeholders.name') }}">
                                            @error('name')
                                                <span
                                                    class="absolute -bottom-6 left-0 text-red-500 text-xs font-medium">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="space-y-2 group">
                                        <label for="email"
                                            class="text-sm font-semibold text-gray-700 group-focus-within:text-green-600 transition-colors">{{ __('contactfull.fields.email') }} <span class="text-red-500">{{ __('contactfull.fields.required') }}</span></label>
                                        <div class="relative">
                                            <input type="email" id="email" wire:model="email"
                                                class="w-full pl-4 pr-4 py-4 bg-gray-50 border-transparent rounded-xl focus:bg-white focus:border-green-500 focus:ring-4 transition-all duration-300 outline-none font-medium placeholder-gray-4000"
                                                placeholder="{{ __('contactfull.placeholders.email') }}">
                                            @error('email')
                                                <span
                                                    class="absolute -bottom-6 left-0 text-red-500 text-xs font-medium">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Sujet --}}
                                <div class="space-y-2 group">
                                    <label for="subject"
                                        class="text-sm font-semibold text-gray-700 group-focus-within:text-green-600 transition-colors">{{ __('contactfull.fields.subject') }} <span class="text-red-500">{{ __('contactfull.fields.required') }}</span></label>
                                    <div class="relative">
                                        <select id="subject" wire:model="subject"
                                            class="w-full pl-4 pr-10 py-4 bg-gray-50 border-transparent rounded-xl focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all duration-300 outline-none font-medium appearance-none cursor-pointer @error('subject') border-red-500 @enderror">
                                            <option value="">{{ __('contactfull.fields.choose_subject') }}</option>
                                            <option value="{{ __('contactfull.subjects.technical_support') }}">{{ __('contactfull.subjects.technical_support') }}</option>
                                            <option value="{{ __('contactfull.subjects.general_question') }}">{{ __('contactfull.subjects.general_question') }}</option>
                                            <option value="{{ __('contactfull.subjects.partnership') }}">{{ __('contactfull.subjects.partnership') }}</option>
                                            <option value="{{ __('contactfull.subjects.press') }}">{{ __('contactfull.subjects.press') }}</option>
                                            <option value="{{ __('contactfull.subjects.other') }}">{{ __('contactfull.subjects.other') }}</option>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                        @error('subject')
                                            <span
                                                class="absolute -bottom-6 left-0 text-red-500 text-xs font-medium">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Message --}}
                                <div class="space-y-2 group">
                                    <label for="message"
                                        class="text-sm font-semibold text-gray-700 group-focus-within:text-green-600 transition-colors">{{ __('contactfull.fields.message') }} <span class="text-red-500">{{ __('contactfull.fields.required') }}</span></label>
                                    <div class="relative">
                                        <textarea id="message" wire:model="message" rows="5"
                                            class="w-full pl-4 pr-4 py-4 bg-gray-50 border-transparent rounded-xl focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all duration-300 outline-none font-medium placeholder-gray-400 resize-none @error('message') border-red-500 @enderror"
                                            placeholder="{{ __('contactfull.placeholders.message') }}"></textarea>
                                        @error('message')
                                            <span
                                                class="absolute -bottom-6 left-0 text-red-500 text-xs font-medium">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="pt-4">
                                    <button type="submit" wire:loading.attr="disabled"
                                        class="w-full group relative flex items-center justify-center py-4 px-8 border border-transparent text-lg font-bold rounded-xl text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-500/30 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden disabled:opacity-70 disabled:cursor-not-allowed">
                                        <span
                                            class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer"></span>
                                        <span wire:loading.remove class="flex items-center gap-2">
                                            {{ __('contactfull.buttons.send_message') }}
                                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </span>
                                        <span wire:loading class="flex items-center gap-2">
                                            <svg class="animate-spin h-5 w-5 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            {{ __('contactfull.buttons.sending') }}
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ SECTION MODERNISÉE --}}
    <section class="py-24 bg-white relative overflow-hidden">
        {{-- Fond décoratif --}}
        <div class="absolute top-0 left-0 w-full h-full opacity-30 pointer-events-none">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle cx="1" cy="1" r="1" class="text-gray-200" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#dots)" />
            </svg>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <span class="text-green-600 font-bold tracking-wider uppercase text-sm">{{ __('contactfull.faq.title') }}</span>
                <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-4">{{ __('contactfull.faq.heading') }}</h2>
                <p class="text-xl text-gray-500 max-w-2xl mx-auto">
                    {{ __('contactfull.faq.subtitle') }}
                </p>
            </div>

            <div class="max-w-3xl mx-auto grid gap-4" x-data="{ activeAccordion: null }">
                @foreach ([
        1 => __('contactfull.questions.registration'),
        2 => __('contactfull.questions.pricing'),
        3 => __('contactfull.questions.reliability'),
        4 => __('contactfull.questions.management'),
    ] as $id => $faq)
                    <div
                        class="group border border-gray-200 rounded-2xl bg-white overflow-hidden hover:border-green-300 transition-colors duration-300">
                        <button
                            @click="activeAccordion = activeAccordion === {{ $id }} ? null : {{ $id }}"
                            class="flex justify-between items-center w-full p-6 text-left focus:outline-none">
                            <span
                                class="text-lg font-bold text-gray-900 group-hover:text-green-700 transition-colors">{{ $faq['question'] }}</span>
                            <span
                                class="ml-6 flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-gray-50 group-hover:bg-green-100 transition-colors">
                                <svg class="w-4 h-4 text-gray-600 group-hover:text-green-600 transform transition-transform duration-300"
                                    :class="activeAccordion === {{ $id }} ? 'rotate-45' : ''" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="activeAccordion === {{ $id }}" x-collapse
                            class="bg-gray-50 px-6 pb-6 text-gray-600 leading-relaxed border-t border-gray-100">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="py-16 bg-white"></div>

    <x-layouts.footer />

    {{-- Styles d'animation personnalisés --}}
    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        .animate-shimmer {
            animation: shimmer 2s infinite;
        }
    </style>
</div>