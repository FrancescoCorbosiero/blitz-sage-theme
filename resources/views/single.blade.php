{{-- resources/views/single.blade.php --}}
@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <article class="single-post-premium" x-data="singlePost()" x-init="init()">
      
      {{-- Reading Progress Bar --}}
      <div class="reading-progress fixed top-0 left-0 w-full h-1 bg-bg-tertiary/30 z-50">
        <div class="progress-bar h-full bg-gradient-to-r from-primary via-accent to-primary-soft transition-all duration-300"
             :style="{ width: readingProgress + '%' }"></div>
      </div>
      
      {{-- Hero Section --}}
      <header class="post-hero relative overflow-hidden">
        @if(has_post_thumbnail())
          <div class="hero-image-wrapper relative">
            {{-- Parallax Image Container --}}
            <div class="parallax-container h-[70vh] lg:h-[80vh] relative" x-ref="parallax">
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent z-10"></div>
              {!! get_the_post_thumbnail(null, 'full', [
                'class' => 'hero-image absolute inset-0 w-full h-full object-cover scale-110',
                'loading' => 'eager',
                'x-ref' => 'heroImage'
              ]) !!}
              
              {{-- Animated Overlay Pattern --}}
              <div class="absolute inset-0 z-20 opacity-20">
                <div class="pattern-dots"></div>
              </div>
            </div>
          </div>
        @endif
        
        <div class="hero-content {{ has_post_thumbnail() ? 'absolute inset-0 z-30 flex items-end' : 'py-20 lg:py-32 bg-gradient-to-br from-bg-primary via-bg-secondary to-bg-tertiary' }}">
          <div class="container mx-auto px-4">
            <div class="max-w-5xl {{ has_post_thumbnail() ? 'pb-20' : 'mx-auto' }}">
              {{-- Category Badge --}}
              @if(get_the_category())
                <div class="category-badges mb-6" x-data="{ hover: false }">
                  @foreach(get_the_category() as $category)
                    <a href="{{ get_category_link($category) }}" 
                       class="category-badge"
                       @mouseenter="hover = true"
                       @mouseleave="hover = false">
                      <span class="badge-inner">
                        {{ $category->name }}
                      </span>
                    </a>
                  @endforeach
                </div>
              @endif
              
              {{-- Post Title with Animation --}}
              <h1 class="post-title text-4xl md:text-5xl lg:text-7xl font-bold leading-tight mb-6 {{ has_post_thumbnail() ? 'text-white' : 'text-text-primary' }}"
                  x-data="{ show: false }"
                  x-init="setTimeout(() => show = true, 100)"
                  x-show="show"
                  x-transition:enter="transition ease-out duration-800"
                  x-transition:enter-start="opacity-0 transform translate-y-10"
                  x-transition:enter-end="opacity-100 transform translate-y-0">
                {!! get_the_title() !!}
              </h1>
              
              {{-- Enhanced Meta Information --}}
              <div class="post-meta-enhanced flex flex-wrap items-center gap-6 {{ has_post_thumbnail() ? 'text-white/90' : 'text-text-secondary' }}">
                {{-- Author with Avatar --}}
                <div class="author-meta flex items-center gap-3">
                  {!! get_avatar(get_the_author_meta('ID'), 40, '', get_the_author(), [
                    'class' => 'w-10 h-10 rounded-full border-2 border-white/30'
                  ]) !!}
                  <div>
                    <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" 
                       class="font-semibold hover:underline">
                      {{ get_the_author() }}
                    </a>
                    <div class="text-xs opacity-80">{{ get_the_author_meta('description') ? wp_trim_words(get_the_author_meta('description'), 10) : __('Author', 'blitz') }}</div>
                  </div>
                </div>
                
                {{-- Date & Reading Time --}}
                <div class="meta-stats flex items-center gap-4 text-sm">
                  <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <time datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time>
                  </span>
                  
                  <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span x-text="readingTime + ' min read'"></span>
                  </span>
                  
                  <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span x-text="viewCount + ' views'"></span>
                  </span>
                </div>
              </div>
              
              {{-- Excerpt --}}
              @if(has_excerpt())
                <div class="post-excerpt mt-6 text-xl leading-relaxed {{ has_post_thumbnail() ? 'text-white/80' : 'text-text-secondary' }}">
                  {!! get_the_excerpt() !!}
                </div>
              @endif
            </div>
          </div>
        </div>
      </header>

      {{-- Floating Actions Bar --}}
      <div class="floating-actions fixed left-8 top-1/2 -translate-y-1/2 z-40 hidden lg:block"
           x-show="showFloatingActions"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 -translate-x-10"
           x-transition:enter-end="opacity-100 translate-x-0">
        <div class="actions-container flex flex-col gap-4">
          {{-- Like Button --}}
          <button @click="toggleLike" 
                  class="action-btn"
                  :class="{ 'active': liked }">
            <svg class="w-5 h-5" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <span class="action-count" x-text="likeCount"></span>
          </button>
          
          {{-- Comment Jump --}}
          <button @click="scrollToComments" class="action-btn">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <span class="action-count">{{ get_comments_number() }}</span>
          </button>
          
          {{-- Bookmark --}}
          <button @click="toggleBookmark" 
                  class="action-btn"
                  :class="{ 'active': bookmarked }">
            <svg class="w-5 h-5" :fill="bookmarked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
            </svg>
          </button>
          
          {{-- Share --}}
          <button @click="showShareMenu = !showShareMenu" class="action-btn">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
            </svg>
          </button>
        </div>
        
        {{-- Share Menu --}}
        <div class="share-menu-floating" x-show="showShareMenu" x-transition @click.away="showShareMenu = false">
          @include('partials.share-menu-compact')
        </div>
      </div>

      {{-- Post Content --}}
      <div class="post-content py-20 lg:py-32">
        <div class="container mx-auto px-4">
          <div class="grid lg:grid-cols-12 gap-12">
            
            {{-- Table of Contents (Desktop) --}}
            <aside class="lg:col-span-3 hidden lg:block">
              <div class="toc-container sticky top-24" x-data="tableOfContents()" x-init="init()">
                <h3 class="text-sm font-bold text-text-primary mb-4 uppercase tracking-wider">
                  {{ __('Table of Contents', 'blitz') }}
                </h3>
                <nav class="toc-nav">
                  <ul class="space-y-2" x-ref="tocList">
                    {{-- Dynamically generated --}}
                  </ul>
                </nav>
                
                {{-- Reading Progress Circle --}}
                <div class="reading-progress-circle mt-8">
                  <svg class="progress-ring" width="60" height="60">
                    <circle class="progress-ring-bg" cx="30" cy="30" r="28" stroke="var(--border-color)" stroke-width="4" fill="none"/>
                    <circle class="progress-ring-bar" cx="30" cy="30" r="28" 
                            stroke="var(--primary)" stroke-width="4" fill="none"
                            stroke-dasharray="176"
                            :stroke-dashoffset="176 - (176 * readingProgress / 100)"
                            transform="rotate(-90 30 30)"/>
                  </svg>
                  <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-xs font-bold" x-text="Math.round(readingProgress) + '%'"></span>
                  </div>
                </div>
              </div>
            </aside>

            {{-- Main Content --}}
            <div class="lg:col-span-6">
              <div class="prose-enhanced prose prose-lg max-w-none
                         prose-headings:font-bold prose-headings:text-text-primary prose-headings:scroll-mt-24
                         prose-p:text-text-secondary prose-p:leading-relaxed
                         prose-a:text-primary prose-a:no-underline hover:prose-a:underline
                         prose-strong:text-text-primary prose-strong:font-semibold
                         prose-blockquote:border-l-4 prose-blockquote:border-primary prose-blockquote:bg-bg-tertiary/50 prose-blockquote:py-4 prose-blockquote:px-6 prose-blockquote:rounded-r-lg prose-blockquote:italic
                         prose-code:bg-bg-tertiary prose-code:text-primary prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:before:content-[''] prose-code:after:content-['']
                         prose-pre:bg-bg-tertiary prose-pre:border prose-pre:border-border-color prose-pre:rounded-xl
                         prose-img:rounded-xl prose-img:shadow-2xl prose-img:mx-auto
                         prose-video:rounded-xl prose-video:shadow-2xl
                         prose-figcaption:text-center prose-figcaption:text-sm prose-figcaption:text-text-muted prose-figcaption:mt-3
                         prose-table:border prose-table:border-border-color
                         prose-th:bg-bg-tertiary prose-th:font-semibold
                         prose-td:border prose-td:border-border-color"
                         x-ref="content">
                
                {!! apply_filters('the_content', get_the_content()) !!}
                
                {{-- Content Improvements --}}
                <div class="content-enhancements">
                  {{-- Highlight Box Example --}}
                  <div class="highlight-box info">
                    <div class="highlight-icon">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                    </div>
                    <div class="highlight-content">
                      <strong>Pro Tip:</strong> This is an example of enhanced content styling that can be used throughout your posts.
                    </div>
                  </div>
                </div>
              </div>

              {{-- Post Footer --}}
              <footer class="post-footer mt-16">
                {{-- Tags --}}
                @if(get_the_tags())
                  <div class="post-tags mb-12">
                    <h3 class="text-sm font-bold text-text-primary mb-4 uppercase tracking-wider">
                      {{ __('Tagged With', 'blitz') }}
                    </h3>
                    <div class="tags-cloud">
                      @foreach(get_the_tags() as $tag)
                        <a href="{{ get_tag_link($tag) }}" class="tag-pill">
                          <span class="tag-hash">#</span>{{ $tag->name }}
                        </a>
                      @endforeach
                    </div>
                  </div>
                @endif

                {{-- Enhanced Share Section --}}
                <div class="share-section mb-12" x-data="shareSection()">
                  <h3 class="text-sm font-bold text-text-primary mb-6 uppercase tracking-wider">
                    {{ __('Share This Article', 'blitz') }}
                  </h3>
                  <div class="share-buttons-grid">
                    <button @click="share('twitter')" class="share-btn twitter">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                      </svg>
                      <span>Twitter</span>
                    </button>
                    
                    <button @click="share('facebook')" class="share-btn facebook">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                      </svg>
                      <span>Facebook</span>
                    </button>
                    
                    <button @click="share('linkedin')" class="share-btn linkedin">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                      </svg>
                      <span>LinkedIn</span>
                    </button>
                    
                    <button @click="share('whatsapp')" class="share-btn whatsapp">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                      </svg>
                      <span>WhatsApp</span>
                    </button>
                    
                    <button @click="share('email')" class="share-btn email">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                      </svg>
                      <span>Email</span>
                    </button>
                    
                    <button @click="copyLink" class="share-btn copy" :class="{ 'copied': copied }">
                      <svg x-show="!copied" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                      </svg>
                      <svg x-show="copied" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                      </svg>
                      <span x-text="copied ? 'Copied!' : 'Copy Link'"></span>
                    </button>
                  </div>
                </div>

                {{-- Author Bio Enhanced --}}
                @if(get_the_author_meta('description'))
                  <div class="author-bio-enhanced">
                    <div class="bio-header">
                      <h3 class="text-sm font-bold text-text-primary mb-6 uppercase tracking-wider">
                        {{ __('About The Author', 'blitz') }}
                      </h3>
                    </div>
                    <div class="bio-content">
                      <div class="author-avatar">
                        {!! get_avatar(get_the_author_meta('ID'), 100, '', get_the_author(), [
                          'class' => 'w-24 h-24 rounded-2xl'
                        ]) !!}
                      </div>
                      <div class="author-details">
                        <h4 class="author-name">{{ get_the_author() }}</h4>
                        <div class="author-role">{{ get_the_author_meta('user_description') ? __('Writer & Content Creator', 'blitz') : '' }}</div>
                        <div class="author-bio">
                          {!! get_the_author_meta('description') !!}
                        </div>
                        <div class="author-links">
                          @if(get_the_author_meta('url'))
                            <a href="{{ get_the_author_meta('url') }}" target="_blank" rel="noopener" class="author-link website">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                              </svg>
                            </a>
                          @endif
                          <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" class="author-link articles">
                            <span>{{ __('View All Articles', 'blitz') }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif

                {{-- Navigation --}}
                @include('partials.post-navigation')
              </footer>
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-3">
              <div class="sidebar-sticky sticky top-24 space-y-8">
                {{-- Newsletter CTA --}}
                <div class="newsletter-cta">
                  <div class="cta-icon">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                  </div>
                  <h3 class="cta-title">{{ __('Stay Updated', 'blitz') }}</h3>
                  <p class="cta-text">{{ __('Get the latest posts delivered to your inbox.', 'blitz') }}</p>
                  <form class="cta-form" @submit.prevent="subscribeNewsletter">
                    <input type="email" x-model="email" placeholder="{{ __('Your email', 'blitz') }}" required class="cta-input">
                    <button type="submit" class="cta-button">{{ __('Subscribe', 'blitz') }}</button>
                  </form>
                </div>
                
                {{-- Related Categories --}}
                @if(get_the_category())
                  <div class="related-categories">
                    <h3 class="widget-title">{{ __('Explore Topics', 'blitz') }}</h3>
                    <div class="categories-list">
                      @foreach(get_the_category() as $category)
                        <a href="{{ get_category_link($category) }}" class="category-item">
                          <span class="category-name">{{ $category->name }}</span>
                          <span class="category-count">{{ $category->count }}</span>
                        </a>
                      @endforeach
                    </div>
                  </div>
                @endif
                
                {{-- Popular Posts Widget --}}
                @include('partials.widgets.popular-posts-mini')
              </div>
            </aside>
          </div>
        </div>
      </div>

      {{-- Comments Section --}}
      @if(comments_open() || get_comments_number())
        <section class="post-comments py-20 bg-gradient-to-b from-bg-primary to-bg-secondary">
          <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
              @include('partials.comments')
            </div>
          </div>
        </section>
      @endif

      {{-- Related Posts Section --}}
      @include('partials.related-posts-premium')
    </article>
  @endwhile
@endsection

<style>
/* Premium Single Post Styles */
.single-post-premium {
  position: relative;
}

/* Parallax Effect */
.parallax-container {
  overflow: hidden;
}

/* Pattern Overlay */
.pattern-dots {
  width: 100%;
  height: 100%;
  background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 1px);
  background-size: 20px 20px;
}

/* Category Badges */
.category-badge {
  display: inline-block;
  position: relative;
  margin-right: 0.75rem;
}

.badge-inner {
  display: inline-block;
  padding: 0.375rem 1rem;
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 100px;
  font-size: 0.875rem;
  font-weight: 500;
  color: white;
  transition: all 0.3s ease;
}

.category-badge:hover .badge-inner {
  background: var(--primary);
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(74, 124, 40, 0.3);
}

/* Floating Actions */
.action-btn {
  position: relative;
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--card-bg);
  border: 2px solid var(--border-color);
  border-radius: 50%;
  color: var(--text-muted);
  transition: all 0.3s ease;
  cursor: pointer;
}

.action-btn:hover {
  border-color: var(--primary);
  color: var(--primary);
  transform: scale(1.1);
}

.action-btn.active {
  background: var(--primary);
  border-color: var(--primary);
  color: white;
}

.action-count {
  position: absolute;
  top: -4px;
  right: -4px;
  min-width: 20px;
  height: 20px;
  padding: 0 6px;
  background: var(--accent);
  color: white;
  border-radius: 10px;
  font-size: 11px;
  font-weight: bold;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Table of Contents */
.toc-nav {
  border-left: 2px solid var(--border-color);
  padding-left: 1rem;
}

.toc-item {
  position: relative;
  padding: 0.375rem 0;
  font-size: 0.875rem;
  color: var(--text-muted);
  cursor: pointer;
  transition: all 0.2s ease;
}

.toc-item:hover {
  color: var(--primary);
  padding-left: 0.5rem;
}

.toc-item.active {
  color: var(--primary);
  font-weight: 600;
}

.toc-item.active::before {
  content: '';
  position: absolute;
  left: -1rem;
  top: 50%;
  transform: translateY(-50%);
  width: 2px;
  height: 1.5rem;
  background: var(--primary);
}

/* Reading Progress Circle */
.reading-progress-circle {
  position: relative;
  width: 60px;
  height: 60px;
  margin: 0 auto;
}

.progress-ring-bar {
  transition: stroke-dashoffset 0.3s ease;
}

/* Enhanced Content Blocks */
.highlight-box {
  display: flex;
  gap: 1rem;
  padding: 1.25rem;
  margin: 2rem 0;
  border-radius: 0.75rem;
  border: 1px solid;
}

.highlight-box.info {
  background: rgba(59, 130, 246, 0.05);
  border-color: rgba(59, 130, 246, 0.2);
  color: rgb(59, 130, 246);
}

.highlight-box.warning {
  background: rgba(245, 158, 11, 0.05);
  border-color: rgba(245, 158, 11, 0.2);
  color: rgb(245, 158, 11);
}

.highlight-box.success {
  background: rgba(34, 197, 94, 0.05);
  border-color: rgba(34, 197, 94, 0.2);
  color: rgb(34, 197, 94);
}

.highlight-icon {
  flex-shrink: 0;
}

.highlight-content {
  flex: 1;
  color: var(--text-secondary);
}

.highlight-content strong {
  color: var(--text-primary);
}

/* Tags Cloud */
.tags-cloud {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;
}

.tag-pill {
  display: inline-flex;
  align-items: center;
  padding: 0.5rem 1rem;
  background: var(--bg-tertiary);
  border: 1px solid var(--border-color);
  border-radius: 100px;
  font-size: 0.875rem;
  color: var(--text-secondary);
  transition: all 0.3s ease;
}

.tag-pill:hover {
  background: var(--primary);
  border-color: var(--primary);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(74, 124, 40, 0.2);
}

.tag-hash {
  opacity: 0.5;
  margin-right: 0.25rem;
}

/* Share Buttons Grid */
.share-buttons-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 0.75rem;
}

.share-btn {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  padding: 1rem;
  background: var(--bg-tertiary);
  border: 1px solid var(--border-color);
  border-radius: 0.75rem;
  color: var(--text-secondary);
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

.share-btn:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.share-btn.twitter:hover {
  background: #1DA1F2;
  border-color: #1DA1F2;
  color: white;
}

.share-btn.facebook:hover {
  background: #1877F2;
  border-color: #1877F2;
  color: white;
}

.share-btn.linkedin:hover {
  background: #0A66C2;
  border-color: #0A66C2;
  color: white;
}

.share-btn.whatsapp:hover {
  background: #25D366;
  border-color: #25D366;
  color: white;
}

.share-btn.email:hover {
  background: var(--primary);
  border-color: var(--primary);
  color: white;
}

.share-btn.copy.copied {
  background: var(--primary);
  border-color: var(--primary);
  color: white;
}

/* Author Bio Enhanced */
.author-bio-enhanced {
  padding: 2rem;
  background: var(--card-bg);
  border: 1px solid var(--border-color);
  border-radius: 1rem;
}

.bio-content {
  display: flex;
  gap: 2rem;
}

.author-avatar {
  flex-shrink: 0;
}

.author-details {
  flex: 1;
}

.author-name {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 0.25rem;
}

.author-role {
  font-size: 0.875rem;
  color: var(--primary);
  margin-bottom: 1rem;
}

.author-bio {
  color: var(--text-secondary);
  line-height: 1.7;
  margin-bottom: 1.5rem;
}

.author-links {
  display: flex;
  gap: 1rem;
}

.author-link {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  background: var(--bg-tertiary);
  border-radius: 0.5rem;
  color: var(--text-secondary);
  font-size: 0.875rem;
  transition: all 0.3s ease;
}

.author-link:hover {
  background: var(--primary);
  color: white;
  transform: translateY(-2px);
}

/* Newsletter CTA */
.newsletter-cta {
  padding: 2rem;
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  border-radius: 1rem;
  text-align: center;
  color: white;
}

.cta-icon {
  display: inline-flex;
  padding: 1rem;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  margin-bottom: 1rem;
}

.cta-title {
  font-size: 1.25rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
}

.cta-text {
  font-size: 0.875rem;
  opacity: 0.9;
  margin-bottom: 1.5rem;
}

.cta-form {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.cta-input {
  padding: 0.75rem;
  background: rgba(255, 255, 255, 0.2);
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 0.5rem;
  color: white;
  outline: none;
}

.cta-input::placeholder {
  color: rgba(255, 255, 255, 0.7);
}

.cta-button {
  padding: 0.75rem;
  background: white;
  color: var(--primary);
  border: none;
  border-radius: 0.5rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.cta-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

/* Dark Mode Adjustments */
[data-theme="dark"] .highlight-box.info {
  background: rgba(59, 130, 246, 0.1);
}

[data-theme="dark"] .pattern-dots {
  opacity: 0.05;
}

/* Responsive */
@media (max-width: 1024px) {
  .floating-actions {
    display: none;
  }
  
  .lg\:grid-cols-12 {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .share-buttons-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .bio-content {
    flex-direction: column;
  }
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('singlePost', () => ({
        readingProgress: 0,
        readingTime: 0,
        viewCount: 0,
        likeCount: 0,
        liked: false,
        bookmarked: false,
        showFloatingActions: false,
        showShareMenu: false,
        
        init() {
            this.calculateReadingTime();
            this.trackReadingProgress();
            this.initParallax();
            this.incrementViewCount();
            this.loadUserPreferences();
        },
        
        calculateReadingTime() {
            const content = document.querySelector('.prose-enhanced');
            if (content) {
                const text = content.textContent || '';
                const wordsPerMinute = 200;
                const words = text.trim().split(/\s+/).length;
                this.readingTime = Math.ceil(words / wordsPerMinute);
            }
        },
        
        trackReadingProgress() {
            const updateProgress = () => {
                const scrollTop = window.scrollY;
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                this.readingProgress = (scrollTop / docHeight) * 100;
                
                // Show floating actions after scrolling
                this.showFloatingActions = scrollTop > 500;
            };
            
            window.addEventListener('scroll', updateProgress, { passive: true });
            updateProgress();
        },
        
        initParallax() {
            const image = this.$refs.heroImage;
            if (image) {
                window.addEventListener('scroll', () => {
                    const scrolled = window.scrollY;
                    const rate = scrolled * -0.5;
                    image.style.transform = `translateY(${rate}px) scale(1.1)`;
                }, { passive: true });
            }
        },
        
        incrementViewCount() {
            // Simulate view count
            this.viewCount = Math.floor(Math.random() * 1000) + 100;
        },
        
        loadUserPreferences() {
            const postId = '{{ get_the_ID() }}';
            const likes = JSON.parse(localStorage.getItem('liked_posts') || '[]');
            const bookmarks = JSON.parse(localStorage.getItem('bookmarked_posts') || '[]');
            
            this.liked = likes.includes(postId);
            this.bookmarked = bookmarks.includes(postId);
            this.likeCount = Math.floor(Math.random() * 50) + 10;
        },
        
        toggleLike() {
            this.liked = !this.liked;
            this.likeCount += this.liked ? 1 : -1;
            this.savePreference('liked_posts', '{{ get_the_ID() }}', this.liked);
        },
        
        toggleBookmark() {
            this.bookmarked = !this.bookmarked;
            this.savePreference('bookmarked_posts', '{{ get_the_ID() }}', this.bookmarked);
        },
        
        savePreference(key, postId, add) {
            let items = JSON.parse(localStorage.getItem(key) || '[]');
            if (add) {
                if (!items.includes(postId)) items.push(postId);
            } else {
                items = items.filter(id => id !== postId);
            }
            localStorage.setItem(key, JSON.stringify(items));
        },
        
        scrollToComments() {
            document.querySelector('.post-comments')?.scrollIntoView({ behavior: 'smooth' });
        }
    }));
    
    Alpine.data('tableOfContents', () => ({
        headings: [],
        activeHeading: null,
        
        init() {
            this.generateTOC();
            this.trackActiveHeading();
        },
        
        generateTOC() {
            const content = document.querySelector('.prose-enhanced');
            if (!content) return;
            
            const headings = content.querySelectorAll('h2, h3');
            const tocList = this.$refs.tocList;
            
            headings.forEach((heading, index) => {
                const id = `heading-${index}`;
                heading.id = id;
                
                const li = document.createElement('li');
                li.className = `toc-item ${heading.tagName === 'H3' ? 'ml-4' : ''}`;
                li.textContent = heading.textContent;
                li.dataset.target = id;
                li.addEventListener('click', () => {
                    document.getElementById(id).scrollIntoView({ behavior: 'smooth' });
                });
                
                tocList.appendChild(li);
                this.headings.push({ id, element: heading, tocItem: li });
            });
        },
        
        trackActiveHeading() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.headings.forEach(h => h.tocItem.classList.remove('active'));
                        const active = this.headings.find(h => h.element === entry.target);
                        if (active) active.tocItem.classList.add('active');
                    }
                });
            }, { rootMargin: '-100px 0px -70% 0px' });
            
            this.headings.forEach(h => observer.observe(h.element));
        }
    }));
    
    Alpine.data('shareSection', () => ({
        copied: false,
        
        share(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
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
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${title}%20${url}`;
                    break;
                case 'email':
                    shareUrl = `mailto:?subject=${title}&body=${url}`;
                    break;
            }
            
            if (shareUrl) window.open(shareUrl, '_blank', 'width=600,height=400');
        },
        
        async copyLink() {
            try {
                await navigator.clipboard.writeText(window.location.href);
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            } catch (err) {
                console.error('Failed to copy:', err);
            }
        }
    }));
});
</script>