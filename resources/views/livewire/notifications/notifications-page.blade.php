<div class="min-h-screen bg-accent/30 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-base tracking-tight">Centre de Notifications</h1>
                <p class="text-sm text-gray-500 mt-1">Gérez vos alertes AgroSpace.</p>
            </div>
            
            <div class="flex space-x-3">
                @if($notifications->count() > 0)
                    <button 
                        wire:click="markAllRead" 
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-medium text-gray-700 text-sm hover:bg-gray-50 shadow-sm transition-all"
                    >
                        <svg class="w-4 h-4 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Tout lire
                    </button>
                    
                    <button 
                        wire:click="deleteAll"
                        onclick="confirm('Êtes-vous sûr de vouloir tout supprimer ?') || event.stopImmediatePropagation()" 
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-medium text-red-600 text-sm hover:bg-red-50 shadow-sm transition-all"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Tout vider
                    </button>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 p-1.5 inline-flex">
            @foreach(['all' => 'Toutes', 'unread' => 'Non lues', 'read' => 'Archives'] as $key => $label)
                <button 
                    wire:click="setFilter('{{ $key }}')"
                    class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 {{ $filter === $key ? 'bg-primary-100 text-primary-800 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div class="bg-white shadow-xl shadow-primary-900/5 rounded-2xl border border-gray-100 overflow-hidden">
            <ul class="divide-y divide-gray-100">
                @forelse($notifications as $notification)
                    @php 
                        $type = $notification->data['type'] ?? 'info';
                        $isRead = !is_null($notification->read_at);
                    @endphp
                    
                    <li class="group hover:bg-primary-50/30 transition-colors duration-150 {{ !$isRead ? 'bg-primary-50/10' : '' }}">
                        <div class="px-6 py-5 flex items-start space-x-4">
                            
                            <div class="flex-shrink-0 pt-1">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl ring-1 ring-inset ring-black/5 
                                    {{ $type === 'success' ? 'bg-green-50 text-green-600' : '' }}
                                    {{ $type === 'warning' ? 'bg-yellow-50 text-yellow-600' : '' }}
                                    {{ $type === 'danger' ? 'bg-red-50 text-red-600' : '' }}
                                    {{ $type === 'info' ? 'bg-blue-50 text-blue-600' : '' }}
                                ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </span>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="text-sm font-bold text-gray-900 truncate {{ !$isRead ? 'text-base' : '' }}">
                                        {{ $notification->data['title'] ?? 'Titre manquant' }}
                                        @if(!$isRead)
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary-100 text-primary-800">
                                                Nouveau
                                            </span>
                                        @endif
                                    </p>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-400">{{ $notification->created_at->isoFormat('D MMM HH:mm') }}</span>
                                        
                                        <button wire:click="delete('{{ $notification->id }}')" class="text-gray-300 hover:text-red-500 transition-colors p-1 opacity-0 group-hover:opacity-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>

                                @if(!$isRead)
                                    <div class="mt-3">
                                        <button 
                                            wire:click="markAsRead('{{ $notification->id }}')" 
                                            class="text-xs font-semibold text-primary-600 hover:text-primary-700 hover:underline"
                                        >
                                            Marquer comme lu
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-6 py-12 text-center">
                        <div class="mx-auto h-12 w-12 text-gray-300 rounded-full bg-gray-50 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900">C'est tout propre !</h3>
                        <p class="mt-1 text-sm text-gray-500">Aucune notification dans cette catégorie.</p>
                    </li>
                @endforelse
            </ul>
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</div>