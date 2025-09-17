<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Post extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.page-header',
        'partials.content',
        'partials.content-*',
    ];

    public function with()
    {
        return [
            'title' => $this->title(),
            'excerpt' => $this->excerpt(),
            'permalink' => $this->permalink(),
            'featuredImage' => $this->featuredImage(),
            'postMeta' => $this->postMeta(),
            'relatedPosts' => $this->relatedPosts(),
            'postNavigation' => $this->postNavigation(),
            'socialShare' => $this->socialShare(),
        ];
    }

    /**
     * Retrieve the post title.
     */
    public function title(): string
    {
        if ($this->view->name() !== 'partials.page-header') {
            return get_the_title();
        }

        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'blitz');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(
                /* translators: %s is replaced with the search query */
                __('Search Results for "%s"', 'blitz'),
                get_search_query()
            );
        }

        if (is_404()) {
            return __('Page Not Found', 'blitz');
        }

        return get_the_title();
    }

    /**
     * Retrieve the post excerpt.
     */
    public function excerpt(): string
    {
        if (has_excerpt()) {
            return get_the_excerpt();
        }
        
        return wp_trim_words(get_the_content(), 30, '...');
    }

    /**
     * Retrieve the post permalink.
     */
    public function permalink(): string
    {
        return get_the_permalink();
    }

    /**
     * Retrieve the post date.
     */
    public function date(): string
    {
        return get_the_date();
    }

    /**
     * Retrieve the post author.
     */
    public function author(): array
    {
        return [
            'name' => get_the_author(),
            'url' => get_author_posts_url(get_the_author_meta('ID')),
            'avatar' => get_avatar_url(get_the_author_meta('ID')),
        ];
    }

    /**
     * Retrieve the post categories.
     */
    public function categories(): array
    {
        $categories = get_the_category();
        
        return array_map(function($category) {
            return [
                'name' => $category->name,
                'url' => get_category_link($category->term_id),
                'slug' => $category->slug,
            ];
        }, $categories);
    }

    /**
     * Retrieve the post tags.
     */
    public function tags(): array
    {
        $tags = get_the_tags();
        
        if (!$tags) {
            return [];
        }
        
        return array_map(function($tag) {
            return [
                'name' => $tag->name,
                'url' => get_tag_link($tag->term_id),
                'slug' => $tag->slug,
            ];
        }, $tags);
    }

    /**
     * Retrieve the featured image.
     */
    public function featuredImage(): array
    {
        if (!has_post_thumbnail()) {
            return [];
        }
        
        $image_id = get_post_thumbnail_id();
        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        
        return [
            'url' => get_the_post_thumbnail_url(null, 'large'),
            'alt' => $image_alt ?: get_the_title(),
            'caption' => wp_get_attachment_caption($image_id),
        ];
    }

    /**
     * Retrieve the reading time.
     */
    public function readingTime(): int
    {
        $content = get_the_content();
        $word_count = str_word_count(strip_tags($content));
        $reading_time = ceil($word_count / 200); // 200 words per minute
        
        return max(1, $reading_time);
    }

    /**
     * Retrieve related posts.
     */
    public function relatedPosts(): array
    {
        if (!is_single()) {
            return [];
        }
        
        $categories = wp_get_post_categories(get_the_ID());
        $tags = wp_get_post_tags(get_the_ID());
        
        $args = [
            'post__not_in' => [get_the_ID()],
            'posts_per_page' => 3,
            'orderby' => 'rand',
        ];
        
        // First try to get posts by tags
        if (!empty($tags)) {
            $tag_ids = wp_list_pluck($tags, 'term_id');
            $args['tag__in'] = $tag_ids;
            $related_posts = get_posts($args);
        }
        
        // If no posts found by tags, try categories
        if (empty($related_posts) && !empty($categories)) {
            unset($args['tag__in']);
            $args['category__in'] = $categories;
            $related_posts = get_posts($args);
        }
        
        // If still no posts, get recent posts
        if (empty($related_posts)) {
            unset($args['category__in']);
            $args['orderby'] = 'date';
            $related_posts = get_posts($args);
        }
        
        return array_map(function($post) {
            return [
                'title' => get_the_title($post),
                'url' => get_permalink($post),
                'excerpt' => wp_trim_words(get_the_excerpt($post), 20),
                'image' => get_the_post_thumbnail_url($post, 'card'),
                'date' => get_the_date('', $post),
            ];
        }, $related_posts);
    }

    /**
     * Retrieve the pagination links.
     */
    public function pagination(): string
    {
        return wp_link_pages([
            'echo' => 0,
            'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'blitz') . '</span>',
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>',
            'pagelink' => '<span class="screen-reader-text">' . __('Page', 'blitz') . ' </span>%',
            'separator' => '<span class="screen-reader-text">, </span>',
        ]);
    }

    /**
     * Check if post has content.
     */
    public function hasContent(): bool
    {
        return !empty(get_the_content());
    }

    /**
     * Get post navigation.
     */
    public function postNavigation(): array
    {
        if (!is_single()) {
            return [];
        }
        
        $prev_post = get_previous_post();
        $next_post = get_next_post();
        
        $navigation = [];
        
        if ($prev_post) {
            $navigation['previous'] = [
                'title' => get_the_title($prev_post),
                'url' => get_permalink($prev_post),
                'excerpt' => wp_trim_words(get_the_excerpt($prev_post), 15),
            ];
        }
        
        if ($next_post) {
            $navigation['next'] = [
                'title' => get_the_title($next_post),
                'url' => get_permalink($next_post),
                'excerpt' => wp_trim_words(get_the_excerpt($next_post), 15),
            ];
        }
        
        return $navigation;
    }

    /**
     * Get social share links.
     */
    public function socialShare(): array
    {
        $url = urlencode(get_permalink());
        $title = urlencode(get_the_title());
        
        return [
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$url}",
            'twitter' => "https://twitter.com/intent/tweet?url={$url}&text={$title}",
            'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$url}",
            'whatsapp' => "https://wa.me/?text={$title}%20{$url}",
            'email' => "mailto:?subject={$title}&body={$url}",
        ];
    }

    /**
     * Get post meta information.
     */
    public function postMeta(): array
    {
        return [
            'date' => $this->date(),
            'author' => $this->author(),
            'categories' => $this->categories(),
            'tags' => $this->tags(),
            'reading_time' => $this->readingTime(),
            'comments_count' => get_comments_number(),
            'comments_open' => comments_open(),
        ];
    }
}