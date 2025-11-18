<?php

use Livewire\Volt\Component;
use App\Models\Comment;

new class extends Component {
    // ... (Le reste de la classe PHP reste inchangé)
    public $isOpen = false;
    public $comment = null;
    public $replyContent = '';

    protected $listeners = ['openCommentDrawer' => 'open'];

    public function open($commentId)
    {
        $this->comment = Comment::with(['post:id,title', 'user:id,name,email,avatar', 'replies.user', 'parent'])
            ->withCount(['likes', 'reports'])
            ->findOrFail($commentId);
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
        $this->comment = null;
        $this->replyContent = '';
    }

    public function reply()
    {
        $this->validate(
            [
                'replyContent' => 'required|min:3|max:1000',
            ],
            [
                'replyContent.required' => 'La réponse ne peut pas être vide',
                'replyContent.min' => 'La réponse doit contenir au moins 3 caractères',
                'replyContent.max' => 'La réponse ne peut pas dépasser 1000 caractères',
            ],
        );

        Comment::create([
            'post_id' => $this->comment->post_id,
            'user_id' => auth()->id(),
            'parent_id' => $this->comment->id,
            'content' => $this->replyContent,
            'status' => 'approved',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $this->replyContent = '';
        $this->open($this->comment->id);
        $this->dispatch('reply-sent', ['message' => 'Réponse envoyée avec succès']);
    }

    public function approve()
    {
        $this->comment->update(['status' => 'approved']);
        $this->open($this->comment->id);
        $this->dispatch('$refresh');
    }

    public function reject()
    {
        $this->comment->update(['status' => 'rejected']);
        $this->open($this->comment->id);
        $this->dispatch('$refresh');
    }

    public function markSpam()
    {
        $this->comment->update(['status' => 'spam']);
        $this->open($this->comment->id);
        $this->dispatch('$refresh');
    }

    public function delete()
    {
        $this->comment->delete();
        $this->close();
        $this->dispatch('$refresh');
        $this->dispatch('comment-deleted-drawer', ['message' => 'Commentaire supprimé']);
    }
}; ?>

<div>
    <div>
        @if ($isOpen && $comment)
            <div class="fixed inset-0 z-50 overflow-hidden" x-data="{ show: @entangle('isOpen') }" x-show="show" style="display: none;">
                <div class="absolute inset-0 bg-gray-900 bg-opacity-75 transition-opacity" x-show="show"
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" wire:click="close"></div>

                <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div class="w-screen max-w-2xl" x-show="show"
                        x-transition:enter="transform transition ease-in-out duration-500"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">

                        <div class="flex h-full flex-col bg-white shadow-2xl overflow-y-auto rounded-l-2xl">
                            <div class="bg-green-600 px-6 py-4 flex items-center justify-between sticky top-0 z-10 shadow-md">
                                <h2 class="text-xl font-bold text-white">Détails du Commentaire</h2>
                                <button wire:click="close" class="text-white hover:text-green-200 transition p-1 rounded-full hover:bg-green-700">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="flex-1 px-6 py-6 space-y-6">
                                <div class="flex flex-wrap items-center gap-4 border-b pb-4">
                                    @if ($comment->status === 'pending')
                                        <span
                                            class="inline-flex px-4 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800 shadow-sm">⏳ En
                                            attente</span>
                                    @elseif($comment->status === 'approved')
                                        <span
                                            class="inline-flex px-4 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800 shadow-sm">✅ Approuvé</span>
                                    @elseif($comment->status === 'rejected')
                                        <span
                                            class="inline-flex px-4 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800 shadow-sm">❌ Rejeté</span>
                                    @elseif($comment->status === 'spam')
                                        <span
                                            class="inline-flex px-4 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800 shadow-sm">🚫 Spam</span>
                                    @endif

                                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                                        <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="font-bold">{{ $comment->likes_count }}</span>
                                    </div>

                                    @if ($comment->reports_count > 0)
                                        <div class="flex items-center space-x-2 text-sm text-red-600 font-semibold animate-pulse">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="font-bold">{{ $comment->reports_count }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                                        <p class="text-xs text-green-700 font-bold mb-1">Article Associé</p>
                                        <p class="text-sm font-semibold text-gray-800">{{ $comment->post->title }}</p>
                                    </div>
                                    <div class="flex items-center space-x-4 bg-gray-50 rounded-xl p-4 border border-gray-200">
                                        <img src="{{ $comment->user?->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->author_name ?? 'Anonyme') . '&background=10b981&color=fff' }}"
                                            class="w-10 h-10 rounded-full shadow-md" alt="Avatar">
                                        <div>
                                            <p class="font-semibold text-gray-800 text-sm">
                                                {{ $comment->user?->name ?? ($comment->author_name ?? 'Anonyme') }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $comment->user?->email ?? ($comment->author_email ?? 'N/A') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white border border-gray-300 rounded-xl p-6 shadow-sm">
                                    <p class="text-gray-900 leading-relaxed text-base">{{ $comment->content }}</p>
                                </div>
                                
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div class="bg-gray-100 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 mb-1">Publié le</p>
                                        <p class="text-sm font-semibold text-gray-800">
                                            {{ $comment->created_at->locale('fr')->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-100 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 mb-1">Adresse IP</p>
                                        <p class="text-sm font-mono text-gray-800">{{ $comment->ip_address ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-100 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 mb-1">Navigateur (User-Agent)</p>
                                        <p class="text-sm text-gray-800 truncate"
                                            title="{{ $comment->user_agent ?? 'N/A' }}">
                                            {{ Str::limit($comment->user_agent ?? 'N/A', 25) }}
                                        </p>
                                    </div>
                                </div>

                                @if ($comment->parent)
                                    <div class="border-l-4 border-green-500 pl-4 bg-green-50 rounded-r-lg p-3">
                                        <p class="text-xs text-green-700 font-bold mb-2">En réponse au commentaire de:</p>
                                        <div class="bg-white rounded p-3 shadow-sm">
                                            <p class="text-sm font-medium text-gray-800 mb-1">
                                                {{ $comment->parent->user?->name ?? 'Anonyme' }}</p>
                                            <p class="text-sm text-gray-600 italic">
                                                {{ Str::limit($comment->parent->content, 100) }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($comment->replies->count() > 0)
                                    <div class="pt-4">
                                        <h3 class="text-lg font-bold text-gray-800 mb-4">💬 Réponses ({{ $comment->replies->count() }})</h3>
                                        <div class="space-y-4">
                                            @foreach ($comment->replies as $reply)
                                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 shadow-sm">
                                                    <div class="flex items-start space-x-3">
                                                        <img src="{{ $reply->user?->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($reply->user?->name ?? 'Anonyme') . '&background=10b981&color=fff' }}"
                                                            class="w-8 h-8 rounded-full" alt="Avatar">
                                                        <div class="flex-1">
                                                            <p class="text-sm font-semibold text-gray-800">
                                                                {{ $reply->user?->name ?? 'Anonyme' }}</p>
                                                            <p class="text-xs text-gray-500">
                                                                {{ $reply->created_at->locale('fr')->diffForHumans() }}
                                                            </p>
                                                            <p class="text-sm text-gray-700 mt-2">{{ $reply->content }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="bg-green-50 rounded-xl p-5 border border-green-200">
                                    <label class="block text-sm font-bold text-green-800 mb-2">✍️ Répondre au
                                        commentaire (en tant qu'administrateur)</label>
                                    <textarea wire:model.defer="replyContent" rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 shadow-inner transition duration-150"
                                        placeholder="Votre réponse..."></textarea>
                                    @error('replyContent')
                                        <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                                    @enderror
                                    <button wire:click="reply"
                                        class="mt-3 px-6 py-2 bg-green-600 text-white text-sm font-bold rounded-xl hover:bg-green-700 transition duration-300 transform hover:scale-[1.02] shadow-lg">
                                        Envoyer la réponse
                                    </button>
                                </div>
                            </div>

                            <div class="bg-gray-50 px-6 py-4 border-t flex items-center justify-between sticky bottom-0 z-10 shadow-inner">
                                <div class="flex space-x-3">
                                    @if ($comment->status !== 'approved')
                                        <button wire:click="approve"
                                            class="flex items-center space-x-2 px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition shadow-md text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Approuver</span>
                                        </button>
                                    @endif
                                    @if ($comment->status !== 'rejected')
                                        <button wire:click="reject"
                                            class="flex items-center space-x-2 px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition shadow-md text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            <span>Rejeter</span>
                                        </button>
                                    @endif
                                    <button wire:click="markSpam"
                                        class="flex items-center space-x-2 px-4 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition shadow-md text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                        <span>Spam</span>
                                    </button>
                                </div>
                                <button wire:click="delete"
                                    class="flex items-center space-x-2 px-4 py-2 bg-red-800 text-white rounded-xl hover:bg-red-900 transition shadow-lg text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    <span>Supprimer</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            // ... (Les scripts SweetAlert restent inchangés et sont parfaits !)
            window.addEventListener('reply-sent', event => {
                Swal.fire({
                    icon: 'success',
                    title: 'Envoyé',
                    text: event.detail.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            });

            window.addEventListener('comment-deleted-drawer', event => {
                Swal.fire({
                    icon: 'success',
                    title: 'Supprimé',
                    text: event.detail.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        </script>
    @endpush
</div>