<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureTwoFactorAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Si l'utilisateur a 2FA activé mais n'a pas encore validé le code
        if ($user && $user->hasTwoFactorEnabled() && !session('two_factor_authenticated')) {
            // Déconnecter temporairement
            $userId = $user->id;
            Auth::logout();

            // Stocker l'ID en session pour la page 2FA
            session(['two_factor_user_id' => $userId]);

            return redirect()->route('2fa.challenge');
        }

        return $next($request);
    }
}
