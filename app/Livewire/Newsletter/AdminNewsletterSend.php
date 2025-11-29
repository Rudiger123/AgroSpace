<?php

namespace App\Livewire\Newsletter;

use App\Jobs\SendNewsletterJob;
use App\Models\NewsletterSubscriber;
use Livewire\Attributes\On;
use Livewire\Component;

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
        'subject.required' => "L'objet est obligatoire",
        'message.required' => 'Le message est obligatoire',
        'message.min' => 'Le message doit contenir au moins 10 caractères',
    ];

    // Méthode pour obtenir les messages traduits
    protected function getTranslatedMessages()
    {
        return [
            'subject.required' => __('newsletter.subject_required'),
            'message.required' => __('newsletter.message_required'),
            'message.min' => __('newsletter.message_min'),
        ];
    }

    // protected $templates = [
    //     'welcome' => [
    //         'subject' => '🎉 ' . __('newsletter.template_welcome_subject'),
    //         'message' => "\n\n" . __('newsletter.template_welcome_message'),
    //     ],
    //     'special_offer' => [
    //         'subject' => '🎁 ' . __('newsletter.template_offer_subject'),
    //         'message' => "\n\n" . __('newsletter.template_offer_message'),
    //     ],
    // ];

    protected $templates = [
        'welcome' => [
            'subject' => '🎉 Bienvenue sur Agrospace !',
            'message' => "\n\nNous sommes ravis de vous accueillir sur Agrospace, la plateforme qui connecte les producteurs et consommateurs du secteur agropastoral au Cameroun.\n\nVotre compte {role} est maintenant actif. Vous pouvez dès maintenant :\n• Explorer les offres et demandes\n• Publier vos propres annonces\n• Échanger avec la communauté\n• Accéder à nos ressources et actualités\n\nBesoin d'aide ? Notre équipe est là pour vous accompagner.\n\nCordialement,\nL'équipe Agrospace 🌾",
        ],
        'special_offer' => [
            'subject' => '🎁 Offre spéciale Agrospace',
            'message' => "\n\nProfitez de notre offre spéciale ! Le meilleur de l'agropastoralisme est là.\n\n[Détails de la promotion]\n\nValable jusqu'au [date]\n\nCordialement,\nL'équipe Agrospace 🌾",
        ],
    ];

    public function sendNewsletter()
    {
        $this->validate();

        $activeSubscribers = NewsletterSubscriber::active()->get();

        foreach ($activeSubscribers as $subscriber) {
            SendNewsletterJob::dispatch($subscriber, $this->subject, $this->message);
        }

        $this->reset(['subject', 'message', 'selectedTemplate']);
        $this->close();

        $this->dispatch('toast', [
            'title' => __('newsletter.send_success_title'),
            'message' => __("newsletter.send_success_message", ['count' => $activeSubscribers->count()]),
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
        $this->resetValidation();
        $this->reset(['subject', 'message', 'selectedTemplate']);
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.newsletter.admin-newsletter-send');
    }
}
