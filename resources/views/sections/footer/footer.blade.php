{{-- Self-contained Premium Footer Section - Blitz Theme --}}
@props([
    'showNewsletter' => get_theme_mod('footer_show_newsletter', true),
    'showSocial' => get_theme_mod('footer_show_social', true),
    'variant' => get_theme_mod('footer_variant', 'gradient'), // gradient, dark, light
])

<footer class="site-footer relative overflow-hidden mt-auto" role="contentinfo">
    {{-- Background with variant support --}}
    <div class="footer-bg absolute inset-0 
        {{ $variant === 'gradient' ? 'bg-gradient-to-br from-primary-dark via-primary to-primary-dark' : '' }}
        {{ $variant === 'dark' ? 'bg-gray-900' : '' }}
        {{ $variant === 'light' ? 'bg-gray-100' : '' }}">
    </div>
    
    {{-- Animated Orbs (only for gradient variant) --}}
    @if($variant === 'gradient')
        <div class="absolute top-0 left-0 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent/10 rounded-full blur-3xl animate-float" style="animation-delay: 3s;"></div>
    @endif
    
    {{-- Wave Decoration --}}
    <div class="relative">
        <svg class="w-full h-12 {{ $variant === 'light' ? 'fill-gray-100' : 'fill-white dark:fill-gray-900' }}" 
             viewBox="0 0 1200 120" 
             preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
    
    <div class="relative z-10 {{ $variant === 'light' ? 'text-gray-900' : 'text-white' }}">
        <div class="container max-w-7xl mx-auto px-6 lg:px-8 py-16">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                
                {{-- Brand Section --}}
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-14 h-14 {{ $variant === 'light' ? 'bg-gray-200' : 'bg-white/10' }} backdrop-blur rounded-xl flex items-center justify-center">
                            @if(has_custom_logo())
                                @php
                                    $custom_logo_id = get_theme_mod('custom_logo');
                                    $logo = wp_get_attachment_image($custom_logo_id, 'thumbnail', false, [
                                        'class' => 'w-8 h-8 object-contain' . ($variant !== 'light' ? ' filter brightness-0 invert' : ''),
                                        'alt' => get_bloginfo('name')
                                    ]);
                                @endphp
                                {!! $logo !!}
                            @else
                                <span class="text-2xl font-bold">{{ substr(get_bloginfo('name'), 0, 1) }}</span>
                            @endif
                        </div>
                        <div>
                            <p class="font-bold text-xl">{{ get_bloginfo('name') }}</p>
                            @if($tagline = get_bloginfo('description'))
                                <p class="text-xs {{ $variant === 'light' ? 'text-gray-600' : 'opacity-70' }}">{{ $tagline }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <p class="{{ $variant === 'light' ? 'text-gray-700' : 'text-white/80' }} text-sm leading-relaxed mb-6">
                        {{ get_theme_mod('footer_description', __('Building amazing digital experiences with modern web technologies.', 'blitz')) }}
                    </p>
                    
                    {{-- Social Icons --}}
                    @if($showSocial)
                        @php
                            $social_links = app('blitz.theme')->getSocialLinks();
                        @endphp
                        @if(!empty($social_links))
                            <div class="flex gap-3">
                                @foreach($social_links as $platform => $url)
                                    <a href="{{ $url }}" 
                                       target="_blank" 
                                       rel="noopener noreferrer" 
                                       class="social-icon"
                                       aria-label="{{ ucfirst($platform) }}">
                                        @include('partials.social-icons.' . $platform)
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
                
                {{-- Footer Menus --}}
                @for($i = 1; $i <= 3; $i++)
                    <div>
                        @if(has_nav_menu('footer_menu_' . $i))
                            @php
                                $locations = get_nav_menu_locations();
                                $menu_id = $locations['footer_menu_' . $i] ?? 0;
                                $menu_obj = wp_get_nav_menu_object($menu_id);
                            @endphp
                            <h3 class="font-semibold text-lg mb-4">
                                {{ $menu_obj->name ?? __('Menu', 'blitz') . ' ' . $i }}
                            </h3>
                            {!! wp_nav_menu([
                                'theme_location' => 'footer_menu_' . $i,
                                'container' => false,
                                'menu_class' => 'footer-links space-y-3',
                                'echo' => false,
                                'depth' => 1
                            ]) !!}
                        @else
                            {{-- Default menus if not configured --}}
                            @if($i == 1)
                                <h3 class="font-semibold text-lg mb-4">{{ __('Quick Links', 'blitz') }}</h3>
                                <ul class="footer-links space-y-3">
                                    <li><a href="{{ home_url('/about') }}">{{ __('About Us', 'blitz') }}</a></li>
                                    <li><a href="{{ home_url('/services') }}">{{ __('Services', 'blitz') }}</a></li>
                                    <li><a href="{{ home_url('/portfolio') }}">{{ __('Portfolio', 'blitz') }}</a></li>
                                    <li><a href="{{ home_url('/blog') }}">{{ __('Blog', 'blitz') }}</a></li>
                                </ul>
                            @elseif($i == 2)
                                <h3 class="font-semibold text-lg mb-4">{{ __('Support', 'blitz') }}</h3>
                                <ul class="footer-links space-y-3">
                                    <li><a href="{{ home_url('/contact') }}">{{ __('Contact', 'blitz') }}</a></li>
                                    <li><a href="{{ home_url('/faq') }}">{{ __('FAQ', 'blitz') }}</a></li>
                                    <li><a href="{{ home_url('/help') }}">{{ __('Help Center', 'blitz') }}</a></li>
                                    <li><a href="{{ home_url('/docs') }}">{{ __('Documentation', 'blitz') }}</a></li>
                                </ul>
                            @elseif($i == 3)
                                <h3 class="font-semibold text-lg mb-4">{{ __('Contact', 'blitz') }}</h3>
                                <ul class="space-y-4">
                                    @php
                                        $contact_info = app('blitz.theme')->getContactInfo();
                                    @endphp
                                    
                                    @if(!empty($contact_info['email']))
                                        <li class="flex items-start gap-3">
                                            <div class="w-8 h-8 {{ $variant === 'light' ? 'bg-gray-200' : 'bg-white/20' }} rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <a href="mailto:{{ $contact_info['email'] }}" class="hover:underline">
                                                {{ $contact_info['email'] }}
                                            </a>
                                        </li>
                                    @endif
                                    
                                    @if(!empty($contact_info['phone']))
                                        <li class="flex items-start gap-3">
                                            <div class="w-8 h-8 {{ $variant === 'light' ? 'bg-gray-200' : 'bg-white/20' }} rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                </svg>
                                            </div>
                                            <a href="tel:{{ $contact_info['phone'] }}" class="hover:underline">
                                                {{ $contact_info['phone'] }}
                                            </a>
                                        </li>
                                    @endif
                                    
                                    @if(!empty($contact_info['address']))
                                        <li class="flex items-start gap-3">
                                            <div class="w-8 h-8 {{ $variant === 'light' ? 'bg-gray-200' : 'bg-white/20' }} rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </div>
                                            <span>{{ $contact_info['address'] }}</span>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        @endif
                    </div>
                @endfor
            </div>
            
            {{-- Newsletter Section --}}
            @if($showNewsletter)
                <div class="mt-12 p-8 {{ $variant === 'light' ? 'bg-white' : 'bg-white/10' }} backdrop-blur rounded-2xl border {{ $variant === 'light' ? 'border-gray-200' : 'border-white/20' }}"
                     x-data="newsletterForm()">
                    <div class="grid md:grid-cols-2 gap-6 items-center">
                        <div>
                            <h3 class="font-bold text-2xl mb-2">{{ __('Stay Updated', 'blitz') }}</h3>
                            <p class="{{ $variant === 'light' ? 'text-gray-700' : 'text-white/80' }}">
                                {{ __('Get the latest news and updates delivered to your inbox.', 'blitz') }}
                            </p>
                        </div>
                        <form @submit.prevent="submit" class="newsletter-form flex gap-3">
                            @csrf
                            <input type="email" 
                                   name="email"
                                   x-model="email"
                                   placeholder="{{ __('Your email', 'blitz') }}" 
                                   required
                                   :disabled="loading"
                                   class="flex-1 px-4 py-3 {{ $variant === 'light' ? 'bg-gray-50 border-gray-300 text-gray-900' : 'bg-white/10 border-white/20 text-white placeholder-white/60' }} backdrop-blur border rounded-full focus:outline-none focus:ring-2 focus:ring-primary">
                            <button type="submit" 
                                    :disabled="loading"
                                    class="px-6 py-3 bg-accent hover:bg-accent-dark text-white font-medium rounded-full transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!loading">{{ __('Subscribe', 'blitz') }}</span>
                                <span x-show="loading" class="inline-flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{ __('Processing...', 'blitz') }}
                                </span>
                            </button>
                        </form>
                    </div>
                    <div x-show="message" 
                         x-transition
                         class="mt-4 p-3 rounded-lg text-sm"
                         :class="success ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                         x-text="message">
                    </div>
                </div>
            @endif
            
            {{-- Bottom Section --}}
            <div class="mt-12 pt-8 border-t {{ $variant === 'light' ? 'border-gray-200' : 'border-white/20' }}">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="{{ $variant === 'light' ? 'text-gray-600' : 'text-white/70' }} text-sm">
                        © {{ date('Y') }} {{ get_bloginfo('name') }}. {{ __('All rights reserved.', 'blitz') }}
                    </div>
                    
                    <div class="flex flex-wrap gap-6 text-sm">
                        @php
                            $privacy_page = get_privacy_policy_url();
                            $terms_page = get_page_by_path('terms');
                            $cookies_page = get_page_by_path('cookies');
                        @endphp
                        
                        @if($privacy_page)
                            <a href="{{ $privacy_page }}" class="{{ $variant === 'light' ? 'text-gray-600 hover:text-gray-900' : 'text-white/70 hover:text-white' }} transition-colors">
                                {{ __('Privacy Policy', 'blitz') }}
                            </a>
                        @endif
                        
                        @if($terms_page)
                            <a href="{{ get_permalink($terms_page) }}" class="{{ $variant === 'light' ? 'text-gray-600 hover:text-gray-900' : 'text-white/70 hover:text-white' }} transition-colors">
                                {{ __('Terms of Service', 'blitz') }}
                            </a>
                        @endif
                        
                        @if($cookies_page)
                            <a href="{{ get_permalink($cookies_page) }}" class="{{ $variant === 'light' ? 'text-gray-600 hover:text-gray-900' : 'text-white/70 hover:text-white' }} transition-colors">
                                {{ __('Cookie Policy', 'blitz') }}
                            </a>
                        @endif
                        
                        <a href="{{ home_url('/sitemap.xml') }}" class="{{ $variant === 'light' ? 'text-gray-600 hover:text-gray-900' : 'text-white/70 hover:text-white' }} transition-colors">
                            {{ __('Sitemap', 'blitz') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
/* Footer Styles */
.site-footer {
    --primary: theme('colors.blue.500');
    --primary-dark: theme('colors.blue.700');
    --accent: theme('colors.orange.500');
    --accent-dark: theme('colors.orange.600');
}

/* Social Icons */
.social-icon {
    @apply w-10 h-10 flex items-center justify-center rounded-full transition-all duration-300;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.social-icon:hover {
    @apply -translate-y-0.5;
    background: rgba(255, 255, 255, 0.2);
}

[data-theme="light"] .social-icon {
    @apply bg-gray-200 border-gray-300 text-gray-700;
}

[data-theme="light"] .social-icon:hover {
    @apply bg-gray-300;
}

/* Footer Links */
.footer-links a {
    @apply flex items-center gap-2 transition-all duration-200;
}

.footer-links a:hover {
    @apply translate-x-1;
}

.footer-links a::before {
    content: '';
    @apply w-1 h-1 rounded-full transition-all duration-300;
    background: var(--accent);
}

.footer-links a:hover::before {
    @apply w-4;
    border-radius: 2px;
}

/* Newsletter Form */
.newsletter-form.loading {
    @apply opacity-70 pointer-events-none;
}

/* Animations */
@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    33% { transform: translateY(-20px) rotate(2deg); }
    66% { transform: translateY(10px) rotate(-1deg); }
}

.animate-float {
    animation: float 15s ease-in-out infinite;
}

/* Responsive */
@media (max-width: 768px) {
    .footer-links {
        @apply flex flex-wrap gap-4;
    }
    
    .footer-links a::before {
        @apply hidden;
    }
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('newsletterForm', () => ({
        email: '',
        loading: false,
        success: false,
        message: '',
        
        async submit() {
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
                    this.message = result.data.message || '{{ __("Thank you for subscribing!", "blitz") }}';
                    this.email = '';
                    
                    // Hide message after 5 seconds
                    setTimeout(() => {
                        this.message = '';
                    }, 5000);
                } else {
                    this.success = false;
                    this.message = result.data.message || '{{ __("Something went wrong. Please try again.", "blitz") }}';
                }
            } catch (error) {
                console.error('Newsletter error:', error);
                this.success = false;
                this.message = '{{ __("Network error. Please try again.", "blitz") }}';
            } finally {
                this.loading = false;
            }
        }
    }));
});
</script>