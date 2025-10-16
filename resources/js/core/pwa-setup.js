/**
 * PWA Setup & Management
 * Handles service worker registration and PWA functionality
 */

class PWAManager {
  constructor() {
    this.registration = null;
    this.updateAvailable = false;
  }

  /**
   * Initialize PWA
   */
  async init() {
    if (!('serviceWorker' in navigator)) {
      console.log('❌ Service Workers not supported');
      return;
    }

    // Check if enabled in config
    const enabled = window.blitzConfig?.features?.serviceWorker ?? true;
    if (!enabled) {
      console.log('⚠️ Service Worker disabled in settings');
      return;
    }

    try {
      await this.registerServiceWorker();
      this.setupUpdateListener();
      this.setupInstallPrompt();
      this.checkForUpdates();
    } catch (error) {
      console.error('PWA initialization failed:', error);
    }
  }

  /**
   * Register service worker
   */
  async registerServiceWorker() {
    try {
      const registration = await navigator.serviceWorker.register('/sw.js', {
        scope: '/'
      });

      this.registration = registration;
      console.log('✅ Service Worker registered:', registration.scope);

      // Check for updates on load
      registration.update();

      return registration;
    } catch (error) {
      console.error('Service Worker registration failed:', error);
      throw error;
    }
  }

  /**
   * Setup update listener
   */
  setupUpdateListener() {
    if (!this.registration) return;

    this.registration.addEventListener('updatefound', () => {
      const newWorker = this.registration.installing;
      
      newWorker.addEventListener('statechange', () => {
        if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
          this.updateAvailable = true;
          this.showUpdateNotification();
        }
      });
    });

    // Listen for controller change
    navigator.serviceWorker.addEventListener('controllerchange', () => {
      console.log('🔄 New service worker activated');
      window.location.reload();
    });
  }

  /**
   * Show update notification
   */
  showUpdateNotification() {
    // Use toast notification if available
    if (window.BlockUtils?.showToast) {
      window.BlockUtils.showToast(
        'A new version is available! Click to update.',
        'info',
        {
          duration: 0, // Don't auto-dismiss
          action: {
            label: 'Update',
            callback: () => this.applyUpdate()
          }
        }
      );
    } else {
      // Fallback to confirm dialog
      if (confirm('A new version is available! Would you like to update now?')) {
        this.applyUpdate();
      }
    }
  }

  /**
   * Apply service worker update
   */
  async applyUpdate() {
    if (!this.registration?.waiting) return;

    // Tell the waiting service worker to activate
    this.registration.waiting.postMessage({ type: 'SKIP_WAITING' });
  }

  /**
   * Check for updates periodically
   */
  checkForUpdates() {
    if (!this.registration) return;

    // Check every hour
    setInterval(() => {
      this.registration.update();
      console.log('🔍 Checking for service worker updates...');
    }, 60 * 60 * 1000);
  }

  /**
   * Setup install prompt for PWA
   */
  setupInstallPrompt() {
    let deferredPrompt;

    window.addEventListener('beforeinstallprompt', (e) => {
      // Prevent default install prompt
      e.preventDefault();
      deferredPrompt = e;

      // Show custom install button
      this.showInstallButton(deferredPrompt);
    });

    window.addEventListener('appinstalled', () => {
      console.log('✅ PWA installed successfully');
      deferredPrompt = null;
      
      // Track installation
      if (window.BlockUtils?.trackEvent) {
        window.BlockUtils.trackEvent('PWA', 'installed', 'success');
      }
    });
  }

  /**
   * Show custom install button
   */
  showInstallButton(deferredPrompt) {
    // Check if install button exists in DOM
    const installBtn = document.querySelector('[data-pwa-install]');
    
    if (installBtn) {
      installBtn.style.display = 'block';
      
      installBtn.addEventListener('click', async () => {
        if (!deferredPrompt) return;

        // Show install prompt
        deferredPrompt.prompt();

        // Wait for user response
        const { outcome } = await deferredPrompt.userChoice;
        console.log(`PWA install: ${outcome}`);

        // Track user choice
        if (window.BlockUtils?.trackEvent) {
          window.BlockUtils.trackEvent('PWA', 'install-prompt', outcome);
        }

        // Clear prompt
        deferredPrompt = null;
        installBtn.style.display = 'none';
      });
    }
  }

  /**
   * Clear all caches (admin only)
   */
  async clearAllCaches() {
    if (!('caches' in window)) return;

    try {
      const cacheNames = await caches.keys();
      await Promise.all(cacheNames.map(name => caches.delete(name)));
      
      console.log('✅ All caches cleared');
      
      // Unregister service worker
      if (this.registration) {
        await this.registration.unregister();
        console.log('✅ Service worker unregistered');
      }

      return true;
    } catch (error) {
      console.error('Error clearing caches:', error);
      return false;
    }
  }

  /**
   * Get cache statistics
   */
  async getCacheStats() {
    if (!('caches' in window)) return null;

    try {
      const cacheNames = await caches.keys();
      const stats = [];

      for (const name of cacheNames) {
        const cache = await caches.open(name);
        const keys = await cache.keys();
        
        stats.push({
          name,
          entries: keys.length,
          urls: keys.map(req => req.url)
        });
      }

      return stats;
    } catch (error) {
      console.error('Error getting cache stats:', error);
      return null;
    }
  }
}

// Export singleton instance
const pwaManager = new PWAManager();

// Auto-initialize on load
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => pwaManager.init());
} else {
  pwaManager.init();
}

// Expose globally for admin/debugging
window.PWA = pwaManager;

export default pwaManager;