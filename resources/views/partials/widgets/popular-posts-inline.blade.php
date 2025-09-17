{{-- Inline Popular Posts Widget (self-contained) --}}
<div class="widget popular-posts-widget" 
     x-data="popularPosts()" 
     x-init="init()">
    
    <div class="widget-header">
        <h3 class="widget-title">{{ __('Popular Posts', 'blitz') }}</h3>
        <div class="widget-icon">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
        </div>
    </div>
    
    <div class="posts-container" x-show="!loading">
        @php
            $popular_posts = get_posts([
                'numberposts' => 5,
                'meta_key' => 'post_views_count',
                'orderby' => 'meta_value_num',
                'order' => 'DESC'
            ]);
            
            if (empty($popular_posts)) {
                $popular_posts = get_posts([
                    'numberposts' => 5,
                    'orderby' => 'comment_count',
                    'order' => 'DESC'
                ]);
            }
        @endphp
        
        @foreach($popular_posts as $index => $post)
            <div class="popular-post-card" 
                 x-data="{ hover: false }"
                 @mouseenter="hover = true"
                 @mouseleave="hover = false">
                
                <div class="post-rank-badge">{{ $index + 1 }}</div>
                
                <div class="post-thumbnail">
                    @if(has_post_thumbnail($post->ID))
                        <a href="{{ get_permalink($post->ID) }}">
                            <img src="{{ get_the_post_thumbnail_url($post->ID, 'thumbnail') }}" 
                                 alt="{{ get_the_title($post->ID) }}"
                                 :class="{ 'scale-110': hover }"
                                 class="transition-transform duration-300">
                        </a>
                    @else
                        <div class="placeholder-image">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <div class="post-info">
                    <h4 class="post-title">
                        <a href="{{ get_permalink($post->ID) }}">
                            {{ get_the_title($post->ID) }}
                        </a>
                    </h4>
                    
                    <div class="post-meta">
                        <span class="post-date">{{ get_the_date('M j, Y', $post->ID) }}</span>
                        <span class="post-views">{{ wp_count_comments($post->ID)->approved }} comments</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div x-show="loading" class="loading-state">
        <div class="skeleton-loader"></div>
    </div>
</div>

<style>
.popular-posts-widget {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.widget-header {
    display: flex;
    align-items: center;
    justify-content: between;
    margin-bottom: 1.5rem;
}

.widget-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    flex: 1;
}

.widget-icon {
    color: var(--primary);
}

.posts-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.popular-post-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem;
    border-radius: 0.5rem;
    transition: background-color 0.3s ease;
    position: relative;
}

.popular-post-card:hover {
    background: var(--bg-tertiary);
}

.post-rank-badge {
    position: absolute;
    top: -0.5rem;
    left: -0.5rem;
    width: 1.5rem;
    height: 1.5rem;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
    z-index: 10;
}

.post-thumbnail {
    width: 4rem;
    height: 4rem;
    border-radius: 0.5rem;
    overflow: hidden;
    flex-shrink: 0;
    background: var(--bg-tertiary);
}

.post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.placeholder-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
}

.post-info {
    flex: 1;
    min-width: 0;
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
    margin-top: 0.25rem;
}

.post-views {
    position: relative;
    padding-left: 0.75rem;
}

.post-views::before {
    content: '•';
    position: absolute;
    left: 0.25rem;
}

.loading-state {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.skeleton-loader {
    height: 4rem;
    background: linear-gradient(90deg, var(--bg-tertiary) 25%, var(--bg-secondary) 50%, var(--bg-tertiary) 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
    border-radius: 0.5rem;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* Dark mode */
[data-theme="dark"] .popular-posts-widget {
    background: var(--bg-secondary);
    border-color: var(--border-color);
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('popularPosts', () => ({
        loading: false,
        
        init() {
            // Widget initialization logic
            console.log('Popular posts widget initialized');
        }
    }));
});
</script>