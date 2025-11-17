<div class="p-6 space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Commentaires</h1>
            <p class="text-sm text-gray-500 mt-1">Modérez et gérez tous les commentaires du blog</p>
        </div>
        @if (count($selected) > 0)
            <button wire:click="bulkDelete"
                class="flex items-center space-x-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
                <span>Supprimer ({{ count($selected) }})</span>
            </button>
        @endif
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl shadow-sm p-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                <input type="text" wire:model.debounce.300ms="search" placeholder="Rechercher par contenu, auteur..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select wire:model="status"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="all">Tous</option>
                    <option value="pending">En attente</option>
                    <option value="approved">Approuvés</option>
                    <option value="rejected">Rejetés</option>
                    <option value="spam">Spam</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Article</label>
                <select wire:model="post_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Tous les articles</option>
                    @foreach ($posts as $post)
                        <option value="{{ $post->id }}">{{ $post->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Par page</label>
                <select wire:model="perPage"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Comments Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left">
                            <input type="checkbox" wire:model="selectAll"
                                class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Commentaire</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer"
                            wire:click="sortBy('post_id')">
                            Article
                            @if ($sortField === 'post_id')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Auteur</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700 cursor-pointer"
                            wire:click="sortBy('status')">
                            Statut
                            @if ($sortField === 'status')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Likes</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Signalements</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">IP</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer"
                            wire:click="sortBy('created_at')">
                            Date
                            @if ($sortField === 'created_at')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($comments as $comment)
                        <tr class="hover:bg-gray-50 transition" wire:key="comment-{{ $comment->id }}">
                            <td class="px-4 py-3">
                                <input type="checkbox" wire:model="selected" value="{{ $comment->id }}"
                                    class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm text-gray-800 line-clamp-2">{{ Str::limit($comment->content, 80) }}
                                </p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm text-gray-700 font-medium">{{ $comment->post?->title ?? 'N/A' }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">
                                        {{ $comment->user?->name ?? ($comment->author_name ?? 'Anonyme') }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $comment->user?->email ?? ($comment->author_email ?? 'N/A') }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if ($comment->status === 'pending')
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">En
                                        attente</span>
                                @elseif($comment->status === 'approved')
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approuvé</span>
                                @elseif($comment->status === 'rejected')
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejeté</span>
                                @elseif($comment->status === 'spam')
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Spam</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span
                                    class="text-sm font-semibold text-pink-600">{{ $comment->likes_count ?? 0 }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span
                                    class="text-sm font-semibold {{ ($comment->reports_count ?? 0) > 0 ? 'text-red-600' : 'text-gray-400' }}">
                                    {{ $comment->reports_count ?? 0 }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="text-xs text-gray-600 font-mono">{{ $comment->ip_address ?? 'N/A' }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-xs text-gray-600">
                                    {{ $comment->created_at->locale('fr')->format('d/m/Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $comment->created_at->format('H:i') }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center space-x-2">
                                    <button wire:click="openDetails({{ $comment->id }})" title="Détails"
                                        class="text-blue-600 hover:text-blue-800">
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
                                            class="text-green-600 hover:text-green-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    @if ($comment->status !== 'rejected')
                                        <button wire:click="reject({{ $comment->id }})" title="Rejeter"
                                            class="text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    <button wire:click="markSpam({{ $comment->id }})" title="Spam"
                                        class="text-gray-600 hover:text-gray-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="delete({{ $comment->id }})" title="Supprimer"
                                        class="text-red-600 hover:text-red-800">
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
                            <td colspan="10" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                        </path>
                                    </svg>
                                    <p class="text-gray-500 text-lg">Aucun commentaire trouvé</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t">
            {{ $comments->links() }}
        </div>
    </div>

    @livewire('blog.comment-drawer')
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
