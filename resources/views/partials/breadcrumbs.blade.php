{{-- resources/views/partials/breadcrumbs.blade.php --}}
<nav class="breadcrumbs text-text-muted text-sm mb-6" aria-label="Breadcrumb">
    <ol class="flex items-center justify-center space-x-2">
        <li>
            <a href="{{ home_url() }}" class="hover:text-primary transition-colors">
                {{ __('Home', 'blitz') }}
            </a>
        </li>
        
        @if(is_page() && $ancestors = get_post_ancestors(get_the_ID()))
            @foreach(array_reverse($ancestors) as $ancestor)
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <a href="{{ get_permalink($ancestor) }}" class="hover:text-primary transition-colors">
                        {{ get_the_title($ancestor) }}
                    </a>
                </li>
            @endforeach
        @endif
        
        <li class="flex items-center text-text-primary">
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span>{{ get_the_title() }}</span>
        </li>
    </ol>
</nav>