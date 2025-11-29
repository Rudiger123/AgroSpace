<?php

namespace App\Livewire\Admin;

use App\Models\Avis;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
#[Title('Gestion des Avis')]
class AvisManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $noteFilter = 'all';
    public $visibilityFilter = 'all';
    public $verifiedFilter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public $showDetailsModal = false;
    public $showDeleteModal = false;
    public $showToggleVisibilityModal = false;
    public $selectedAvis = null;
    public $isAdmin;

    public $stats = [];

    protected $queryString = ['search', 'noteFilter', 'visibilityFilter', 'verifiedFilter'];

    public function mount()
    {
        $this->isAdmin = Auth::user()->isAdmin();
        $this->loadStats();
    }

    public function loadStats()
    {
        $userId = Auth::id();
        $baseQuery = Avis::query();

        if (!$this->isAdmin) {
            $baseQuery->where('producer_id', $userId);
        }

        $this->stats['total'] = (clone $baseQuery)->count();
        $this->stats['visible'] = (clone $baseQuery)->where('is_visible', true)->count();
        $this->stats['moyenne'] = number_format((clone $baseQuery)->avg('note') ?? 0, 1);
        $this->stats['verified'] = (clone $baseQuery)->where('is_verified', true)->count();
        $this->stats['hidden'] = $this->stats['total'] - $this->stats['visible'];
    }

    public function updating($key)
    {
        if (in_array($key, ['search', 'noteFilter', 'visibilityFilter', 'verifiedFilter'])) {
            $this->resetPage();
        }
    }

    public function updated()
    {
        $this->loadStats();
    }

    public function render()
    {
        $userId = Auth::id();

        $avisQuery = Avis::with(['producer:id,name', 'consumer:id,name', 'offer:id,titre'])
            ->when(!$this->isAdmin, fn ($q) => $q->where('producer_id', $userId))
            ->when($this->search, function ($query) {
                $query->where('commentaire', 'like', "%{$this->search}%")
                      ->orWhereHas('consumer', fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
                      ->orWhereHas('producer', fn ($q) => $q->where('name', 'like', "%{$this->search}%"));
            })
            ->when($this->noteFilter !== 'all', fn ($q) => $q->where('note', $this->noteFilter))
            ->when($this->visibilityFilter !== 'all', fn ($q) => $q->where('is_visible', $this->visibilityFilter === 'true'))
            ->when($this->verifiedFilter !== 'all', fn ($q) => $q->where('is_verified', $this->verifiedFilter === 'true'))
            ->orderBy($this->sortBy, $this->sortDirection);

        $avis = $avisQuery->paginate(15);

        return view('livewire.admin.avis-management', [
            'avis' => $avis,
        ]);
    }

    public function openToggleVisibilityModal($avisId)
    {
        $this->selectedAvis = Avis::findOrFail($avisId);
        $this->showToggleVisibilityModal = true;
    }

    public function toggleVisibility()
    {
        $avis = $this->selectedAvis;
        $avis->is_visible = !$avis->is_visible;
        $avis->save();
        $this->showToggleVisibilityModal = false;
        $this->loadStats();
        $this->dispatch('toast', ['type' => 'success', 'message' => "L'avis a été " . ($avis->is_visible ? 'rendu visible' : 'masqué') . " avec succès."]);
    }

    public function openDeleteModal($avisId)
    {
        if (!$this->isAdmin) {
            return;
        }
        $this->selectedAvis = Avis::find($avisId);
        $this->showDeleteModal = true;
    }

    public function deleteAvis()
    {
        if (!$this->isAdmin || !$this->selectedAvis) {
            return;
        }
        $this->selectedAvis->delete();
        $this->showDeleteModal = false;
        $this->selectedAvis = null;
        $this->loadStats();
        $this->dispatch('toast', ['type' => 'success', 'message' => "L'avis a été supprimé avec succès."]);
    }

    public function openDetailsModal($avisId)
    {
        $this->selectedAvis = Avis::with(['producer', 'consumer', 'offer'])->find($avisId);
        $this->showDetailsModal = true;
    }

    public function closeModals()
    {
        $this->showDetailsModal = false;
        $this->showDeleteModal = false;
        $this->showToggleVisibilityModal = false;
        $this->selectedAvis = null;
    }
}
