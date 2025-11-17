<?php

namespace App\Livewire\Blog;


use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Gestion des Commentaires')]
class CommentManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'all';
    public $post_id = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $selected = [];
    public $selectAll = false;

    protected $queryString = ['search', 'status', 'post_id', 'sortField', 'sortDirection'];
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $comments = Comment::with(['post:id,title', 'user:id,name,email'])
            ->when($this->search, fn($q) => $q->search($this->search))
            ->when($this->status !== 'all', fn($q) => $q->where('status', $this->status))
            ->when($this->post_id, fn($q) => $q->where('post_id', $this->post_id))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.blog.comment-management', [
            'comments' => $comments,
            'posts' => Post::select('id', 'title')->get()
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingPostId()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['status' => 'approved', 'moderated_at' => now(), 'moderated_by' => Auth::user()->id]);
        $this->dispatch('comment-approved', ['message' => 'Commentaire approuvé avec succès']);
    }

    public function reject($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['status' => 'rejected', 'moderated_at' => now(), 'moderated_by' => Auth::user()->id]);
        $this->dispatch('comment-rejected', ['message' => 'Commentaire rejeté']);
    }

    public function markSpam($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['status' => 'spam', 'moderated_at' => now(), 'moderated_by' => Auth::user()->id]);
        $this->dispatch('comment-spam', ['message' => 'Commentaire marqué comme spam']);
    }

    public function delete($id)
    {
        $this->dispatch('confirm-delete', ['id' => $id]);
    }

    public function confirmDelete($id)
    {
        Comment::findOrFail($id)->delete();
        $this->dispatch('comment-deleted', ['message' => 'Commentaire supprimé']);
    }

    public function openDetails($id)
    {
        $this->dispatch('openCommentDrawer', $id);
    }

    public function bulkDelete()
    {
        if (empty($this->selected)) {
            $this->dispatch('alert', ['message' => 'Aucun commentaire sélectionné']);
            return;
        }

        $this->dispatch('confirm-bulk-delete');
    }

    public function confirmBulkDelete()
    {
        Comment::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        $this->dispatch('comments-deleted', ['message' => count($this->selected) . ' commentaires supprimés']);
    }

    public function updatedSelectAll($value)
    { 
        if ($value) {
            $this->selected = Comment::when($this->search, fn($q) => $q->search($this->search))
                ->when($this->status !== 'all', fn($q) => $q->where('status', $this->status))
                ->when($this->post_id, fn($q) => $q->where('post_id', $this->post_id))
                ->pluck('id')
                ->toArray();
        } else {
            $this->selected = [];
        }
    }
}
