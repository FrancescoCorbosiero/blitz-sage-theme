<?php
/**
 * Title: FAQ - Accordion Style
 * Slug: blitz/faq-accordion
 * Categories: blitz-faq
 * Description: FAQ section with accordion layout
 */

return [
    'title'       => __('FAQ - Accordion Style', 'blitz'),
    'categories'  => ['blitz-faq'],
    'description' => __('FAQ section with accordion layout', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"className":"blitz-faq-section"} -->
        <div class="wp-block-group alignwide blitz-faq-section" style="padding-top:5rem;padding-bottom:5rem">
            <!-- wp:heading {"textAlign":"center","className":"is-style-blitz-gradient"} -->
            <h2 class="has-text-align-center is-style-blitz-gradient">Frequently Asked Questions</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"1rem","bottom":"3rem"}}}} -->
            <p class="has-text-align-center" style="margin-top:1rem;margin-bottom:3rem">Find answers to common questions about our service</p>
            <!-- /wp:paragraph -->

            <!-- wp:group {"layout":{"type":"constrained","contentSize":"800px"}} -->
            <div class="wp-block-group">
                <!-- wp:details {"className":"blitz-faq-item"} -->
                <details class="wp-block-details blitz-faq-item">
                    <summary><strong>How do I get started?</strong></summary>
                    <!-- wp:paragraph -->
                    <p>Getting started is easy! Simply sign up for a free account, choose your plan, and follow our step-by-step onboarding guide. Our support team is available 24/7 to help you with any questions.</p>
                    <!-- /wp:paragraph -->
                </details>
                <!-- /wp:details -->

                <!-- wp:details {"className":"blitz-faq-item"} -->
                <details class="wp-block-details blitz-faq-item">
                    <summary><strong>What payment methods do you accept?</strong></summary>
                    <!-- wp:paragraph -->
                    <p>We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers for enterprise plans. All payments are processed securely through our payment partners.</p>
                    <!-- /wp:paragraph -->
                </details>
                <!-- /wp:details -->

                <!-- wp:details {"className":"blitz-faq-item"} -->
                <details class="wp-block-details blitz-faq-item">
                    <summary><strong>Can I cancel my subscription anytime?</strong></summary>
                    <!-- wp:paragraph -->
                    <p>Yes, you can cancel your subscription at any time from your account settings. There are no cancellation fees, and you\'ll retain access to your plan until the end of your billing period.</p>
                    <!-- /wp:paragraph -->
                </details>
                <!-- /wp:details -->

                <!-- wp:details {"className":"blitz-faq-item"} -->
                <details class="wp-block-details blitz-faq-item">
                    <summary><strong>Do you offer a money-back guarantee?</strong></summary>
                    <!-- wp:paragraph -->
                    <p>Absolutely! We offer a 30-day money-back guarantee on all plans. If you\'re not completely satisfied, contact our support team for a full refund, no questions asked.</p>
                    <!-- /wp:paragraph -->
                </details>
                <!-- /wp:details -->

                <!-- wp:details {"className":"blitz-faq-item"} -->
                <details class="wp-block-details blitz-faq-item">
                    <summary><strong>Is my data secure?</strong></summary>
                    <!-- wp:paragraph -->
                    <p>Security is our top priority. We use enterprise-grade encryption, regular security audits, and comply with all major data protection regulations including GDPR and CCPA.</p>
                    <!-- /wp:paragraph -->
                </details>
                <!-- /wp:details -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:group -->
    ',
];