<?php

namespace App\Livewire\Admin\Modals;

use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * Modal d'envoi d'email
 */
class SendEmailModal extends Component
{
    public $show = false;
    public $recipients = [];
    public $subject;
    public $message;
    public $selectedTemplate;
    public $sendCopy = false;
    public $scheduleEmail = false;
    public $scheduledAt;

    protected $rules = [
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10',
        'scheduledAt' => 'nullable|date|after:now',
    ];

    protected $messages = [
        'subject.required' => __('emails.subject_required'),
        'message.required' => __('emails.message_required'),
        'message.min' => __('emails.message_min'),
        'scheduledAt.after' => __('emails.scheduled_after'),
    ];

    protected $templates = [
        'welcome' => [
            'subject' => __('emails.welcome_subject'),
            'message' => __('emails.welcome_message'),
        ],
        'verification' => [
            'subject' => __('emails.verification_subject'),
            'message' => __('emails.verification_message'),
        ],
        'offer_approved' => [
            'subject' => __('emails.offer_approved_subject'),
            'message' => __('emails.offer_approved_message'),
        ],
        'offer_rejected' => [
            'subject' => __('emails.offer_rejected_subject'),
            'message' => __('emails.offer_rejected_message'),
        ],
        'account_suspended' => [
            'subject' => __('emails.account_suspended_subject'),
            'message' => __('emails.account_suspended_message'),
        ],
        'newsletter' => [
            'subject' => __('emails.newsletter_subject'),
            'message' => __('emails.newsletter_message'),
        ],
        'promotion' => [
            'subject' => __('emails.promotion_subject'),
            'message' => __('emails.promotion_message'),
        ],
    ];

    #[On('openSendEmailModal')]
    public function open($userIds)
    {
        $this->recipients = User::whereIn('id', $userIds)->get();
        $this->show = true;
    }

    public function updatedSelectedTemplate($value)
    {
        if ($value && isset($this->templates[$value])) {
            $this->subject = $this->templates[$value]['subject'];
            $this->message = $this->templates[$value]['message'];
        }
    }

    public function sendEmail()
    {
        $this->validate();

        foreach ($this->recipients as $recipient) {
            $personalizedSubject = $this->replaceVariables($this->subject, $recipient);
            $personalizedMessage = $this->replaceVariables($this->message, $recipient);

            // Envoyer la notification
            Notification::send($recipient, new AdminNotification($this->subject, $this->message));
        }

        if ($this->sendCopy) {
            Auth::user()->notify(new AdminNotification($this->subject, $this->message));
        }
        $message = count($this->recipients) . ' ' . __('emails.users_selected_for_email');

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => $message
        ]);

        // Rafraîchir la liste des utilisateurs
        $this->dispatch('refresh-users');

        $this->close();
    }

    private function replaceVariables($text, $user)
    {
        return str_replace(
            ['{nom}', '{email}', '{role}'],
            [$user->name, $user->email, $user->getRoleBadge()['label']],
            $text
        );
    }

    // public function previewEmail()
    // {
    //     $this->dispatch('showPreview', [
    //         'subject' => $this->subject,
    //         'message' => $this->message,
    //         'recipient' => $this->recipients->first()
    //     ]);
    // }

    public function saveDraft()
    {
        // Sauvegarder en brouillon
        session()->flash('success', __('emails.draft_saved'));
    }

    public function close()
    {
        $this->reset();
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.admin.modals.send-email-modal');
    }
}