<?php
/**
 * Title: Pricing - Comparison Table
 * Slug: blitz/pricing-comparison
 * Categories: blitz-pricing
 * Description: Detailed pricing comparison table
 */

return [
    'title'       => __('Pricing - Comparison Table', 'blitz'),
    'categories'  => ['blitz-pricing'],
    'description' => __('Detailed pricing comparison table', 'blitz'),
    'content'     => '
        <!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"className":"blitz-pricing-comparison"} -->
        <div class="wp-block-group alignwide blitz-pricing-comparison" style="padding-top:5rem;padding-bottom:5rem">
            <!-- wp:heading {"textAlign":"center","className":"is-style-blitz-underline"} -->
            <h2 class="has-text-align-center is-style-blitz-underline">Compare Our Plans</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"1rem","bottom":"3rem"}}}} -->
            <p class="has-text-align-center" style="margin-top:1rem;margin-bottom:3rem">Find the perfect plan for your needs</p>
            <!-- /wp:paragraph -->

            <!-- wp:table {"className":"is-style-blitz-striped"} -->
            <figure class="wp-block-table is-style-blitz-striped">
                <table>
                    <thead>
                        <tr>
                            <th>Feature</th>
                            <th>Starter</th>
                            <th>Professional</th>
                            <th>Enterprise</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Projects</strong></td>
                            <td>5</td>
                            <td>Unlimited</td>
                            <td>Unlimited</td>
                        </tr>
                        <tr>
                            <td><strong>Storage</strong></td>
                            <td>10 GB</td>
                            <td>100 GB</td>
                            <td>1 TB</td>
                        </tr>
                        <tr>
                            <td><strong>Support</strong></td>
                            <td>Email</td>
                            <td>Priority</td>
                            <td>24/7 Phone</td>
                        </tr>
                        <tr>
                            <td><strong>Analytics</strong></td>
                            <td>Basic</td>
                            <td>Advanced</td>
                            <td>Enterprise</td>
                        </tr>
                        <tr>
                            <td><strong>API Access</strong></td>
                            <td>❌</td>
                            <td>✅</td>
                            <td>✅</td>
                        </tr>
                        <tr>
                            <td><strong>Custom Domain</strong></td>
                            <td>❌</td>
                            <td>✅</td>
                            <td>✅</td>
                        </tr>
                        <tr>
                            <td><strong>White Label</strong></td>
                            <td>❌</td>
                            <td>❌</td>
                            <td>✅</td>
                        </tr>
                        <tr>
                            <td><strong>SLA</strong></td>
                            <td>❌</td>
                            <td>❌</td>
                            <td>99.99%</td>
                        </tr>
                        <tr>
                            <td><strong>Price</strong></td>
                            <td><strong>$29/mo</strong></td>
                            <td><strong>$79/mo</strong></td>
                            <td><strong>$199/mo</strong></td>
                        </tr>
                    </tbody>
                </table>
            </figure>
            <!-- /wp:table -->
        </div>
        <!-- /wp:group -->
    ',
];