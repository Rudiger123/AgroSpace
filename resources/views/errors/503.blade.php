@extends('errors.layout')

@section('title', __('errors.503.title'))
@section('code', '503')
@section('message', __('errors.503.message'))
@section('description', __('errors.503.description'))

@section('image')
    <!-- SVG Sprout / Growth -->
    <svg class="w-48 h-32 mx-auto text-[#2E7D32] animate-pulse" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 22v-9" stroke-width="2"/>
        <path d="M12 18c-3 0-5-2-5-5 0-3 2.5-5 5-8" />
        <path d="M12 18c3 0 5-2 5-5 0-3-2.5-5-5-8" />
        <path d="M12 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" fill="#FFB300" stroke="none"/>
    </svg>
@endsection

@section('actions')
    <!-- Auto-refresh status visual indicator -->
    <div class="flex items-center justify-center gap-2 text-sm text-gray-500 mt-4">
        <span class="relative flex h-3 w-3">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#2E7D32] opacity-75"></span>
          <span class="relative inline-flex rounded-full h-3 w-3 bg-[#1B5E20]"></span>
        </span>
        {{ __('errors.503.checking') }}
    </div>

    <script>
        // Vérifie si le site est en ligne toutes les 15 secondes
        setInterval(function() {
            fetch(window.location.href, { method: 'HEAD' })
            .then(function(response) {
                if (response.status === 200) {
                    window.location.reload();
                }
            })
            .catch(function(e) {
                console.log('{{ __("errors.503.console") }}');
            });
        }, 15000);
    </script>
@endsection@extends('errors.layout')

@section('title', __('errors.503.title'))
@section('code', '503')
@section('message', __('errors.503.message'))
@section('description', __('errors.503.description'))

@section('image')
    <!-- SVG Sprout / Growth -->
    <svg class="w-48 h-32 mx-auto text-[#2E7D32] animate-pulse" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 22v-9" stroke-width="2"/>
        <path d="M12 18c-3 0-5-2-5-5 0-3 2.5-5 5-8" />
        <path d="M12 18c3 0 5-2 5-5 0-3-2.5-5-5-8" />
        <path d="M12 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" fill="#FFB300" stroke="none"/>
    </svg>
@endsection

@section('actions')
    <!-- Auto-refresh status visual indicator -->
    <div class="flex items-center justify-center gap-2 text-sm text-gray-500 mt-4">
        <span class="relative flex h-3 w-3">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#2E7D32] opacity-75"></span>
          <span class="relative inline-flex rounded-full h-3 w-3 bg-[#1B5E20]"></span>
        </span>
        {{ __('errors.503.checking') }}
    </div>

    <script>
        // Vérifie si le site est en ligne toutes les 15 secondes
        setInterval(function() {
            fetch(window.location.href, { method: 'HEAD' })
            .then(function(response) {
                if (response.status === 200) {
                    window.location.reload();
                }
            })
            .catch(function(e) {
                console.log('{{ __("errors.503.console") }}');
            });
        }, 15000);
    </script>
@endsection