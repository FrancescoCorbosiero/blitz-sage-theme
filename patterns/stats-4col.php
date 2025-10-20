<?php
/**
 * Title: Statistics - 4 Columns
 * Slug: blitz/stats-4col
 * Categories: blitz-stats
 * Description: Four column statistics section
 */

return [
    'title'       => __('Statistics - 4 Columns', 'blitz'),
    'categories'  => ['blitz-stats'],
    'description' => __('Four column statistics section', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"backgroundColor":"primary"} -->
        <div class="wp-block-group alignwide has-primary-background-color has-background" style="padding-top:5rem;padding-bottom:5rem">
            <!-- wp:columns {"className":"blitz-stats-grid"} -->
            <div class="wp-block-columns blitz-stats-grid">
                <!-- wp:column {"textAlign":"center"} -->
                <div class="wp-block-column has-text-align-center">
                    <!-- wp:heading {"textAlign":"center","level":2,"textColor":"white","style":{"typography":{"fontSize":"3.5rem","fontWeight":"800"}}} -->
                    <h2 class="has-text-align-center has-white-color has-text-color" style="font-size:3.5rem;font-weight:800">500+</h2>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center","textColor":"white"} -->
                    <p class="has-text-align-center has-white-color has-text-color">Happy Clients</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"textAlign":"center"} -->
                <div class="wp-block-column has-text-align-center">
                    <!-- wp:heading {"textAlign":"center","level":2,"textColor":"white","style":{"typography":{"fontSize":"3.5rem","fontWeight":"800"}}} -->
                    <h2 class="has-text-align-center has-white-color has-text-color" style="font-size:3.5rem;font-weight:800">
                    <h2 class="has-text-align-center has-white-color has-text-color" style="font-size:3.5rem;font-weight:800">1000+</h2>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center","textColor":"white"} -->
                    <p class="has-text-align-center has-white-color has-text-color">Projects Completed</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"textAlign":"center"} -->
                <div class="wp-block-column has-text-align-center">
                    <!-- wp:heading {"textAlign":"center","level":2,"textColor":"white","style":{"typography":{"fontSize":"3.5rem","fontWeight":"800"}}} -->
                    <h2 class="has-text-align-center has-white-color has-text-color" style="font-size:3.5rem;font-weight:800">99%</h2>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center","textColor":"white"} -->
                    <p class="has-text-align-center has-white-color has-text-color">Satisfaction Rate</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"textAlign":"center"} -->
                <div class="wp-block-column has-text-align-center">
                    <!-- wp:heading {"textAlign":"center","level":2,"textColor":"white","style":{"typography":{"fontSize":"3.5rem","fontWeight":"800"}}} -->
                    <h2 class="has-text-align-center has-white-color has-text-color" style="font-size:3.5rem;font-weight:800">24/7</h2>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center","textColor":"white"} -->
                    <p class="has-text-align-center has-white-color has-text-color">Support Available</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->
        </div>
        <!-- /wp:group -->
    ',
];