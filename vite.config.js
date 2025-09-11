import { defineConfig, loadEnv } from 'vite'
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin'
import { wordpressPlugin, wordpressThemeJson } from '@roots/vite-plugin';
import path from 'path'
import fs from 'fs'
import compression from 'vite-plugin-compression';
import imagemin from 'vite-plugin-imagemin';

// https://vitejs.dev/config/
export default defineConfig(({ command, mode }) => {
  // Load env file based on `mode` in the current working directory.
  const env = loadEnv(mode, process.cwd(), '')
  const isProduction = mode === 'production'
  
  return {
    base: env.VITE_BASE_URL || '/app/themes/blitz-theme/public/build/',
    
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

      // Image optimization - BEST SETTINGS (KEEPING ORIGINAL)
      imagemin({
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
          ],
        },
        // WebP conversion for modern browsers
        webp: {
          quality: 80,
          alphaQuality: 90,
          method: 6,
        },
        // AVIF for next-gen (even smaller than WebP)
        avif: {
          quality: 60,
          speed: 0,
        },
      }),

      // Compression for all assets
      compression({
        algorithm: 'brotliCompress',
        ext: '.br',
        threshold: 1024,
      }),
      compression({
        algorithm: 'gzip',
        ext: '.gz',
        threshold: 1024,
      }),
      
      // Copy service worker to public directory
      {
        name: 'copy-sw',
        writeBundle() {
          // Check if service worker exists before copying
          const swPath = path.resolve(__dirname, 'resources/js/sw.js');
          const destPath = path.resolve(__dirname, 'public/sw.js');
          
          if (fs.existsSync(swPath)) {
            // Create public directory if it doesn't exist
            const publicDir = path.dirname(destPath);
            if (!fs.existsSync(publicDir)) {
              fs.mkdirSync(publicDir, { recursive: true });
            }
            
            // Copy the service worker
            fs.copyFileSync(swPath, destPath);
            console.log('✅ Service Worker copied to public/sw.js');
          } else {
            console.warn('⚠️ Service Worker not found at resources/js/sw.js');
          }
        }
      },
    ],
    
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
        '/wp-admin': env.WP_HOME || 'http://localhost',
        '/wp-content': env.WP_HOME || 'http://localhost',
        '/wp-includes': env.WP_HOME || 'http://localhost',
      },
      // HMR configuration
      hmr: {
        host: 'localhost',
        protocol: 'ws',
      },
    },
    
    css: {
      // Extract CSS for better caching in production
      extract: isProduction,
    },
    
    build: {
      // Output directory
      outDir: 'public/build',
      // Assets directory
      assetsDir: 'assets',
      // Generate source maps for production (hidden for security)
      sourcemap: isProduction ? 'hidden' : true,
      // Minification settings
      minify: isProduction ? 'terser' : false,
      terserOptions: {
        compress: {
          drop_console: isProduction,
          drop_debugger: isProduction,
          pure_funcs: isProduction ? ['console.log', 'console.info'] : [],
        },
        format: {
          comments: false,
        },
      },
      // Target modern browsers for smaller bundles
      target: 'es2018',
      // Rollup options
      rollupOptions: {
        output: {
          // Asset naming patterns (KEEPING ORIGINAL)
          assetFileNames: (assetInfo) => {
            const info = assetInfo.name.split('.')
            const ext = info[info.length - 1]
            if (/png|jpe?g|svg|gif|tiff|bmp|ico|webp|avif/i.test(ext)) {
              return `assets/images/[name]-[hash][extname]`
            } else if (/woff2?|ttf|otf|eot/i.test(ext)) {
              return `assets/fonts/[name]-[hash][extname]`
            }
            return `assets/[name]-[hash][extname]`
          },
          chunkFileNames: 'assets/js/[name]-[hash].js',
          entryFileNames: 'assets/js/[name]-[hash].js',
          // Manual chunks for optimal code splitting (KEEPING ORIGINAL LOGIC)
          manualChunks: (id) => {
            // Node modules chunking strategy
            if (id.includes('node_modules')) {
              // Navigation enhancement module
              if (id.includes('navigation-enhancement')) {
                return 'navigation-enhancer'
              }
              // Alpine.js and plugins
              if (id.includes('alpinejs') || id.includes('@alpinejs')) {
                return 'vendor-alpine'
              }
              // Animation libraries
              if (id.includes('aos') || id.includes('typed.js')) {
                return 'vendor-animation'
              }
              // UI components (Swiper, GLightbox, etc.)
              if (id.includes('glightbox') || id.includes('swiper')) {
                return 'vendor-ui'
              }
              // Calendar/Booking (Flatpickr, Cal.com)
              if (id.includes('flatpickr') || id.includes('cal.com')) {
                return 'vendor-booking'
              }
              // All other vendor code
              return 'vendor-misc'
            }
            // Application code chunking
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
        },
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
      // Include dependencies that need pre-bundling (KEEPING ORIGINAL)
      include: [
        'alpinejs',
        '@alpinejs/collapse',
        '@alpinejs/intersect',
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
    },
    
    // Performance optimizations
    esbuild: {
      // Drop console and debugger in production
      drop: isProduction ? ['console', 'debugger'] : [],
      // Legal comments
      legalComments: 'none',
      // Target
      target: 'es2018',
    },
    
    // Preview server configuration
    preview: {
      port: 4173,
      strictPort: true,
      host: true,
    },
    
    // Define global constants
    define: {
      'process.env.NODE_ENV': JSON.stringify(mode),
      '__DEV__': !isProduction,
      '__PROD__': isProduction,
    },
  }
})