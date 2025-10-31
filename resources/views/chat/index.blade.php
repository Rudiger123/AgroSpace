{{-- resources/views/chat/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Messagerie')
@section('subtitle', 'Conversations en temps réel')

@section('content')
<div class="h-full flex gap-6">
    {{-- Liste des conversations (30% de largeur) --}}
    <div class="w-1/3 h-full">
        @livewire('chat.chat-list')
    </div>

    {{-- Fenêtre de chat (70% de largeur) --}}
    <div class="flex-1 h-full">
        @livewire('chat.chat-window')
    </div>
</div>
@endsection