{{-- resources/views/sections/footer/footer-minimal.blade.php --}}
{{-- Minimal Elegant Footer - With Dark Mode Support --}}

@php
    $site_name = get_bloginfo('name');
    $site_description = get_bloginfo('description');
    $current_year = date('Y');
    
    // Get theme customizer settings
    $show_social = get_theme_mod('footer_show_social', true);
    $footer_text = get_theme_mod('footer_copyright_text', '');
    
    // Contact info
    $email = get_theme_mod('contact_email', '');
    $phone = get_theme_mod('contact_phone', '');
    
    // Get custom logo
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = $custom_logo_id ? wp_get_attachment_image_src($custom_logo_id, 'thumbnail') : null;
@endphp

<footer class="footer-minimal relative mt-auto" role="contentinfo">
    {{-- Simple gradient line decoration --}}
    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent dark:via-gray-700"></div>
    
    <div class="bg-white dark:bg-gray-900 py-12 md:py-16 transition-colors duration-200">
        <div class="container max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Main Footer Content --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 items-start">
                
                {{-- Brand Column --}}
                <div class="text-center md:text-left">
                    <a href="{{ home_url('/') }}" class="inline-flex items-center gap-3 group mb-4">
                        @if($logo)
                            <img src="{{ $logo[0] }}" 
                                 alt="{{ $site_name }}" 
                                 class="h-8 w-auto dark:brightness-0 dark:invert transition-all duration-200">
                        @else
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold">
                                {{ substr($site_name, 0, 1) }}
                            </div>
                        @endif
                        <span class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            {{ $site_name }}
                        </span>
                    </a>
                    
                    @if($site_description)
                        <p class="text-sm text-gray-600 dark:text-gray-400 transition-colors">
                            {{ $site_description }}
                        </p>
                    @endif
                </div>
                
                {{-- Quick Links --}}
                <nav class="text-center" aria-label="Footer navigation">
                    @if(has_nav_menu('footer_menu_minimal'))
                        @php
                            $menu_items = wp_get_nav_menu_items(get_nav_menu_locations()['footer_menu_minimal']);
                        @endphp
                        @if($menu_items)
                            <ul class="inline-flex flex-wrap justify-center gap-x-6 gap-y-2">
                                @foreach($menu_items as $item)
                                    @if($item->menu_item_parent == 0)
                                        <li>
                                            <a href="{{ $item->url }}" 
                                               class="footer-link">
                                                {{ $item->title }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    @else
                        {{-- Fallback links --}}
                        <ul class="inline-flex flex-wrap justify-center gap-x-6 gap-y-2">
                            <li><a href="{{ home_url('/about') }}" class="footer-link">About</a></li>
                            <li><a href="{{ home_url('/services') }}" class="footer-link">Services</a></li>
                            <li><a href="{{ home_url('/contact') }}" class="footer-link">Contact</a></li>
                            <li><a href="{{ get_privacy_policy_url() }}" class="footer-link">Privacy</a></li>
                        </ul>
                    @endif
                </nav>
                
                {{-- Contact/Social Column --}}
                <div class="text-center md:text-right">
                    @if($email || $phone)
                        <div class="space-y-2 mb-4">
                            @if($email)
                                <a href="mailto:{{ $email }}" 
                                   class="block text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                    {{ $email }}
                                </a>
                            @endif
                            @if($phone)
                                <a href="tel:{{ $phone }}" 
                                   class="block text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                    {{ $phone }}
                                </a>
                            @endif
                        </div>
                    @endif
                    
                    @if($show_social)
                        @php
                            $social_platforms = [
                                'facebook' => get_theme_mod('social_facebook'),
                                'instagram' => get_theme_mod('social_instagram'),
                                'twitter' => get_theme_mod('social_twitter'),
                                'linkedin' => get_theme_mod('social_linkedin'),
                                'youtube' => get_theme_mod('social_youtube'),
                            ];
                            $has_social = array_filter($social_platforms);
                        @endphp
                        
                        @if(!empty($has_social))
                            <div class="flex justify-center md:justify-end gap-3">
                                @foreach($social_platforms as $platform => $url)
                                    @if($url)
                                        <a href="{{ $url }}" 
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="social-minimal"
                                           aria-label="{{ ucfirst($platform) }}">
                                            {{-- SVG icons here --}}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            
            {{-- Copyright Bar --}}
            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-800 transition-colors">
                <p class="text-center text-xs text-gray-500 dark:text-gray-400 transition-colors">
                    @if($footer_text)
                        {{ $footer_text }}
                    @else
                        © {{ $current_year }} {{ $site_name }}. All rights reserved.
                    @endif
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
/* Minimal Footer Styles with Dark Mode Support */
.footer-minimal {
    contain: layout style;
}

/* CSS variables for theming */
:root {
    --footer-bg: theme('colors.white');
    --footer-text: theme('colors.gray.600');
    --footer-text-hover: theme('colors.gray.900');
    --footer-border: theme('colors.gray.200');
    --footer-social-bg: theme('colors.gray.100');
    --footer-social-hover: theme('colors.gray.200');
}

[data-theme="dark"] {
    --footer-bg: theme('colors.gray.900');
    --footer-text: theme('colors.gray.400');
    --footer-text-hover: theme('colors.white');
    --footer-border: theme('colors.gray.800');
    --footer-social-bg: theme('colors.gray.800');
    --footer-social-hover: theme('colors.gray.700');
}

.footer-link {
    @apply text-sm transition-colors duration-200;
    color: var(--footer-text);
}

.footer-link:hover {
    color: var(--footer-text-hover);
}

.social-minimal {
    @apply w-9 h-9 flex items-center justify-center rounded-lg transition-all duration-200;
    background: var(--footer-social-bg);
    color: var(--footer-text);
}

.social-minimal:hover {
    background: var(--footer-social-hover);
    color: var(--footer-text-hover);
    transform: translateY(-2px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .footer-minimal .container {
        @apply px-4;
    }
}
</style>