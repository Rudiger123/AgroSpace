<?php

namespace App\Livewire\Newsletter;

use App\Models\NewsletterSubscriber;
use Livewire\Component;

class NewsletterSubscriptionForm extends Component
{
    public $name = '';
    public $email = '';

    protected $rules = [
        'name' => [
            'required',
            'string',
            'max:255',
            'regex:/^[^<>]*$/' // Interdit les caractères < et > pour éviter le HTML basique
        ],
        'email' => [
            'required',
            'string',
            'max:255',
            'unique:newsletter_subscribers,email',
            // 1. Vérification stricte des standards email (RFC) + Vérification DNS + Anti-Spoofing
            'email:rfc,dns,spoof',
            // 2. Regex stricte pour forcer un format standard et bloquer les caractères dangereux (XSS)
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
        ],
    ];

    protected $messages = [
        'name.required' => 'Le nom est obligatoire.',
        'name.regex' => 'Le nom contient des caractères non autorisés.',
        'email.required' => "L'email est obligatoire.",
        'email.email' => "L'adresse email n'est pas valide.",
        'email.unique' => 'Cet email est déjà inscrit à la newsletter.',
        'email.regex' => "Le format de l'email est invalide ou contient des caractères interdits.",
        'email.dns' => "Le nom de domaine de cet email n'existe pas.",
        'email.spoof' => "Cette adresse email semble suspecte.",
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
