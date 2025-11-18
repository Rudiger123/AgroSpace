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
        'email.required' => "L'email est obligatoire.",
        'email.email' => "L'email doit être une adresse valide.",
        'email.unique' => 'Cet email est déjà inscrit à la newsletter.',
    ];

    public function subscribe()
    {
        $this->validate();

        // Assurez-vous que le modèle a bien une colonne 'status' par défaut à 'active'
        $newsletter = new NewsletterSubscriber();
        $newsletter->name = $this->name;
        $newsletter->email =  $this->email;
        $newsletter->save();
    
        $this->reset(['name', 'email']);

        // Utilisation de la session pour afficher le message après redirection ou refresh
        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Merci de vous être abonné à notre newsletter. Bienvenue chez Agrospace !',
        ]);
        
        // Dispatch pour le cas où le composant est utilisé sur la même page
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => 'Merci de vous être abonné à notre newsletter. Bienvenue chez Agrospace !',
        ]);
    }
    
    public function render()
    {
        return view('livewire.newsletter.newsletter-subscription-form');
    }
}