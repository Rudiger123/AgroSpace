<?php

namespace App\Livewire\Admin\Contacts;

use App\Models\Contact;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;

#[Layout('layouts.app')]
#[Title('Contacts')]
class ListContacts extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $perPage = 10;
    public $openViewModal, $openReplyModal, $openDeleteModal;
    public $selectedResponse = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function openViewModal($contactId)
    {
        $this->dispatch('openModal', ['contactId' => $contactId]);
    }

    public function openReplyModal($contactId)
    {
        $this->dispatch('openModal', 'admin.contacts.reply-contact-modal', ['contactId' => $contactId]);
    }

    public function openDeleteModal($contactId)
    {
        $this->dispatch('openModal', 'admin.contacts.delete-contact-modal', ['contactId' => $contactId]);
    }

    public function markAsOpened($contactId)
    {
        $contact = Contact::findOrFail($contactId);
        
        if ($contact->status === 'new') {
            $contact->update(['status' => 'opened']);
            
            $this->dispatch('contact-updated');
        }
    }

    public function deleteContact($contactId)
    {
        try {
            $contact = Contact::findOrFail($contactId);
            $contact->delete();

            $this->dispatch('contact-deleted');
            $this->dispatch('closeModal');
        } catch (\Exception $e) {
            $this->dispatch('contact-error', message: 'Erreur lors de la suppression du message.');
        }
    }

    public function sendReply($contactId, $replyMessage)
    {
        try {
            $contact = Contact::findOrFail($contactId);
            
            // Envoyer l'email de réponse
            Mail::send('emails.contact-reply', [
                'contact' => $contact,
                'replyMessage' => $replyMessage
            ], function ($message) use ($contact) {
                $message->to($contact->email)
                        ->subject('Réponse à votre message - AgroSpace');
            });

            // Mettre à jour le statut du contact
            $contact->update([
                'status' => 'replied',
                'replied_at' => now()
            ]);

            $this->dispatch('contact-replied');
            $this->dispatch('closeModal');
        } catch (\Exception $e) {
            $this->dispatch('contact-error', message: 'Erreur lors de l\'envoi de la réponse.');
        }
    }

    public function closeModals()
    {
        $this->openDeleteModal = false;
        $this->openViewModal = false;
        $this->openReplyModal = false;
        $this->selectedResponse = null;
    }

    public function render()
    {
        $contacts = Contact::query()
            ->search($this->search)
            ->status($this->statusFilter)
            ->latest()
            ->paginate($this->perPage);

        $newMessagesCount = Contact::newMessages()->count();
        
        $stats = [
            'total' => Contact::count(),
            'new' => Contact::where('status', 'new')->count(),
            'opened' => Contact::where('status', 'opened')->count(),
            'replied' => Contact::where('status', 'replied')->count(),
            'closed' => Contact::where('status', 'closed')->count(),
        ];

        return view('livewire.admin.contacts.list-contacts', [
            'contacts' => $contacts,
            'newMessagesCount' => $newMessagesCount,
            'stats' => $stats,
        ]);
    }
}