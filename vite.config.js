import { defineConfig, loadEnv } from 'vite'
import tailwindcss from '@tailwindcss/vite'
import laravel from 'laravel-vite-plugin'
import { wordpressPlugin, wordpressThemeJson } from '@roots/vite-plugin'
import path from 'path'
import fs from 'fs'
import compression from 'vite-plugin-compression'
import imagemin from 'vite-plugin-imagemin'

// https://vitejs.dev/config/
export default defineConfig(({ command, mode }) => {
  // Load env file based on `mode` in the current working directory
  const env = loadEnv(mode, process.cwd(), '')
  const isProduction = mode === 'production'
  const isDevelopment = mode === 'development'
  const isAnalyze = mode === 'analyze'

  // Better base URL handling
  const baseUrl = env.VITE_BASE_URL || 
    (env.WP_HOME ? `${env.WP_HOME}/app/themes/blitz-theme/public/build/` : '/app/themes/blitz-theme/public/build/')

  return {
    base: baseUrl,

    plugins: [
      tailwindcss(),

      laravel({
        input: [
          'resources/css/app.css',
          'resources/js/app.js',
          'resources/css/editor.css',
          'resources/js/editor.js',
        ],
        refresh: [
          'app/**/*.php',
          'resources/views/**/*.php',
          'resources/**/*.js',
          'resources/**/*.css',
          'theme.json', // Added theme.json to refresh
        ],
      }),

      wordpressPlugin({
        // Additional WordPress-specific optimizations
        resolveBlockAssets: true,
        resolveViewAssets: true,
      }),

      // Generate the theme.json file
      wordpressThemeJson({
        disableTailwindColors: false,
        disableTailwindFonts: false,
        disableTailwindFontSizes: false,
        customSpacing: true,
        customProperties: true,
      }),

      // Image optimization - ENHANCED SETTINGS
      isProduction && imagemin({
        gifsicle: {
          optimizationLevel: 7,
          interlaced: false,
        },
        optipng: {
          optimizationLevel: 7,
        },
        mozjpeg: {
          quality: 75,
          progressive: true,
        },
        pngquant: {
          quality: [0.65, 0.8],
          speed: 4,
        },
        svgo: {
          plugins: [
            {
              name: 'removeViewBox',
              active: false,
            },
            {
              name: 'removeEmptyAttrs',
              active: false,
            },
            {
              name: 'removeDimensions',
              active: true, // Added for better SVG optimization
            },
            {
              name: 'removeScriptElement',
              active: true, // Security: remove scripts from SVGs
            },
            {
              name: 'removeStyleElement',
              active: false, // Keep styles if needed
            },
            {
              name: 'convertPathData',
              active: true, // Optimize path data
            },
            {
              name: 'convertTransform',
              active: true, // Optimize transforms
            },
          ],
        },
        // WebP conversion for modern browsers
        webp: {
          quality: 80,
          alphaQuality: 90,
          method: 6,
          lossless: false, // Added explicit setting
        },
        // AVIF for next-gen (even smaller than WebP)
        avif: {
          quality: 60,
          speed: 0,
          chromaSubsampling: '4:2:0', // Added for better compression
        },
      }),

      // Compression for all assets - ENHANCED
      isProduction && compression({
        algorithm: 'brotliCompress',
        ext: '.br',
        threshold: 1024,
        deleteOriginFile: false,
        compressionOptions: {
          level: 11, // Maximum compression for Brotli
        },
      }),

      isProduction && compression({
        algorithm: 'gzip',
        ext: '.gz',
        threshold: 1024,
        deleteOriginFile: false,
        compressionOptions: {
          level: 9, // Maximum compression for gzip
        },
      }),

      // Copy service worker to public directory - ENHANCED
      {
        name: 'copy-sw',
        writeBundle() {
          const swPath = path.resolve(__dirname, 'resources/js/sw.js')
          const destPath = path.resolve(__dirname, 'public/sw.js')

          if (fs.existsSync(swPath)) {
            const publicDir = path.dirname(destPath)
            if (!fs.existsSync(publicDir)) {
              fs.mkdirSync(publicDir, { recursive: true })
            }

            // Copy the service worker
            fs.copyFileSync(swPath, destPath)
            console.log('✅ Service Worker copied to public/sw.js')

            // Also generate a version file for cache busting
            const version = {
              version: Date.now(),
              build: isProduction ? 'production' : 'development'
            }
            fs.writeFileSync(
              path.resolve(__dirname, 'public/sw-version.json'),
              JSON.stringify(version)
            )
          } else {
            console.warn('⚠️ Service Worker not found at resources/js/sw.js')
          }
        }
      },

      // Bundle analyzer for analyze mode
      isAnalyze && {
        name: 'rollup-plugin-visualizer',
        async load() {
          const { visualizer } = await import('rollup-plugin-visualizer')
          return visualizer({
            open: true,
            filename: 'dist-stats.html',
            gzipSize: true,
            brotliSize: true,
          })
        }
      },
    ].filter(Boolean),

    resolve: {
      alias: {
        '@': path.resolve(__dirname, './resources'),
        '@scripts': path.resolve(__dirname, './resources/js'),
        '@styles': path.resolve(__dirname, './resources/css'),
        '@fonts': path.resolve(__dirname, './resources/fonts'),
        '@images': path.resolve(__dirname, './resources/images'),
        '@components': path.resolve(__dirname, './resources/js/components'),
        '@modules': path.resolve(__dirname, './resources/js/modules'),
        '@utils': path.resolve(__dirname, './resources/js/utils'),
        '@features': path.resolve(__dirname, './resources/js/features'), // Added features alias
        '@views': path.resolve(__dirname, './resources/views'), // Added views alias
      },
    },

    server: {
      // Development server configuration
      host: true, // Listen on all local IPs
      port: 3000,
      strictPort: false,
      cors: true,
      // Proxy configuration for WordPress development
      proxy: {
        // Adjust this based on your local WordPress URL
        '/wp-admin': {
          target: env.WP_HOME || 'http://localhost/blitz-theme',
          changeOrigin: true,
          secure: false,
        },
        '/wp-content': {
          target: env.WP_HOME || 'http://localhost/blitz-theme',
          changeOrigin: true,
          secure: false,
        },
        '/wp-includes': {
          target: env.WP_HOME || 'http://localhost/blitz-theme',
          changeOrigin: true,
          secure: false,
        },
        '/wp-json': {
          target: env.WP_HOME || 'http://localhost/blitz-theme',
          changeOrigin: true,
          secure: false,
        },
      },
      // HMR configuration
      hmr: {
        host: 'localhost',
        protocol: 'ws',
        port: 3000,
      },
      // Watch options for better performance
      watch: {
        usePolling: false,
        interval: 1000,
      },
    },

    css: {
      // Extract CSS for better caching in production
      extract: isProduction,
      // Source maps for development
      devSourcemap: isDevelopment,
      // PostCSS configuration handled by Tailwind
      postcss: {},
    },

    build: {
      // Output directory
      outDir: 'public/build',
      // Assets directory
      assetsDir: 'assets',
      // Generate source maps for production (hidden for security)
      sourcemap: isProduction ? 'hidden' : true,
      // Clean output directory before build
      emptyOutDir: true,
      // Minification settings
      minify: isProduction ? 'terser' : false,
      terserOptions: isProduction ? {
        compress: {
          drop_console: true,
          drop_debugger: true,
          pure_funcs: ['console.log', 'console.info', 'console.debug', 'console.trace'],
          passes: 2,
          ecma: 2018,
          module: true,
          toplevel: true,
        },
        format: {
          comments: false,
          ecma: 2018,
        },
        mangle: {
          safari10: true,
          toplevel: true,
          module: true,
        },
      } : undefined,
      // Target modern browsers for smaller bundles
      target: 'es2018',
      // Module preload polyfill
      modulePreload: {
        polyfill: true,
      },
      // Rollup options
      rollupOptions: {
        output: {
          // Asset naming patterns
          assetFileNames: (assetInfo) => {
            const info = assetInfo.name.split('.')
            const ext = info[info.length - 1]
            if (/png|jpe?g|svg|gif|tiff|bmp|ico|webp|avif/i.test(ext)) {
              return `assets/images/[name]-[hash][extname]`
            } else if (/woff2?|ttf|otf|eot/i.test(ext)) {
              return `assets/fonts/[name]-[hash][extname]`
            } else if (/css/i.test(ext)) {
              return `assets/css/[name]-[hash][extname]`
            }
            return `assets/[name]-[hash][extname]`
          },
          chunkFileNames: 'assets/js/[name]-[hash].js',
          entryFileNames: 'assets/js/[name]-[hash].js',
          // Manual chunks for optimal code splitting
          manualChunks: (id) => {
            // Node modules chunking strategy
            if (id.includes('node_modules')) {
              // Navigation enhancement module
              if (id.includes('navigation-enhancement')) {
                return 'navigation-enhancer'
              }
              // Alpine.js and plugins - ENHANCED
              if (id.includes('alpinejs')) {
                if (id.includes('@alpinejs/collapse')) return 'alpine-collapse'
                if (id.includes('@alpinejs/intersect')) return 'alpine-intersect'
                if (id.includes('@alpinejs/focus')) return 'alpine-focus'
                if (id.includes('@alpinejs/persist')) return 'alpine-persist'
                return 'alpine-core'
              }
              // Animation libraries
              if (id.includes('aos')) return 'vendor-aos'
              if (id.includes('typed.js')) return 'vendor-typed'
              // UI components
              if (id.includes('glightbox')) return 'vendor-glightbox'
              if (id.includes('swiper')) return 'vendor-swiper'
              // Calendar/Booking
              if (id.includes('flatpickr')) return 'vendor-flatpickr'
              if (id.includes('cal.com')) return 'vendor-cal'
              // All other vendor code
              return 'vendor-misc'
            }
            // Application code chunking
            if (id.includes('resources/js/features')) {
              return 'features'
            }
            if (id.includes('resources/js/modules')) {
              return 'modules'
            }
            if (id.includes('resources/js/components')) {
              return 'components'
            }
            if (id.includes('resources/js/utils')) {
              return 'utils'
            }
          },
        },
        // Tree-shaking options for smaller bundles
        treeshake: {
          moduleSideEffects: false,
          propertyReadSideEffects: false,
          tryCatchDeoptimization: false,
          preset: 'smallest', // Most aggressive tree-shaking
        },
        // External dependencies (if needed for CDN)
        external: [],
      },
      // Enable CSS code splitting
      cssCodeSplit: true,
      // Assets inlining threshold (4kb)
      assetsInlineLimit: 4096,
      // Chunk size warnings
      chunkSizeWarningLimit: 1000,
      // Don't report compressed size (faster builds)
      reportCompressedSize: false,
    },

    optimizeDeps: {
      // Include dependencies that need pre-bundling
      include: [
        'alpinejs',
        '@alpinejs/collapse',
        '@alpinejs/intersect',
        '@alpinejs/focus', // Added if you use it
        '@alpinejs/persist', // Added if you use it
        'aos',
        'glightbox',
        'swiper',
        'typed.js',
        'flatpickr',
      ],
      // Exclude WordPress dependencies
      exclude: [
        '@wordpress/block-editor',
        '@wordpress/blocks',
        '@wordpress/components',
      ],
      // Force optimize on cold start
      force: isDevelopment,
    },

    // Performance optimizations
    esbuild: {
      // Drop console and debugger in production
      drop: isProduction ? ['console', 'debugger'] : [],
      // Legal comments
      legalComments: 'none',
      // Target
      target: 'es2018',
      // Format
      format: 'esm',
      // Keep names for better debugging
      keepNames: !isProduction,
    },

    // Preview server configuration
    preview: {
      port: 4173,
      strictPort: true,
      host: true,
      cors: true,
    },

    // Define global constants
    define: {
      'process.env.NODE_ENV': JSON.stringify(mode),
      '__DEV__': !isProduction,
      '__PROD__': isProduction,
      '__ANALYZE__': isAnalyze,
      '__BUILD_TIME__': JSON.stringify(new Date().toISOString()),
    },

    // Worker options
    worker: {
      format: 'es',
      rollupOptions: {
        output: {
          entryFileNames: 'assets/workers/[name]-[hash].js',
        },
      },
    },
  }
})