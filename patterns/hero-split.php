<?php
/**
 * Title: Hero Section - Split Layout
 * Slug: blitz/hero-split
 * Categories: blitz-hero
 * Description: Hero with split layout - text on left, image on right
 */

return [
    'title'       => __('Hero - Split Layout', 'blitz'),
    'categories'  => ['blitz-hero'],
    'description' => __('Hero with split layout - text on left, image on right', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem","left":"2rem","right":"2rem"}}},"backgroundColor":"bg-secondary","className":"is-style-blitz-section"} -->
        <div class="wp-block-group alignfull is-style-blitz-section has-bg-secondary-background-color has-background" style="padding-top:5rem;padding-right:2rem;padding-bottom:5rem;padding-left:2rem">
            <!-- wp:columns {"verticalAlignment":"center","align":"wide"} -->
            <div class="wp-block-columns alignwide are-vertically-aligned-center">
                <!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
                <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
                    <!-- wp:heading {"level":1,"className":"is-style-blitz-gradient"} -->
                    <h1 class="is-style-blitz-gradient">Build Something Amazing</h1>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"style":{"typography":{"fontSize":"1.125rem"},"spacing":{"margin":{"top":"1.5rem","bottom":"2rem"}}}} -->
                    <p style="margin-top:1.5rem;margin-bottom:2rem;font-size:1.125rem">We help businesses transform their ideas into reality with cutting-edge technology and innovative solutions.</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:list {"className":"is-style-blitz-checklist"} -->
                    <ul class="is-style-blitz-checklist">
                        <li>Fast and reliable performance</li>
                        <li>24/7 customer support</li>
                        <li>Secure and scalable infrastructure</li>
                    </ul>
                    <!-- /wp:list -->

                    <!-- wp:buttons {"style":{"spacing":{"margin":{"top":"2rem"}}}} -->
                    <div class="wp-block-buttons" style="margin-top:2rem">
                        <!-- wp:button {"className":"is-style-blitz-primary"} -->
                        <div class="wp-block-button is-style-blitz-primary"><a class="wp-block-button__link wp-element-button">Start Free Trial</a></div>
                        <!-- /wp:button -->
                    </div>
                    <!-- /wp:buttons -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
                <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
                    <!-- wp:image {"className":"is-style-blitz-shadow"} -->
                    <figure class="wp-block-image is-style-blitz-shadow"><img src="' . get_template_directory_uri() . '/resources/images/placeholder.jpg" alt=""/></figure>
                    <!-- /wp:image -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->
        </div>
        <!-- /wp:group -->
    ',
];