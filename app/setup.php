<?php

namespace App;

use Illuminate\Support\Facades\Vite;

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
     * Enable theme features
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
    add_theme_support('editor-styles');
    
    /**
     * Custom theme supports
     */
    add_theme_support('view-transitions');
    add_theme_support('dark-mode');
}, 20);

/**
 * Register theme sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
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
 * Enqueue theme assets - CSS and JS
 */
add_action('wp_enqueue_scripts', function () {
    // Use Vite to enqueue assets
    echo Vite::withEntryPoints([
        'resources/css/app.css',
        'resources/js/app.js'
    ])->toHtml();
    
    // Localize script configuration
    $theme_config = [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('blitz_nonce'),
        'homeUrl' => home_url(),
        'themeUrl' => get_template_directory_uri(),
        'isHome' => is_front_page(),
        'isSingle' => is_single(),
        'isPage' => is_page(),
        'pageId' => get_the_ID(),
        'features' => [
            'serviceWorker' => get_theme_mod('enable_service_worker', true),
            'speculationRules' => get_theme_mod('enable_speculation_rules', true),
            'viewTransitions' => get_theme_mod('enable_view_transitions', true),
            'webVitals' => get_theme_mod('enable_web_vitals', true),
            'darkMode' => get_theme_mod('enable_dark_mode', true),
        ],
        'contactInfo' => [
            'phone' => get_theme_mod('contact_phone', ''),
            'whatsapp' => get_theme_mod('whatsapp_number', ''),
            'email' => get_theme_mod('contact_email', get_option('admin_email')),
            'address' => get_theme_mod('contact_address', ''),
        ],
        'socialLinks' => [
            'facebook' => get_theme_mod('social_facebook', ''),
            'twitter' => get_theme_mod('social_twitter', ''),
            'instagram' => get_theme_mod('social_instagram', ''),
            'linkedin' => get_theme_mod('social_linkedin', ''),
            'youtube' => get_theme_mod('social_youtube', ''),
        ],
    ];
    
    wp_add_inline_script(
        'vite',
        'window.blitzConfig = ' . wp_json_encode($theme_config) . ';',
        'before'
    );
}, 100);

/**
 * Inject styles into the block editor
 */
add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/css/editor.css');
    $settings['styles'][] = ['css' => "@import url('{$style}')"];
    return $settings;
});

/**
 * Inject scripts into the block editor
 */
add_action('admin_head', function () {
    if (!get_current_screen()?->is_block_editor()) {
        return;
    }

    echo Vite::withEntryPoints(['resources/js/editor.js'])->toHtml();
});

/**
 * Use the generated theme.json file
 */
add_filter('theme_file_path', function ($path, $file) {
    return $file === 'theme.json'
        ? public_path('build/assets/theme.json')
        : $path;
}, 10, 2);

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
function get_social_links($platform = null) {
    $links = [
        'facebook' => get_theme_mod('social_facebook', ''),
        'twitter' => get_theme_mod('social_twitter', ''),
        'instagram' => get_theme_mod('social_instagram', ''),
        'linkedin' => get_theme_mod('social_linkedin', ''),
        'youtube' => get_theme_mod('social_youtube', ''),
    ];
    
    return $platform ? ($links[$platform] ?? '') : array_filter($links);
}

/**
 * Smart Speculation Rules with context awareness
 */
add_action('wp_head', function () {
    // Skip for admin users
    if (is_admin() || !get_theme_mod('enable_speculation_rules', true)) {
        return;
    }
    
    $rules = [
        'prerender' => [],
        'prefetch' => []
    ];
    
    // Homepage: Prerender primary menu items
    if (is_front_page()) {
        $menu_locations = get_nav_menu_locations();
        if (isset($menu_locations['primary_navigation'])) {
            $menu_items = wp_get_nav_menu_items($menu_locations['primary_navigation']);
            if ($menu_items) {
                foreach (array_slice($menu_items, 0, 3) as $item) {
                    $rules['prerender'][] = [
                        'source' => 'list',
                        'urls' => [$item->url]
                    ];
                }
            }
        }
    }
    
    // Blog posts: Prefetch next/prev posts
    if (is_single()) {
        $next_post = get_next_post();
        $prev_post = get_previous_post();
        
        if ($next_post) {
            $rules['prefetch'][] = [
                'source' => 'list',
                'urls' => [get_permalink($next_post)]
            ];
        }
        if ($prev_post) {
            $rules['prefetch'][] = [
                'source' => 'list',
                'urls' => [get_permalink($prev_post)]
            ];
        }
    }
    
    // Archive pages: Prefetch pagination
    if (is_archive() || is_home()) {
        $next_link = get_next_posts_page_link();
        $prev_link = get_previous_posts_page_link();
        
        if ($next_link) {
            $rules['prefetch'][] = [
                'source' => 'list',
                'urls' => [$next_link]
            ];
        }
        if ($prev_link) {
            $rules['prefetch'][] = [
                'source' => 'list',
                'urls' => [$prev_link]
            ];
        }
    }
    
    // Output speculation rules
    if (!empty($rules['prerender']) || !empty($rules['prefetch'])) {
        echo '<script type="speculationrules">';
        echo wp_json_encode($rules, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        echo '</script>';
    }
}, 2);

/**
 * Add security headers
 */
add_action('send_headers', function () {
    if (is_admin()) {
        return;
    }
    
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
});