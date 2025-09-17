// resources/js/app.js

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import intersect from '@alpinejs/intersect';

// Core Features
import NavigationEnhancer from './features/navigation-enhancement.js';
import ThemeManager from './features/theme-manager.js';
import { ComponentRegistry } from './core/component-registry.js';
import AccessibilityManager from './features/accessibility.js';

// Initialize Alpine globally
window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.plugin(intersect);

// Register reusable Alpine components
ComponentRegistry.registerAll(Alpine);

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
  // Initialize core features
  window.navigationEnhancer = new NavigationEnhancer();
  window.themeManager = new ThemeManager();
  window.accessibilityManager = new AccessibilityManager();
  window.accessibilityManager.init();
  
  // Start Alpine
  Alpine.start();
  
  // Initialize blocks after Alpine
  initializeBlocks();
  
  // Remove loading screen if exists
  const loader = document.querySelector('.loader-default');
  if (loader) {
    loader.classList.add('hidden');
    setTimeout(() => loader.remove(), 500);
  }
});

// Initialize block-specific JavaScript
function initializeBlocks() {
  // Dispatch ready event
  window.dispatchEvent(new CustomEvent('blocks:ready'));
  
  // Auto-initialize blocks with data attributes
  document.querySelectorAll('[data-block-init]').forEach(block => {
    const initFunction = block.dataset.blockInit;
    if (typeof window[initFunction] === 'function') {
      window[initFunction](block);
    }
  });
  
  // Initialize AOS if present
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 800,
      once: true,
      offset: 100
    });
  }
  
  // Initialize GLightbox if present
  if (typeof GLightbox !== 'undefined') {
    GLightbox({
      selector: '.glightbox',
      touchNavigation: true,
      loop: true,
      autoplayVideos: true
    });
  }
}

// Global utilities for blocks
const BlockUtils = {
  // Animation helper
  animate(element, animation, duration = 1000) {
    element.classList.add(`animate-${animation}`);
    setTimeout(() => {
      element.classList.remove(`animate-${animation}`);
    }, duration);
  },
  
  // Lazy loading helper
  lazyLoad(selector) {
    const elements = document.querySelectorAll(selector);
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src;
          img.classList.remove('lazy');
          imageObserver.unobserve(img);
        }
      });
    });
    
    elements.forEach(img => imageObserver.observe(img));
  },
  
  // Analytics helper
  trackEvent(category, action, label, value) {
    if (typeof gtag !== 'undefined') {
      gtag('event', action, {
        event_category: category,
        event_label: label,
        value: value
      });
    }
    
    // Also trigger custom event
    window.dispatchEvent(new CustomEvent('analytics:track', {
      detail: { category, action, label, value }
    }));
  },
  
  // Toast notification helper
  showToast(message, type = 'info', duration = 3000) {
    // Use Alpine toast if available
    if (window.Alpine && Alpine.$data && Alpine.$data.toast) {
      Alpine.$data.toast.add(message, type);
    } else {
      // Fallback implementation
      const toast = document.createElement('div');
      toast.className = `toast toast-${type}`;
      toast.textContent = message;
      toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 16px 24px;
        background: var(--${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'});
        color: white;
        border-radius: 8px;
        z-index: 9999;
        animation: slideIn 0.3s ease-out;
      `;
      
      document.body.appendChild(toast);
      
      setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => toast.remove(), 300);
      }, duration);
    }
  },
  
  // Debounce helper
  debounce(func, wait = 250) {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  },
  
  // Throttle helper
  throttle(func, limit = 250) {
    let inThrottle;
    return function(...args) {
      if (!inThrottle) {
        func.apply(this, args);
        inThrottle = true;
        setTimeout(() => inThrottle = false, limit);
      }
    };
  }
};

// Make available globally
window.BlockUtils = BlockUtils;

// Handle view transitions on navigation
if (document.startViewTransition) {
  window.addEventListener('navigation:complete', () => {
    // Reinitialize components after navigation
    initializeBlocks();
    
    // Re-run Alpine
    if (window.Alpine) {
      Alpine.initTree(document.querySelector('main'));
    }
  });
}

// Service Worker registration
if ('serviceWorker' in navigator && window.location.protocol === 'https:') {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js')
      .then(registration => {
        console.log('ServiceWorker registered:', registration);
        
        // Check for updates periodically
        setInterval(() => {
          registration.update();
        }, 60000); // Check every minute
      })
      .catch(error => {
        console.log('ServiceWorker registration failed:', error);
      });
  });
}

// Handle WordPress admin bar with view transitions
if (document.body.classList.contains('admin-bar')) {
  document.documentElement.style.setProperty('--admin-bar-height', '32px');
  
  // Adjust for mobile
  if (window.innerWidth < 783) {
    document.documentElement.style.setProperty('--admin-bar-height', '46px');
  }
}

// Export for use in other modules
export { Alpine, BlockUtils };