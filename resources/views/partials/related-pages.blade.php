{{-- resources/views/partials/related-pages.blade.php --}}
@php
    $page_id = get_the_ID();
    $children = get_children([
        'post_parent' => $page_id,
        'post_type' => 'page',
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ]);
    
    $parent = wp_get_post_parent_id($page_id);
    $siblings = $parent ? get_children([
        'post_parent' => $parent,
        'post_type' => 'page',
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ]) : [];
@endphp

@if($children || ($parent && count($siblings) > 1))
<section class="related-pages-section py-16 bg-bg-tertiary" 
         x-data="{ animated: false }"
         x-intersect="animated = true">
    
    <div class="container mx-auto px-4">
        {{-- Child Pages --}}
        @if($children)
            <div class="child-pages mb-12">
                <h2 class="text-2xl font-bold mb-6 text-center">{{ __('Explore More', 'blitz') }}</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($children as $index => $child)
                        <a href="{{ get_permalink($child) }}" 
                           class="page-card glass-card p-6 hover:shadow-xl transition-all duration-300 group"
                           :class="{ 'animate-slide-up': animated }"
                           style="animation-delay: {{ $index * 0.1 }}s">
                            
                            @if(has_post_thumbnail($child))
                                <div class="aspect-video mb-4 overflow-hidden rounded-lg">
                                    {!! get_the_post_thumbnail($child, 'medium', [
                                        'class' => 'w-full h-full object-cover transition-transform duration-300 group-hover:scale-105',
                                        'loading' => 'lazy'
                                    ]) !!}
                                </div>
                            @endif
                            
                            <h3 class="text-xl font-bold mb-2 group-hover:text-primary transition-colors">
                                {{ get_the_title($child) }}
                            </h3>
                            
                            @if(has_excerpt($child))
                                <p class="text-text-secondary text-sm line-clamp-3 mb-4">
                                    {{ get_the_excerpt($child) }}
                                </p>
                            @endif
                            
                            <div class="flex items-center gap-2 text-primary font-medium">
                                {{ __('Learn More', 'blitz') }}
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        
        {{-- Sibling Pages --}}
        @if($parent && count($siblings) > 1)
            <div class="sibling-pages">
                <h3 class="text-lg font-semibold mb-4 text-center">{{ __('Related Pages', 'blitz') }}</h3>
                <div class="flex flex-wrap justify-center gap-3">
                    @foreach($siblings as $sibling)
                        @if($sibling->ID !== $page_id)
                            <a href="{{ get_permalink($sibling) }}" 
                               class="px-4 py-2 bg-bg-secondary text-text-secondary rounded-full 
                                      hover:bg-primary hover:text-white transition-all duration-200">
                                {{ get_the_title($sibling) }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<style>
@keyframes slide-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slide-up {
    animation: slide-up 0.6s ease-out forwards;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endif