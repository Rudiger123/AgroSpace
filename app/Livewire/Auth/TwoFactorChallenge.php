<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Services\TwoFactorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.guest')]
#[Title('2fa challenge - AgroSpace')]
class TwoFactorChallenge extends Component
{
    public $code = '';
    public $recovery_code = '';
    public $useRecoveryCode = false;
    public $attempts = 0;
    public $maxAttempts = 5;
    public $user;

    protected $rules = [
        'code' => 'required|string|size:6',
        'recovery_code' => 'required|string|min:10',
    ];

    public function mount()
    {
        // Vérifier si un utilisateur est en attente de 2FA
        if (!session()->has('two_factor_user_id')) {
            return redirect()->route('login');
        }

        $this->user = User::find(session('two_factor_user_id'));

        if (!$this->user || !$this->user->hasTwoFactorEnabled()) {
            session()->forget('two_factor_user_id');
            return redirect()->route('login');
        }

        // Récupérer le nombre de tentatives
        $this->attempts = session('two_factor_attempts', 0);
    }

    public function toggleRecoveryCode()
    {
        $this->useRecoveryCode = !$this->useRecoveryCode;
        $this->reset(['code', 'recovery_code']);
        $this->resetErrorBag();
    }

    public function verify()
    {
        // Vérifier le rate limiting
        $key = 'two-factor-challenge:' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, $this->maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            $this->addError('code', __('auth.two_factor.too_many_attempts', ['seconds' => $seconds]));
            return;
        }

        $service = new TwoFactorService();
        $verified = false;

        if ($this->useRecoveryCode) {
            $this->validate(['recovery_code' => 'required|string|min:10']);
            $verified = $service->verifyRecoveryCode($this->user, $this->recovery_code);

            if (!$verified) {
                $this->addError('recovery_code', __('auth.two_factor.invalid_recovery_code'));
            }
        } else {
            $this->validate(['code' => 'required|string|size:6']);
            $verified = $service->verifyCode($this->user, $this->code);

            if (!$verified) {
                $this->addError('code', __('auth.two_factor.invalid_code'));
            }
        }

        if (!$verified) {
            RateLimiter::hit($key, 300); // 5 minutes

            $this->attempts++;
            session(['two_factor_attempts' => $this->attempts]);

            // Après 3 tentatives, proposer les codes de récupération
            if ($this->attempts >= 3 && !$this->useRecoveryCode) {
                $this->dispatch('suggest-recovery', [
                    'message' => __('auth.two_factor.suggest_recovery')
                ]);
            }

            // Après max tentatives, bloquer temporairement
            if ($this->attempts >= $this->maxAttempts) {
                session()->forget(['two_factor_user_id', 'two_factor_attempts']);

                return redirect()->route('login')->with(
                    'error',
                    __('auth.two_factor.max_attempts_reached')
                );
            }

            return;
        }

        // Succès - Authentifier l'utilisateur
        RateLimiter::clear($key);
        Auth::login($this->user);
        $service->markSessionAsAuthenticated();

        // Nettoyer la session
        session()->forget(['two_factor_user_id', 'two_factor_attempts']);
        session()->regenerate();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => __('auth.two_factor.success')
        ]);

        // Rediriger selon le rôle
        return redirect()->intended($this->getRedirectUrl());
    }

    protected function getRedirectUrl(): string
    {
        $role = $this->user->role->name;

        return match ($role) {
            'admin' => route('dashboard'),
            'producer' => route('dashboard'),
            'consumer' => route('dashboard'),
            default => route('dashboard'),
        };
    }

    public function logout()
    {
        session()->forget(['two_factor_user_id', 'two_factor_attempts']);
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.two-factor-challenge');
    }
}