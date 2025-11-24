<?php

namespace App\Livewire\Admin;

use App\Models\Avis;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
#[Title('Gestion des Avis')]
class AvisManagement extends Component
{
    use WithPagination;

    // --- Propriétés de Filtrage et Tri ---
    public $search = '';
    public $noteFilter = 'all';
    public $visibilityFilter = 'all';
    public $verifiedFilter = 'all';
    public $sortBy = 'date_creation';
    public $sortDirection = 'desc';

    // --- Modales et État ---
    public $showDetailsModal = false;
    public $showDeleteModal = false;
    public $showToggleVisibilityModal = false;
    public $selectedAvis = null;

    // Déterminer si l'utilisateur est un administrateur
    public $isAdmin;

    protected $queryString = ['search', 'noteFilter', 'visibilityFilter', 'verifiedFilter'];

    public function mount()
    {
        // Supposons que l'Admin a un rôle 'admin'
        $this->isAdmin = Auth::user()->isAdmin();
    }

    // Événements d'écoute pour réinitialiser la pagination
    public function updating($key)
    {
        if (in_array($key, ['search', 'noteFilter', 'visibilityFilter', 'verifiedFilter'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $userId = Auth::id();

        // 1. Logique de la requête principale
        $avisQuery = Avis::with(['producer:id,name', 'consumer:id,name', 'offer:id,titre'])

            // CONVENTION: Admin voit TOUT. Producteur voit SEULEMENT ses avis.
            ->when(!$this->isAdmin, fn ($q) => $q->where('producer_id', $userId))

            // Application de la recherche et des filtres
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

        // 2. Logique des statistiques (adaptée au rôle)
        $stats = $this->getAvisStats($this->isAdmin ? null : $userId);

        return view('livewire.admin.avis-management', [
            'avis' => $avis,
            'stats' => $stats,
        ]);
    }

    // Méthode pour générer les données statistiques (pour ApexCharts)
    public function getAvisStats($producerId = null)
    {
        $baseQuery = Avis::query();
        if ($producerId) {
            $baseQuery->where('producer_id', $producerId);
        }

        $total = (clone $baseQuery)->count();
        $visible = (clone $baseQuery)->where('is_visible', true)->count();
        $moyenne = number_format((clone $baseQuery)->avg('note') ?? 0, 1);
        $verified = (clone $baseQuery)->where('is_verified', true)->count();

        // Distribution des notes (pour l'histogramme)
        $distribution = (clone $baseQuery)->select('note', DB::raw('count(*) as count'))
                            ->groupBy('note')
                            ->pluck('count', 'note')
                            ->toArray();

        $notesData = [];
        for ($i = 1; $i <= 5; $i++) {
            $notesData[] = $distribution[$i] ?? 0;
        }

        return [
            'total' => $total,
            'visible' => $visible,
            'moyenne' => $moyenne,
            'verified_rate' => $verified,
            'distribution' => [
                'labels' => ['1 étoile', '2 étoiles', '3 étoiles', '4 étoiles', '5 étoiles'],
                'data' => $notesData,
            ],
        ];
    }

    // Actions de Modération
    public function openToggleVisibilityModal($avisId)
    {
        $this->selectedAvis =  Avis::findOrFail($avisId);
        $this->showToggleVisibilityModal = true;
    }

    public function toggleVisibility()
    {
        $avis = $this->selectedAvis;
        $avis->is_visible = !$avis->is_visible;
        $avis->save();
        $this->showToggleVisibilityModal = false;
        $this->dispatch('toast', ['type' => 'success', 'message' => "L'avis a été " . ($avis->is_visible ? 'rendu visible' : 'masqué') . " avec succès."]);
    }

    // Actions de Modération (Admin uniquement)
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
        } // Sécurité
        $this->selectedAvis->delete();
        $this->showDeleteModal = false;
        $this->selectedAvis = null;
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
        $this->selectedAvis = null;
    }
}
