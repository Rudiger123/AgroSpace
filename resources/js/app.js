import './bootstrap';
import Alpine from 'alpinejs';
import Cropper from 'cropperjs';
import Swal from 'sweetalert2';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Swal = Swal;

document.addEventListener('livewire:initialized', () => {
    Livewire.on('toast', (data) => {
        console.log("Événement reçu :", data);
        Swal.fire({
            icon: data.type,
            title: data.message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

    });
});

// Rendre Cropper disponible globalement
window.Cropper = Cropper;

window.Alpine = Alpine;
Alpine.start(); // resources/js/app.js

window.Pusher = Pusher;

/**
 * Configuration Laravel Echo avec Reverb
 */
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: (
        import.meta.env.VITE_REVERB_SCHEME) === 'https ',
    enabledTransports: ['ws', 'wss'],
    disableStats: true,
});

/**
 * Authentification pour canaux privés
 * Laravel Reverb utilise /broadcasting/auth par défaut
 */
window.Echo.connector.pusher.config.authEndpoint = '/broadcasting/auth';

/**
 * Écouter les événements globaux
 */
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer l'ID utilisateur depuis le DOM
    const userId = document.querySelector('meta[name="user-id"]');

    if (userId) {
        // Écouter les notifications personnelles
        window.Echo.private(`notifications.${userId}`)
            .listen('.notification.created', (e) => {
                console.log('Notification reçue:', e);

                // Dispatcher événement Livewire
                Livewire.dispatch('notificationReceived', e);

                // Afficher toast
                showToast(e.title, e.message, e.type);
            });

        // Marquer l'utilisateur comme en ligne
        markUserOnline();

        // Heartbeat toutes les 30 secondes
        setInterval(markUserOnline, 30000);
    }
});

/**
 * Marquer l'utilisateur comme en ligne
 */
function markUserOnline() {
    fetch('/api/user/online', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    }).catch(() => {
        // Ignorer les erreurs de heartbeat
    });
}

/**
 * Afficher un toast de notification
 */
function showToast(title, message, type = 'info') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500',
    };

    const toast = document.createElement('div');
    toast.className = `${colors[type] || colors.info} text-white px-6 py-4 rounded-lg shadow-lg max-w-md transform transition-all duration-300 translate-x-0`;
    toast.innerHTML = `
        <div class="flex items-start gap-3">
            <div class="flex-1">
                <p class="font-semibold">${title}</p>
                <p class="text-sm mt-1">${message}</p>
            </div>
            <button onclick="this.closest('div').remove()" class="text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    `;

    container.appendChild(toast);

    // Animation d'entrée
    setTimeout(() => toast.classList.add('translate-x-0'), 10);

    // Auto-suppression après 5 secondes
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-x-full');
        setTimeout(() => toast.remove(), 300);
    }, 5000);

    // Jouer son de notification
    playNotificationSound();
}

/**
 * Jouer un son de notification
 */
function playNotificationSound() {
    const audio = new Audio('/sounds/notification.mp3');
    audio.volume = 0.3;
    audio.play().catch(() => {
        // Ignorer si autoplay bloqué
    });
}

/**
 * Exposer les fonctions globalement
 */
window.showToast = showToast;

/**
 * Configuration Echo pour les pages de chat
 */
window.initializeChatEcho = function(conversationId) {
    // Quitter les canaux précédents
    window.Echo.leaveAllChannels();

    // Écouter le canal privé de la conversation
    window.Echo.private(`chat.${conversationId}`)
        .listen('.message.sent', (e) => {
            console.log('Message reçu:', e);
            Livewire.dispatch('messageReceived', { message: e.message });
        })
        .listen('.user.typing', (e) => {
            console.log('User typing:', e);
            Livewire.dispatch('userTyping', {
                user_id: e.user_id,
                user_name: e.user_name
            });
        })
        .listen('.message.read', (e) => {
            console.log('Message read:', e);
            Livewire.dispatch('messageRead', {
                message_id: e.message_id,
                user_id: e.user_id
            });
        });

    // Écouter le canal de présence (optionnel)
    window.Echo.join(`conversation.${conversationId}`)
        .here((users) => {
            console.log('Users currently online:', users);
            Livewire.dispatch('usersOnline', { users });
        })
        .joining((user) => {
            console.log('User joined:', user);
            showToast('Utilisateur connecté', `${user.name} vient de se connecter`, 'info');
        })
        .leaving((user) => {
            console.log('User left:', user);
        });
};

/**
 * Throttle pour événement typing
 */
let typingTimeout;
window.emitTyping = function(conversationId) {
    clearTimeout(typingTimeout);
    typingTimeout = setTimeout(() => {
        Livewire.dispatch('typing');
    }, 300); // Throttle à 300ms
};