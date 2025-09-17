<!doctype html>
<html {!! language_attributes() !!} data-theme="{{ get_theme_mod('default_theme', 'auto') }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  {{-- Early theme setup to prevent FOUC --}}
  <script>
    (function() {
      const saved = localStorage.getItem('blitz-theme-preference');
      const theme = saved || '{{ get_theme_mod('default_theme', 'auto') }}';
      
      if (theme === 'auto') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.documentElement.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
      } else {
        document.documentElement.setAttribute('data-theme', theme);
      }
      
      // Add loading class for transitions
      document.documentElement.classList.add('is-loading');
    })();
  </script>
  
  {{-- Critical inline CSS for above-the-fold --}}
  <style>
    /* Critical CSS - prevents layout shift */
    :root {
      --header-height: 80px;
      --admin-bar-height: 0px;
    }
    
    body.admin-bar {
      --admin-bar-height: 32px;
    }
    
    @media (max-width: 782px) {
      body.admin-bar {
        --admin-bar-height: 46px;
      }
    }
    
    .is-loading * {
      animation-play-state: paused !important;
    }
    
    /* Skeleton loader styles */
    .skeleton {
      background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
      background-size: 200% 100%;
      animation: skeleton-loading 1.5s infinite;
    }
    
    @keyframes skeleton-loading {
      0% { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }
    
    @media (prefers-color-scheme: dark) {
      [data-theme="auto"] .skeleton {
        background: linear-gradient(90deg, #2a2a2a 25%, #3a3a3a 50%, #2a2a2a 75%);
      }
    }
  </style>
  
  @php(wp_head())
  
  {{-- PWA manifest --}}
  <link rel="manifest" href="{{ get_theme_file_uri('manifest.json') }}">
  <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
  <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)">
</head>

<body @php(body_class())>
  {{-- Skip links for accessibility --}}
  <a class="skip-link screen-reader-text" href="#main">{{ __('Skip to content', 'blitz') }}</a>
  <a class="skip-link screen-reader-text" href="#footer">{{ __('Skip to footer', 'blitz') }}</a>
  
  {{-- Loading overlay (removed after load) --}}
  <div class="loader-default" aria-hidden="true">
    <div class="loader-spinner"></div>
  </div>
  
  {{-- App wrapper with proper semantic structure --}}
  <div id="app" class="app-wrapper">
    {{-- Header --}}
    @include('sections.header.header')
    
    {{-- Main content area --}}
    <main id="main" class="main-content" role="main">
      {{-- Page transition wrapper --}}
      <div class="page-transition-wrapper">
        @yield('content')
      </div>
    </main>
    
    {{-- Footer --}}
    @include('sections.footer.footer')
    
    {{-- Global components --}}
    @include('components.contact-button')
    @include('partials.toast.toast')
    @include('partials.modal.modal')
    
    {{-- Back to top button --}}
    <button 
      id="back-to-top" 
      class="back-to-top"
      aria-label="{{ __('Back to top', 'blitz') }}"
      x-data="{ show: false }"
      x-on:scroll.window="show = window.pageYOffset > 300"
      x-show="show"
      x-transition
      @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
    >
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
      </svg>
    </button>
    
    {{-- Cookie consent (if enabled) --}}
    @if(get_theme_mod('show_cookie_consent', false))
      @include('components.cookie-consent')
    @endif
  </div>
  
  {{-- Notification container for Alpine --}}
  <div id="notification-container" class="fixed top-20 right-4 z-50 pointer-events-none">
    <template x-for="notification in $store.notifications.items" :key="notification.id">
      <div 
        class="notification pointer-events-auto"
        x-show="notification.show"
        x-transition
      >
        <div x-text="notification.message"></div>
      </div>
    </template>
  </div>
  
  {{-- Analytics & tracking (non-blocking) --}}
  @if($ga_id = get_theme_mod('google_analytics_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga_id }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $ga_id }}', {
        'anonymize_ip': true,
        'cookie_flags': 'SameSite=None;Secure'
      });
    </script>
  @endif
  
  @php(wp_footer())
  
  {{-- Remove loading state --}}
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.documentElement.classList.remove('is-loading');
      
      // Remove loader with fade
      const loader = document.querySelector('.loader-default');
      if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => loader.remove(), 300);
      }
    });
  </script>
</body>
</html>