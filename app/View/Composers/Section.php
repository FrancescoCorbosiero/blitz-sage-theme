<?php
namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Section extends Composer
{
    protected static $views = [
        'sections.*',
        'components.*'
    ];

    public function with()
    {
        return [
            'globalConfig' => $this->getGlobalConfig(),
            'blockData' => $this->getBlockData(),
        ];
    }

    protected function getGlobalConfig()
    {
        return [
            'theme' => get_theme_mod('default_theme', 'light'),
            'animations' => get_theme_mod('enable_animations', true),
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('blitz_nonce'),
        ];
    }

    protected function getBlockData()
    {
        return [
            'hero' => function_exists('get_field') ? get_field('hero_settings') : [],
            'features' => function_exists('get_field') ? get_field('features_settings') : [],
            // etc...
        ];
    }
}