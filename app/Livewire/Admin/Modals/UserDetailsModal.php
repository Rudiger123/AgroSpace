<?php

namespace App\Livewire\Admin\Modals;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

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
            ->withCount(['offers', 'demands'])
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