<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Navigation extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'sections.header',
        'sections.footer',
        'partials.navigation',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'primaryNavigation' => $this->primaryNavigation(),
            'footerNavigation' => $this->footerNavigation(),
            'mobileNavigation' => $this->mobileNavigation(),
            'socialLinks' => $this->socialLinks(),
            'contactInfo' => $this->contactInfo(),
            'breadcrumbs' => $this->breadcrumbs(),
        ];
    }

    /**
     * Returns the primary navigation.
     *
     * @return array
     */
    public function primaryNavigation()
    {
        $location = get_nav_menu_locations();
        $menu = isset($location['primary_navigation']) 
            ? wp_get_nav_menu_items($location['primary_navigation']) 
            : false;
        if (!$menu) {
            return $this->defaultMenu();
        }
        
        return array_map(function ($item) {
            return [
                'title' => $item->title,
                'url' => $item->url,
                'active' => $item->current,
                'classes' => $item->classes,
                'id' => $item->ID,
                'children' => $this->getMenuChildren($item->ID, $menu),
            ];
        }, array_filter($menu, function($item) {
            return $item->menu_item_parent == 0;
        }));
    }

    /**
     * Get menu children
     */
    protected function getMenuChildren($parent_id, $menu_items)
    {
        $children = array_filter($menu_items, function($item) use ($parent_id) {
            return $item->menu_item_parent == $parent_id;
        });
        
        return array_map(function ($item) {
            return [
                'title' => $item->title,
                'url' => $item->url,
                'active' => $item->current,
                'classes' => $item->classes,
                'id' => $item->ID,
            ];
        }, $children);
    }

    /**
     * Default menu items
     */
    protected function defaultMenu()
    {
        return [
            ['title' => 'Home', 'url' => home_url('/'), 'active' => is_front_page(), 'children' => []],
            ['title' => 'About', 'url' => '#about', 'active' => false, 'children' => []],
            ['title' => 'Services', 'url' => '#services', 'active' => false, 'children' => []],
            ['title' => 'Portfolio', 'url' => '#portfolio', 'active' => false, 'children' => []],
            ['title' => 'Team', 'url' => '#team', 'active' => false, 'children' => []],
            ['title' => 'Blog', 'url' => '/blog', 'active' => is_home() || is_category(), 'children' => []],
            ['title' => 'Contact', 'url' => '#contact', 'active' => false, 'children' => []],
        ];
    }

    /**
     * Footer navigation
     */
    public function footerNavigation()
    {
        $menu = wp_get_nav_menu_items('footer_navigation');
        if ($menu) {
            return array_map(function ($item) {
                return [
                    'title' => $item->title,
                    'url' => $item->url,
                    'active' => $item->current,
                ];
            }, $menu);
        }

        return [
            'company' => [
                ['title' => 'About Us', 'url' => '/about'],
                ['title' => 'Our Team', 'url' => '/team'],
                ['title' => 'Careers', 'url' => '/careers'],
                ['title' => 'Press', 'url' => '/press'],
            ],
            'services' => [
                ['title' => 'All Services', 'url' => '/services'],
                ['title' => 'Consulting', 'url' => '/services/consulting'],
                ['title' => 'Support', 'url' => '/services/support'],
                ['title' => 'Training', 'url' => '/services/training'],
            ],
            'resources' => [
                ['title' => 'Blog', 'url' => '/blog'],
                ['title' => 'Documentation', 'url' => '/docs'],
                ['title' => 'FAQ', 'url' => '/faq'],
                ['title' => 'Help Center', 'url' => '/help'],
            ],
            'legal' => [
                ['title' => 'Privacy Policy', 'url' => '/privacy-policy'],
                ['title' => 'Terms of Service', 'url' => '/terms-of-service'],
                ['title' => 'Cookie Policy', 'url' => '/cookie-policy'],
                ['title' => 'Sitemap', 'url' => '/sitemap'],
            ],
        ];
    }

    /**
     * Mobile navigation
     */
    public function mobileNavigation()
    {
        return $this->primaryNavigation();
    }

    /**
     * Social links
     */
    public function socialLinks()
    {
        return get_social_links();
    }

    /**
     * Contact information
     */
    public function contactInfo()
    {
        return get_contact_info();
    }

    /**
     * Get breadcrumbs
     */
    public function breadcrumbs()
    {
        if (is_front_page()) {
            return [];
        }

        $breadcrumbs = [
            ['title' => 'Home', 'url' => home_url('/')]
        ];

        if (is_category()) {
            $category = get_queried_object();
            if ($category->parent) {
                $parent = get_category($category->parent);
                $breadcrumbs[] = ['title' => $parent->name, 'url' => get_category_link($parent->term_id)];
            }
            $breadcrumbs[] = ['title' => $category->name, 'url' => ''];
        } elseif (is_single()) {
            if (get_post_type() === 'post') {
                $categories = get_the_category();
                if ($categories) {
                    $breadcrumbs[] = ['title' => $categories[0]->name, 'url' => get_category_link($categories[0]->term_id)];
                }
            } else {
                $post_type_object = get_post_type_object(get_post_type());
                if ($post_type_object) {
                    $breadcrumbs[] = ['title' => $post_type_object->labels->name, 'url' => get_post_type_archive_link(get_post_type())];
                }
            }
            $breadcrumbs[] = ['title' => get_the_title(), 'url' => ''];
        } elseif (is_page()) {
            $ancestors = get_post_ancestors(get_the_ID());
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor) {
                $breadcrumbs[] = ['title' => get_the_title($ancestor), 'url' => get_permalink($ancestor)];
            }
            $breadcrumbs[] = ['title' => get_the_title(), 'url' => ''];
        } elseif (is_archive()) {
            $breadcrumbs[] = ['title' => get_the_archive_title(), 'url' => ''];
        } elseif (is_search()) {
            $breadcrumbs[] = ['title' => sprintf(__('Search Results for "%s"', 'blitz'), get_search_query()), 'url' => ''];
        } elseif (is_404()) {
            $breadcrumbs[] = ['title' => __('Page Not Found', 'blitz'), 'url' => ''];
        }

        return $breadcrumbs;
    }

    /**
     * Get menu locations
     */
    public function getMenuLocations()
    {
        return get_nav_menu_locations();
    }

    /**
     * Check if menu has children
     */
    public function hasChildren($menu_id)
    {
        $menu_items = wp_get_nav_menu_items($menu_id);
        if (!$menu_items) return false;
        
        foreach ($menu_items as $item) {
            if ($item->menu_item_parent != 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get current page menu item
     */
    public function getCurrentMenuItem()
    {
        $menu_items = wp_get_nav_menu_items('primary_navigation');
        if (!$menu_items) return null;
        
        foreach ($menu_items as $item) {
            if ($item->current) {
                return [
                    'title' => $item->title,
                    'url' => $item->url,
                    'id' => $item->ID,
                ];
            }
        }
        return null;
    }
}