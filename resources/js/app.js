import './bootstrap';
import './seo-jsonld';
// import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import persist from '@alpinejs/persist';
import { Picker } from 'emoji-mart';
window.EmojiMart = { Picker };

import ApexCharts from 'apexcharts';
window.ApexCharts = ApexCharts;

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
});

document.addEventListener('livewire:init', () => {
    Livewire.on('openShareWindow', ({ url }) => {
        if (!url) return;
        window.open(url, '_blank', 'noopener,noreferrer');
    });
});;