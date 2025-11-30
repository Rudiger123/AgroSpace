<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class LanguageSwitcher extends Component
{
    public $currentLocale;
    public $isOpen = false;

    // Langues disponibles avec leurs configurations
    public $availableLanguages = [
        'fr' => [
            'name' => 'Français Camerounais',
            'native' => 'Français Camerounais',
            'flag' => '🇨🇲',
            'code' => 'fr',
            'direction' => 'ltr',
        ],
        'en' => [
            'name' => 'Cameroon English',
            'native' => 'Cameroon English',
            'flag' => '🇨🇲',
            'code' => 'en',
            'direction' => 'ltr',
        ],
        // Ajoutez d'autres langues ici facilement
        /*
        'es' => [
            'name' => 'Spanish',
            'native' => 'Español',
            'flag' => '🇪🇸',
            'code' => 'es',
            'direction' => 'ltr',
        ],
        'de' => [
            'name' => 'German',
            'native' => 'Deutsch',
            'flag' => '🇩🇪',
            'code' => 'de',
            'direction' => 'ltr',
        ],
        'ar' => [
            'name' => 'Arabic',
            'native' => 'العربية',
            'flag' => '🇸🇦',
            'code' => 'ar',
            'direction' => 'rtl',
        ],
        'zh' => [
            'name' => 'Chinese',
            'native' => '中文',
            'flag' => '🇨🇳',
            'code' => 'zh',
            'direction' => 'ltr',
        ],
        'ja' => [
            'name' => 'Japanese',
            'native' => '日本語',
            'flag' => '🇯🇵',
            'code' => 'ja',
            'direction' => 'ltr',
        ],
        'pt' => [
            'name' => 'Portuguese',
            'native' => 'Português',
            'flag' => '🇵🇹',
            'code' => 'pt',
            'direction' => 'ltr',
        ],
        */
    ];

    public function mount()
    {
        // Détection automatique de la langue
        $this->currentLocale = $this->detectLanguage();

        // Appliquer la langue détectée
        App::setLocale($this->currentLocale);
    }

    /**
     * Détecte la langue préférée de l'utilisateur
     */
    protected function detectLanguage()
    {
        // 1. Vérifier la session
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            if (array_key_exists($locale, $this->availableLanguages)) {
                return $locale;
            }
        }

        // 2. Vérifier le cookie
        if (Cookie::has('locale')) {
            $locale = Cookie::get('locale');
            if (array_key_exists($locale, $this->availableLanguages)) {
                Session::put('locale', $locale);
                return $locale;
            }
        }

        // 3. Vérifier la langue du navigateur
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (array_key_exists($browserLang, $this->availableLanguages)) {
                Session::put('locale', $browserLang);
                return $browserLang;
            }
        }

        // 4. Langue par défaut (anglais)
        return config('app.locale', 'en');
    }

    /**
     * Change la langue de l'application
     */
    public function changeLanguage($locale)
    {
        // Vérifier que la langue existe
        if (!array_key_exists($locale, $this->availableLanguages)) {
            $locale = 'en'; // Fallback vers anglais
        }

        // Mettre à jour la locale
        $this->currentLocale = $locale;
        App::setLocale($locale);

        // Sauvegarder dans la session
        Session::put('locale', $locale);

        // Sauvegarder dans un cookie (1 an)
        Cookie::queue('locale', $locale, 525600);

        // Fermer le dropdown
        $this->isOpen = false;

        // Émettre un événement pour informer les autres composants
        $this->dispatch('language-changed', locale: $locale);

        // Message de confirmation
        $this->dispatch('language-updated', [
            'message' => $this->getTranslation('language_changed', $locale),
            'locale' => $locale,
            'flag' => $this->availableLanguages[$locale]['flag'],
            'name' => $this->availableLanguages[$locale]['native']
        ]);

        // Rafraîchir la page pour appliquer les traductions $this->redirect(url()->current(), navigate: true);
        $this->dispatch('refresh-page');
    }

    /**
     * Toggle le dropdown
     */
    public function toggleDropdown()
    {
        $this->isOpen = !$this->isOpen;
    }

    /**
     * Fermer le dropdown
     */
    public function closeDropdown()
    {
        $this->isOpen = false;
    }

    /**
     * Obtenir la langue courante
     */
    public function getCurrentLanguage()
    {
        return $this->availableLanguages[$this->currentLocale] ?? $this->availableLanguages['en'];
    }

    /**
     * Traductions simples pour les messages de confirmation
     */
    protected function getTranslation($key, $locale)
    {
        $translations = [
            'language_changed' => [
                'fr' => 'Langue changée avec succès !',
                'en' => 'Language changed successfully!',
                'es' => '¡Idioma cambiado con éxito!',
                'de' => 'Sprache erfolgreich geändert!',
                'ar' => 'تم تغيير اللغة بنجاح!',
                'zh' => '语言更改成功！',
                'ja' => '言語が正常に変更されました！',
                'pt' => 'Idioma alterado com sucesso!',
            ]
        ];

        return $translations[$key][$locale] ?? $translations[$key]['en'] ?? 'Success!';
    }

    /**
     * Obtenir les statistiques des langues (optionnel - pour analytics)
     */
    public function getLanguageStats()
    {
        // Vous pouvez tracker l'utilisation des langues
        return [
            'current' => $this->currentLocale,
            'available' => count($this->availableLanguages),
            'direction' => $this->availableLanguages[$this->currentLocale]['direction'] ?? 'ltr'
        ];
    }

    public function render()
    {
        return view('livewire.components.language-switcher', [
            'currentLanguage' => $this->getCurrentLanguage(),
            'languages' => $this->availableLanguages,
        ]);
    }
}
