<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorChallenge extends Component
{
    public $code;
    public $user;

    protected $rules = [
        'code' => ['required', 'digits:6'],
    ];

    protected $messages = [
        'code.required' => 'Veuillez saisir le code de vérification.',
        'code.digits' => 'Le code doit comporter 6 chiffres.',
    ];

    public function mount()
    {
        // Récupère l'utilisateur depuis la session temporaire
        $userId = session('2fa:user:id');
        $this->user = \App\Models\User::find($userId);

        if (!$this->user) {
            abort(403, 'Utilisateur non trouvé ou session expirée.');
        }
    }

    public function verify()
    {
        $this->validate();

        $google2fa = new Google2FA();

        // Vérifie le code OTP
        if (!$google2fa->verifyKey(decrypt($this->user->two_factor_secret), $this->code)) {
            $this->addError('code', 'Code invalide. Réessayez.');
            return;
        }

        // Connexion définitive de l'utilisateur
        Auth::login($this->user);
        session()->forget('2fa:user:id');
        session(['2fa_passed' => true]);

        session()->flash('message', 'Authentification réussie !');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.two-factor-challenge')->layout('layouts.guest');
    }
}
