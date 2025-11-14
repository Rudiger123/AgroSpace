<?php

namespace App\Livewire\Admin\DemandsManagement;

use App\Models\Demand;
use App\Models\Category;
use App\Models\DemandResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout("layouts.app")]
#[Title('Liste des demandes')]
class PublicDemands extends Component
{
    use WithPagination;

    public $showResponseModal = false;
    public $showDetailsModal = false;
    
    public $selectedDemandId = null;
    public $selectedDemand = null;
    public $message = '';
    public $proposed_price = '';
    public $contact_phone = '';
    public $contact_email = '';
    
    public $search = '';
    public $categoryFilter = '';
    public $regionFilter = '';
    public $urgencyFilter = '';
    public $sortBy = 'latest';

    protected $queryString = ['search', 'categoryFilter', 'regionFilter', 'urgencyFilter', 'sortBy'];

    protected $regions = [
        'Adamaoua', 'Centre', 'Est', 'Extrême-Nord',
        'Littoral', 'Nord', 'Nord-Ouest', 'Ouest',
        'Sud', 'Sud-Ouest'
    ];

    public function rules()
    {
        return [
            'message' => 'required|string|min:20|max:1000',
            'proposed_price' => 'nullable|numeric|min:0',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
        ];
    }

    public function openResponseModal($demandId)
    {
        if (!Auth::check()) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Vous devez être connecté pour répondre à une demande'
            ]);
            return redirect()->route('login');
        }

        $demand = Demand::findOrFail($demandId);

        // Vérifier si c'est sa propre demande
        if ($demand->user_id === Auth::user()->id) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Vous ne pouvez pas répondre à votre propre demande'
            ]);
            return;
        }

        // Vérifier si déjà répondu
        $alreadyResponded = DemandResponse::where('demand_id', $demandId)
            ->where('user_id', Auth::user()->id)
            ->exists();

        if ($alreadyResponded) {
            $this->dispatch('toast', [
                'type' => 'info',
                'message' => 'Vous avez déjà répondu à cette demande'
            ]);
            return;
        }

        $this->selectedDemandId = $demandId;
        $this->selectedDemand = $demand;
        $this->reset(['message', 'proposed_price', 'contact_phone', 'contact_email']);
        $this->contact_phone = Auth::user()->phone ?? '';
        $this->contact_email = Auth::user()->email;
        $this->showDetailsModal = false;
        $this->showResponseModal = true;
    }

    public function submitResponse()
    {
        $this->validate();

        try {
            DemandResponse::create([
                'demand_id' => $this->selectedDemandId,
                'user_id' => Auth::user()->id,
                'message' => $this->message,
                'proposed_price' => $this->proposed_price,
                'contact_phone' => $this->contact_phone,
                'contact_email' => $this->contact_email,
                'status' => 'pending',
            ]);

            // Incrémenter le compteur de contacts
            $demand = Demand::find($this->selectedDemandId);
            $demand->incrementContacts();

            $this->showResponseModal = false;
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Votre réponse a été envoyée avec succès !'
            ]);

            // TODO: Envoyer une notification au demandeur

        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur lors de l\'envoi de la réponse: ' . $e->getMessage()
            ]);
        }
    }

    public function viewDetails($id)
    {
        $demand = Demand::with(['category', 'user'])->findOrFail($id);
        
        // Incrémenter le compteur de vues
        if (!Auth::check() || $demand->user_id !== Auth::user()->id) {
            $demand->incrementViews();
        }

        $this->selectedDemand = $demand;
        $this->showResponseModal = false;
        $this->showDetailsModal = true;
    }

    public function render()
    {
        $demands = Demand::with(['category', 'user'])
            ->where('status', 'active')
            ->where('user_id', '!=', Auth::user()->id ?? 0)
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('city', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter, function($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->when($this->regionFilter, function($query) {
                $query->where('region', $this->regionFilter);
            })
            ->when($this->urgencyFilter, function($query) {
                $query->where('urgency', $this->urgencyFilter);
            })
            ->when($this->sortBy === 'latest', function($query) {
                $query->latest();
            })
            ->when($this->sortBy === 'urgent', function($query) {
                $query->orderByRaw("CASE urgency WHEN 'high' THEN 1 WHEN 'medium' THEN 2 WHEN 'low' THEN 3 END");
            })
            ->when($this->sortBy === 'popular', function($query) {
                $query->orderBy('views_count', 'desc');
            })
            ->when($this->sortBy === 'expiring', function($query) {
                $query->orderBy('validity_date', 'asc');
            })
            ->paginate(12);

        $categories = Category::where('is_active', true)->get();

        // Stats
        $stats = [
            'total' => Demand::where('status', 'active')->count(),
            'high_urgency' => Demand::where('status', 'active')->where('urgency', 'high')->count(),
            'new_today' => Demand::where('status', 'active')->whereDate('created_at', today())->count(),
        ];

        return view('livewire.admin.demands-management.public-demands', [
            'demands' => $demands,
            'categories' => $categories,
            'regions' => $this->regions,
            'stats' => $stats,
        ]);
    }
}
