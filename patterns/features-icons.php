<?php
/**
 * Title: Features - With Large Icons
 * Slug: blitz/features-icons
 * Categories: blitz-features
 * Description: Features section with large icon display
 */

return [
    'title'       => __('Features - With Large Icons', 'blitz'),
    'categories'  => ['blitz-features'],
    'description' => __('Features section with large icon display', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"className":"blitz-features-icons-section"} -->
        <div class="wp-block-group alignwide blitz-features-icons-section" style="padding-top:5rem;padding-bottom:5rem">
            <!-- wp:heading {"textAlign":"center","className":"is-style-blitz-gradient","style":{"typography":{"fontSize":"3rem"}}} -->
            <h2 class="has-text-align-center is-style-blitz-gradient" style="font-size:3rem">Powerful Features</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"align":"center","className":"is-style-blitz-lead","style":{"spacing":{"margin":{"top":"1rem","bottom":"4rem"}}}} -->
            <p class="has-text-align-center is-style-blitz-lead" style="margin-top:1rem;margin-bottom:4rem">Everything you need to succeed, all in one place</p>
            <!-- /wp:paragraph -->

            <!-- wp:columns {"className":"has-2-columns"} -->
            <div class="wp-block-columns has-2-columns">
                <!-- wp:column -->
                <div class="wp-block-column">
                    <!-- wp:group {"className":"is-style-blitz-card"} -->
                    <div class="wp-block-group is-style-blitz-card">
                        <!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"4rem"}}} -->
                        <h1 style="font-size:4rem">🚀</h1>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":3} -->
                        <h3>Blazing Fast Performance</h3>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Optimized for speed with cutting-edge technology. Load times under 1 second guaranteed across all devices and platforms.</p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column -->
                <div class="wp-block-column">
                    <!-- wp:group {"className":"is-style-blitz-card"} -->
                    <div class="wp-block-group is-style-blitz-card">
                        <!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"4rem"}}} -->
                        <h1 style="font-size:4rem">🔐</h1>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":3} -->
                        <h3>Enterprise Security</h3>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Bank-level encryption and security protocols. Your data is protected with the highest industry standards and compliance.</p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->

            <!-- wp:columns {"className":"has-2-columns","style":{"spacing":{"margin":{"top":"2rem"}}}} -->
            <div class="wp-block-columns has-2-columns" style="margin-top:2rem">
                <!-- wp:column -->
                <div class="wp-block-column">
                    <!-- wp:group {"className":"is-style-blitz-card"} -->
                    <div class="wp-block-group is-style-blitz-card">
                        <!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"4rem"}}} -->
                        <h1 style="font-size:4rem">📊</h1>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":3} -->
                        <h3>Advanced Analytics</h3>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Real-time insights and detailed reports. Make data-driven decisions with our comprehensive analytics dashboard.</p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column -->
                <div class="wp-block-column">
                    <!-- wp:group {"className":"is-style-blitz-card"} -->
                    <div class="wp-block-group is-style-blitz-card">
                        <!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"4rem"}}} -->
                        <h1 style="font-size:4rem">🌍</h1>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":3} -->
                        <h3>Global Scale</h3>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Deploy worldwide in minutes. Our infrastructure spans 50+ countries with 99.99% uptime guarantee.</p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->
        </div>
        <!-- /wp:group -->
    ',
];