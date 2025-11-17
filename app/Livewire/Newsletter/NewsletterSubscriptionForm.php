<?php

namespace App\Livewire\Newsletter;

use App\Models\NewsletterSubscriber;
use Livewire\Component;

class NewsletterSubscriptionForm extends Component
{
    public $name = '';
    public $email = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:newsletter_subscribers,email',
    ];

    protected $messages = [
        'name.required' => 'Le nom est obligatoire.',
        'email.required' => 'L\'email est obligatoire.',
        'email.email' => 'L\'email doit être une adresse valide.',
        'email.unique' => 'Cet email est déjà inscrit à la newsletter.',
    ];

    public function subscribe()
    {
        $this->validate();

        $newsletter = new NewsletterSubscriber();
        $newsletter->name = $this->name;
        $newsletter->email =  $this->email;
        $newsletter->save();
    
        $this->reset(['name', 'email']);

        $this->dispatch('show-toast',[
            'type' => 'success',
            'message' => 'Merci de vous être abonné à notre newsletter.',
        ]);
        session()->flash('toast',[
            'type' => 'success',
            'message' => 'Merci de vous être abonné à notre newsletter.',
        ]);
    }
    
    public function render()
    {
        return view('livewire.newsletter.newsletter-subscription-form');
    }
}
