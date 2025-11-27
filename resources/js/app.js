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