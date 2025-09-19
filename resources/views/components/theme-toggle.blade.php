{{-- resources/views/components/theme-toggle/theme-toggle.blade.php --}}

{{-- Usage: @include('components.theme-toggle.theme-toggle') --}}

@php
  $showToggle = get_theme_mod('show_theme_toggle', true);
  $defaultTheme = get_theme_mod('default_theme', 'auto');
  $position = $position ?? 'fixed'; // fixed, header, inline
  $size = $size ?? 'medium'; // small, medium, large
@endphp

@if($showToggle)
<button 
  id="theme-toggle-{{ uniqid() }}"
  class="theme-toggle theme-toggle--{{ $position }} theme-toggle--{{ $size }}"
  aria-label="{{ __('Toggle theme', 'blitz') }}"
  title="{{ __('Toggle theme (Light/Dark/Auto)', 'blitz') }}"
  x-data="themeToggle"
  @click="cycleTheme"
  :class="{ 'transitioning': transitioning }"
>
  <svg x-show="theme === 'light'" class="theme-toggle__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
  </svg>
  
  <svg x-show="theme === 'dark'" class="theme-toggle__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
  </svg>
  
  <svg x-show="theme === 'auto'" class="theme-toggle__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v8m4-4H8"/>
  </svg>
</button>

{{-- Toast Notification --}}
<div 
  x-data="{ show: false, message: '' }"
  x-show="show"
  x-transition
  @theme-changed.window="
    message = $event.detail.message;
    show = true;
    setTimeout(() => show = false, 3000);
  "
  class="theme-notification"
  x-cloak
>
  <span x-text="message"></span>
</div>
@endif

{{-- Inline Styles (Critical) --}}
<style>
  /* Theme Toggle Component - Minimal Critical CSS */
  .theme-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--card-bg);
    border: 2px solid var(--border-color);
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
    outline: none;
    -webkit-tap-highlight-color: transparent;
  }
  
  /* Position Variants */
  .theme-toggle--fixed {
    position: fixed;
    top: 50%;
    right: 2rem;
    transform: translateY(-50%);
    z-index: 90;
    box-shadow: 0 2px 8px var(--shadow);
  }
  
  .theme-toggle--header {
    position: relative;
  }
  
  .theme-toggle--inline {
    position: static;
  }
  
  /* Size Variants */
  .theme-toggle--small {
    width: 40px;
    height: 40px;
  }
  
  .theme-toggle--medium {
    width: 48px;
    height: 48px;
  }
  
  .theme-toggle--large {
    width: 56px;
    height: 56px;
  }
  
  /* Icon */
  .theme-toggle__icon {
    width: 60%;
    height: 60%;
    color: var(--text-primary);
    transition: transform 0.3s ease;
  }
  
  /* States */
  .theme-toggle:hover {
    background: var(--bg-secondary);
    border-color: var(--primary);
    transform: translateY(-50%) scale(1.08);
  }
  
  .theme-toggle--header:hover,
  .theme-toggle--inline:hover {
    transform: scale(1.08);
  }
  
  .theme-toggle:active {
    transform: translateY(-50%) scale(0.95);
  }
  
  .theme-toggle--header:active,
  .theme-toggle--inline:active {
    transform: scale(0.95);
  }
  
  .theme-toggle:focus-visible {
    outline: 2px solid var(--primary);
    outline-offset: 4px;
  }
  
  .theme-toggle.transitioning .theme-toggle__icon {
    animation: rotateIcon 0.5s ease;
  }
  
  @keyframes rotateIcon {
    0% { transform: rotate(0deg) scale(1); }
    50% { transform: rotate(180deg) scale(0.8); }
    100% { transform: rotate(360deg) scale(1); }
  }
  
  /* Notification */
  .theme-notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 12px 20px;
    background: var(--primary);
    color: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    font-size: 14px;
    pointer-events: none;
  }
  
  /* Mobile */
  @media (max-width: 768px) {
    .theme-toggle--fixed {
      right: 1rem;
    }
    
    .theme-notification {
      bottom: auto;
      top: 20px;
      left: 50%;
      right: auto;
      transform: translateX(-50%);
    }
  }
</style>

{{-- Inline Script (Alpine Component) --}}
<script>
document.addEventListener('alpine:init', () => {
  Alpine.data('themeToggle', () => ({
    theme: localStorage.getItem('blitz-theme-preference') || '{{ $defaultTheme }}',
    transitioning: false,
    
    init() {
      // Apply theme immediately
      this.applyTheme(this.theme);
      
      // Watch system preference
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (this.theme === 'auto') {
          this.applyTheme('auto');
        }
      });
      
      // Sync across tabs
      window.addEventListener('storage', (e) => {
        if (e.key === 'blitz-theme-preference') {
          this.theme = e.newValue || 'auto';
          this.applyTheme(this.theme);
        }
      });
    },
    
    applyTheme(theme) {
      const root = document.documentElement;
      
      if (theme === 'auto') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        root.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
      } else {
        root.setAttribute('data-theme', theme);
      }
      
      // Update meta theme-color
      const metaTheme = document.querySelector('meta[name="theme-color"]');
      if (metaTheme) {
        const colors = {
          light: '#ffffff',
          dark: '#1a1a1a',
          auto: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#1a1a1a' : '#ffffff'
        };
        metaTheme.content = colors[theme] || colors.light;
      }
    },
    
    cycleTheme() {
      const themes = ['light', 'dark', 'auto'];
      const currentIndex = themes.indexOf(this.theme);
      const nextTheme = themes[(currentIndex + 1) % themes.length];
      
      // Start transition
      this.transitioning = true;
      
      // Save and apply
      this.theme = nextTheme;
      localStorage.setItem('blitz-theme-preference', nextTheme);
      this.applyTheme(nextTheme);
      
      // Dispatch event for notification
      const messages = {
        light: '☀️ Light theme',
        dark: '🌙 Dark theme',
        auto: '🔄 Auto theme'
      };
      
      window.dispatchEvent(new CustomEvent('theme-changed', {
        detail: { 
          theme: nextTheme,
          message: messages[nextTheme]
        }
      }));
      
      // End transition
      setTimeout(() => {
        this.transitioning = false;
      }, 500);
    }
  }));
});
</script>