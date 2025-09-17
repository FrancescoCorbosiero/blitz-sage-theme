{{--
  Enhanced Blog Post Content (Archive/Index view)
  Modern card-based layout with rich media support and interaction features
--}}

<article @php(post_class('post-card group relative bg-card-bg border border-border-color rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1'))
         x-data="postCard({{ get_the_ID() }})"
         x-intersect="trackView">
  
  {{-- Featured Image --}}
  @if(has_post_thumbnail())
    <div class="post-thumbnail relative overflow-hidden">
      <a href="{{ get_permalink() }}" 
         class="block relative aspect-video bg-gray-100">
        
        {{-- Image with lazy loading --}}
        <img src="{{ get_the_post_thumbnail_url(get_the_ID(), 'medium_large') }}" 
             alt="{{ get_the_title() }}"
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
             loading="lazy"
             x-data="{ loaded: false }"
             @load="loaded = true"
             :class="{ 'opacity-100': loaded, 'opacity-0': !loaded }">
        
        {{-- Loading placeholder --}}
        <div x-show="!loaded" 
             class="absolute inset-0 bg-gray-200 animate-pulse flex items-center justify-center">
          <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
        </div>
        
        {{-- Overlay gradient --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        
        {{-- Read time overlay --}}
        <div class="absolute top-4 right-4 bg-black/70 text-white text-xs px-2 py-1 rounded-full">
          {{ estimated_reading_time(get_the_content()) }} {{ __('min read', 'blitz') }}
        </div>
      </a>
    </div>
  @endif
  
  {{-- Post Content --}}
  <div class="post-content p-6">
    
    {{-- Post Meta --}}
    <header class="post-header mb-4">
      {{-- Categories --}}
      @if(get_the_category())
        <div class="post-categories mb-3">
          @foreach(get_the_category() as $category)
            <a href="{{ get_category_link($category) }}" 
               class="inline-block text-xs font-medium px-2 py-1 bg-primary/10 text-primary rounded-full hover:bg-primary/20 transition-colors mr-2">
              {{ $category->name }}
            </a>
          @endforeach
        </div>
      @endif
      
      {{-- Post Title --}}
      <h2 class="entry-title text-xl lg:text-2xl font-bold text-text-primary group-hover:text-primary transition-colors duration-200 leading-tight mb-3">
        <a href="{{ get_permalink() }}" class="block">
          {!! $title !!}
        </a>
      </h2>
      
      {{-- Meta Information --}}
      <div class="entry-meta flex items-center gap-4 text-sm text-text-muted mb-4">
        
        {{-- Author --}}
        <div class="flex items-center gap-2">
          @if(get_avatar_url(get_the_author_meta('ID')))
            <img src="{{ get_avatar_url(get_the_author_meta('ID'), ['size' => 32]) }}" 
                 alt="{{ get_the_author() }}"
                 class="w-6 h-6 rounded-full">
          @else
            <div class="w-6 h-6 bg-primary/20 rounded-full flex items-center justify-center">
              <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
          @endif
          <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" 
             class="hover:text-primary transition-colors">
            {{ get_the_author() }}
          </a>
        </div>
        
        {{-- Date --}}
        <div class="flex items-center gap-1">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
          <time class="dt-published" datetime="{{ get_post_time('c', true) }}">
            {{ get_the_date() }}
          </time>
        </div>
        
        {{-- Comments count --}}
        @if(comments_open() || get_comments_number())
          <div class="flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <a href="{{ get_permalink() }}#comments" 
               class="hover:text-primary transition-colors">
              {{ get_comments_number() }} 
              {{ _n('comment', 'comments', get_comments_number(), 'blitz') }}
            </a>
          </div>
        @endif
      </div>
    </header>
    
    {{-- Post Excerpt --}}
    <div class="entry-summary text-text-secondary leading-relaxed mb-6">
      @if(has_excerpt())
        <p>{{ get_the_excerpt() }}</p>
      @else
        <p>{{ wp_trim_words(get_the_content(), 30, '...') }}</p>
      @endif
    </div>
    
    {{-- Post Footer --}}
    <footer class="post-footer flex items-center justify-between">
      
      {{-- Read More Button --}}
      <a href="{{ get_permalink() }}" 
         class="inline-flex items-center gap-2 text-primary font-medium hover:text-primary-dark transition-colors group/link">
        <span>{{ __('Read More', 'blitz') }}</span>
        <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-1" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
      </a>
      
      {{-- Post Actions --}}
      <div class="post-actions flex items-center gap-2">
        
        {{-- Bookmark Button --}}
        <button @click="toggleBookmark" 
                :class="{ 'text-accent': bookmarked, 'text-text-muted hover:text-primary': !bookmarked }"
                class="p-2 rounded-lg hover:bg-bg-tertiary transition-colors"
                :title="bookmarked ? '{{ __('Remove Bookmark', 'blitz') }}' : '{{ __('Bookmark', 'blitz') }}'">
          <svg class="w-5 h-5" :fill="bookmarked ? 'currentColor' : 'none'" 
               stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
          </svg>
        </button>
        
        {{-- Share Button --}}
        <button @click="share" 
                class="p-2 rounded-lg text-text-muted hover:text-primary hover:bg-bg-tertiary transition-colors"
                title="{{ __('Share', 'blitz') }}">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
          </svg>
        </button>
      </div>
    </footer>
  </div>
  
  {{-- Loading overlay for interactions --}}
  <div x-show="loading" 
       class="absolute inset-0 bg-white/70 flex items-center justify-center z-10"
       x-transition>
    <div class="flex items-center gap-2 text-primary">
      <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-primary"></div>
      <span class="text-sm">{{ __('Loading...', 'blitz') }}</span>
    </div>
  </div>
</article>

{{-- Enhanced Styles --}}
<style>
  /* Post card hover effects */
  .post-card {
    transform-origin: center bottom;
  }
  
  .post-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  }
  
  /* Smooth image loading */
  .post-thumbnail img {
    transition: opacity 0.3s ease, transform 0.5s ease;
  }
  
  /* Enhanced typography */
  .entry-title a:hover {
    text-decoration: underline;
    text-decoration-color: var(--primary);
    text-decoration-thickness: 2px;
    text-underline-offset: 4px;
  }
  
  /* Meta hover effects */
  .entry-meta a:hover {
    color: var(--primary);
  }
  
  /* Action buttons */
  .post-actions button {
    transition: all 0.2s ease;
  }
  
  .post-actions button:hover {
    transform: scale(1.1);
  }
  
  /* Dark mode adjustments */
  [data-theme="dark"] .post-card {
    background: var(--bg-secondary);
    border-color: var(--border-color);
  }
  
  [data-theme="dark"] .post-card:hover {
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
  }
</style>

{{-- Post Interaction Script --}}
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('postCard', (postId) => ({
      postId,
      bookmarked: false,
      loading: false,
      viewed: false,
      
      init() {
        // Load bookmark state from localStorage
        this.bookmarked = this.isBookmarked();
      },
      
      trackView() {
        if (!this.viewed) {
          this.viewed = true;
          
          // Track post view for analytics
          if (typeof gtag !== 'undefined') {
            gtag('event', 'post_view', {
              'post_id': this.postId,
              'event_category': 'engagement'
            });
          }
        }
      },
      
      toggleBookmark() {
        this.loading = true;
        
        setTimeout(() => {
          this.bookmarked = !this.bookmarked;
          this.saveBookmark();
          this.loading = false;
          
          // Show feedback
          this.showToast(
            this.bookmarked ? 'Post bookmarked!' : 'Bookmark removed',
            this.bookmarked ? 'success' : 'info'
          );
        }, 300);
      },
      
      share() {
        const url = window.location.href.replace(window.location.hash, '') + `#post-${this.postId}`;
        const title = document.querySelector(`[data-post-id="${this.postId}"] .entry-title a`)?.textContent || 'Check this out!';
        
        if (navigator.share) {
          navigator.share({
            title: title,
            url: url
          }).catch(err => console.log('Error sharing:', err));
        } else {
          // Fallback - copy to clipboard
          navigator.clipboard.writeText(url).then(() => {
            this.showToast('Link copied to clipboard!', 'success');
          }).catch(() => {
            // Fallback for older browsers
            this.showShareModal(url, title);
          });
        }
      },
      
      isBookmarked() {
        const bookmarks = JSON.parse(localStorage.getItem('blitz-bookmarks') || '[]');
        return bookmarks.includes(this.postId);
      },
      
      saveBookmark() {
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
      
      showToast(message, type = 'info') {
        // Dispatch toast event
        window.dispatchEvent(new CustomEvent('show-toast', {
          detail: { message, type, duration: 3000 }
        }));
      },
      
      showShareModal(url, title) {
        // Create simple share modal for older browsers
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50';
        modal.innerHTML = `
          <div class="bg-white rounded-lg p-6 max-w-md mx-4">
            <h3 class="text-lg font-semibold mb-4">Share this post</h3>
            <div class="flex gap-2 mb-4">
              <input type="text" value="${url}" readonly 
                     class="flex-1 px-3 py-2 border border-gray-300 rounded-md text-sm"
                     onclick="this.select()">
              <button onclick="navigator.clipboard.writeText('${url}'); this.textContent='Copied!'" 
                      class="px-4 py-2 bg-primary text-white rounded-md text-sm hover:bg-primary-dark">
                Copy
              </button>
            </div>
            <div class="flex justify-end">
              <button onclick="this.closest('.fixed').remove()" 
                      class="px-4 py-2 text-gray-600 hover:text-gray-800">
                Close
              </button>
            </div>
          </div>
        `;
        document.body.appendChild(modal);
        
        // Remove on background click
        modal.addEventListener('click', (e) => {
          if (e.target === modal) {
            modal.remove();
          }
        });
      }
    }));
  });
  
  // Global reading time calculator
  function estimated_reading_time(content) {
    if (typeof content !== 'string') return 1;
    
    const wordsPerMinute = 200;
    const textContent = content.replace(/<[^>]*>/g, ''); // Strip HTML
    const wordCount = textContent.split(/\s+/).length;
    const readingTime = Math.ceil(wordCount / wordsPerMinute);
    
    return readingTime || 1;
  }
  
  // Make function available globally
  window.estimated_reading_time = estimated_reading_time;