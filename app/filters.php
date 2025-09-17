<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s" class="read-more-link">%s</a>', get_permalink(), __('Read More', 'blitz'));
});

/**
 * Customize excerpt length
 */
add_filter('excerpt_length', function () {
    return 30;
});

/**
 * Add custom classes to post/page classes
 */
add_filter('post_class', function ($classes) {
    $classes[] = 'blitz-post';
    
    if (has_post_thumbnail()) {
        $classes[] = 'has-featured-image';
    }
    
    return $classes;
});

/**
 * Customize archive title
 */
add_filter('get_the_archive_title', function ($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    }
    
    return $title;
});

/**
 * Remove unnecessary meta boxes from admin
 */
add_action('admin_menu', function () {
    remove_meta_box('commentsdiv', 'page', 'normal');
    remove_meta_box('trackbacksdiv', 'page', 'normal');
});

/**
 * Custom login page styling
 */
add_action('login_enqueue_scripts', function () {
    ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_template_directory_uri(); ?>/screenshot.png);
            height: 65px;
            width: 320px;
            background-size: contain;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
        .login form {
            border-radius: 8px;
        }
        .wp-core-ui .button-primary {
            background: #3b82f6;
            border-color: #3b82f6;
            border-radius: 6px;
        }
        .wp-core-ui .button-primary:hover {
            background: #2563eb;
        }
    </style>
    <?php
});

/**
 * Change login logo URL
 */
add_filter('login_headerurl', function () {
    return home_url();
});

/**
 * Change login logo title
 */
add_filter('login_headertext', function () {
    return get_option('bloginfo', 'name');
});

/**
 * Add custom image sizes to media library
 */
add_filter('image_size_names_choose', function ($sizes) {
    return array_merge($sizes, [
        'hero' => __('Hero Image', 'blitz'),
        'card' => __('Card Image', 'blitz'),
        'testimonial' => __('Testimonial Image', 'blitz'),
        'team' => __('Team Image', 'blitz'),
        'feature' => __('Feature Image', 'blitz'),
    ]);
});

/**
 * Clean up wp_head
 */
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * Remove emoji scripts
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/**
 * Disable XML-RPC
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove version from scripts and styles
 */
add_filter('style_loader_src', function ($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
});

add_filter('script_loader_src', function ($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
});

/**
 * Add security headers
 */
add_action('send_headers', function () {
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
});

/**
 * Customize comment form
 */
add_filter('comment_form_defaults', function ($args) {
    $args['comment_notes_before'] = '';
    $args['comment_notes_after'] = '';
    $args['class_submit'] = 'btn btn-primary';
    $args['submit_button'] = '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />';
    
    return $args;
});

/**
 * Add rel="noopener" to external links
 */
add_filter('the_content', function ($content) {
    return preg_replace_callback(
        '/<a[^>]+href=["\']([^"\']+)["\'][^>]*>/i',
        function ($matches) {
            $href = $matches[1];
            if (strpos($href, home_url()) === false && strpos($href, 'mailto:') !== 0 && strpos($href, 'tel:') !== 0) {
                if (strpos($matches[0], 'rel=') !== false) {
                    $link = str_replace('rel="', 'rel="noopener ', $matches[0]);
                } else {
                    $link = str_replace('>', ' rel="noopener">', $matches[0]);
                }
                return $link;
            }
            return $matches[0];
        },
        $content
    );
});

/**
 * Optimize search query
 */
add_filter('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_search()) {
            $query->set('post_type', ['post', 'page', 'service', 'portfolio']);
        }
    }
});