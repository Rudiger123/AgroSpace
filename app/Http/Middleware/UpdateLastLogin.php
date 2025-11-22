<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Mettre à jour la dernière connexion seulement si c'est une nouvelle session
            // ou si la dernière mise à jour date de plus de 5 minutes $user->last_login_at->lt(now()->subMinutes(5))
            if (!$user->last_login_at ) {
                $user->update([
                    'last_login_at' => now()
                ]);
            }
        }

        return $next($request);
    }
}
