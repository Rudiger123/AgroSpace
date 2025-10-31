{{-- resources/views/livewire/notifications-dropdown.blade.php --}}

<div class="relative" x-data="{ open: @entangle('isOpen') }">
    {{-- Bouton cloche --}}
    <button 
        @click="open = !open"
        class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full transition"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>

        {{-- Badge non lus --}}
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 px-1.5 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    {{-- Dropdown --}}
    <div 
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-xl border border-gray-200 z-50"
        style="display: none;"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
            @if($unreadCount > 0)
                <button 
                    wire:click="markAllAsRead"
                    class="text-sm text-green-600 hover:text-green-700"
                >
                    Tout marquer comme lu
                </button>
            @endif
        </div>

        {{-- Liste des notifications --}}
        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
                <div 
                    class="p-4 border-b border-gray-100 hover:bg-gray-50 transition cursor-pointer {{ is_null($notification['read_at']) ? 'bg-green-50' : '' }}"
                    wire:click="markAsRead('{{ $notification['id'] }}')"
                >
                    <div class="flex items-start gap-3">
                        {{-- Icône selon le type --}}
                        <div class="flex-shrink-0">
                            @if($notification['type'] === 'success' || str_contains($notification['type'], 'Success'))
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @elseif($notification['type'] === 'warning' || str_contains($notification['type'], 'Warning'))
                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                            @elseif($notification['type'] === 'error' || str_contains($notification['type'], 'Error'))
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @else
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $notification['data']['title'] ?? 'Notification' }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $notification['data']['message'] ?? '' }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $notification['created_at'] }}
                            </p>
                        </div>

                        {{-- Indicateur non lu --}}
                        @if(is_null($notification['read_at']))
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <p>Aucune notification</p>
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        <div class="p-3 border-t border-gray-200">
            <a href="#" class="block text-center text-sm text-green-600 hover:text-green-700">
                Voir toutes les notifications
            </a>
        </div>
    </div>
</div>