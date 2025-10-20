<?php
/**
 * Title: Team Grid
 * Slug: blitz/team-grid
 * Categories: blitz-team
 * Description: Team member grid with photos and info
 */

return [
    'title'       => __('Team Grid', 'blitz'),
    'categories'  => ['blitz-team'],
    'description' => __('Team member grid with photos and info', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"className":"blitz-team-section"} -->
        <div class="wp-block-group alignwide blitz-team-section" style="padding-top:5rem;padding-bottom:5rem">
            <!-- wp:heading {"textAlign":"center","className":"is-style-blitz-underline"} -->
            <h2 class="has-text-align-center is-style-blitz-underline">Meet Our Team</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"1rem","bottom":"3rem"}}}} -->
            <p class="has-text-align-center" style="margin-top:1rem;margin-bottom:3rem">The talented people behind our success</p>
            <!-- /wp:paragraph -->

            <!-- wp:columns -->
            <div class="wp-block-columns">
                <!-- wp:column {"className":"is-style-blitz-card-hover"} -->
                <div class="wp-block-column is-style-blitz-card-hover">
                    <!-- wp:image {"align":"center","className":"is-style-blitz-rounded"} -->
                    <figure class="wp-block-image aligncenter is-style-blitz-rounded"><img src="' . get_template_directory_uri() . '/resources/images/team-placeholder.jpg" alt="Team member"/></figure>
                    <!-- /wp:image -->

                    <!-- wp:heading {"textAlign":"center","level":3} -->
                    <h3 class="has-text-align-center">John Smith</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.9rem"},"spacing":{"margin":{"top":"0.5rem"}}}} -->
                    <p class="has-text-align-center" style="margin-top:0.5rem;font-size:0.9rem"><em>CEO & Founder</em></p>
                    <!-- /wp:paragraph -->

                    <!-- wp:paragraph {"align":"center"} -->
                    <p class="has-text-align-center">Visionary leader with 15+ years of experience in tech innovation.</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"className":"is-style-blitz-card-hover"} -->
                <div class="wp-block-column is-style-blitz-card-hover">
                    <!-- wp:image {"align":"center","className":"is-style-blitz-rounded"} -->
                    <figure class="wp-block-image aligncenter is-style-blitz-rounded"><img src="' . get_template_directory_uri() . '/resources/images/team-placeholder.jpg" alt="Team member"/></figure>
                    <!-- /wp:image -->

                    <!-- wp:heading {"textAlign":"center","level":3} -->
                    <h3 class="has-text-align-center">Sarah Williams</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.9rem"},"spacing":{"margin":{"top":"0.5rem"}}}} -->
                    <p class="has-text-align-center" style="margin-top:0.5rem;font-size:0.9rem"><em>CTO</em></p>
                    <!-- /wp:paragraph -->

                    <!-- wp:paragraph {"align":"center"} -->
                    <p class="has-text-align-center">Technical expert driving innovation and excellence in development.</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"className":"is-style-blitz-card-hover"} -->
                <div class="wp-block-column is-style-blitz-card-hover">
                    <!-- wp:image {"align":"center","className":"is-style-blitz-rounded"} -->
                    <figure class="wp-block-image aligncenter is-style-blitz-rounded"><img src="' . get_template_directory_uri() . '/resources/images/team-placeholder.jpg" alt="Team member"/></figure>
                    <!-- /wp:image -->

                    <!-- wp:heading {"textAlign":"center","level":3} -->
                    <h3 class="has-text-align-center">Michael Chen</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.9rem"},"spacing":{"margin":{"top":"0.5rem"}}}} -->
                    <p class="has-text-align-center" style="margin-top:0.5rem;font-size:0.9rem"><em>Head of Design</em></p>
                    <!-- /wp:paragraph -->

                    <!-- wp:paragraph {"align":"center"} -->
                    <p class="has-text-align-center">Creative mind crafting beautiful and intuitive user experiences.</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->
        </div>
        <!-- /wp:group -->
    ',
];