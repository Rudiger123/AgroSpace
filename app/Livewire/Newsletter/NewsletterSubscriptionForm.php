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

    protected function getTranslatedMessages()
    {
        return [
            'name.required' => __('newsletter.name_required'),
            'name.regex' => __('newsletter.name_invalid'),
            'email.required' => __('newsletter.email_required'),
            'email.email' => __('newsletter.email_invalid'),
            'email.unique' => __('newsletter.email_already_subscribed'),
            'email.regex' => __('newsletter.email_format_invalid'),
            'email.dns' => __('newsletter.email_domain_invalid'),
            'email.spoof' => __('newsletter.email_suspicious'),
        ];
    }

    public function subscribe()
    {
        $this->validate();

        $newsletter = new NewsletterSubscriber();
        $newsletter->name = $this->name;
        $newsletter->email = $this->email;
        $newsletter->save();

        $this->reset(['name', 'email']);

        $message = __('newsletter.subscription_success');

        session()->flash('toast', [
            'type' => 'success',
            'message' => $message,
        ]);

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => $message,
        ]);
    }

    public function render()
    {
        return view('livewire.newsletter.newsletter-subscription-form');
    }
}
