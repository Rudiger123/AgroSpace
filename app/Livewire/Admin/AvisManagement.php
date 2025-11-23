<?php

namespace App\Livewire\Admin;

use App\Models\Avis;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Gestion des Avis')]
class AvisManagement extends Component
{
    use WithPagination;

    // Filtres
    public $search = '';
    public $noteFilter = 'all'; // 1 à 5, ou 'all'
    public $visibilityFilter = 'all'; // true/false/all
    public $verifiedFilter = 'all'; // true/false/all
    public $sortBy = 'date_creation';
    public $sortDirection = 'desc';

    // Modales
    public $showDetailsModal = false;
    public $showToggleVisibilityModal = false;
    public $selectedAvisId = null;

    protected $queryString = ['search', 'noteFilter', 'visibilityFilter', 'verifiedFilter'];

    // Événements d'écoute pour réinitialiser la pagination
    public function updatingSearch() { $this->resetPage(); }
    public function updatingNoteFilter() { $this->resetPage(); }
    public function updatingVisibilityFilter() { $this->resetPage(); }
    public function updatingVerifiedFilter() { $this->resetPage(); }

    public function render()
    {
        // 1. Logique de la requête principale
        $avisQuery = Avis::with(['producer:id,name', 'consumer:id,name', 'offer:id,titre'])
            ->when($this->search, function ($query) {
                // Recherche dans le commentaire et les noms d'utilisateurs
                $query->where('commentaire', 'like', "%{$this->search}%")
                      ->orWhereHas('consumer', fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
                      ->orWhereHas('producer', fn ($q) => $q->where('name', 'like', "%{$this->search}%"));
            })
            ->when($this->noteFilter !== 'all', fn ($q) => $q->where('note', $this->noteFilter))
            ->when($this->visibilityFilter !== 'all', fn ($q) => $q->where('is_visible', $this->visibilityFilter === 'true'))
            ->when($this->verifiedFilter !== 'all', fn ($q) => $q->where('is_verified', $this->verifiedFilter === 'true'))
            ->orderBy($this->sortBy, $this->sortDirection);
        
        $avis = $avisQuery->paginate(15);

        // 2. Logique des statistiques pour ApexCharts
        $stats = $this->getAvisStats();

        return view('livewire.admin.avis-management', [
            'avis' => $avis,
            'stats' => $stats,
        ]);
    }

    // Méthode pour générer les données statistiques (pour ApexCharts)
    public function getAvisStats()
    {
        // Distribution des notes (pour l'histogramme)
        $distribution = Avis::select('note', DB::raw('count(*) as count'))
                            ->groupBy('note')
                            ->pluck('count', 'note')
                            ->toArray();
        
        $notesData = [];
        for ($i = 1; $i <= 5; $i++) {
            $notesData[] = $distribution[$i] ?? 0;
        }

        // Statistiques globales
        $total = Avis::count();
        $visible = Avis::where('is_visible', true)->count();
        $moyenne = number_format(Avis::avg('note') ?? 0, 1);

        return [
            'total' => $total,
            'visible' => $visible,
            'moyenne' => $moyenne,
            'distribution' => [
                'labels' => ['1 étoile', '2 étoiles', '3 étoiles', '4 étoiles', '5 étoiles'],
                'data' => $notesData,
            ],
            'notes_count' => Avis::select('note', DB::raw('count(*) as count'))->groupBy('note')->get(),
            // Vous pouvez ajouter ici le taux de vérification:
            'verified_rate' => Avis::where('is_verified', true)->count(),
        ];
    }
    
    // Actions de Modération
    public function openToggleVisibilityModal($avisId)
    {
        $this->selectedAvisId = $avisId;
        $this->showToggleVisibilityModal = true;
    }

    public function toggleVisibility()
    {
        $avis = Avis::findOrFail($this->selectedAvisId);
        $avis->is_visible = !$avis->is_visible;
        $avis->save();
        $this->showToggleVisibilityModal = false;
        $this->dispatch('alert', ['type' => 'success', 'message' => "L'avis a été " . ($avis->is_visible ? 'rendu visible' : 'masqué') . " avec succès."]);
    }
    
    // ... Autres méthodes (supprimer, voir détails) ...
}