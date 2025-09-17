// resources/js/core/config.js

/**
 * Blitz Theme Configuration
 * Central configuration for all JavaScript features
 */

export const config = {
  // Theme settings
  theme: {
    defaultMode: 'auto', // light, dark, auto
    storageKey: 'blitz-theme-preference',
    enableToggle: true,
    syncAcrossTabs: true
  },
  
  // Navigation settings
  navigation: {
    enableSpeculation: true,
    enableViewTransitions: true,
    enablePrefetch: true,
    prefetchDelay: 2000,
    hoverDelay: 65,
    excludeSelectors: ['.no-prefetch', '.no-transition', '[download]'],
    highPrioritySelectors: ['.btn-primary', '.cta', '[data-priority="high"]']
  },
  
  // Performance settings
  performance: {
    enableServiceWorker: true,
    enableLazyLoading: true,
    enableWebVitals: true,
    lazyLoadOffset: '100px',
    imageObserverThreshold: 0.1
  },
  
  // Animation settings
  animations: {
    enableAOS: true,
    aosOptions: {
      duration: 800,
      once: true,
      offset: 100,
      delay: 0,
      easing: 'ease-out'
    }
  },
  
  // Form settings
  forms: {
    validateOnBlur: true,
    validateOnInput: false,
    showInlineErrors: true,
    submitDelay: 1000,
    honeypotField: 'blitz_honey'
  },
  
  // Analytics settings
  analytics: {
    enabled: true,
    trackWebVitals: true,
    trackErrors: false,
    debugMode: false
  },
  
  // API settings
  api: {
    baseUrl: window.blitzConfig?.homeUrl || '/',
    timeout: 30000,
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  },
  
  // Feature flags
  features: {
    darkMode: true,
    smoothScroll: true,
    stickyHeader: true,
    backToTop: true,
    cookieConsent: false,
    search: true,
    notifications: true
  }
};

// Helper to get config value
export function getConfig(path, defaultValue = null) {
  const keys = path.split('.');
  let value = config;
  
  for (const key of keys) {
    if (value && typeof value === 'object' && key in value) {
      value = value[key];
    } else {
      return defaultValue;
    }
  }
  
  return value;
}

// Helper to update config value
export function setConfig(path, value) {
  const keys = path.split('.');
  const lastKey = keys.pop();
  let target = config;
  
  for (const key of keys) {
    if (!(key in target) || typeof target[key] !== 'object') {
      target[key] = {};
    }
    target = target[key];
  }
  
  target[lastKey] = value;
}

// Merge with WordPress config if available
if (window.blitzConfig) {
  Object.assign(config.api, {
    ajaxUrl: window.blitzConfig.ajaxUrl,
    nonce: window.blitzConfig.nonce
  });
  
  if (window.blitzConfig.features) {
    Object.assign(config.features, window.blitzConfig.features);
  }
}

export default config;