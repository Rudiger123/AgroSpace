import './bootstrap';
import './seo-jsonld';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import persist from '@alpinejs/persist';
import { Picker } from 'emoji-mart'
import ApexCharts from 'apexcharts';

window.ApexCharts = ApexCharts;
window.EmojiMart = { Picker }

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: false,
    disableStats: true,
});

window.Echo.channel('notifications')
    .listen('NewOfferCreated', (e) => {
        // Jouer le son
        const audio = new Audio('/sounds/notification.mp3');
        audio.play();

        // Afficher la notification visuelle
        alert(`Nouvelle offre: ${e.offer.title}`);
    });


// Nous ne devons pas initialiser Alpine ici, Livewire le fera.
// Mais nous devons enregistrer le plugin lorsque Alpine est disponible.
// Livewire exposera Alpine via window.Alpine après son initialisation.

// Configuration SweetAlert2
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

window.Toast = Toast;

// Nous attendons que Livewire soit chargé pour enregistrer le plugin et initialiser nos événements.
document.addEventListener('livewire:load', () => {
    // Enregistrer le plugin persist avec Alpine
    window.Alpine.plugin(persist);

    // Initialiser les événements Livewire
    initLivewireEvents();
});

// Également, si Livewire est déjà chargé (par exemple dans les pages sans Livewire), nous devrions initialiser les événements.
if (window.Livewire) {
    document.addEventListener('livewire:load', initLivewireEvents);
}

function initLivewireEvents() {
    // Toasts
    Livewire.on('toast', (data) => {
        let toastData = data;
        if (Array.isArray(data)) {
            toastData = data[0] || {};
        }

        let type = toastData.type || 'info';
        let message = toastData.message || 'Opération réussie';

        Toast.fire({
            icon: type,
            title: message
        });
    });

    // Alertes classiques
    Livewire.on('alert', (data) => {
        let alertData = data;
        if (Array.isArray(data)) {
            alertData = data[0] || {};
        }

        Swal.fire({
            title: alertData.title || 'Information',
            text: alertData.text || '',
            icon: alertData.icon || 'info',
            confirmButtonText: alertData.confirmText || 'OK',
            confirmButtonColor: '#22c55e'
        });
    });

    // Confirmations
    // Dans votre app.js - assurez-vous que cette partie existe
    Livewire.on('confirm', function(data) {
        let confirmData = data;
        if (Array.isArray(data)) {
            confirmData = data[0] || {};
        }

        Swal.fire({
            title: confirmData.title || 'Êtes-vous sûr ?',
            text: confirmData.text || 'Cette action est irréversible.',
            icon: confirmData.icon || 'warning',
            showCancelButton: true,
            confirmButtonColor: '#22c55e',
            cancelButtonColor: '#ef4444',
            confirmButtonText: confirmData.confirmText || 'Oui, continuer',
            cancelButtonText: confirmData.cancelText || 'Annuler',
            reverseButtons: true
        }).then(function(result) {
            if (result.isConfirmed && confirmData.callback) {
                if (confirmData.params) {
                    Livewire.emit(confirmData.callback, confirmData.params);
                } else {
                    Livewire.emit(confirmData.callback);
                }
            }
        });
    });

    // Global SweetAlert2 configuration
    Swal.mixin({
        customClass: {
            popup: 'rounded-lg shadow-lg',
            confirmButton: 'bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200',
            cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-md transition duration-200'
        },
        buttonsStyling: false
    });
}