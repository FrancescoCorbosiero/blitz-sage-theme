// resources/js/app.js
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import intersect from '@alpinejs/intersect';

// Core Features only
import NavigationEnhancer from './features/navigation-enhancement.js';
import ThemeManager from './features/theme-manager.js';
import AccessibilityManager from './features/accessibility.js';

// NO MORE ComponentRegistry!

window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.plugin(intersect);

document.addEventListener('DOMContentLoaded', () => {
  // Initialize features
  window.navigationEnhancer = new NavigationEnhancer();
  window.themeManager = new ThemeManager();
  window.accessibilityManager = new AccessibilityManager();
  
  // Start Alpine - it will auto-detect x-data components
  Alpine.start();
  
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