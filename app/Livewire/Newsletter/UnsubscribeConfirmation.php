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
        // Assurez-vous que le modèle NewsletterSubscriber a bien un champ `unsubscribe_token`
        $this->subscriber = NewsletterSubscriber::where('unsubscribe_token', $token)->first();

        if (!$this->subscriber) {
            // Pas d'abort 404 pour une meilleure UX, on laisse la vue gérer l'état
        }
    }

    public function unsubscribe()
    {
        if ($this->subscriber && $this->subscriber->isActive() ) {
            $this->subscriber->markAsUnsubscribed();
            $this->dispatch('show-toast', [
                'title' => 'Désabonnement réussi',
                'message' => "Vous avez été désabonné avec succès de la newsletter d'Agrospace.",
                'type' => 'success',
            ]);
           
        } else {
            $this->dispatch('show-toast', [
                'message' => "Vous êtes déjà désabonné.",
                'type' => 'error',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.newsletter.unsubscribe-confirmation');
    }
}