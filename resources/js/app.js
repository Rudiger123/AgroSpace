import './bootstrap';
import Alpine from 'alpinejs';
import Cropper from 'cropperjs';
import Swal from 'sweetalert2';
import persist from '@alpinejs/persist';

// Plugins Alpine
Alpine.plugin(persist);

// Configuration globale de SweetAlert2
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

// Assignation globale
window.Alpine = Alpine;
window.Swal = Swal;
window.Cropper = Cropper;
window.Toast = Toast;

// Écouteurs Livewire
document.addEventListener('livewire:initialized', () => {
    // Pour les toasts
    Livewire.on('toast', (data) => {
        console.log("Événement toast reçu :", data);

        const type = Array.isArray(data) ? data[0] ? .type : data.type;
        const message = Array.isArray(data) ? data[0] ? .message : data.message;

        Toast.fire({
            icon: type || 'info',
            title: message || 'Opération réussie'
        });
    });

    // Pour les alertes standard
    Livewire.on('alert', (data) => {
        console.log("Événement alert reçu :", data);

        const alertData = Array.isArray(data) ? data[0] : data;

        Swal.fire({
            title: alertData.title || 'Information',
            text: alertData.text || '',
            icon: alertData.icon || 'info',
            confirmButtonText: alertData.confirmText || 'OK',
            confirmButtonColor: '#22c55e'
        });
    });

    // Pour les confirmations
    Livewire.on('confirm', (data) => {
        console.log("Événement confirm reçu :", data);

        const confirmData = Array.isArray(data) ? data[0] : data;

        Swal.fire({
            title: confirmData.title || 'Êtes-vous sûr ?',
            text: confirmData.text || 'Cette action est irréversible.',
            icon: confirmData.icon || 'warning',
            showCancelButton: true,
            confirmButtonColor: '#22c55e',
            cancelButtonColor: '#ef4444',
            confirmButtonText: confirmData.confirmText || 'Oui, continuer',
            cancelButtonText: confirmData.cancelText || 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch(confirmData.callback || 'confirmed');
            }
        });
    });
});

// Gestion des erreurs Livewire
document.addEventListener('livewire:init', () => {
    Livewire.hook('request', ({ fail }) => {
        fail(({ status, content }) => {
            if (status === 500) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur serveur',
                    text: 'Une erreur est survenue. Veuillez réessayer.',
                    confirmButtonColor: '#22c55e'
                });
            }
        });
    });
});


// Dans votre layout principal ou dans un script spécifique
document.addEventListener('DOMContentLoaded', function() {
    // Écouter l'événement de confirmation de suppression
    Livewire.on('show-admin-delete-confirmation', (data) => {
        Swal.fire({
            title: 'Confirmer la suppression',
            html: `
        <div class="text-left">
            <p class="text-red-600 font-semibold mb-2">⚠️ Action irréversible !</p>
            <p class="mb-2">Vous êtes sur le point de supprimer l'utilisateur :</p>
            <div class="bg-gray-100 p-3 rounded-lg mb-3">
                <p><strong>Nom :</strong> ${data.userName}</p>
                <p><strong>Email :</strong> ${data.userEmail}</p>
            </div>
            <p class="text-sm text-gray-600">
                Toutes les données associées à cet utilisateur seront définitivement supprimées.
            </p>
        </div>
    `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer cet utilisateur',
            cancelButtonText: 'Annuler',
            reverseButtons: true,
            customClass: {
                popup: 'text-left'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Lancer la suppression via Livewire
                Livewire.dispatch('delete-user');
            }
        });
    });

    // Écouter les alertes Livewire pour les afficher avec SweetAlert
    Livewire.on('alert', (data) => {
        Swal.fire({
            title: data.title || 'Information',
            text: data.message,
            icon: data.type || 'info',
            confirmButtonText: 'OK',
            confirmButtonColor: data.type === 'error' ? '#d33' : '#3085d6'
        });
    });
});

// Initialisation Alpine
Alpine.start();

// Fonctions utilitaires globales
window.showSuccess = (message) => {
    Toast.fire({
        icon: 'success',
        title: message
    });
};

window.showError = (message) => {
    Toast.fire({
        icon: 'error',
        title: message
    });
};

window.showWarning = (message) => {
    Toast.fire({
        icon: 'warning',
        title: message
    });
};

window.showInfo = (message) => {
    Toast.fire({
        icon: 'info',
        title: message
    });
};

// Debug helper (à retirer en production)
window.debugAlpine = () => {
    console.log('Alpine store:', Alpine.store('sidebar'));
};