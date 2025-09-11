# Blitz - High-Performance WordPress Theme

A modern, production-ready WordPress theme built with Sage 10, Laravel Blade, and Tailwind CSS v4. Features self-contained components, advanced optimization, and enterprise-ready architecture.

## 🚀 Features

- **Sage 10 Framework** - Modern WordPress development with Laravel components
- **Tailwind CSS v4** - Next-generation utility-first CSS with Vite plugin
- **Laravel Blade** - Powerful templating with components and directives
- **Alpine.js** - Lightweight reactive framework for interactivity
- **Performance Optimized** - Brotli/Gzip compression, image optimization (WebP/AVIF), code splitting
- **Self-Contained Sections** - Each section includes its own HTML, CSS, and JS
- **PWA Ready** - Service worker, manifest.json, and offline support
- **Developer Friendly** - Hot module replacement, aliases, linting

## 📋 Requirements

- PHP >= 8.2
- Composer >= 2.0
- Node.js >= 20.0.0
- WordPress >= 6.6

## 🛠️ Installation

### 1. Clone the theme

```bash
cd wp-content/themes/
git clone https://github.com/yourusername/blitz-theme.git
cd blitz-theme
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Configure environment

```bash
cp .env.example .env
```

Edit `.env` file with your local settings:
```env
WP_HOME=http://localhost/your-site
WP_SITEURL=${WP_HOME}/wp
```

### 5. Build assets

```bash
# Development (with HMR)
npm run dev

# Production build
npm run build
```

## 📁 Theme Structure

```
blitz-theme/
├── app/                      # PHP application files
│   ├── Providers/           # Service providers
│   ├── View/               # View composers and components
│   ├── filters.php         # WordPress filters
│   └── setup.php          # Theme setup
├── resources/              # Source assets
│   ├── css/               # Stylesheets
│   │   ├── app.css       # Main stylesheet
│   │   ├── editor.css    # Block editor styles
│   │   ├── core/         # Core utilities
│   │   └── dom/          # DOM-specific styles
│   ├── js/               # JavaScript
│   │   ├── app.js       # Main entry point
│   │   ├── editor.js    # Block editor scripts
│   │   └── features/    # Feature modules
│   ├── views/           # Blade templates
│   │   ├── layouts/     # Layout templates
│   │   ├── partials/    # Reusable partials
│   │   ├── sections/    # Self-contained sections
│   │   ├── components/  # UI components
│   │   └── forms/       # Form templates
│   ├── fonts/           # Web fonts
│   └── images/          # Images
├── public/              # Built assets (git-ignored)
├── vendor/              # Composer packages (git-ignored)
├── node_modules/        # NPM packages (git-ignored)
└── config files         # Configuration files
```

## 🎨 Working with Sections

Each section in `resources/views/sections/` is self-contained with inline styles and scripts:

```blade
{{-- resources/views/sections/hero/hero.blade.php --}}
<section class="hero-section">
  <!-- HTML structure -->
</section>

<style>
  /* Section-specific CSS */
  .hero-section {
    /* Styles here */
  }
</style>

<script>
  // Section-specific JavaScript
  document.addEventListener('alpine:init', () => {
    // Alpine.js components
  });
</script>
```

## 🔧 Available Scripts

```bash
# Development
npm run dev              # Start development server with HMR
npm run preview          # Preview production build

# Building
npm run build           # Production build
npm run build:analyze   # Build with bundle analyzer
npm run clean          # Clean build directory

# Linting
npm run lint           # Lint JavaScript files
npm run lint:fix       # Auto-fix linting issues

# Translations
npm run translate      # Generate POT file and update PO files
npm run translate:compile  # Compile translations
```

## 🎯 CSS Architecture

The theme uses a modular CSS structure:

- **app.css** - Main stylesheet entry point
- **core/** - Core design system
  - `animation.css` - Animation utilities
  - `color.css` - Color system
  - `spacing.css` - Spacing scales
  - `typography.css` - Typography system
  - `utilities.css` - Custom utilities
- **dom/** - DOM-specific styles
  - `body.css` - Body styles
  - `loading.css` - Loading states
  - `scrollbar.css` - Custom scrollbars
  - `theme-toggle.css` - Theme switcher

## 🚀 Performance Features

- **Image Optimization**: Automatic WebP/AVIF conversion
- **Code Splitting**: Smart chunking for optimal loading
- **Compression**: Brotli and Gzip compression
- **Tree Shaking**: Removes unused code
- **Critical CSS**: Inline critical styles
- **Lazy Loading**: Images and components
- **Service Worker**: Offline support and caching

## 🔌 Included Libraries

- **Alpine.js** (3.14.x) - Reactive framework
  - Collapse, Intersect, Focus, Persist plugins
- **Swiper** (11.x) - Touch slider
- **GLightbox** (3.x) - Lightbox gallery
- **AOS** (2.x) - Scroll animations
- **Typed.js** (2.x) - Typing animations
- **Flatpickr** (4.x) - Date picker

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This theme is open-source software licensed under the [MIT license](LICENSE).

## 🙏 Credits

- Built with [Sage](https://roots.io/sage/)
- Powered by [Laravel](https://laravel.com/)
- Styled with [Tailwind CSS](https://tailwindcss.com/)
- Interactive with [Alpine.js](https://alpinejs.dev/)

## 📞 Support

For issues and questions:
- [GitHub Issues](https://github.com/yourusername/blitz-theme/issues)
- [Documentation](https://roots.io/sage/docs/)
- [Community Forum](https://discourse.roots.io/)

---

Made with ❤️ using modern web technologies