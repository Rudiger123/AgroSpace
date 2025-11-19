<div>
    @if ($notifications->isEmpty())
        <!-- Empty State -->
        <div class="px-6 py-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                </path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune notification</h3>
            <p class="mt-1 text-sm text-gray-500">Vous n'avez aucune notification pour le moment.</p>
        </div>
    @else
        <!-- Notifications List -->
        <div class="divide-y divide-gray-200">
            @foreach ($notifications as $notification)
                @php
                    $data = $notification->data;
                    $isUnread = is_null($notification->read_at);
                    $iconConfig = $this->getIconConfig($data['icon'] ?? 'bell', $data['color'] ?? 'gray');
                @endphp

                <div 
                    wire:key="notification-{{ $notification->id }}"
                    class="relative px-4 py-3 hover:bg-gray-50 transition-colors duration-150 {{ $isUnread ? 'bg-blue-50' : 'bg-white' }}"
                >
                    <div class="flex items-start space-x-3">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full {{ $iconConfig }} flex items-center justify-center">
                                {!! $this->getIconSvg($data['icon'] ?? 'bell', $iconConfig) !!}
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <button 
                                wire:click="handleNotificationClick('{{ $notification->id }}', '{{ $data['action_url'] ?? '' }}')"
                                class="block w-full text-left focus:outline-none"
                            >
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $data['title'] ?? 'Notification' }}
                                </p>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                    {{ $data['message'] ?? '' }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </button>
                        </div>

                        <!-- Actions -->
                        <div class="flex-shrink-0 flex items-center space-x-2">
                            <!-- Unread Indicator -->
                            @if ($isUnread)
                                <button
                                    wire:click="markAsRead('{{ $notification->id }}')"
                                    class="w-2 h-2 rounded-full bg-blue-500 hover:bg-blue-600"
                                    title="Marquer comme lu"
                                ></button>
                            @endif

                            <!-- Delete Button -->
                            <button
                                wire:click="deleteNotification('{{ $notification->id }}')"
                                class="p-1 text-gray-400 hover:text-red-500 rounded transition-colors"
                                title="Supprimer"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M6 18L18 6M6 6l12 12">
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

@script
<script>
    // Helper function to get icon configuration
    $wire.getIconConfig = function(icon, color) {
        const colorMap = {
            'green': { bg: 'bg-green-100', text: 'text-green-600' },
            'blue': { bg: 'bg-blue-100', text: 'text-blue-600' },
            'yellow': { bg: 'bg-yellow-100', text: 'text-yellow-600' },
            'orange': { bg: 'bg-orange-100', text: 'text-orange-600' },
            'red': { bg: 'bg-red-100', text: 'text-red-600' },
            'purple': { bg: 'bg-purple-100', text: 'text-purple-600' },
            'pink': { bg: 'bg-pink-100', text: 'text-pink-600' },
            'indigo': { bg: 'bg-indigo-100', text: 'text-indigo-600' },
            'gray': { bg: 'bg-gray-100', text: 'text-gray-600' },
        };
        
        return colorMap[color] || colorMap['gray'];
    };

    // Helper function to get icon SVG
    $wire.getIconSvg = function(icon, colorClass) {
        const icons = {
            'bell': '<svg class="w-5 h-5 ' + colorClass + '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>',
            'shopping-bag': '<svg class="w-5 h-5 ' + colorClass + '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>',
            'star': '<svg class="w-5 h-5 ' + colorClass + '" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>',
            'newspaper': '<svg class="w-5 h-5 ' + colorClass + '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>',
            'user': '<svg class="w-5 h-5 ' + colorClass + '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
        };
        
        return icons[icon] || icons['bell'];
    };
</script>
@endscript