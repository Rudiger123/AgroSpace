<div class="relative" x-data="{ open: @entangle('showDropdown') }">
    <!-- Notification Bell Button -->
    <button 
        @click="open = !open" 
        type="button"
        class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
        aria-label="Notifications"
    >
        <!-- Bell Icon -->
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
            </path>
        </svg>

        <!-- Unread Badge -->
        @if ($unreadCount > 0)
            <span class="absolute top-1 right-1 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full animate-pulse">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown Portal -->
    <div 
        x-show="open" 
        x-cloak
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute right-0 mt-2 w-96 max-w-sm z-50"
    >
        <div class="bg-white rounded-lg shadow-xl ring-1 ring-black ring-opacity-5 overflow-hidden">
            <!-- Header -->
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                @if ($unreadCount > 0)
                    <button 
                        wire:click="$dispatch('markAllAsRead')"
                        class="text-xs text-primary-600 hover:text-primary-800 font-medium"
                    >
                        Tout marquer comme lu
                    </button>
                @endif
            </div>

            <!-- Notification List Component -->
            <div class="max-h-96 overflow-y-auto">
                @livewire('notifications.notification-list')
            </div>

            <!-- Footer -->
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                <a 
                    href="#" 
                    class="block text-center text-sm font-medium text-primary-600 hover:text-primary-800"
                >
                    Voir toutes les notifications
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Listen for real-time notifications via Echo
    @if(auth()->check())
    window.Echo.private('notifications.{{ auth()->id() }}')
        .notification((notification) => {
            console.log('Notification received:', notification);
            
            // Update the bell counter
            @this.call('incrementUnreadCount');
            
            // Show toast notification
            showToast(notification);
        });
    @endif

    function showToast(notification) {
        // Simple toast implementation (you can use a library like Notyf, SweetAlert2, etc.)
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden z-50';
        toast.innerHTML = `
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium text-gray-900">${notification.title || 'Nouvelle notification'}</p>
                        <p class="mt-1 text-sm text-gray-500">${notification.message || ''}</p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button onclick="this.parentElement.parentElement.parentElement.parentElement.remove()" class="inline-flex text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Fermer</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }
</script>
@endpush