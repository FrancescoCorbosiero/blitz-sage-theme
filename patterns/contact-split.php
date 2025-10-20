<?php
/**
 * Title: Contact Section - Split Layout
 * Slug: blitz/contact-split
 * Categories: blitz-contact
 * Description: Contact section with form and info side by side
 */

return [
    'title'       => __('Contact Section - Split Layout', 'blitz'),
    'categories'  => ['blitz-contact'],
    'description' => __('Contact section with form and info side by side', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem","left":"2rem","right":"2rem"}}},"backgroundColor":"bg-secondary"} -->
        <div class="wp-block-group alignfull has-bg-secondary-background-color has-background" style="padding-top:5rem;padding-right:2rem;padding-bottom:5rem;padding-left:2rem">
            <!-- wp:heading {"textAlign":"center","className":"is-style-blitz-gradient"} -->
            <h2 class="has-text-align-center is-style-blitz-gradient">Get In Touch</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"1rem","bottom":"3rem"}}}} -->
            <p class="has-text-align-center" style="margin-top:1rem;margin-bottom:3rem">We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.</p>
            <!-- /wp:paragraph -->

            <!-- wp:columns {"verticalAlignment":"top","align":"wide"} -->
            <div class="wp-block-columns alignwide are-vertically-aligned-top">
                <!-- wp:column {"verticalAlignment":"top","width":"40%"} -->
                <div class="wp-block-column is-vertically-aligned-top" style="flex-basis:40%">
                    <!-- wp:group {"className":"is-style-blitz-card"} -->
                    <div class="wp-block-group is-style-blitz-card">
                        <!-- wp:heading {"level":3} -->
                        <h3>Contact Information</h3>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p><strong>📧 Email</strong><br>hello@example.com</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><strong>📞 Phone</strong><br>+1 (555) 123-4567</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><strong>📍 Address</strong><br>123 Business Street<br>New York, NY 10001</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><strong>🕐 Hours</strong><br>Monday - Friday: 9am - 6pm<br>Saturday: 10am - 4pm</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:social-links {"className":"is-style-default"} -->
                        <ul class="wp-block-social-links is-style-default">
                            <!-- wp:social-link {"url":"#","service":"facebook"} /-->
                            <!-- wp:social-link {"url":"#","service":"twitter"} /-->
                            <!-- wp:social-link {"url":"#","service":"linkedin"} /-->
                            <!-- wp:social-link {"url":"#","service":"instagram"} /-->
                        </ul>
                        <!-- /wp:social-links -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column {"verticalAlignment":"top","width":"60%"} -->
                <div class="wp-block-column is-vertically-aligned-top" style="flex-basis:60%">
                    <!-- wp:group {"className":"is-style-blitz-card"} -->
                    <div class="wp-block-group is-style-blitz-card">
                        <!-- wp:heading {"level":3} -->
                        <h3>Send Us a Message</h3>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p><input type="text" placeholder="Your Name" style="width:100%;padding:12px;border:1px solid #ddd;border-radius:6px;margin-bottom:1rem;" /></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><input type="email" placeholder="Your Email" style="width:100%;padding:12px;border:1px solid #ddd;border-radius:6px;margin-bottom:1rem;" /></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><input type="text" placeholder="Subject" style="width:100%;padding:12px;border:1px solid #ddd;border-radius:6px;margin-bottom:1rem;" /></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><textarea placeholder="Your Message" rows="6" style="width:100%;padding:12px;border:1px solid #ddd;border-radius:6px;margin-bottom:1rem;"></textarea></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:buttons -->
                        <div class="wp-block-buttons">
                            <!-- wp:button {"className":"is-style-blitz-primary","width":100} -->
                            <div class="wp-block-button has-custom-width wp-block-button__width-100 is-style-blitz-primary"><a class="wp-block-button__link wp-element-button">Send Message</a></div>
                            <!-- /wp:button -->
                        </div>
                        <!-- /wp:buttons -->
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