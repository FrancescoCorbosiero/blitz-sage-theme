<?php
/**
 * Title: CTA - Boxed Style
 * Slug: blitz/cta-boxed
 * Categories: blitz-cta
 * Description: Boxed call to action with gradient background
 */

return [
    'title'       => __('CTA - Boxed Style', 'blitz'),
    'categories'  => ['blitz-cta'],
    'description' => __('Boxed call to action with gradient background', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"className":"blitz-cta-wrapper"} -->
        <div class="wp-block-group alignwide blitz-cta-wrapper" style="padding-top:5rem;padding-bottom:5rem">
            <!-- wp:group {"align":"wide","className":"blitz-cta-block has-background-gradient"} -->
            <div class="wp-block-group alignwide blitz-cta-block has-background-gradient">
                <!-- wp:heading {"textAlign":"center","level":2,"textColor":"white"} -->
                <h2 class="has-text-align-center has-white-color has-text-color">Ready to Get Started?</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"align":"center","textColor":"white","style":{"spacing":{"margin":{"top":"1rem","bottom":"2rem"}},"typography":{"fontSize":"1.125rem"}}} -->
                <p class="has-text-align-center has-white-color has-text-color" style="margin-top:1rem;margin-bottom:2rem;font-size:1.125rem">Join thousands of satisfied customers and start your free trial today. No credit card required.</p>
                <!-- /wp:paragraph -->

                <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
                <div class="wp-block-buttons">
                    <!-- wp:button {"backgroundColor":"white","textColor":"primary","className":"is-style-fill"} -->
                    <div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-primary-color has-white-background-color has-text-color has-background wp-element-button">Start Free Trial</a></div>
                    <!-- /wp:button -->
                </div>
                <!-- /wp:buttons -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:group -->
    ',
];