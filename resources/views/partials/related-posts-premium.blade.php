{{--
  Premium Related Posts Component
  Smart related posts with multiple algorithms and rich display
--}}

@php
    $current_post_id = get_the_ID();
    $post_categories = wp_get_post_categories($current_post_id);
    $post_tags = wp_get_post_tags($current_post_id);
    
    // Smart algorithm: Categories first, then tags, then recent
    $related_posts = [];
    
    if (!empty($post_categories)) {
        $related_posts = get_posts([
            'category__in' => $post_categories,
            'post__not_in' => [$current_post_id],
            'posts_per_page' => 6,
            'orderby' => 'rand'
        ]);
    }
    
    // Fill with tag-related posts if needed
    if (count($related_posts) < 6 && !empty($post_tags)) {
        $tag_ids = array_map(function($tag) { return $tag->term_id; }, $post_tags);
        $tag_posts = get_posts([
            'tag__in' => $tag_ids,
            'post__not_in' => array_merge([$current_post_id], array_map('get_the_ID', $related_posts)),
            'posts_per_page' => 6 - count($related_posts),
            'orderby' => 'rand'
        ]);
        $related_posts = array_merge($related_posts, $tag_posts);
    }
    
    // Fill with recent posts if still needed
    if (count($related_posts) < 3) {
        $recent_posts = get_posts([
            'post__not_in' => array_merge([$current_post_id], array_map('get_the_ID', $related_posts)),
            'posts_per_page' => 6 - count($related_posts),
            'orderby' => 'date'
        ]);
        $related_posts = array_merge($related_posts, $recent_posts);
    }
    
    $related_posts = array_slice($related_posts, 0, 6);
@endphp

@if(!empty($related_posts))
    <section class="related-posts-premium py-20 bg-gradient-to-b from-bg-secondary to-bg-primary"
             x-data="relatedPosts()"
             x-init="init()">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4">
                    {{ __('Continue Reading', 'blitz') }}
                </h2>
                <p class="text-lg text-text-secondary max-w-2xl mx-auto">
                    {{ __('Discover more articles you might find interesting', 'blitz') }}
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($related_posts as $index => $post)
                    @php
                        setup_postdata($post);
                        $post_id = $post->ID;
                    @endphp
                    
                    <article class="related-post-card group"
                             x-data="{ inView: false }"
                             x-intersect="inView = true"
                             :class="{ 'animate-slide-up': inView }"
                             style="animation-delay: {{ $index * 100 }}ms">
                        
                        <div class="card-container">
                            @if(has_post_thumbnail($post_id))
                                <div class="card-image">
                                    <a href="{{ get_permalink($post_id) }}">
                                        <img src="{{ get_the_post_thumbnail_url($post_id, 'medium_large') }}" 
                                             alt="{{ get_the_title($post_id) }}"
                                             class="w-full aspect-video object-cover transition-transform duration-500 group-hover:scale-105"
                                             loading="lazy">
                                    </a>
                                    <div class="image-overlay"></div>
                                </div>
                            @endif
                            
                            <div class="card-content">
                                @if(get_the_category($post_id))
                                    <div class="card-category">
                                        <a href="{{ get_category_link(get_the_category($post_id)[0]) }}"
                                           class="category-badge">
                                            {{ get_the_category($post_id)[0]->name }}
                                        </a>
                                    </div>
                                @endif
                                
                                <h3 class="card-title">
                                    <a href="{{ get_permalink($post_id) }}">
                                        {{ get_the_title($post_id) }}
                                    </a>
                                </h3>
                                
                                <div class="card-meta">
                                    <time datetime="{{ get_post_time('c', true, $post_id) }}">
                                        {{ get_the_date('', $post_id) }}
                                    </time>
                                    <span class="reading-time">
                                        {{ ceil(str_word_count(wp_strip_all_tags(get_post_field('post_content', $post_id))) / 200) }} min read
                                    </span>
                                </div>
                                
                                <div class="card-excerpt">
                                    {{ wp_trim_words(get_the_excerpt($post_id) ?: get_post_field('post_content', $post_id), 20) }}
                                </div>
                                
                                <div class="card-footer">
                                    <a href="{{ get_permalink($post_id) }}" 
                                       class="read-more-btn">
                                        <span>{{ __('Read More', 'blitz') }}</span>
                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ get_permalink(get_option('page_for_posts')) ?: home_url('/blog') }}" 
                   class="view-all-btn">
                    {{ __('View All Articles', 'blitz') }}
                </a>
            </div>
        </div>
    </section>
    
    @php wp_reset_postdata(); @endphp
@endif

<style>
/* Related Posts Premium Styles */
.related-posts-premium {
    position: relative;
    overflow: hidden;
}

.related-post-card {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease;
}

.related-post-card.animate-slide-up {
    opacity: 1;
    transform: translateY(0);
}

.card-container {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    overflow: hidden;
    height: 100%;
    transition: all 0.3s ease;
    position: relative;
}

.card-container:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px var(--shadow);
    border-color: var(--primary)/0.2;
}

.card-image {
    position: relative;
    overflow: hidden;
    border-radius: 1rem 1rem 0 0;
}

.image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.1) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.related-post-card:hover .image-overlay {
    opacity: 1;
}

.card-content {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    height: calc(100% - 200px);
}

.card-category {
    margin-bottom: 0.5rem;
}

.category-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background: var(--primary)/0.1;
    color: var(--primary);
    border-radius: 100px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    transition: all 0.3s ease;
}

.category-badge:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-1px);
}

.card-title {
    flex: 0 0 auto;
}

.card-title a {
    font-size: 1.125rem;
    font-weight: 600;
    line-height: 1.4;
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.3s ease;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-title a:hover {
    color: var(--primary);
}

.card-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.875rem;
    color: var(--text-muted);
}

.card-meta time {
    font-weight: 500;
}

.reading-time {
    position: relative;
    padding-left: 1rem;
}

.reading-time::before {
    content: '•';
    position: absolute;
    left: 0.5rem;
    color: var(--text-muted);
}

.card-excerpt {
    flex: 1;
    font-size: 0.875rem;
    line-height: 1.6;
    color: var(--text-secondary);
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-footer {
    flex: 0 0 auto;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

.read-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary);
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.read-more-btn:hover {
    color: var(--primary-dark);
}

.view-all-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 2rem;
    background: var(--primary);
    color: white;
    border-radius: 0.5rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.view-all-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px var(--primary)/0.3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .related-posts-premium .grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .card-content {
        padding: 1rem;
        gap: 0.75rem;
    }
    
    .card-title a {
        font-size: 1rem;
    }
}

/* Dark Mode Adjustments */
[data-theme="dark"] .card-container {
    background: var(--bg-secondary);
    border-color: var(--border-color);
}

[data-theme="dark"] .card-container:hover {
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

[data-theme="dark"] .category-badge {
    background: var(--primary)/0.2;
    color: var(--primary-light);
}

[data-theme="dark"] .category-badge:hover {
    background: var(--primary);
    color: white;
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('relatedPosts', () => ({
        init() {
            // Track related post interactions
            this.trackInteractions();
        },
        
        trackInteractions() {
            // Track clicks on related posts
            const relatedLinks = document.querySelectorAll('.related-post-card a');
            relatedLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'related_post_click', {
                            'post_title': link.textContent?.trim(),
                            'event_category': 'engagement'
                        });
                    }
                });
            });
        }
    }));
});
</script>