<?php

namespace App;

use Illuminate\Support\Facades\Vite;

/**
 * Enqueue theme assets - CSS and JS
 */
add_action('wp_enqueue_scripts', function () {
    // Use Vite to enqueue assets properly
    echo Vite::withEntryPoints([
        'resources/css/app.css',
        'resources/js/app.js'
    ])->toHtml();
    
    // Add inline script configuration AFTER Vite assets are loaded
    wp_add_inline_script('vite', '
        window.blitzConfig = ' . json_encode([
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('blitz_nonce'),
            'homeUrl' => home_url(),
            'isHome' => is_front_page(),
            'isSingle' => is_single(),
            'isPage' => is_page(),
            'pageId' => get_the_ID(),
            'contactInfo' => get_contact_info(),
            'socialLinks' => get_social_links(),
        ]) . ';'
    );
}, 100);

/**
 * Inject styles into the block editor.
 */
add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/css/editor.css');
    $settings['styles'][] = ['css' => "@import url('{$style}')"];
    return $settings;
});

/**
 * Inject scripts into the block editor.
 */
add_filter('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    $dependencies = json_decode(Vite::content('editor.deps.json'));

    foreach ($dependencies as $dependency) {
        if (! wp_script_is($dependency)) {
            wp_enqueue_script($dependency);
        }
    }

    echo Vite::withEntryPoints([
        'resources/js/editor.js',
    ])->toHtml();
});

/**
 * Use the generated theme.json file.
 */
add_filter('theme_file_path', function ($path, $file) {
    return $file === 'theme.json'
        ? public_path('build/assets/theme.json')
        : $path;
}, 10, 2);

/**
 * Register the initial theme setup.
 */
add_action('after_setup_theme', function () {
    /**
     * Register navigation menus
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'blitz'),
        'footer_navigation' => __('Footer Navigation', 'blitz'),
        'mobile_navigation' => __('Mobile Navigation', 'blitz'),
        'secondary_navigation' => __('Secondary Navigation', 'blitz'),
    ]);

    /**
     * Add custom image sizes
     */
    add_image_size('hero', 1920, 1080, true);
    add_image_size('card', 600, 400, true);
    add_image_size('testimonial', 150, 150, true);
    add_image_size('gallery', 800, 600, true);
    add_image_size('team', 400, 400, true);
    add_image_size('feature', 300, 200, true);

    /**
     * Enable features
     */
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('html5', [
        'caption', 'comment-form', 'comment-list', 
        'gallery', 'search-form', 'script', 'style',
    ]);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    
    /**
     * Add support for view transitions
     */
    add_theme_support('view-transitions');
    
    /**
     * Add theme support for dark mode
     */
    add_theme_support('dark-mode');
}, 20);

/**
 * Add theme customizer options - REMOVED FROM HERE, NOW IN ThemeServiceProvider
 */

/**
 * Helper function to get theme preference
 */
function get_theme_preference() {
    return get_theme_mod('default_theme', 'auto');
}

/**
 * Helper function to check if theme toggle should be shown
 */
function should_show_theme_toggle() {
    return get_theme_mod('show_theme_toggle', true);
}

/**
 * Helper function to get contact information
 */
function get_contact_info($field = null) {
    $info = [
        'phone' => get_theme_mod('contact_phone', ''),
        'whatsapp' => get_theme_mod('whatsapp_number', ''),
        'email' => get_theme_mod('contact_email', get_option('admin_email')),
        'address' => get_theme_mod('contact_address', ''),
    ];
    
    return $field ? ($info[$field] ?? '') : $info;
}

/**
 * Helper function to get social links
 */
function get_social_links() {
    $platforms = ['facebook', 'instagram', 'twitter', 'linkedin', 'youtube', 'tiktok'];
    $links = [];
    
    foreach ($platforms as $platform) {
        $url = get_theme_mod("social_{$platform}", '');
        if ($url) {
            $links[$platform] = $url;
        }
    }
    
    return $links;
}

/**
 * Add theme data attributes to body
 */
add_filter('body_class', function ($classes) {
    $default_theme = get_theme_preference();
    
    if ($default_theme !== 'auto') {
        $classes[] = 'theme-' . $default_theme;
    }
    
    $classes[] = 'blitz-theme';
    
    return $classes;
});

/**
 * Add theme meta tags to head
 */
add_action('wp_head', function () {
    ?>
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)">
    <?php
}, 5);

/**
 * Register custom post types
 */
add_action('init', function () {
    // Testimonials
    register_post_type('testimonial', [
        'labels' => [
            'name' => __('Testimonials', 'blitz'),
            'singular_name' => __('Testimonial', 'blitz'),
            'add_new_item' => __('Add New Testimonial', 'blitz'),
            'edit_item' => __('Edit Testimonial', 'blitz'),
        ],
        'public' => false,
        'show_ui' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'menu_icon' => 'dashicons-format-quote',
    ]);
    
    // Services/Products
    register_post_type('service', [
        'labels' => [
            'name' => __('Services', 'blitz'),
            'singular_name' => __('Service', 'blitz'),
            'add_new_item' => __('Add New Service', 'blitz'),
            'edit_item' => __('Edit Service', 'blitz'),
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'services'],
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon' => 'dashicons-admin-tools',
    ]);
    
    // Team Members
    register_post_type('team', [
        'labels' => [
            'name' => __('Team Members', 'blitz'),
            'singular_name' => __('Team Member', 'blitz'),
            'add_new_item' => __('Add New Team Member', 'blitz'),
            'edit_item' => __('Edit Team Member', 'blitz'),
        ],
        'public' => false,
        'show_ui' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'menu_icon' => 'dashicons-groups',
    ]);
    
    // Portfolio Items
    register_post_type('portfolio', [
        'labels' => [
            'name' => __('Portfolio', 'blitz'),
            'singular_name' => __('Portfolio Item', 'blitz'),
            'add_new_item' => __('Add New Portfolio Item', 'blitz'),
            'edit_item' => __('Edit Portfolio Item', 'blitz'),
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'portfolio'],
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon' => 'dashicons-portfolio',
    ]);
});

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="text-2xl font-heading font-bold mb-4">',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary Sidebar', 'blitz'),
        'id' => 'sidebar-primary',
    ] + $config);
    
    register_sidebar([
        'name' => __('Footer', 'blitz'),
        'id' => 'sidebar-footer',
    ] + $config);
});

/**
 * Enqueue theme assets
 */
add_action('wp_enqueue_scripts', function () {
    // Localize script for AJAX and configuration
    wp_localize_script('sage/app.js', 'blitzConfig', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('blitz_nonce'),
        'homeUrl' => home_url(),
        'isHome' => is_front_page(),
        'isSingle' => is_single(),
        'isPage' => is_page(),
        'pageId' => get_the_ID(),
        'contactInfo' => get_contact_info(),
        'socialLinks' => get_social_links(),
    ]);
}, 100);

/**
 * Smart Speculation Rules with context awareness
 */
add_action('wp_head', function () {
    // Skip for admin users and admin pages
    if (is_admin() || (is_user_logged_in() && current_user_can('manage_options'))) {
        return;
    }
    
    $rules = [
        'prerender' => [],
        'prefetch' => []
    ];
    
    /**
     * Context-aware prerendering based on page type
     */
    
    // Homepage: Prerender most likely navigation targets
    if (is_front_page()) {
        // Get primary menu items for intelligent prerendering
        $menu_locations = get_nav_menu_locations();
        if (isset($menu_locations['primary_navigation'])) {
            $menu_items = wp_get_nav_menu_items($menu_locations['primary_navigation']);
            if ($menu_items) {
                $priority_urls = [];
                foreach (array_slice($menu_items, 0, 3) as $item) { // First 3 menu items
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
    
    // Service/Product pages: Prerender CTA targets
    if (is_page() || is_singular(['service', 'portfolio'])) {
        $rules['prerender'][] = [
            'where' => [
                'selector_matches' => '.btn-primary, .cta-button, [data-prerender]'
            ],
            'eagerness' => 'moderate'
        ];
    }
    
    /**
     * Document-wide rules for intelligent prefetching
     */
    
    // Prefetch all internal navigation with smart filtering
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
                ['not' => ['href_matches' => '*.zip']],
                ['not' => ['selector_matches' => '.no-prefetch']],
                ['not' => ['selector_matches' => '[download]']],
                ['not' => ['selector_matches' => '[target="_blank"]']]
            ]
        ],
        'eagerness' => 'conservative'
    ];
    
    // Prerender high-priority elements on hover
    $rules['prerender'][] = [
        'where' => [
            'and' => [
                ['selector_matches' => '[data-priority="high"], .hero-cta, .main-cta'],
                ['not' => ['selector_matches' => '[data-no-prerender]']]
            ]
        ],
        'eagerness' => 'eager'
    ];
    
    // Output the speculation rules
    if (!empty($rules['prerender']) || !empty($rules['prefetch'])) {
        ?>
        <script type="speculationrules">
        <?php echo json_encode($rules, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
        </script>
        <?php
    }
}, 15);

/**
 * Add performance monitoring and optimization headers
 */
add_action('send_headers', function () {
    if (!is_admin()) {
        // Add performance hints
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        
        // Cache control based on content type
        if (is_page() && !is_page(['cart', 'checkout', 'account', 'contact'])) {
            // Static pages can be cached
            header('Cache-Control: public, max-age=3600, s-maxage=7200');
        } elseif (is_single()) {
            // Blog posts can be cached longer
            header('Cache-Control: public, max-age=7200, s-maxage=14400');
        } elseif (is_archive() || is_home()) {
            // Archives should be fresher
            header('Cache-Control: public, max-age=900, s-maxage=1800');
        } else {
            // Dynamic content shouldn't be cached
            header('Cache-Control: no-cache, must-revalidate, max-age=0');
        }
    }
});

/**
 * Web Vitals tracking
 */
add_action('wp_footer', function () {
    ?>
    <script>
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
    </script>
    <?php
}, 100);

/**
 * Register Blade components
 */
add_action('init', function () {
    if (function_exists('\Roots\view')) {
        \Roots\view()->composer('*', function ($view) {
            // Register global view data
        });
        
        // Register components namespace
        \Roots\view()->addNamespace('components', get_theme_file_path('resources/views/components'));
        \Roots\view()->addNamespace('partials', get_theme_file_path('resources/views/partials'));
        \Roots\view()->addNamespace('sections', get_theme_file_path('resources/views/sections'));
    }
});