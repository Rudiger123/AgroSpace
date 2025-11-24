<?php

namespace App\Livewire\Admin;

use App\Models\DemandResponse;
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
use App\Notifications\DemandResponseAccepted; // Importation de la notification
use App\Notifications\DemandResponseRejected; // Importation de la notification

// Nécessaire pour les notifications

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
    public $isAdmin;

    // Modales & Actions
    public $showDetailsModal = false;
    public $showAcceptModal = false;
    public $showRejectModal = false; // Ajout de la modale de rejet
    public $selectedResponseId = null;
    public $rejectionReason = ''; // Pour une raison de rejet si nécessaire

    protected $queryString = ['search', 'statusFilter'];
    public function mount()
    {
        // Supposons que l'Admin a un rôle 'admin'
        $this->isAdmin = Auth::user()->isAdmin();
    }

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
        $this->showRejectModal = false;
        $this->selectedResponseId = null;
        $this->rejectionReason = '';
    }

    public function render()
    {
        $userId = Auth::id();
        $responses = DemandResponse::with(['user:id,name', 'demand:id,title'])
            // CONVENTION: Admin voit TOUT. consomateur voit SEULEMENT ses responses.
            ->when(!$this->isAdmin, function ($q) use ($userId) {
                return $q->where(function ($query) use ($userId) {
                    $query->whereHas('demand', function ($subQuery) use ($userId) {
                        $subQuery->where('user_id', $userId);
                    });
                });
            })
            ->when($this->search, function ($query) {
                $query->where('message', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', fn ($q) => $q->where('name', 'like', '%' . $this->search . '%'));
            })
            ->when($this->statusFilter !== 'all', fn ($query) => $query->where('status', $this->statusFilter))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.demand-response-management', [
            'responses' => $responses,
        ]);
    }

    // Ouvre la modale d'acceptation
    public function openAcceptModal($responseId)
    {
        $this->selectedResponseId = $responseId;
        $this->showAcceptModal = true;
    }

    // Ouvre la modale de rejet
    public function openRejectModal($responseId)
    {
        $this->selectedResponseId = $responseId;
        $this->showRejectModal = true;
    }

    // Rejeter la réponse (implémentation simple)
    public function rejectResponse()
    {
        $response = DemandResponse::findOrFail($this->selectedResponseId);

        // 1. Mettre à jour le statut
        $response->status = 'rejected';
        $response->save();

        // 2. Envoyer la notification par email au producteur
        $producer = $response->user;
        if ($producer) {
            $producer->notify(new DemandResponseRejected($response));
        }

        $this->closeModals();
        $this->dispatch('toast', ['type' => 'info', 'message' => "Réponse de {$producer->name} à la demande #{$response->demand_id} rejetée et producteur notifié."]);
    }


    // Accepter la réponse (logique existante + notification)
    public function acceptResponse()
    {
        $response = DemandResponse::with(['user', 'demand.user'])->findOrFail($this->selectedResponseId);

        // Vérifier si la demande a déjà une réponse acceptée
        if ($response->demand->responses()->where('status', 'accepted')->exists()) {
            $this->closeModals();
            $this->dispatch('toast', ['type' => 'warning', 'message' => 'Une réponse a déjà été acceptée pour cette demande.']);
            return;
        }

        // 1. Mettre à jour le statut de la réponse
        $response->status = 'accepted';
        $response->save();

        // 2. Notification par email au producteur
        $producer = $response->user;
        if ($producer) {
            $producer->notify(new DemandResponseAccepted($response));
        }

        // 3. Création de la conversation
        $consumer = $response->demand->user;

        $createdConversation = Auth::user()->createConversationWith($producer);

        // Message initial
        $response_title = $response->demand->title;
        $response_date = $response->created_at->format('d/m/Y');

        $message = Message::create([
            'reply_id' => null,
            'conversation_id' => $createdConversation->id,
            'sendable_type' => Auth::user()->getMorphClass(),
            'sendable_id' => Auth::id(),
            'type' => 'text',
            'body' => "Bonjour, je vous contacte à propos de votre offre sur ma demande : **\"{$response_title}\"** du $response_date. Votre offre a été sélectionnée. Discutons des détails pour finaliser l'échange.",
        ]);

        $createdConversation->updated_at = now();
        $createdConversation->save();

        $this->dispatch('refresh')->to(Chats::class);

        if ($createdConversation) {
            $this->handleComponentTermination(
                redirectRoute: route(WireChat::viewRouteName(), [$createdConversation->id]),
                events: [
                    WidgetsWireChat::class => ['open-chat',  ['conversation' => $createdConversation->id]],
                ]
            );
            return;
        }

        $this->closeModals();
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Réponse acceptée. La conversation a été initiée ou mise à jour.'
        ]);
    }

    public function openDetailsModal($responseId)
    {
        $this->selectedResponseId = $responseId;
        $this->showDetailsModal = true;
    }
}
