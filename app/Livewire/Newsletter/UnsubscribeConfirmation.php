<?php

namespace App\Livewire\Newsletter;

use App\Models\NewsletterSubscriber;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class UnsubscribeConfirmation extends Component
{
    public $token;
    public $subscriber;

    public function mount($token)
    {
        $this->token = $token;
        $this->subscriber = NewsletterSubscriber::where('unsubscribe_token', $token)->first();

        if (!$this->subscriber) {
            abort(404, 'Lien de désinscription invalide.');
        }
    }

    public function unsubscribe()
    {
        if ($this->subscriber->isActive()) {
            $this->subscriber->markAsUnsubscribed();

            $this->dispatch('swal:success', [
                'title' => 'Désabonnement réussi',
                'text' => 'Vous avez été désabonné avec succès.',
                'icon' => 'success',
            ]);
        } else {
            session()->flash('error', 'Vous êtes déjà désabonné.');
        }
    }

    public function render()
    {
        return view('livewire.newsletter.unsubscribe-confirmation');
    }
}
