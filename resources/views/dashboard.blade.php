{{-- resources/views/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Vue d\'ensemble de votre activité')

@section('content')
<div class="space-y-6">
    {{-- Statistiques temps réel --}}
    @livewire('dashboard-stats')

    {{-- Graphiques et autres widgets --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Widget : Activité récente --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Activité récente</h3>
            <div class="space-y-3">
                @foreach(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-900">{{ $notification->data['message'] ?? 'Notification' }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Widget : Conversations récentes --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Conversations récentes</h3>
            <div class="space-y-3">
                @foreach(auth()->user()->conversations()->take(5)->get() as $conversation)
                    <a href="{{ route('chat.index', ['conversation' => $conversation->id]) }}" class="flex items-start gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                        @if($conversation->type === 'private')
                            @php $otherUser = $conversation->getOtherParticipant(auth()->user()); @endphp
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                                {{ substr($otherUser?->name ?? '?', 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $otherUser?->name }}</p>
                                @if($conversation->lastMessage)
                                    <p class="text-xs text-gray-500 truncate">{{ Str::limit($conversation->lastMessage->content, 40) }}</p>
                                @endif
                            </div>
                        @else
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $conversation->name }}</p>
                                <p class="text-xs text-gray-500">{{ $conversation->users->count() }} membres</p>
                            </div>
                        @endif
                        @if($conversation->unreadCountFor(auth()->user()) > 0)
                            <span class="px-2 py-1 text-xs font-bold text-white bg-green-500 rounded-full">
                                {{ $conversation->unreadCountFor(auth()->user()) }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection