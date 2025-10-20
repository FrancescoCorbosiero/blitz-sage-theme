<?php
/**
 * Title: CTA - Split with Image
 * Slug: blitz/cta-split
 * Categories: blitz-cta
 * Description: Split CTA with image and content
 */

return [
    'title'       => __('CTA - Split with Image', 'blitz'),
    'categories'  => ['blitz-cta'],
    'description' => __('Split CTA with image and content', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"className":"blitz-cta-split"} -->
        <div class="wp-block-group alignfull blitz-cta-split" style="padding-top:0;padding-bottom:0">
            <!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":"0"}}} -->
            <div class="wp-block-columns alignwide are-vertically-aligned-center">
                <!-- wp:column {"verticalAlignment":"center","width":"50%","backgroundColor":"primary"} -->
                <div class="wp-block-column is-vertically-aligned-center has-primary-background-color has-background" style="flex-basis:50%">
                    <!-- wp:group {"style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem","left":"3rem","right":"3rem"}}}} -->
                    <div class="wp-block-group" style="padding-top:5rem;padding-right:3rem;padding-bottom:5rem;padding-left:3rem">
                        <!-- wp:heading {"textColor":"white"} -->
                        <h2 class="has-white-color has-text-color">Ready to Transform Your Business?</h2>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph {"textColor":"white","style":{"spacing":{"margin":{"top":"1.5rem","bottom":"2rem"}}}} -->
                        <p class="has-white-color has-text-color" style="margin-top:1.5rem;margin-bottom:2rem">Join over 10,000 companies already using our platform to grow their business and increase revenue.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:list {"className":"is-style-blitz-checklist","textColor":"white"} -->
                        <ul class="is-style-blitz-checklist has-white-color has-text-color">
                            <li>No credit card required</li>
                            <li>14-day free trial</li>
                            <li>Cancel anytime</li>
                        </ul>
                        <!-- /wp:list -->

                        <!-- wp:buttons {"style":{"spacing":{"margin":{"top":"2rem"}}}} -->
                        <div class="wp-block-buttons" style="margin-top:2rem">
                            <!-- wp:button {"backgroundColor":"white","textColor":"primary","className":"is-style-fill"} -->
                            <div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-primary-color has-white-background-color has-text-color has-background wp-element-button">Start Your Free Trial</a></div>
                            <!-- /wp:button -->
                        </div>
                        <!-- /wp:buttons -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
                <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
                    <!-- wp:image {"sizeSlug":"large"} -->
                    <figure class="wp-block-image size-large"><img src="' . get_template_directory_uri() . '/resources/images/cta-placeholder.jpg" alt="Call to action"/></figure>
                    <!-- /wp:image -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->
        </div>
        <!-- /wp:group -->
    ',
];