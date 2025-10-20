import { defineConfig, loadEnv } from 'vite'
import tailwindcss from '@tailwindcss/vite'
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

  return {
    // Use relative paths for WordPress theme compatibility
    base: command === 'serve' ? '/' : '/app/themes/blitz-theme/public/build/',

    plugins: [
      tailwindcss(),

      // WordPress plugin handles all theme integration
      wordpressPlugin({
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
          'theme.json',
        ],
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

      // Image optimization for production only
      isProduction && imagemin({
        gifsicle: {
          optimizationLevel: 7,
          interlaced: false,
        },
        optipng: {
          optimizationLevel: 7,
        },
        mozjpeg: {
          quality: 80,
          progressive: true,
        },
        pngquant: {
          quality: [0.7, 0.85],
          speed: 4,
        },
        svgo: {
          plugins: [
            {
              name: 'removeViewBox',
              active: false,
            },
            {
              name: 'removeScriptElement',
              active: true,
            },
            {
              name: 'convertPathData',
              active: true,
            },
          ],
        },
      }),

      // Brotli compression for production
      isProduction && compression({
        algorithm: 'brotliCompress',
        ext: '.br',
        threshold: 1024,
        deleteOriginFile: false,
        compressionOptions: {
          level: 11,
        },
      }),

      // Gzip compression for production
      isProduction && compression({
        algorithm: 'gzip',
        ext: '.gz',
        threshold: 1024,
        deleteOriginFile: false,
        compressionOptions: {
          level: 9,
        },
      }),

      // Copy service worker to public directory if it exists
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

            fs.copyFileSync(swPath, destPath)
            console.log('✅ Service Worker copied to public/sw.js')

            // Generate version file for cache busting
            const version = {
              version: Date.now(),
              build: isProduction ? 'production' : 'development'
            }
            fs.writeFileSync(
              path.resolve(__dirname, 'public/sw-version.json'),
              JSON.stringify(version)
            )
          }
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
        '@features': path.resolve(__dirname, './resources/js/features'),
        '@views': path.resolve(__dirname, './resources/views'),
      },
    },

    server: {
      host: true,
      port: 3000,
      strictPort: false,
      cors: true,
      hmr: {
        host: 'localhost',
        protocol: 'ws',
        port: 3000,
      },
      watch: {
        usePolling: false,
        interval: 1000,
      },
    },

    css: {
      devSourcemap: isDevelopment,
      postcss: {},
    },

    build: {
      outDir: 'public/build',
      assetsDir: 'assets',
      sourcemap: isProduction ? 'hidden' : true,
      emptyOutDir: true,
      minify: isProduction ? 'terser' : false,
      terserOptions: isProduction ? {
        compress: {
          drop_console: true,
          drop_debugger: true,
          pure_funcs: ['console.log', 'console.info', 'console.debug', 'console.trace'],
          passes: 2,
          ecma: 2020,
        },
        format: {
          comments: false,
          ecma: 2020,
        },
        mangle: {
          safari10: true,
        },
      } : undefined,
      target: 'es2020',
      modulePreload: {
        polyfill: true,
      },
      rollupOptions: {
        input: {
          app: path.resolve(__dirname, 'resources/js/app.js'),
          editor: path.resolve(__dirname, 'resources/js/editor.js'),
        },
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
            if (id.includes('node_modules')) {
              // Alpine.js and plugins
              if (id.includes('alpinejs')) {
                if (id.includes('@alpinejs/collapse')) return 'alpine-collapse'
                if (id.includes('@alpinejs/intersect')) return 'alpine-intersect'
                return 'alpine-core'
              }
              // Animation libraries
              if (id.includes('aos')) return 'vendor-aos'
              if (id.includes('typed.js')) return 'vendor-typed'
              // UI components
              if (id.includes('glightbox')) return 'vendor-glightbox'
              if (id.includes('swiper')) return 'vendor-swiper'
              // Calendar
              if (id.includes('flatpickr')) return 'vendor-flatpickr'
              // All other vendor code
              return 'vendor-misc'
            }
            // Application code chunking
            if (id.includes('resources/js/features')) return 'features'
            if (id.includes('resources/js/modules')) return 'modules'
            if (id.includes('resources/js/components')) return 'components'
            if (id.includes('resources/js/utils')) return 'utils'
          },
        },
        treeshake: {
          moduleSideEffects: false,
          propertyReadSideEffects: false,
          preset: 'recommended',
        },
      },
      cssCodeSplit: true,
      assetsInlineLimit: 4096,
      chunkSizeWarningLimit: 1000,
      reportCompressedSize: false,
    },

    optimizeDeps: {
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
      force: isDevelopment,
    },

    esbuild: {
      drop: isProduction ? ['console', 'debugger'] : [],
      legalComments: 'none',
      target: 'es2020',
      format: 'esm',
      keepNames: !isProduction,
    },

    preview: {
      port: 4173,
      strictPort: true,
      host: true,
      cors: true,
    },

    define: {
      'process.env.NODE_ENV': JSON.stringify(mode),
      '__DEV__': !isProduction,
      '__PROD__': isProduction,
      '__BUILD_TIME__': JSON.stringify(new Date().toISOString()),
    },

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
