<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Comments extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.comments',
        'forms.comments',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'title' => $this->title(),
            'responses' => $this->responses(),
            'previous' => $this->previous(),
            'next' => $this->next(),
            'paginated' => $this->paginated(),
            'closed' => $this->closed(),
            'commentForm' => $this->commentForm(),
            'commentsCount' => $this->commentsCount(),
            'threadedComments' => $this->threadedComments(),
        ];
    }

    /**
     * The comment title.
     */
    public function title(): string
    {
        $comments_number = get_comments_number();
        
        if ($comments_number == 0) {
            return __('No Comments', 'blitz');
        } elseif ($comments_number == 1) {
            return __('1 Comment', 'blitz');
        } else {
            return sprintf(__('%s Comments', 'blitz'), number_format_i18n($comments_number));
        }
    }

    /**
     * Retrieve the comments.
     */
    public function responses(): ?string
    {
        if (! have_comments()) {
            return null;
        }

        return wp_list_comments([
            'style' => 'ol',
            'short_ping' => true,
            'echo' => false,
            'avatar_size' => 60,
            'max_depth' => get_option('thread_comments_depth', 5),
            'callback' => [$this, 'customCommentCallback'],
        ]);
    }

    /**
     * Custom comment callback for better HTML structure.
     */
    public function customCommentCallback($comment, $args, $depth)
    {
        $tag = ($args['style'] === 'div') ? 'div' : 'li';
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(['comment-item', empty($args['has_children']) ? '' : 'parent']); ?>>
            <article class="comment-body">
                <header class="comment-meta">
                    <div class="comment-author vcard">
                        <?php 
                        if ($args['avatar_size'] != 0) {
                            echo get_avatar($comment, $args['avatar_size'], '', '', ['class' => 'avatar rounded-full']);
                        }
                        ?>
                        <div class="comment-metadata">
                            <?php printf('<cite class="fn font-semibold">%s</cite>', get_comment_author_link()); ?>
                            <time datetime="<?php comment_time('c'); ?>" class="comment-date text-sm text-gray-600">
                                <?php comment_date(); ?> at <?php comment_time(); ?>
                            </time>
                            <?php edit_comment_link(__('Edit', 'blitz'), '<span class="edit-link">', '</span>'); ?>
                        </div>
                    </div>
                </header>

                <div class="comment-content">
                    <?php if ($comment->comment_approved == '0') : ?>
                        <p class="comment-awaiting-moderation bg-yellow-100 text-yellow-800 p-3 rounded">
                            <?php _e('Your comment is awaiting moderation.', 'blitz'); ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php comment_text(); ?>
                </div>

                <div class="comment-reply">
                    <?php 
                    comment_reply_link(array_merge($args, [
                        'add_below' => 'comment',
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'before' => '<div class="reply">',
                        'after' => '</div>',
                        'reply_text' => __('Reply', 'blitz'),
                        'class' => 'btn btn-sm btn-outline',
                    ])); 
                    ?>
                </div>
            </article>
        <?php
    }

    /**
     * The previous comments link.
     */
    public function previous(): ?string
    {
        if (! get_previous_comments_link()) {
            return null;
        }

        return get_previous_comments_link(
            __('&larr; Older Comments', 'blitz')
        );
    }

    /**
     * The next comments link.
     */
    public function next(): ?string
    {
        if (! get_next_comments_link()) {
            return null;
        }

        return get_next_comments_link(
            __('Newer Comments &rarr;', 'blitz')
        );
    }

    /**
     * Determine if the comments are paginated.
     */
    public function paginated(): bool
    {
        return get_comment_pages_count() > 1 && get_option('page_comments');
    }

    /**
     * Determine if the comments are closed.
     */
    public function closed(): bool
    {
        return ! comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments');
    }

    /**
     * Get comments count.
     */
    public function commentsCount(): int
    {
        return get_comments_number();
    }

    /**
     * Check if threaded comments are enabled.
     */
    public function threadedComments(): bool
    {
        return get_option('thread_comments', false);
    }

    /**
     * Get comment form configuration.
     */
    public function commentForm(): array
    {
        $user = wp_get_current_user();
        $user_identity = $user->exists() ? $user->display_name : '';
        $req = get_option('require_name_email');
        $aria_req = ($req ? ' aria-required="true" required' : '');
        
        return [
            'title_reply' => __('Leave a Comment', 'blitz'),
            'title_reply_to' => __('Leave a Reply to %s', 'blitz'),
            'cancel_reply_link' => __('Cancel Reply', 'blitz'),
            'label_submit' => __('Post Comment', 'blitz'),
            'submit_button' => '<input name="%1$s" type="submit" id="%2$s" class="btn btn-primary %3$s" value="%4$s" />',
            'submit_field' => '<p class="form-submit">%1$s %2$s</p>',
            'format' => 'xhtml',
            'comment_field' => sprintf(
                '<div class="comment-form-comment"><label for="comment" class="sr-only">%s</label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" placeholder="%s" class="form-textarea" required></textarea></div>',
                __('Comment', 'blitz'),
                __('Write your comment here...', 'blitz')
            ),
            'fields' => [
                'author' => sprintf(
                    '<div class="comment-form-author"><label for="author" class="sr-only">%s</label><input id="author" name="author" type="text" value="%s" size="30" maxlength="245" placeholder="%s" class="form-input"%s /></div>',
                    __('Name', 'blitz'),
                    esc_attr($user_identity),
                    __('Your Name', 'blitz') . ($req ? ' *' : ''),
                    $aria_req
                ),
                'email' => sprintf(
                    '<div class="comment-form-email"><label for="email" class="sr-only">%s</label><input id="email" name="email" type="email" value="%s" size="30" maxlength="100" placeholder="%s" class="form-input"%s /></div>',
                    __('Email', 'blitz'),
                    esc_attr($user->user_email),
                    __('Your Email', 'blitz') . ($req ? ' *' : ''),
                    $aria_req
                ),
                'url' => sprintf(
                    '<div class="comment-form-url"><label for="url" class="sr-only">%s</label><input id="url" name="url" type="url" value="%s" size="30" maxlength="200" placeholder="%s" class="form-input" /></div>',
                    __('Website', 'blitz'),
                    esc_attr($user->user_url),
                    __('Your Website (optional)', 'blitz')
                ),
                'cookies' => sprintf(
                    '<div class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s /><label for="wp-comment-cookies-consent" class="checkbox-label">%s</label></div>',
                    empty($user_identity) ? '' : ' checked="checked"',
                    __('Save my name, email, and website in this browser for the next time I comment.', 'blitz')
                ),
            ],
            'class_container' => 'comment-form-container',
            'class_form' => 'comment-form',
            'comment_notes_before' => sprintf(
                '<p class="comment-notes">%s</p>',
                __('Your email address will not be published. Required fields are marked *', 'blitz')
            ),
            'comment_notes_after' => '',
        ];
    }

    /**
     * Get comment statistics.
     */
    public function commentStats(): array
    {
        $comments = get_comments(['post_id' => get_the_ID(), 'status' => 'approve']);
        
        return [
            'total' => count($comments),
            'authors' => count(array_unique(array_column($comments, 'comment_author'))),
            'avg_per_post' => count($comments) > 0 ? round(count($comments) / 1, 1) : 0,
        ];
    }

    /**
     * Get recent comments for sidebar or widget.
     */
    public function recentComments($limit = 5): array
    {
        $comments = get_comments([
            'number' => $limit,
            'status' => 'approve',
            'post_status' => 'publish',
        ]);

        return array_map(function($comment) {
            return [
                'id' => $comment->comment_ID,
                'author' => $comment->comment_author,
                'content' => wp_trim_words($comment->comment_content, 20),
                'date' => get_comment_date('', $comment),
                'post_title' => get_the_title($comment->comment_post_ID),
                'post_url' => get_permalink($comment->comment_post_ID),
                'comment_url' => get_comment_link($comment),
            ];
        }, $comments);
    }

    /**
     * Check if user can comment.
     */
    public function canComment(): bool
    {
        return comments_open() && (is_user_logged_in() || get_option('comment_registration') == 0);
    }
}