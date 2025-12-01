<?php

namespace App\Livewire\Settings;

use App\Models\UserPreference;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('paramètres utilisateur')]
class PreferencesManager extends Component
{
    // Préférences
    public $language = 'fr';
    public $timezone = 'Africa/Douala';
    public $currency = 'XAF';

    // Notifications par type
    public $notify_new_offers = true;
    public $notify_new_demands = true;
    public $notify_articles = true;
    public $notify_chat_messages = true;
    public $notify_admin_alerts = true;

    // Canaux de notification
    public $email_notifications = true;
    public $push_notifications = true;
    public $sms_notifications = false;

    // Interface
    public $theme = 'light';
    public $compact_view = false;
    public $show_tutorials = true;

    // États
    public $activeTab = 'notifications';
    public $saving = false;

    protected $listeners = ['preferencesUpdated' => 'refreshPreferences'];

    public function mount()
    {
        $user = Auth::user();
        $preferences = $user->preferences;

        // Préférences
        if ($preferences) {
            $this->language = $preferences->language;
            $this->timezone = $preferences->timezone;
            $this->currency = $preferences->currency;

            $this->notify_new_offers = $preferences->notify_new_offers;
            $this->notify_new_demands = $preferences->notify_new_demands;
            $this->notify_articles = $preferences->notify_articles;
            $this->notify_chat_messages = $preferences->notify_chat_messages;
            $this->notify_admin_alerts = $preferences->notify_admin_alerts;

            $this->email_notifications = $preferences->email_notifications;
            $this->push_notifications = $preferences->push_notifications;
            $this->sms_notifications = $preferences->sms_notifications;

            $this->theme = $preferences->theme;
            $this->compact_view = $preferences->compact_view;
            $this->show_tutorials = $preferences->show_tutorials;
        }
    }

    public function refreshPreferences()
    {
        $this->mount();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function savePreferences()
    {
        $this->saving = true;

        try {
            $user = Auth::user();

            $validated = $this->validate([
                'language' => 'required|in:fr,en,es',
                'timezone' => 'required|timezone',
                'currency' => 'required|in:XAF,EUR,USD',

                'notify_new_offers' => 'boolean',
                'notify_new_demands' => 'boolean',
                'notify_articles' => 'boolean',
                'notify_chat_messages' => 'boolean',
                'notify_admin_alerts' => 'boolean',

                'email_notifications' => 'boolean',
                'push_notifications' => 'boolean',
                'sms_notifications' => 'boolean',

                'theme' => 'required|in:light,dark,system',
                'compact_view' => 'boolean',
                'show_tutorials' => 'boolean',
            ]);

            UserPreference::updateOrCreate(
                ['user_id' => $user->id],
                $validated
            );

            // Mettre à jour la session si la langue change
            if ($this->language !== app()->getLocale()) {
                session()->put('locale', $this->language);
            }

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => __('settings.preferences.success')
            ]);

            $this->dispatch('preferencesUpdated');
        } catch (\Exception $e) {
            Log::error('Preferences update error: ' . $e->getMessage());

            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('settings.preferences.error')
            ]);
        } finally {
            $this->saving = false;
        }
    }

    public function toggleNotification($type)
    {
        $this->$type = !$this->$type;
        $this->savePreferences();
    }

    public function render()
    {
        return view('livewire.settings.preferences-manager');
    }
}