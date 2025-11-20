@extends('errors.layout')

@section('title', 'Parcelle Introuvable')
@section('code', '404')
@section('message', 'Oups ! Cette parcelle n\'existe pas.')
@section('description', 'Il semble que vous ayez labouré trop loin. La page que vous cherchez a peut-être été récoltée ou déplacée.')

@section('image')
    <!-- SVG Tractor / Field Search -->
    <svg class="w-48 h-32 mx-auto text-[#81C784]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 21h18M5 21V7l8-4 8 4v14M9 10a2 2 0 1 1-4 0v11M19 10a2 2 0 1 1-4 0v11M9 5l8-4" />
        <circle cx="12" cy="14" r="3" class="text-[#2E7D32]" stroke-width="2"/>
        <path d="M14.5 16.5L17 19" stroke-width="2" class="text-[#2E7D32]"/>
    </svg>
@endsection