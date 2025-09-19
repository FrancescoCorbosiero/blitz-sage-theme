// resources/js/modules/navigation-enhancement.js

/**
 * Generic Navigation Enhancement Module
 * Works with any WordPress/Sage site
 */

class NavigationEnhancer {
  constructor(options = {}) {
    this.config = {
      enableSpeculation: true,
      enableTransitions: true,
      enablePrefetch: true,
      enableAnalytics: true,
      prefetchDelay: 2000,
      hoverDelay: 65, // Delay before prefetch on hover
      ...options
    };
    
    this.prefetchedUrls = new Set();
    this.prerenderedUrls = new Set();
    this.hoveredLinks = new WeakSet();
    
    this.init();
  }

  init() {
    if (this.config.enableSpeculation) {
      this.setupSpeculationObserver();
    }
    
    if (this.config.enableTransitions) {
      this.setupViewTransitions();
    }
    
    if (this.config.enablePrefetch) {
      this.setupIntelligentPrefetch();
    }
    
    if (this.config.enableAnalytics) {
      this.trackNavigationPerformance();
    }
  }

  /**
   * Setup Speculation Rules with IntersectionObserver
   */
  setupSpeculationObserver() {
    if (!this.supportsSpeculationRules()) {
      this.setupFallbackStrategy();
      return;
    }

    // Observer for viewport visibility
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const link = entry.target;
            const href = this.getValidHref(link);
            
            if (href && this.shouldPrefetch(href)) {
              // High priority links get prerendered
              if (link.dataset.priority === 'high' || 
                  link.classList.contains('btn-primary') ||
                  link.classList.contains('cta')) {
                this.prerenderUrl(href);
              } else {
                this.prefetchUrl(href);
              }
            }
          }
        });
      },
      {
        rootMargin: '50px' // Start loading 50px before entering viewport
      }
    );

    // Observe all internal links
    this.observeLinks(observer);
    
    // Setup hover-based prerendering for CTAs
    this.setupHoverPrerender();
  }

  /**
   * Observe links for prefetching
   */
  observeLinks(observer) {
    document.querySelectorAll('a[href]').forEach(link => {
      if (this.isInternalLink(link) && !this.isExcluded(link)) {
        observer.observe(link);
      }
    });

    // Watch for dynamically added links
    const mutationObserver = new MutationObserver((mutations) => {
      mutations.forEach(mutation => {
        mutation.addedNodes.forEach(node => {
          if (node.nodeType === 1) { // Element node
            const links = node.tagName === 'A' ? [node] : node.querySelectorAll?.('a[href]') || [];
            links.forEach(link => {
              if (this.isInternalLink(link) && !this.isExcluded(link)) {
                observer.observe(link);
              }
            });
          }
        });
      });
    });

    mutationObserver.observe(document.body, {
      childList: true,
      subtree: true
    });
  }

  /**
   * Setup hover-based prerendering for high-priority elements
   */
  setupHoverPrerender() {
    let hoverTimer;
    
    document.addEventListener('pointerover', (e) => {
      const link = e.target.closest('a[href]');
      
      if (!link || this.hoveredLinks.has(link)) return;
      
      const href = this.getValidHref(link);
      if (!href || !this.shouldPrefetch(href)) return;
      
      this.hoveredLinks.add(link);
      
      // Clear any existing timer
      clearTimeout(hoverTimer);
      
      // Start prefetch/prerender after hover delay
      hoverTimer = setTimeout(() => {
        if (link.matches(':hover')) {
          // High priority elements get prerendered
          if (this.isHighPriority(link)) {
            this.prerenderUrl(href);
          } else {
            this.prefetchUrl(href);
          }
        }
      }, this.config.hoverDelay);
    });

    document.addEventListener('pointerout', (e) => {
      clearTimeout(hoverTimer);
    });
  }

  /**
   * Check if element is high priority
   */
  isHighPriority(element) {
    return element.dataset.priority === 'high' ||
           element.classList.contains('btn-primary') ||
           element.classList.contains('cta') ||
           element.classList.contains('hero-cta') ||
           element.querySelector('.btn-primary');
  }

  /**
   * Setup View Transitions API
   */
  setupViewTransitions() {
    if (!document.startViewTransition) {
      console.log('View Transitions not supported, using fallback');
      this.setupFallbackTransitions();
      return;
    }

    // Intercept link clicks for smooth transitions
    document.addEventListener('click', async (e) => {
      const link = e.target.closest('a[href]');
      
      if (!link || !this.shouldTransition(link)) return;
      
      e.preventDefault();
      
      const href = link.href;
      
      try {
        // Start the view transition
        const transition = document.startViewTransition(async () => {
          await this.updatePage(href);
        });
        
        await transition.finished;
      } catch (error) {
        console.error('View transition failed:', error);
        window.location.href = href;
      }
    });

    // Handle browser back/forward
    window.addEventListener('popstate', async (e) => {
      if (document.startViewTransition) {
        const transition = document.startViewTransition(async () => {
          await this.updatePage(window.location.href);
        });
        
        try {
          await transition.finished;
        } catch (error) {
          console.error('Popstate transition failed:', error);
          window.location.reload();
        }
      }
    });
  }

  /**
   * Update page content for view transitions
   */
  async updatePage(url) {
    try {
      const response = await fetch(url, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      });
      
      if (!response.ok) throw new Error('Failed to fetch page');
      
      const html = await response.text();
      const parser = new DOMParser();
      const newDoc = parser.parseFromString(html, 'text/html');
      
      // Update the main content
      const mainContent = document.querySelector('main');
      const newMainContent = newDoc.querySelector('main');
      
      if (mainContent && newMainContent) {
        mainContent.innerHTML = newMainContent.innerHTML;
      }
      
      // Update meta tags
      document.title = newDoc.title;
      
      // Update body classes
      document.body.className = newDoc.body.className;
      
      // Update current navigation states
      this.updateNavigationStates(url);
      
      // Update history
      if (window.location.href !== url) {
        window.history.pushState({}, '', url);
      }
      
      // Scroll to top
      window.scrollTo(0, 0);
      
      // Trigger custom event
      window.dispatchEvent(new CustomEvent('page:changed', { detail: { url } }));
      
      // Reinitialize any necessary scripts
      this.reinitializeScripts();
      
    } catch (error) {
      throw error;
    }
  }

  /**
   * Update navigation active states
   */
  updateNavigationStates(url) {
    const currentPath = new URL(url).pathname;
    
    document.querySelectorAll('nav a').forEach(link => {
      const linkPath = new URL(link.href).pathname;
      
      if (linkPath === currentPath) {
        link.classList.add('current-menu-item', 'active');
        link.setAttribute('aria-current', 'page');
      } else {
        link.classList.remove('current-menu-item', 'active');
        link.removeAttribute('aria-current');
      }
    });
  }

  /**
   * Reinitialize scripts after page change
   */
  reinitializeScripts() {
    // Trigger WordPress hooks
    if (window.wp?.hooks) {
      window.wp.hooks.doAction('page.changed');
    }
    
    // Reinitialize Alpine if present
    if (window.Alpine) {
      window.Alpine.initTree(document.querySelector('main'));
    }
    
    // Trigger custom reinitialization event
    document.dispatchEvent(new CustomEvent('navigation:complete'));
  }

  /**
   * Setup intelligent prefetch based on user patterns
   */
  setupIntelligentPrefetch() {
    // Track time on page
    let timeOnPage = 0;
    const timeInterval = setInterval(() => {
      timeOnPage++;
      
      // After 3 seconds, prefetch likely next pages
      if (timeOnPage === 3) {
        this.prefetchLikelyPages();
      }
      
      // Stop tracking after 30 seconds
      if (timeOnPage >= 30) {
        clearInterval(timeInterval);
      }
    }, 1000);

    // Track scroll depth
    let maxScrollDepth = 0;
    const scrollHandler = this.throttle(() => {
      const scrolled = window.scrollY;
      const height = document.documentElement.scrollHeight - window.innerHeight;
      const scrolledPercentage = (scrolled / height) * 100;
      
      if (scrolledPercentage > maxScrollDepth) {
        maxScrollDepth = scrolledPercentage;
        
        // At 50% scroll, prefetch next likely navigation
        if (maxScrollDepth > 50) {
          this.prefetchFromNavigation();
        }
      }
    }, 250);
    
    window.addEventListener('scroll', scrollHandler, { passive: true });
  }

  /**
   * Prefetch likely next pages based on common patterns
   */
  prefetchLikelyPages() {
    // Find CTA buttons and primary navigation items
    const prioritySelectors = [
      '.btn-primary',
      '.cta',
      'nav a',
      '.pagination a.next',
      '.post-navigation a'
    ];
    
    prioritySelectors.forEach(selector => {
      document.querySelectorAll(selector).forEach(element => {
        const href = this.getValidHref(element);
        if (href && this.shouldPrefetch(href)) {
          this.prefetchUrl(href);
        }
      });
    });
  }

  /**
   * Prefetch from navigation menu
   */
  prefetchFromNavigation() {
    const navLinks = document.querySelectorAll('nav a[href]');
    const currentPath = window.location.pathname;
    
    // Find current item index
    let currentIndex = -1;
    navLinks.forEach((link, index) => {
      if (new URL(link.href).pathname === currentPath) {
        currentIndex = index;
      }
    });
    
    // Prefetch next item in navigation
    if (currentIndex >= 0 && currentIndex < navLinks.length - 1) {
      const nextLink = navLinks[currentIndex + 1];
      const href = this.getValidHref(nextLink);
      if (href) {
        this.prefetchUrl(href);
      }
    }
  }

  /**
   * Prerender URL using Speculation Rules API
   */
  prerenderUrl(url) {
    if (this.prerenderedUrls.has(url)) return;
    
    this.addSpeculationRule('prerender', url);
    this.prerenderedUrls.add(url);
    console.log(`🚀 Prerendering: ${url}`);
  }

  /**
   * Prefetch URL using Speculation Rules API
   */
  prefetchUrl(url) {
    if (this.prefetchedUrls.has(url) || this.prerenderedUrls.has(url)) return;
    
    this.addSpeculationRule('prefetch', url);
    this.prefetchedUrls.add(url);
    console.log(`📥 Prefetching: ${url}`);
  }

  /**
   * Add speculation rule dynamically
   */
  addSpeculationRule(type, url) {
    if (!this.supportsSpeculationRules()) {
      this.fallbackPrefetch(url);
      return;
    }
    
    const script = document.createElement('script');
    script.type = 'speculationrules';
    script.textContent = JSON.stringify({
      [type]: [{
        source: 'list',
        urls: [url]
      }]
    });
    document.head.appendChild(script);
  }

  /**
   * Fallback prefetch using link element
   */
  fallbackPrefetch(url) {
    const link = document.createElement('link');
    link.rel = 'prefetch';
    link.href = url;
    document.head.appendChild(link);
  }

  /**
   * Setup fallback for browsers without native support
   */
  setupFallbackStrategy() {
    // Use Intersection Observer for prefetching
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const link = entry.target;
            const href = this.getValidHref(link);
            if (href && this.shouldPrefetch(href)) {
              this.fallbackPrefetch(href);
            }
          }
        });
      },
      { rootMargin: '100px' }
    );

    document.querySelectorAll('a[href]').forEach(link => {
      if (this.isInternalLink(link) && !this.isExcluded(link)) {
        observer.observe(link);
      }
    });
  }

  /**
   * Setup fallback transitions
   */
  setupFallbackTransitions() {
    document.addEventListener('click', (e) => {
      const link = e.target.closest('a[href]');
      
      if (!link || !this.shouldTransition(link)) return;
      
      e.preventDefault();
      
      // Simple fade out effect
      document.body.style.transition = 'opacity 0.2s';
      document.body.style.opacity = '0';
      
      setTimeout(() => {
        window.location.href = link.href;
      }, 200);
    });
  }

  /**
   * Track navigation performance
   */
  trackNavigationPerformance() {
    // Log navigation timing
    window.addEventListener('load', () => {
      const navEntry = performance.getEntriesByType('navigation')[0];
      
      if (navEntry) {
        const metrics = {
          dns: navEntry.domainLookupEnd - navEntry.domainLookupStart,
          tcp: navEntry.connectEnd - navEntry.connectStart,
          request: navEntry.responseStart - navEntry.requestStart,
          response: navEntry.responseEnd - navEntry.responseStart,
          dom: navEntry.domContentLoadedEventEnd - navEntry.responseEnd,
          load: navEntry.loadEventEnd - navEntry.loadEventStart,
          total: navEntry.loadEventEnd - navEntry.fetchStart
        };
        
        console.log('Navigation Performance:', metrics);
        
        // Send to analytics if available
        if (window.gtag) {
          window.gtag('event', 'page_timing', {
            'event_category': 'Performance',
            'event_label': 'Page Load',
            'value': Math.round(metrics.total)
          });
        }
        
        // Check if page was prerendered
        if (navEntry.type === 'prerender') {
          console.log('⚡ This page was prerendered!');
        }
      }
    });
  }

  /**
   * Utility: Check if link is internal
   */
  isInternalLink(link) {
    try {
      const url = new URL(link.href);
      return url.origin === window.location.origin;
    } catch {
      return false;
    }
  }

  /**
   * Utility: Check if link should be excluded
   */
  isExcluded(link) {
    return link.href.includes('#') ||
           link.href.includes('wp-admin') ||
           link.href.includes('wp-login') ||
           link.href.endsWith('.pdf') ||
           link.href.endsWith('.zip') ||
           link.hasAttribute('download') ||
           link.getAttribute('target') === '_blank' ||
           link.classList.contains('no-prefetch') ||
           link.dataset.noPrefetch === 'true';
  }

  /**
   * Utility: Check if link should use view transition
   */
  shouldTransition(link) {
    return this.isInternalLink(link) && 
           !this.isExcluded(link) &&
           !link.classList.contains('no-transition');
  }

  /**
   * Utility: Check if URL should be prefetched
   */
  shouldPrefetch(url) {
    return !this.prefetchedUrls.has(url) && 
           !this.prerenderedUrls.has(url) &&
           !url.includes('#') &&
           !url.includes('wp-admin');
  }

  /**
   * Utility: Get valid href from element
   */
  getValidHref(element) {
    const href = element.href || element.getAttribute('href');
    if (!href || href === '#') return null;
    
    try {
      const url = new URL(href, window.location.origin);
      return url.href;
    } catch {
      return null;
    }
  }

  /**
   * Utility: Check for Speculation Rules support
   */
  supportsSpeculationRules() {
    return HTMLScriptElement.supports?.('speculationrules');
  }

  /**
   * Utility: Throttle function
   */
  throttle(func, wait) {
    let timeout;
    let lastTime = 0;
    
    return function(...args) {
      const now = Date.now();
      const remaining = wait - (now - lastTime);
      
      if (remaining <= 0 || remaining > wait) {
        if (timeout) {
          clearTimeout(timeout);
          timeout = null;
        }
        lastTime = now;
        func.apply(this, args);
      } else if (!timeout) {
        timeout = setTimeout(() => {
          lastTime = Date.now();
          timeout = null;
          func.apply(this, args);
        }, remaining);
      }
    };
  }
}

// Auto-initialize with default config
document.addEventListener('DOMContentLoaded', () => {
  window.navigationEnhancer = new NavigationEnhancer({
    // Override defaults here if needed
  });
});

// Export for use in other modules
export default NavigationEnhancer;