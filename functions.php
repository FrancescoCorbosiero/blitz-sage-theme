<?php

use Roots\Acorn\Application;

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (! file_exists($composer = __DIR__.'/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

\Roots\bootloader()->boot();

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect(['setup', 'filters'])
    ->each(function ($file) {
        if (! locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
                /* translators: %s is replaced with the relative file path */
                sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
            );
        }
    });


/*
|--------------------------------------------------------------------------
| Helper Functions
|--------------------------------------------------------------------------
*/

if (!function_exists('blitz_theme')) {
    function blitz_theme() {
        if (app()->has('blitz.theme')) {
            return app('blitz.theme');
        }
        return null;
    }
}

if (!function_exists('blitz_seo')) {
    function blitz_seo() {
        if (app()->has('blitz.seo')) {
            return app('blitz.seo');
        }
        return null;
    }
}

if (!function_exists('blitz_performance')) {
    function blitz_performance() {
        if (app()->has('blitz.performance')) {
            return app('blitz.performance');
        }
        return null;
    }
}

// Add to your theme's customizer setup
function blitz_customize_register($wp_customize) {
    // Social Media Section
    $wp_customize->add_section('social_media', [
        'title' => __('Social Media', 'blitz'),
        'priority' => 120,
    ]);

    // Social media settings
    $social_platforms = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'];
    foreach ($social_platforms as $platform) {
        $wp_customize->add_setting("social_{$platform}", [
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);

        $wp_customize->add_control("social_{$platform}", [
            'label' => ucfirst($platform) . ' URL',
            'section' => 'social_media',
            'type' => 'url',
        ]);
    }

    // Contact Information Section
    $wp_customize->add_section('contact_info', [
        'title' => __('Contact Information', 'blitz'),
        'priority' => 125,
    ]);

    // Contact settings
    $wp_customize->add_setting('contact_phone', [
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('contact_phone', [
        'label' => __('Phone Number', 'blitz'),
        'section' => 'contact_info',
        'type' => 'text',
    ]);

    $wp_customize->add_setting('contact_email', [
        'default' => '',
        'sanitize_callback' => 'sanitize_email',
    ]);

    $wp_customize->add_control('contact_email', [
        'label' => __('Email Address', 'blitz'),
        'section' => 'contact_info',
        'type' => 'email',
    ]);

    $wp_customize->add_setting('contact_address', [
        'default' => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);

    $wp_customize->add_control('contact_address', [
        'label' => __('Address', 'blitz'),
        'section' => 'contact_info',
        'type' => 'textarea',
    ]);
}
add_action('customize_register', 'blitz_customize_register');

/**
 * Add custom metaboxes for pages (native WordPress, no ACF required)
 */
add_action('add_meta_boxes', function() {
    add_meta_box(
        'page_options',
        __('Page Options', 'blitz'),
        function($post) {
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
        },
        'page',
        'side',
        'default'
    );
});

/**
 * Save metabox data
 */
add_action('save_post_page', function($post_id) {
    if (!isset($_POST['page_options_nonce']) || 
        !wp_verify_nonce($_POST['page_options_nonce'], 'page_options_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }
    
    // Save checkboxes
    update_post_meta($post_id, '_show_table_of_contents', 
        isset($_POST['show_table_of_contents']) ? '1' : '0');
    update_post_meta($post_id, '_enable_page_sharing', 
        isset($_POST['enable_page_sharing']) ? '1' : '0');
    update_post_meta($post_id, '_show_bottom_cta', 
        isset($_POST['show_bottom_cta']) ? '1' : '0');
});

/**

 * Get contact information safely

 */

function get_contact_info($field = null) {

    // Try to use service first

    if (function_exists('app') && app()->has('blitz.theme')) {

        return app('blitz.theme')->getContactInfo($field);

    }

    

    // Fallback to direct customizer access

    $info = [

        'phone' => get_theme_mod('contact_phone', ''),

        'whatsapp' => get_theme_mod('whatsapp_number', ''),

        'email' => get_theme_mod('contact_email', get_option('admin_email')),

        'address' => get_theme_mod('contact_address', ''),

    ];

    

    return $field ? ($info[$field] ?? '') : $info;

}



/**

 * Get social links safely

 */

function get_social_links() {

    // Try to use service first

    if (function_exists('app') && app()->has('blitz.theme')) {

        return app('blitz.theme')->getSocialLinks();

    }

    

    // Fallback to direct customizer access

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