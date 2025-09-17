// resources/js/modules/navigation-enhancement.js

/**
 * Advanced Navigation Enhancement for Dog Safe Place
 * Includes: Speculation Rules, View Transitions, Smart Prefetching
 */

class NavigationEnhancer {
  constructor() {
    this.prefetchedUrls = new Set();
    this.prerenderedUrls = new Set();
    this.init();
  }

  init() {
    this.setupSpeculationRules();
    this.setupViewTransitions();
    this.monitorNavigation();
    this.setupSmartPrefetch();
  }

  /**
   * Dynamic Speculation Rules based on user behavior
   */
  setupSpeculationRules() {
    if (!HTMLScriptElement.supports?.('speculationrules')) {
      console.log('⚠️ Speculation Rules not supported');
      this.setupFallbackPrefetch();
      return;
    }

    console.log('✅ Speculation Rules enabled');

    // Monitor user intent and add dynamic rules
    this.addDynamicSpeculationRules();
  }

  /**
   * Add dynamic speculation rules based on user behavior
   */
  addDynamicSpeculationRules() {
    // Track user hovering over booking CTAs
    document.addEventListener('mouseover', (e) => {
      const bookingLink = e.target.closest('a[href*="prenota"]');
      if (bookingLink && !this.prerenderedUrls.has('/prenota')) {
        this.addPrerender('/prenota');
        this.prerenderedUrls.add('/prenota');
      }
    });

    // Prerender next likely page based on current page
    const currentPath = window.location.pathname;
    const nextLikelyPages = this.predictNextPages(currentPath);
    
    nextLikelyPages.forEach(page => {
      setTimeout(() => this.addPrefetch(page), 2000); // Delay to prioritize current page
    });
  }

  /**
   * Predict next likely pages based on current page
   */
  predictNextPages(currentPath) {
    const predictions = {
      '/': ['/servizi', '/prezzi', '/prenota'],
      '/servizi': ['/prenota', '/prezzi'],
      '/prezzi': ['/prenota'],
      '/chi-siamo': ['/servizi', '/prenota'],
      '/blog': ['/prenota']
    };

    return predictions[currentPath] || ['/prenota']; // Default to booking page
  }

  /**
   * Add prerender rule dynamically
   */
  addPrerender(url) {
    const script = document.createElement('script');
    script.type = 'speculationrules';
    script.textContent = JSON.stringify({
      prerender: [{
        source: 'list',
        urls: [url]
      }]
    });
    document.head.appendChild(script);
    console.log(`🚀 Prerendering: ${url}`);
  }

  /**
   * Add prefetch rule dynamically
   */
  addPrefetch(url) {
    if (this.prefetchedUrls.has(url)) return;
    
    const script = document.createElement('script');
    script.type = 'speculationrules';
    script.textContent = JSON.stringify({
      prefetch: [{
        source: 'list',
        urls: [url]
      }]
    });
    document.head.appendChild(script);
    this.prefetchedUrls.add(url);
    console.log(`📥 Prefetching: ${url}`);
  }

  /**
   * Setup View Transitions with custom animations
   */
  setupViewTransitions() {
    if (!document.startViewTransition) {
      console.log('⚠️ View Transitions not supported');
      this.setupFallbackTransitions();
      return;
    }

    console.log('✅ View Transitions enabled');

    // Intercept navigation for smooth transitions
    document.addEventListener('click', (e) => {
      const link = e.target.closest('a');
      if (!link || !this.shouldTransition(link)) return;

      e.preventDefault();
      this.navigateWithTransition(link.href);
    });
  }

  /**
   * Check if link should use view transition
   */
  shouldTransition(link) {
    const href = link.getAttribute('href');
    return (
      href?.startsWith('/') &&
      !href.includes('wp-admin') &&
      !href.includes('#') &&
      !link.classList.contains('no-transition') &&
      !link.hasAttribute('download') &&
      link.target !== '_blank'
    );
  }

  /**
   * Navigate with view transition
   */
  async navigateWithTransition(url) {
    const transition = document.startViewTransition(async () => {
      await this.updateDOM(url);
    });

    try {
      await transition.finished;
      console.log('✨ View transition completed');
    } catch (error) {
      console.error('View transition failed:', error);
    }
  }

  /**
   * Update DOM with new content
   */
  async updateDOM(url) {
    try {
      const response = await fetch(url);
      const html = await response.text();
      
      // Parse the new content
      const parser = new DOMParser();
      const newDocument = parser.parseFromString(html, 'text/html');
      
      // Update the page content
      document.querySelector('main').innerHTML = 
        newDocument.querySelector('main').innerHTML;
      
      // Update title and meta
      document.title = newDocument.title;
      
      // Update URL
      window.history.pushState({}, '', url);
      
      // Reinitialize any JavaScript that needs to run on new content
      this.reinitializeScripts();
    } catch (error) {
      console.error('Failed to update DOM:', error);
      window.location.href = url; // Fallback to normal navigation
    }
  }

  /**
   * Reinitialize scripts after view transition
   */
  reinitializeScripts() {
    // Dispatch custom event for other scripts to listen to
    window.dispatchEvent(new CustomEvent('viewtransition:complete'));
    
    // Reinitialize Alpine components if needed
    if (window.Alpine) {
      window.Alpine.initTree(document.querySelector('main'));
    }
  }

  /**
   * Fallback for browsers without Speculation Rules
   */
  setupFallbackPrefetch() {
    // Intersection Observer for prefetching visible links
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const link = entry.target;
          const href = link.getAttribute('href');
          if (href && !this.prefetchedUrls.has(href)) {
            this.prefetchLink(href);
            this.prefetchedUrls.add(href);
          }
        }
      });
    }, {
      rootMargin: '50px'
    });

    // Observe all internal links
    document.querySelectorAll('a[href^="/"]').forEach(link => {
      observer.observe(link);
    });

    // Prefetch on hover as well
    document.addEventListener('mouseover', (e) => {
      const link = e.target.closest('a[href^="/"]');
      if (link) {
        const href = link.getAttribute('href');
        if (href && !this.prefetchedUrls.has(href)) {
          this.prefetchLink(href);
          this.prefetchedUrls.add(href);
        }
      }
    });
  }

  /**
   * Prefetch a link using link rel=prefetch
   */
  prefetchLink(url) {
    const link = document.createElement('link');
    link.rel = 'prefetch';
    link.href = url;
    document.head.appendChild(link);
    console.log(`📥 Fallback prefetch: ${url}`);
  }

  /**
   * Fallback transitions for older browsers
   */
  setupFallbackTransitions() {
    document.addEventListener('click', (e) => {
      const link = e.target.closest('a[href^="/"]');
      if (link && !link.classList.contains('no-transition')) {
        e.preventDefault();
        document.body.classList.add('fade-out');
        setTimeout(() => {
          window.location.href = link.href;
        }, 200);
      }
    });
  }

  /**
   * Monitor navigation performance
   */
  monitorNavigation() {
    // Log navigation timing
    if ('PerformanceNavigationTiming' in window) {
      window.addEventListener('load', () => {
        const navTiming = performance.getEntriesByType('navigation')[0];
        if (navTiming) {
          console.log(`⚡ Page load time: ${navTiming.loadEventEnd - navTiming.fetchStart}ms`);
          
          // Send to analytics if available
          if (window.gtag) {
            window.gtag('event', 'timing_complete', {
              'name': 'load',
              'value': Math.round(navTiming.loadEventEnd - navTiming.fetchStart),
              'event_category': 'Navigation Enhancement'
            });
          }
        }
      });
    }
  }

  /**
   * Smart prefetch based on user patterns
   */
  setupSmartPrefetch() {
    // Time on page tracking
    let timeOnPage = 0;
    setInterval(() => {
      timeOnPage++;
      
      // After 5 seconds, prefetch high-probability pages
      if (timeOnPage === 5) {
        this.prefetchHighPriorityPages();
      }
    }, 1000);

    // Track scroll depth
    let maxScroll = 0;
    window.addEventListener('scroll', () => {
      const scrollPercentage = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
      if (scrollPercentage > maxScroll) {
        maxScroll = scrollPercentage;
        
        // At 50% scroll, prefetch booking page
        if (maxScroll > 50 && !this.prefetchedUrls.has('/prenota')) {
          this.addPrefetch('/prenota');
        }
      }
    });
  }

  /**
   * Prefetch high priority pages
   */
  prefetchHighPriorityPages() {
    const highPriority = ['/prenota', '/prezzi', '/servizi'];
    highPriority.forEach(url => {
      if (!this.prefetchedUrls.has(url)) {
        this.addPrefetch(url);
      }
    });
  }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
  window.navigationEnhancer = new NavigationEnhancer();
});

// Export for use in other modules
export default NavigationEnhancer;