{{--
  Enhanced Post Navigation Component
  Previous/Next post navigation with thumbnails and metadata
--}}

@props([
    'style' => 'default',                   // default, minimal, cards
    'showThumbnails' => true,               // Show post thumbnails
    'showExcerpts' => false,                // Show post excerpts
    'showDates' => true,                    // Show publish dates
    'animated' => true,                     // Enable animations
])

@php
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    
    if (!$prev_post && !$next_post) {
        return; // No navigation needed
    }
@endphp

<nav class="post-navigation {{ $style === 'cards' ? 'post-nav-cards' : 'post-nav-default' }}"
     role="navigation"
     aria-label="{{ __('Post Navigation', 'blitz') }}"
     @if($animated)
     x-data="{ isVisible: false }"
     x-intersect="isVisible = true"
     :class="{ 'animate-fade-in-up': isVisible }"
     @endif>
    
    @if($style === 'minimal')
        {{-- Minimal Style --}}
        <div class="nav-minimal flex justify-between items-center py-8 border-t border-border-color">
            @if($prev_post)
                <a href="{{ get_permalink($prev_post) }}" 
                   class="nav-link prev flex items-center gap-2 text-text-muted hover:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span>{{ __('Previous', 'blitz') }}</span>
                </a>
            @else
                <div></div>
            @endif
            
            @if($next_post)
                <a href="{{ get_permalink($next_post) }}" 
                   class="nav-link next flex items-center gap-2 text-text-muted hover:text-primary transition-colors">
                    <span>{{ __('Next', 'blitz') }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @endif
        </div>
        
    @elseif($style === 'cards')
        {{-- Card Style --}}
        <div class="nav-cards grid md:grid-cols-2 gap-6 py-12">
            @if($prev_post)
                <div class="nav-card prev">
                    <div class="card-label text-xs font-medium text-text-muted uppercase tracking-wider mb-3">
                        {{ __('Previous Article', 'blitz') }}
                    </div>
                    <a href="{{ get_permalink($prev_post) }}" 
                       class="card-content block group">
                        @if($showThumbnails && has_post_thumbnail($prev_post))
                            <div class="card-thumbnail aspect-video mb-4 overflow-hidden rounded-lg">
                                <img src="{{ get_the_post_thumbnail_url($prev_post, 'medium') }}" 
                                     alt="{{ get_the_title($prev_post) }}"
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>
                        @endif
                        
                        <h3 class="card-title text-lg font-semibold text-text-primary group-hover:text-primary transition-colors line-clamp-2 mb-2">
                            {{ get_the_title($prev_post) }}
                        </h3>
                        
                        @if($showExcerpts)
                            <p class="card-excerpt text-sm text-text-secondary line-clamp-2 mb-3">
                                {{ get_the_excerpt($prev_post) ?: wp_trim_words(get_post_field('post_content', $prev_post), 20) }}
                            </p>
                        @endif
                        
                        @if($showDates)
                            <div class="card-meta text-xs text-text-muted">
                                {{ get_the_date('', $prev_post) }}
                            </div>
                        @endif
                    </a>
                </div>
            @endif
            
            @if($next_post)
                <div class="nav-card next {{ !$prev_post ? 'md:col-start-2' : '' }}">
                    <div class="card-label text-xs font-medium text-text-muted uppercase tracking-wider mb-3">
                        {{ __('Next Article', 'blitz') }}
                    </div>
                    <a href="{{ get_permalink($next_post) }}" 
                       class="card-content block group">
                        @if($showThumbnails && has_post_thumbnail($next_post))
                            <div class="card-thumbnail aspect-video mb-4 overflow-hidden rounded-lg">
                                <img src="{{ get_the_post_thumbnail_url($next_post, 'medium') }}" 
                                     alt="{{ get_the_title($next_post) }}"
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>
                        @endif
                        
                        <h3 class="card-title text-lg font-semibold text-text-primary group-hover:text-primary transition-colors line-clamp-2 mb-2">
                            {{ get_the_title($next_post) }}
                        </h3>
                        
                        @if($showExcerpts)
                            <p class="card-excerpt text-sm text-text-secondary line-clamp-2 mb-3">
                                {{ get_the_excerpt($next_post) ?: wp_trim_words(get_post_field('post_content', $next_post), 20) }}
                            </p>
                        @endif
                        
                        @if($showDates)
                            <div class="card-meta text-xs text-text-muted">
                                {{ get_the_date('', $next_post) }}
                            </div>
                        @endif
                    </a>
                </div>
            @endif
        </div>
        
    @else
        {{-- Default Style --}}
        <div class="nav-default py-12 border-t border-border-color">
            <div class="grid md:grid-cols-2 gap-8">
                @if($prev_post)
                    <div class="nav-item prev">
                        <div class="nav-label flex items-center gap-2 text-sm font-medium text-text-muted mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            {{ __('Previous Post', 'blitz') }}
                        </div>
                        
                        <a href="{{ get_permalink($prev_post) }}" 
                           class="nav-content flex gap-4 group">
                            @if($showThumbnails && has_post_thumbnail($prev_post))
                                <div class="nav-thumbnail w-20 h-20 flex-shrink-0 overflow-hidden rounded-lg">
                                    <img src="{{ get_the_post_thumbnail_url($prev_post, 'thumbnail') }}" 
                                         alt="{{ get_the_title($prev_post) }}"
                                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                </div>
                            @endif
                            
                            <div class="nav-details flex-1">
                                <h3 class="nav-title font-semibold text-text-primary group-hover:text-primary transition-colors line-clamp-2 mb-1">
                                    {{ get_the_title($prev_post) }}
                                </h3>
                                
                                @if($showDates)
                                    <div class="nav-date text-sm text-text-muted">
                                        {{ get_the_date('', $prev_post) }}
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @endif
                
                @if($next_post)
                    <div class="nav-item next {{ !$prev_post ? 'md:col-start-2' : '' }}">
                        <div class="nav-label flex items-center justify-end gap-2 text-sm font-medium text-text-muted mb-3">
                            {{ __('Next Post', 'blitz') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        
                        <a href="{{ get_permalink($next_post) }}" 
                           class="nav-content flex gap-4 group">
                            <div class="nav-details flex-1 text-right">
                                <h3 class="nav-title font-semibold text-text-primary group-hover:text-primary transition-colors line-clamp-2 mb-1">
                                    {{ get_the_title($next_post) }}
                                </h3>
                                
                                @if($showDates)
                                    <div class="nav-date text-sm text-text-muted">
                                        {{ get_the_date('', $next_post) }}
                                    </div>
                                @endif
                            </div>
                            
                            @if($showThumbnails && has_post_thumbnail($next_post))
                                <div class="nav-thumbnail w-20 h-20 flex-shrink-0 overflow-hidden rounded-lg">
                                    <img src="{{ get_the_post_thumbnail_url($next_post, 'thumbnail') }}" 
                                         alt="{{ get_the_title($next_post) }}"
                                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                </div>
                            @endif
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</nav>

<style>
    /* Post Navigation Styles */
    .post-navigation {
        margin: 3rem 0;
    }
    
    /* Animation */
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out;
    }
    
    /* Card Style */
    .nav-cards .nav-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .nav-cards .nav-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px var(--shadow);
        border-color: var(--primary)/0.2;
    }
    
    /* Line clamp utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Hover effects */
    .nav-content:hover .nav-thumbnail img {
        transform: scale(1.05);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .nav-default .nav-content {
            flex-direction: column;
        }
        
        .nav-default .nav-details {
            text-align: left !important;
        }
        
        .nav-default .nav-label {
            justify-content: flex-start !important;
        }
        
        .nav-cards {
            grid-template-columns: 1fr;
        }
    }
    
    /* Dark mode adjustments */
    [data-theme="dark"] .nav-cards .nav-card {
        background: var(--bg-secondary);
        border-color: var(--border-color);
    }
    
    [data-theme="dark"] .nav-cards .nav-card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }
</style>