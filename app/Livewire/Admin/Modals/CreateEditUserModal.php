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
        'name.required' => __('users.name_required'),
        'email.required' => __('users.email_required'),
        'email.email' => __('users.email_invalid'),
        'email.unique' => __('users.email_unique'),
        'phone.required' => __('users.phone_required'),
        'role.required' => __('users.role_required'),
        'region.required' => __('users.region_required'),
        'city.required' => __('users.city_required'),
        'password.required' => __('users.password_required'),
        'password.min' => __('users.password_min'),
        'password.confirmed' => __('users.password_confirmed'),
        'avatar.image' => __('users.avatar_image'),
        'avatar.max' => __('users.avatar_max'),
        'role.exists' => __('users.role_exists')
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
            $title = __('users.update_title');
            $message = __('users.update_success') . $user->name . '.';
        } else {
            $user = User::create($data);
            $title = __('users.create_title');
            $message = __('users.create_success') . $user->name . '.';
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