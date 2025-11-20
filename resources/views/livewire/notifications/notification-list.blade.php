<div>
    @if ($notifications->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
            <div class="bg-gray-50 rounded-full p-4 mb-3 ring-1 ring-gray-100 shadow-sm">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
            </div>
            <h3 class="text-sm font-bold text-gray-900">C'est calme par ici</h3>
            <p class="mt-1 text-xs text-gray-500 max-w-[200px]">Vous êtes à jour ! Aucune nouvelle notification pour le moment.</p>
        </div>
    @else
        <div class="divide-y divide-gray-100">
            @foreach ($notifications as $notification)
                @php
                    $data = $notification->data;
                    $isUnread = is_null($notification->read_at);
                    
                    // Gestion des couleurs et icones directement en PHP/Blade (plus propre que JS)
                    $colorType = $data['color'] ?? 'primary';
                    $colors = [
                        'success' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'border' => 'border-green-500'],
                        'info'    => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'border-blue-500'],
                        'warning' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-600', 'border' => 'border-yellow-500'],
                        'danger'  => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'border' => 'border-red-500'],
                        'primary' => ['bg' => 'bg-primary-50', 'text' => 'text-primary-600', 'border' => 'border-primary-500'],
                        'gray'    => ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'border' => 'border-gray-500'],
                    ];
                    $theme = $colors[$colorType] ?? $colors['primary'];
                @endphp

                <div 
                    wire:key="notification-{{ $notification->id }}"
                    class="group relative px-4 py-4 hover:bg-gray-50 transition-all duration-200 {{ $isUnread ? 'bg-gradient-to-r from-' . substr($theme['bg'], 3) . '/40 to-transparent' : 'bg-white' }}"
                >
                    @if ($isUnread)
                        <div class="absolute left-0 top-0 bottom-0 w-1 {{ $theme['bg'] }} {{ $theme['border'] }} border-l-2"></div>
                    @endif

                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 pt-1">
                            <div class="w-10 h-10 rounded-xl {{ $theme['bg'] }} {{ $theme['text'] }} flex items-center justify-center shadow-sm ring-1 ring-black/5">
                                @switch($data['icon'] ?? 'bell')
                                    @case('shopping-bag')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        @break
                                    @case('user')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        @break
                                    @case('warning')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        @break
                                    @default
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                @endswitch
                            </div>
                        </div>

                        <div class="flex-1 min-w-0 relative">
                            <button 
                                wire:click="handleNotificationClick('{{ $notification->id }}', '{{ $data['action_url'] ?? '' }}')"
                                class="block w-full text-left focus:outline-none group-hover:pr-8 transition-all"
                            >
                                <div class="flex justify-between items-start mb-0.5">
                                    <p class="text-sm font-bold text-gray-900 truncate pr-2">
                                        {{ $data['title'] ?? 'Notification' }}
                                    </p>
                                    <span class="text-[10px] font-medium text-gray-400 whitespace-nowrap ml-2">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
                                    {{ $data['message'] ?? '' }}
                                </p>
                            </button>
                        </div>
                        
                        <div class="flex flex-col items-center justify-start gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 absolute right-2 top-4">
                            @if ($isUnread)
                                <button
                                    wire:click.stop="markAsRead('{{ $notification->id }}')"
                                    class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-600 transition-colors"
                                    title="Marquer comme lu"
                                >
                                    <span class="w-2 h-2 rounded-full bg-blue-600 block"></span>
                                </button>
                            @endif

                            <button
                                wire:click.stop="deleteNotification('{{ $notification->id }}')"
                                class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-600 transition-colors"
                                title="Supprimer"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>