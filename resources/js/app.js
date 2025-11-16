import './bootstrap';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import persist from '@alpinejs/persist';
import { Picker } from 'emoji-mart'
window.EmojiMart = { Picker }


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
}