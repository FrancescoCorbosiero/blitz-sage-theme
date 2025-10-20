<?php
/**
 * Title: Features Grid - 3 Columns
 * Slug: blitz/features-grid-3col
 * Categories: blitz-features
 * Description: Three column feature grid with icons
 */

return [
    'title'       => __('Features Grid - 3 Columns', 'blitz'),
    'categories'  => ['blitz-features'],
    'description' => __('Three column feature grid with icons', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"className":"blitz-features-section"} -->
        <div class="wp-block-group alignwide blitz-features-section" style="padding-top:5rem;padding-bottom:5rem">
            <!-- wp:heading {"textAlign":"center","className":"is-style-blitz-underline"} -->
            <h2 class="has-text-align-center is-style-blitz-underline">Why Choose Us</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"1rem","bottom":"3rem"}}}} -->
            <p class="has-text-align-center" style="margin-top:1rem;margin-bottom:3rem">Discover the features that make us stand out from the competition</p>
            <!-- /wp:paragraph -->

            <!-- wp:columns {"className":"blitz-features-grid"} -->
            <div class="wp-block-columns blitz-features-grid">
                <!-- wp:column {"className":"is-style-blitz-card-hover"} -->
                <div class="wp-block-column is-style-blitz-card-hover">
                    <!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"2rem"}}} -->
                    <h3 class="has-text-align-center" style="font-size:2rem">⚡</h3>
                    <!-- /wp:heading -->

                    <!-- wp:heading {"textAlign":"center","level":3} -->
                    <h3 class="has-text-align-center">Lightning Fast</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center"} -->
                    <p class="has-text-align-center">Experience blazing fast performance that keeps your users engaged and coming back for more.</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"className":"is-style-blitz-card-hover"} -->
                <div class="wp-block-column is-style-blitz-card-hover">
                    <!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"2rem"}}} -->
                    <h3 class="has-text-align-center" style="font-size:2rem">🔒</h3>
                    <!-- /wp:heading -->

                    <!-- wp:heading {"textAlign":"center","level":3} -->
                    <h3 class="has-text-align-center">Secure & Reliable</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center"} -->
                    <p class="has-text-align-center">Built with security in mind, protecting your data with enterprise-grade encryption.</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"className":"is-style-blitz-card-hover"} -->
                <div class="wp-block-column is-style-blitz-card-hover">
                    <!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"2rem"}}} -->
                    <h3 class="has-text-align-center" style="font-size:2rem">💎</h3>
                    <!-- /wp:heading -->

                    <!-- wp:heading {"textAlign":"center","level":3} -->
                    <h3 class="has-text-align-center">Premium Quality</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center"} -->
                    <p class="has-text-align-center">Every detail crafted with care to deliver an exceptional user experience.</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->
        </div>
        <!-- /wp:group -->
    ',
];