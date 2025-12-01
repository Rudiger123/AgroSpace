<div>
    <div class="relative" x-data="{ open: @entangle('showDropdown') }">
        <!-- Notification Bell Button - Design Amélioré -->
        <button 
            @click="open = !open" 
            type="button"
            class="relative p-2.5 text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 group"
            aria-label="{{ __('notifications.bell.aria_label') }}"
        >
            <!-- Bell Icon avec animation -->
            <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12" 
                 fill="none" 
                 stroke="currentColor" 
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" 
                      stroke-linejoin="round" 
                      stroke-width="2" 
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                </path>
            </svg>
    
            <!-- Unread Badge - Design Moderne -->
            @if ($unreadCount > 0)
                <span class="absolute -top-1 -right-1 flex items-center justify-center min-w-[20px] h-5 px-1.5 text-xs font-bold text-white bg-gradient-to-r from-red-500 to-red-600 rounded-full shadow-lg animate-pulse ring-2 ring-white">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
            @endif
    
            <!-- Pulse Animation Ring (quand il y a des notifications) -->
            @if ($unreadCount > 0)
                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-400 rounded-full opacity-75 animate-ping"></span>
            @endif
        </button>
    
        <!-- Dropdown Portal - Design Premium -->
        <div 
            x-show="open" 
            x-cloak
            @click.away="open = false"
            x-transition:enter="transition ease-out duration-200 transform"
            x-transition:enter-start="opacity-0 scale-95 translate-y-1"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-1"
            class="absolute right-0 mt-3 w-96 max-w-[calc(100vw-2rem)] z-50"
            style="filter: drop-shadow(0 20px 25px rgba(0, 0, 0, 0.15));"
        >
            <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-gray-900/5 overflow-hidden backdrop-blur-xl">
                <!-- Header avec dégradé -->
                <div class="px-5 py-4 bg-gradient-to-r from-primary-50 via-white to-primary-50 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">{{ __('notifications.dropdown.title') }}</h3>
                            @if ($unreadCount > 0)
                                <p class="text-xs text-gray-500">{{ $unreadCount }} {{ __('notifications.dropdown.unread', ['count' => $unreadCount]) }}</p>
                            @endif
                        </div>
                    </div>
    
                    @if ($unreadCount > 0)
                        <button 
                            wire:click="$dispatch('markAllAsRead')"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-primary-600 bg-primary-50 hover:bg-primary-100 rounded-lg transition-all duration-200 hover:scale-105 active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ __('notifications.dropdown.mark_all_read') }}</span>
                        </button>
                    @endif
                </div>
    
                <!-- Notification List Component avec scroll personnalisé -->
                <div class="max-h-[28rem] overflow-y-auto custom-scrollbar">
                    @livewire('notifications.notification-list')
                </div>
    
                <!-- Footer avec dégradé -->
                <div class="px-5 py-4 bg-gradient-to-r from-gray-50 via-white to-gray-50 border-t border-gray-100">
                    <a 
                        href="{{ route('notifications.index') }}"  wire:navigate
                        class="flex items-center justify-center gap-2 text-sm font-semibold text-primary-600 hover:text-primary-700 transition-colors duration-200 group"
                    >
                        <span>{{ __('notifications.dropdown.view_all') }}</span>
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
            </div>
    
            <!-- Triangle pointer (arrow) -->
            <div class="absolute top-0 right-4 -translate-y-2 w-4 h-4 bg-white transform rotate-45 border-l border-t border-gray-200"></div>
        </div>
    </div>
    
    <!-- Custom Scrollbar Styles -->
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
    
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
    
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #16a34a, #10b981);
            border-radius: 10px;
            transition: background 0.3s ease;
        }
    
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #15803d, #059669);
        }
    
        /* Firefox scrollbar */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #16a34a #f1f5f9;
        }
    </style>
    
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
            // Toast moderne avec animations améliorées
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 max-w-sm w-full bg-white shadow-2xl rounded-2xl pointer-events-auto ring-1 ring-gray-900/5 overflow-hidden z-[9999] transform transition-all duration-500';
            toast.style.animation = 'slideInRight 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
            
            // Type de notification (success, info, warning, error)
            const notificationType = notification.type || 'info';
            const colors = {
                'success': { bg: 'bg-green-50', border: 'border-green-500', icon: 'text-green-500', iconBg: 'bg-green-100' },
                'info': { bg: 'bg-blue-50', border: 'border-blue-500', icon: 'text-blue-500', iconBg: 'bg-blue-100' },
                'warning': { bg: 'bg-yellow-50', border: 'border-yellow-500', icon: 'text-yellow-500', iconBg: 'bg-yellow-100' },
                'error': { bg: 'bg-red-50', border: 'border-red-500', icon: 'text-red-500', iconBg: 'bg-red-100' }
            };
            
            const color = colors[notificationType] || colors['info'];
            
            toast.innerHTML = `
                <div class="relative ${color.bg} border-l-4 ${color.border}">
                    <div class="p-4">
                        <div class="flex items-start gap-3">
                            <!-- Icon avec background -->
                            <div class="flex-shrink-0 ${color.iconBg} w-10 h-10 rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 ${color.icon}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0 pt-0.5">
                                <p class="text-sm font-bold text-gray-900 mb-1">${notification.title || "{{ __('notifications.toast.default_title') }}"}</p>
                                <p class="text-sm text-gray-600 leading-relaxed">${notification.message || ''}</p>
                                ${notification.action_url ? `
                                    <a href="${notification.action_url}" class="inline-flex items-center gap-1 mt-2 text-xs font-semibold ${color.icon} hover:underline">
                                        <span>{{ __('notifications.toast.see_more') }}</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                ` : ''}
                            </div>
                            
                            <!-- Close button -->
                            <button 
                                onclick="removeToast(this)" 
                                class="flex-shrink-0 inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 hover:bg-white/80 rounded-lg transition-all duration-200"
                            >
                                <span class="sr-only">{{ __('notifications.toast.close') }}</span>
                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Progress bar -->
                    <div class="h-1 bg-gray-200 overflow-hidden">
                        <div class="${color.border.replace('border-', 'bg-')} h-full animate-shrink"></div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Auto remove after 5 seconds with fade out
            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
                setTimeout(() => toast.remove(), 500);
            }, 5000);
        }
        
        function removeToast(button) {
            const toast = button.closest('.fixed');
            toast.style.animation = 'slideOutRight 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
            setTimeout(() => toast.remove(), 500);
        }
    </script>
    
    <!-- Toast Animations -->
    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
        
        @keyframes shrink {
            from {
                width: 100%;
            }
            to {
                width: 0%;
            }
        }
        
        .animate-shrink {
            animation: shrink 5s linear;
        }
        
        /* Responsive pour mobile */
        @media (max-width: 640px) {
            .fixed.top-4.right-4 {
                top: 1rem;
                right: 1rem;
                left: 1rem;
                max-width: calc(100vw - 2rem);
            }
        }
    </style>
    @endpush
</div>