// resources/js/features/theme-manager.js

class ThemeManager {
  constructor() {
    this.themeKey = 'blitz-theme-preference';
    this.currentTheme = this.getSavedTheme() || 'auto';
    this.init();
  }

  init() {
    // Apply saved theme immediately
    this.applyTheme(this.currentTheme);
    
    // Setup theme toggle button
    this.setupToggleButton();
    
    // Listen for system theme changes
    this.watchSystemPreference();
    
    // Listen for storage events (sync across tabs)
    this.syncAcrossTabs();
  }

  getSavedTheme() {
    return localStorage.getItem(this.themeKey);
  }

  saveTheme(theme) {
    localStorage.setItem(this.themeKey, theme);
    this.currentTheme = theme;
  }

  applyTheme(theme) {
    const root = document.documentElement;
    
    if (theme === 'auto') {
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      root.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
    } else {
      root.setAttribute('data-theme', theme);
    }
    
    // Update meta theme-color
    this.updateMetaThemeColor(theme);
    
    // Dispatch custom event
    window.dispatchEvent(new CustomEvent('theme:changed', { 
      detail: { theme } 
    }));
  }

  updateMetaThemeColor(theme) {
    const colors = {
      light: '#faf7f2',
      dark: '#0f1419',
      auto: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#0f1419' : '#faf7f2'
    };
    
    let metaThemeColor = document.querySelector('meta[name="theme-color"]');
    if (!metaThemeColor) {
      metaThemeColor = document.createElement('meta');
      metaThemeColor.name = 'theme-color';
      document.head.appendChild(metaThemeColor);
    }
    
    metaThemeColor.content = colors[theme] || colors.light;
  }

  setupToggleButton() {
    // Create toggle button if it doesn't exist
    if (!document.querySelector('.theme-toggle')) {
      this.createToggleButton();
    }
    
    // Handle all theme toggle buttons
    document.addEventListener('click', (e) => {
      if (e.target.closest('.theme-toggle, [data-theme-toggle]')) {
        e.preventDefault();
        this.cycleTheme();
      }
    });
  }

  createToggleButton() {
    const button = document.createElement('button');
    button.className = 'theme-toggle';
    button.setAttribute('aria-label', 'Toggle theme');
    button.setAttribute('title', 'Toggle theme (Light/Dark/Auto)');
    button.innerHTML = this.getToggleIcon();
    
    document.body.appendChild(button);
  }

  getToggleIcon() {
    const icons = {
      light: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
      </svg>`,
      dark: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
      </svg>`,
      auto: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v8m4-4H8"/>
      </svg>`
    };
    
    return icons[this.currentTheme] || icons.auto;
  }

  cycleTheme() {
    const themes = ['light', 'dark', 'auto'];
    const currentIndex = themes.indexOf(this.currentTheme);
    const nextTheme = themes[(currentIndex + 1) % themes.length];
    
    this.saveTheme(nextTheme);
    this.applyTheme(nextTheme);
    
    // Update toggle button icon
    const toggleButtons = document.querySelectorAll('.theme-toggle, [data-theme-toggle]');
    toggleButtons.forEach(button => {
      button.innerHTML = this.getToggleIcon();
    });
    
    // Show toast notification
    this.showThemeToast(nextTheme);
  }

  showThemeToast(theme) {
    const messages = {
      light: 'Light theme activated ☀️',
      dark: 'Dark theme activated 🌙',
      auto: 'Auto theme activated 🔄'
    };
    
    // Create simple notification without external dependencies
    this.showNotification(messages[theme]);
  }

  showNotification(message) {
    // Check if global notification exists, otherwise use internal method
    if (typeof window.showNotification === 'function') {
      window.showNotification(message, 'info');
    } else {
      // Fallback: Create simple notification
      const notification = document.createElement('div');
      notification.className = 'theme-notification';
      notification.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 12px 20px;
        background: var(--primary);
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideIn 0.3s ease-out;
        font-size: 14px;
      `;
      notification.textContent = message;
      
      // Add animation
      const style = document.createElement('style');
      style.textContent = `
        @keyframes slideIn {
          from {
            transform: translateX(100%);
            opacity: 0;
          }
          to {
            transform: translateX(0);
            opacity: 1;
          }
        }
        @keyframes slideOut {
          from {
            transform: translateX(0);
            opacity: 1;
          }
          to {
            transform: translateX(100%);
            opacity: 0;
          }
        }
      `;
      
      if (!document.querySelector('style[data-theme-animations]')) {
        style.setAttribute('data-theme-animations', '');
        document.head.appendChild(style);
      }
      
      document.body.appendChild(notification);
      
      // Auto remove
      setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
      }, 3000);
    }
  }

  watchSystemPreference() {
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    
    mediaQuery.addEventListener('change', (e) => {
      if (this.currentTheme === 'auto') {
        this.applyTheme('auto');
      }
    });
  }

  syncAcrossTabs() {
    window.addEventListener('storage', (e) => {
      if (e.key === this.themeKey && e.newValue) {
        this.currentTheme = e.newValue;
        this.applyTheme(e.newValue);
        
        // Update toggle buttons
        const toggleButtons = document.querySelectorAll('.theme-toggle, [data-theme-toggle]');
        toggleButtons.forEach(button => {
          button.innerHTML = this.getToggleIcon();
        });
      }
    });
  }

  // Public API methods
  setTheme(theme) {
    if (['light', 'dark', 'auto'].includes(theme)) {
      this.saveTheme(theme);
      this.applyTheme(theme);
    }
  }

  getTheme() {
    return this.currentTheme;
  }

  getEffectiveTheme() {
    if (this.currentTheme === 'auto') {
      return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }
    return this.currentTheme;
  }

  // Check if dark mode is active
  isDark() {
    return this.getEffectiveTheme() === 'dark';
  }

  // Check if light mode is active
  isLight() {
    return this.getEffectiveTheme() === 'light';
  }
}

export default ThemeManager;