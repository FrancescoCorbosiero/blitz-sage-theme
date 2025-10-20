<?php
/**
 * Title: Gallery Grid
 * Slug: blitz/gallery-grid
 * Categories: blitz-gallery
 * Description: Image gallery in grid layout
 */

return [
    'title'       => __('Gallery Grid', 'blitz'),
    'categories'  => ['blitz-gallery'],
    'description' => __('Image gallery in grid layout', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"className":"blitz-gallery-section"} -->
        <div class="wp-block-group alignwide blitz-gallery-section" style="padding-top:5rem;padding-bottom:5rem">
            <!-- wp:heading {"textAlign":"center","className":"is-style-blitz-gradient"} -->
            <h2 class="has-text-align-center is-style-blitz-gradient">Our Work</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"1rem","bottom":"3rem"}}}} -->
            <p class="has-text-align-center" style="margin-top:1rem;margin-bottom:3rem">Explore our recent projects and achievements</p>
            <!-- /wp:paragraph -->

            <!-- wp:gallery {"columns":3,"linkTo":"none","className":"is-style-default"} -->
            <figure class="wp-block-gallery has-nested-images columns-3 is-cropped is-style-default">
                <!-- wp:image {"className":"is-style-blitz-zoom-hover"} -->
                <figure class="wp-block-image is-style-blitz-zoom-hover"><img src="' . get_template_directory_uri() . '/resources/images/gallery-placeholder.jpg" alt="Gallery image"/></figure>
                <!-- /wp:image -->

                <!-- wp:image {"className":"is-style-blitz-zoom-hover"} -->
                <figure class="wp-block-image is-style-blitz-zoom-hover"><img src="' . get_template_directory_uri() . '/resources/images/gallery-placeholder.jpg" alt="Gallery image"/></figure>
                <!-- /wp:image -->

                <!-- wp:image {"className":"is-style-blitz-zoom-hover"} -->
                <figure class="wp-block-image is-style-blitz-zoom-hover"><img src="' . get_template_directory_uri() . '/resources/images/gallery-placeholder.jpg" alt="Gallery image"/></figure>
                <!-- /wp:image -->

                <!-- wp:image {"className":"is-style-blitz-zoom-hover"} -->
                <figure class="wp-block-image is-style-blitz-zoom-hover"><img src="' . get_template_directory_uri() . '/resources/images/gallery-placeholder.jpg" alt="Gallery image"/></figure>
                <!-- /wp:image -->

                <!-- wp:image {"className":"is-style-blitz-zoom-hover"} -->
                <figure class="wp-block-image is-style-blitz-zoom-hover"><img src="' . get_template_directory_uri() . '/resources/images/gallery-placeholder.jpg" alt="Gallery image"/></figure>
                <!-- /wp:image -->

                <!-- wp:image {"className":"is-style-blitz-zoom-hover"} -->
                <figure class="wp-block-image is-style-blitz-zoom-hover"><img src="' . get_template_directory_uri() . '/resources/images/gallery-placeholder.jpg" alt="Gallery image"/></figure>
                <!-- /wp:image -->
            </figure>
            <!-- /wp:gallery -->
        </div>
        <!-- /wp:group -->
    ',
];