<?php
/**
 * Title: Pricing Table - 3 Columns
 * Slug: blitz/pricing-3col
 * Categories: blitz-pricing
 * Description: Three tier pricing table
 */

return [
    'title'       => __('Pricing Table - 3 Columns', 'blitz'),
    'categories'  => ['blitz-pricing'],
    'description' => __('Three tier pricing table', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"className":"blitz-pricing-section"} -->
        <div class="wp-block-group alignwide blitz-pricing-section" style="padding-top:5rem;padding-bottom:5rem">
            <!-- wp:heading {"textAlign":"center","className":"is-style-blitz-gradient"} -->
            <h2 class="has-text-align-center is-style-blitz-gradient">Choose Your Plan</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"1rem","bottom":"3rem"}}}} -->
            <p class="has-text-align-center" style="margin-top:1rem;margin-bottom:3rem">Select the perfect plan for your needs</p>
            <!-- /wp:paragraph -->

            <!-- wp:columns {"className":"blitz-pricing-grid"} -->
            <div class="wp-block-columns blitz-pricing-grid">
                <!-- wp:column {"className":"pricing-card"} -->
                <div class="wp-block-column pricing-card">
                    <!-- wp:heading {"textAlign":"center","level":3} -->
                    <h3 class="has-text-align-center">Starter</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center","className":"price"} -->
                    <p class="has-text-align-center price"><strong>$29</strong>/month</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:separator {"className":"is-style-blitz-dots"} -->
                    <hr class="wp-block-separator has-alpha-channel-opacity is-style-blitz-dots"/>
                    <!-- /wp:separator -->

                    <!-- wp:list {"className":"is-style-blitz-checklist"} -->
                    <ul class="is-style-blitz-checklist">
                        <li>5 Projects</li>
                        <li>10 GB Storage</li>
                        <li>Email Support</li>
                        <li>Basic Analytics</li>
                    </ul>
                    <!-- /wp:list -->

                    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"2rem"}}}} -->
                    <div class="wp-block-buttons" style="margin-top:2rem">
                        <!-- wp:button {"className":"is-style-blitz-outline"} -->
                        <div class="wp-block-button is-style-blitz-outline"><a class="wp-block-button__link wp-element-button">Choose Plan</a></div>
                        <!-- /wp:button -->
                    </div>
                    <!-- /wp:buttons -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"className":"pricing-card featured"} -->
                <div class="wp-block-column pricing-card featured">
                    <!-- wp:heading {"textAlign":"center","level":3} -->
                    <h3 class="has-text-align-center">Professional</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center","className":"price"} -->
                    <p class="has-text-align-center price"><strong>$79</strong>/month</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:separator {"className":"is-style-blitz-dots"} -->
                    <hr class="wp-block-separator has-alpha-channel-opacity is-style-blitz-dots"/>
                    <!-- /wp:separator -->

                    <!-- wp:list {"className":"is-style-blitz-checklist"} -->
                    <ul class="is-style-blitz-checklist">
                        <li>Unlimited Projects</li>
                        <li>100 GB Storage</li>
                        <li>Priority Support</li>
                        <li>Advanced Analytics</li>
                        <li>Custom Domain</li>
                    </ul>
                    <!-- /wp:list -->

                    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"2rem"}}}} -->
                    <div class="wp-block-buttons" style="margin-top:2rem">
                        <!-- wp:button {"className":"is-style-blitz-primary"} -->
                        <div class="wp-block-button is-style-blitz-primary"><a class="wp-block-button__link wp-element-button">Choose Plan</a></div>
                        <!-- /wp:button -->
                    </div>
                    <!-- /wp:buttons -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"className":"pricing-card"} -->
                <div class="wp-block-column pricing-card">
                    <!-- wp:heading {"textAlign":"center","level":3} -->
                    <h3 class="has-text-align-center">Enterprise</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center","className":"price"} -->
                    <p class="has-text-align-center price"><strong>$199</strong>/month</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:separator {"className":"is-style-blitz-dots"} -->
                    <hr class="wp-block-separator has-alpha-channel-opacity is-style-blitz-dots"/>
                    <!-- /wp:separator -->

                    <!-- wp:list {"className":"is-style-blitz-checklist"} -->
                    <ul class="is-style-blitz-checklist">
                        <li>Unlimited Everything</li>
                        <li>1 TB Storage</li>
                        <li>24/7 Phone Support</li>
                        <li>Enterprise Analytics</li>
                        <li>Dedicated Manager</li>
                        <li>SLA Guarantee</li>
                    </ul>
                    <!-- /wp:list -->

                    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"2rem"}}}} -->
                    <div class="wp-block-buttons" style="margin-top:2rem">
                        <!-- wp:button {"className":"is-style-blitz-outline"} -->
                        <div class="wp-block-button is-style-blitz-outline"><a class="wp-block-button__link wp-element-button">Choose Plan</a></div>
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