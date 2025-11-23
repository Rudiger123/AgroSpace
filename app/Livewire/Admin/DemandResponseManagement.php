<?php

namespace App\Livewire\Admin;

use App\Models\DemandResponse;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Namu\WireChat\Facades\WireChat;
use Namu\WireChat\Livewire\Chats\Chats;
use Namu\WireChat\Livewire\Concerns\Widget;
use Namu\WireChat\Livewire\Widgets\WireChat as WidgetsWireChat;
use Namu\WireChat\Models\Message;

#[Layout('layouts.app')]
#[Title('Gestion des Réponses aux Demandes')]
class DemandResponseManagement extends Component
{
    use WithPagination;
    use Widget;

    // Filtres
    public $search = '';
    public $statusFilter = 'pending'; // pending, accepted, rejected, all
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Modales & Actions
    public $showDetailsModal = false;
    public $showAcceptModal = false;
    public $selectedResponseId = null;

    protected $queryString = ['search', 'statusFilter'];

    // Événements d'écoute
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function closeModals()
    {
        $this->showDetailsModal = false;
        $this->showAcceptModal = false;
    }

    public function render()
    {
        $responses = DemandResponse::with(['demand:id,user_id', 'user:id,name,email'])
            ->when($this->search, function ($query) {
                // Recherche dans le message et le nom de l'utilisateur qui répond
                $query->where('message', 'like', "%{$this->search}%")
                    ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$this->search}%"));
            })
            ->when($this->statusFilter !== 'all', fn($q) => $q->where('status', $this->statusFilter))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);

        // Statistiques simples
        $stats = [
            'total' => DemandResponse::count(),
            'pending' => DemandResponse::where('status', 'pending')->count(),
            'accepted' => DemandResponse::where('status', 'accepted')->count(),
        ];

        return view('livewire.admin.demand-response-management', [
            'responses' => $responses,
            'stats' => $stats,
        ]);
    }

    // Ouvre la modale pour accepter
    public function openAcceptModal($responseId)
    {
        $this->selectedResponseId = $responseId;
        $this->showAcceptModal = true;
    }

    // Valide et déclenche le chat
    public function acceptResponse()
    {
        $response = DemandResponse::findOrFail($this->selectedResponseId);

        // 1. Mise à jour du statut
        $response->update(['status' => 'accepted']);

        // 2. Déclenchement du Chat Interne


        // Exemple: Créer ou trouver une conversation entre le Producteur (user_id) et le Demandeur (demand->user_id)
        $demandCreatorId = $response->demand->user_id;
        $model = $response->user;

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Rediriger vers la messagerie ou ouvrir modal de contact
        if ($model) {
            $createdConversation = Auth::user()->createConversationWith($model);

            $response_date = $response->demand->created_at->format('d/m/Y');
            $response_title = $response->demand->title;

            // Create the message
            $message = Message::create([
                'reply_id' => null,
                'conversation_id' => $createdConversation->id,
                'sendable_type' => Auth::user()->getMorphClass(), // Polymorphic sender type
                'sendable_id' => Auth::id(), // Polymorphic sender ID
                'type' => 'text',
                'body' => "Votre réponse a ma demande $response_title du $response_date a été acceptée avec succès et maintenant nous devons discuter des paiements et livraisons...",
            ]);

            // update the conversation model - for sorting in chatlist
            $createdConversation->updated_at = now();
            $createdConversation->save();

            // dispatch event 'refresh ' to chatlist
            $this->dispatch('refresh')->to(Chats::class);

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

        $this->showAcceptModal = false;
        $this->dispatch('toast', ['type' => 'success', 'message' => "Réponse acceptée. Conversation initiée entre les parties."]);
    }

    // Méthode pour rejeter une réponse (similaire à acceptResponse, mais sans l'initiation du chat)
    public function rejectResponse($responseId)
    {
        $response = DemandResponse::findOrFail($responseId);
        $response->update(['status' => 'rejected']);
        $this->dispatch('toast', ['type' => 'info', 'message' => "Réponse rejetée."]);
    }

    // Méthode pour contacter directement le producteur par le chat (sans accepter l'offre)
    public function contactProducer($responseId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->dispatch('toast', ['type' => 'info', 'message' => "Ouverture de la fenêtre de chat avec le producteur..."]);

        $response = DemandResponse::findOrFail($responseId);
        $model = $response->user;

        // Rediriger vers la messagerie ou ouvrir modal de contact
        if ($model) {
            $createdConversation = Auth::user()->createConversationWith($model);

            $response_date = $response->created_at->format('d/m/Y');
            $response_title = $response->message;
            $demande = $response->demand->title;

            // Create the message
            $message = Message::create([
                'reply_id' => null,
                'conversation_id' => $createdConversation->id,
                'sendable_type' => Auth::user()->getMorphClass(), // Polymorphic sender type
                'sendable_id' => Auth::id(), // Polymorphic sender ID
                'type' => 'text',
                'body' => "Bonjour, je vous contacte à propos de votre réponse : \n $response_title \n du $response_date  sur ma demande $demande afin d'avoir plus d'informations", // Add body if required
            ]);

            // update the conversation model - for sorting in chatlist
            $createdConversation->updated_at = now();
            $createdConversation->save();

            // dispatch event 'refresh ' to chatlist
            $this->dispatch('refresh')->to(Chats::class);

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
    }
}
