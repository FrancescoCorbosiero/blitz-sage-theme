# Blitz Theme - Complete Documentation

A modern, performant WordPress theme built with Sage 10, Tailwind CSS, Alpine.js, and Laravel Blade templating. Features a self-contained block philosophy, advanced navigation enhancement, and comprehensive optimization.

## Table of Contents
- [Architecture Overview](#architecture-overview)
- [Installation](#installation)
- [Core Features](#core-features)
- [Module Documentation](#module-documentation)
- [Configuration](#configuration)
- [Development](#development)
- [API Reference](#api-reference)

## Architecture Overview

```
blitz-theme/
├── app/                        # PHP/Laravel application layer
│   ├── Providers/             # Service providers
│   ├── Services/              # Service classes
│   ├── View/Composers/        # Blade view composers
│   ├── filters.php            # WordPress filters
│   └── setup.php              # Theme setup
├── resources/                  # Frontend assets
│   ├── css/                   # Stylesheets
│   ├── js/                    # JavaScript modules
│   └── views/                 # Blade templates
├── public/                     # Built assets
├── functions.php              # Theme bootstrap
├── vite.config.js             # Build configuration
└── composer.json              # PHP dependencies
```

## Installation

### Requirements
- PHP 8.0+
- Composer
- Node.js 16+
- WordPress 6.0+
- MySQL 5.7+ / MariaDB 10.3+

### Setup
```bash
# Clone the theme
cd wp-content/themes/
git clone https://github.com/yourusername/blitz-theme.git

# Install dependencies
cd blitz-theme
composer install
npm install

# Build assets
npm run build   # Production
npm run dev     # Development with HMR
```

## Core Features

### 🎨 **Design & Styling**
- **Tailwind CSS** with custom configuration
- **CSS Layer Architecture** for optimal cascade control
- **Token-based Design System** (colors, typography, spacing, animations)
- **Dark/Light/Auto Theme Modes** with system preference detection
- **Animated Backgrounds** with performant gradient effects
- **Custom Scrollbar Styles** theme-aware
- **Glass Morphism Effects** for modern UI

### ⚡ **Performance**
- **Vite Build System** with HMR and code splitting
- **Speculation Rules API** for intelligent prefetching
- **View Transitions API** for SPA-like navigation
- **Service Worker** for offline support and caching
- **Critical CSS Inlining** for faster FCP
- **Image Optimization** (WebP, AVIF, lazy loading)
- **Web Vitals Monitoring** with analytics integration
- **Brotli/Gzip Compression** for all assets
- **Smart Resource Hints** (DNS prefetch, preconnect)

### 🔧 **Developer Experience**
- **Sage 10 Framework** with Laravel components
- **Blade Templating** for clean, reusable templates
- **ES6 Modules** with proper imports/exports
- **Alpine.js Integration** for reactive components
- **Component Registry** for reusable UI patterns
- **Self-contained Blocks** (HTML + CSS + JS)
- **Hot Module Replacement** for instant updates
- **TypeScript Ready** (optional)

### ♿ **Accessibility**
- **WCAG 2.1 AA Compliant**
- **Focus Management System** with trap/restore
- **Keyboard Navigation** for all interactive elements
- **Skip Links** for screen readers
- **ARIA Live Regions** for dynamic content
- **Responsive Tables** with keyboard navigation
- **Form Enhancements** with proper labeling
- **Screen Reader Announcements** for SPA navigation

### 🔒 **Security**
- **Security Headers** (CSP, X-Frame-Options, etc.)
- **XML-RPC Disabled** by default
- **Hidden Login Errors** to prevent enumeration
- **File Editing Disabled** in admin
- **Nonce Verification** for all forms
- **Input Sanitization** throughout

### 📱 **Responsive & Adaptive**
- **Mobile-first Design** approach
- **Fluid Typography** with clamp()
- **Container Queries Ready**
- **Responsive Images** with srcset
- **Touch-optimized** interactions

## Module Documentation

### PHP Modules

#### **ThemeServiceProvider** (`app/Providers/ThemeServiceProvider.php`)
Main service provider that bootstraps all theme functionality.

**Features:**
- Service registration (Theme, SEO, Performance)
- Custom post types (Service, Portfolio, Team, FAQ, Testimonial)
- Custom taxonomies (Service/Portfolio categories)
- Customizer settings registration
- Admin interface enhancements
- Metabox registration for pages/posts

**Key Methods:**
```php
bootThemeServices()      // Initialize theme services
bootSeoEnhancements()    // Setup SEO features
bootPerformanceOptimizations() // Performance tweaks
bootSecurityEnhancements()     // Security hardening
bootAccessibilityFeatures()    // A11y improvements
```

#### **BlitzThemeService** (`app/Services/BlitzThemeService.php`)
Central theme configuration and helper service.

**Features:**
- Configuration caching
- Contact info management
- Social links management
- Feature flags
- Menu configuration
- Assets versioning

**API:**
```php
getConfig()          // Get all configuration
getContactInfo($field) // Get contact information
getSocialLinks($platform) // Get social media links
isFeatureEnabled($feature) // Check feature flags
clearCache()         // Clear configuration cache
```

#### **SeoService** (`app/Services/SeoService.php`)
Comprehensive SEO management.

**Features:**
- Meta descriptions (auto-generated or custom)
- Open Graph tags generation
- Twitter Card tags
- Schema.org structured data
- Breadcrumb schema
- Canonical URLs
- FAQ schema for FAQ post type

**API:**
```php
getMetaDescription()    // Generate meta description
getOpenGraphImage()     // Get OG image
getCanonicalUrl()       // Get canonical URL
getSchemaData()         // Generate JSON-LD
generateOpenGraphTags() // Output OG tags
generateTwitterCardTags() // Output Twitter tags
```

#### **PerformanceService** (`app/Services/PerformanceService.php`)
Performance optimization utilities.

**Features:**
- Query optimization
- Speculation rules generation
- Cache headers management
- Resource hints
- Critical CSS generation
- Web Vitals tracking script
- Image attribute optimization
- Unnecessary feature removal

**API:**
```php
optimizeQueries($query)     // Optimize WP queries
generateSpeculationRules()  // Generate prefetch rules
getCacheHeaders()           // Get cache control headers
getResourceHints()          // Get DNS/preconnect hints
getCriticalCss()           // Get critical CSS
getWebVitalsScript()       // Get monitoring script
optimizeImageAttributes()   // Add lazy loading
```

### JavaScript Modules

#### **App.js** (`resources/js/app.js`)
Main entry point orchestrating all JavaScript functionality.

**Features:**
- Alpine.js initialization
- Core feature initialization
- Block system management
- Service Worker registration
- Global utilities (BlockUtils)
- WordPress admin bar handling

**Global Objects:**
```javascript
window.Alpine              // Alpine.js instance
window.themeManager        // Theme management
window.navigationEnhancer  // Navigation features
window.accessibilityManager // A11y features
window.BlockUtils          // Utility functions
```

#### **NavigationEnhancer** (`resources/js/features/navigation-enhancement.js`)
SPA-like navigation with SSR benefits.

**Features:**
- Speculation Rules API usage
- View Transitions API
- Smart prefetching strategies
- Hover prerendering
- Intersection-based prefetching
- Fallback for older browsers

**Configuration:**
```javascript
{
  enableSpeculation: true,
  enableTransitions: true,
  enablePrefetch: true,
  prefetchDelay: 2000,
  hoverDelay: 65
}
```

#### **ThemeManager** (`resources/js/features/theme-manager.js`)
Dark/light theme switching system.

**Features:**
- Light/Dark/Auto modes
- System preference detection
- LocalStorage persistence
- Cross-tab synchronization
- Toast notifications
- Meta theme-color updates

**API:**
```javascript
setTheme(theme)      // Set theme mode
getTheme()           // Get current theme
getEffectiveTheme()  // Get actual theme (auto resolved)
isDark()             // Check if dark mode
isLight()            // Check if light mode
cycleTheme()         // Cycle through modes
```

#### **AccessibilityManager** (`resources/js/features/accessibility.js`)
Comprehensive accessibility enhancements.

**Features:**
- Focus trap management
- Keyboard navigation
- Skip links
- Live regions for screen readers
- Table enhancements
- Form accessibility
- Page change announcements

**API:**
```javascript
announce(message, priority)  // Screen reader announcement
trapFocus(element)          // Trap focus in element
releaseFocus(element)       // Release focus trap
```

#### **ComponentRegistry** (`resources/js/core/component-registry.js`)
Alpine.js component registration system.

**Registered Components:**
- `formHandler` - Form submission with validation
- `searchBox` - Live search functionality
- `toast` - Notification system
- `lightbox` - Image gallery
- `sidebar` - Sidebar toggle
- `mobileMenu` - Mobile navigation
- `countdown` - Timer component
- `clipboard` - Copy to clipboard

### CSS Architecture

#### **Token System** (`resources/css/core/tokens/`)
Design tokens for consistency:

- **colors.css** - Complete color palette with dark mode
- **typography.css** - Font families, sizes, line heights
- **spacing.css** - Spacing rhythm scale
- **animations.css** - Animation curves and keyframes

#### **Utilities** (`resources/css/core/utilities/`)
Opt-in utility classes:

- **typography.css** - Text styling utilities
- **forms.css** - Form control styles
- **effects.css** - Visual effects (shadows, gradients)

#### **DOM Styles** (`resources/css/dom/`)
Element-specific styles:

- **body.css** - Body animations and backgrounds
- **loading.css** - Loading states
- **scrollbar.css** - Custom scrollbars
- **theme-toggle.css** - Theme switcher styles

## Configuration

### Theme Customizer Options
Access via WordPress Customizer:

- **Theme Options** - Default mode, toggle visibility
- **Performance** - Lazy loading, speculation rules, Web Vitals
- **SEO** - Schema.org, Open Graph settings
- **Contact Information** - Phone, email, address, WhatsApp
- **Social Media** - All major platform links

### JavaScript Configuration
Edit `resources/js/core/config.js`:

```javascript
export const config = {
  theme: { defaultMode: 'auto' },
  navigation: { enableSpeculation: true },
  performance: { enableWebVitals: true },
  animations: { enableAOS: true },
  features: { darkMode: true }
}
```

### Build Configuration
Edit `vite.config.js`:

- Entry points configuration
- Build optimization settings
- Image optimization options
- Compression settings

## Development

### Commands
```bash
npm run dev      # Start dev server with HMR
npm run build    # Build for production
npm run analyze  # Bundle analysis
composer test    # Run PHP tests
npm run lint     # Lint JS/CSS
```

### Creating New Blocks
Blocks follow self-contained philosophy:

```blade
{{-- resources/views/sections/new-block/new-block.blade.php --}}
<section class="new-block" x-data="newBlock(@json($data))">
  <!-- HTML -->
</section>

<style>
  /* Scoped CSS */
  .new-block { }
</style>

<script>
document.addEventListener('alpine:init', () => {
  Alpine.data('newBlock', (data = {}) => ({
    // Component logic
  }));
});
</script>
```

### Adding Custom Post Types
Register in `ThemeServiceProvider::registerCustomPostTypes()`:

```php
register_post_type('custom_type', [
    'labels' => [...],
    'public' => true,
    'supports' => ['title', 'editor', 'thumbnail'],
    'menu_icon' => 'dashicons-icon'
]);
```

## API Reference

### PHP Helper Functions
```php
// Theme helpers
blitz_theme($key)         // Get theme config
blitz_contact($field)      // Get contact info
blitz_social($platform)    // Get social links
blitz_seo()               // Get SEO service
blitz_performance()       // Get performance service
blitz_feature_enabled()   // Check feature flag
blitz_clear_cache()       // Clear theme cache
blitz_assets_version()    // Get assets version
```

### JavaScript Global Utilities
```javascript
// BlockUtils methods
BlockUtils.animate(element, animation)
BlockUtils.lazyLoad(selector)
BlockUtils.trackEvent(category, action, label)
BlockUtils.showToast(message, type)
BlockUtils.debounce(func, wait)
BlockUtils.throttle(func, limit)
```

### WordPress Hooks

**Actions:**
- `blocks:ready` - All blocks initialized
- `theme:changed` - Theme mode changed
- `navigation:complete` - Navigation transition complete
- `analytics:track` - Analytics event tracked

**Filters:**
- `blitz_theme_config` - Modify theme configuration
- `blitz_speculation_rules` - Modify prefetch rules
- `blitz_critical_css` - Modify critical CSS

## Browser Support
- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Chrome Android 90+
- Safari iOS 14+

## Performance Metrics
Target metrics on mobile (Lighthouse):
- Performance: 95+
- Accessibility: 100
- Best Practices: 100
- SEO: 100

## License
GPL v2 or later

## Credits
Built with [Sage](https://roots.io/sage/), [Tailwind CSS](https://tailwindcss.com/), [Alpine.js](https://alpinejs.dev/), and [Vite](https://vitejs.dev/).

---

**Version:** 1.0.0  
**Author:** Blitz Theme Team  
**Website:** [blitztheme.com](https://blitztheme.com)