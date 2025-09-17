<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class BlitzThemeService
{
    /**
     * Theme configuration cache key
     */
    const CACHE_KEY = 'blitz_theme_config';

    /**
     * Get theme configuration with caching
     */
    public function getConfig(): array
    {
        return Cache::remember(self::CACHE_KEY, 3600, function () {
            return [
                'theme' => [
                    'mode' => get_theme_mod('default_theme', 'auto'),
                    'show_toggle' => get_theme_mod('show_theme_toggle', true),
                ],
                'contact' => $this->getContactInfo(),
                'social' => $this->getSocialLinks(),
                'performance' => [
                    'lazy_loading' => get_theme_mod('enable_lazy_loading', true),
                    'speculation_rules' => get_theme_mod('enable_speculation_rules', true),
                    'web_vitals' => get_theme_mod('enable_web_vitals', true),
                ],
                'seo' => [
                    'enable_schema' => get_theme_mod('enable_schema', true),
                    'enable_og' => get_theme_mod('enable_open_graph', true),
                ],
            ];
        });
    }

    /**
     * Get contact information from customizer
     */
    public function getContactInfo(?string $field = null)
    {
        $info = [
            'phone' => get_theme_mod('contact_phone', ''),
            'whatsapp' => get_theme_mod('whatsapp_number', ''),
            'email' => get_theme_mod('contact_email', get_option('admin_email')),
            'address' => get_theme_mod('contact_address', ''),
        ];
        
        return $field ? ($info[$field] ?? '') : $info;
    }

    /**
     * Get social media links from customizer
     */
    public function getSocialLinks(?string $platform = null)
    {
        $platforms = ['facebook', 'instagram', 'twitter', 'linkedin', 'youtube', 'tiktok'];
        $links = [];
        
        foreach ($platforms as $p) {
            $url = get_theme_mod("social_{$p}", '');
            if ($url) {
                $links[$p] = $url;
            }
        }
        
        return $platform ? ($links[$platform] ?? '') : $links;
    }

    /**
     * Clear theme configuration cache
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Get theme assets version for cache busting
     */
    public function getAssetsVersion(): string
    {
        $theme = wp_get_theme();
        return $theme->get('Version') . '-' . date('YmdH');
    }

    /**
     * Check if feature is enabled
     */
    public function isFeatureEnabled(string $feature): bool
    {
        $features = [
            'dark_mode' => get_theme_mod('show_theme_toggle', true),
            'lazy_loading' => get_theme_mod('enable_lazy_loading', true),
            'speculation_rules' => get_theme_mod('enable_speculation_rules', true),
            'web_vitals' => get_theme_mod('enable_web_vitals', true),
            'schema' => get_theme_mod('enable_schema', true),
            'open_graph' => get_theme_mod('enable_open_graph', true),
        ];
        
        return $features[$feature] ?? false;
    }

    /**
     * Get navigation menus configuration
     */
    public function getMenus(): array
    {
        $locations = get_nav_menu_locations();
        $menus = [];
        
        foreach ($locations as $location => $menu_id) {
            if ($menu_id) {
                $menu = wp_get_nav_menu_object($menu_id);
                $menus[$location] = [
                    'id' => $menu_id,
                    'name' => $menu->name,
                    'items' => wp_get_nav_menu_items($menu_id),
                ];
            }
        }
        
        return $menus;
    }

    /**
     * Get custom post types configuration
     */
    public function getCustomPostTypes(): array
    {
        return [
            'testimonial' => [
                'enabled' => get_theme_mod('enable_testimonials', true),
                'archive' => get_post_type_archive_link('testimonial'),
            ],
            'service' => [
                'enabled' => get_theme_mod('enable_services', true),
                'archive' => get_post_type_archive_link('service'),
            ],
            'portfolio' => [
                'enabled' => get_theme_mod('enable_portfolio', true),
                'archive' => get_post_type_archive_link('portfolio'),
            ],
            'team' => [
                'enabled' => get_theme_mod('enable_team', true),
                'archive' => get_post_type_archive_link('team'),
            ],
            'faq' => [
                'enabled' => get_theme_mod('enable_faq', true),
                'archive' => get_post_type_archive_link('faq'),
            ],
        ];
    }

    public function getOptimizedAsset($path) {
        $manifest = $this->getManifest();
        $asset = $manifest[$path] ?? $path;
        
        return [
            'url' => asset($asset),
            'version' => $this->getAssetsVersion(),
            'preload' => $this->shouldPreload($path),
            'critical' => $this->isCriticalAsset($path)
        ];
    }
}