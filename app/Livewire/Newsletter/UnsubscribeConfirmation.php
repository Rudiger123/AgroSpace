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
    }

    public function unsubscribe()
    {
        if ($this->subscriber && $this->subscriber->isActive()) {
            $this->subscriber->markAsUnsubscribed();
            $this->dispatch('show-toast', [
                'title' => __('newsletter.unsubscribe_success_title'),
                'message' => __('newsletter.unsubscribe_success_message'),
                'type' => 'success',
            ]);
        } else {
            $this->dispatch('show-toast', [
                'message' => __('newsletter.already_unsubscribed'),
                'type' => 'error',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.newsletter.unsubscribe-confirmation');
    }
}
