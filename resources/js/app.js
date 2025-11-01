import './bootstrap';
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