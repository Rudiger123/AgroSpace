<?php

namespace App\Livewire\Newsletter;

use App\Jobs\SendNewsletterJob;
use App\Models\NewsletterSubscriber;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class AdminNewsletterSend extends Component
{
    public $subject = '';
    public $message = '';
    public $show = false;
    public $recipients = [];
    public $selectedTemplate;


    protected $rules = [
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10',
    ];

    protected $messages = [
        'subject.required' => 'L\'objet est obligatoire',
        'message.required' => 'Le message est obligatoire',
        'message.min' => 'Le message doit contenir au moins 10 caractères',
    ];

    protected $templates = [
        'welcome' => [
            'subject' => '🎉 Bienvenue sur Agrospace !',
            'message' => "Bonjour {nom},\n\nNous sommes ravis de vous accueillir sur Agrospace, la plateforme qui connecte les producteurs et consommateurs du secteur agropastoral au Cameroun.\n\nVotre compte {role} est maintenant actif. Vous pouvez dès maintenant :\n• Explorer les offres et demandes\n• Publier vos propres annonces\n• Échanger avec la communauté\n• Accéder à nos ressources et actualités\n\nBesoin d'aide ? Notre équipe est là pour vous accompagner.\n\nCordialement,\nL'équipe Agrospace 🌾",
        ],
        'verification' => [
            'subject' => '✅ Vérification de votre compte Agrospace',
            'message' => "Bonjour {nom},\n\nFélicitations ! Votre compte Agrospace a été vérifié avec succès.\n\nVous bénéficiez maintenant de tous les avantages :\n✓ Badge vérifié sur votre profil\n✓ Visibilité accrue\n✓ Accès prioritaire aux fonctionnalités\n\nContinuez à développer votre activité sur Agrospace !\n\nCordialement,\nL'équipe Agrospace 🌾",
        ],
        'offer_approved' => [
            'subject' => '📦 Votre offre a été approuvée !',
            'message' => "Bonjour {nom},\n\nBonne nouvelle ! Votre offre vient d'être approuvée et est maintenant visible par tous les utilisateurs d'Agrospace.\n\nConsultez les statistiques de votre offre depuis votre tableau de bord pour suivre son évolution.\n\nCordialement,\nL'équipe Agrospace 🌾",
        ],
        'offer_rejected' => [
            'subject' => '❌ Votre offre nécessite des modifications',
            'message' => "Bonjour {nom},\n\nNous avons examiné votre offre et elle nécessite quelques ajustements avant d'être publiée.\n\nMotif : [À compléter]\n\nVeuillez apporter les modifications nécessaires et soumettre à nouveau votre offre.\n\nCordialement,\nL'équipe Agrospace 🌾",
        ],
        'account_suspended' => [
            'subject' => '⏸ Suspension temporaire de votre compte',
            'message' => "Bonjour {nom},\n\nVotre compte Agrospace a été temporairement suspendu suite à [raison].\n\nPour réactiver votre compte, veuillez nous contacter à support@agrospace.cm.\n\nCordialement,\nL'équipe Agrospace 🌾",
        ],
        'newsletter' => [
            'subject' => '📰 Newsletter Agrospace - [Mois Année]',
            'message' => "Bonjour {nom},\n\nDécouvrez les actualités du mois :\n\n• Nouveauté 1\n• Nouveauté 2\n• Nouveauté 3\n\nRestez connecté avec Agrospace !\n\nCordialement,\nL'équipe Agrospace 🌾",
        ],
        'promotion' => [
            'subject' => '🎁 Offre spéciale Agrospace',
            'message' => "Bonjour {nom},\n\nProfitez de notre offre spéciale !\n\n[Détails de la promotion]\n\nValable jusqu'au [date]\n\nCordialement,\nL'équipe Agrospace 🌾",
        ],
    ];

    public function sendNewsletter()
    {
        $this->validate();

        $activeSubscribers = NewsletterSubscriber::active()->get();

        foreach ($activeSubscribers as $subscriber) {
            SendNewsletterJob::dispatch($subscriber, $this->subject, $this->message);
        }

        $this->reset(['subject', 'message']);
        $this->close();

        $this->dispatch('toast', [
            'title' => 'Newsletter en cours d\'envoi !',
            'message' => "La newsletter a été mise en file d'attente pour {$activeSubscribers->count()} abonnés.",
            'type' => 'success',
        ]);
    }

    #[On('openEmailModal')]
    public function open()
    {
        $this->recipients = NewsletterSubscriber::active()->get();
        $this->show = true;
    }

    public function updatedSelectedTemplate($value)
    {
        if ($value && isset($this->templates[$value])) {
            $this->subject = $this->templates[$value]['subject'];
            $this->message = $this->templates[$value]['message'];
        }
    }

    public function close()
    {
        $this->reset();
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.newsletter.admin-newsletter-send');
    }
}
