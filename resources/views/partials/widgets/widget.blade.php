{{-- 
  Widget Templates for Sidebar
  These are inline templates that can be included in the sidebar
--}}

{{-- Popular Posts Widget Template --}}
@section('popular-posts-inline')
    @php
        $popular_posts = get_posts([
            'numberposts' => 5,
            'meta_key' => 'post_views_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        ]);
    @endphp

    @if($popular_posts)
        <div class="widget widget-popular-posts" x-data="{ loading: false }">
            <h3 class="widget-title flex items-center gap-2">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                {{ __('Popular Posts', 'blitz') }}
            </h3>
            
            <ul class="popular-posts-list space-y-4">
                @foreach($popular_posts as $index => $post)
                    <li class="popular-post-item group">
                        <div class="flex gap-3 items-start">
                            {{-- Post thumbnail --}}
                            @if(has_post_thumbnail($post->ID))
                                <div class="flex-shrink-0">
                                    <img src="{{ get_the_post_thumbnail_url($post->ID, 'thumbnail') }}" 
                                         alt="{{ get_the_title($post->ID) }}"
                                         class="w-16 h-16 rounded-lg object-cover transition-transform duration-300 group-hover:scale-105">
                                </div>
                            @endif
                            
                            {{-- Post content --}}
                            <div class="flex-1 min-w-0">
                                {{-- Post rank --}}
                                <div class="text-xs font-bold text-accent mb-1">
                                    #{{ $index + 1 }}
                                </div>
                                
                                {{-- Post title --}}
                                <a href="{{ get_permalink($post->ID) }}" 
                                   class="font-medium text-text-primary hover:text-primary transition-colors line-clamp-2 text-sm leading-snug">
                                    {{ get_the_title($post->ID) }}
                                </a>
                                
                                {{-- Post meta --}}
                                <div class="flex items-center gap-3 text-xs text-text-muted mt-2">
                                    <time datetime="{{ get_the_time('c', $post->ID) }}">
                                        {{ get_the_date('M j', $post->ID) }}
                                    </time>
                                    @if(function_exists('get_post_views'))
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ number_format_i18n(get_post_views($post->ID)) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            
            {{-- View all link --}}
            @if(get_option('page_for_posts'))
                <div class="mt-4 pt-4 border-t border-border-color">
                    <a href="{{ get_permalink(get_option('page_for_posts')) }}" 
                       class="inline-flex items-center gap-2 text-sm text-primary hover:text-primary-dark transition-colors font-medium">
                        <span>{{ __('View All Posts', 'blitz') }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    @endif
@endsection

{{-- Newsletter Widget Template --}}
@section('newsletter-inline')
    <div class="widget widget-newsletter bg-gradient-to-br from-primary/5 to-primary-soft/10 border-primary/20 relative overflow-hidden"
         x-data="newsletterWidget()">
        
        {{-- Background pattern --}}
        <div class="absolute top-0 right-0 opacity-10">
            <svg class="w-20 h-20 text-primary" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
        </div>
        
        <div class="relative">
            <h3 class="widget-title flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                {{ __('Stay Updated', 'blitz') }}
            </h3>
            
            <p class="text-sm text-text-secondary mb-4 leading-relaxed">
                {{ __('Get the latest posts and updates delivered directly to your inbox. Join our community!', 'blitz') }}
            </p>
            
            {{-- Success message --}}
            <div x-show="success" 
                 x-transition
                 class="mb-4 p-3 bg-green-100 border border-green-200 rounded-lg">
                <div class="flex items-center gap-2 text-green-800 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ __('Thank you for subscribing!', 'blitz') }}</span>
                </div>
            </div>
            
            {{-- Error message --}}
            <div x-show="error" 
                 x-transition
                 class="mb-4 p-3 bg-red-100 border border-red-200 rounded-lg">
                <div class="flex items-center gap-2 text-red-800 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span x-text="errorMessage">{{ __('Please try again.', 'blitz') }}</span>
                </div>
            </div>
            
            {{-- Newsletter form --}}
            <form @submit.prevent="subscribe" class="newsletter-form" x-show="!success">
                <div class="space-y-3">
                    <div class="relative">
                        <input type="email" 
                               x-model="email"
                               name="email" 
                               placeholder="{{ __('Your email address', 'blitz') }}"
                               class="w-full px-4 py-3 border border-border-color rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm pr-12"
                               required>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg x-show="!loading" class="w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                            <div x-show="loading" class="animate-spin rounded-full h-5 w-5 border-b-2 border-primary"></div>
                        </div>
                    </div>
                    
                    <button type="submit" 
                            :disabled="loading"
                            class="w-full px-4 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark disabled:opacity-50 transition-all text-sm font-medium flex items-center justify-center gap-2">
                        <span x-show="!loading">{{ __('Subscribe Now', 'blitz') }}</span>
                        <span x-show="loading">{{ __('Subscribing...', 'blitz') }}</span>
                        <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </div>
                
                <p class="text-xs text-text-muted mt-3 text-center">
                    {{ __('We respect your privacy. Unsubscribe anytime.', 'blitz') }}
                </p>
            </form>
        </div>
        
        {{-- Newsletter widget script --}}
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('newsletterWidget', () => ({
                    email: '',
                    loading: false,
                    success: false,
                    error: false,
                    errorMessage: '',
                    
                    async subscribe() {
                        if (!this.email || this.loading) return;
                        
                        this.loading = true;
                        this.error = false;
                        
                        try {
                            // Replace with your newsletter service endpoint
                            const response = await fetch('/wp-json/blitz/v1/newsletter/subscribe', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-WP-Nonce': window.wpApiSettings?.nonce || ''
                                },
                                body: JSON.stringify({
                                    email: this.email
                                })
                            });
                            
                            const data = await response.json();
                            
                            if (response.ok && data.success) {
                                this.success = true;
                                this.email = '';
                                
                                // Track subscription
                                if (typeof gtag !== 'undefined') {
                                    gtag('event', 'newsletter_subscribe', {
                                        'method': 'sidebar_widget',
                                        'event_category': 'engagement'
                                    });
                                }
                            } else {
                                throw new Error(data.message || 'Subscription failed');
                            }
                        } catch (error) {
                            this.error = true;
                            this.errorMessage = error.message || 'Please try again later.';
                            console.error('Newsletter subscription error:', error);
                        } finally {
                            this.loading = false;
                        }
                    }
                }));
            });
        </script>
    </div>
@endsection

{{-- Social Follow Widget Template --}}
@section('social-follow-inline')
    @php
        $socialLinks = [
            'facebook' => get_theme_mod('social_facebook', ''),
            'twitter' => get_theme_mod('social_twitter', ''),
            'instagram' => get_theme_mod('social_instagram', ''),
            'youtube' => get_theme_mod('social_youtube', ''),
            'linkedin' => get_theme_mod('social_linkedin', ''),
            'tiktok' => get_theme_mod('social_tiktok', ''),
        ];
        
        $socialIcons = [
            'facebook' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z',
            'twitter' => 'M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z',
            'instagram' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z',
            'youtube' => 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z',
            'linkedin' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z',
            'tiktok' => 'M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-.88-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z'
        ];
        
        $colorClasses = [
            'facebook' => 'hover:bg-blue-600',
            'twitter' => 'hover:bg-blue-400',
            'instagram' => 'hover:bg-pink-600',
            'youtube' => 'hover:bg-red-600',
            'linkedin' => 'hover:bg-blue-700',
            'tiktok' => 'hover:bg-black',
        ];
        
        $activeSocials = array_filter($socialLinks);
    @endphp

    @if(!empty($activeSocials))
        <div class="widget widget-social-follow" x-data="socialWidget()">
            <h3 class="widget-title flex items-center gap-2">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                {{ __('Follow Us', 'blitz') }}
            </h3>
            
            <p class="text-sm text-text-secondary mb-4">
                {{ __('Connect with us on social media for updates and behind-the-scenes content!', 'blitz') }}
            </p>
            
            <div class="social-links grid {{ count($activeSocials) > 4 ? 'grid-cols-2' : 'grid-cols-1' }} gap-3">
                @foreach($activeSocials as $platform => $url)
                    <a href="{{ $url }}" 
                       target="_blank"
                       rel="noopener noreferrer"
                       @click="trackFollow('{{ $platform }}')"
                       class="flex items-center gap-3 p-3 rounded-lg bg-bg-tertiary {{ $colorClasses[$platform] }} hover:text-white transition-all duration-300 text-sm group hover:scale-105 hover:shadow-lg">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="{{ $socialIcons[$platform] }}"/>
                        </svg>
                        <span class="font-medium">{{ ucfirst($platform) }}</span>
                        <svg class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-opacity" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                @endforeach
            </div>
            
            {{-- Follower counts (if available) --}}
            @if(get_theme_mod('show_social_counts', false))
                <div class="social-stats mt-4 pt-4 border-t border-border-color">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary" x-text="totalFollowers">
                            {{ number_format_i18n(get_theme_mod('total_followers', 0)) }}
                        </div>
                        <div class="text-sm text-text-muted">
                            {{ __('Total Followers', 'blitz') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        {{-- Social widget script --}}
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('socialWidget', () => ({
                    totalFollowers: {{ get_theme_mod('total_followers', 0) }},
                    
                    trackFollow(platform) {
                        // Track social media clicks
                        if (typeof gtag !== 'undefined') {
                            gtag('event', 'social_follow', {
                                'social_network': platform,
                                'event_category': 'social_engagement',
                                'event_label': 'sidebar_widget'
                            });
                        }
                        
                        // Update follower count (simulate)
                        if (this.totalFollowers > 0) {
                            this.totalFollowers += 1;
                        }
                    }
                }));
            });
        </script>
    @endif
@endsection

{{-- Recent Comments Widget Template --}}
@section('recent-comments-inline')
    @php
        $recent_comments = get_comments([
            'number' => 5,
            'status' => 'approve',
            'post_status' => 'publish'
        ]);
    @endphp

    @if($recent_comments)
        <div class="widget widget-recent-comments">
            <h3 class="widget-title flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                {{ __('Recent Comments', 'blitz') }}
            </h3>
            
            <ul class="recent-comments-list space-y-4">
                @foreach($recent_comments as $comment)
                    <li class="recent-comment-item group">
                        <div class="flex gap-3 items-start">
                            {{-- Commenter avatar --}}
                            <div class="flex-shrink-0">
                                <img src="{{ get_avatar_url($comment->comment_author_email, ['size' => 40]) }}" 
                                     alt="{{ $comment->comment_author }}"
                                     class="w-10 h-10 rounded-full border-2 border-border-color">
                            </div>
                            
                            {{-- Comment content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="font-medium text-text-primary text-sm">
                                        {{ $comment->comment_author }}
                                    </div>
                                    <time class="text-xs text-text-muted" 
                                          datetime="{{ get_comment_date('c', $comment) }}">
                                        {{ human_time_diff(strtotime($comment->comment_date), current_time('timestamp')) }} {{ __('ago', 'blitz') }}
                                    </time>
                                </div>
                                
                                <div class="text-sm text-text-secondary mb-2 leading-relaxed">
                                    {{ wp_trim_words($comment->comment_content, 12) }}
                                </div>
                                
                                <a href="{{ get_comment_link($comment) }}" 
                                   class="text-xs text-primary hover:text-primary-dark transition-colors flex items-center gap-1">
                                    {{ __('on', 'blitz') }} {{ get_the_title($comment->comment_post_ID) }}
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

{{-- Archive Widget Template --}}
@section('archives-inline')
    @php
        $archives = wp_get_archives([
            'type' => 'monthly',
            'limit' => 12,
            'echo' => 0,
            'format' => 'array'
        ]);
    @endphp

    @if($archives)
        <div class="widget widget-archives" x-data="{ expanded: false }">
            <h3 class="widget-title flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ __('Archives', 'blitz') }}
            </h3>
            
            <div class="archives-list">
                <ul class="space-y-2">
                    @foreach(array_slice($archives, 0, 6) as $archive)
                        <li class="archive-item">
                            {!! $archive !!}
                        </li>
                    @endforeach
                </ul>
                
                @if(count($archives) > 6)
                    <div x-show="expanded" x-transition class="mt-2">
                        <ul class="space-y-2">
                            @foreach(array_slice($archives, 6) as $archive)
                                <li class="archive-item">
                                    {!! $archive !!}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <button @click="expanded = !expanded" 
                            class="mt-3 text-sm text-primary hover:text-primary-dark transition-colors flex items-center gap-1">
                        <span x-text="expanded ? '{{ __('Show Less', 'blitz') }}' : '{{ __('Show More', 'blitz') }}'"></span>
                        <svg class="w-4 h-4 transition-transform" 
                             :class="{ 'rotate-180': expanded }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    @endif
@endsection