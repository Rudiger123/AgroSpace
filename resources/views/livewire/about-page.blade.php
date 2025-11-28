<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Helpers\SEO;

new #[Layout('layouts.main')] class extends Component {
    public function mount()
    {
        /* ----------  SEO  ---------- */
        SEO::setTitle(__('about.seo.title'));
        SEO::setDescription(__('about.seo.description'));
        SEO::setKeywords(__('about.seo.keywords'));
        SEO::setCanonical(url()->current());
        SEO::setImage(asset(__('about.seo.image'))); // 1200×630
        SEO::setType(__('about.seo.type'));
    }
}; ?>

@push('meta')
    {{-- Primary Meta Tags --}}
    <title>{{ __('about.seo.title') }}</title>
    <meta name="title" content="{{ __('about.seo.title') }}">
    <meta name="description" content="{{ __('about.seo.description') }}">
    <meta name="keywords" content="{{ __('about.seo.keywords') }}">
    <meta name="robots" content="index, follow">
    <meta name="language" content="{{ app()->getLocale() }}">
    <meta name="author" content="AgroSpace">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="{{ __('about.seo.type') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ __('about.seo.og_title') }}">
    <meta property="og:description" content="{{ __('about.seo.og_description') }}">
    <meta property="og:image" content="{{ asset(__('about.seo.image')) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="AgroSpace">
    <meta property="og:locale" content="{{ __('about.seo.locale') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ __('about.seo.twitter_title') }}">
    <meta name="twitter:description" content="{{ __('about.seo.twitter_description') }}">
    <meta name="twitter:image" content="{{ asset(__('about.seo.image')) }}">

    {{-- Geo-tags --}}
    <meta name="geo.region" content="{{ __('about.geo.region') }}">
    <meta name="geo.placename" content="{{ __('about.geo.placename') }}">
    <meta name="geo.position" content="{{ __('about.geo.position') }}">
    <meta name="ICBM" content="{{ __('about.geo.position') }}">
@endpush

<div>
    <x-layouts.header />

    {{-- HERO --}}
    <section id="about-hero" class="relative pt-24 pb-20 md:pt-32 md:pb-28 overflow-hidden gradient-bg" itemscope
        itemtype="https://schema.org/WPHeader">
        <div class="absolute inset-0 opacity-10 pointer-events-none" aria-hidden="true">
            <div class="absolute inset-0"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.2\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>
        </div>

        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                {{-- Left --}}
                <div class="text-white space-y-6 animate-fade-in-up">
                    {{-- SEO : only H1 of the page --}}
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        {{ __('about.hero.h1') }}
                    </h1>
                    <p class="text-xl text-gray-50 mb-8">
                        {{ __('about.hero.p') }}
                    </p>
                    <a href="{{ route('register') }}" wire:navigate title="{{ __('about.hero.cta_title') }}"
                        class="inline-flex items-center gap-2 bg-white text-base font-semibold px-8 py-4 rounded-lg 
                              shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1
                              hover:bg-gradient-to-r hover:from-green-500 hover:to-emerald-500 hover:text-white
                              focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m3-4a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                        {{ __('about.hero.cta') }}
                    </a>
                </div>

                {{-- Right Illustration --}}
                <div class="relative">
                    <div class="bg-gradient-to-br from-green-400 to-emerald-600 rounded-3xl p-8 shadow-2xl">
                        <svg class="w-full h-auto text-white" viewBox="0 0 400 300" fill="none">
                            <circle cx="200" cy="150" r="100" fill="currentColor" opacity="0.2" />
                            <path d="M150 150 L200 100 L250 150 L200 200 Z" fill="currentColor" opacity="0.3" />
                            <circle cx="150" cy="150" r="40" fill="currentColor" />
                            <circle cx="250" cy="150" r="40" fill="currentColor" />
                            <circle cx="200" cy="100" r="40" fill="currentColor" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MISSION & VISION --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12">
                {{-- Mission --}}
                <article class="bg-[#F9FAF6] p-10 rounded-2xl" itemscope itemtype="https://schema.org/AboutPage">
                    <div class="w-16 h-16 bg-[#1B5E20] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __('about.mission.title') }}</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        {{ __('about.mission.text') }}
                    </p>
                </article>

                {{-- Vision --}}
                <article class="bg-emerald-50 p-10 rounded-2xl">
                    <div class="w-16 h-16 bg-[#81C784] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __('about.vision.title') }}</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        {{ __('about.vision.text') }}
                    </p>
                </article>
            </div>
        </div>
    </section>

    {{-- VALEURS --}}
    <section class="py-20 bg-[#F9FAF6]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <header class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('about.values.header_title') }}</h2>
                <p class="text-xl text-gray-600">{{ __('about.values.header_sub') }}</p>
            </header>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach (array_filter(trans('about.values'), 'is_array') as $val)
                    <article
                        class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2">
                        <div class="text-5xl mb-4" aria-hidden="true">{{ $val['emoji'] }}</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $val['title'] }}</h3>
                        <p class="text-gray-600">{{ $val['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- HISTOIRE --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">{{ __('about.history.title') }}</h2>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        {{ __('about.history.p1') }}
                    </p>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        {{ __('about.history.p2') }}
                    </p>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        {{ __('about.history.p3') }}
                    </p>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-emerald-100 to-green-200 rounded-3xl p-8 shadow-xl">
                        <svg class="w-full h-auto text-[#1B5E20]" viewBox="0 0 400 400" fill="none">
                            <rect x="50" y="150" width="100" height="200" fill="currentColor" opacity="0.3"
                                rx="10" />
                            <rect x="250" y="100" width="100" height="250" fill="currentColor" opacity="0.5"
                                rx="10" />
                            <circle cx="200" cy="200" r="80" fill="currentColor" opacity="0.4" />
                            <path d="M100 250 Q200 200 300 250" stroke="currentColor" stroke-width="4"
                                fill="none" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ÉQUIPE --}}
    <section class="py-20 bg-emerald-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <header class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('about.team.header_title') }}</h2>
                <p class="text-xl text-gray-600">{{ __('about.team.header_sub') }}</p>
            </header>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach (array_filter(trans('about.team'), 'is_array') as $member)
                    <article
                        class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2"
                        itemscope itemtype="https://schema.org/Person">
                        <div
                            class="h-48 bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center">
                            <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center text-6xl"
                                aria-hidden="true">
                                {{ $member['emoji'] }}
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2" itemprop="name">{{ $member['name'] }}
                            </h3>
                            <p class="text-[#1B5E20] font-semibold mb-4" itemprop="jobTitle">{{ $member['role'] }}
                            </p>
                            <p class="text-gray-600" itemprop="description">{{ $member['text'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- IMPACT CHIFFRES --}}
    <section class="py-20 bg-gradient-to-br from-emerald-50 to-green-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <header class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('about.stats.header_title') }}</h2>
                <p class="text-xl text-gray-600">{{ __('about.stats.header_sub') }}</p>
            </header>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach (array_filter(trans('about.stats'), 'is_array') as $stat)
                    <article class="bg-white p-8 rounded-2xl text-center shadow-lg" itemscope
                        itemtype="https://schema.org/Number">
                        <div class="text-5xl mb-4" aria-hidden="true">{{ $stat['emoji'] }}</div>
                        <div class="text-4xl font-bold text-[#1B5E20] mb-2" itemprop="value">{{ $stat['value'] }}
                        </div>
                        <p class="text-gray-600 font-medium">{{ $stat['label'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA FINAL --}}
    <section class="py-20 bg-gradient-to-r from-[#1B5E20] to-green-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">
                {{ __('about.cta.title') }}
            </h2>
            <p class="text-xl text-green-50 mb-8">
                {{ __('about.cta.p') }}
            </p>
            <a href="{{ route('register') }}" wire:navigate title="{{ __('about.cta.button_title') }}"
                class="inline-block bg-white text-[#1B5E20] px-10 py-4 rounded-xl font-bold hover:bg-gray-100 transition shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                {{ __('about.cta.button') }}
            </a>
            <p class="text-green-100 mt-4 text-sm">{{ __('about.cta.note') }}</p>
        </div>
    </section>

    <x-layouts.footer />
</div>
