import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// AOS (Animate On Scroll) initialization
import AOS from 'aos';
import 'aos/dist/aos.css';

// Initialize AOS when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,        // Animation duration in ms
        easing: 'ease-in-out', // Easing function
        once: true,           // Animation happens only once
        offset: 100,          // Offset from viewport
        delay: 0,             // Delay before animation starts
        mirror: false,        // Don't animate on scroll back
    });
});
