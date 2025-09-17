{{--
  Enhanced Entry Meta Component
  Rich metadata display with schema.org structured data and social features
--}}

@props([
    'layout' => 'horizontal',              // horizontal, vertical, minimal, detailed
    'showAuthor' => true,                  // Show author information
    'showDate' => true,                    // Show publish date
    'showComments' => true,                // Show comments count
    'showReadTime' => true,                // Show estimated reading time
    'showViews' => false,                  // Show view count (requires custom implementation)
    'showUpdated' => false,                // Show last updated date
    'avatarSize' => 32,                    // Author avatar size in pixels
    'dateFormat' => '',                    // Custom date format (uses site default if empty)
    'schema' => true,                      // Include schema.org markup
])

@php
    // Layout classes
    $layoutClasses = match($layout) {
        'vertical' => 'flex flex-col space-y-3',
        'minimal' => 'flex items-center space-x-4 text-sm',
        'detailed' => 'grid grid-cols-1 md:grid-cols-2 gap-4',
        default => 'flex flex-wrap items-center gap-4 text-sm'
    };
    
    // Calculate reading time
    $content = get_the_content();
    $wordCount = str_word_count(wp_strip_all_tags($content));
    $readingTime = max(1, ceil($wordCount / 200)); // 200 words per minute
    
    // Get post data
    $postDate = get_the_date($dateFormat ?: get_option('date_format'));
    $postDateTime = get_post_time('c', true);
    $modifiedDate = get_the_modified_date($dateFormat ?: get_option('date_format'));
    $modifiedDateTime = get_post_modified_time('c', true);
    $authorId = get_the_author_meta('ID');
    $authorName = get_the_author();
    $authorUrl = get_author_posts_url($authorId);
    $commentsNumber = get_comments_number();
@endphp

<div class="entry-meta {{ $layoutClasses }} text-text-muted"
     @if($schema)
     itemscope 
     itemtype="https://schema.org/BlogPosting"
     @endif>

    {{-- Schema.org structured data (invisible) --}}
    @if($schema)
        <meta itemprop="headline" content="{{ get_the_title() }}">
        <meta itemprop="datePublished" content="{{ $postDateTime }}">
        @if($postDateTime !== $modifiedDateTime)
            <meta itemprop="dateModified" content="{{ $modifiedDateTime }}">
        @endif
        <meta itemprop="wordCount" content="{{ $wordCount }}">
        @if(has_post_thumbnail())
            <meta itemprop="image" content="{{ get_the_post_thumbnail_url(null, 'large') }}">
        @endif
        <div itemprop="author" itemscope itemtype="https://schema.org/Person" class="hidden">
            <meta itemprop="name" content="{{ $authorName }}">
            <meta itemprop="url" content="{{ $authorUrl }}">
        </div>
        <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization" class="hidden">
            <meta itemprop="name" content="{{ get_bloginfo('name') }}">
            <meta itemprop="url" content="{{ home_url() }}">
            @if(has_custom_logo())
                <meta itemprop="logo" content="{{ wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') }}">
            @endif
        </div>
    @endif

    {{-- Author Information --}}
    @if($showAuthor)
        <div class="author-meta flex items-center gap-2 {{ $layout === 'detailed' ? 'col-span-1' : '' }}">
            <div class="author-avatar flex-shrink-0">
                @if(get_avatar_url($authorId))
                    <img src="{{ get_avatar_url($authorId, ['size' => $avatarSize]) }}" 
                         alt="{{ $authorName }}"
                         class="rounded-full border border-border-color"
                         style="width: {{ $avatarSize }}px; height: {{ $avatarSize }}px;"
                         loading="lazy">
                @else
                    <div class="bg-primary/20 rounded-full flex items-center justify-center border border-border-color"
                         style="width: {{ $avatarSize }}px; height: {{ $avatarSize }}px;">
                        <svg class="text-primary" style="width: {{ $avatarSize * 0.6 }}px; height: {{ $avatarSize * 0.6 }}px;" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                @endif
            </div>
            
            <div class="author-info">
                <div class="author-name">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>{{ __('By', 'blitz') }}</span>
                    <a href="{{ $authorUrl }}" 
                       class="font-medium hover:text-primary transition-colors ml-1"
                       rel="author">
                        {{ $authorName }}
                    </a>
                </div>
                
                @if($layout === 'detailed' && get_the_author_meta('description'))
                    <p class="text-xs mt-1 text-text-muted">
                        {{ wp_trim_words(get_the_author_meta('description'), 12) }}
                    </p>
                @endif
            </div>
        </div>
    @endif

    {{-- Publication Date --}}
    @if($showDate)
        <div class="publish-date flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <time class="dt-published" datetime="{{ $postDateTime }}">
                {{ $postDate }}
            </time>
        </div>
    @endif

    {{-- Last Updated Date --}}
    @if($showUpdated && $postDateTime !== $modifiedDateTime)
        <div class="updated-date flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <span class="text-xs">{{ __('Updated', 'blitz') }}</span>
            <time class="dt-updated text-xs" datetime="{{ $modifiedDateTime }}">
                {{ $modifiedDate }}
            </time>
        </div>
    @endif

    {{-- Reading Time --}}
    @if($showReadTime)
        <div class="reading-time flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>
                {{ $readingTime }} {{ _n('min read', 'min read', $readingTime, 'blitz') }}
            </span>
        </div>
    @endif

    {{-- Comments Count --}}
    @if($showComments && (comments_open() || $commentsNumber > 0))
        <div class="comments-count flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <a href="{{ comments_open() ? get_permalink() . '#comments' : get_permalink() }}" 
               class="hover:text-primary transition-colors">
                {{ $commentsNumber }} 
                {{ _n('comment', 'comments', $commentsNumber, 'blitz') }}
            </a>
        </div>
    @endif

    {{-- View Count (if enabled and function exists) --}}
    @if($showViews && function_exists('get_post_views'))
        <div class="view-count flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            <span>
                {{ number_format_i18n(get_post_views()) }} 
                {{ _n('view', 'views', get_post_views(), 'blitz') }}
            </span>
        </div>
    @endif

    {{-- Categories (for detailed layout) --}}
    @if($layout === 'detailed' && get_the_category())
        <div class="post-categories {{ $layout === 'detailed' ? 'col-span-1 md:col-span-2' : '' }}">
            <div class="flex items-center gap-2 flex-wrap">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span class="text-xs">{{ __('In', 'blitz') }}</span>
                @foreach(get_the_category() as $category)
                    <a href="{{ get_category_link($category) }}" 
                       class="inline-block text-xs font-medium px-2 py-1 bg-primary/10 text-primary rounded-full hover:bg-primary/20 transition-colors">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

{{-- Enhanced Meta Styles --}}
<style>
    /* Responsive adjustments */
    @media (max-width: 640px) {
        .entry-meta {
            font-size: 0.875rem;
        }
        
        .entry-meta .author-avatar img,
        .entry-meta .author-avatar div {
            width: 24px !important;
            height: 24px !important;
        }
        
        .entry-meta .author-avatar svg {
            width: 14px !important;
            height: 14px !important;
        }
    }
    
    /* Hover effects */
    .entry-meta a {
        transition: color 0.2s ease;
    }
    
    .entry-meta a:hover {
        color: var(--primary);
    }
    
    /* Icon consistency */
    .entry-meta svg {
        color: var(--text-muted);
        opacity: 0.8;
    }
    
    /* Category badges */
    .post-categories a {
        font-size: 0.75rem;
        transition: all 0.2s ease;
    }
    
    .post-categories a:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(74, 124, 40, 0.2);
    }
    
    /* Vertical layout specific */
    .entry-meta.flex-col .author-meta {
        align-items: flex-start;
    }
    
    .entry-meta.flex-col .author-info {
        margin-left: 0;
        margin-top: 0.5rem;
    }
    
    /* Detailed layout specific */
    .entry-meta.grid .author-meta {
        justify-self: start;
    }
    
    /* Dark mode adjustments */
    [data-theme="dark"] .entry-meta {
        color: var(--text-muted);
    }
    
    [data-theme="dark"] .entry-meta a:hover {
        color: var(--primary-light);
    }
    
    [data-theme="dark"] .post-categories a {
        background: rgba(74, 124, 40, 0.2);
        color: var(--primary-light);
    }
    
    [data-theme="dark"] .post-categories a:hover {
        background: rgba(74, 124, 40, 0.3);
    }
</style>