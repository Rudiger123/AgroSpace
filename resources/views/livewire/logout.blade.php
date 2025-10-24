<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

new class extends Component {

    public function logout()
    {
        $user = Auth::user();

        if ($user) {
            // 🔹 Exemple : journaliser la déconnexion
            Log::info('Utilisateur déconnecté : ' . $user->email);
        }

        // Déconnexion
        Auth::guard('web')->logout();

        // Invalider et régénérer le token de session
        Session::invalidate();
        Session::regenerateToken();

        $this->redirectIntended(default: route('login', absolute: false));
    }
}; ?>

<div>
    <button wire:click="logout"
    class="w-full text-left px-4 py-2 rounded-lg  bg-gradient-to-br from-[#132c15] via-[#033806] to-[#05640b] hover:bg-green-700">
        Déconnexion
    </button>
</div>