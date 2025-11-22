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
    public $activity;
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
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'role' => 'required|exists:roles,id',
            'region' => 'required|string',
            'city' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'status' => 'required|in:active,suspended,banned',
            'avatar' => 'nullable|image|max:2048',
            "activity" => 'nullable|string|max:255'
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
        'role.exists' => 'Le role selectionné est inexistant'
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
        $this->role = $user->role_id;
        $this->region = $user->region;
        $this->city = $user->city;
        $this->bio = $user->bio;
        $this->activity = $user->activity;
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
            'role_id' => $this->role,
            'region' => $this->region,
            'city' => $this->city,
            'bio' => $this->bio,
            'status' => $this->status,
            'activity' => $this->activity,
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
            $title = 'Mise à Jour';
            $message = "L'utilisateur {$user->name} a été mis à jour avec succès.";
        } else {
            $user = User::create($data);
            $title = 'Création';
            $message = "L'utilisateur {$user->name} a été créé avec succès.";
        }

        $this->dispatch('userSaved');
        $this->dispatch('refresh-users');
        $this->dispatch('showAlert', [
            'type' => 'success',
            'title' => $title,
            'text' => $message
        ]);

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
