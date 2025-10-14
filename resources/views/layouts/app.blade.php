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

    {{-- Alpine.js initialization script --}}
    <script>
      // Add loading class immediately
      document.documentElement.classList.add('alpine-loading');
      
      // Remove loading class when Alpine is ready
      document.addEventListener('alpine:init', () => {
        // console.log('Alpine is initializing...');
      });
      
      document.addEventListener('alpine:initialized', () => {
        document.documentElement.classList.remove('alpine-loading');
        document.body.classList.add('alpine-ready');
        // console.log('Alpine is ready!');
      });
      
      // Fallback: Remove loading class after 1 second if Alpine fails
      setTimeout(() => {
        document.documentElement.classList.remove('alpine-loading');
      }, 1000);
    </script>

    <script>
      // Mark Alpine as ready
      document.addEventListener('alpine:initialized', () => {
        document.body.classList.add('alpine-ready');
      });
    </script>

    <style id="anti-flicker">
      /* Only hide elements with x-cloak attribute */
      [x-cloak] { 
        display: none !important; 
      }
      
      /* Hide elements ONLY before Alpine initializes */
      .alpine-loading [x-show] {
        display: none;
      }
      
      /* Specific modal/dialog hiding (using classes, not x-show) */
      .modal[aria-hidden="true"],
      .dialog[aria-hidden="true"] {
        display: none;
      }
      
      /* Toast notifications - class based */
      .toast:not(.toast--visible) {
        opacity: 0;
        transform: translateY(1rem);
      }
      
      /* Prevent layout shift during Alpine init */
      .alpine-loading {
        visibility: visible !important;
      }
      
      /* Optional: Add a very brief fade-in after Alpine loads */
      body.alpine-ready {
        animation: fadeIn 0.2s ease-out;
      }
      
      @keyframes fadeIn {
        from { opacity: 0.95; }
        to { opacity: 1; }
      }
    </style>
    
    {{-- Preconnect to external domains --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    {{-- PWA manifest --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    
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
      @include('components.theme-toggle')

      {{-- Main Content --}}
      <main id="main" class="site-main flex-grow">
        @yield('content')
      </main>

      {{-- Site Footer --}}
      @include('sections.footer.footer')      
      
      {{-- Global Components --}}
      @includeWhen(get_theme_mod('show_contact_button', true), 'components.contact-button', [
          'type' => 'whatsapp',
          'position' => 'bottom-right'
      ])
      @includeWhen(
        get_theme_mod('show_back_to_top', true), 
        'components.back-to-top',
        [
            'showAfter' => 500,           // Show after 500px scroll
            'position' => 'left',          // Position on left side
            'style' => 'rounded',          // Rounded square style
            'showProgress' => true,        // Show scroll progress
            'pulseAnimation' => false,     // Disable pulse effect
            'offsetBottom' => '3rem',      // Custom bottom offset
            'offsetSide' => '1.5rem',      // Custom side offset
            'tooltipText' => __('Scroll to top', 'blitz')
        ]
      )
      
    </div>

    @php(do_action('get_footer'))
    @php(wp_footer())
  </body>
</html>