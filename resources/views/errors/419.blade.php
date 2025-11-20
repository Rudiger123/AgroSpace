@extends('errors.layout')

@section('title', 'Session Expirée')
@section('code', '419')
@section('message', 'Temps de pause écoulé')
@section('description', 'Votre session a expiré par inactivité. Veuillez recharger la page pour reprendre votre travail.')

@section('image')
    <!-- SVG Hourglass -->
    <svg class="w-48 h-32 mx-auto text-[#81C784]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M5 22h14" />
        <path d="M5 2h14" />
        <path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22" />
        <path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2" />
    </svg>
@endsection

@section('actions')
    <button onclick="window.location.reload()" class="inline-flex items-center justify-center px-6 py-3 border-2 border-[#1B5E20] text-base font-medium rounded-xl text-[#1B5E20] bg-transparent hover:bg-[#f0fdf4] transition-colors duration-200">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
        Rafraîchir la page
    </button>
@endsection