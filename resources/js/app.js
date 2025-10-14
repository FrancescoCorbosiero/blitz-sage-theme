// resources/js/app.js
const images = import.meta.glob('../images/**/*.{jpg,jpeg,png,PNG,svg,gif}', { eager: true });

// Import Alpine.js and plugins
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import intersect from '@alpinejs/intersect';

// Import vendor libraries
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import AOS from 'aos';
import 'aos/dist/aos.css';

// Core Features
import AccessibilityManager from './features/accessibility.js';

// Global setup
window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.plugin(intersect);
window.Swiper = Swiper;

// After DOM load setup
document.addEventListener('DOMContentLoaded', () => {
  // Initialize features
  window.accessibilityManager = new AccessibilityManager();

  // Initialize AOS with config
  AOS.init({
    duration: 800,
    once: true,
    offset: 100,
    easing: 'ease-out'
  });
  
  // Start Alpine - it will auto-detect x-data components
  Alpine.start();

  // Initialize all Swiper instances with proper config
  const swipers = document.querySelectorAll('.hero-carousel-swiper');
  swipers.forEach(element => {
    new Swiper(element, {
      // Core
      loop: true,
      speed: 1200,
      parallax: true,
      grabCursor: true,
      
      // Autoplay
      autoplay: {
        delay: 7000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      
      // Effects
      effect: 'fade',
      fadeEffect: {
        crossFade: true
      },
      
      // Navigation
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      
      // Pagination
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true,
      },
      
      // Keyboard
      keyboard: {
        enabled: true,
        onlyInViewport: true,
      },
      
      // Touch
      touchEventsTarget: 'wrapper',
      touchRatio: 1,
      touchAngle: 45,
      simulateTouch: true,
    });
  });
  
  // Remove loader
  const loader = document.querySelector('.loader-default');
  if (loader) {
    loader.classList.add('hidden');
    setTimeout(() => loader.remove(), 500);
  }
});

// Keep BlockUtils for shared utilities
window.BlockUtils = {
  animate(element, animation, duration = 1000) { /* ... */ },
  lazyLoad(selector) { /* ... */ },
  trackEvent(category, action, label) { /* ... */ },
  showToast(message, type) { /* ... */ },
  debounce(func, wait) { /* ... */ },
  throttle(func, limit) { /* ... */ }
};