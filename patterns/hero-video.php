<?php
/**
 * Title: Hero Section - Video Background
 * Slug: blitz/hero-video
 * Categories: blitz-hero
 * Description: Hero section with video background
 */

return [
    'title'       => __('Hero - Video Background', 'blitz'),
    'categories'  => ['blitz-hero'],
    'description' => __('Hero section with video background', 'blitz'),
    'content'     => '
        <!-- wp:cover {"url":"' . get_template_directory_uri() . '/resources/images/hero-placeholder.jpg","dimRatio":70,"overlayColor":"primary","minHeight":700,"align":"full","className":"blitz-video-hero"} -->
        <div class="wp-block-cover alignfull blitz-video-hero" style="min-height:700px">
            <span aria-hidden="true" class="wp-block-cover__background has-primary-background-color has-background-dim-70 has-background-dim"></span>
            <div class="wp-block-cover__inner-container">
                <!-- wp:group {"layout":{"type":"constrained","contentSize":"900px"}} -->
                <div class="wp-block-group">
                    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.875rem","fontWeight":"600","letterSpacing":"2px","textTransform":"uppercase"},"spacing":{"margin":{"bottom":"1rem"}}},"textColor":"white"} -->
                    <p class="has-text-align-center has-white-color has-text-color" style="margin-bottom:1rem;font-size:0.875rem;font-weight:600;letter-spacing:2px;text-transform:uppercase">Welcome to the Future</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:heading {"textAlign":"center","level":1,"textColor":"white","style":{"typography":{"fontSize":"4rem","fontWeight":"900","lineHeight":"1.1"}}} -->
                    <h1 class="has-text-align-center has-white-color has-text-color" style="font-size:4rem;font-weight:900;line-height:1.1">Experience Innovation Like Never Before</h1>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center","textColor":"white","style":{"typography":{"fontSize":"1.25rem"},"spacing":{"margin":{"top":"1.5rem","bottom":"2.5rem"}}}} -->
                    <p class="has-text-align-center has-white-color has-text-color" style="margin-top:1.5rem;margin-bottom:2.5rem;font-size:1.25rem">Transform your business with cutting-edge technology and unparalleled expertise</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"blockGap":"1.5rem"}}} -->
                    <div class="wp-block-buttons">
                        <!-- wp:button {"className":"is-style-blitz-primary","fontSize":"medium"} -->
                        <div class="wp-block-button has-custom-font-size is-style-blitz-primary has-medium-font-size"><a class="wp-block-button__link wp-element-button">Get Started Free</a></div>
                        <!-- /wp:button -->

                        <!-- wp:button {"className":"is-style-blitz-ghost","fontSize":"medium"} -->
                        <div class="wp-block-button has-custom-font-size is-style-blitz-ghost has-medium-font-size"><a class="wp-block-button__link wp-element-button" style="color:white;border-color:white;">Watch Demo ▶</a></div>
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