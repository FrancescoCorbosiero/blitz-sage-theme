{{--
  Enhanced Single Post Content
  Complete single post layout with rich features, reading progress, and social sharing
--}}

<article @php(post_class('single-post h-entry max-w-4xl mx-auto'))
         x-data="singlePost({{ get_the_ID() }})"
         x-init="init()">

  {{-- Reading Progress Bar --}}
  <div class="reading-progress fixed top-0 left-0 w-full h-1 bg-bg-tertiary z-50">
    <div class="progress-bar h-full bg-gradient-to-r from-primary to-primary-soft transition-all duration-300 ease-out"
         :style="{ width: readingProgress + '%' }"></div>
  </div>

  {{-- Post Header --}}
  <header class="post-header mb-8 lg:mb-12">
    
    {{-- Breadcrumbs --}}
    <nav class="breadcrumbs text-sm text-text-muted mb-6" aria-label="Breadcrumb">
      <ol class="flex items-center space-x-2">
        <li>
          <a href="{{ home_url() }}" class="hover:text-primary transition-colors">
            {{ __('Home', 'blitz') }}
          </a>
        </li>
        <li class="flex items-center">
          <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
          <a href="{{ get_permalink(get_option('page_for_posts')) }}" 
             class="hover:text-primary transition-colors">
            {{ __('Blog', 'blitz') }}
          </a>
        </li>
        @if(get_the_category())
          <li class="flex items-center">
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ get_category_link(get_the_category()[0]) }}" 
               class="hover:text-primary transition-colors">
              {{ get_the_category()[0]->name }}
            </a>
          </li>
        @endif
        <li class="flex items-center text-text-primary">
          <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
          <span class="truncate max-w-xs">{{ get_the_title() }}</span>
        </li>
      </ol>
    </nav>

    {{-- Categories --}}
    @if(get_the_category())
      <div class="post-categories mb-4">
        @foreach(get_the_category() as $category)
          <a href="{{ get_category_link($category) }}" 
             class="inline-block text-sm font-medium px-3 py-1 bg-primary/10 text-primary rounded-full hover:bg-primary/20 transition-colors mr-2 mb-2">
            {{ $category->name }}
          </a>
        @endforeach
      </div>
    @endif

    {{-- Post Title --}}
    <h1 class="p-name text-3xl lg:text-5xl font-bold text-text-primary leading-tight mb-6">
      {!! $title !!}
    </h1>

    {{-- Post Meta --}}
    <div class="post-meta flex flex-wrap items-center gap-6 text-text-muted mb-8">
      
      {{-- Author --}}
      <div class="flex items-center gap-3">
        @if(get_avatar_url(get_the_author_meta('ID')))
          <img src="{{ get_avatar_url(get_the_author_meta('ID'), ['size' => 48]) }}" 
               alt="{{ get_the_author() }}"
               class="w-12 h-12 rounded-full border-2 border-border-color">
        @else
          <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center border-2 border-border-color">
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </div>
        @endif
        <div>
          <p class="font-medium text-text-primary">
            <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" 
               class="hover:text-primary transition-colors">
              {{ get_the_author() }}
            </a>
          </p>
          @if(get_the_author_meta('description'))
            <p class="text-sm">{{ wp_trim_words(get_the_author_meta('description'), 8) }}</p>
          @endif
        </div>
      </div>

      {{-- Date & Reading Time --}}
      <div class="flex items-center gap-4 text-sm">
        <div class="flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
          <time class="dt-published" datetime="{{ get_post_time('c', true) }}">
            {{ get_the_date() }}
          </time>
        </div>
        
        <div class="flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span>{{ $readingTime }} {{ __('min read', 'blitz') }}</span>
        </div>
      </div>

      {{-- Share Button --}}
      <button @click="toggleShareMenu" 
              class="flex items-center gap-2 px-4 py-2 bg-bg-secondary border border-border-color rounded-lg hover:bg-bg-tertiary transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
        </svg>
        <span>{{ __('Share', 'blitz') }}</span>
      </button>
    </div>

    {{-- Share Menu --}}
    <div x-show="showShareMenu" 
         x-transition
         class="share-menu bg-card-bg border border-border-color rounded-xl p-4 shadow-lg mb-6">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <button @click="shareOn('twitter')" 
                class="flex items-center gap-2 p-3 rounded-lg hover:bg-bg-tertiary transition-colors">
          <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
          </svg>
          <span class="text-sm">Twitter</span>
        </button>
        
        <button @click="shareOn('facebook')" 
                class="flex items-center gap-2 p-3 rounded-lg hover:bg-bg-tertiary transition-colors">
          <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
          </svg>
          <span class="text-sm">Facebook</span>
        </button>
        
        <button @click="shareOn('linkedin')" 
                class="flex items-center gap-2 p-3 rounded-lg hover:bg-bg-tertiary transition-colors">
          <svg class="w-5 h-5 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
          </svg>
          <span class="text-sm">LinkedIn</span>
        </button>
        
        <button @click="copyLink" 
                class="flex items-center gap-2 p-3 rounded-lg hover:bg-bg-tertiary transition-colors">
          <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
          </svg>
          <span class="text-sm">Copy Link</span>
        </button>
      </div>
    </div>

    {{-- Featured Image --}}
    @if(has_post_thumbnail())
      <div class="post-featured-image mb-8 lg:mb-12">
        <figure class="relative rounded-xl overflow-hidden shadow-lg">
          <img src="{{ get_the_post_thumbnail_url(get_the_ID(), 'full') }}" 
               alt="{{ get_the_title() }}"
               class="w-full aspect-video lg:aspect-[21/9] object-cover"
               loading="eager">
          
          @if(get_post(get_post_thumbnail_id())->post_excerpt)
            <figcaption class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent text-white p-4">
              <p class="text-sm">{{ get_post(get_post_thumbnail_id())->post_excerpt }}</p>
            </figcaption>
          @endif
        </figure>
      </div>
    @endif
  </header>

  {{-- Post Content --}}
  <div class="post-content e-content prose prose-lg max-w-none mb-12"
       x-ref="content">
    @php(the_content())
  </div>

  {{-- Post Tags --}}
  @if(get_the_tags())
    <div class="post-tags mb-8">
      <h3 class="text-lg font-semibold text-text-primary mb-4 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
        </svg>
        {{ __('Tags', 'blitz') }}
      </h3>
      <div class="flex flex-wrap gap-2">
        @foreach(get_the_tags() as $tag)
          <a href="{{ get_tag_link($tag) }}" 
             class="inline-block px-3 py-1 bg-bg-secondary border border-border-color rounded-full text-sm hover:bg-primary hover:text-white hover:border-primary transition-colors">
            #{{ $tag->name }}
          </a>
        @endforeach
      </div>
    </div>
  @endif

  {{-- Author Bio --}}
  @if(get_the_author_meta('description'))
    <div class="author-bio bg-card-bg border border-border-color rounded-xl p-6 mb-8">
      <div class="flex items-start gap-4">
        <img src="{{ get_avatar_url(get_the_author_meta('ID'), ['size' => 80]) }}" 
             alt="{{ get_the_author() }}"
             class="w-20 h-20 rounded-full border-2 border-border-color flex-shrink-0">
        <div class="flex-1">
          <h3 class="text-xl font-semibold text-text-primary mb-2">
            {{ get_the_author() }}
          </h3>
          <p class="text-text-secondary mb-4">
            {{ get_the_author_meta('description') }}
          </p>
          <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" 
             class="inline-flex items-center gap-2 text-primary hover:text-primary-dark transition-colors">
            <span>{{ __('View all posts', 'blitz') }}</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
          </a>
        </div>
      </div>
    </div>
  @endif

  {{-- Post Navigation --}}
  @if ($pagination())
    <footer class="post-footer border-t border-border-color pt-8">
      <nav class="post-navigation" aria-label="Posts">
        <div class="flex flex-col md:flex-row gap-6">
          @if($prev = get_previous_post())
            <div class="flex-1">
              <p class="text-sm text-text-muted mb-2">{{ __('Previous Post', 'blitz') }}</p>
              <a href="{{ get_permalink($prev) }}" 
                 class="flex items-start gap-4 p-4 bg-card-bg border border-border-color rounded-lg hover:border-primary transition-colors group">
                @if(has_post_thumbnail($prev))
                  <img src="{{ get_the_post_thumbnail_url($prev, 'thumbnail') }}" 
                       alt="{{ get_the_title($prev) }}"
                       class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                @endif
                <div class="flex-1 min-w-0">
                  <h4 class="font-medium text-text-primary group-hover:text-primary transition-colors line-clamp-2">
                    {{ get_the_title($prev) }}
                  </h4>
                  <p class="text-sm text-text-muted mt-1">
                    {{ get_the_date('', $prev) }}
                  </p>
                </div>
              </a>
            </div>
          @endif
          
          @if($next = get_next_post())
            <div class="flex-1">
              <p class="text-sm text-text-muted mb-2">{{ __('Next Post', 'blitz') }}</p>
              <a href="{{ get_permalink($next) }}" 
                 class="flex items-start gap-4 p-4 bg-card-bg border border-border-color rounded-lg hover:border-primary transition-colors group">
                @if(has_post_thumbnail($next))
                  <img src="{{ get_the_post_thumbnail_url($next, 'thumbnail') }}" 
                       alt="{{ get_the_title($next) }}"
                       class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                @endif
                <div class="flex-1 min-w-0">
                  <h4 class="font-medium text-text-primary group-hover:text-primary transition-colors line-clamp-2">
                    {{ get_the_title($next) }}
                  </h4>
                  <p class="text-sm text-text-muted mt-1">
                    {{ get_the_date('', $next) }}
                  </p>
                </div>
              </a>
            </div>
          @endif
        </div>
      </nav>
    </footer>
  @endif
</article>

{{-- Floating Action Bar (Mobile) --}}
<div class="floating-actions fixed bottom-6 left-1/2 transform -translate-x-1/2 md:hidden z-40"
     x-show="showFloatingActions"
     x-transition>
  <div class="flex items-center gap-2 bg-card-bg border border-border-color rounded-full px-4 py-2 shadow-lg">
    <button @click="toggleBookmark" 
            :class="{ 'text-accent': bookmarked, 'text-text-muted': !bookmarked }"
            class="p-2">
      <svg class="w-5 h-5" :fill="bookmarked ? 'currentColor' : 'none'" 
           stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
      </svg>
    </button>
    
    <div class="w-px h-6 bg-border-color"></div>
    
    <button @click="toggleShareMenu" class="p-2 text-text-muted">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
      </svg>
    </button>
  </div>
</div>

{{-- Single Post Styles --}}
<style>
  /* Reading progress bar */
  .reading-progress {
    transition: opacity 0.3s ease;
  }
  
  .progress-bar {
    background: linear-gradient(90deg, var(--primary) 0%, var(--primary-soft) 100%);
  }
  
  /* Enhanced prose styling */
  .prose {
    color: var(--text-secondary);
    line-height: 1.8;
  }
  
  .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: var(--text-primary);
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
  }
  
  .prose h2 {
    font-size: 1.875rem;
    border-bottom: 2px solid var(--border-color);
    padding-bottom: 0.5rem;
  }
  
  .prose h3 {
    font-size: 1.5rem;
  }
  
  .prose a {
    color: var(--primary);
    text-decoration: underline;
    text-decoration-color: var(--primary-soft);
    text-underline-offset: 3px;
  }
  
  .prose a:hover {
    color: var(--primary-dark);
    text-decoration-color: var(--primary);
  }
  
  .prose blockquote {
    border-left: 4px solid var(--primary);
    background: var(--bg-secondary);
    padding: 1.5rem;
    margin: 2rem 0;
    border-radius: 0 0.5rem 0.5rem 0;
    font-style: italic;
  }
  
  .prose code {
    background: var(--bg-secondary);
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
    border: 1px solid var(--border-color);
  }
  
  .prose pre {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    padding: 1rem;
    overflow-x: auto;
  }
  
  .prose pre code {
    background: none;
    border: none;
    padding: 0;
  }
  
  .prose img {
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px var(--shadow);
  }
  
  .prose table {
    border-collapse: collapse;
    width: 100%;
    margin: 2rem 0;
  }
  
  .prose th,
  .prose td {
    border: 1px solid var(--border-color);
    padding: 0.75rem;
    text-align: left;
  }
  
  .prose th {
    background: var(--bg-secondary);
    font-weight: 600;
  }
  
  /* Line clamp utility */
  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  
  /* Share menu animation */
  .share-menu {
    transform-origin: top;
  }
  
  /* Floating actions */
  .floating-actions {
    backdrop-filter: blur(10px);
  }
  
  /* Dark mode adjustments */
  [data-theme="dark"] .prose {
    color: var(--text-secondary);
  }
  
  [data-theme="dark"] .prose h2,
  [data-theme="dark"] .prose h3,
  [data-theme="dark"] .prose h4,
  [data-theme="dark"] .prose h5,
  [data-theme="dark"] .prose h6 {
    color: var(--text-primary);
  }
  
  [data-theme="dark"] .prose blockquote {
    background: var(--bg-tertiary);
    border-left-color: var(--primary);
  }
  
  [data-theme="dark"] .prose code {
    background: var(--bg-tertiary);
    border-color: var(--border-color);
  }
  
  [data-theme="dark"] .prose pre {
    background: var(--bg-tertiary);
    border-color: var(--border-color);
  }
</style>

{{-- Single Post JavaScript --}}
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('singlePost', (postId) => ({
      postId,
      readingProgress: 0,
      readingTime: 0,
      showShareMenu: false,
      showFloatingActions: false,
      bookmarked: false,
      
      init() {
        this.calculateReadingTime();
        this.trackReadingProgress();
        this.loadBookmarkState();
        this.setupScrollListeners();
        
        // Close share menu when clicking outside
        document.addEventListener('click', (e) => {
          if (!e.target.closest('.share-menu') && !e.target.closest('[\\@click="toggleShareMenu"]')) {
            this.showShareMenu = false;
          }
        });
      },
      
      calculateReadingTime() {
        const content = this.$refs.content;
        if (content) {
          const text = content.textContent || content.innerText || '';
          const wordsPerMinute = 200;
          const words = text.trim().split(/\s+/).length;
          this.readingTime = Math.ceil(words / wordsPerMinute) || 1;
        }
      },
      
      trackReadingProgress() {
        const updateProgress = () => {
          const content = this.$refs.content;
          if (!content) return;
          
          const contentTop = content.offsetTop;
          const contentHeight = content.offsetHeight;
          const windowHeight = window.innerHeight;
          const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
          
          const contentStart = contentTop - windowHeight * 0.3;
          const contentEnd = contentTop + contentHeight - windowHeight * 0.7;
          const contentLength = contentEnd - contentStart;
          
          if (scrollTop < contentStart) {
            this.readingProgress = 0;
          } else if (scrollTop > contentEnd) {
            this.readingProgress = 100;
          } else {
            this.readingProgress = ((scrollTop - contentStart) / contentLength) * 100;
          }
          
          // Show floating actions on mobile after 20% progress
          if (window.innerWidth < 768) {
            this.showFloatingActions = this.readingProgress > 20;
          }
        };
        
        window.addEventListener('scroll', updateProgress, { passive: true });
        window.addEventListener('resize', updateProgress, { passive: true });
        updateProgress();
      },
      
      setupScrollListeners() {
        let ticking = false;
        
        const scrollHandler = () => {
          if (!ticking) {
            requestAnimationFrame(() => {
              // Track reading milestones
              if (this.readingProgress >= 25 && !this.milestones?.quarter) {
                this.trackMilestone('25_percent');
                this.milestones = { ...this.milestones, quarter: true };
              }
              if (this.readingProgress >= 50 && !this.milestones?.half) {
                this.trackMilestone('50_percent');
                this.milestones = { ...this.milestones, half: true };
              }
              if (this.readingProgress >= 75 && !this.milestones?.three_quarter) {
                this.trackMilestone('75_percent');
                this.milestones = { ...this.milestones, three_quarter: true };
              }
              if (this.readingProgress >= 90 && !this.milestones?.complete) {
                this.trackMilestone('90_percent');
                this.milestones = { ...this.milestones, complete: true };
              }
              
              ticking = false;
            });
            ticking = true;
          }
        };
        
        window.addEventListener('scroll', scrollHandler, { passive: true });
        this.milestones = {};
      },
      
      toggleShareMenu() {
        this.showShareMenu = !this.showShareMenu;
      },
      
      shareOn(platform) {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(document.title);
        const text = encodeURIComponent(document.querySelector('meta[name="description"]')?.content || '');
        
        let shareUrl = '';
        
        switch(platform) {
          case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
            break;
          case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            break;
          case 'linkedin':
            shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
            break;
        }
        
        if (shareUrl) {
          window.open(shareUrl, '_blank', 'width=600,height=400');
          this.trackShare(platform);
        }
        
        this.showShareMenu = false;
      },
      
      copyLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
          this.showToast('Link copied to clipboard!', 'success');
          this.trackShare('copy_link');
        }).catch(() => {
          this.showToast('Failed to copy link', 'error');
        });
        
        this.showShareMenu = false;
      },
      
      toggleBookmark() {
        this.bookmarked = !this.bookmarked;
        this.saveBookmarkState();
        
        this.showToast(
          this.bookmarked ? 'Post bookmarked!' : 'Bookmark removed',
          this.bookmarked ? 'success' : 'info'
        );
        
        this.trackBookmark();
      },
      
      loadBookmarkState() {
        const bookmarks = JSON.parse(localStorage.getItem('blitz-bookmarks') || '[]');
        this.bookmarked = bookmarks.includes(this.postId);
      },
      
      saveBookmarkState() {
        const bookmarks = JSON.parse(localStorage.getItem('blitz-bookmarks') || '[]');
        
        if (this.bookmarked) {
          if (!bookmarks.includes(this.postId)) {
            bookmarks.push(this.postId);
          }
        } else {
          const index = bookmarks.indexOf(this.postId);
          if (index > -1) {
            bookmarks.splice(index, 1);
          }
        }
        
        localStorage.setItem('blitz-bookmarks', JSON.stringify(bookmarks));
      },
      
      trackMilestone(milestone) {
        if (typeof gtag !== 'undefined') {
          gtag('event', 'reading_progress', {
            'milestone': milestone,
            'post_id': this.postId,
            'event_category': 'engagement'
          });
        }
      },
      
      trackShare(platform) {
        if (typeof gtag !== 'undefined') {
          gtag('event', 'share', {
            'method': platform,
            'content_type': 'post',
            'content_id': this.postId
          });
        }
      },
      
      trackBookmark() {
        if (typeof gtag !== 'undefined') {
          gtag('event', this.bookmarked ? 'bookmark_add' : 'bookmark_remove', {
            'post_id': this.postId,
            'event_category': 'engagement'
          });
        }
      },
      
      showToast(message, type = 'info') {
        window.dispatchEvent(new CustomEvent('show-toast', {
          detail: { message, type, duration: 3000 }
        }));
      }
    }));
  });
  
  // Smooth scroll to comments when hash is present
  document.addEventListener('DOMContentLoaded', () => {
    if (window.location.hash === '#comments') {
      setTimeout(() => {
        document.getElementById('comments')?.scrollIntoView({ 
          behavior: 'smooth',
          block: 'start'
        });
      }, 100);
    }
  });
  
  // Handle print styles
  window.addEventListener('beforeprint', () => {
    document.querySelector('.reading-progress')?.style.setProperty('display', 'none');
    document.querySelector('.floating-actions')?.style.setProperty('display', 'none');
  });
  
  window.addEventListener('afterprint', () => {
    document.querySelector('.reading-progress')?.style.removeProperty('display');
    document.querySelector('.floating-actions')?.style.removeProperty('display');
  });
</script>