<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class TwoFactorSettings extends Component
{
    public $showQrCode = false;
    public $recoveryCodes = [];
    public $google2faSvg = null;

    /**
     * Activer le 2FA
     */
    public function enableTwoFactor()
    {
        $user = Auth::user();
        $google2fa = new Google2FA();

        // 1️⃣ Générer un secret TOTP
        $secret = $google2fa->generateSecretKey();
        $user->two_factor_secret = encrypt($secret);

        // 2️⃣ Générer les codes de récupération
        $this->recoveryCodes = collect(range(1, 8))->map(fn () => bin2hex(random_bytes(5)))->toArray();
        $user->two_factor_recovery_codes = encrypt(json_encode($this->recoveryCodes));

        $user->two_factor_enabled = true;
        $user->save();

        // 3️⃣ Générer QR Code SVG
        $company = config('app.name');
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            $company,
            $user->email,
            $secret
        );

        $renderer = new ImageRenderer(new RendererStyle(200), new SvgImageBackEnd());
        $writer = new Writer($renderer);
        $this->google2faSvg = $writer->writeString($qrCodeUrl);

        $this->showQrCode = true;

        session()->flash('success', 'Authentification à deux facteurs activée avec succès !');
    }

    /**
     * Désactiver le 2FA
     */
    public function disableTwoFactor()
    {
        $user = Auth::user();
        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->two_factor_enabled = false;
        $user->save();

        $this->showQrCode = false;
        $this->google2faSvg = null;
        $this->recoveryCodes = [];

        session()->flash('success', 'Authentification à deux facteurs désactivée.');
    }

    /**
    * Exporter les codes de récupération en CSV
    */
    public function exportRecoveryCodes()
    {
        if (!$this->recoveryCodes || count($this->recoveryCodes) === 0) {
            session()->flash('error', 'Aucun code de récupération à exporter.');
            return;
        }

        $filename = 'recovery_codes_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $csvContent = "Code\n" . implode("\n", $this->recoveryCodes);

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function render()
    {
        return view('livewire.auth.two-factor-settings')->layout('layouts.admin');
    }
}
