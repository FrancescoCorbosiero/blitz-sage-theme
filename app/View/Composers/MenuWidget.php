<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class MenuWidget extends Composer
{
    protected static $views = [
        'partials.widgets.navigation.menu-widget',
        'partials.widgets.navigation.*',
        'sections.header.*',
        'sections.footer.*',
    ];

    public function with()
    {
        $menuTree = $this->getMenuTree();
        $menuConfig = $this->getMenuConfig();
        
        return [
            'menuTree' => $menuTree,
            'menuConfig' => $menuConfig,
            'hasMenu' => !empty($menuTree),
        ];
    }

    protected function getMenuTree($menu_location = 'primary_navigation')
    {
        // Check if location exists
        $locations = get_nav_menu_locations();
        
        if (!isset($locations[$menu_location])) {
            return null;
        }
        
        $menu_id = $locations[$menu_location];
        
        if (!$menu_id) {
            return null;
        }

        $menu = wp_get_nav_menu_object($menu_id);
        
        if (!$menu) {
            return null;
        }
        
        $menu_items = wp_get_nav_menu_items($menu_id);
        
        if (empty($menu_items)) {
            return null;
        }

        // Build hierarchical tree
        $menu_tree = $this->buildTree($menu_items);
        
        return [
            'name' => $menu->name,
            'slug' => $menu->slug,
            'items' => $menu_tree,
            'depth' => $this->calculateDepth($menu_tree),
        ];
    }

    protected function buildTree($items, $parent_id = 0, $level = 0)
    {
        $branch = [];
        
        if (!is_array($items)) {
            return $branch;
        }
        
        foreach ($items as $item) {
            if ($item->menu_item_parent == $parent_id) {
                $children = $this->buildTree($items, $item->ID, $level + 1);
                
                $branch[] = [
                    'id' => $item->ID,
                    'title' => $item->title,
                    'url' => $item->url,
                    'target' => $item->target ?: '_self',
                    'description' => $item->description,
                    'classes' => $item->classes,
                    'xfn' => $item->xfn,
                    'level' => $level,
                    'is_current' => $item->current,
                    'is_ancestor' => $item->current_item_ancestor,
                    'is_parent' => $item->current_item_parent,
                    'has_children' => !empty($children),
                    'children_count' => count($children),
                    'children' => $children,
                    'icon' => null, // Add your icon logic here
                    'badge' => null, // Add your badge logic here
                ];
            }
        }
        
        return $branch;
    }

    protected function calculateDepth($items, $current_depth = 1)
    {
        if (empty($items)) {
            return $current_depth;
        }
        
        $max_depth = $current_depth;
        
        foreach ($items as $item) {
            if (!empty($item['children'])) {
                $child_depth = $this->calculateDepth($item['children'], $current_depth + 1);
                $max_depth = max($max_depth, $child_depth);
            }
        }
        
        return $max_depth;
    }

    protected function getMenuConfig()
    {
        return [
            'show_icons' => false,
            'show_badges' => false,
            'show_description' => false,
            'expand_on_hover' => false,
            'accordion_mode' => true,
            'animation_speed' => 300,
        ];
    }
}