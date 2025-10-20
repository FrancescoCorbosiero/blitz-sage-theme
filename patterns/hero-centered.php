<?php
/**
 * Title: Hero Section - Centered
 * Slug: blitz/hero-centered
 * Categories: blitz-hero
 * Description: Centered hero section with heading, text, and buttons
 */

return [
    'title'       => __('Hero - Centered', 'blitz'),
    'categories'  => ['blitz-hero'],
    'description' => __('Centered hero section with heading, text, and buttons', 'blitz'),
    'content'     => '
        <!-- wp:cover {"url":"' . get_template_directory_uri() . '/resources/images/hero-placeholder.jpg","dimRatio":60,"overlayColor":"primary","minHeight":600,"align":"full","className":"is-style-blitz-gradient-overlay"} -->
        <div class="wp-block-cover alignfull is-style-blitz-gradient-overlay" style="min-height:600px">
            <span aria-hidden="true" class="wp-block-cover__background has-primary-background-color has-background-dim-60 has-background-dim"></span>
            <div class="wp-block-cover__inner-container">
                <!-- wp:group {"layout":{"type":"constrained","contentSize":"800px"}} -->
                <div class="wp-block-group">
                    <!-- wp:heading {"textAlign":"center","level":1,"style":{"typography":{"fontSize":"3.5rem","fontWeight":"800"}}} -->
                    <h1 class="has-text-align-center" style="font-size:3.5rem;font-weight:800">Transform Your Business Today</h1>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.25rem"},"spacing":{"margin":{"top":"1.5rem","bottom":"2rem"}}}} -->
                    <p class="has-text-align-center" style="margin-top:1.5rem;margin-bottom:2rem;font-size:1.25rem">Discover the power of innovative solutions designed to help your business grow and succeed in the digital age.</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"blockGap":"1rem"}}} -->
                    <div class="wp-block-buttons">
                        <!-- wp:button {"className":"is-style-blitz-primary"} -->
                        <div class="wp-block-button is-style-blitz-primary"><a class="wp-block-button__link wp-element-button">Get Started</a></div>
                        <!-- /wp:button -->

                        <!-- wp:button {"className":"is-style-blitz-outline"} -->
                        <div class="wp-block-button is-style-blitz-outline"><a class="wp-block-button__link wp-element-button">Learn More</a></div>
                        <!-- /wp:button -->
                    </div>
                    <!-- /wp:buttons -->
                </div>
                <!-- /wp:group -->
            </div>
        </div>
        <!-- /wp:cover -->
    ',
];