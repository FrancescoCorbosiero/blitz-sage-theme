{{--
  Mini Popular Posts Widget
  Compact version for sidebar use
--}}

@php
    $popular_posts = get_posts([
        'numberposts' => 5,
        'meta_key' => 'post_views_count',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'post_status' => 'publish'
    ]);
    
    // Fallback to recent posts if no view counts
    if (empty($popular_posts)) {
        $popular_posts = get_posts([
            'numberposts' => 5,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish'
        ]);
    }
@endphp

@if(!empty($popular_posts))
    <div class="widget popular-posts-mini">
        <h3 class="widget-title">{{ __('Popular Posts', 'blitz') }}</h3>
        
        <ul class="popular-posts-list">
            @foreach($popular_posts as $index => $post)
                @php setup_postdata($post); @endphp
                
                <li class="popular-post-item">
                    <div class="post-rank">{{ $index + 1 }}</div>
                    
                    <div class="post-content">
                        @if(has_post_thumbnail($post->ID))
                            <div class="post-thumbnail">
                                <a href="{{ get_permalink($post->ID) }}">
                                    <img src="{{ get_the_post_thumbnail_url($post->ID, 'thumbnail') }}" 
                                         alt="{{ get_the_title($post->ID) }}"
                                         loading="lazy">
                                </a>
                            </div>
                        @endif
                        
                        <div class="post-details">
                            <h4 class="post-title">
                                <a href="{{ get_permalink($post->ID) }}">
                                    {{ get_the_title($post->ID) }}
                                </a>
                            </h4>
                            
                            <div class="post-meta">
                                <time datetime="{{ get_post_time('c', true, $post->ID) }}">
                                    {{ get_the_date('M j', $post->ID) }}
                                </time>
                                
                                @if(function_exists('get_post_views'))
                                    <span class="view-count">
                                        {{ number_format_i18n(get_post_views($post->ID)) }} {{ __('views', 'blitz') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        
        @php wp_reset_postdata(); @endphp
    </div>
@endif

<style>
.popular-posts-mini {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 0.75rem;
    padding: 1.5rem;
}

.popular-posts-mini .widget-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--primary);
    position: relative;
}

.popular-posts-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.popular-post-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}

.popular-post-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.post-rank {
    flex-shrink: 0;
    width: 24px;
    height: 24px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
}

.post-content {
    flex: 1;
    display: flex;
    gap: 0.75rem;
}

.post-thumbnail {
    flex-shrink: 0;
    width: 60px;
    height: 60px;
    border-radius: 0.5rem;
    overflow: hidden;
}

.post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.post-thumbnail:hover img {
    transform: scale(1.1);
}

.post-details {
    flex: 1;
}

.post-title {
    margin: 0 0 0.5rem 0;
}

.post-title a {
    font-size: 0.875rem;
    font-weight: 500;
    line-height: 1.4;
    color: var(--text-primary);
    text-decoration: none;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.3s ease;
}

.post-title a:hover {
    color: var(--primary);
}

.post-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.view-count {
    position: relative;
    padding-left: 0.75rem;
}

.view-count::before {
    content: '•';
    position: absolute;
    left: 0.25rem;
}

/* Dark mode adjustments */
[data-theme="dark"] .popular-posts-mini {
    background: var(--bg-secondary);
    border-color: var(--border-color);
}
</style>