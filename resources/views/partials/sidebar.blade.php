{{--
  Enhanced Sidebar Component  
  Modern sidebar with dynamic widgets, sticky behavior, and responsive design
--}}

@props([
    'location' => 'sidebar-primary',        // Widget area location
    'sticky' => true,                       // Enable sticky behavior
    'collapsible' => false,                 // Enable mobile collapse
    'animate' => true,                      // Enable entrance animations
    'spacing' => 'normal',                  // tight, normal, loose
    'background' => 'default',              // default, card, transparent
])

@php
    // Check if sidebar has widgets
    $hasWidgets = is_active_sidebar($location);
    
    // Spacing configurations
    $spacingClasses = match($spacing) {
        'tight' => 'space-y-4',
        'normal' => 'space-y-6',
        'loose' => 'space-y-8',
        default => 'space-y-6'
    };
    
    // Background configurations
    $backgroundClasses = match($background) {
        'card' => 'bg-card-bg border border-border-color rounded-xl p-6',
        'transparent' => 'bg-transparent',
        default => 'bg-bg-secondary rounded-lg p-4'
    };
    
    // Additional sidebar info
    $sidebarClasses = collect([
        'sidebar',
        'sidebar-' . str_replace('sidebar-', '', $location),
        $sticky ? 'sidebar-sticky' : '',
        $animate ? 'sidebar-animated' : '',
        $backgroundClasses,
        $spacingClasses
    ])->filter()->implode(' ');
@endphp

@if($hasWidgets)
    <aside class="{{ $sidebarClasses }}"
           role="complementary"
           aria-label="{{ __('Sidebar', 'blitz') }}"
           @if($animate)
           x-data="sidebarComponent"
           x-init="init()"
           @endif
           @if($collapsible)
           x-data="{ 
               ...($data || {}), 
               collapsed: window.innerWidth < 768,
               toggle() { this.collapsed = !this.collapsed }
           }"
           @endif>
        
        {{-- Mobile Toggle Button (if collapsible) --}}
        @if($collapsible)
            <button @click="toggle()" 
                    class="sidebar-toggle md:hidden w-full flex items-center justify-between p-3 mb-4 bg-bg-tertiary border border-border-color rounded-lg text-text-primary hover:bg-bg-secondary transition-colors">
                <span class="font-medium">{{ __('Sidebar Menu', 'blitz') }}</span>
                <svg class="w-5 h-5 transition-transform duration-200"
                     :class="{ 'rotate-180': !collapsed }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
        @endif
        
        {{-- Widgets Container --}}
        <div class="sidebar-content"
             @if($collapsible)
             x-show="!collapsed || window.innerWidth >= 768"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @endif>
            
            {{-- Default WordPress Sidebar --}}
            @php(dynamic_sidebar($location))
            
        </div>
        
        {{-- Additional Custom Widgets --}}
        @if($location === 'sidebar-primary')
            {{-- Popular Posts Widget --}}
            @include('partials.widgets.popular-posts')
            
            {{-- Newsletter Subscription --}}
            @include('partials.widgets.newsletter')
            
            {{-- Social Follow --}}
            @include('partials.widgets.social-follow')
        @endif
        
        {{-- Back to Top (for long sidebars) --}}
        @if($sticky)
            <div class="sidebar-back-to-top mt-6 text-center">
                <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
                        class="inline-flex items-center gap-2 text-sm text-text-muted hover:text-primary transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    {{ __('Back to top', 'blitz') }}
                </button>
            </div>
        @endif
    </aside>
@endif

{{-- Popular Posts Widget --}}
@include('partials.widgets.popular-posts-inline')

{{-- Newsletter Widget --}}
@include('partials.widgets.newsletter-inline')

{{-- Social Follow Widget --}}
@include('partials.widgets.social-follow-inline')

{{-- Enhanced Sidebar Styles --}}
<style>
    /* Sticky sidebar behavior */
    .sidebar-sticky {
        position: sticky;
        top: 2rem;
        max-height: calc(100vh - 4rem);
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--primary-soft) var(--bg-tertiary);
    }
    
    /* Custom scrollbar for webkit browsers */
    .sidebar-sticky::-webkit-scrollbar {
        width: 6px;
    }
    
    .sidebar-sticky::-webkit-scrollbar-track {
        background: var(--bg-tertiary);
        border-radius: 3px;
    }
    
    .sidebar-sticky::-webkit-scrollbar-thumb {
        background: var(--primary-soft);
        border-radius: 3px;
    }
    
    .sidebar-sticky::-webkit-scrollbar-thumb:hover {
        background: var(--primary);
    }
    
    /* Widget styling */
    .sidebar .widget {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .sidebar .widget:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px var(--shadow);
        border-color: var(--primary)/0.2;
    }
    
    .sidebar .widget:last-child {
        margin-bottom: 0;
    }
    
    /* Widget titles */
    .sidebar .widget-title,
    .sidebar .widgettitle {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary)/0.2;
        position: relative;
    }
    
    .sidebar .widget-title::after,
    .sidebar .widgettitle::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 3rem;
        height: 2px;
        background: var(--primary);
        border-radius: 1px;
    }
    
    /* Widget content */
    .sidebar .widget ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .sidebar .widget ul li {
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border-color);
        position: relative;
    }
    
    .sidebar .widget ul li:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .sidebar .widget ul li::before {
        content: '';
        position: absolute;
        left: -1rem;
        top: 0.5rem;
        width: 6px;
        height: 6px;
        background: var(--primary-soft);
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    
    .sidebar .widget ul li:hover::before {
        opacity: 1;
    }
    
    /* Widget links */
    .sidebar .widget a {
        color: var(--text-secondary);
        text-decoration: none;
        transition: all 0.2s ease;
        display: block;
        padding: 0.25rem 0;
        border-radius: 0.25rem;
    }
    
    .sidebar .widget a:hover {
        color: var(--primary);
        background: var(--primary)/0.05;
        padding-left: 0.5rem;
        transform: translateX(4px);
    }
    
    /* Search widget enhancement */
    .sidebar .widget_search input[type="search"],
    .sidebar .widget_product_search input[type="search"] {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }
    
    .sidebar .widget_search input[type="search"]:focus,
    .sidebar .widget_product_search input[type="search"]:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary)/0.1;
        transform: translateY(-1px);
    }
    
    /* Calendar widget enhancement */
    .sidebar .widget_calendar table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }
    
    .sidebar .widget_calendar th,
    .sidebar .widget_calendar td {
        padding: 0.5rem;
        text-align: center;
        border: 1px solid var(--border-color);
    }
    
    .sidebar .widget_calendar th {
        background: var(--bg-tertiary);
        font-weight: 600;
        color: var(--text-primary);
    }
    
    .sidebar .widget_calendar td a {
        background: var(--primary);
        color: white;
        border-radius: 0.25rem;
        padding: 0.25rem 0.5rem;
        font-weight: 500;
    }
    
    /* Tag cloud widget */
    .sidebar .widget_tag_cloud a,
    .sidebar .wp-block-tag-cloud a {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        margin: 0.25rem 0.25rem 0.25rem 0;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        color: var(--text-secondary);
        font-size: 0.875rem !important;
        line-height: 1.5;
        transition: all 0.2s ease;
    }
    
    .sidebar .widget_tag_cloud a:hover,
    .sidebar .wp-block-tag-cloud a:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 2px 8px var(--primary)/0.3;
    }
    
    /* Recent posts widget */
    .sidebar .widget_recent_entries .post-date {
        font-size: 0.75rem;
        color: var(--text-muted);
        display: block;
        margin-top: 0.25rem;
    }
    
    /* Text widget paragraphs */
    .sidebar .widget_text p {
        margin-bottom: 0.75rem;
        line-height: 1.6;
        color: var(--text-secondary);
    }
    
    .sidebar .widget_text p:last-child {
        margin-bottom: 0;
    }
    
    /* Animation classes */
    .sidebar-animated .widget {
        opacity: 0;
        transform: translateY(20px);
        animation: widget-slide-in 0.6s ease-out forwards;
    }
    
    .sidebar-animated .widget:nth-child(2) { animation-delay: 0.1s; }
    .sidebar-animated .widget:nth-child(3) { animation-delay: 0.2s; }
    .sidebar-animated .widget:nth-child(4) { animation-delay: 0.3s; }
    .sidebar-animated .widget:nth-child(5) { animation-delay: 0.4s; }
    
    @keyframes widget-slide-in {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
        .sidebar-sticky {
            position: static;
            max-height: none;
            overflow-y: visible;
        }
        
        .sidebar .widget {
            margin-bottom: 1rem;
            padding: 1rem;
        }
        
        .sidebar .widget-title,
        .sidebar .widgettitle {
            font-size: 1.125rem;
        }
    }
    
    /* Dark mode adjustments */
    [data-theme="dark"] .sidebar .widget {
        background: var(--bg-secondary);
        border-color: var(--border-color);
    }
    
    [data-theme="dark"] .sidebar .widget:hover {
        border-color: var(--primary)/0.3;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    [data-theme="dark"] .sidebar .widget_calendar th {
        background: var(--bg-tertiary);
    }
    
    [data-theme="dark"] .sidebar .widget_tag_cloud a,
    [data-theme="dark"] .wp-block-tag-cloud a {
        background: var(--bg-tertiary);
        border-color: var(--border-color);
        color: var(--text-secondary);
    }
    
    [data-theme="dark"] .sidebar .widget_tag_cloud a:hover,
    [data-theme="dark"] .wp-block-tag-cloud a:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    
    /* Print styles */
    @media print {
        .sidebar {
            display: none;
        }
    }
</style>

{{-- Sidebar JavaScript --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('sidebarComponent', () => ({
            initialized: false,
            
            init() {
                this.initialized = true;
                this.setupStickyBehavior();
                this.enhanceWidgets();
                this.trackEngagement();
                
                // Handle window resize for responsive behavior
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 768 && this.collapsed) {
                        this.collapsed = false;
                    }
                });
            },
            
            setupStickyBehavior() {
                if (!document.querySelector('.sidebar-sticky')) return;
                
                const sidebar = document.querySelector('.sidebar-sticky');
                const main = document.querySelector('main');
                
                if (!sidebar || !main) return;
                
                // Calculate optimal sticky positioning
                const calculateStickyPosition = () => {
                    const header = document.querySelector('.site-header');
                    const headerHeight = header ? header.offsetHeight : 0;
                    const offset = 20; // Additional offset
                    
                    sidebar.style.top = `${headerHeight + offset}px`;
                    sidebar.style.maxHeight = `calc(100vh - ${headerHeight + offset * 2}px)`;
                };
                
                // Initial calculation
                calculateStickyPosition();
                
                // Recalculate on scroll (for dynamic headers)
                let ticking = false;
                window.addEventListener('scroll', () => {
                    if (!ticking) {
                        requestAnimationFrame(() => {
                            calculateStickyPosition();
                            ticking = false;
                        });
                        ticking = true;
                    }
                }, { passive: true });
            },
            
            enhanceWidgets() {
                // Enhance search widgets
                const searchInputs = document.querySelectorAll('.sidebar input[type="search"]');
                searchInputs.forEach(input => {
                    input.addEventListener('focus', () => {
                        input.parentElement.classList.add('focused');
                    });
                    
                    input.addEventListener('blur', () => {
                        input.parentElement.classList.remove('focused');
                    });
                });
                
                // Add loading states to links
                const widgetLinks = document.querySelectorAll('.sidebar .widget a[href]');
                widgetLinks.forEach(link => {
                    if (!link.href.startsWith('#') && !link.href.includes('javascript:')) {
                        link.addEventListener('click', (e) => {
                            const loader = document.createElement('span');
                            loader.innerHTML = '...';
                            loader.className = 'ml-2 text-xs text-text-muted';
                            link.appendChild(loader);
                        });
                    }
                });
                
                // Lazy load widget content if needed
                this.setupLazyLoading();
            },
            
            setupLazyLoading() {
                const lazyWidgets = document.querySelectorAll('.sidebar .widget[data-lazy]');
                if (lazyWidgets.length === 0) return;
                
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const widget = entry.target;
                            const loadUrl = widget.dataset.lazy;
                            
                            if (loadUrl) {
                                fetch(loadUrl)
                                    .then(response => response.text())
                                    .then(html => {
                                        widget.innerHTML = html;
                                        widget.removeAttribute('data-lazy');
                                    })
                                    .catch(error => {
                                        console.error('Failed to load widget content:', error);
                                        widget.innerHTML = '<p class="text-text-muted text-sm">Content unavailable</p>';
                                    });
                            }
                            
                            observer.unobserve(widget);
                        }
                    });
                }, { threshold: 0.1 });
                
                lazyWidgets.forEach(widget => observer.observe(widget));
            },
            
            trackEngagement() {
                // Track widget interactions
                const widgets = document.querySelectorAll('.sidebar .widget');
                widgets.forEach((widget, index) => {
                    const links = widget.querySelectorAll('a');
                    const widgetTitle = widget.querySelector('.widget-title, .widgettitle')?.textContent || `Widget ${index + 1}`;
                    
                    links.forEach(link => {
                        link.addEventListener('click', () => {
                            if (typeof gtag !== 'undefined') {
                                gtag('event', 'sidebar_click', {
                                    'widget_name': widgetTitle,
                                    'link_text': link.textContent?.trim(),
                                    'event_category': 'sidebar_engagement'
                                });
                            }
                        });
                    });
                });
                
                // Track sidebar scroll depth
                const sidebar = document.querySelector('.sidebar-sticky');
                if (sidebar) {
                    let maxScrollDepth = 0;
                    
                    sidebar.addEventListener('scroll', () => {
                        const scrollPercent = Math.round(
                            (sidebar.scrollTop / (sidebar.scrollHeight - sidebar.clientHeight)) * 100
                        );
                        
                        if (scrollPercent > maxScrollDepth) {
                            maxScrollDepth = scrollPercent;
                            
                            // Track significant milestones
                            if ([25, 50, 75, 90].includes(scrollPercent)) {
                                if (typeof gtag !== 'undefined') {
                                    gtag('event', 'sidebar_scroll', {
                                        'scroll_depth': scrollPercent,
                                        'event_category': 'sidebar_engagement'
                                    });
                                }
                            }
                        }
                    }, { passive: true });
                }
            }
        }));
    });
    
    // Global sidebar utilities
    window.sidebarUtils = {
        // Refresh widget content
        refreshWidget: function(widgetId) {
            const widget = document.getElementById(widgetId);
            if (widget && widget.dataset.refresh) {
                fetch(widget.dataset.refresh)
                    .then(response => response.text())
                    .then(html => {
                        widget.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Failed to refresh widget:', error);
                    });
            }
        },
        
        // Add new widget dynamically
        addWidget: function(widgetHtml, position = 'append') {
            const sidebar = document.querySelector('.sidebar-content');
            if (!sidebar) return;
            
            const widgetElement = document.createElement('div');
            widgetElement.innerHTML = widgetHtml;
            
            if (position === 'prepend') {
                sidebar.insertBefore(widgetElement.firstElementChild, sidebar.firstChild);
            } else {
                sidebar.appendChild(widgetElement.firstElementChild);
            }
        },
        
        // Toggle widget visibility
        toggleWidget: function(widgetId) {
            const widget = document.getElementById(widgetId);
            if (widget) {
                widget.style.display = widget.style.display === 'none' ? 'block' : 'none';
            }
        }
    };
</script>

{{-- Inline Widget Templates --}}
@php
    // Popular Posts Widget Template
    $popularPostsWidget = '
    <div class="widget widget-popular-posts">
        <h3 class="widget-title">Popular Posts</h3>
        <ul class="popular-posts-list">';
    
    $popular_posts = get_posts([
        'numberposts' => 5,
        'meta_key' => 'post_views_count',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    ]);
    
    foreach($popular_posts as $post) {
        $popularPostsWidget .= '
            <li class="popular-post-item">
                <div class="flex gap-3">
                    ' . (has_post_thumbnail($post->ID) ? 
                        '<img src="' . get_the_post_thumbnail_url($post->ID, 'thumbnail') . '" 
                             alt="' . get_the_title($post->ID) . '"
                             class="w-16 h-16 rounded-lg object-cover flex-shrink-0">' : '') . '
                    <div class="flex-1">
                        <a href="' . get_permalink($post->ID) . '" 
                           class="font-medium text-text-primary hover:text-primary transition-colors line-clamp-2">
                            ' . get_the_title($post->ID) . '
                        </a>
                        <p class="text-sm text-text-muted mt-1">
                            ' . get_the_date('', $post->ID) . '
                        </p>
                    </div>
                </div>
            </li>';
    }
    
    $popularPostsWidget .= '
        </ul>
    </div>';
@endphp

{{-- Newsletter Widget Template --}}
@php
    $newsletterWidget = '
    <div class="widget widget-newsletter bg-gradient-to-br from-primary/5 to-primary-soft/10 border-primary/20">
        <h3 class="widget-title">Stay Updated</h3>
        <p class="text-sm text-text-secondary mb-4">
            Get the latest posts and updates delivered directly to your inbox.
        </p>
        <form class="newsletter-form" action="#" method="post">
            <div class="space-y-3">
                <input type="email" 
                       name="email" 
                       placeholder="Your email address"
                       class="w-full px-3 py-2 border border-border-color rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm"
                       required>
                <button type="submit" 
                        class="w-full px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors text-sm font-medium">
                    Subscribe
                </button>
            </div>
            <p class="text-xs text-text-muted mt-2">
                We respect your privacy. Unsubscribe anytime.
            </p>
        </form>
    </div>';
@endphp

{{-- Social Follow Widget Template --}}
@php
    $socialWidget = '
    <div class="widget widget-social-follow">
        <h3 class="widget-title">Follow Us</h3>
        <div class="social-links grid grid-cols-2 gap-3">
            <a href="#" class="flex items-center gap-2 p-2 rounded-lg bg-bg-tertiary hover:bg-primary hover:text-white transition-colors text-sm">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                </svg>
                Twitter
            </a>
            <a href="#" class="flex items-center gap-2 p-2 rounded-lg bg-bg-tertiary hover:bg-blue-600 hover:text-white transition-colors text-sm">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                Facebook
            </a>
            <a href="#" class="flex items-center gap-2 p-2 rounded-lg bg-bg-tertiary hover:bg-pink-600 hover:text-white transition-colors text-sm">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
                Instagram
            </a>
            <a href="#" class="flex items-center gap-2 p-2 rounded-lg bg-bg-tertiary hover:bg-red-600 hover:text-white transition-colors text-sm">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
                YouTube
            </a>
        </div>
    </div>';
@endphp