<?php
/**
 * Title: Footer - Complex Layout
 * Slug: blitz/footer-complex
 * Categories: blitz-footer
 * Description: Multi-column footer with navigation and info
 */

return [
    'title'       => __('Footer - Complex Layout', 'blitz'),
    'categories'  => ['blitz-footer'],
    'description' => __('Multi-column footer with navigation and info', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"4rem","bottom":"2rem","left":"2rem","right":"2rem"}}},"backgroundColor":"primary","textColor":"white"} -->
        <div class="wp-block-group alignfull has-white-color has-primary-background-color has-text-color has-background" style="padding-top:4rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem">
            <!-- wp:columns {"align":"wide"} -->
            <div class="wp-block-columns alignwide">
                <!-- wp:column {"width":"40%"} -->
                <div class="wp-block-column" style="flex-basis:40%">
                    <!-- wp:heading {"level":3,"textColor":"white"} -->
                    <h3 class="has-white-color has-text-color">Blitz Theme</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"textColor":"white"} -->
                    <p class="has-white-color has-text-color">Building the future of digital experiences. Join thousands of satisfied customers worldwide.</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:social-links {"className":"is-style-logos-only"} -->
                    <ul class="wp-block-social-links is-style-logos-only">
                        <!-- wp:social-link {"url":"#","service":"facebook"} /-->
                        <!-- wp:social-link {"url":"#","service":"twitter"} /-->
                        <!-- wp:social-link {"url":"#","service":"linkedin"} /-->
                        <!-- wp:social-link {"url":"#","service":"instagram"} /-->
                    </ul>
                    <!-- /wp:social-links -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"width":"20%"} -->
                <div class="wp-block-column" style="flex-basis:20%">
                    <!-- wp:heading {"level":4,"textColor":"white"} -->
                    <h4 class="has-white-color has-text-color">Product</h4>
                    <!-- /wp:heading -->

                    <!-- wp:list {"className":"blitz-footer-menu"} -->
                    <ul class="blitz-footer-menu">
                        <li><a href="#">Features</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">Case Studies</a></li>
                        <li><a href="#">Reviews</a></li>
                    </ul>
                    <!-- /wp:list -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"width":"20%"} -->
                <div class="wp-block-column" style="flex-basis:20%">
                    <!-- wp:heading {"level":4,"textColor":"white"} -->
                    <h4 class="has-white-color has-text-color">Company</h4>
                    <!-- /wp:heading -->

                    <!-- wp:list {"className":"blitz-footer-menu"} -->
                    <ul class="blitz-footer-menu">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Team</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                    <!-- /wp:list -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"width":"20%"} -->
                <div class="wp-block-column" style="flex-basis:20%">
                    <!-- wp:heading {"level":4,"textColor":"white"} -->
                    <h4 class="has-white-color has-text-color">Legal</h4>
                    <!-- /wp:heading -->

                    <!-- wp:list {"className":"blitz-footer-menu"} -->
                    <ul class="blitz-footer-menu">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">GDPR</a></li>
                    </ul>
                    <!-- /wp:list -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->

            <!-- wp:separator {"backgroundColor":"white","className":"is-style-wide","style":{"spacing":{"margin":{"top":"3rem","bottom":"2rem"}}}} -->
            <hr class="wp-block-separator has-text-color has-white-color has-alpha-channel-opacity has-white-background-color has-background is-style-wide" style="margin-top:3rem;margin-bottom:2rem"/>
            <!-- /wp:separator -->

            <!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"},"align":"wide"} -->
            <div class="wp-block-group alignwide">
                <!-- wp:paragraph {"textColor":"white","fontSize":"small"} -->
                <p class="has-white-color has-text-color has-small-font-size">© 2025 Blitz Theme. All rights reserved.</p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph {"textColor":"white","fontSize":"small"} -->
                <p class="has-white-color has-text-color has-small-font-size">Made with ❤️ by Your Company</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:group -->
    ',
];