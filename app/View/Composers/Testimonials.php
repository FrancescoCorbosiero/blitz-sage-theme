<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Testimonials extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'sections.testimonials',
        'partials.testimonial-slide',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'testimonials' => $this->testimonials(),
            'testimonialSettings' => $this->testimonialSettings(),
        ];
    }

    /**
     * Get testimonials
     *
     * @return array
     */
    public function testimonials()
    {
        // Check if we have testimonial posts
        $testimonialPosts = get_posts([
            'post_type' => 'testimonial',
            'posts_per_page' => -1,
            'orderby' => 'menu_order date',
            'order' => 'ASC',
            'meta_query' => [
                [
                    'key' => '_testimonial_featured',
                    'value' => '1',
                    'compare' => '!=',
                ],
            ],
        ]);

        if ($testimonialPosts) {
            return array_map(function ($post) {
                $rating = get_field('rating', $post->ID) ?: get_post_meta($post->ID, '_testimonial_rating', true) ?: 5;
                $author_info = get_field('author_info', $post->ID) ?: get_post_meta($post->ID, '_testimonial_author_info', true);
                $company = get_field('company', $post->ID) ?: get_post_meta($post->ID, '_testimonial_company', true);
                $position = get_field('position', $post->ID) ?: get_post_meta($post->ID, '_testimonial_position', true);
                
                return [
                    'id' => $post->ID,
                    'quote' => apply_filters('the_content', $post->post_content),
                    'author' => $author_info ?: get_the_title($post),
                    'company' => $company,
                    'position' => $position,
                    'rating' => intval($rating),
                    'image' => get_the_post_thumbnail_url($post, 'testimonial') ?: $this->getGravatarFromEmail($post),
                    'featured' => get_post_meta($post->ID, '_testimonial_featured', true) === '1',
                    'date' => get_the_date('Y-m-d', $post),
                ];
            }, $testimonialPosts);
        }

        // Default testimonials if no posts
        return $this->defaultTestimonials();
    }

    /**
     * Get default testimonials
     */
    protected function defaultTestimonials()
    {
        return [
            [
                'id' => 1,
                'quote' => 'Working with this team has been an absolute game-changer for our business. Their expertise and dedication are unmatched.',
                'author' => 'Sarah Johnson',
                'company' => 'Tech Innovations Inc.',
                'position' => 'CEO',
                'rating' => 5,
                'image' => null,
                'featured' => true,
                'date' => date('Y-m-d', strtotime('-30 days')),
            ],
            [
                'id' => 2,
                'quote' => 'The results exceeded our expectations. Professional, reliable, and truly committed to delivering quality work.',
                'author' => 'Michael Chen',
                'company' => 'Digital Solutions Ltd.',
                'position' => 'Marketing Director',
                'rating' => 5,
                'image' => null,
                'featured' => false,
                'date' => date('Y-m-d', strtotime('-45 days')),
            ],
            [
                'id' => 3,
                'quote' => 'Outstanding service and support. They understood our needs perfectly and delivered exactly what we were looking for.',
                'author' => 'Emily Rodriguez',
                'company' => 'Creative Agency Co.',
                'position' => 'Project Manager',
                'rating' => 5,
                'image' => null,
                'featured' => false,
                'date' => date('Y-m-d', strtotime('-60 days')),
            ],
            [
                'id' => 4,
                'quote' => 'Incredible attention to detail and customer service. I would recommend them to anyone looking for quality work.',
                'author' => 'David Thompson',
                'company' => 'Startup Ventures',
                'position' => 'Founder',
                'rating' => 5,
                'image' => null,
                'featured' => true,
                'date' => date('Y-m-d', strtotime('-75 days')),
            ],
            [
                'id' => 5,
                'quote' => 'From start to finish, the entire process was smooth and professional. Great communication throughout.',
                'author' => 'Lisa Wang',
                'company' => 'E-commerce Plus',
                'position' => 'Operations Manager',
                'rating' => 5,
                'image' => null,
                'featured' => false,
                'date' => date('Y-m-d', strtotime('-90 days')),
            ],
            [
                'id' => 6,
                'quote' => 'They transformed our vision into reality. Highly skilled team with excellent project management.',
                'author' => 'Robert Martinez',
                'company' => 'Growth Partners',
                'position' => 'Business Development',
                'rating' => 5,
                'image' => null,
                'featured' => false,
                'date' => date('Y-m-d', strtotime('-105 days')),
            ],
        ];
    }

    /**
     * Get testimonial settings
     */
    public function testimonialSettings()
    {
        return [
            'autoplay' => get_theme_mod('testimonials_autoplay', true),
            'autoplay_speed' => get_theme_mod('testimonials_autoplay_speed', 5000),
            'show_arrows' => get_theme_mod('testimonials_show_arrows', true),
            'show_dots' => get_theme_mod('testimonials_show_dots', true),
            'slides_to_show' => get_theme_mod('testimonials_slides_to_show', 1),
            'infinite' => get_theme_mod('testimonials_infinite', true),
            'fade' => get_theme_mod('testimonials_fade', false),
        ];
    }

    /**
     * Get featured testimonials
     */
    public function featuredTestimonials()
    {
        $testimonials = $this->testimonials();
        return array_filter($testimonials, function($testimonial) {
            return $testimonial['featured'];
        });
    }

    /**
     * Get testimonials by rating
     */
    public function testimonialsByRating($rating = 5)
    {
        $testimonials = $this->testimonials();
        return array_filter($testimonials, function($testimonial) use ($rating) {
            return $testimonial['rating'] >= $rating;
        });
    }

    /**
     * Get average rating
     */
    public function averageRating()
    {
        $testimonials = $this->testimonials();
        if (empty($testimonials)) {
            return 0;
        }
        
        $total = array_sum(array_column($testimonials, 'rating'));
        return round($total / count($testimonials), 1);
    }

    /**
     * Get total testimonials count
     */
    public function totalCount()
    {
        return count($this->testimonials());
    }

    /**
     * Get testimonials statistics
     */
    public function statistics()
    {
        $testimonials = $this->testimonials();
        $ratings = array_column($testimonials, 'rating');
        
        $stats = [
            'total' => count($testimonials),
            'average_rating' => $this->averageRating(),
            'five_star' => count(array_filter($ratings, function($r) { return $r == 5; })),
            'four_star' => count(array_filter($ratings, function($r) { return $r == 4; })),
            'three_star' => count(array_filter($ratings, function($r) { return $r == 3; })),
            'two_star' => count(array_filter($ratings, function($r) { return $r == 2; })),
            'one_star' => count(array_filter($ratings, function($r) { return $r == 1; })),
        ];
        
        // Calculate percentages
        if ($stats['total'] > 0) {
            foreach (['five_star', 'four_star', 'three_star', 'two_star', 'one_star'] as $key) {
                $stats[$key . '_percent'] = round(($stats[$key] / $stats['total']) * 100, 1);
            }
        }
        
        return $stats;
    }

    /**
     * Get Gravatar from email if available
     */
    protected function getGravatarFromEmail($post)
    {
        $email = get_post_meta($post->ID, '_testimonial_email', true);
        if ($email) {
            return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '?s=150&d=mp';
        }
        return null;
    }

    /**
     * Render star rating HTML
     */
    public function renderStars($rating, $max_rating = 5)
    {
        $output = '<div class="star-rating" data-rating="' . $rating . '">';
        
        for ($i = 1; $i <= $max_rating; $i++) {
            if ($i <= $rating) {
                $output .= '<span class="star filled">★</span>';
            } else {
                $output .= '<span class="star">☆</span>';
            }
        }
        
        $output .= '</div>';
        return $output;
    }
}