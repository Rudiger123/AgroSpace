<?php

namespace App\Livewire\Admin\OffersManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Offre;
use App\Models\Avis;
use App\Models\Category;
use App\Models\Offer;
use App\Services\AvisService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Namu\WireChat\Facades\WireChat;
use Namu\WireChat\Livewire\Widgets\WireChat as WidgetsWireChat;
use Namu\WireChat\Livewire\Concerns\Widget;

#[Layout("layouts.app")]
#[Title("Offers Public")]
class OffresList extends Component
{
    use WithPagination;
    use Widget;

    // Filtres
    public $search = '';
    public $filterCategorie = '';
    public $filterRegion = '';
    public $filterPrixMin = '';
    public $filterPrixMax = '';
    public $sortBy = 'date_publication';
    public $sortDirection = 'desc';

    // Modal détails offre
    public $showDetailsModal = false;
    public $selectedOffre;

    // Modal notation
    public $showAvisModal = false;
    public $avisproducerId;
    public $avisOffreId;
    public $avisNote = 5;
    public $avisCommentaire = '';

    protected $queryString = [
        'search',
        'filterCategorie',
        'filterRegion',
        'sortBy'
    ];

    public function mount()
    {
        // Initialisation
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openDetailsModal($offreId)
    {
        $this->selectedOffre = Offer::with([
            'photos',
            'producer.avisRecus' => function ($query) {
                $query->visible()->latest()->take(5);
            }
        ])->findOrFail($offreId);

        // Incrémenter les vues
        $this->selectedOffre->incrementViews();

        $this->showDetailsModal = true;
    }

    public function contactproducer($offreId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $offre = Offer::findOrFail($offreId);
        $offre->incrementContacts();

        $model = $offre->producer;

        // Rediriger vers la messagerie ou ouvrir modal de contact
        if ($model) {
            $createdConversation = Auth::user()->createConversationWith($model);

            if ($createdConversation) {
                // redirect to conversation
                $this->handleComponentTermination(
                    redirectRoute: route(WireChat::viewRouteName(), [$createdConversation->id]),
                    events: [
                        WidgetsWireChat::class => ['open-chat',  ['conversation' => $createdConversation->id]],
                    ]
                );
            }
        }
        $this->dispatch('toast', [
            'type' => 'info',
            'message' => 'Vous pouvez maintenant discuter avec le producteur de cette offre'
        ]);

        // TODO: Implémenter la redirection vers le chat
        // return redirect()->route('messages.show', $offre->producer_id);
    }

    public function openAvisModal($producerId, $offreId = null)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::id() === $producerId) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Vous ne pouvez pas vous noter vous-même'
            ]);
            return;
        }

        // Vérifier si l'utilisateur peut laisser un avis
        $service = new AvisService();
        $producer = \App\Models\User::findOrFail($producerId);

        if (!$service->canUserLeaveAvis(Auth::user(), $producer)) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Vous avez déjà noté ce producteur'
            ]);
            return;
        }

        $this->avisproducerId = $producerId;
        $this->avisOffreId = $offreId;
        $this->avisNote = 5;
        $this->avisCommentaire = '';
        $this->showAvisModal = true;
    }

    public function submitAvis()
    {
        $this->validate([
            'avisNote' => 'required|integer|min:1|max:5',
            'avisCommentaire' => 'nullable|string|max:500',
        ]);

        try {
            $service = new AvisService();

            $avis = $service->createAvis([
                'producer_id' => $this->avisproducerId,
                'offre_id' => $this->avisOffreId,
                'note' => $this->avisNote,
                'commentaire' => $this->avisCommentaire,
                'is_verified' => false, // Sera vérifié par admin si besoin
            ]);

            event(new \App\Events\Notifications\NewReviewCreated($avis));

            $this->showAvisModal = false;
            $this->reset(['avisproducerId', 'avisOffreId', 'avisNote', 'avisCommentaire']);

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Merci pour votre avis !'
            ]);

            // Recharger les détails si modal ouverte
            if ($this->selectedOffre) {
                $this->selectedOffre = $this->selectedOffre->fresh([
                    'photos',
                    'producer.avisRecus'
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFilters()
    {
        $this->reset([
            'search',
            'filterCategorie',
            'filterRegion',
            'filterPrixMin',
            'filterPrixMax'
        ]);
        $this->resetPage();
    }

    public function render()
    {
        $query = Offer::with(['photos', 'producer'])
                      ->where('statut', 'validé')->where('is_published', true); // Seulement les offres validés et activés

        // Recherche
        if ($this->search) {
            $query->search($this->search);
        }

        // Filtres
        if ($this->filterCategorie) {
            $query->byCategory($this->filterCategorie);
        }

        if ($this->filterRegion) {
            $query->byRegion($this->filterRegion);
        }

        if ($this->filterPrixMin) {
            $query->where('prix', '>=', $this->filterPrixMin);
        }

        if ($this->filterPrixMax) {
            $query->where('prix', '<=', $this->filterPrixMax);
        }

        // Tri
        $query->orderBy($this->sortBy, $this->sortDirection);

        $offres = $query->paginate(12);

        // Offres en vedette
        $featuredOffres = Offer::with(['photos', 'producer'])
                               ->where('is_published', true)
                               ->where('is_featured', true)
                               ->take(3)
                               ->get();

        return view('livewire.admin.offers-management.offres-list', [
            'offres' => $offres,
            'featuredOffres' => $featuredOffres,
            'categories' => Category::where('is_active', true)->get(),
            'regions' => Offer::getRegionsOptions(),
        ]);
    }
}
