<?php

namespace App\Providers;

use Roots\Acorn\Sage\SageServiceProvider;
use App\Services\BlitzThemeService;
use App\Services\SeoService;
use App\Services\PerformanceService;

class ThemeServiceProvider extends SageServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        
        // Register theme-specific services
        $this->app->singleton('blitz.theme', function ($app) {
            return new BlitzThemeService();
        });
        
        // Register SEO service
        $this->app->singleton('blitz.seo', function ($app) {
            return new SeoService();
        });
        
        // Register performance service
        $this->app->singleton('blitz.performance', function ($app) {
            return new PerformanceService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        
        // Boot theme services
        $this->bootThemeServices();
        
        // Boot SEO enhancements
        $this->bootSeoEnhancements();
        
        // Boot performance optimizations
        $this->bootPerformanceOptimizations();
        
        // Boot security enhancements
        $this->bootSecurityEnhancements();
        
        // Boot accessibility features
        $this->bootAccessibilityFeatures();
        
        // Boot customizer settings
        $this->bootCustomizerSettings();
        
        // Register custom blocks
        $this->registerBlocks();
    }

    /**
     * Boot theme-specific services.
     */
    protected function bootThemeServices()
    {
        // Custom post types
        add_action('init', [$this, 'registerCustomPostTypes']);
        add_action('init', [$this, 'registerCustomTaxonomies']);
        
        // Admin enhancements
        add_action('admin_init', [$this, 'enhanceAdminInterface']);
        
        // Clear cache on theme switch
        add_action('after_switch_theme', function() {
            $this->app->make('blitz.theme')->clearCache();
        });
    }

    /**
     * Boot SEO enhancements.
     */
    protected function bootSeoEnhancements()
    {
        $seoService = $this->app->make('blitz.seo');
        
        // Only add SEO features if enabled
        add_action('wp_head', function() use ($seoService) {
            $themeService = $this->app->make('blitz.theme');
            
            if ($themeService->isFeatureEnabled('open_graph')) {
                echo $seoService->generateOpenGraphTags() . "\n";
                echo $seoService->generateTwitterCardTags() . "\n";
            }
            
            if ($themeService->isFeatureEnabled('schema')) {
                $schema = $seoService->getSchemaData();
                if ($schema) {
                    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
                }
            }
            
            // Always add canonical and meta description
            echo '<link rel="canonical" href="' . esc_url($seoService->getCanonicalUrl()) . '">' . "\n";
            echo '<meta name="description" content="' . esc_attr($seoService->getMetaDescription()) . '">' . "\n";
        }, 5);
    }

    /**
     * Boot performance optimizations.
     */
    protected function bootPerformanceOptimizations()
    {
        $performanceService = $this->app->make('blitz.performance');
        
        // Optimize queries
        add_action('pre_get_posts', [$performanceService, 'optimizeQueries']);
        
        // Remove unnecessary features
        add_action('init', [$performanceService, 'removeUnnecessaryFeatures']);
        
        // Add resource hints
        add_action('wp_head', function() use ($performanceService) {
            $hints = $performanceService->getResourceHints();
            
            foreach ($hints['dns-prefetch'] ?? [] as $url) {
                echo '<link rel="dns-prefetch" href="' . esc_url($url) . '">' . "\n";
            }
            
            foreach ($hints['preconnect'] ?? [] as $url) {
                echo '<link rel="preconnect" href="' . esc_url($url) . '" crossorigin>' . "\n";
            }
        }, 2);
        
        // Add speculation rules
        add_action('wp_head', function() use ($performanceService) {
            $rules = $performanceService->generateSpeculationRules();
            
            if (!empty($rules['prerender']) || !empty($rules['prefetch'])) {
                echo '<script type="speculationrules">' . "\n";
                echo json_encode($rules, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                echo '</script>' . "\n";
            }
        }, 15);
        
        // Add Web Vitals tracking
        add_action('wp_footer', function() use ($performanceService) {
            echo '<script>' . $performanceService->getWebVitalsScript() . '</script>';
        }, 100);
        
        // Optimize image attributes
        add_filter('wp_get_attachment_image_attributes', [$performanceService, 'optimizeImageAttributes'], 10, 2);
        
        // Add cache headers
        add_action('send_headers', function() use ($performanceService) {
            if (!is_admin()) {
                $headers = $performanceService->getCacheHeaders();
                foreach ($headers as $key => $value) {
                    header("{$key}: {$value}");
                }
            }
        });
    }

    /**
     * Boot security enhancements.
     */
    protected function bootSecurityEnhancements()
    {
        // Add security headers
        add_action('send_headers', function() {
            if (!is_admin()) {
                header('X-Content-Type-Options: nosniff');
                header('X-Frame-Options: SAMEORIGIN');
                header('X-XSS-Protection: 1; mode=block');
                header('Referrer-Policy: strict-origin-when-cross-origin');
                
                if (is_ssl()) {
                    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
                }
            }
        });
        
        // Hide login errors
        add_filter('login_errors', function() {
            return __('Invalid credentials.', 'blitz');
        });
        
        // Disable file editing in admin
        if (!defined('DISALLOW_FILE_EDIT')) {
            define('DISALLOW_FILE_EDIT', true);
        }
    }

    /**
     * Boot accessibility features.
     */
    protected function bootAccessibilityFeatures()
    {
        // Add skip links
        add_action('wp_body_open', function() {
            echo '<a class="skip-link screen-reader-text" href="#main">' . __('Skip to content', 'blitz') . '</a>' . "\n";
            echo '<a class="skip-link screen-reader-text" href="#footer">' . __('Skip to footer', 'blitz') . '</a>' . "\n";
        });
        
        // Add ARIA attributes to menu links
        add_filter('nav_menu_link_attributes', function($atts, $item, $args, $depth) {
            if ($depth === 0 && in_array('menu-item-has-children', $item->classes)) {
                $atts['aria-haspopup'] = 'true';
                $atts['aria-expanded'] = 'false';
            }
            return $atts;
        }, 10, 4);
    }

    /**
     * Boot customizer settings
     */
    protected function bootCustomizerSettings()
    {
        add_action('customize_register', [$this, 'registerCustomizerSettings']);
    }

    /**
     * Register customizer settings
     */
    public function registerCustomizerSettings($wp_customize)
    {
        // Theme Options Section
        $wp_customize->add_section('blitz_theme_options', [
            'title' => __('Blitz Theme Options', 'blitz'),
            'priority' => 35,
        ]);
        
        // Default theme mode
        $wp_customize->add_setting('default_theme', [
            'default' => 'auto',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('default_theme', [
            'label' => __('Default Theme Mode', 'blitz'),
            'section' => 'blitz_theme_options',
            'type' => 'select',
            'choices' => [
                'auto' => __('Auto (Follow System)', 'blitz'),
                'light' => __('Light Mode', 'blitz'),
                'dark' => __('Dark Mode', 'blitz'),
            ],
        ]);
        
        // Show theme toggle
        $wp_customize->add_setting('show_theme_toggle', [
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ]);
        
        $wp_customize->add_control('show_theme_toggle', [
            'label' => __('Show Theme Toggle Button', 'blitz'),
            'section' => 'blitz_theme_options',
            'type' => 'checkbox',
        ]);
        
        // Performance Section
        $wp_customize->add_section('blitz_performance', [
            'title' => __('Performance', 'blitz'),
            'priority' => 50,
        ]);
        
        // Enable lazy loading
        $wp_customize->add_setting('enable_lazy_loading', [
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ]);
        
        $wp_customize->add_control('enable_lazy_loading', [
            'label' => __('Enable Lazy Loading', 'blitz'),
            'section' => 'blitz_performance',
            'type' => 'checkbox',
        ]);
        
        // Enable speculation rules
        $wp_customize->add_setting('enable_speculation_rules', [
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ]);
        
        $wp_customize->add_control('enable_speculation_rules', [
            'label' => __('Enable Speculation Rules (Prefetch/Prerender)', 'blitz'),
            'section' => 'blitz_performance',
            'type' => 'checkbox',
        ]);
        
        // Enable Web Vitals
        $wp_customize->add_setting('enable_web_vitals', [
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ]);
        
        $wp_customize->add_control('enable_web_vitals', [
            'label' => __('Enable Web Vitals Tracking', 'blitz'),
            'section' => 'blitz_performance',
            'type' => 'checkbox',
        ]);
        
        // SEO Section
        $wp_customize->add_section('blitz_seo', [
            'title' => __('SEO', 'blitz'),
            'priority' => 55,
        ]);
        
        // Enable Schema
        $wp_customize->add_setting('enable_schema', [
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ]);
        
        $wp_customize->add_control('enable_schema', [
            'label' => __('Enable Schema.org Structured Data', 'blitz'),
            'section' => 'blitz_seo',
            'type' => 'checkbox',
        ]);
        
        // Enable Open Graph
        $wp_customize->add_setting('enable_open_graph', [
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ]);
        
        $wp_customize->add_control('enable_open_graph', [
            'label' => __('Enable Open Graph & Twitter Cards', 'blitz'),
            'section' => 'blitz_seo',
            'type' => 'checkbox',
        ]);
        
        // Contact Information Section
        $wp_customize->add_section('blitz_contact_info', [
            'title' => __('Contact Information', 'blitz'),
            'priority' => 40,
        ]);
        
        // Phone number
        $wp_customize->add_setting('contact_phone', [
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('contact_phone', [
            'label' => __('Phone Number', 'blitz'),
            'section' => 'blitz_contact_info',
            'type' => 'text',
        ]);
        
        // WhatsApp number
        $wp_customize->add_setting('whatsapp_number', [
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('whatsapp_number', [
            'label' => __('WhatsApp Number', 'blitz'),
            'section' => 'blitz_contact_info',
            'type' => 'text',
            'description' => __('Include country code (e.g., +1234567890)', 'blitz'),
        ]);
        
        // Email
        $wp_customize->add_setting('contact_email', [
            'default' => get_option('admin_email'),
            'sanitize_callback' => 'sanitize_email',
        ]);
        
        $wp_customize->add_control('contact_email', [
            'label' => __('Contact Email', 'blitz'),
            'section' => 'blitz_contact_info',
            'type' => 'email',
        ]);
        
        // Address
        $wp_customize->add_setting('contact_address', [
            'default' => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ]);
        
        $wp_customize->add_control('contact_address', [
            'label' => __('Address', 'blitz'),
            'section' => 'blitz_contact_info',
            'type' => 'textarea',
        ]);
        
        // Social Media Section
        $wp_customize->add_section('blitz_social_media', [
            'title' => __('Social Media', 'blitz'),
            'priority' => 45,
        ]);
        
        $social_platforms = [
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'twitter' => 'Twitter',
            'linkedin' => 'LinkedIn',
            'youtube' => 'YouTube',
            'tiktok' => 'TikTok',
        ];
        
        foreach ($social_platforms as $platform => $label) {
            $wp_customize->add_setting("social_{$platform}", [
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ]);
            
            $wp_customize->add_control("social_{$platform}", [
                'label' => __($label . ' URL', 'blitz'),
                'section' => 'blitz_social_media',
                'type' => 'url',
            ]);
        }
        
        // Twitter handle for Twitter Cards
        $wp_customize->add_setting('twitter_handle', [
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('twitter_handle', [
            'label' => __('Twitter Handle (without @)', 'blitz'),
            'section' => 'blitz_social_media',
            'type' => 'text',
            'description' => __('Used for Twitter Card tags', 'blitz'),
        ]);

        // Header Section
        $wp_customize->add_section('header_settings', [
            'title' => __('Header Settings', 'blitz'),
            'priority' => 30,
        ]);

        // Show/hide elements
        $wp_customize->add_setting('header_show_search', ['default' => true]);
        $wp_customize->add_control('header_show_search', [
            'label' => __('Show Search', 'blitz'),
            'section' => 'header_settings',
            'type' => 'checkbox',
        ]);

        // CTA Button
        $wp_customize->add_setting('header_cta_text', ['default' => 'Book Now']);
        $wp_customize->add_control('header_cta_text', [
            'label' => __('CTA Button Text', 'blitz'),
            'section' => 'header_settings',
            'type' => 'text',
        ]);

        $wp_customize->add_setting('header_cta_url', ['default' => '/contact']);
        $wp_customize->add_control('header_cta_url', [
            'label' => __('CTA Button URL', 'blitz'),
            'section' => 'header_settings',
            'type' => 'text',
        ]);

        // Show tagline
        $wp_customize->add_setting('header_show_tagline', [
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ]);

        $wp_customize->add_control('header_show_tagline', [
            'label' => __('Show Site Tagline', 'blitz'),
            'section' => 'header_settings',
            'type' => 'checkbox',
        ]);

        // Show CTA button
        $wp_customize->add_setting('header_show_cta', [
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ]);

        $wp_customize->add_control('header_show_cta', [
            'label' => __('Show CTA Button', 'blitz'),
            'section' => 'header_settings',
            'type' => 'checkbox',
        ]);

        // Show WhatsApp
        $wp_customize->add_setting('header_show_whatsapp', [
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ]);

        $wp_customize->add_control('header_show_whatsapp', [
            'label' => __('Show WhatsApp Button', 'blitz'),
            'section' => 'header_settings',
            'type' => 'checkbox',
        ]);

        // Footer credits
        $wp_customize->add_setting('footer_credits', [
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ]);

        $wp_customize->add_control('footer_credits', [
            'label' => __('Footer Credits Text', 'blitz'),
            'section' => 'header_settings',
            'type' => 'text',
        ]);
    }

    /**
     * Register custom post types.
     */
    public function registerCustomPostTypes()
    {
        // Don't register here - moved to setup.php for proper timing
    }

    /**
     * Register custom taxonomies.
     */
    public function registerCustomTaxonomies()
    {
        // Don't register here - moved to setup.php for proper timing
    }

    /**
     * Enhance admin interface.
     */
    public function enhanceAdminInterface()
    {
        // Add custom admin styles
        add_action('admin_enqueue_scripts', function() {
            wp_enqueue_style(
                'blitz-admin',
                get_template_directory_uri() . '/resources/css/admin.css',
                [],
                wp_get_theme()->get('Version')
            );
        });

        // Remove unnecessary admin menu items for non-admin users
        if (!current_user_can('administrator')) {
            remove_menu_page('edit-comments.php');
        }
        
        // Add custom metaboxes
        add_action('add_meta_boxes', [$this, 'addCustomMetaboxes']);
        
        // Save metabox data
        add_action('save_post', [$this, 'saveCustomMetaboxes']);
    }

    /**
     * Add custom metaboxes
     */
    public function addCustomMetaboxes()
    {
        // Page options metabox
        add_meta_box(
            'page_options',
            __('Page Options', 'blitz'),
            [$this, 'renderPageOptionsMetabox'],
            ['page', 'post'],
            'side',
            'default'
        );
        
        // SEO metabox
        add_meta_box(
            'seo_options',
            __('SEO Options', 'blitz'),
            [$this, 'renderSeoMetabox'],
            ['page', 'post', 'service', 'portfolio'],
            'normal',
            'high'
        );
    }

    /**
     * Render page options metabox
     */
    public function renderPageOptionsMetabox($post)
    {
        wp_nonce_field('page_options_nonce', 'page_options_nonce');
        
        $show_toc = get_post_meta($post->ID, '_show_table_of_contents', true);
        $enable_sharing = get_post_meta($post->ID, '_enable_page_sharing', true);
        $show_bottom_cta = get_post_meta($post->ID, '_show_bottom_cta', true);
        ?>
        <div class="page-options-metabox">
            <p>
                <label>
                    <input type="checkbox" name="show_table_of_contents" value="1" <?php checked($show_toc, '1'); ?>>
                    <?php _e('Show Table of Contents', 'blitz'); ?>
                </label>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="enable_page_sharing" value="1" <?php checked($enable_sharing, '1'); ?>>
                    <?php _e('Enable Page Sharing', 'blitz'); ?>
                </label>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="show_bottom_cta" value="1" <?php checked($show_bottom_cta, '1'); ?>>
                    <?php _e('Show Bottom CTA', 'blitz'); ?>
                </label>
            </p>
        </div>
        <?php
    }

    /**
     * Render SEO metabox
     */
    public function renderSeoMetabox($post)
    {
        wp_nonce_field('seo_options_nonce', 'seo_options_nonce');
        
        $meta_description = get_post_meta($post->ID, '_meta_description', true);
        $og_image = get_post_meta($post->ID, '_og_image', true);
        ?>
        <div class="seo-options-metabox">
            <p>
                <label for="meta_description">
                    <?php _e('Meta Description', 'blitz'); ?>
                </label>
                <textarea 
                    id="meta_description" 
                    name="meta_description" 
                    rows="3" 
                    style="width: 100%;"
                    placeholder="<?php _e('Leave blank to auto-generate from content', 'blitz'); ?>"
                ><?php echo esc_textarea($meta_description); ?></textarea>
                <span class="description">
                    <?php _e('Recommended: 150-160 characters', 'blitz'); ?>
                </span>
            </p>
            <p>
                <label for="og_image">
                    <?php _e('Open Graph Image URL', 'blitz'); ?>
                </label>
                <input 
                    type="url" 
                    id="og_image" 
                    name="og_image" 
                    value="<?php echo esc_url($og_image); ?>" 
                    style="width: 100%;"
                    placeholder="<?php _e('Leave blank to use featured image', 'blitz'); ?>"
                >
                <span class="description">
                    <?php _e('Recommended size: 1200x630 pixels', 'blitz'); ?>
                </span>
            </p>
        </div>
        <?php
    }

    /**
     * Save custom metabox data
     */
    public function saveCustomMetaboxes($post_id)
    {
        // Check nonces
        $nonces = ['page_options_nonce', 'seo_options_nonce'];
        $valid_nonce = false;
        
        foreach ($nonces as $nonce) {
            if (isset($_POST[$nonce]) && wp_verify_nonce($_POST[$nonce], $nonce)) {
                $valid_nonce = true;
                break;
            }
        }
        
        if (!$valid_nonce) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Save page options
        if (isset($_POST['page_options_nonce'])) {
            update_post_meta($post_id, '_show_table_of_contents', 
                isset($_POST['show_table_of_contents']) ? '1' : '0');
            update_post_meta($post_id, '_enable_page_sharing', 
                isset($_POST['enable_page_sharing']) ? '1' : '0');
            update_post_meta($post_id, '_show_bottom_cta', 
                isset($_POST['show_bottom_cta']) ? '1' : '0');
        }
        
        // Save SEO options
        if (isset($_POST['seo_options_nonce'])) {
            if (isset($_POST['meta_description'])) {
                update_post_meta($post_id, '_meta_description', 
                    sanitize_textarea_field($_POST['meta_description']));
            }
            if (isset($_POST['og_image'])) {
                update_post_meta($post_id, '_og_image', 
                    esc_url_raw($_POST['og_image']));
            }
        }
    }

    /**
     * Auto-register all blade components in the sections directory
     */
    protected function registerBlocks()
    {
        $sectionsPath = resource_path('views/sections');
        
        if (!is_dir($sectionsPath)) {
            return;
        }
        
        // Scan the sections directory
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($sectionsPath)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                // Get the relative path from the sections folder
                $relativePath = str_replace(
                    [$sectionsPath . DIRECTORY_SEPARATOR, '.blade.php', DIRECTORY_SEPARATOR],
                    ['', '', '.'],
                    $file->getPathname()
                );
                
                // Convert to component name
                $componentName = basename($relativePath, '.blade');
                $viewPath = 'sections.' . str_replace('/', '.', dirname($relativePath)) . '.' . $componentName;
                
                // Register the component
                if (function_exists('\Blade')) {
                    \Blade::component($viewPath, 'sections.' . $componentName);
                }
            }
        }
    }
}