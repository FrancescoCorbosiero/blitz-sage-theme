{{-- resources/views/sections/header/header.blade.php --}}
{{-- Premium Dynamic Header - Self-contained with all features preserved --}}

@php
    // Get WordPress data
    $site_name = get_bloginfo('name');
    $site_description = get_bloginfo('description');
    $home_url = home_url('/');
    $current_url = home_url(add_query_arg([]));
    
    // Get theme mods
    $show_site_tagline = get_theme_mod('header_show_tagline', true);
    $show_search = get_theme_mod('header_show_search', true);
    $show_booking_cta = get_theme_mod('header_show_cta', true);
    $cta_text = get_theme_mod('header_cta_text', __('Book Now', 'blitz'));
    $cta_url = get_theme_mod('header_cta_url', '/contact');
    
    // Get contact info
    $whatsapp = get_theme_mod('whatsapp_number', '');
    $show_whatsapp = !empty($whatsapp) && get_theme_mod('header_show_whatsapp', true);
    
    // Get custom logo
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = $custom_logo_id ? wp_get_attachment_image_src($custom_logo_id, 'full') : null;
    
    // Props with defaults
    $isTransparent = $isTransparent ?? false;
    $showBookingCta = $showBookingCta ?? $show_booking_cta;
@endphp

{{-- Spacer to prevent content overlap --}}
<div class="header-spacer" aria-hidden="true"></div>

<header 
    x-data="{ 
        mobileOpen: false,
        scrolled: false,
        dropdownOpen: null,
        searchOpen: false,
        init() {
            // Handle scroll behavior
            const handleScroll = () => {
                this.scrolled = window.scrollY > 20;
            };
            
            window.addEventListener('scroll', handleScroll);
            handleScroll(); // Check initial state
            
            // Close mobile menu on resize to desktop
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    this.mobileOpen = false;
                    document.body.style.overflow = '';
                }
            });
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', (e) => {
                if (!this.$el.contains(e.target)) {
                    this.dropdownOpen = null;
                    this.searchOpen = false;
                }
            });
            
            // Handle body scroll lock for mobile menu
            this.$watch('mobileOpen', value => {
                if (value) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
        }
    }"
    :class="{ 
        'is-scrolled': scrolled,
        'is-transparent': {{ $isTransparent ? 'true' : 'false' }} && !scrolled 
    }"
    class="site-header fixed top-0 left-0 right-0 transition-all duration-500"
    style="z-index: 9000;"
>
    {{-- Premium glass morphism background --}}
    <div class="header-backdrop absolute inset-0 transition-all duration-500"
         :class="{ 'backdrop-blur-xl': scrolled || !{{ $isTransparent ? 'true' : 'false' }} }">
    </div>

    {{-- Main Container --}}
    <div class="relative container max-w-7xl mx-auto">
        <nav class="header-nav px-4 sm:px-6 lg:px-8 transition-all duration-500"
             :class="{ 'py-2 sm:py-3': scrolled, 'py-3 sm:py-4 lg:py-5': !scrolled }">
            
            {{-- Desktop Layout --}}
            <div class="flex items-center justify-between">
                
                {{-- Logo Section --}}
                <div class="flex items-center">
                    <a href="{{ $home_url }}" 
                       class="logo-link group flex items-center gap-2 sm:gap-3 lg:gap-4 transition-all duration-300"
                       :class="{ 'scale-95': scrolled }">
                        
                        {{-- Logo Icon Container --}}
                        <div class="logo-icon relative">
                            <div class="logo-icon-bg absolute inset-0 rounded-xl sm:rounded-2xl transition-all duration-500 group-hover:scale-110"></div>
                            <div class="relative w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 flex items-center justify-center">
                                @if($logo)
                                    <img src="{{ $logo[0] }}" 
                                         alt="{{ $site_name }}" 
                                         class="w-full h-full object-contain">
                                @else
                                    {{-- Fallback icon --}}
                                    <svg class="w-7 h-7 sm:w-8 sm:h-8 lg:w-10 lg:h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 12l-2-2 1.414-1.414L8 9.172l2.586-2.586L12 8l-4 4z"/>
                                    </svg>
                                @endif
                            </div>
                        </div>
                        
                        {{-- Logo Text --}}
                        <div class="logo-text">
                            <h1 class="text-base sm:text-lg lg:text-xl font-bold leading-tight tracking-tight">
                                {{ $site_name }}
                            </h1>
                            @if($show_site_tagline && $site_description)
                            <p class="text-[10px] sm:text-xs lg:text-sm opacity-70 font-medium hidden sm:block">
                                {{ $site_description }}
                            </p>
                            @endif
                        </div>
                    </a>
                </div>

                {{-- Center Navigation - Desktop Only --}}
                <div class="hidden lg:flex items-center justify-center flex-1 px-8">
                    @if(has_nav_menu('primary_navigation'))
                        @php
                            $menu_items = wp_get_nav_menu_items(get_nav_menu_locations()['primary_navigation']);
                            $menu_tree = [];
                            if($menu_items) {
                                foreach($menu_items as $item) {
                                    if($item->menu_item_parent == 0) {
                                        $menu_tree[$item->ID] = [
                                            'item' => $item,
                                            'children' => []
                                        ];
                                    }
                                }
                                foreach($menu_items as $item) {
                                    if($item->menu_item_parent != 0 && isset($menu_tree[$item->menu_item_parent])) {
                                        $menu_tree[$item->menu_item_parent]['children'][] = $item;
                                    }
                                }
                            }
                        @endphp
                        
                        <ul class="nav-list flex items-center gap-1">
                            @foreach($menu_tree as $menu_id => $menu_data)
                                @php
                                    $item = $menu_data['item'];
                                    $has_children = !empty($menu_data['children']);
                                    $is_active = ($current_url == $item->url) || str_starts_with($current_url, rtrim($item->url, '/') . '/');
                                @endphp
                                
                                <li @if($has_children) class="relative" @endif>
                                    @if($has_children)
                                        <button @click="dropdownOpen = dropdownOpen === {{ $item->ID }} ? null : {{ $item->ID }}"
                                                @click.away="dropdownOpen = null"
                                                class="nav-link nav-dropdown {{ $is_active ? 'active' : '' }}">
                                            <span>{{ $item->title }}</span>
                                            <svg class="dropdown-arrow" :class="{ 'rotate-180': dropdownOpen === {{ $item->ID }} }" 
                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>
                                        
                                        {{-- Dropdown Menu --}}
                                        <div x-show="dropdownOpen === {{ $item->ID }}"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 -translate-y-2"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             x-transition:leave="transition ease-in duration-150"
                                             x-transition:leave-start="opacity-100 translate-y-0"
                                             x-transition:leave-end="opacity-0 -translate-y-2"
                                             class="dropdown-menu absolute top-full left-0 mt-2 w-64 rounded-2xl overflow-hidden shadow-2xl"
                                             x-cloak>
                                            
                                            <div class="dropdown-content">
                                                @foreach($menu_data['children'] as $child)
                                                    <a href="{{ $child->url }}" 
                                                       class="dropdown-item group">
                                                        @if($child->classes && in_array('has-icon', $child->classes))
                                                            <span class="dropdown-icon">{{ $child->attr_title ?: '📄' }}</span>
                                                        @endif
                                                        <div>
                                                            <div class="dropdown-title">{{ $child->title }}</div>
                                                            @if($child->description)
                                                                <div class="dropdown-desc">{{ $child->description }}</div>
                                                            @endif
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ $item->url }}" 
                                           class="nav-link {{ $is_active ? 'active' : '' }}">
                                            {{ $item->title }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- Right Actions --}}
                <div class="flex items-center gap-2 sm:gap-3 lg:gap-4">
                    
                    {{-- Search Button --}}
                    @if($show_search)
                    <button @click="searchOpen = !searchOpen"
                            class="search-btn hidden lg:flex">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                    @endif
                    
                    {{-- WhatsApp --}}
                    @if($show_whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="whatsapp-btn hidden sm:flex">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                    </a>
                    @endif
                    
                    {{-- CTA Button --}}
                    @if($showBookingCta)
                    <a href="{{ home_url($cta_url) }}" 
                       class="btn-primary hidden sm:flex">
                        <span class="hidden sm:inline">{{ $cta_text }}</span>
                        <span class="sm:hidden">{{ __('Book', 'blitz') }}</span>
                        <svg class="btn-arrow hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    @endif
                    
                    {{-- Mobile Menu Toggle --}}
                    <button @click="mobileOpen = !mobileOpen"
                            class="mobile-toggle flex lg:hidden"
                            aria-label="Toggle menu"
                            aria-expanded="false"
                            :aria-expanded="mobileOpen.toString()">
                        <span class="hamburger" :class="{ 'active': mobileOpen }">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>
            </div>

            {{-- Search Bar --}}
            @if($show_search)
            <div x-show="searchOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="search-bar absolute left-0 right-0 top-full mt-2 px-4 sm:px-6 lg:px-8"
                 x-cloak>
                <form action="{{ $home_url }}" method="GET" class="search-form">
                    <input type="search" 
                           name="s" 
                           placeholder="{{ __('Search...', 'blitz') }}"
                           class="search-input"
                           @keydown.escape="searchOpen = false">
                    <button type="submit" class="search-submit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>
            @endif
        </nav>
    </div>

    {{-- Mobile Menu Overlay --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="mobile-menu-overlay lg:hidden fixed inset-0 bg-black/50 backdrop-blur-sm"
         @click="mobileOpen = false"
         x-cloak>
    </div>

    {{-- Mobile Menu Drawer --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="mobile-menu lg:hidden fixed inset-y-0 left-0 w-[85%] max-w-sm overflow-y-auto"
         x-cloak>
        
        {{-- Mobile Menu Header --}}
        <div class="mobile-menu-header flex items-center justify-between p-4 sm:p-6 sticky top-0 z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center">
                    @if($logo)
                        <img src="{{ $logo[0] }}" alt="{{ $site_name }}" class="w-7 h-7 object-contain filter brightness-0 invert">
                    @else
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 12l-2-2 1.414-1.414L8 9.172l2.586-2.586L12 8l-4 4z"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <div class="font-bold text-sm sm:text-base">{{ $site_name }}</div>
                    @if($show_site_tagline && $site_description)
                    <div class="text-[10px] sm:text-xs opacity-70">{{ $site_description }}</div>
                    @endif
                </div>
            </div>
            <button @click="mobileOpen = false" class="mobile-close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Mobile Menu Content --}}
        <nav class="mobile-nav px-4 sm:px-6 pb-6">
            @if(has_nav_menu('mobile_navigation') || has_nav_menu('primary_navigation'))
                @php
                    $mobile_menu_location = has_nav_menu('mobile_navigation') ? 'mobile_navigation' : 'primary_navigation';
                    $mobile_menu_items = wp_get_nav_menu_items(get_nav_menu_locations()[$mobile_menu_location]);
                    $mobile_menu_tree = [];
                    if($mobile_menu_items) {
                        foreach($mobile_menu_items as $item) {
                            if($item->menu_item_parent == 0) {
                                $mobile_menu_tree[$item->ID] = [
                                    'item' => $item,
                                    'children' => []
                                ];
                            }
                        }
                        foreach($mobile_menu_items as $item) {
                            if($item->menu_item_parent != 0 && isset($mobile_menu_tree[$item->menu_item_parent])) {
                                $mobile_menu_tree[$item->menu_item_parent]['children'][] = $item;
                            }
                        }
                    }
                @endphp
                
                <ul class="space-y-1">
                    @foreach($mobile_menu_tree as $menu_id => $menu_data)
                        @php
                            $item = $menu_data['item'];
                            $has_children = !empty($menu_data['children']);
                            $is_active = ($current_url == $item->url) || str_starts_with($current_url, rtrim($item->url, '/') . '/');
                        @endphp
                        
                        <li @if($has_children) x-data="{ open: false }" @endif>
                            @if($has_children)
                                <button @click="open = !open" class="mobile-nav-link w-full {{ $is_active ? 'active' : '' }}">
                                    @if($item->classes && in_array('has-icon', $item->classes))
                                        <span class="mobile-nav-icon">{{ $item->attr_title ?: '📁' }}</span>
                                    @endif
                                    <span>{{ $item->title }}</span>
                                    <svg class="ml-auto w-5 h-5 transition-transform" :class="{ 'rotate-180': open }"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="open" 
                                     x-transition
                                     class="mobile-submenu"
                                     x-cloak>
                                    @foreach($menu_data['children'] as $child)
                                        <a href="{{ $child->url }}" 
                                           @click="mobileOpen = false"
                                           class="mobile-submenu-link">
                                            {{ $child->title }}
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <a href="{{ $item->url }}" 
                                   @click="mobileOpen = false"
                                   class="mobile-nav-link {{ $is_active ? 'active' : '' }}">
                                    @if($item->classes && in_array('has-icon', $item->classes))
                                        <span class="mobile-nav-icon">{{ $item->attr_title ?: '📄' }}</span>
                                    @endif
                                    <span>{{ $item->title }}</span>
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif

            {{-- Mobile CTAs --}}
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 space-y-3">
                @if($showBookingCta)
                <a href="{{ home_url($cta_url) }}" 
                   @click="mobileOpen = false"
                   class="btn-primary w-full justify-center">
                    <span>{{ $cta_text }}</span>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                @endif
                
                @if($show_whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   class="btn-secondary w-full justify-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>{{ __('WhatsApp Chat', 'blitz') }}</span>
                </a>
                @endif
            </div>

            {{-- Mobile Footer Info --}}
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    © {{ date('Y') }} {{ $site_name }}<br>
                    @if(get_theme_mod('footer_credits'))
                        {{ get_theme_mod('footer_credits') }}
                    @endif
                </p>
            </div>
        </nav>
    </div>
</header>

{{-- Inline Styles for the Header Component --}}
<style>
/* CSS Custom Properties for theming */
:root {
    --header-height: 72px;
    --header-height-scrolled: 64px;
    --header-height-mobile: 60px;
    --header-height-mobile-scrolled: 56px;
}

/* Hide elements with x-cloak until Alpine loads */
[x-cloak] { 
    display: none !important; 
}

/* Header Spacer to prevent content overlap */
.header-spacer {
    height: var(--header-height-mobile);
    transition: height 0.3s ease;
}

@media (min-width: 640px) {
    .header-spacer {
        height: var(--header-height);
    }
}

/* When header is scrolled, adjust spacer */
.is-scrolled + .header-spacer {
    height: var(--header-height-mobile-scrolled);
}

@media (min-width: 640px) {
    .is-scrolled + .header-spacer {
        height: var(--header-height-scrolled);
    }
}

/* Header Base Styles */
.site-header {
    background: var(--bg-primary, #ffffff);
    border-bottom: 1px solid transparent;
    contain: layout style;
    z-index: 9000 !important;
}

/* Mobile Menu Overlay - Maximum z-index */
.mobile-menu-overlay {
    z-index: 99998 !important;
}

/* Mobile Menu Drawer - Above overlay */
.mobile-menu {
    background: var(--bg-primary);
    box-shadow: 2px 0 20px rgba(0, 0, 0, 0.1);
    z-index: 99999 !important;
    position: fixed !important;
    top: 0 !important;
    bottom: 0 !important;
    left: 0 !important;
    height: 100vh !important;
    height: 100dvh !important;
    max-height: none !important;
    min-height: 100vh !important;
}

.site-header.is-scrolled {
    border-bottom-color: var(--border-color);
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
}

.site-header.is-transparent:not(.is-scrolled) {
    background: transparent;
}

.header-backdrop {
    background: var(--bg-primary);
    opacity: 0.95;
}

/* Logo Styles */
.logo-icon-bg {
    background: var(--gradient-primary);
    box-shadow: 0 4px 12px var(--shadow);
}

.logo-link:hover .logo-icon-bg {
    box-shadow: 0 6px 20px var(--shadow-lg);
}

.logo-text h1 {
    color: var(--text-primary);
    font-family: var(--font-heading);
}

.logo-text p {
    color: var(--text-secondary);
}

/* Navigation Links */
.nav-link {
    position: relative;
    padding: 0.625rem 1rem;
    color: var(--text-secondary);
    font-weight: 500;
    font-size: 0.9375rem;
    border-radius: 0.75rem;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.nav-link:hover {
    color: var(--primary);
    background: rgba(var(--primary-rgb), 0.08);
}

.nav-link.active {
    color: var(--primary);
    background: rgba(var(--primary-rgb), 0.12);
    font-weight: 600;
}

/* Dropdown Styles */
.dropdown-arrow {
    width: 1rem;
    height: 1rem;
    transition: transform 0.2s ease;
}

.dropdown-menu {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    min-width: 280px;
}

.dropdown-content {
    padding: 0.5rem;
}

.dropdown-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.75rem;
    border-radius: 0.75rem;
    transition: all 0.2s ease;
    color: var(--text-primary);
}

.dropdown-item:hover {
    background: rgba(var(--primary-rgb), 0.08);
}

.dropdown-icon {
    font-size: 1.25rem;
    line-height: 1.5rem;
    flex-shrink: 0;
}

.dropdown-title {
    font-weight: 600;
    font-size: 0.9375rem;
    margin-bottom: 0.125rem;
}

.dropdown-desc {
    font-size: 0.8125rem;
    color: var(--text-secondary);
    opacity: 0.8;
}

/* Button Styles */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--gradient-primary);
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
    border-radius: 2rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px var(--shadow);
}

@media (min-width: 640px) {
    .btn-primary {
        padding: 0.625rem 1.25rem;
        font-size: 0.9375rem;
    }
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px var(--shadow-lg);
}

.btn-arrow {
    width: 1.125rem;
    height: 1.125rem;
    transition: transform 0.3s ease;
}

.btn-primary:hover .btn-arrow {
    transform: translateX(2px);
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    background: var(--bg-secondary);
    color: var(--primary);
    font-weight: 600;
    font-size: 0.9375rem;
    border: 2px solid var(--primary-soft);
    border-radius: 2rem;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: rgba(var(--primary-rgb), 0.08);
    border-color: var(--primary);
}

/* Icon Buttons */
.search-btn,
.whatsapp-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.75rem;
    color: var(--text-secondary);
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    transition: all 0.2s ease;
}

.search-btn:hover,
.whatsapp-btn:hover {
    color: var(--primary);
    border-color: var(--primary-soft);
    background: rgba(var(--primary-rgb), 0.08);
}

/* Search Bar */
.search-form {
    position: relative;
    max-width: 32rem;
    margin: 0 auto;
}

.search-input {
    width: 100%;
    padding: 0.75rem 3rem 0.75rem 1rem;
    background: var(--bg-secondary);
    border: 2px solid var(--border-color);
    border-radius: 1rem;
    font-size: 0.875rem;
    color: var(--text-primary);
    transition: all 0.2s ease;
}

@media (min-width: 640px) {
    .search-input {
        padding: 0.875rem 3.5rem 0.875rem 1.25rem;
        font-size: 0.9375rem;
    }
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-soft);
    box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
}

.search-submit {
    position: absolute;
    right: 0.375rem;
    top: 50%;
    transform: translateY(-50%);
    width: 2.25rem;
    height: 2.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary);
    color: white;
    border-radius: 0.625rem;
    transition: all 0.2s ease;
}

@media (min-width: 640px) {
    .search-submit {
        width: 2.5rem;
        height: 2.5rem;
    }
}

.search-submit:hover {
    background: var(--primary-soft);
}

/* Mobile Menu */
.mobile-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.75rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    transition: all 0.2s ease;
}

@media (min-width: 640px) {
    .mobile-toggle {
        width: 2.5rem;
        height: 2.5rem;
    }
}

.hamburger {
    width: 1.25rem;
    height: 1rem;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.hamburger span {
    display: block;
    width: 100%;
    height: 2px;
    background: var(--text-primary);
    border-radius: 2px;
    transition: all 0.3s ease;
    transform-origin: center;
}

.hamburger.active span:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
}

.hamburger.active span:nth-child(2) {
    opacity: 0;
    transform: scaleX(0);
}

.hamburger.active span:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
}

.mobile-menu-header {
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-color);
    color: var(--text-primary);
}

.mobile-close {
    width: 2.25rem;
    height: 2.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.5rem;
    color: var(--text-secondary);
    transition: all 0.2s ease;
}

.mobile-close:hover {
    background: rgba(0, 0, 0, 0.05);
    color: var(--text-primary);
}

.mobile-nav-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    color: var(--text-primary);
    font-weight: 500;
    font-size: 0.9375rem;
    transition: all 0.2s ease;
}

.mobile-nav-link:hover {
    background: rgba(var(--primary-rgb), 0.08);
    color: var(--primary);
}

.mobile-nav-link.active {
    background: rgba(var(--primary-rgb), 0.12);
    color: var(--primary);
    font-weight: 600;
}

.mobile-nav-icon {
    font-size: 1.25rem;
    width: 1.75rem;
    text-align: center;
}

.mobile-submenu {
    margin-top: 0.25rem;
    margin-left: 3rem;
    padding-left: 1rem;
    border-left: 2px solid var(--border-color);
}

.mobile-submenu-link {
    display: block;
    padding: 0.5rem 0.75rem;
    color: var(--text-secondary);
    font-size: 0.875rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
}

.mobile-submenu-link:hover {
    background: rgba(var(--primary-rgb), 0.08);
    color: var(--primary);
}

/* Dark Mode Support */
[data-theme="dark"] .site-header {
    background: var(--bg-primary);
}

[data-theme="dark"] .header-backdrop {
    background: rgba(15, 20, 25, 0.95);
}

[data-theme="dark"] .dropdown-menu,
[data-theme="dark"] .mobile-menu {
    background: var(--bg-secondary);
    border-color: var(--border-color);
}

[data-theme="dark"] .search-btn,
[data-theme="dark"] .whatsapp-btn,
[data-theme="dark"] .mobile-toggle,
[data-theme="dark"] .btn-secondary {
    background: var(--bg-secondary);
    border-color: var(--border-color);
}

[data-theme="dark"] .search-input {
    background: var(--bg-secondary);
    border-color: var(--border-color);
}

[data-theme="dark"] .mobile-menu-header {
    background: var(--bg-tertiary);
    border-color: var(--border-color);
}

/* Responsive Breakpoints */
@media (min-width: 360px) {
    .xs\:flex {
        display: flex;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .site-header,
    .nav-link,
    .dropdown-menu,
    .btn-primary,
    .hamburger span,
    .mobile-menu {
        transition: none;
    }
}

/* Print Styles */
@media print {
    .site-header {
        display: none;
    }
    
    .header-spacer {
        display: none;
    }
}

/* Prevent body scroll when mobile menu is open */
body.overflow-hidden {
    overflow: hidden;
    position: fixed;
    width: 100%;
}
</style>