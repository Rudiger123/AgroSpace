<?php
// app/Services/TwoFactorService.php

namespace App\Services;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Collection;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorService
{
    protected Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    public function enable(User $user): array
    {
        $secret = $this->google2fa->generateSecretKey();
        $recoveryCodes = $this->generateRecoveryCodes();

        $user->update([
            'two_factor_secret' => encrypt($secret),
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
            'two_factor_confirmed_at' => now(),
        ]);

        ActivityLog::log('2fa_enabled', 'Authentification à deux facteurs activée');

        return [
            'secret' => $secret,
            'qr_code' => $this->google2fa->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $secret
            ),
            'recovery_codes' => $recoveryCodes,
        ];
    }

    public function disable(User $user): bool
    {
        $user->update([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);

        ActivityLog::log('2fa_disabled', 'Authentification à deux facteurs désactivée');

        return true;
    }

    public function verify(User $user, string $code): bool
    {
        $secret = decrypt($user->two_factor_secret);
        return $this->google2fa->verifyKey($secret, $code);
    }

    protected function generateRecoveryCodes(int $count = 8): array
    {
        return Collection::times($count, function () {
            return strtoupper(bin2hex(random_bytes(5)));
        })->toArray();
    }

    public function regenerateRecoveryCodes(User $user): array
    {
        $recoveryCodes = $this->generateRecoveryCodes();

        $user->update([
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        ]);

        ActivityLog::log('2fa_codes_regenerated', 'Codes de récupération régénérés');

        return $recoveryCodes;
    }


    /**
     * Vérifier le code 2FA
     */
    public function verifyCode(User $user, string $code): bool
    {
        if (!$user->hasTwoFactorEnabled()) {
            return false;
        }

        $secret = decrypt($user->two_factor_secret);
        $valid = $this->google2fa->verifyKey($secret, $code, 2); // 2 = tolérance de 30 secondes

        if ($valid) {
            ActivityLog::log('2fa_code_verified', 'Code 2FA vérifié avec succès');
        } else {
            ActivityLog::log('2fa_code_failed', 'Échec de vérification du code 2FA');
        }

        return $valid;
    }

    /**
     * Vérifier un code de récupération
     */
    public function verifyRecoveryCode(User $user, string $code): bool
    {
        if (!$user->hasTwoFactorEnabled()) {
            return false;
        }

        $recoveryCodes = $user->recoveryCodes();

        // Chercher le code (insensible à la casse)
        $codeIndex = array_search(strtoupper($code), array_map('strtoupper', $recoveryCodes));

        if ($codeIndex === false) {
            ActivityLog::log('2fa_recovery_failed', 'Échec de vérification du code de récupération');
            return false;
        }

        // Supprimer le code utilisé
        unset($recoveryCodes[$codeIndex]);
        $recoveryCodes = array_values($recoveryCodes); // Réindexer

        $user->update([
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes))
        ]);

        ActivityLog::log('2fa_recovery_used', 'Code de récupération utilisé', [
            'codes_remaining' => count($recoveryCodes)
        ]);

        // Si c'était le dernier code, alerter l'utilisateur
        if (count($recoveryCodes) === 0) {
            // TODO: Envoyer un email d'alerte
            ActivityLog::log('2fa_recovery_depleted', 'Tous les codes de récupération ont été utilisés');
        }

        return true;
    }

    /**
     * Marquer la session comme authentifiée 2FA
     */
    public function markSessionAsAuthenticated(): void
    {
        session(['two_factor_authenticated' => true]);
    }
}
