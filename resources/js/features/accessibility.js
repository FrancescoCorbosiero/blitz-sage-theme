// resources/js/features/accessibility.js

/**
 * Blitz Theme Accessibility Manager
 * Improves keyboard navigation, focus management, and screen reader support
 */

class FocusManager {
  constructor() {
    this.lastFocusedElement = null;
    this.focusTrap = null;
  }

  init() {
    // Track focus changes
    document.addEventListener('focusin', (e) => {
      this.lastFocusedElement = e.target;
    });

    // Improve focus visibility
    this.enhanceFocusVisibility();
    
    // Setup keyboard navigation
    this.setupKeyboardNavigation();
    
    // Initialize skip links
    this.initializeSkipLinks();
    
    // Setup modal focus trap
    this.setupModalFocusTrap();
    
    // Enhance form accessibility
    this.enhanceFormAccessibility();
  }

  enhanceFocusVisibility() {
    // Add focus-visible polyfill behavior
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Tab') {
        document.body.classList.add('keyboard-nav');
      }
    });

    document.addEventListener('mousedown', () => {
      document.body.classList.remove('keyboard-nav');
    });

    // Custom focus styles
    if (!document.getElementById('a11y-focus-styles')) {
      const style = document.createElement('style');
      style.id = 'a11y-focus-styles';
      style.textContent = `
        .keyboard-nav *:focus {
          outline: 3px solid var(--primary, #3b82f6);
          outline-offset: 2px;
        }
        
        .keyboard-nav button:focus,
        .keyboard-nav a:focus {
          outline-offset: 4px;
        }
        
        .skip-link:focus {
          position: fixed;
          top: 1rem;
          left: 1rem;
          z-index: 999999;
          padding: 0.75rem 1.5rem;
          background: var(--primary, #3b82f6);
          color: white;
          text-decoration: none;
          border-radius: 0.5rem;
          box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
      `;
      document.head.appendChild(style);
    }
  }

  setupKeyboardNavigation() {
    // Escape key to close modals/dropdowns
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        this.closeActiveOverlays();
      }
    });

    // Arrow key navigation for menus
    this.setupMenuKeyboardNav();
    
    // Tab trapping for modals
    this.setupTabTrapping();
  }

  setupMenuKeyboardNav() {
    const menus = document.querySelectorAll('[role="navigation"]');
    
    menus.forEach(menu => {
      const items = menu.querySelectorAll('a, button');
      
      menu.addEventListener('keydown', (e) => {
        const currentIndex = Array.from(items).indexOf(document.activeElement);
        
        switch(e.key) {
          case 'ArrowDown':
          case 'ArrowRight':
            e.preventDefault();
            const nextIndex = (currentIndex + 1) % items.length;
            items[nextIndex]?.focus();
            break;
            
          case 'ArrowUp':
          case 'ArrowLeft':
            e.preventDefault();
            const prevIndex = currentIndex <= 0 ? items.length - 1 : currentIndex - 1;
            items[prevIndex]?.focus();
            break;
            
          case 'Home':
            e.preventDefault();
            items[0]?.focus();
            break;
            
          case 'End':
            e.preventDefault();
            items[items.length - 1]?.focus();
            break;
        }
      });
    });
  }

  initializeSkipLinks() {
    const skipLinks = document.querySelectorAll('.skip-link');
    
    skipLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = link.getAttribute('href')?.substring(1);
        if (!targetId) return;
        
        const target = document.getElementById(targetId);
        if (target) {
          target.setAttribute('tabindex', '-1');
          target.focus();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });
  }

  setupModalFocusTrap() {
    // Observe for modals being added to DOM
    const observer = new MutationObserver((mutations) => {
      mutations.forEach((mutation) => {
        mutation.addedNodes.forEach((node) => {
          if (node.nodeType === 1 && (
            node.classList?.contains('modal') ||
            node.getAttribute?.('role') === 'dialog'
          )) {
            this.trapFocus(node);
          }
        });
      });
    });

    observer.observe(document.body, {
      childList: true,
      subtree: true
    });
  }

  trapFocus(element) {
    const focusableElements = element.querySelectorAll(
      'a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], select, [tabindex]:not([tabindex="-1"])'
    );
    
    const firstFocusable = focusableElements[0];
    const lastFocusable = focusableElements[focusableElements.length - 1];
    
    // Store current focus
    this.lastFocusedElement = document.activeElement;
    
    // Focus first element
    firstFocusable?.focus();
    
    // Trap focus
    const trapHandler = (e) => {
      if (e.key !== 'Tab') return;
      
      if (e.shiftKey) {
        if (document.activeElement === firstFocusable) {
          lastFocusable?.focus();
          e.preventDefault();
        }
      } else {
        if (document.activeElement === lastFocusable) {
          firstFocusable?.focus();
          e.preventDefault();
        }
      }
    };
    
    element.addEventListener('keydown', trapHandler);
    
    // Store trap handler for cleanup
    element._trapHandler = trapHandler;
  }

  releaseFocusTrap(element) {
    if (element._trapHandler) {
      element.removeEventListener('keydown', element._trapHandler);
      delete element._trapHandler;
    }
    
    // Restore focus
    this.lastFocusedElement?.focus();
  }

  setupTabTrapping() {
    // Handle dialogs and modals
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Tab') {
        const activeModal = document.querySelector('.modal.active, [role="dialog"][aria-hidden="false"]');
        if (activeModal && !activeModal.contains(document.activeElement)) {
          e.preventDefault();
          this.trapFocus(activeModal);
        }
      }
    });
  }

  closeActiveOverlays() {
    // Close dropdowns
    document.querySelectorAll('.dropdown.open').forEach(dropdown => {
      dropdown.classList.remove('open');
      dropdown.setAttribute('aria-expanded', 'false');
    });
    
    // Close modals
    document.querySelectorAll('.modal.active').forEach(modal => {
      modal.classList.remove('active');
      modal.setAttribute('aria-hidden', 'true');
      this.releaseFocusTrap(modal);
    });
  }

  enhanceFormAccessibility() {
    // Add aria-describedby for form errors
    document.querySelectorAll('.form-error').forEach(error => {
      const input = error.previousElementSibling;
      if (input && input.tagName === 'INPUT') {
        const errorId = 'error-' + Math.random().toString(36).substr(2, 9);
        error.id = errorId;
        input.setAttribute('aria-describedby', errorId);
        input.setAttribute('aria-invalid', 'true');
      }
    });
    
    // Add required aria attributes
    document.querySelectorAll('input[required], textarea[required], select[required]').forEach(field => {
      field.setAttribute('aria-required', 'true');
    });
    
    // Enhance labels
    document.querySelectorAll('label').forEach(label => {
      const forAttr = label.getAttribute('for');
      if (forAttr) {
        const field = document.getElementById(forAttr);
        if (field && field.hasAttribute('required')) {
          if (!label.querySelector('.required-indicator')) {
            const indicator = document.createElement('span');
            indicator.className = 'required-indicator';
            indicator.setAttribute('aria-label', 'required');
            indicator.textContent = ' *';
            label.appendChild(indicator);
          }
        }
      }
    });
  }
}

class LiveRegionManager {
  constructor() {
    this.regions = {};
  }

  init() {
    this.createLiveRegions();
    this.monitorAjaxContent();
  }

  createLiveRegions() {
    // Status messages
    if (!document.getElementById('a11y-status')) {
      const status = document.createElement('div');
      status.id = 'a11y-status';
      status.className = 'sr-only';
      status.setAttribute('role', 'status');
      status.setAttribute('aria-live', 'polite');
      status.setAttribute('aria-atomic', 'true');
      document.body.appendChild(status);
      this.regions.status = status;
    }
    
    // Alert messages
    if (!document.getElementById('a11y-alert')) {
      const alert = document.createElement('div');
      alert.id = 'a11y-alert';
      alert.className = 'sr-only';
      alert.setAttribute('role', 'alert');
      alert.setAttribute('aria-live', 'assertive');
      alert.setAttribute('aria-atomic', 'true');
      document.body.appendChild(alert);
      this.regions.alert = alert;
    }
  }

  announce(message, priority = 'polite') {
    const region = priority === 'assertive' 
      ? this.regions.alert || document.getElementById('a11y-alert')
      : this.regions.status || document.getElementById('a11y-status');
    
    if (region) {
      region.textContent = message;
      
      // Clear after announcement
      setTimeout(() => {
        region.textContent = '';
      }, 3000);
    }
  }

  monitorAjaxContent() {
    // Intercept fetch requests
    const originalFetch = window.fetch;
    window.fetch = async (...args) => {
      const response = await originalFetch(...args);
      
      // Announce loading states
      if (response.ok) {
        this.announce('Content updated');
      } else {
        this.announce('Error loading content', 'assertive');
      }
      
      return response;
    };
  }
}

class ResponsiveTables {
  init() {
    this.enhanceTables();
    this.addTableNavigation();
  }

  enhanceTables() {
    document.querySelectorAll('table').forEach(table => {
      // Add scope to headers
      table.querySelectorAll('th').forEach(th => {
        if (!th.hasAttribute('scope')) {
          const isRowHeader = th.parentElement.tagName === 'TR' && 
                             th.parentElement.firstElementChild === th;
          th.setAttribute('scope', isRowHeader ? 'row' : 'col');
        }
      });
      
      // Add caption if missing
      if (!table.querySelector('caption')) {
        const caption = document.createElement('caption');
        caption.className = 'sr-only';
        caption.textContent = 'Data table';
        table.insertBefore(caption, table.firstChild);
      }
      
      // Make responsive
      if (!table.parentElement.classList.contains('table-wrapper')) {
        const wrapper = document.createElement('div');
        wrapper.className = 'table-wrapper';
        wrapper.setAttribute('role', 'region');
        wrapper.setAttribute('aria-label', 'Scrollable table');
        wrapper.setAttribute('tabindex', '0');
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
      }
    });
  }

  addTableNavigation() {
    document.querySelectorAll('.table-wrapper').forEach(wrapper => {
      wrapper.addEventListener('keydown', (e) => {
        const scrollAmount = 50;
        
        switch(e.key) {
          case 'ArrowLeft':
            wrapper.scrollLeft -= scrollAmount;
            e.preventDefault();
            break;
          case 'ArrowRight':
            wrapper.scrollLeft += scrollAmount;
            e.preventDefault();
            break;
        }
      });
    });
  }
}

/**
 * Main Accessibility Manager
 */
class AccessibilityManager {
  constructor(options = {}) {
    this.config = {
      enableFocusManagement: true,
      enableLiveRegions: true,
      enableTableEnhancements: true,
      enablePageAnnouncements: true,
      ...options
    };
    
    this.focusManager = null;
    this.liveRegion = null;
    this.tables = null;
  }

  init() {
    // Add screen reader only styles
    this.addScreenReaderStyles();
    
    // Initialize sub-managers
    if (this.config.enableFocusManagement) {
      this.focusManager = new FocusManager();
      this.focusManager.init();
    }
    
    if (this.config.enableLiveRegions) {
      this.liveRegion = new LiveRegionManager();
      this.liveRegion.init();
    }
    
    if (this.config.enableTableEnhancements) {
      this.tables = new ResponsiveTables();
      this.tables.init();
    }
    
    if (this.config.enablePageAnnouncements) {
      this.setupPageChangeAnnouncements();
    }
    
    // Expose API
    this.exposeAPI();
  }

  addScreenReaderStyles() {
    if (!document.getElementById('a11y-sr-styles')) {
      const srStyles = document.createElement('style');
      srStyles.id = 'a11y-sr-styles';
      srStyles.textContent = `
        .sr-only {
          position: absolute;
          width: 1px;
          height: 1px;
          padding: 0;
          margin: -1px;
          overflow: hidden;
          clip: rect(0, 0, 0, 0);
          white-space: nowrap;
          border-width: 0;
        }
        
        .sr-only-focusable:focus {
          position: absolute;
          width: auto;
          height: auto;
          padding: 0.75rem 1.5rem;
          margin: 0;
          overflow: visible;
          clip: auto;
          white-space: normal;
          z-index: 999999;
        }
      `;
      document.head.appendChild(srStyles);
    }
  }

  setupPageChangeAnnouncements() {
    // Announce page changes for SPAs
    let lastLocation = location.href;
    const observer = new MutationObserver(() => {
      if (location.href !== lastLocation) {
        lastLocation = location.href;
        const pageTitle = document.title || 'New page';
        this.liveRegion?.announce(`Navigated to ${pageTitle}`);
      }
    });
    
    const titleElement = document.querySelector('title');
    if (titleElement) {
      observer.observe(titleElement, { childList: true });
    }
    
    // Also listen for custom navigation events
    window.addEventListener('navigation:complete', () => {
      const pageTitle = document.title || 'New page';
      this.liveRegion?.announce(`Navigated to ${pageTitle}`);
    });
  }

  exposeAPI() {
    // Expose managers for external use
    window.blitzA11y = {
      manager: this,
      focusManager: this.focusManager,
      liveRegion: this.liveRegion,
      tables: this.tables,
      
      // Convenience methods
      announce: (message, priority) => this.liveRegion?.announce(message, priority),
      trapFocus: (element) => this.focusManager?.trapFocus(element),
      releaseFocus: (element) => this.focusManager?.releaseFocusTrap(element)
    };
  }

  // Public API methods
  destroy() {
    // Clean up if needed
    document.body.classList.remove('keyboard-nav');
  }

  announce(message, priority = 'polite') {
    this.liveRegion?.announce(message, priority);
  }

  trapFocus(element) {
    this.focusManager?.trapFocus(element);
  }

  releaseFocus(element) {
    this.focusManager?.releaseFocusTrap(element);
  }
}

// Auto-initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
  window.accessibilityManager = new AccessibilityManager();
  window.accessibilityManager.init();
});

export default AccessibilityManager;