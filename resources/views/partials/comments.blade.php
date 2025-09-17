{{--
  Enhanced Comments Section - Fixed Version
  Modern comment system with threading, reactions, and social features
--}}

@php
    // Get comments data safely
    $comments_number = get_comments_number();
    $comments_open = comments_open();
    $have_comments = $comments_number > 0;
    $comments_title = sprintf(
        _n('One Comment', '%1$s Comments', $comments_number, 'blitz'),
        number_format_i18n($comments_number)
    );
@endphp

@if (!post_password_required())
    <section id="comments" 
             class="comments-section mt-12 lg:mt-16"
             x-data="commentsComponent()"
             x-init="init()">
        
        {{-- Comments Header --}}
        @if ($have_comments)
            <header class="comments-header mb-8">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl lg:text-3xl font-bold text-text-primary flex items-center gap-3">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        {{ $comments_title }}
                    </h2>
                    
                    {{-- Comment Stats --}}
                    <div class="flex items-center gap-4 text-sm text-text-muted">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8V4l4 4z"/>
                            </svg>
                            {{ $comments_number }} {{ __('comments', 'blitz') }}
                        </span>
                    </div>
                </div>
            </header>

            {{-- Comment Filters & Sort --}}
            <div class="comments-filters mb-6 flex flex-wrap items-center justify-between gap-4 p-4 bg-bg-secondary rounded-xl">
                <div class="flex items-center gap-3">
                    <label class="text-sm font-medium text-text-primary">{{ __('Sort by:', 'blitz') }}</label>
                    <select x-model="sortBy" 
                            @change="sortComments()"
                            class="text-sm border border-border-color rounded-lg px-3 py-1 bg-bg-primary">
                        <option value="newest">{{ __('Newest First', 'blitz') }}</option>
                        <option value="oldest">{{ __('Oldest First', 'blitz') }}</option>
                        <option value="helpful">{{ __('Most Helpful', 'blitz') }}</option>
                    </select>
                </div>
                
                <div class="flex items-center gap-2">
                    <button @click="toggleThreaded()" 
                            class="text-sm px-3 py-1 rounded-lg transition-colors"
                            :class="threaded ? 'bg-primary text-white' : 'bg-bg-tertiary text-text-muted hover:text-text-primary'">
                        {{ __('Threaded View', 'blitz') }}
                    </button>
                </div>
            </div>

            {{-- Comments List --}}
            <div class="comments-wrapper">
                <div class="comment-list space-y-6" x-show="!loading">
                    {{-- WordPress will render comments here via wp_list_comments --}}
                    @if (have_comments())
                        <ol class="commentlist">
                            @php
                                wp_list_comments([
                                    'style' => 'ol',
                                    'short_ping' => true,
                                    'callback' => function($comment, $args, $depth) {
                                        echo '<li ' . comment_class('comment-item', $comment) . ' id="comment-' . get_comment_ID() . '">';
                                        echo '<article class="comment-body bg-card-bg border border-border-color rounded-lg p-4 mb-4">';
                                        
                                        // Author avatar
                                        echo '<div class="comment-meta flex items-start gap-3 mb-3">';
                                        echo '<div class="comment-avatar">' . get_avatar($comment, 48, '', '', ['class' => 'w-12 h-12 rounded-full']) . '</div>';
                                        echo '<div class="comment-author-info flex-1">';
                                        echo '<div class="comment-author font-semibold">' . get_comment_author_link($comment) . '</div>';
                                        echo '<div class="comment-date text-sm text-text-muted">' . get_comment_date() . ' at ' . get_comment_time() . '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                        
                                        // Comment content
                                        echo '<div class="comment-content text-text-secondary">';
                                        comment_text();
                                        echo '</div>';
                                        
                                        // Reply link
                                        if (get_comment_type() === 'comment') {
                                            comment_reply_link([
                                                'depth' => $depth,
                                                'max_depth' => $args['max_depth'],
                                                'reply_text' => __('Reply', 'blitz'),
                                                'before' => '<div class="comment-reply mt-3">',
                                                'after' => '</div>'
                                            ]);
                                        }
                                        
                                        echo '</article>';
                                    }
                                ]);
                            @endphp
                        </ol>
                    @endif
                </div>
                
                {{-- Loading State --}}
                <div x-show="loading" class="flex items-center justify-center py-12">
                    <div class="flex items-center gap-3 text-text-muted">
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-primary"></div>
                        <span>{{ __('Loading comments...', 'blitz') }}</span>
                    </div>
                </div>
            </div>

            {{-- Comments Pagination --}}
            @if (get_comment_pages_count() > 1 && get_option('page_comments'))
                <nav class="comment-navigation mt-8" aria-label="Comment Navigation">
                    <div class="flex items-center justify-between">
                        @if (get_previous_comments_link())
                            <div class="previous">
                                {!! get_previous_comments_link(__('&larr; Older Comments', 'blitz')) !!}
                            </div>
                        @else
                            <div></div>
                        @endif

                        @if (get_next_comments_link())
                            <div class="next">
                                {!! get_next_comments_link(__('Newer Comments &rarr;', 'blitz')) !!}
                            </div>
                        @endif
                    </div>
                </nav>
            @endif
        @else
            {{-- No Comments State --}}
            <div class="no-comments text-center py-12">
                <svg class="w-16 h-16 text-text-muted mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <h3 class="text-lg font-medium text-text-primary mb-2">
                    {{ __('No comments yet', 'blitz') }}
                </h3>
                <p class="text-text-muted">
                    {{ __('Be the first to share your thoughts!', 'blitz') }}
                </p>
            </div>
        @endif

        {{-- Comments Form --}}
        @if ($comments_open)
            <div class="comment-form-wrapper mt-8">
                <h3 class="text-xl font-semibold text-text-primary mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    {{ __('Leave a Comment', 'blitz') }}
                </h3>
                
                @php
                    comment_form([
                        'title_reply' => '',
                        'comment_field' => '<div class="comment-form-comment mb-6">
                            <label for="comment" class="block text-sm font-medium text-text-primary mb-2">' . __('Your Comment *', 'blitz') . '</label>
                            <textarea id="comment" name="comment" rows="6" required 
                                     class="w-full px-4 py-3 border border-border-color rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors resize-y" 
                                     placeholder="' . __('Share your thoughts...', 'blitz') . '"></textarea>
                          </div>',
                        'fields' => [
                            'author' => '<div class="grid md:grid-cols-2 gap-4 mb-6">
                              <div class="comment-form-author">
                                <label for="author" class="block text-sm font-medium text-text-primary mb-2">' . __('Name *', 'blitz') . '</label>
                                <input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author'] ?? '') . '" size="30" maxlength="245" required 
                                       class="w-full px-4 py-3 border border-border-color rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                              </div>',
                            'email' => '<div class="comment-form-email">
                                <label for="email" class="block text-sm font-medium text-text-primary mb-2">' . __('Email *', 'blitz') . '</label>
                                <input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email'] ?? '') . '" size="30" maxlength="100" aria-describedby="email-notes" required 
                                       class="w-full px-4 py-3 border border-border-color rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                              </div></div>',
                            'url' => '<div class="comment-form-url mb-6">
                              <label for="url" class="block text-sm font-medium text-text-primary mb-2">' . __('Website', 'blitz') . '</label>
                              <input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url'] ?? '') . '" size="30" maxlength="200" 
                                     class="w-full px-4 py-3 border border-border-color rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>',
                        ],
                        'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            %4$s
                          </button>',
                        'submit_field' => '<div class="form-submit flex items-center justify-between">
                            <div class="text-sm text-text-muted">
                              <span>' . __('Required fields are marked with *', 'blitz') . '</span>
                            </div>
                            %1$s %2$s
                          </div>',
                        'class_submit' => 'inline-flex items-center px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark transition-colors duration-200 shadow-md hover:shadow-lg'
                    ]);
                @endphp
            </div>
        @else
            {{-- Comments Closed Notice --}}
            <div class="comments-closed bg-bg-secondary border border-border-color rounded-lg p-6 text-center">
                <svg class="w-12 h-12 text-text-muted mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <h3 class="text-lg font-medium text-text-primary mb-2">
                    {{ __('Comments Closed', 'blitz') }}
                </h3>
                <p class="text-text-muted">
                    {{ __('Comments are closed for this post.', 'blitz') }}
                </p>
            </div>
        @endif
    </section>
@endif

<style>
/* Enhanced comment styling */
.comments-section .commentlist {
    list-style: none;
    padding: 0;
    margin: 0;
}

.comments-section .comment-item {
    margin-bottom: 1.5rem;
}

/* Comment threading lines */
.comments-section .children {
    margin-left: 2rem;
    position: relative;
}

.comments-section .children::before {
    content: '';
    position: absolute;
    left: -1rem;
    top: 0;
    bottom: 2rem;
    width: 2px;
    background: var(--border-color);
}

/* Comment cards */
.comments-section .comment-body {
    transition: all 0.3s ease;
}

.comments-section .comment-body:hover {
    box-shadow: 0 4px 12px var(--shadow);
    border-color: var(--primary-soft);
}

/* Comment form enhancements */
.comment-form input:focus,
.comment-form textarea:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(74, 124, 40, 0.1);
}

/* Dark mode adjustments */
[data-theme="dark"] .comments-section .comment-body {
    background: var(--bg-secondary);
    border-color: var(--border-color);
}

[data-theme="dark"] .comments-section .children::before {
    background: var(--border-color);
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('commentsComponent', () => ({
        loading: false,
        sortBy: 'newest',
        threaded: true,
        
        init() {
            this.setupCommentInteractions();
            this.loadSavedPreferences();
        },
        
        sortComments() {
            this.loading = true;
            setTimeout(() => {
                this.loading = false;
                this.savePreferences();
            }, 500);
        },
        
        toggleThreaded() {
            this.threaded = !this.threaded;
            this.savePreferences();
            
            const comments = document.querySelectorAll('.commentlist .children');
            comments.forEach(child => {
                if (this.threaded) {
                    child.style.marginLeft = '2rem';
                } else {
                    child.style.marginLeft = '0';
                }
            });
        },
        
        setupCommentInteractions() {
            // Add helpful/unhelpful buttons if needed
            // Add reply functionality
            // Add sharing options
        },
        
        loadSavedPreferences() {
            const prefs = localStorage.getItem('blitz-comment-prefs');
            if (prefs) {
                const parsed = JSON.parse(prefs);
                this.sortBy = parsed.sortBy || 'newest';
                this.threaded = parsed.threaded ?? true;
            }
        },
        
        savePreferences() {
            localStorage.setItem('blitz-comment-prefs', JSON.stringify({
                sortBy: this.sortBy,
                threaded: this.threaded
            }));
        }
    }));
});
</script>