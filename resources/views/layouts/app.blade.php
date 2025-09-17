<!doctype html>
<html {!! language_attributes() !!}>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- Theme detection before any CSS --}}
    <script>
      (function() {
        const defaultTheme = '{{ get_theme_mod('default_theme', 'auto') }}';
        const savedTheme = localStorage.getItem('blitz-theme-preference');
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        let theme = savedTheme || defaultTheme;
        if (theme === 'auto') {
          theme = systemPrefersDark ? 'dark' : 'light';
        }
        
        document.documentElement.setAttribute('data-theme', theme);
        document.documentElement.classList.add('theme-' + theme, 'theme-loaded');
      })();
    </script>
    
    {{-- Critical CSS to prevent FOUC --}}
    <style>
      html:not(.theme-loaded) { visibility: hidden; opacity: 0; }
      html.theme-loaded { visibility: visible; opacity: 1; transition: opacity 0.3s; }
    </style>
    
    {{-- Preconnect to external domains --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    {{-- PWA manifest --}}
    <link rel="manifest" href="{{ get_template_directory_uri() }}/public/manifest.json">
    
    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ get_template_directory_uri() }}/public/images/favicon.svg">
    <link rel="apple-touch-icon" href="{{ get_template_directory_uri() }}/public/images/apple-touch-icon.png">
    
    {{-- WordPress head --}}
    @php(do_action('get_header'))
    @php(wp_head())
  </head>

  <body @php(body_class())>
    @php(wp_body_open())

    {{-- Skip links for accessibility --}}
    <a class="skip-link screen-reader-text" href="#main">
      {{ __('Skip to content', 'blitz') }}
    </a>

    <div id="app" class="site min-h-screen flex flex-col">
      
      {{-- Site Header --}}
      @include('sections.header.header')

      {{-- Main Content --}}
      <main id="main" class="site-main flex-grow">
        @yield('content')
      </main>

      {{-- Site Footer --}}
      @include('sections.footer.footer')
      
      {{-- Global Components --}}
      @includeWhen(get_theme_mod('show_whatsapp_button', true), 'components.contact-button')
      
      @if(get_theme_mod('show_theme_toggle', true))
        <button class="theme-toggle" aria-label="{{ __('Toggle theme', 'blitz') }}">
          {{-- Icon injected by JS --}}
        </button>
      @endif
      
      {{-- Back to Top --}}
      <button 
        id="back-to-top" 
        class="back-to-top"
        aria-label="{{ __('Back to top', 'blitz') }}"
        style="display: none;"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
      </button>
    </div>

    {{-- Loading Screen --}}
    <div class="loader-default" aria-hidden="true">
      <div class="loader-dots">
        <span></span><span></span><span></span>
      </div>
    </div>

    @php(do_action('get_footer'))
    @php(wp_footer())
    
    {{-- Initialize back to top --}}
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const backToTop = document.getElementById('back-to-top');
        if (backToTop) {
          window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
              backToTop.style.display = 'block';
            } else {
              backToTop.style.display = 'none';
            }
          }, { passive: true });
          
          backToTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
          });
        }
      });
    </script>
  </body>
</html>