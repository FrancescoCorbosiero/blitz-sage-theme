// resources/js/core/component-registry.js

export class ComponentRegistry {
  static registerAll(Alpine) {
    // Form components
    this.registerFormComponents(Alpine);
    
    // UI components
    this.registerUIComponents(Alpine);
    
    // Layout components
    this.registerLayoutComponents(Alpine);
    
    // Utility components
    this.registerUtilityComponents(Alpine);
  }
  
  static registerFormComponents(Alpine) {
    // Form handler with validation
    Alpine.data('formHandler', () => ({
      loading: false,
      errors: {},
      success: false,
      
      async submit(event) {
        event.preventDefault();
        this.loading = true;
        this.errors = {};
        
        const formData = new FormData(event.target);
        
        try {
          const response = await fetch(event.target.action, {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
            }
          });
          
          const data = await response.json();
          
          if (response.ok) {
            this.success = true;
            this.resetForm(event.target);
          } else {
            this.errors = data.errors || {};
          }
        } catch (error) {
          console.error('Form submission error:', error);
          this.errors.general = 'An error occurred. Please try again.';
        } finally {
          this.loading = false;
        }
      },
      
      resetForm(form) {
        form.reset();
        setTimeout(() => {
          this.success = false;
        }, 5000);
      }
    }));
    
    // Search component
    Alpine.data('searchBox', () => ({
      query: '',
      results: [],
      loading: false,
      open: false,
      
      async search() {
        if (this.query.length < 3) return;
        
        this.loading = true;
        
        try {
          const response = await fetch(`/wp-json/wp/v2/search?search=${this.query}`);
          this.results = await response.json();
          this.open = true;
        } catch (error) {
          console.error('Search error:', error);
        } finally {
          this.loading = false;
        }
      }
    }));
  }
  
  static registerUIComponents(Alpine) {
    // Toast notifications
    Alpine.data('toast', () => ({
      notifications: [],
      
      add(message, type = 'info') {
        const id = Date.now();
        this.notifications.push({ id, message, type });
        
        setTimeout(() => {
          this.remove(id);
        }, 5000);
      },
      
      remove(id) {
        this.notifications = this.notifications.filter(n => n.id !== id);
      }
    }));
    
    // Lightbox
    Alpine.data('lightbox', () => ({
      images: [],
      currentIndex: 0,
      open: false,
      
      init() {
        this.images = Array.from(this.$el.querySelectorAll('img')).map(img => ({
          src: img.dataset.fullsize || img.src,
          alt: img.alt
        }));
      },
      
      openImage(index) {
        this.currentIndex = index;
        this.open = true;
      },
      
      next() {
        this.currentIndex = (this.currentIndex + 1) % this.images.length;
      },
      
      prev() {
        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
      }
    }));
  }
  
  static registerLayoutComponents(Alpine) {
    // Sidebar toggle
    Alpine.data('sidebar', () => ({
      open: window.innerWidth >= 1024,
      
      toggle() {
        this.open = !this.open;
      },
      
      handleResize() {
        if (window.innerWidth >= 1024) {
          this.open = true;
        }
      }
    }));
    
    // Mobile menu
    Alpine.data('mobileMenu', () => ({
      open: false,
      
      toggle() {
        this.open = !this.open;
        document.body.style.overflow = this.open ? 'hidden' : '';
      },
      
      close() {
        this.open = false;
        document.body.style.overflow = '';
      }
    }));
  }
  
  static registerUtilityComponents(Alpine) {
    // Countdown timer
    Alpine.data('countdown', (targetDate) => ({
      days: 0,
      hours: 0,
      minutes: 0,
      seconds: 0,
      expired: false,
      
      init() {
        this.updateCountdown();
        setInterval(() => this.updateCountdown(), 1000);
      },
      
      updateCountdown() {
        const now = new Date().getTime();
        const target = new Date(targetDate).getTime();
        const distance = target - now;
        
        if (distance < 0) {
          this.expired = true;
          return;
        }
        
        this.days = Math.floor(distance / (1000 * 60 * 60 * 24));
        this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        this.seconds = Math.floor((distance % (1000 * 60)) / 1000);
      }
    }));
    
    // Copy to clipboard
    Alpine.data('clipboard', () => ({
      copied: false,
      
      copy(text) {
        navigator.clipboard.writeText(text).then(() => {
          this.copied = true;
          setTimeout(() => {
            this.copied = false;
          }, 2000);
        });
      }
    }));
  }
}