@extends('errors.layout')

@section('title', 'Trop de requêtes')
@section('code', '429')
@section('message', 'Doucement sur la pédale !')
@section('description', 'Vous envoyez trop de demandes au serveur. Laissez un peu de temps à la nature pour respirer.')

@section('image')
    <!-- SVG Speedometer -->
    <svg class="w-48 h-32 mx-auto text-[#FFB300]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 14a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
        <path d="M12 14L16.24 9.76" class="text-[#37474F]" stroke-width="2"/>
        <path d="M20.38 18.38A10 10 0 1 0 3.62 18.38" />
    </svg>
@endsection