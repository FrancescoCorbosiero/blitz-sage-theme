<?php
/**
 * Title: Testimonials Grid
 * Slug: blitz/testimonial-grid
 * Categories: blitz-testimonials
 * Description: Grid of customer testimonials
 */

return [
    'title'       => __('Testimonials Grid', 'blitz'),
    'categories'  => ['blitz-testimonials'],
    'description' => __('Grid of customer testimonials', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"backgroundColor":"bg-secondary"} -->
        <div class="wp-block-group alignwide has-bg-secondary-background-color has-background" style="padding-top:5rem;padding-bottom:5rem">
            <!-- wp:heading {"textAlign":"center","className":"is-style-blitz-underline"} -->
            <h2 class="has-text-align-center is-style-blitz-underline">What Our Clients Say</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"1rem","bottom":"3rem"}}}} -->
            <p class="has-text-align-center" style="margin-top:1rem;margin-bottom:3rem">Don\'t just take our word for it</p>
            <!-- /wp:paragraph -->

            <!-- wp:columns -->
            <div class="wp-block-columns">
                <!-- wp:column -->
                <div class="wp-block-column">
                    <!-- wp:quote {"className":"is-style-blitz-testimonial"} -->
                    <blockquote class="wp-block-quote is-style-blitz-testimonial">
                        <p>"This product completely transformed how we do business. The results were immediate and impressive."</p>
                        <cite><strong>Sarah Johnson</strong><br>CEO, Tech Corp</cite>
                    </blockquote>
                    <!-- /wp:quote -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column -->
                <div class="wp-block-column">
                    <!-- wp:quote {"className":"is-style-blitz-testimonial"} -->
                    <blockquote class="wp-block-quote is-style-blitz-testimonial">
                        <p>"Outstanding support and incredible features. I recommend this to everyone in our industry."</p>
                        <cite><strong>Michael Chen</strong><br>Founder, StartupXYZ</cite>
                    </blockquote>
                    <!-- /wp:quote -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column -->
                <div class="wp-block-column">
                    <!-- wp:quote {"className":"is-style-blitz-testimonial"} -->
                    <blockquote class="wp-block-quote is-style-blitz-testimonial">
                        <p>"Best investment we\'ve made this year. The ROI was visible within the first month."</p>
                        <cite><strong>Emily Rodriguez</strong><br>Marketing Director, BigBrand</cite>
                    </blockquote>
                    <!-- /wp:quote -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->
        </div>
        <!-- /wp:group -->
    ',
];