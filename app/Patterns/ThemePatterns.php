<?php

namespace App\Patterns;

class ThemePatterns
{
    public function __construct()
    {
        add_action('init', [$this, 'registerPatternCategories']);
        add_action('init', [$this, 'registerPatterns']);
    }

    /**
     * Register custom pattern categories
     */
    public function registerPatternCategories()
    {
        $categories = [
            'blitz-hero' => [
                'label' => __('Blitz - Hero Sections', 'blitz'),
                'description' => __('Hero sections with various layouts', 'blitz'),
            ],
            'blitz-features' => [
                'label' => __('Blitz - Features', 'blitz'),
                'description' => __('Feature sections and highlights', 'blitz'),
            ],
            'blitz-testimonials' => [
                'label' => __('Blitz - Testimonials', 'blitz'),
                'description' => __('Customer testimonials and reviews', 'blitz'),
            ],
            'blitz-cta' => [
                'label' => __('Blitz - Call to Action', 'blitz'),
                'description' => __('Call to action sections', 'blitz'),
            ],
            'blitz-pricing' => [
                'label' => __('Blitz - Pricing', 'blitz'),
                'description' => __('Pricing tables and plans', 'blitz'),
            ],
            'blitz-team' => [
                'label' => __('Blitz - Team', 'blitz'),
                'description' => __('Team member sections', 'blitz'),
            ],
            'blitz-stats' => [
                'label' => __('Blitz - Statistics', 'blitz'),
                'description' => __('Statistics and numbers sections', 'blitz'),
            ],
            'blitz-faq' => [
                'label' => __('Blitz - FAQ', 'blitz'),
                'description' => __('Frequently asked questions', 'blitz'),
            ],
            'blitz-contact' => [
                'label' => __('Blitz - Contact', 'blitz'),
                'description' => __('Contact sections and forms', 'blitz'),
            ],
            'blitz-content' => [
                'label' => __('Blitz - Content', 'blitz'),
                'description' => __('Content layouts and text sections', 'blitz'),
            ],
            'blitz-gallery' => [
                'label' => __('Blitz - Gallery', 'blitz'),
                'description' => __('Image galleries and showcases', 'blitz'),
            ],
            'blitz-footer' => [
                'label' => __('Blitz - Footer', 'blitz'),
                'description' => __('Footer layouts', 'blitz'),
            ],
        ];

        foreach ($categories as $name => $properties) {
            if (!WP_Block_Pattern_Categories_Registry::get_instance()->is_registered($name)) {
                register_block_pattern_category($name, $properties);
            }
        }
    }

    /**
     * Register all patterns
     */
    public function registerPatterns()
    {
        // Get all pattern files from patterns directory
        $pattern_files = glob(get_template_directory() . '/patterns/*.php');

        foreach ($pattern_files as $file) {
            register_block_pattern(
                'blitz/' . basename($file, '.php'),
                require $file
            );
        }
    }
}