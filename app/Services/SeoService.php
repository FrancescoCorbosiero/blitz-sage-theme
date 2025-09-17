<?php

namespace App\Services;

class SeoService
{
    /**
     * Get meta description for current context
     */
    public function getMetaDescription(): string
    {
        if (is_single() || is_page()) {
            // Try custom meta description field first
            $custom_description = get_post_meta(get_the_ID(), '_meta_description', true);
            if (!empty($custom_description)) {
                return wp_trim_words($custom_description, 25);
            }
            
            // Then try excerpt
            $excerpt = get_the_excerpt();
            if (!empty($excerpt)) {
                return wp_trim_words(wp_strip_all_tags($excerpt), 25);
            }
            
            // Fall back to content snippet
            $content = get_the_content();
            if (!empty($content)) {
                return wp_trim_words(wp_strip_all_tags($content), 25);
            }
        }
        
        if (is_category()) {
            $description = category_description();
            if (!empty($description)) {
                return wp_trim_words(wp_strip_all_tags($description), 25);
            }
        }
        
        if (is_tag()) {
            $description = tag_description();
            if (!empty($description)) {
                return wp_trim_words(wp_strip_all_tags($description), 25);
            }
        }
        
        if (is_author()) {
            $description = get_the_author_meta('description');
            if (!empty($description)) {
                return wp_trim_words($description, 25);
            }
        }
        
        // Default to site description
        return get_bloginfo('description');
    }

    /**
     * Get Open Graph image
     */
    public function getOpenGraphImage(): ?string
    {
        if (is_single() || is_page()) {
            // Try custom OG image first
            $custom_og_image = get_post_meta(get_the_ID(), '_og_image', true);
            if (!empty($custom_og_image)) {
                return $custom_og_image;
            }
            
            if (has_post_thumbnail()) {
                return get_the_post_thumbnail_url(null, 'large');
            }
        }
        
        // Default site image
        $custom_logo_id = get_theme_mod('custom_logo');
        if ($custom_logo_id) {
            return wp_get_attachment_image_url($custom_logo_id, 'large');
        }
        
        return null;
    }

    /**
     * Get canonical URL for current context
     */
    public function getCanonicalUrl(): string
    {
        if (is_front_page()) {
            return home_url('/');
        }
        
        if (is_single() || is_page()) {
            return get_permalink();
        }
        
        if (is_category()) {
            return get_category_link(get_queried_object_id());
        }
        
        if (is_tag()) {
            return get_tag_link(get_queried_object_id());
        }
        
        if (is_author()) {
            return get_author_posts_url(get_queried_object_id());
        }
        
        if (is_post_type_archive()) {
            return get_post_type_archive_link(get_post_type());
        }
        
        return home_url(add_query_arg([], $_SERVER['REQUEST_URI']));
    }

    /**
     * Generate Schema.org structured data
     */
    public function getSchemaData(): array
    {
        $themeService = app('blitz.theme');
        
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'url' => home_url(),
        ];

        if (is_front_page()) {
            $schema['@type'] = 'Organization';
            $schema['logo'] = $this->getOpenGraphImage();
            
            // Add social media profiles
            $social_links = $themeService->getSocialLinks();
            if (!empty($social_links)) {
                $schema['sameAs'] = array_values($social_links);
            }
            
            // Add contact information
            $contact_info = $themeService->getContactInfo();
            if (!empty($contact_info['phone'])) {
                $schema['telephone'] = $contact_info['phone'];
            }
            if (!empty($contact_info['email'])) {
                $schema['email'] = $contact_info['email'];
            }
            if (!empty($contact_info['address'])) {
                $schema['address'] = [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $contact_info['address'],
                ];
            }
        }

        if (is_single()) {
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => get_the_title(),
                'description' => $this->getMetaDescription(),
                'url' => get_permalink(),
                'datePublished' => get_the_date('c'),
                'dateModified' => get_the_modified_date('c'),
                'author' => [
                    '@type' => 'Person',
                    'name' => get_the_author(),
                    'url' => get_author_posts_url(get_the_author_meta('ID')),
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => get_bloginfo('name'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => $this->getOpenGraphImage(),
                    ],
                ],
            ];

            if (has_post_thumbnail()) {
                $schema['image'] = [
                    '@type' => 'ImageObject',
                    'url' => get_the_post_thumbnail_url(null, 'large'),
                ];
            }

            // Add breadcrumb schema
            $breadcrumbs = $this->getBreadcrumbSchema();
            if ($breadcrumbs) {
                $schema['breadcrumb'] = $breadcrumbs;
            }
        }

        if (get_post_type() === 'service') {
            $schema['@type'] = 'Service';
            $schema['serviceType'] = get_the_title();
            $schema['provider'] = [
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
            ];
        }

        if (get_post_type() === 'portfolio') {
            $schema['@type'] = 'CreativeWork';
            $schema['name'] = get_the_title();
            $schema['creator'] = [
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
            ];
        }

        if (get_post_type() === 'faq') {
            $schema['@type'] = 'FAQPage';
            $schema['mainEntity'] = $this->getFAQSchema();
        }

        return $schema;
    }

    /**
     * Generate breadcrumb schema
     */
    public function getBreadcrumbSchema(): ?array
    {
        if (is_front_page()) {
            return null;
        }

        $breadcrumbs = [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [],
        ];

        $position = 1;
        
        // Home
        $breadcrumbs['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => 'Home',
            'item' => home_url(),
        ];

        if (is_category() || is_single()) {
            $categories = get_the_category();
            if ($categories) {
                $category = $categories[0];
                
                // Add parent categories if they exist
                $parents = [];
                while ($category->parent) {
                    $parent = get_category($category->parent);
                    $parents[] = $parent;
                    $category = $parent;
                }
                
                // Reverse to get correct order
                $parents = array_reverse($parents);
                
                foreach ($parents as $parent) {
                    $breadcrumbs['itemListElement'][] = [
                        '@type' => 'ListItem',
                        'position' => $position++,
                        'name' => $parent->name,
                        'item' => get_category_link($parent->term_id),
                    ];
                }
                
                // Add current category
                if (!is_single()) {
                    $current_cat = get_queried_object();
                    $breadcrumbs['itemListElement'][] = [
                        '@type' => 'ListItem',
                        'position' => $position++,
                        'name' => $current_cat->name,
                        'item' => get_category_link($current_cat->term_id),
                    ];
                } else {
                    $breadcrumbs['itemListElement'][] = [
                        '@type' => 'ListItem',
                        'position' => $position++,
                        'name' => $categories[0]->name,
                        'item' => get_category_link($categories[0]->term_id),
                    ];
                }
            }
        }

        if (is_single() || is_page()) {
            $breadcrumbs['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => get_the_title(),
                'item' => get_permalink(),
            ];
        }

        return $breadcrumbs;
    }

    /**
     * Generate FAQ schema
     */
    protected function getFAQSchema(): array
    {
        $faq_items = [];
        
        // Get FAQ items from content or custom fields
        $content = get_the_content();
        
        // Simple pattern matching for Q&A format
        // This is a basic implementation - extend as needed
        preg_match_all('/<h[2-3][^>]*>(.*?)<\/h[2-3]>.*?<p>(.*?)<\/p>/is', $content, $matches);
        
        if (!empty($matches[1]) && !empty($matches[2])) {
            foreach ($matches[1] as $index => $question) {
                $faq_items[] = [
                    '@type' => 'Question',
                    'name' => strip_tags($question),
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => strip_tags($matches[2][$index]),
                    ],
                ];
            }
        }
        
        return $faq_items;
    }

    /**
     * Generate Open Graph tags
     */
    public function generateOpenGraphTags(): string
    {
        if (!app('blitz.theme')->isFeatureEnabled('open_graph')) {
            return '';
        }
        
        $title = wp_get_document_title();
        $description = $this->getMetaDescription();
        $url = $this->getCanonicalUrl();
        $image = $this->getOpenGraphImage();
        
        $tags = [];
        $tags[] = '<meta property="og:type" content="website">';
        $tags[] = '<meta property="og:title" content="' . esc_attr($title) . '">';
        $tags[] = '<meta property="og:description" content="' . esc_attr($description) . '">';
        $tags[] = '<meta property="og:url" content="' . esc_url($url) . '">';
        $tags[] = '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">';
        
        if ($image) {
            $tags[] = '<meta property="og:image" content="' . esc_url($image) . '">';
        }
        
        return implode("\n", $tags);
    }

    /**
     * Generate Twitter Card tags
     */
    public function generateTwitterCardTags(): string
    {
        if (!app('blitz.theme')->isFeatureEnabled('open_graph')) {
            return '';
        }
        
        $title = wp_get_document_title();
        $description = $this->getMetaDescription();
        $image = $this->getOpenGraphImage();
        
        $tags = [];
        $tags[] = '<meta name="twitter:card" content="summary_large_image">';
        $tags[] = '<meta name="twitter:title" content="' . esc_attr($title) . '">';
        $tags[] = '<meta name="twitter:description" content="' . esc_attr($description) . '">';
        
        if ($image) {
            $tags[] = '<meta name="twitter:image" content="' . esc_url($image) . '">';
        }
        
        $twitter_handle = get_theme_mod('twitter_handle', '');
        if ($twitter_handle) {
            $tags[] = '<meta name="twitter:site" content="@' . esc_attr($twitter_handle) . '">';
        }
        
        return implode("\n", $tags);
    }
}