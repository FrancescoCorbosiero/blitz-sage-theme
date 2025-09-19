{{-- resources/views/sections/footer/footer-full.blade.php --}}
{{-- Full-Featured Footer with Widgets & Newsletter - Fully Responsive --}}

@php
    $site_name = get_bloginfo('name');
    $site_description = get_bloginfo('description');
    $current_year = date('Y');
    
    // Theme settings
    $show_newsletter = get_theme_mod('footer_show_newsletter', true);
    $show_social = get_theme_mod('footer_show_social', true);
    $footer_bg = get_theme_mod('footer_background', 'gradient');
    $newsletter_title = get_theme_mod('newsletter_title', 'Stay Updated');
    $newsletter_desc = get_theme_mod('newsletter_description', 'Get the latest news and updates.');
    
    // Contact info
    $contact = [
        'email' => get_theme_mod('contact_email', ''),
        'phone' => get_theme_mod('contact_phone', ''),
        'address' => get_theme_mod('contact_address', ''),
        'whatsapp' => get_theme_mod('whatsapp_number', ''),
    ];
    
    // Logo
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = $custom_logo_id ? wp_get_attachment_image_src($custom_logo_id, 'thumbnail') : null;

    // Theme variant detection
    $theme_variant = get_theme_mod('footer_theme_variant', 'auto'); // auto, always-dark, always-light
@endphp

<footer class="footer-full relative overflow-hidden mt-auto" 
        role="contentinfo"
        :class="{ 'dark-theme': {{ $theme_variant === 'always-dark' ? 'true' : 'false' }} || ({{ $theme_variant === 'auto' ? 'true' : 'false' }} && $store.theme.isDark) }">
    {{-- Background Gradient --}}
    <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900"></div>
    
    {{-- Decorative Elements --}}
    <div class="absolute top-0 left-0 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute top-0 right-0 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    <div class="absolute bottom-0 left-1/2 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    
    <div class="relative z-10">
        {{-- Newsletter Section --}}
        @if($show_newsletter)
        <div class="bg-white/5 backdrop-blur-sm border-b border-white/10">
            <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
                <div class="max-w-4xl mx-auto" x-data="newsletter()">
                    <div class="grid md:grid-cols-2 gap-6 items-center">
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-2">{{ $newsletter_title }}</h3>
                            <p class="text-gray-300">{{ $newsletter_desc }}</p>
                        </div>
                        <form @submit.prevent="subscribe" class="flex flex-col sm:flex-row gap-3">
                            @csrf
                            <input type="email" 
                                   x-model="email"
                                   placeholder="Enter your email"
                                   required
                                   :disabled="loading"
                                   class="flex-1 px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-white/40 focus:bg-white/20 transition-all">
                            <button type="submit"
                                    :disabled="loading"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed whitespace-nowrap">
                                <span x-show="!loading">Subscribe</span>
                                <span x-show="loading" class="flex items-center justify-center">
                                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                </span>
                            </button>
                        </form>
                    </div>
                    <div x-show="message" 
                         x-transition
                         class="mt-4 p-3 rounded-lg text-sm"
                         :class="success ? 'bg-green-500/20 text-green-300 border border-green-500/30' : 'bg-red-500/20 text-red-300 border border-red-500/30'"
                         x-text="message">
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        {{-- Main Footer Content --}}
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12">
                
                {{-- Brand Section - Spans 4 columns --}}
                <div class="lg:col-span-4">
                    <div class="mb-6">
                        <a href="{{ home_url('/') }}" class="inline-flex items-center gap-3 group">
                            <div class="w-12 h-12 bg-white/10 backdrop-blur rounded-xl flex items-center justify-center">
                                @if($logo)
                                    <img src="{{ $logo[0] }}" alt="{{ $site_name }}" class="h-8 w-auto">
                                @else
                                    <span class="text-2xl font-bold text-white">{{ substr($site_name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <p class="font-bold text-xl text-white">{{ $site_name }}</p>
                                @if($site_description)
                                    <p class="text-xs text-gray-400">{{ $site_description }}</p>
                                @endif
                            </div>
                        </a>
                    </div>
                    
                    <p class="text-gray-300 text-sm mb-6 max-w-xs">
                        {{ get_theme_mod('footer_description', 'Building amazing digital experiences with modern web technologies.') }}
                    </p>
                    
                    @if($show_social)
                        @php
                            $social_platforms = [
                                'facebook' => get_theme_mod('social_facebook'),
                                'instagram' => get_theme_mod('social_instagram'),  
                                'twitter' => get_theme_mod('social_twitter'),
                                'linkedin' => get_theme_mod('social_linkedin'),
                                'youtube' => get_theme_mod('social_youtube'),
                                'tiktok' => get_theme_mod('social_tiktok'),
                            ];
                            $has_social = array_filter($social_platforms);
                        @endphp
                        
                        @if(!empty($has_social))
                            <div class="flex flex-wrap gap-2">
                                @foreach($social_platforms as $platform => $url)
                                    @if($url)
                                        <a href="{{ $url }}" 
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="social-icon-full"
                                           aria-label="{{ ucfirst($platform) }}">
                                            {{-- Icons same as minimal version --}}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
                
                {{-- Dynamic Widget Areas - Spans 8 columns --}}
                <div class="lg:col-span-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @if(is_active_sidebar('footer-widget-1'))
                            <div class="footer-widget">
                                @php dynamic_sidebar('footer-widget-1') @endphp
                            </div>
                        @else
                            <div>
                                <h3 class="font-semibold text-white mb-4">Quick Links</h3>
                                @if(has_nav_menu('footer_menu_1'))
                                    {!! wp_nav_menu([
                                        'theme_location' => 'footer_menu_1',
                                        'container' => false,
                                        'menu_class' => 'space-y-2',
                                        'echo' => false,
                                        'walker' => new \App\Walkers\FooterMenuWalker()
                                    ]) !!}
                                @else
                                    <ul class="space-y-2">
                                        <li><a href="{{ home_url('/about') }}" class="footer-full-link">About Us</a></li>
                                        <li><a href="{{ home_url('/services') }}" class="footer-full-link">Services</a></li>
                                        <li><a href="{{ home_url('/portfolio') }}" class="footer-full-link">Portfolio</a></li>
                                        <li><a href="{{ home_url('/blog') }}" class="footer-full-link">Blog</a></li>
                                    </ul>
                                @endif
                            </div>
                        @endif
                        
                        @if(is_active_sidebar('footer-widget-2'))
                            <div class="footer-widget">
                                @php dynamic_sidebar('footer-widget-2') @endphp
                            </div>
                        @else
                            <div>
                                <h3 class="font-semibold text-white mb-4">Resources</h3>
                                <ul class="space-y-2">
                                    <li><a href="{{ home_url('/help') }}" class="footer-full-link">Help Center</a></li>
                                    <li><a href="{{ home_url('/documentation') }}" class="footer-full-link">Documentation</a></li>
                                    <li><a href="{{ home_url('/tutorials') }}" class="footer-full-link">Tutorials</a></li>
                                    <li><a href="{{ home_url('/faq') }}" class="footer-full-link">FAQ</a></li>
                                </ul>
                            </div>
                        @endif
                        
                        @if(is_active_sidebar('footer-widget-3'))
                            <div class="footer-widget">
                                @php dynamic_sidebar('footer-widget-3') @endphp
                            </div>
                        @else
                            <div>
                                <h3 class="font-semibold text-white mb-4">Get in Touch</h3>
                                <ul class="space-y-3">
                                    @if($contact['email'])
                                        <li class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            <a href="mailto:{{ $contact['email'] }}" class="text-gray-300 hover:text-white transition-colors text-sm">
                                                {{ $contact['email'] }}
                                            </a>
                                        </li>
                                    @endif
                                    
                                    @if($contact['phone'])
                                        <li class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            <a href="tel:{{ $contact['phone'] }}" class="text-gray-300 hover:text-white transition-colors text-sm">
                                                {{ $contact['phone'] }}
                                            </a>
                                        </li>
                                    @endif
                                    
                                    @if($contact['address'])
                                        <li class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span class="text-gray-300 text-sm">{{ $contact['address'] }}</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            {{-- Bottom Bar --}}
            <div class="mt-12 pt-8 border-t border-white/10">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-400 text-sm text-center md:text-left">
                        © {{ $current_year }} {{ $site_name }}. All rights reserved.
                    </p>
                    
                    <nav class="flex flex-wrap justify-center gap-4 md:gap-6 text-sm">
                        @if($privacy = get_privacy_policy_url())
                            <a href="{{ $privacy }}" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                        @endif
                        <a href="{{ home_url('/terms') }}" class="text-gray-400 hover:text-white transition-colors">Terms</a>
                        <a href="{{ home_url('/cookies') }}" class="text-gray-400 hover:text-white transition-colors">Cookies</a>
                        <a href="{{ home_url('/sitemap.xml') }}" class="text-gray-400 hover:text-white transition-colors">Sitemap</a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>

/* Theme-aware styles */
.footer-full {
    transition: background-color 0.3s ease, color 0.3s ease;
}

/* Auto theme switching */
[data-theme="dark"] .footer-full:not(.dark-theme) {
    /* Automatically adjust colors when not forcing dark theme */
}

/* Force dark theme variant */
.footer-full.dark-theme {
    /* Always use dark theme colors */
}

/* Newsletter input theming */
[data-theme="dark"] .footer-full input {
    @apply bg-white/10 border-white/20 text-white;
}

[data-theme="light"] .footer-full.light-variant {
    @apply bg-gray-50 text-gray-900;
}

[data-theme="light"] .footer-full.light-variant .social-icon-full {
    @apply bg-gray-200 text-gray-700 border-gray-300;
}

/* Full Footer Styles */
.footer-full {
    contain: layout style;
}

/* Social Icons */
.social-icon-full {
    @apply w-10 h-10 flex items-center justify-center rounded-lg bg-white/10 backdrop-blur border border-white/20 text-white hover:bg-white/20 transition-all duration-300;
}

.social-icon-full:hover {
    transform: translateY(-2px);
}

/* Footer Links */
.footer-full-link {
    @apply text-gray-300 hover:text-white transition-colors text-sm block py-1;
}

.footer-full-link:hover {
    transform: translateX(3px);
}

/* Widget Styling */
.footer-widget h2,
.footer-widget h3 {
    @apply font-semibold text-white mb-4;
}

.footer-widget ul {
    @apply space-y-2;
}

.footer-widget a {
    @apply text-gray-300 hover:text-white transition-colors text-sm;
}

/* Newsletter Fixes */
@media (max-width: 640px) {
    .footer-full form {
        @apply flex-col;
    }
    
    .footer-full form button {
        @apply w-full;
    }
}

/* Animations */
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('newsletter', () => ({
        email: '',
        loading: false,
        success: false,
        message: '',
        
        async subscribe() {
            this.loading = true;
            this.message = '';
            
            const formData = new FormData();
            formData.append('action', 'newsletter_signup');
            formData.append('email', this.email);
            formData.append('nonce', '{{ wp_create_nonce("newsletter_nonce") }}');
            
            try {
                const response = await fetch('{{ admin_url("admin-ajax.php") }}', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    this.success = true;
                    this.message = 'Thank you for subscribing!';
                    this.email = '';
                    setTimeout(() => this.message = '', 5000);
                } else {
                    this.success = false;
                    this.message = result.data?.message || 'Something went wrong. Please try again.';
                }
            } catch (error) {
                this.success = false;
                this.message = 'Network error. Please try again.';
            } finally {
                this.loading = false;
            }
        }
    }));
});
</script>