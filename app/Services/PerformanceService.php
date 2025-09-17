<?php

namespace App\Services;

class PerformanceService
{
    /**
     * Optimize WordPress queries
     */
    public function optimizeQueries($query): void
    {
        if (!is_admin() && $query->is_main_query()) {
            // Disable SQL_CALC_FOUND_ROWS for better performance
            if ($query->is_home() || $query->is_archive()) {
                $query->set('no_found_rows', true);
            }
            
            // Optimize search queries
            if ($query->is_search()) {
                $query->set('post_type', ['post', 'page', 'service', 'portfolio']);
                $query->set('posts_per_page', 12);
                $query->set('fields', 'ids'); // Get only IDs first
            }
            
            // Limit post meta queries
            if ($query->is_single()) {
                $query->set('update_post_meta_cache', false);
                $query->set('update_post_term_cache', false);
            }
        }
    }

    /**
     * Generate speculation rules based on context
     */
    public function generateSpeculationRules(): array
    {
        if (!app('blitz.theme')->isFeatureEnabled('speculation_rules')) {
            return [];
        }
        
        $rules = [
            'prerender' => [],
            'prefetch' => []
        ];
        
        // Homepage: Prerender primary navigation
        if (is_front_page()) {
            $menu_locations = get_nav_menu_locations();
            if (isset($menu_locations['primary_navigation'])) {
                $menu_items = wp_get_nav_menu_items($menu_locations['primary_navigation']);
                if ($menu_items) {
                    $priority_urls = [];
                    foreach (array_slice($menu_items, 0, 3) as $item) {
                        $priority_urls[] = $item->url;
                    }
                    if (!empty($priority_urls)) {
                        $rules['prerender'][] = [
                            'source' => 'list',
                            'urls' => $priority_urls
                        ];
                    }
                }
            }
        }
        
        // Archive pages: Prefetch pagination
        if (is_archive() || is_home()) {
            $rules['prefetch'][] = [
                'where' => [
                    'selector_matches' => '.pagination a, .nav-links a'
                ],
                'eagerness' => 'moderate'
            ];
        }
        
        // Single posts: Prefetch related content
        if (is_single()) {
            $rules['prefetch'][] = [
                'where' => [
                    'selector_matches' => '.related-posts a, .post-navigation a'
                ],
                'eagerness' => 'conservative'
            ];
        }
        
        // Global prefetch rules
        $rules['prefetch'][] = [
            'where' => [
                'and' => [
                    ['or' => [
                        ['href_matches' => '/*'],
                        ['href_matches' => home_url() . '/*']
                    ]],
                    ['not' => ['href_matches' => '/wp-admin/*']],
                    ['not' => ['href_matches' => '/wp-login.php']],
                    ['not' => ['href_matches' => '*.pdf']],
                    ['not' => ['selector_matches' => '.no-prefetch']],
                    ['not' => ['selector_matches' => '[download]']],
                    ['not' => ['selector_matches' => '[target="_blank"]']]
                ]
            ],
            'eagerness' => 'conservative'
        ];
        
        return $rules;
    }

    /**
     * Generate cache control headers based on content type
     */
    public function getCacheHeaders(): array
    {
        $headers = [];
        
        if (is_page() && !is_page(['cart', 'checkout', 'account', 'contact'])) {
            // Static pages can be cached
            $headers['Cache-Control'] = 'public, max-age=3600, s-maxage=7200';
        } elseif (is_single()) {
            // Blog posts can be cached longer
            $headers['Cache-Control'] = 'public, max-age=7200, s-maxage=14400';
        } elseif (is_archive() || is_home()) {
            // Archives should be fresher
            $headers['Cache-Control'] = 'public, max-age=900, s-maxage=1800';
        } else {
            // Dynamic content shouldn't be cached
            $headers['Cache-Control'] = 'no-cache, must-revalidate, max-age=0';
        }
        
        return $headers;
    }

    /**
     * Get resource hints for optimal loading
     */
    public function getResourceHints(): array
    {
        $hints = [];
        
        // DNS prefetch for external domains
        $hints['dns-prefetch'] = [
            '//fonts.googleapis.com',
            '//fonts.gstatic.com',
        ];
        
        // Preconnect to important domains
        $hints['preconnect'] = [
            'https://fonts.googleapis.com',
            'https://fonts.gstatic.com',
        ];
        
        // Add CDN if configured
        $cdn_url = get_theme_mod('cdn_url', '');
        if ($cdn_url) {
            $hints['dns-prefetch'][] = '//' . parse_url($cdn_url, PHP_URL_HOST);
            $hints['preconnect'][] = $cdn_url;
        }
        
        return $hints;
    }

    /**
     * Get critical CSS for inline loading
     */
    public function getCriticalCss(): string
    {
        // This would typically load from a generated file
        // For now, return essential above-the-fold styles
        return '
            /* Critical CSS */
            :root {
                --color-primary: #3b82f6;
                --color-background: #ffffff;
                --color-text: #1a1a1a;
            }
            
            @media (prefers-color-scheme: dark) {
                :root {
                    --color-background: #1a1a1a;
                    --color-text: #ffffff;
                }
            }
            
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                background: var(--color-background);
                color: var(--color-text);
                font-family: system-ui, -apple-system, sans-serif;
                line-height: 1.6;
            }
            
            .container {
                max-width: 1280px;
                margin: 0 auto;
                padding: 0 1rem;
            }
            
            /* Prevent layout shift */
            img {
                max-width: 100%;
                height: auto;
            }
            
            /* Loading states */
            .skeleton {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: loading 1.5s infinite;
            }
            
            @keyframes loading {
                0% { background-position: 200% 0; }
                100% { background-position: -200% 0; }
            }
        ';
    }

    /**
     * Generate Web Vitals tracking script
     */
    public function getWebVitalsScript(): string
    {
        if (!app('blitz.theme')->isFeatureEnabled('web_vitals')) {
            return '';
        }
        
        return "
        // Core Web Vitals monitoring
        if ('PerformanceObserver' in window) {
            // Largest Contentful Paint
            try {
                new PerformanceObserver((list) => {
                    const entries = list.getEntries();
                    const lastEntry = entries[entries.length - 1];
                    console.log('LCP:', lastEntry.renderTime || lastEntry.loadTime);
                    
                    // Send to analytics if available
                    if (window.gtag) {
                        gtag('event', 'web_vitals', {
                            'event_category': 'Web Vitals',
                            'event_label': 'LCP',
                            'value': Math.round(lastEntry.renderTime || lastEntry.loadTime)
                        });
                    }
                }).observe({ type: 'largest-contentful-paint', buffered: true });
            } catch (e) {}
            
            // First Input Delay
            try {
                new PerformanceObserver((list) => {
                    const entries = list.getEntries();
                    entries.forEach((entry) => {
                        const fid = entry.processingStart - entry.startTime;
                        console.log('FID:', fid);
                        
                        if (window.gtag) {
                            gtag('event', 'web_vitals', {
                                'event_category': 'Web Vitals',
                                'event_label': 'FID',
                                'value': Math.round(fid)
                            });
                        }
                    });
                }).observe({ type: 'first-input', buffered: true });
            } catch (e) {}
            
            // Cumulative Layout Shift
            try {
                let cls = 0;
                new PerformanceObserver((list) => {
                    for (const entry of list.getEntries()) {
                        if (!entry.hadRecentInput) {
                            cls += entry.value;
                            console.log('CLS:', cls);
                        }
                    }
                }).observe({ type: 'layout-shift', buffered: true });
            } catch (e) {}
        }
        ";
    }

    /**
     * Check if lazy loading should be enabled
     */
    public function shouldLazyLoad(): bool
    {
        return app('blitz.theme')->isFeatureEnabled('lazy_loading') && !is_admin();
    }

    /**
     * Optimize image attributes
     */
    public function optimizeImageAttributes(array $attr, $attachment = null): array
    {
        if ($this->shouldLazyLoad()) {
            // Add loading="lazy" for non-critical images
            if (!isset($attr['loading'])) {
                $attr['loading'] = 'lazy';
            }
            
            // Add decoding="async" for better performance
            if (!isset($attr['decoding'])) {
                $attr['decoding'] = 'async';
            }
        }
        
        // Add aspect ratio for layout stability
        if (isset($attr['width']) && isset($attr['height'])) {
            $ratio = $attr['height'] / $attr['width'];
            $attr['style'] = isset($attr['style']) 
                ? $attr['style'] . "; aspect-ratio: {$attr['width']}/{$attr['height']};"
                : "aspect-ratio: {$attr['width']}/{$attr['height']};";
        }
        
        return $attr;
    }

    /**
     * Get performance metrics
     */
    public function getMetrics(): array
    {
        return [
            'cache_enabled' => function_exists('wp_cache_get'),
            'gzip_enabled' => extension_loaded('zlib'),
            'opcache_enabled' => function_exists('opcache_get_status') && opcache_get_status()['opcache_enabled'] ?? false,
            'object_cache' => wp_using_ext_object_cache(),
            'php_version' => PHP_VERSION,
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'theme_optimized' => true,
        ];
    }

    /**
     * Remove unnecessary WordPress features
     */
    public function removeUnnecessaryFeatures(): void
    {
        // Remove emoji scripts
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
        
        // Remove oEmbed
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
        
        // Remove REST API links
        remove_action('wp_head', 'rest_output_link_wp_head');
        
        // Remove shortlink
        remove_action('wp_head', 'wp_shortlink_wp_head');
        
        // Remove RSD link
        remove_action('wp_head', 'rsd_link');
        
        // Remove Windows Live Writer manifest
        remove_action('wp_head', 'wlwmanifest_link');
        
        // Remove generator meta tag
        remove_action('wp_head', 'wp_generator');
        
        // Disable XML-RPC
        add_filter('xmlrpc_enabled', '__return_false');
        
        // Remove version from scripts and styles
        add_filter('style_loader_src', [$this, 'removeVersionFromUrl']);
        add_filter('script_loader_src', [$this, 'removeVersionFromUrl']);
    }

    /**
     * Remove version query string from URLs
     */
    public function removeVersionFromUrl(string $src): string
    {
        if (strpos($src, 'ver=')) {
            $src = remove_query_arg('ver', $src);
        }
        return $src;
    }
}