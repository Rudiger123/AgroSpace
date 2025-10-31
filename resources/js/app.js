import './bootstrap';
import './echo';
import Alpine from 'alpinejs';
import Cropper from 'cropperjs';
import Swal from 'sweetalert2';
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
Alpine.start();

// Écouter sur un canal public
Echo.channel('chat.123')
    .listen('.message.sent', (e) => {
        console.log('📨 Nouveau message:', e);
        // Ajouter le message à l'interface
        addMessageToChat(e.message);
    });

// Écouter sur un canal privé
Echo.private('user.456')
    .listen('.message.sent', (e) => {
        console.log('📬 Message privé reçu:', e);
        showNotification('Nouveau message de ' + e.sender.name);
    });

// Présence (qui est en ligne)
Echo.join('online-users')
    .here((users) => {
        console.log('👥 Utilisateurs en ligne:', users);
    })
    .joining((user) => {
        console.log('✅ Connexion:', user.name);
    })
    .leaving((user) => {
        console.log('❌ Déconnexion:', user.name);
    });