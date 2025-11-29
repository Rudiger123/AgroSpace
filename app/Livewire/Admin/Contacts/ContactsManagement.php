<?php

namespace App\Livewire\Admin\Contacts;

use App\Models\Contact;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
#[Title('Gestion des Contacts')]
class ContactsManagement extends Component
{
    use WithPagination;

    // Propriétés de recherche et filtres
    public $search = '';
    public $statusFilter = 'all';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Modals
    public $showViewModal = false;
    public $showReplyModal = false;
    public $showDeleteModal = false;

    // Données du contact sélectionné
    public $selectedContact = null;
    public $contactId = null;

    // Formulaire de réponse
    public $replyMessage = '';
    public $selectedUsers = [];
    public $ccToSender = true;
    public $sendCopyToMe = false;

    // Sélection multiple
    public $selectedContacts = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
    ];

    protected $rules = [
        'replyMessage' => 'required|min:10',
    ];

    protected $messages = [
        'replyMessage.required' => 'Veuillez saisir un message de réponse.',
        'replyMessage.min' => 'Le message doit contenir au moins 10 caractères.',
    ];

    // Lifecycle hooks
    public function mount()
    {
        $this->selectedUsers = [];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedContacts = Contact::query()
                ->search($this->search)
                ->status($this->statusFilter)
                ->pluck('id')
                ->toArray();
        } else {
            $this->selectedContacts = [];
        }
    }

    // Tri
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Ouvrir le modal de visualisation
    public function viewContact($contactId)
    {
        $this->selectedContact = Contact::with('repliedBy')->findOrFail($contactId);
        $this->contactId = $contactId;

        // Marquer comme ouvert si nouveau
        if ($this->selectedContact->status === 'new') {
            $this->selectedContact->update(['status' => 'opened']);
        }

        $this->showViewModal = true;
    }

    // Ouvrir le modal de réponse
    public function openReplyModal($contactId)
    {
        $this->selectedContact = Contact::findOrFail($contactId);
        $this->contactId = $contactId;
        $this->replyMessage = '';
        $this->selectedUsers = [];
        $this->ccToSender = true;
        $this->sendCopyToMe = false;

        $this->showReplyModal = true;
    }

    // Envoyer la réponse
    public function sendReply()
    {
        $this->validate();

        try {
            $contact = Contact::findOrFail($this->contactId);

            // Envoyer l'email aux utilisateurs sélectionnés
            Mail::send('emails.contact-reply', [
                'contact' => $contact,
                'replyMessage' => $this->replyMessage,
                'recipient' => $contact->email,
            ], function ($message) use ($contact) {
                $message->to($contact->email, $contact->name)
                        ->subject('Réponse: ' . $contact->subject . ' - AgroSpace');

                // CC au sender si demandé
                if ($this->ccToSender) {
                    $message->cc($contact->email, $contact->name);
                }
            });

            // Copie à l'expéditeur
            if ($this->sendCopyToMe) {
                Mail::send('emails.contact-reply', [
                    'contact' => $contact,
                    'replyMessage' => $this->replyMessage,
                    'recipient' => Auth::user(),
                ], function ($message) use ($contact) {
                    $message->to(Auth::user()->email, Auth::user()->name)
                            ->subject('[Copie] Réponse: ' . $contact->subject);
                });
            }

            // Mettre à jour le contact
            $contact->update([
                'status' => 'replied',
                'reply_message' => $this->replyMessage,
                'replied_at' => now(),
                'replied_by' => Auth::id(),
            ]);

            $this->dispatch('contact-replied', [
                'message' => "Réponse envoyée avec succès à $contact->name !"
            ]);

            $this->closeReplyModal();
        } catch (\Exception $e) {
            $this->dispatch('contact-error', [
                'message' => 'Erreur lors de l\'envoi: ' . $e->getMessage()
            ]);
        }
    }

    // Ouvrir le modal de suppression
    public function openDeleteModal($contactId)
    {
        $this->selectedContact = Contact::findOrFail($contactId);
        $this->contactId = $contactId;
        $this->showDeleteModal = true;
    }

    // Supprimer un contact
    public function deleteContact()
    {
        try {
            Contact::findOrFail($this->contactId)->delete();

            $this->dispatch('contact-deleted', [
                'message' => 'Message supprimé avec succès!'
            ]);

            $this->closeDeleteModal();
        } catch (\Exception $e) {
            $this->dispatch('contact-error', [
                'message' => 'Erreur lors de la suppression.'
            ]);
        }
    }

    // Suppression multiple
    public function deleteSelected()
    {
        try {
            $count = count($this->selectedContacts);
            Contact::whereIn('id', $this->selectedContacts)->delete();

            $this->selectedContacts = [];
            $this->selectAll = false;

            $this->dispatch('contacts-deleted', [
                'message' => $count . ' message(s) supprimé(s) avec succès!'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('contact-error', [
                'message' => 'Erreur lors de la suppression multiple.'
            ]);
        }
    }

    // Marquer comme fermé
    public function markAsClosed($contactId)
    {
        $contact = Contact::findOrFail($contactId);
        $contact->update(['status' => 'closed']);

        $this->dispatch('contact-updated', [
            'message' => 'Statut mis à jour!'
        ]);

        if ($this->showViewModal) {
            $this->selectedContact->refresh();
        }
    }

    // Fermer les modals
    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->selectedContact = null;
        $this->contactId = null;
    }

    public function closeReplyModal()
    {
        $this->showReplyModal = false;
        $this->selectedContact = null;
        $this->contactId = null;
        $this->replyMessage = '';
        $this->selectedUsers = [];
        $this->resetValidation();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->selectedContact = null;
        $this->contactId = null;
    }

    // Export (optionnel)
    public function exportContacts()
    {
        // Logique d'export CSV/Excel
        $this->dispatch('export-started');
    }

    public function render()
    {
        $contacts = Contact::query()
            ->with('repliedBy')
            ->search($this->search)
            ->status($this->statusFilter)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        $users = User::select('id', 'name', 'email')
                    ->where('id', '!=', Auth::id())
                    ->orderBy('name')
                    ->get();

        $stats = [
            'total' => Contact::count(),
            'new' => Contact::where('status', 'new')->count(),
            'opened' => Contact::where('status', 'opened')->count(),
            'replied' => Contact::where('status', 'replied')->count(),
            'closed' => Contact::where('status', 'closed')->count(),
        ];

        // Stats avancées
        $advancedStats = [
            'today' => Contact::whereDate('created_at', today())->count(),
            'this_week' => Contact::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => Contact::whereMonth('created_at', now()->month)->count(),
            'avg_response_time' => Contact::whereNotNull('replied_at')->get()->avg(function ($contact) {
                return $contact->replied_at->diffInHours($contact->created_at);
            }),
            'response_rate' => Contact::count() > 0
                ? round((Contact::where('status', 'replied')->count() / Contact::count()) * 100, 1)
                : 0,
        ];

        return view('livewire.admin.contacts.contacts-management', [
            'contacts' => $contacts,
            'users' => $users,
            'stats' => $stats,
            'advancedStats' => $advancedStats,
        ]);
    }
}
