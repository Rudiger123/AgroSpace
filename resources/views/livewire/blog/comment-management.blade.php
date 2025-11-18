<div class="p-6 space-y-6">
    <div class="flex items-center justify-between border-b pb-4 mb-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">✨ Gestion des Commentaires</h1>
            <p class="text-sm text-gray-500 mt-1">Modérez et gérez tous les commentaires du blog</p>
        </div>
        @if (count($selected) > 0)
            <button wire:click="bulkDelete"
                class="flex items-center space-x-2 px-4 py-2 bg-red-600 text-white rounded-xl shadow-lg hover:bg-red-700 transition duration-300 transform hover:scale-[1.02]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
                <span>Supprimer ({{ count($selected) }})</span>
            </button>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Filtrage et Recherche</h2>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">🔍 Rechercher</label>
                <input type="text" wire:model.debounce.300ms="search" placeholder="Contenu, auteur, email..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">🏷️ Statut</label>
                <select wire:model="status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150 bg-white">
                    <option value="all">Tous</option>
                    <option value="pending">En attente</option>
                    <option value="approved">Approuvés</option>
                    <option value="rejected">Rejetés</option>
                    <option value="spam">Spam</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">📰 Article</label>
                <select wire:model="post_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150 bg-white">
                    <option value="">Tous les articles</option>
                    @foreach ($posts as $post)
                        <option value="{{ $post->id }}">{{ Str::limit($post->title, 25) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">🔢 Par page</label>
                <select wire:model="perPage"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 shadow-sm transition duration-150 bg-white">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" wire:model.live="selectAll"
                                class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Commentaire
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('post_id')">
                            Article
                            @if ($sortField === 'post_id')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Auteur
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('status')">
                            Statut
                            @if ($sortField === 'status')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            ❤️ Likes
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            ⚠️ Signal.
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            IP
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('created_at')">
                            Date
                            @if ($sortField === 'created_at')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($comments as $comment)
                        <tr class="hover:bg-green-50 transition duration-150" wire:key="comment-{{ $comment->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" wire:model.live="selected" value="{{ $comment->id }}"
                                    class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            </td>
                            <td class="px-6 py-4 max-w-sm">
                                <p class="text-sm text-gray-800 line-clamp-2">{{ Str::limit($comment->content, 80) }}
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-700 font-medium">{{ Str::limit($comment->post?->title, 10) ?? 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $comment->user?->name ?? ($comment->author_name ?? 'Anonyme') }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $comment->user?->email ?? ($comment->author_email ?? 'N/A') }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($comment->status === 'pending')
                                    <span
                                        class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 shadow-sm">En
                                        attente</span>
                                @elseif($comment->status === 'approved')
                                    <span
                                        class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 shadow-sm">Approuvé</span>
                                @elseif($comment->status === 'rejected')
                                    <span
                                        class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 shadow-sm">Rejeté</span>
                                @elseif($comment->status === 'spam')
                                    <span
                                        class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 shadow-sm">Spam</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="text-sm font-bold text-pink-600">{{ $comment->likes_count ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="text-sm font-bold {{ ($comment->reports_count ?? 0) > 0 ? 'text-red-600 animate-pulse' : 'text-gray-400' }}">
                                    {{ $comment->reports_count ?? 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="text-xs text-gray-600 font-mono">{{ $comment->ip_address ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-600">
                                    {{ $comment->created_at->locale('fr')->format('d/m/Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $comment->created_at->format('H:i') }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button wire:click="openDetails({{ $comment->id }})" title="Détails"
                                        class="text-blue-600 hover:text-blue-800 transition transform hover:scale-110 p-1 rounded-full hover:bg-blue-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                    @if ($comment->status !== 'approved')
                                        <button wire:click="approve({{ $comment->id }})" title="Approuver"
                                            class="text-green-600 hover:text-green-800 transition transform hover:scale-110 p-1 rounded-full hover:bg-green-50">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    @if ($comment->status !== 'rejected')
                                        <button wire:click="reject({{ $comment->id }})" title="Rejeter"
                                            class="text-red-600 hover:text-red-800 transition transform hover:scale-110 p-1 rounded-full hover:bg-red-50">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    <button wire:click="markSpam({{ $comment->id }})" title="Spam"
                                        class="text-gray-600 hover:text-gray-800 transition transform hover:scale-110 p-1 rounded-full hover:bg-gray-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="delete({{ $comment->id }})" title="Supprimer"
                                        class="text-red-600 hover:text-red-800 transition transform hover:scale-110 p-1 rounded-full hover:bg-red-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-12 text-center bg-gray-50">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-green-200 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                        </path>
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">Aucun commentaire trouvé</p>
                                    <p class="text-sm text-gray-400 mt-1">Veuillez ajuster vos filtres de recherche.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $comments->links() }}
        </div>
    </div>

    @livewire('blog.comment-drawer')
</div>

@push('scripts')
    <script>
        // ... (Les scripts SweetAlert restent inchangés et sont déjà très bien pour l'UX !)
        window.addEventListener('confirm-delete', event => {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('confirmDelete', event.detail.id);
                }
            });
        });

        window.addEventListener('confirm-bulk-delete', () => {
            Swal.fire({
                title: 'Supprimer les commentaires sélectionnés ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Oui, supprimer tout',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('confirmBulkDelete');
                }
            });
        });

        window.addEventListener('comment-approved', event => {
            Swal.fire({
                icon: 'success',
                title: 'Approuvé',
                text: event.detail.message,
                timer: 2000,
                showConfirmButton: false
            });
        });

        window.addEventListener('comment-rejected', event => {
            Swal.fire({
                icon: 'info',
                title: 'Rejeté',
                text: event.detail.message,
                timer: 2000,
                showConfirmButton: false
            });
        });

        window.addEventListener('comment-spam', event => {
            Swal.fire({
                icon: 'warning',
                title: 'Spam',
                text: event.detail.message,
                timer: 2000,
                showConfirmButton: false
            });
        });

        window.addEventListener('comment-deleted', event => {
            Swal.fire({
                icon: 'success',
                title: 'Supprimé',
                text: event.detail.message,
                timer: 2000,
                showConfirmButton: false
            });
        });

        window.addEventListener('comments-deleted', event => {
            Swal.fire({
                icon: 'success',
                title: 'Supprimés',
                text: event.detail.message,
                timer: 2000,
                showConfirmButton: false
            });
        });
    </script>
@endpush