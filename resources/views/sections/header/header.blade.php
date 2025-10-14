{{-- resources/views/sections/header/header.blade.php --}}
@php
    // Site information
    $site_name = get_bloginfo('name') ?: 'Blitz Theme';
    $tagline = get_bloginfo('description') ?: '';
    
    // Header settings with defaults to prevent undefined variable errors
    $header_style = get_theme_mod('header_style', 'default');
    $is_transparent = get_theme_mod('header_transparent', false);
    $show_contact_btn = get_theme_mod('header_contact_button', true);
    $contact_link = get_theme_mod('header_contact_link', '/contact');
    $contact_text = get_theme_mod('header_contact_text', __('Get Started', 'blitz'));
    
    // Get navigation from composer or directly
    $navigation_items = $primaryNavigation ?? [];
    
    // If no composer data, get menu directly
    if (empty($navigation_items)) {
        $locations = get_nav_menu_locations();
        if (!empty($locations['primary_navigation'])) {
            $menu_items = wp_get_nav_menu_items($locations['primary_navigation']);
            $navigation_items = [];
            
            if ($menu_items) {
                // Build parent items first
                foreach ($menu_items as $item) {
                    if ($item->menu_item_parent == 0) {
                        $navigation_items[$item->ID] = [
                            'id' => $item->ID,
                            'title' => $item->title,
                            'url' => $item->url,
                            'classes' => (array) $item->classes,
                            'active' => false,
                            'children' => []
                        ];
                    }
                }
                
                // Add children to parents
                foreach ($menu_items as $item) {
                    if ($item->menu_item_parent != 0 && isset($navigation_items[$item->menu_item_parent])) {
                        $navigation_items[$item->menu_item_parent]['children'][] = [
                            'id' => $item->ID,
                            'title' => $item->title,
                            'url' => $item->url,
                            'classes' => (array) $item->classes,
                            'description' => $item->description ?: '',
                        ];
                    }
                }
                
                // Convert to indexed array
                $navigation_items = array_values($navigation_items);
            }
        }
    }
@endphp

{{-- Add spacer for fixed header --}}
<div class="header-spacer"></div>

<header id="site-header" 
        class="site-header fixed top-0 left-0 right-0 transition-all duration-300 {{ $is_transparent ? 'is-transparent' : '' }}"
        x-data="{ 
            scrolled: false,
            dropdownOpen: null,
            mobileMenuOpen: false,
            searchOpen: false,
            init() {
                // Handle scroll events
                window.addEventListener('scroll', () => {
                    this.scrolled = window.scrollY > 50;
                });
                
                // Close dropdowns on click outside
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.nav-dropdown') && !e.target.closest('.dropdown-menu')) {
                        this.dropdownOpen = null;
                    }
                });
                
                // Close mobile menu on escape
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        this.mobileMenuOpen = false;
                        this.dropdownOpen = null;
                        this.searchOpen = false;
                    }
                });
            }
        }"
        x-init="init()"
        :class="{ 'is-scrolled': scrolled }">
    
    {{-- Header backdrop for glass effect --}}
    <div class="header-backdrop absolute inset-0 backdrop-blur-lg"></div>
    
    <div class="container mx-auto px-4 relative">
        <nav class="flex items-center justify-between h-16 sm:h-18 lg:h-20 transition-all duration-300">
            
            {{-- Logo Section --}}
            <div class="flex items-center gap-3">
                <a href="{{ home_url('/') }}" 
                   class="logo-link flex items-center gap-3 group">
                    {{-- Logo Icon/Image --}}
                    @if(has_custom_logo())
                        {!! get_custom_logo() !!}
                    @else
                        <div class="logo-icon-bg w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110">
                            <span class="text-white font-bold text-lg sm:text-xl">
                                {{ substr($site_name, 0, 1) }}
                            </span>
                        </div>
                    @endif
                    
                    {{-- Site Name & Tagline --}}
                    <div class="logo-text hidden xs:block">
                        <h1 class="text-base sm:text-lg font-bold leading-tight">
                            {{ $site_name }}
                        </h1>
                        @if($tagline && !$is_transparent)
                            <p class="text-xs sm:text-sm opacity-70 leading-tight">
                                {{ $tagline }}
                            </p>
                        @endif
                    </div>
                </a>
            </div>
            
            {{-- Desktop Navigation --}}
            <div class="hidden lg:flex items-center gap-2">
                @if(!empty($navigation_items))
                    <ul class="flex items-center gap-1">
                        @foreach($navigation_items as $item)
                            @php
                                $has_children = !empty($item['children']);
                                $is_active = $item['active'] ?? false;
                            @endphp
                            
                            <li @if($has_children) class="relative" @endif>
                                @if($has_children)
                                    <button @click="dropdownOpen = dropdownOpen === {{ $item['id'] }} ? null : {{ $item['id'] }}"
                                            class="nav-link nav-dropdown {{ $is_active ? 'active' : '' }} flex items-center gap-1">
                                        <span>{{ $item['title'] }}</span>
                                        <svg class="dropdown-arrow w-4 h-4" 
                                             :class="{ 'rotate-180': dropdownOpen === {{ $item['id'] }} }" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    
                                    {{-- Dropdown Menu --}}
                                    <div x-show="dropdownOpen === {{ $item['id'] }}"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 -translate-y-2"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 -translate-y-2"
                                         @click.away="dropdownOpen = null"
                                         class="dropdown-menu absolute top-full left-0 mt-2 w-64 rounded-2xl overflow-hidden shadow-2xl bg-white dark:bg-gray-800"
                                         style="z-index: 9999;"
                                         x-cloak>
                                        
                                        <div class="dropdown-content p-2">
                                            @foreach($item['children'] as $child)
                                                <a href="{{ $child['url'] }}" 
                                                   class="dropdown-item group block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                    <div class="flex-1">
                                                        <div class="dropdown-title font-medium">{{ $child['title'] }}</div>
                                                        @if(!empty($child['description']))
                                                            <div class="dropdown-desc text-sm text-gray-600 dark:text-gray-400">{{ $child['description'] }}</div>
                                                        @endif
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ $item['url'] }}" 
                                       class="nav-link {{ $is_active ? 'active' : '' }}">
                                        {{ $item['title'] }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{-- Default menu if no navigation is set --}}
                    <ul class="flex items-center gap-1">
                        <li><a href="{{ home_url('/') }}" class="nav-link">{{ __('Home', 'blitz') }}</a></li>
                        <li><a href="#about" class="nav-link">{{ __('About', 'blitz') }}</a></li>
                        <li><a href="#services" class="nav-link">{{ __('Services', 'blitz') }}</a></li>
                        <li><a href="#contact" class="nav-link">{{ __('Contact', 'blitz') }}</a></li>
                    </ul>
                @endif
            </div>
            
            {{-- Right Section --}}
            <div class="flex items-center gap-2 sm:gap-3">
                {{-- Search Button --}}
                <button @click="searchOpen = !searchOpen" 
                        class="search-btn p-2 rounded-lg transition-all hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
                
                {{-- Contact/CTA Button --}}
                @if($show_contact_btn)
                    <a href="{{ $contact_link }}" 
                       class="btn-primary hidden sm:flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                        <span>{{ $contact_text }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                @endif
                
                {{-- Mobile Menu Toggle --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen; document.body.classList.toggle('overflow-hidden')"
                        class="mobile-toggle lg:hidden p-2 rounded-lg transition-all">
                    <div class="hamburger w-6 h-6 relative" :class="{ 'active': mobileMenuOpen }">
                        <span class="absolute left-0 w-full h-0.5 bg-current transition-all duration-300" 
                              :class="mobileMenuOpen ? 'top-2.5 rotate-45' : 'top-1'"></span>
                        <span class="absolute left-0 w-full h-0.5 bg-current transition-all duration-300 top-2.5"
                              :class="mobileMenuOpen ? 'opacity-0' : 'opacity-100'"></span>
                        <span class="absolute left-0 w-full h-0.5 bg-current transition-all duration-300"
                              :class="mobileMenuOpen ? 'top-2.5 -rotate-45' : 'top-4'"></span>
                    </div>
                </button>
            </div>
        </nav>
    </div>
    
    {{-- Search Bar --}}
    <div x-show="searchOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-full"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-full"
         class="search-bar absolute top-full left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-lg"
         x-cloak>
        <div class="container mx-auto px-4 py-4">
            <form action="{{ home_url('/') }}" method="get" class="flex gap-2">
                <input type="search" 
                       name="s" 
                       class="search-input flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
                       placeholder="{{ __('Search...', 'blitz') }}"
                       x-ref="searchInput"
                       @keydown.escape="searchOpen = false">
                <button type="submit" class="btn-primary px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                    {{ __('Search', 'blitz') }}
                </button>
            </form>
        </div>
    </div>
    
    {{-- Mobile Menu Overlay --}}
    <div x-show="mobileMenuOpen" 
         @click="mobileMenuOpen = false"
         class="mobile-menu-overlay fixed inset-0 bg-black/50 lg:hidden"
         style="z-index: 99998;"
         x-cloak>
    </div>
    
    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="mobile-menu fixed top-0 left-0 bottom-0 w-80 max-w-[85vw] bg-white dark:bg-gray-900 lg:hidden overflow-y-auto overscroll-contain"
         style="z-index: 99999;"
         @click.stop
         x-cloak>
        
        {{-- Mobile Menu Header --}}
        <div class="mobile-menu-header p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    @if(has_custom_logo())
                        {!! get_custom_logo() !!}
                    @else
                        <div class="logo-icon-bg w-10 h-10 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-lg">
                                {{ substr($site_name, 0, 1) }}
                            </span>
                        </div>
                    @endif
                    <span class="font-bold text-lg">{{ $site_name }}</span>
                </div>
                <button @click="mobileMenuOpen = false" 
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        {{-- Mobile Menu Content --}}
        <nav class="p-4">
            @if(!empty($navigation_items))
                <ul class="space-y-2">
                    @foreach($navigation_items as $item)
                        @php
                            $has_children = !empty($item['children']);
                        @endphp
                        
                        <li>
                            @if($has_children)
                                <div x-data="{ open: false }">
                                    <button @click="open = !open"
                                            class="mobile-nav-link w-full flex items-center justify-between p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                        <span>{{ $item['title'] }}</span>
                                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    
                                    <ul x-show="open" 
                                        x-transition
                                        class="mobile-submenu mt-2 ml-4 space-y-1">
                                        @foreach($item['children'] as $child)
                                            <li>
                                                <a href="{{ $child['url'] }}" 
                                                   class="mobile-submenu-link block p-2 pl-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                                    {{ $child['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <a href="{{ $item['url'] }}" 
                                   class="mobile-nav-link block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                    {{ $item['title'] }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
            
            {{-- Mobile CTA Button --}}
            @if($show_contact_btn)
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ $contact_link }}" 
                       class="btn-primary w-full flex items-center justify-center gap-2 px-4 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                        <span>{{ $contact_text }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @endif
        </nav>
    </div>
</header>

{{-- Include the original styles --}}
<style>
/* Include all the original header styles here */
[x-cloak] { 
    display: none !important; 
}

/* Add other styles from the original header */
</style>

{{-- Inline Styles for the Header Component --}}
<style>
/* CSS Custom Properties for theming */
:root {
    --header-height: 72px;
    --header-height-scrolled: 64px;
    --header-height-mobile: 60px;
    --header-height-mobile-scrolled: 56px;
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
    background: var(--bg-primary, #faf7f2);
    border-bottom: 1px solid transparent;
    contain: layout style;
    z-index: 9000 !important; /* Ensure header is always on top */
}

/* Mobile Menu Overlay - Maximum z-index */
.mobile-menu-overlay {
    z-index: 99998 !important;
}

/* Mobile Menu Drawer - Above overlay */
.mobile-menu {
    z-index: 99999 !important;
}

.site-header.is-scrolled {
    border-bottom-color: var(--border-color, #e8e8e0);
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
}

.site-header.is-transparent:not(.is-scrolled) {
    background: transparent;
}

.header-backdrop {
    background: var(--bg-primary, #faf7f2);
    opacity: 0.95;
}

/* Logo Styles */
.logo-icon-bg {
    background: linear-gradient(135deg, #7ba65d 0%, #4a7c28 100%);
    box-shadow: 0 4px 12px rgba(74, 124, 40, 0.15);
}

.logo-link:hover .logo-icon-bg {
    box-shadow: 0 6px 20px rgba(74, 124, 40, 0.25);
}

.logo-text h1 {
    color: var(--text-primary, #1a1a1a);
    font-family: 'Comfortaa', system-ui, sans-serif;
}

.logo-text p {
    color: var(--text-secondary, #3a3a3a);
}

/* Navigation Links */
.nav-link {
    position: relative;
    padding: 0.625rem 1rem;
    color: var(--text-secondary, #3a3a3a);
    font-weight: 500;
    font-size: 0.9375rem;
    border-radius: 0.75rem;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.nav-link:hover {
    color: var(--primary, #2d5016);
    background: rgba(74, 124, 40, 0.08);
}

.nav-link.active {
    color: var(--primary, #2d5016);
    background: rgba(74, 124, 40, 0.12);
    font-weight: 600;
}

/* Dropdown Styles */
.dropdown-arrow {
    width: 1rem;
    height: 1rem;
    transition: transform 0.2s ease;
}

.dropdown-menu {
    background: var(--bg-secondary, #ffffff);
    border: 1px solid var(--border-color, #e8e8e0);
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
    color: var(--text-primary, #1a1a1a);
}

.dropdown-item:hover {
    background: rgba(74, 124, 40, 0.08);
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
    color: var(--text-secondary, #3a3a3a);
    opacity: 0.8;
}

/* Button Styles */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #7ba65d 0%, #4a7c28 100%);
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
    border-radius: 2rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(74, 124, 40, 0.2);
}

@media (min-width: 640px) {
    .btn-primary {
        padding: 0.625rem 1.25rem;
        font-size: 0.9375rem;
    }
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 124, 40, 0.3);
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
    background: var(--bg-secondary, #ffffff);
    color: var(--primary, #2d5016);
    font-weight: 600;
    font-size: 0.9375rem;
    border: 2px solid var(--primary-soft, #7ba65d);
    border-radius: 2rem;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: rgba(74, 124, 40, 0.08);
    border-color: var(--primary, #2d5016);
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
    color: var(--text-secondary, #3a3a3a);
    background: var(--bg-secondary, #ffffff);
    border: 1px solid var(--border-color, #e8e8e0);
    transition: all 0.2s ease;
}

.search-btn:hover,
.whatsapp-btn:hover {
    color: var(--primary, #2d5016);
    border-color: var(--primary-soft, #7ba65d);
    background: rgba(74, 124, 40, 0.08);
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
    background: var(--bg-secondary, #ffffff);
    border: 2px solid var(--border-color, #e8e8e0);
    border-radius: 1rem;
    font-size: 0.875rem;
    color: var(--text-primary, #1a1a1a);
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
    border-color: var(--primary-soft, #7ba65d);
    box-shadow: 0 0 0 3px rgba(74, 124, 40, 0.1);
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
    background: var(--primary, #2d5016);
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
    background: var(--primary-soft, #7ba65d);
}

/* Mobile Menu */
.mobile-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.75rem;
    background: var(--bg-secondary, #ffffff);
    border: 1px solid var(--border-color, #e8e8e0);
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
    background: var(--text-primary, #1a1a1a);
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

/* Mobile Menu Drawer - Fixed full height */
.mobile-menu {
    background: var(--bg-primary, #faf7f2);
    box-shadow: 2px 0 20px rgba(0, 0, 0, 0.1);
    z-index: 99999 !important;
    position: fixed !important;
    top: 0 !important;
    bottom: 0 !important;
    left: 0 !important;
    height: 100vh !important;
    height: 100dvh !important; /* Dynamic viewport height for mobile */
    max-height: none !important;
    min-height: 100vh !important;
}

.mobile-menu-header {
    background: var(--bg-secondary, #ffffff);
    border-bottom: 1px solid var(--border-color, #e8e8e0);
    color: var(--text-primary, #1a1a1a);
}

.mobile-close {
    width: 2.25rem;
    height: 2.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.5rem;
    color: var(--text-secondary, #3a3a3a);
    transition: all 0.2s ease;
}

.mobile-close:hover {
    background: rgba(0, 0, 0, 0.05);
    color: var(--text-primary, #1a1a1a);
}

.mobile-nav-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    color: var(--text-primary, #1a1a1a);
    font-weight: 500;
    font-size: 0.9375rem;
    transition: all 0.2s ease;
}

.mobile-nav-link:hover {
    background: rgba(74, 124, 40, 0.08);
    color: var(--primary, #2d5016);
}

.mobile-nav-link.active {
    background: rgba(74, 124, 40, 0.12);
    color: var(--primary, #2d5016);
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
    border-left: 2px solid var(--border-color, #e8e8e0);
}

.mobile-submenu-link {
    display: block;
    padding: 0.5rem 0.75rem;
    color: var(--text-secondary, #3a3a3a);
    font-size: 0.875rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
}

.mobile-submenu-link:hover {
    background: rgba(74, 124, 40, 0.08);
    color: var(--primary, #2d5016);
}

/* Dark Mode Support */
[data-theme="dark"] {
    --bg-primary: #0f1419;
    --bg-secondary: #1a1f2e;
    --border-color: #2a2f3a;
    --text-primary: #e4e6ea;
    --text-secondary: #b8bcc8;
    --primary: #a3c394;
    --primary-soft: #6b9654;
}

[data-theme="dark"] .site-header {
    background: #0f1419;
}

[data-theme="dark"] .header-backdrop {
    background: rgba(15, 20, 25, 0.95);
}

[data-theme="dark"] .dropdown-menu,
[data-theme="dark"] .mobile-menu {
    background: #1a1f2e;
    border-color: #2a2f3a;
}

[data-theme="dark"] .search-btn,
[data-theme="dark"] .whatsapp-btn,
[data-theme="dark"] .mobile-toggle,
[data-theme="dark"] .btn-secondary {
    background: #1a1f2e;
    border-color: #2a2f3a;
}

[data-theme="dark"] .search-input {
    background: #1a1f2e;
    border-color: #2a2f3a;
}

[data-theme="dark"] .mobile-menu-header {
    background: #242938;
    border-color: #2a2f3a;
}

/* Responsive Breakpoints */
@media (min-width: 360px) {
    /* Slightly larger phones */
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