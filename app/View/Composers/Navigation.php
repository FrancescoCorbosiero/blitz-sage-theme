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
        ];
    }

    /**
     * Returns the primary navigation.
     *
     * @return array
     */
    public function primaryNavigation()
    {
        $menu = wp_get_nav_menu_items('primary_navigation');
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
            ];
        }, $menu);
    }

    /**
     * Default menu items
     */
    protected function defaultMenu()
    {
        return [
            ['title' => 'Home', 'url' => home_url('/'), 'active' => is_front_page()],
            ['title' => 'Servizi', 'url' => '#servizi', 'active' => false],
            ['title' => 'Come Funziona', 'url' => '#come-funziona', 'active' => false],
            ['title' => 'Team Branco', 'url' => '#team-branco', 'active' => false],
            ['title' => 'Prezzi', 'url' => '#prezzi', 'active' => false],
            ['title' => 'Contatti', 'url' => '#contatti', 'active' => false],
        ];
    }

    /**
     * Footer navigation
     */
    public function footerNavigation()
    {
        return [
            'services' => [
                ['title' => 'Area Privata', 'url' => '/servizi/area-privata'],
                ['title' => 'Profiling Comportamentale', 'url' => '/servizi/profiling'],
                ['title' => 'Training Team Branco', 'url' => '/servizi/team-branco'],
                ['title' => 'Abbonamento VIP', 'url' => '/servizi/vip'],
            ],
            'info' => [
                ['title' => 'Come Funziona', 'url' => '/come-funziona'],
                ['title' => 'FAQ', 'url' => '/faq'],
                ['title' => 'Blog', 'url' => '/blog'],
                ['title' => 'Regolamento', 'url' => '/regolamento'],
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
        return [
            'facebook' => 'https://facebook.com/dogsafeplace',
            'instagram' => 'https://instagram.com/dogsafeplace',
            'whatsapp' => 'https://wa.me/393331234567',
        ];
    }
}