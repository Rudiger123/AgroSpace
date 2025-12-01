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
use App\Notifications\DemandResponseAccepted;
use App\Notifications\DemandResponseRejected;

#[Layout('layouts.app')]
#[Title('Demand Response Management')]
class DemandResponseManagement extends Component
{
    use WithPagination;
    use Widget;

    public $search = '';
    public $statusFilter = 'pending';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $isAdmin;

    public $showDetailsModal = false;
    public $showAcceptModal = false;
    public $showRejectModal = false;
    public $selectedResponseId = null;
    public $rejectionReason = '';

    public $stats = [];

    protected $queryString = ['search', 'statusFilter'];

    public function mount()
    {
        $this->isAdmin = Auth::user()->isAdmin();
        $this->loadStats();
    }

    public function loadStats()
    {
        $userId = Auth::id();

        $baseQuery = DemandResponse::query()
            ->when(!$this->isAdmin, function ($q) use ($userId) {
                return $q->whereHas('demand', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            });

        $this->stats['total'] = (clone $baseQuery)->count();
        $this->stats['pending'] = (clone $baseQuery)->where('status', 'pending')->count();
        $this->stats['accepted'] = (clone $baseQuery)->where('status', 'accepted')->count();
        $this->stats['rejected'] = (clone $baseQuery)->where('status', 'rejected')->count();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updated()
    {
        $this->loadStats();
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

    public function openAcceptModal($responseId)
    {
        $this->selectedResponseId = $responseId;
        $this->showAcceptModal = true;
    }

    public function openRejectModal($responseId)
    {
        $this->selectedResponseId = $responseId;
        $this->showRejectModal = true;
    }

    public function rejectResponse()
    {
        $response = DemandResponse::findOrFail($this->selectedResponseId);

        $response->status = 'rejected';
        $response->save();

        $producer = $response->user;
        if ($producer) {
            $producer->notify(new DemandResponseRejected($response));
        }

        $this->closeModals();
        $this->loadStats();
        $this->dispatch('toast', ['type' => 'info', 'message' => __('demand_responses.rejected_notification', ['name' => $producer->name, 'id' => $response->demand_id])]);
    }

    public function acceptResponse()
    {
        $response = DemandResponse::with(['user', 'demand.user'])->findOrFail($this->selectedResponseId);

        if ($response->demand->responses()->where('status', 'accepted')->exists()) {
            $this->closeModals();
            $this->dispatch('toast', ['type' => 'warning', 'message' => __('demand_responses.already_accepted')]);
            return;
        }

        $response->status = 'accepted';
        $response->save();

        $producer = $response->user;
        if ($producer) {
            $producer->notify(new DemandResponseAccepted($response));
        }

        $consumer = $response->demand->user;

        $createdConversation = Auth::user()->createConversationWith($producer);

        $response_title = $response->demand->title;
        $response_date = $response->created_at->format('d/m/Y');

        $message = Message::create([
            'reply_id' => null,
            'conversation_id' => $createdConversation->id,
            'sendable_type' => Auth::user()->getMorphClass(),
            'sendable_id' => Auth::id(),
            'type' => 'text',
            'body' => __('demand_responses.conversation_message', ['title' => $response_title, 'date' => $response_date]),
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
        $this->loadStats();
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => __('demand_responses.accepted_notification')
        ]);
    }

    public function openDetailsModal($responseId)
    {
        $this->selectedResponseId = $responseId;
        $this->showDetailsModal = true;
    }
}
