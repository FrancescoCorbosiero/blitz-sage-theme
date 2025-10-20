<?php

namespace App\Providers;

use Roots\Acorn\Sage\SageServiceProvider;
use App\Services\BlitzThemeService;
use App\Services\SeoService;
use App\Services\PerformanceService;
use App\Patterns\ThemePatterns;

class ThemeServiceProvider extends SageServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        parent::register();
        
        $this->app->singleton('blitz.theme', function ($app) {
            return new BlitzThemeService();
        });
        
        $this->app->singleton('blitz.seo', function ($app) {
            return new SeoService();
        });
        
        $this->app->singleton('blitz.performance', function ($app) {
            return new PerformanceService();
        });

        // Register patterns
        new ThemePatterns();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();
        
        $this->bootThemeServices();
        $this->bootSeoEnhancements();
        $this->bootPerformanceOptimizations();
        $this->bootSecurityEnhancements();
        $this->bootAccessibilityFeatures();
        $this->bootCustomizerSettings();
        $this->registerBlocks();

        view()->composer(
            [
                'partials.widgets.navigation.menu-widget',
                'partials.widgets.navigation.*',
                'sections.header.*',
                'sections.footer.*'
            ],
            \App\View\Composers\MenuWidget::class
        );
    }

    /**
     * Boot theme-specific services.
     */
    protected function bootThemeServices(): void
    {
        add_action('init', [$this, 'registerCustomPostTypes']);
        add_action('init', [$this, 'registerCustomTaxonomies']);
        add_action('admin_init', [$this, 'enhanceAdminInterface']);
        add_action('admin_menu', [$this, 'addThemeOptionsPage']);
        
        add_action('after_switch_theme', function() {
            $this->app->make('blitz.theme')->clearCache();
        });
    }

    /**
     * Boot SEO enhancements.
     * FIXED: Uses correct method names
     */
    protected function bootSeoEnhancements(): void
    {
        $seoService = $this->app->make('blitz.seo');
        
        add_action('wp_head', function() use ($seoService) {
            $themeService = $this->app->make('blitz.theme');
            
            if ($themeService->isFeatureEnabled('open_graph')) {
                echo $seoService->generateOpenGraphTags() . "\n";
                echo $seoService->generateTwitterCardTags() . "\n";
            }
            
            if ($themeService->isFeatureEnabled('schema')) {
                $schema = $seoService->getSchemaData();
                if ($schema && !empty($schema)) {
                    echo '<script type="application/ld+json">' . 
                         wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . 
                         '</script>' . "\n";
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
    protected function bootPerformanceOptimizations(): void
    {
        $performanceService = $this->app->make('blitz.performance');
        
        add_action('pre_get_posts', [$performanceService, 'optimizeQueries']);
        add_filter('wp_lazy_loading_enabled', '__return_true');
        
        add_action('wp_head', function() use ($performanceService) {
            $hints = $performanceService->getResourceHints();
            
            foreach ($hints['dns-prefetch'] ?? [] as $url) {
                echo '<link rel="dns-prefetch" href="' . esc_url($url) . '">' . "\n";
            }
            
            foreach ($hints['preconnect'] ?? [] as $url) {
                echo '<link rel="preconnect" href="' . esc_url($url) . '" crossorigin>' . "\n";
            }
        }, 2);
    }

    /**
     * Boot security enhancements.
     */
    protected function bootSecurityEnhancements(): void
    {
        add_filter('xmlrpc_enabled', '__return_false');
        remove_action('wp_head', 'wp_generator');
        
        if (!defined('DISALLOW_FILE_EDIT')) {
            define('DISALLOW_FILE_EDIT', true);
        }
        
        add_filter('login_errors', function() {
            return __('Login failed. Please try again.', 'blitz');
        });
    }

    /**
     * Boot accessibility features.
     */
    protected function bootAccessibilityFeatures(): void
    {
        add_action('wp_body_open', function() {
            echo '<a href="#main-content" class="skip-link screen-reader-text">' . 
                 __('Skip to content', 'blitz') . '</a>';
        });
    }

    /**
     * Boot customizer settings.
     */
    protected function bootCustomizerSettings(): void
    {
        add_action('customize_register', function ($wp_customize) {
            // Theme Options
            $wp_customize->add_section('blitz_theme_options', [
                'title' => __('Theme Options', 'blitz'),
                'priority' => 30,
            ]);

            $wp_customize->add_setting('default_theme', [
                'default' => 'auto',
                'sanitize_callback' => function ($input) {
                    return in_array($input, ['light', 'dark', 'auto']) ? $input : 'auto';
                },
            ]);

            $wp_customize->add_control('default_theme', [
                'label' => __('Default Theme Mode', 'blitz'),
                'section' => 'blitz_theme_options',
                'type' => 'select',
                'choices' => [
                    'light' => __('Light', 'blitz'),
                    'dark' => __('Dark', 'blitz'),
                    'auto' => __('Auto', 'blitz'),
                ],
            ]);

            $wp_customize->add_setting('show_theme_toggle', [
                'default' => true,
                'sanitize_callback' => 'rest_sanitize_boolean',
            ]);

            $wp_customize->add_control('show_theme_toggle', [
                'label' => __('Show Theme Toggle Button', 'blitz'),
                'section' => 'blitz_theme_options',
                'type' => 'checkbox',
            ]);

            // Contact Info
            $wp_customize->add_section('blitz_contact_info', [
                'title' => __('Contact Information', 'blitz'),
                'priority' => 35,
            ]);

            $contact_fields = [
                'contact_email' => ['label' => 'Email', 'type' => 'email', 'default' => get_option('admin_email')],
                'contact_phone' => ['label' => 'Phone', 'type' => 'text', 'default' => ''],
                'whatsapp_number' => ['label' => 'WhatsApp', 'type' => 'text', 'default' => ''],
                'contact_address' => ['label' => 'Address', 'type' => 'textarea', 'default' => ''],
            ];

            foreach ($contact_fields as $key => $field) {
                $wp_customize->add_setting($key, [
                    'default' => $field['default'],
                    'sanitize_callback' => $field['type'] === 'email' ? 'sanitize_email' : 
                                          ($field['type'] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field'),
                ]);

                $wp_customize->add_control($key, [
                    'label' => __($field['label'], 'blitz'),
                    'section' => 'blitz_contact_info',
                    'type' => $field['type'],
                ]);
            }

            // Social Links
            $wp_customize->add_section('blitz_social_links', [
                'title' => __('Social Media', 'blitz'),
                'priority' => 40,
            ]);

            foreach (['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'] as $platform) {
                $wp_customize->add_setting("social_{$platform}", [
                    'default' => '',
                    'sanitize_callback' => 'esc_url_raw',
                ]);

                $wp_customize->add_control("social_{$platform}", [
                    'label' => ucfirst($platform),
                    'section' => 'blitz_social_links',
                    'type' => 'url',
                ]);
            }

            // Performance
            $wp_customize->add_section('blitz_performance', [
                'title' => __('Performance', 'blitz'),
                'priority' => 50,
            ]);

            foreach ([
                'enable_service_worker' => 'Service Worker',
                'enable_speculation_rules' => 'Speculation Rules',
                'enable_view_transitions' => 'View Transitions',
                'enable_web_vitals' => 'Web Vitals',
                'enable_lazy_loading' => 'Lazy Loading',
            ] as $key => $label) {
                $wp_customize->add_setting($key, [
                    'default' => true,
                    'sanitize_callback' => 'rest_sanitize_boolean',
                ]);

                $wp_customize->add_control($key, [
                    'label' => __($label, 'blitz'),
                    'section' => 'blitz_performance',
                    'type' => 'checkbox',
                ]);
            }

            // SEO
            $wp_customize->add_section('blitz_seo', [
                'title' => __('SEO', 'blitz'),
                'priority' => 55,
            ]);

            foreach ([
                'enable_open_graph' => 'Open Graph Tags',
                'enable_schema' => 'Schema.org Markup',
            ] as $key => $label) {
                $wp_customize->add_setting($key, [
                    'default' => true,
                    'sanitize_callback' => 'rest_sanitize_boolean',
                ]);

                $wp_customize->add_control($key, [
                    'label' => __($label, 'blitz'),
                    'section' => 'blitz_seo',
                    'type' => 'checkbox',
                ]);
            }
        });
    }

    /**
     * Register custom post types
     */
    public function registerCustomPostTypes(): void
    {
        $types = [
            'service' => ['icon' => 'dashicons-admin-tools', 'slug' => 'services'],
            'portfolio' => ['icon' => 'dashicons-portfolio', 'slug' => 'portfolio'],
            'team' => ['icon' => 'dashicons-groups', 'slug' => 'team'],
            'testimonial' => ['icon' => 'dashicons-testimonial', 'slug' => 'testimonials'],
            'faq' => ['icon' => 'dashicons-editor-help', 'slug' => 'faq'],
        ];

        foreach ($types as $key => $config) {
            register_post_type($key, [
                'labels' => [
                    'name' => __(ucfirst($key) . 's', 'blitz'),
                    'singular_name' => __(ucfirst($key), 'blitz'),
                ],
                'public' => true,
                'has_archive' => true,
                'show_in_rest' => true,
                'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
                'menu_icon' => $config['icon'],
                'rewrite' => ['slug' => $config['slug']],
            ]);
        }
    }

    /**
     * Register custom taxonomies
     */
    public function registerCustomTaxonomies(): void
    {
        foreach (['service', 'portfolio'] as $type) {
            register_taxonomy("{$type}_category", $type, [
                'labels' => [
                    'name' => __(ucfirst($type) . ' Categories', 'blitz'),
                    'singular_name' => __(ucfirst($type) . ' Category', 'blitz'),
                ],
                'hierarchical' => true,
                'show_in_rest' => true,
                'rewrite' => ['slug' => "{$type}-category"],
            ]);
        }
    }

    /**
     * Enhance admin interface
     */
    public function enhanceAdminInterface(): void
    {
        add_action('add_meta_boxes', [$this, 'addPageOptionsMetabox']);
        add_action('save_post', [$this, 'savePageOptionsMetabox']);
    }

    /**
     * Add page options metabox
     */
    public function addPageOptionsMetabox(): void
    {
        add_meta_box(
            'blitz_page_options',
            __('Page Options', 'blitz'),
            [$this, 'renderPageOptionsMetabox'],
            ['page', 'post'],
            'side'
        );
    }

    /**
     * Render page options metabox
     */
    public function renderPageOptionsMetabox($post): void
    {
        wp_nonce_field('blitz_page_options', 'blitz_page_options_nonce');
        
        $options = [
            'hide_page_title' => __('Hide Title', 'blitz'),
            'hide_breadcrumbs' => __('Hide Breadcrumbs', 'blitz'),
            'enable_page_sharing' => __('Enable Sharing', 'blitz'),
            'show_bottom_cta' => __('Show Bottom CTA', 'blitz'),
        ];

        foreach ($options as $key => $label) {
            $value = get_post_meta($post->ID, "_{$key}", true);
            echo '<p><label>';
            echo '<input type="checkbox" name="' . esc_attr($key) . '" value="1" ' . checked($value, '1', false) . '>';
            echo ' ' . esc_html($label);
            echo '</label></p>';
        }
    }

    /**
     * Save page options metabox
     */
    public function savePageOptionsMetabox($post_id): void
    {
        if (!isset($_POST['blitz_page_options_nonce']) || 
            !wp_verify_nonce($_POST['blitz_page_options_nonce'], 'blitz_page_options') ||
            (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) ||
            !current_user_can('edit_post', $post_id)) {
            return;
        }

        foreach (['hide_page_title', 'hide_breadcrumbs', 'enable_page_sharing', 'show_bottom_cta'] as $key) {
            update_post_meta($post_id, "_{$key}", isset($_POST[$key]) ? '1' : '0');
        }
    }

    /**
     * Add theme options page
     */
    public function addThemeOptionsPage(): void
    {
        add_theme_page(
            __('Blitz Options', 'blitz'),
            __('Blitz Options', 'blitz'),
            'manage_options',
            'blitz-theme',
            [$this, 'renderThemeOptionsPage']
        );
    }

    /**
     * Render theme options page
     */
    public function renderThemeOptionsPage(): void
    {
        ?>
        <div class="wrap">
            <h1><?php _e('Blitz Theme Options', 'blitz'); ?></h1>
            <p><?php _e('Configure settings via Appearance > Customize', 'blitz'); ?></p>
            
            <div class="card" style="max-width: 800px; padding: 20px; margin-top: 20px;">
                <h2><?php _e('Quick Links', 'blitz'); ?></h2>
                <ul>
                    <li><a href="<?php echo admin_url('customize.php?autofocus[section]=blitz_theme_options'); ?>">Theme Options</a></li>
                    <li><a href="<?php echo admin_url('customize.php?autofocus[section]=blitz_contact_info'); ?>">Contact Info</a></li>
                    <li><a href="<?php echo admin_url('customize.php?autofocus[section]=blitz_social_links'); ?>">Social Links</a></li>
                    <li><a href="<?php echo admin_url('customize.php?autofocus[section]=blitz_performance'); ?>">Performance</a></li>
                    <li><a href="<?php echo admin_url('customize.php?autofocus[section]=blitz_seo'); ?>">SEO</a></li>
                </ul>
            </div>

            <div class="card" style="max-width: 800px; padding: 20px; margin-top: 20px;">
                <h2><?php _e('Theme Info', 'blitz'); ?></h2>
                <p><strong>Version:</strong> 1.0.0</p>
                <p><strong>Framework:</strong> Sage 10</p>
                <p><a href="https://github.com/FrancescoCorbosiero/blitz-sage-theme" target="_blank">Documentation</a></p>
            </div>
        </div>
        <?php
    }

    /**
     * Auto-register blade components
     */
    protected function registerBlocks(): void
    {
        $path = resource_path('views/sections');
        
        if (!is_dir($path)) return;
        
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $relative = str_replace([$path . DIRECTORY_SEPARATOR, '.blade.php'], '', $file->getPathname());
                $component = str_replace(DIRECTORY_SEPARATOR, '.', $relative);
                
                if (function_exists('\Blade')) {
                    \Blade::component('sections.' . $component, 'sections.' . basename($component));
                }
            }
        }
    }
}