<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Langues supportées par l'application
     */
    protected $supportedLocales = ['fr', 'en'];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Vérifier si une langue est définie dans la session
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            if ($this->isLocaleSupported($locale)) {
                App::setLocale($locale);
                return $next($request);
            }
        }

        // 2. Vérifier le paramètre dans l'URL (optionnel)
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            if ($this->isLocaleSupported($locale)) {
                Session::put('locale', $locale);
                App::setLocale($locale);
                return $next($request);
            }
        }

        // 3. Vérifier le cookie
        if ($request->hasCookie('locale')) {
            $locale = $request->cookie('locale');
            if ($this->isLocaleSupported($locale)) {
                Session::put('locale', $locale);
                App::setLocale($locale);
                return $next($request);
            }
        }

        // 4. Détecter la langue du navigateur
        $browserLocale = $this->detectBrowserLocale($request);
        if ($browserLocale) {
            Session::put('locale', $browserLocale);
            App::setLocale($browserLocale);
            return $next($request);
        }

        // 5. Utiliser la langue par défaut
        App::setLocale(config('app.locale', 'en'));

        return $next($request);
    }

    /**
     * Vérifie si la locale est supportée
     */
    protected function isLocaleSupported($locale): bool
    {
        return in_array($locale, $this->supportedLocales);
    }

    /**
     * Détecte la langue préférée du navigateur
     */
    protected function detectBrowserLocale(Request $request): ?string
    {
        $acceptLanguage = $request->header('Accept-Language');
        
        if (!$acceptLanguage) {
            return null;
        }

        // Parser le header Accept-Language
        $languages = explode(',', $acceptLanguage);
        
        foreach ($languages as $language) {
            $locale = substr($language, 0, 2);
            
            if ($this->isLocaleSupported($locale)) {
                return $locale;
            }
        }

        return null;
    }
}