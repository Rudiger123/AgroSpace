<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{

    use WithFileUploads;

    public $name;
    public $bio;
    public $location;
    public $activity;
    public $avatar;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->bio = $user->bio;
        $this->location = $user->location;
        $this->activity = $user->activity;
        $this->avatar = $user->avatar;
    }

    public function render()
    {
        return view('livewire.admin.profile')->layout('layouts.admin');
    }
}
