<?php
/**
 * Title: Content - Two Column Layout
 * Slug: blitz/content-two-column
 * Categories: blitz-content
 * Description: Two column content layout with image
 */

return [
    'title'       => __('Content - Two Column Layout', 'blitz'),
    'categories'  => ['blitz-content'],
    'description' => __('Two column content layout with image', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"className":"blitz-content-section"} -->
        <div class="wp-block-group alignwide blitz-content-section" style="padding-top:5rem;padding-bottom:5rem">
            <!-- wp:columns {"verticalAlignment":"center"} -->
            <div class="wp-block-columns are-vertically-aligned-center">
                <!-- wp:column {"verticalAlignment":"center"} -->
                <div class="wp-block-column is-vertically-aligned-center">
                    <!-- wp:image {"className":"is-style-blitz-shadow"} -->
                    <figure class="wp-block-image is-style-blitz-shadow"><img src="' . get_template_directory_uri() . '/resources/images/placeholder.jpg" alt=""/></figure>
                    <!-- /wp:image -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"verticalAlignment":"center"} -->
                <div class="wp-block-column is-vertically-aligned-center">
                    <!-- wp:heading {"className":"is-style-blitz-underline"} -->
                    <h2 class="is-style-blitz-underline">Our Story</h2>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"className":"is-style-blitz-lead"} -->
                    <p class="is-style-blitz-lead">We started with a simple mission: to make technology accessible to everyone.</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:paragraph -->
                    <p>Founded in 2020, our company has grown from a small startup to a leading provider of innovative solutions. We believe in the power of technology to transform lives and businesses.</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:paragraph -->
                    <p>Our team of dedicated professionals works tirelessly to deliver exceptional products and services that exceed our customers\' expectations. We\'re not just building software; we\'re building relationships and creating value.</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:buttons {"style":{"spacing":{"margin":{"top":"2rem"}}}} -->
                    <div class="wp-block-buttons" style="margin-top:2rem">
                        <!-- wp:button {"className":"is-style-blitz-primary"} -->
                        <div class="wp-block-button is-style-blitz-primary"><a class="wp-block-button__link wp-element-button">Learn More About Us</a></div>
                        <!-- /wp:button -->
                    </div>
                    <!-- /wp:buttons -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->
        </div>
        <!-- /wp:group -->
    ',
];