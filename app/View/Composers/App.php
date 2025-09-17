<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'siteName' => $this->siteName(),
            'siteDescription' => $this->siteDescription(),
            'siteUrl' => $this->siteUrl(),
            'currentYear' => $this->currentYear(),
            'themeVersion' => $this->themeVersion(),
            'bodyClasses' => $this->bodyClasses(),
            'pageTitle' => $this->pageTitle(),
            'metaDescription' => $this->metaDescription(),
            'canonicalUrl' => $this->canonicalUrl(),
            'isHomePage' => $this->isHomePage(),
            'pageId' => $this->pageId(),
            'templateName' => $this->templateName(),
        ];
    }

    /**
     * Retrieve the site name.
     */
    public function siteName(): string
    {
        return get_bloginfo('name', 'display');
    }

    /**
     * Retrieve the site description.
     */
    public function siteDescription(): string
    {
        return get_bloginfo('description', 'display');
    }

    /**
     * Retrieve the site URL.
     */
    public function siteUrl(): string
    {
        return home_url();
    }

    /**
     * Get current year.
     */
    public function currentYear(): int
    {
        return date('Y');
    }

    /**
     * Get theme version.
     */
    public function themeVersion(): string
    {
        $theme = wp_get_theme();
        return $theme->get('Version');
    }

    /**
     * Get body classes.
     */
    public function bodyClasses(): string
    {
        return implode(' ', get_body_class());
    }

    /**
     * Get page title.
     */
    public function pageTitle(): string
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'blitz');
        }

        if (is_front_page()) {
            return $this->siteName();
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(__('Search Results for "%s"', 'blitz'), get_search_query());
        }

        if (is_404()) {
            return __('Page Not Found', 'blitz');
        }

        return get_the_title();
    }

    /**
     * Get meta description.
     */
    public function metaDescription(): string
    {
        if (is_front_page()) {
            return $this->siteDescription();
        }

        if (is_single() || is_page()) {
            if (has_excerpt()) {
                return wp_trim_words(get_the_excerpt(), 25, '');
            }
            return wp_trim_words(get_the_content(), 25, '');
        }

        if (is_category()) {
            $description = category_description();
            if ($description) {
                return wp_trim_words(strip_tags($description), 25, '');
            }
        }

        if (is_tag()) {
            $description = tag_description();
            if ($description) {
                return wp_trim_words(strip_tags($description), 25, '');
            }
        }

        if (is_author()) {
            $description = get_the_author_meta('description');
            if ($description) {
                return wp_trim_words($description, 25, '');
            }
        }

        return $this->siteDescription();
    }

    /**
     * Get canonical URL.
     */
    public function canonicalUrl(): string
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

        if (is_archive()) {
            return get_post_type_archive_link(get_post_type());
        }

        return home_url(add_query_arg([], $_SERVER['REQUEST_URI']));
    }

    /**
     * Check if current page is homepage.
     */
    public function isHomePage(): bool
    {
        return is_front_page();
    }

    /**
     * Get current page ID.
     */
    public function pageId(): ?int
    {
        if (is_front_page() && !is_home()) {
            return get_option('page_on_front');
        }

        if (is_home()) {
            return get_option('page_for_posts');
        }

        if (is_singular()) {
            return get_the_ID();
        }

        return null;
    }

    /**
     * Get template name.
     */
    public function templateName(): string
    {
        global $template;
        return basename($template, '.php');
    }

    /**
     * Get theme configuration.
     */
    public function themeConfig(): array
    {
        return [
            'name' => 'Blitz',
            'version' => $this->themeVersion(),
            'textdomain' => 'blitz',
            'supports' => [
                'dark_mode' => true,
                'view_transitions' => true,
                'performance_optimization' => true,
                'seo_optimization' => true,
            ],
        ];
    }

    /**
     * Get theme customizer options.
     */
    public function themeOptions(): array
    {
        return [
            'theme_mode' => get_theme_mod('default_theme', 'auto'),
            'show_theme_toggle' => get_theme_mod('show_theme_toggle', true),
            'contact_info' => get_contact_info(),
            'social_links' => get_social_links(),
        ];
    }

    /**
     * Get pagination data.
     */
    public function pagination(): array
    {
        global $wp_query;

        $pagination = [];
        $current_page = max(1, get_query_var('paged', 1));
        $total_pages = $wp_query->max_num_pages;

        if ($total_pages > 1) {
            $pagination = [
                'current' => $current_page,
                'total' => $total_pages,
                'prev_url' => get_previous_posts_page_link(),
                'next_url' => get_next_posts_page_link(),
                'base_url' => esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false)))),
            ];
        }

        return $pagination;
    }

    /**
     * Get schema.org structured data.
     */
    public function schemaData(): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $this->siteName(),
            'description' => $this->siteDescription(),
            'url' => $this->siteUrl(),
        ];

        if (is_single()) {
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => get_the_title(),
                'description' => $this->metaDescription(),
                'url' => get_permalink(),
                'datePublished' => get_the_date('c'),
                'dateModified' => get_the_modified_date('c'),
                'author' => [
                    '@type' => 'Person',
                    'name' => get_the_author(),
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => $this->siteName(),
                ],
            ];

            if (has_post_thumbnail()) {
                $schema['image'] = get_the_post_thumbnail_url(null, 'large');
            }
        }

        if (is_page()) {
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => get_the_title(),
                'description' => $this->metaDescription(),
                'url' => get_permalink(),
            ];
        }

        return $schema;
    }

    /**
     * Get performance metrics.
     */
    public function performanceMetrics(): array
    {
        return [
            'cache_enabled' => function_exists('wp_cache_get'),
            'gzip_enabled' => extension_loaded('zlib'),
            'opcache_enabled' => function_exists('opcache_get_status') && opcache_get_status()['opcache_enabled'],
            'theme_optimized' => true,
        ];
    }