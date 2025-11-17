<?php

namespace App\Livewire\Newsletter;

use App\Models\NewsletterSubscriber;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class AdminNewsletterList extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedSubscribers = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function bulkSendEmail()
    {
        // Dispatch event pour ouvrir modal d'envoi d'email en masse
        $this->dispatch('openEmailModal');

        $this->dispatch('toast', [
            'type' => 'info',
            'message' => count(NewsletterSubscriber::active()->get()) . " abonné(s) sélectionné(s) pour la diffusion."
        ]);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedSubscribers = $this->getSubscribersProperty()->pluck('id')->toArray();
        } else {
            $this->selectedSubscribers = [];
        }
    }

    public function confirmDelete($subscriberId)
    {
        $subscriber = NewsletterSubscriber::find($subscriberId);

        if (!$subscriber) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Abonné non trouvé.'
            ]);
            return;
        }

        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer la suppression',
            'text' => "Êtes-vous sûr de vouloir supprimer l'abonné \"{$subscriber->name}\" ? Cette action est irréversible.",
            'icon' => 'warning',
            'confirmText' => 'Oui, supprimer',
            'cancelText' => 'Annuler',
            'method' => 'deleteSubscriber',
            'params' => ['subscriberId' => $subscriberId] // Toujours passer un tableau
        ]);
    }

    #[On('deleteSubscriber')]
    public function deleteSubscriber($subscriberId)
    {
        NewsletterSubscriber::find($subscriberId)?->delete();

        $this->dispatch('toast', [
            'message' => 'L\'abonné a été supprimé avec succès.',
            'type' => 'success',
        ]);
    }

    public function deleteSelected()
    {
        if (empty($this->selectedsubscribers)) {
            $this->dispatch('alert', [
                'title' => 'Aucune sélection',
                'text' => 'Veuillez sélectionner au moins un utilisateur à supprimer.',
                'icon' => 'warning'
            ]);
            return;
        }

        $count = count($this->selectedsubscribers);
        $subscriberText = $count > 1 ? "ces {$count} utilisateurs" : "cet utilisateur";

        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer la suppression multiple',
            'text' => "Êtes-vous sûr de vouloir supprimer {$subscriberText} ? Cette action est irréversible.",
            'icon' => 'warning',
            'confirmText' => 'Oui, supprimer',
            'cancelText' => 'Annuler',
            'method' => 'bulkDelete',
            'params' => [] // Tableau vide pour les méthodes sans paramètres
        ]);
    }

    #[On('bulkDelete')]
    public function bulkDelete()
    { 
        NewsletterSubscriber::whereIn('id', $this->selectedSubscribers)->delete();
        $this->selectedSubscribers = [];

        $this->dispatch('toast', [
            'message' => 'Les abonnés sélectionnés ont été supprimés.',
            'type' => 'success',
        ]);
    }

    public function getSubscribersProperty()
    {
        $query = NewsletterSubscriber::query();

        if ($this->search) {
            $query->where(fn($q) => $q->where('name', 'like', "%{$this->search}%")
                                      ->orWhere('email', 'like', "%{$this->search}%"));
        }

        match($this->filter) {
            'active' => $query->active(),
            'unsubscribed' => $query->unsubscribed(),
            default => $query
        };

        return $query->orderBy($this->sortField, $this->sortDirection)
                    ->paginate(10);
    }
    
    public function render()
    {
        return view('livewire.newsletter.admin-newsletter-list',
    [
        'subscribers' => $this->subscribers
    ]);
    }
}
