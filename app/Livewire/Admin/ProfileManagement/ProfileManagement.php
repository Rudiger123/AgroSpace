<?php

namespace App\Livewire\Admin\ProfileManagement;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ProfileService;
use App\Services\TwoFactorService;
use App\Models\ActivityLog;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Gestion du Profil')]
class ProfileManagement extends Component
{
    use WithFileUploads;

    // États
    public $activeTab = 'informations';
    public $isEditing = false;

    // Données du profil
    public $name;
    public $email;
    public $phone;
    public $bio;
    public $location;
    public $avatar;
    public $newAvatar;

    // Changement de mot de passe
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    // Changement d'email
    public $new_email;
    public $email_password;

    // 2FA
    public $show2FAModal = false;
    public $twofa_password;
    public $qrCode;
    public $qrCodeSvg;
    public $recoveryCodes = [];
    public $twoFactorEnabled = false;

    // Suppression de compte
    public $showDeleteModal = false;
    public $delete_password;

    // Statistiques
    public $stats = [];
    public $activityStats = [];

    protected $listeners = ['profile.updated' => 'refreshProfile'];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
            'newAvatar' => 'nullable|image|max:2048',

            'current_password' => 'required_with:new_password|string',
            'new_password' => 'required_with:current_password|string|min:8|confirmed',

            'new_email' => 'required_with:email_password|email|unique:users,email,' . Auth::user()->id,
            'email_password' => 'required_with:new_email|string',

            'twofa_password' => 'required_with:show2FAModal|string',
            'delete_password' => 'required_with:showDeleteModal|string',
        ];
    }

    public function mount()
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->bio = $user->bio;
        $this->location = $user->city;
        $this->avatar = $user->avatar;
        $this->twoFactorEnabled = $user->hasTwoFactorEnabled();

        $this->loadStats();
        $this->loadActivityStats();
    }

    public function loadStats()
    {
        $user = Auth::user();
        if ($user->isProducer()) {
            $this->stats = $user->getProducerStats();
        } elseif ($user->isConsumer()) {
            $this->stats = $user->getConsumerStats();
        }
    }

    public function loadActivityStats()
    {
        $this->activityStats = ActivityLog::getLoginStats(Auth::user()->id, 30);
    }

    public function toggleEdit()
    {
        $this->isEditing = !$this->isEditing;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
        ]);

        try {
            $service = new ProfileService();
            $service->updateProfile(Auth::user(), [
                'name' => $this->name,
                'phone' => $this->phone,
                'bio' => $this->bio,
                'city' => $this->location,
            ]);

            $this->isEditing = false;
            $this->dispatch('profile-updated');

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => "Profil mis à jour avec succès !"
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function updateAvatar()
    {
        $this->validate([
            'newAvatar' => 'required|image|max:2048',
        ]);

        try {
            $service = new ProfileService();
            $url = $service->updateAvatar(Auth::user(), $this->newAvatar);

            $this->avatar = $url;
            $this->newAvatar = null;

            $this->emit('profile-updated');
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Photo de profil mise à jour !'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $service = new ProfileService();
            $service->updatePassword(
                Auth::user(),
                $this->current_password,
                $this->new_password
            );

            $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
            Auth::logout();

            return redirect()->route('login')->with(
                'toast',
                [
                    'type' => 'success',
                    'message' => 'Mot de passe mis à jour. Veuillez vérifier votre nouveau mot de passe en vous connectant!',
                ]
            );
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateEmail()
    {
        $this->validate([
            'new_email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'email_password' => 'required|string',
        ]);

        try {
            $service = new ProfileService();
            $service->updateEmail(
                Auth::user(),
                $this->new_email,
                $this->email_password
            );

            Auth::logout();

            return redirect()->route('login')->with(
                'toast',
                [
                    'type' => 'success',
                    'message' => 'Email mis à jour. Veuillez vérifier votre nouveau email avant de vous reconnecter.',
                ]
            );
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function enable2FA()
    {
        $this->validate([
            'twofa_password' => 'required|string',
        ]);

        if (!Hash::check($this->twofa_password, Auth::user()->password)) {
            $this->addError('twofa_password', 'Mot de passe incorrect');
            return;
        }

        try {
            $service = new TwoFactorService();
            $data = $service->enable(Auth::user());

            $this->qrCode = $data['qr_code'];
            // Utilisation de bacon/bacon-qr-code
            $renderer = new ImageRenderer(
                new RendererStyle(200), // Taille 200px
                new SvgImageBackEnd()   // Format SVG
            );

            $writer = new Writer($renderer);
            $this->qrCodeSvg = $writer->writeString($this->qrCode);
            $this->recoveryCodes = $data['recovery_codes'];
            $this->twoFactorEnabled = true;
            $this->twofa_password = '';

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Authentification à deux facteurs activée !'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function disable2FA()
    {
        try {
            $service = new TwoFactorService();
            $service->disable(Auth::user());

            $this->twoFactorEnabled = false;
            $this->qrCode = null;
            $this->recoveryCodes = [];

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Authentification à deux facteurs désactivée'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erreur : ' . $e->getMessage()
            ]);
        }
    }

    public function exportRecoveryCodes($format)
    {
        $exporter = new \App\Actions\ExportRecoveryCodes();

        switch ($format) {
            case 'csv':
                $content = $exporter->toCsv($this->recoveryCodes);
                return response()->streamDownload(function () use ($content) {
                    echo $content;
                }, 'agrospace-recovery-codes.csv');

            case 'md':
                $content = $exporter->toMarkdown($this->recoveryCodes);
                return response()->streamDownload(function () use ($content) {
                    echo $content;
                }, 'agrospace-recovery-codes.md');

                /*case 'pdf':
                return $exporter->toPdf($this->recoveryCodes, Auth::user()->name);

            case 'xlsx':
                $filename = $exporter->toXlsx($this->recoveryCodes);
                return response()->download($filename)->deleteFileAfterSend();*/
        }
    }

    /**
     * Confirmation de suppression d'un utilisateur
     */
    public function confirmDelete()
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Confirmer la suppression',
            'text' => "Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.",
            'icon' => 'warning',
            'confirmText' => 'Oui, supprimer',
            'cancelText' => 'Annuler',
            'method' => 'deleteAccount',
            'params' => []
        ]);
    }

    /**
     * Suppression effective du Compte
     */
    #[On('deleteAccount')]
    public function deleteAccount()
    {
        $this->validate([
            'delete_password' => 'required|string',
        ]);

        try {
            $service = new ProfileService();

            $service->deleteAccount(Auth::user(), $this->delete_password);

            Auth::logout();

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Votre Compte à été supprimé avec succès',
            ]);

            $this->redirect('/', navigate: true);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function refreshProfile()
    {
        $this->mount();
    }

    public function render()
    {
        return view('livewire.admin.profile-management.profile-management');
    }
}
