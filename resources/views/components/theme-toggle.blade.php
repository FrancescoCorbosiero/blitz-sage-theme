@if(get_theme_mod('show_theme_toggle', true))
<button 
  class="theme-toggle fixed top-4 right-4 z-50 p-3 bg-white dark:bg-gray-800 rounded-full shadow-lg transition-all hover:scale-110"
  aria-label="{{ __('Toggle theme', 'blitz') }}"
  x-data="themeToggle"
  @click="toggleTheme"
>
  <svg x-show="theme === 'light'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
  </svg>
  <svg x-show="theme === 'dark'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
  </svg>
  <svg x-show="theme === 'auto'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
    <circle cx="12" cy="12" r="3" stroke-width="2"/>
  </svg>
</button>

<script>
document.addEventListener('alpine:init', () => {
  Alpine.data('themeToggle', () => ({
    theme: localStorage.getItem('blitz-theme-preference') || 'auto',
    
    init() {
      this.theme = window.themeManager?.getTheme() || this.theme;
    },
    
    toggleTheme() {
      const themes = ['light', 'dark', 'auto'];
      const current = themes.indexOf(this.theme);
      this.theme = themes[(current + 1) % themes.length];
      
      if (window.themeManager) {
        window.themeManager.setTheme(this.theme);
      } else {
        localStorage.setItem('blitz-theme-preference', this.theme);
        document.documentElement.dataset.theme = this.theme;
      }
    }
  }));
});
</script>
@endif