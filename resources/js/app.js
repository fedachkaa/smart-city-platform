import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const msg = document.getElementById('success-message');
    if (msg) {
        setTimeout(() => {
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 500);
        }, 4000);
    }
});