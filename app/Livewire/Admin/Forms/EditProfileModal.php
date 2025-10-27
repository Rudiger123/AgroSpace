<?php

namespace App\Livewire\Admin\Forms;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfileModal extends Component
{
    use WithFileUploads;

    public $isOpen = false;
    public $name = '';
    public $email = '';
    public $activity = '';
    public $location = '';
    public $bio = '';
    public $phone = '00000';
    public $avatar;
    public $currentAvatar;
    public $saving = false;

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|email',
            'bio' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:1000'],
            'location' => ['nullable', 'string', 'max:255'],
            'activity' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
        ];
    }

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = '00000';
        $this->location = $user->location ?? '';
        $this->currentAvatar = $user->avatar ?? null;
        $this->bio = $user->bio ?? '';
        $this->activity = $user->activity ?? '';
    }

    public function open()
    {
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
        $this->reset(['avatar', 'saving']);
        $this->resetValidation();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->saving = true;
        $this->validate();

        $user = Auth::user();

        // Gestion de l'upload de photo
        if ($this->avatar) {
            $photoPath = $this->avatar->store('profile-photos', 'public');
            $user->avatar = $photoPath;
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->bio = $this->bio;
        $user->activity = $this->activity;
        $user->location = $this->location;
        $user->save();

        $this->saving = false;
        
        // Message de succès
        session()->flash('message', 'Profil mis à jour avec succès ! Appuyer sur X ou annuler pour sortir');
        
        $this->close();
    }

    public function render()
    {
        return view('livewire.admin.forms.edit-profile-modal');
    }
}
