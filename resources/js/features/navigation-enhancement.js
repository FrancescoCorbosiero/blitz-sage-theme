// resources/js/features/navigation-enhancement.js

class NavigationEnhancer {
  constructor(options = {}) {
    this.config = {
      enableSpeculation: true,
      enableTransitions: true,
      enablePrefetch: true,
      prefetchDelay: 2000,
      hoverDelay: 65,
      ...options
    };
    
    this.prefetchedUrls = new Set();
    this.prerenderedUrls = new Set();
    
    this.init();
  }

  init() {
    if (this.config.enableSpeculation) {
      this.setupSpeculationRules();
    }
    
    if (this.config.enableTransitions) {
      this.setupViewTransitions();
    }
    
    if (this.config.enablePrefetch) {
      this.setupSmartPrefetch();
    }
  }

  setupSpeculationRules() {
    if (!HTMLScriptElement.supports?.('speculationrules')) {
      this.setupFallbackPrefetch();
      return;
    }

    // Observe links entering viewport
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const link = entry.target;
          const href = this.getValidHref(link);
          
          if (href && this.shouldPrefetch(href)) {
            if (this.isHighPriority(link)) {
              this.prerenderUrl(href);
            } else {
              this.prefetchUrl(href);
            }
          }
        }
      });
    }, { rootMargin: '50px' });

    // Observe all internal links
    document.querySelectorAll('a[href]').forEach(link => {
      if (this.isInternalLink(link) && !this.isExcluded(link)) {
        observer.observe(link);
      }
    });

    // Hover prerendering for CTAs
    this.setupHoverPrerender();
  }

  setupHoverPrerender() {
    let hoverTimer;
    
    document.addEventListener('pointerover', (e) => {
      const link = e.target.closest('a[href]');
      if (!link) return;
      
      const href = this.getValidHref(link);
      if (!href || !this.shouldPrefetch(href)) return;
      
      clearTimeout(hoverTimer);
      hoverTimer = setTimeout(() => {
        if (link.matches(':hover')) {
          if (this.isHighPriority(link)) {
            this.prerenderUrl(href);
          } else {
            this.prefetchUrl(href);
          }
        }
      }, this.config.hoverDelay);
    });

    document.addEventListener('pointerout', () => {
      clearTimeout(hoverTimer);
    });
  }

  setupViewTransitions() {
    if (!document.startViewTransition) {
      this.setupFallbackTransitions();
      return;
    }

    document.addEventListener('click', async (e) => {
      const link = e.target.closest('a[href]');
      
      if (!link || !this.shouldTransition(link)) return;
      
      e.preventDefault();
      
      const transition = document.startViewTransition(async () => {
        await this.updatePage(link.href);
      });
      
      try {
        await transition.finished;
      } catch (error) {
        console.error('View transition failed:', error);
        window.location.href = link.href;
      }
    });
  }

  async updatePage(url) {
    try {
      const response = await fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      
      const html = await response.text();
      const newDoc = new DOMParser().parseFromString(html, 'text/html');
      
      // Update main content
      const main = document.querySelector('main');
      const newMain = newDoc.querySelector('main');
      
      if (main && newMain) {
        main.innerHTML = newMain.innerHTML;
      }
      
      // Update meta
      document.title = newDoc.title;
      document.body.className = newDoc.body.className;
      
      // Update URL
      if (window.location.href !== url) {
        window.history.pushState({}, '', url);
      }
      
      // Reinitialize
      this.reinitialize();
      
      // Scroll to top
      window.scrollTo(0, 0);
      
    } catch (error) {
      throw error;
    }
  }

  reinitialize() {
    // Reinitialize Alpine
    if (window.Alpine) {
      window.Alpine.initTree(document.querySelector('main'));
    }
    
    // Dispatch event for other scripts
    window.dispatchEvent(new CustomEvent('navigation:complete'));
  }

  setupSmartPrefetch() {
    // Prefetch after time on page
    setTimeout(() => {
      this.prefetchLikelyPages();
    }, this.config.prefetchDelay);
    
    // Prefetch on scroll depth
    let maxScroll = 0;
    window.addEventListener('scroll', () => {
      const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
      
      if (scrolled > maxScroll) {
        maxScroll = scrolled;
        
        if (maxScroll > 50) {
          this.prefetchFromNavigation();
        }
      }
    }, { passive: true });
  }

  prefetchLikelyPages() {
    const selectors = ['.btn-primary', '.cta', 'nav a'];
    
    selectors.forEach(selector => {
      document.querySelectorAll(selector).forEach(el => {
        const href = this.getValidHref(el);
        if (href && this.shouldPrefetch(href)) {
          this.prefetchUrl(href);
        }
      });
    });
  }

  prefetchFromNavigation() {
    document.querySelectorAll('nav a[href]').forEach(link => {
      const href = this.getValidHref(link);
      if (href && this.shouldPrefetch(href)) {
        this.prefetchUrl(href);
      }
    });
  }

  // Utility methods
  prerenderUrl(url) {
    if (this.prerenderedUrls.has(url)) return;
    
    const script = document.createElement('script');
    script.type = 'speculationrules';
    script.textContent = JSON.stringify({
      prerender: [{ source: 'list', urls: [url] }]
    });
    document.head.appendChild(script);
    this.prerenderedUrls.add(url);
  }

  prefetchUrl(url) {
    if (this.prefetchedUrls.has(url) || this.prerenderedUrls.has(url)) return;
    
    const script = document.createElement('script');
    script.type = 'speculationrules';
    script.textContent = JSON.stringify({
      prefetch: [{ source: 'list', urls: [url] }]
    });
    document.head.appendChild(script);
    this.prefetchedUrls.add(url);
  }

  setupFallbackPrefetch() {
    document.querySelectorAll('a[href]').forEach(link => {
      if (this.isInternalLink(link) && !this.isExcluded(link)) {
        link.addEventListener('mouseenter', () => {
          const href = this.getValidHref(link);
          if (href && this.shouldPrefetch(href)) {
            const prefetchLink = document.createElement('link');
            prefetchLink.rel = 'prefetch';
            prefetchLink.href = href;
            document.head.appendChild(prefetchLink);
            this.prefetchedUrls.add(href);
          }
        });
      }
    });
  }

  setupFallbackTransitions() {
    document.addEventListener('click', (e) => {
      const link = e.target.closest('a[href]');
      
      if (!link || !this.shouldTransition(link)) return;
      
      e.preventDefault();
      document.body.style.opacity = '0';
      
      setTimeout(() => {
        window.location.href = link.href;
      }, 200);
    });
  }

  // Helper methods
  isInternalLink(link) {
    try {
      return new URL(link.href).origin === window.location.origin;
    } catch {
      return false;
    }
  }

  isExcluded(link) {
    return link.href.includes('#') ||
           link.href.includes('wp-admin') ||
           link.href.includes('wp-login') ||
           link.hasAttribute('download') ||
           link.target === '_blank' ||
           link.classList.contains('no-prefetch');
  }

  shouldTransition(link) {
    return this.isInternalLink(link) && 
           !this.isExcluded(link) &&
           !link.classList.contains('no-transition');
  }

  shouldPrefetch(url) {
    return !this.prefetchedUrls.has(url) && 
           !this.prerenderedUrls.has(url) &&
           !url.includes('#') &&
           !url.includes('wp-admin');
  }

  getValidHref(element) {
    const href = element.href || element.getAttribute('href');
    if (!href || href === '#') return null;
    
    try {
      return new URL(href, window.location.origin).href;
    } catch {
      return null;
    }
  }

  isHighPriority(element) {
    return element.classList.contains('btn-primary') ||
           element.classList.contains('cta') ||
           element.dataset.priority === 'high';
  }
}

// Auto-initialize
document.addEventListener('DOMContentLoaded', () => {
  window.navigationEnhancer = new NavigationEnhancer();
});

export default NavigationEnhancer;