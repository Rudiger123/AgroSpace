<?php

namespace App\Livewire\Admin\Modals;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Modal de création/édition d'utilisateur
 */
class CreateEditUserModal extends Component
{
    use WithFileUploads;

    public $show = false;
    public $userId = null;
    
    // Champs du formulaire
    public $name;
    public $email;
    public $phone;
    public $role;
    public $region;
    public $city;
    public $bio;
    public $status = 'active';
    public $password;
    public $password_confirmation;
    public $avatar;
    public $currentAvatar;
    public $emailVerified = false;

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'phone' => 'required|string|max:20',
            'role' => 'required|in:producer,consumer,admin',
            'region' => 'required|string',
            'city' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'status' => 'required|in:active,suspended,banned',
            'avatar' => 'nullable|image|max:2048',
        ];

        if (!$this->userId) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        return $rules;
    }

    protected $messages = [
        'name.required' => 'Le nom est obligatoire',
        'email.required' => 'L\'email est obligatoire',
        'email.email' => 'L\'email n\'est pas valide',
        'email.unique' => 'Cet email est déjà utilisé',
        'phone.required' => 'Le téléphone est obligatoire',
        'role.required' => 'Le rôle est obligatoire',
        'region.required' => 'La région est obligatoire',
        'city.required' => 'La ville est obligatoire',
        'password.required' => 'Le mot de passe est obligatoire',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
        'password.confirmed' => 'Les mots de passe ne correspondent pas',
        'avatar.image' => 'Le fichier doit être une image',
        'avatar.max' => 'L\'image ne doit pas dépasser 2 Mo',
    ];

    #[On('openCreateUserModal')]
    public function openCreate()
    {
        $this->reset();
        $this->show = true;
    }

    #[On('openEditUserModal')]
    public function openEdit($userId)
    {
        $this->reset();
        $user = User::findOrFail($userId);
        
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->role;
        $this->region = $user->region;
        $this->city = $user->city;
        $this->bio = $user->bio;
        $this->status = $user->status;
        $this->currentAvatar = $user->avatar_url;
        $this->emailVerified = !is_null($user->email_verified_at);
        
        $this->show = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'region' => $this->region,
            'city' => $this->city,
            'bio' => $this->bio,
            'status' => $this->status,
            'email_verified_at' => $this->emailVerified ? now() : null,
        ];

        if (!$this->userId && $this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $data['avatar'] = $path;

            // Supprimer l'ancien avatar si modification
            if ($this->userId) {
                $user = User::find($this->userId);
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }
        }

        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $user->update($data);
            $message = "L'utilisateur {$user->name} a été mis à jour avec succès.";
        } else {
            $user = User::create($data);
            $message = "L'utilisateur {$user->name} a été créé avec succès.";
        }

        $this->dispatch('userSaved');
        $this->dispatch('refresh-users');
        session()->flash('success', $message);
        
        $this->close();
    }

    public function close()
    {
        $this->reset();
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.admin.modals.create-edit-user-modal');
    }
}

/**
 * Modal de détails utilisateur
 */
class UserDetailsModal extends Component
{
    public $show = false;
    public $user = null;

    #[On('openUserDetailsModal')]
    public function open($userId)
    {
        $this->user = User::with(['offers', 'demands'])
            ->withCount(['offers', 'demands', 'messages'])
            ->findOrFail($userId);
        
        $this->show = true;
    }

    public function sendEmail()
    {
        $this->dispatch('openSendEmailModal', userIds: [$this->user->id]);
        $this->close();
    }

    public function editUser()
    {
        $this->dispatch('openEditUserModal', userId: $this->user->id);
        $this->close();
    }

    public function close()
    {
        $this->reset();
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.admin.modals.user-details-modal');
    }
}

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
        'subject.required' => 'L\'objet est obligatoire',
        'message.required' => 'Le message est obligatoire',
        'message.min' => 'Le message doit contenir au moins 10 caractères',
        'scheduledAt.after' => 'La date doit être dans le futur',
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

            // Logique d'envoi d'email
            Mail::to($recipient->email)->send(
                new \App\Mail\AdminEmail($personalizedSubject, $personalizedMessage)
            );
        }

        if ($this->sendCopy) {
            Mail::to(auth()->user()->email)->send(
                new \App\Mail\AdminEmail($this->subject, $this->message)
            );
        }

        session()->flash('success', 'Email(s) envoyé(s) avec succès !');
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

    public function previewEmail()
    {
        $this->dispatch('showPreview', [
            'subject' => $this->subject,
            'message' => $this->message,
            'recipient' => $this->recipients->first()
        ]);
    }

    public function saveDraft()
    {
        // Sauvegarder en brouillon
        session()->flash('success', 'Brouillon sauvegardé !');
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