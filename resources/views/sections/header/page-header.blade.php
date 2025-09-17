{{-- resources/views/sections/page-header/page-header.blade.php --}}
@props([
    'title' => '',
    'subtitle' => '',
    'featured_image' => null,
    'show_breadcrumbs' => true,
    'show_meta' => false,
    'overlay_opacity' => 60
])

<section class="page-header-section relative overflow-hidden" 
         x-data="pageHeader()"
         x-init="init()">
    
    @if($featured_image)
        {{-- Hero Image Header --}}
        <div class="hero-container relative h-[50vh] lg:h-[60vh]">
            <div class="absolute inset-0 bg-gradient-to-t from-black/{{ $overlay_opacity }} via-black/20 to-transparent z-10"></div>
            <img src="{{ $featured_image }}" 
                 alt="{{ $title }}"
                 class="absolute inset-0 w-full h-full object-cover"
                 loading="eager">
            
            <div class="relative z-20 h-full flex items-center">
                <div class="container mx-auto px-4">
                    <div class="max-w-4xl text-white">
                        @if($show_breadcrumbs && function_exists('yoast_breadcrumb'))
                            {!! yoast_breadcrumb('<nav class="breadcrumbs text-white/80 text-sm mb-4">', '</nav>', false) !!}
                        @endif
                        
                        <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-4 animate-fade-in-up">
                            {!! $title !!}
                        </h1>
                        
                        @if($subtitle)
                            <div class="text-xl leading-relaxed text-white/90 max-w-2xl animate-fade-in-up animation-delay-200">
                                {!! $subtitle !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Standard Header --}}
        <div class="standard-header py-16 lg:py-24">
            <div class="container mx-auto px-4 text-center">
                <div class="max-w-4xl mx-auto">
                    @if($show_breadcrumbs && function_exists('yoast_breadcrumb'))
                        {!! yoast_breadcrumb('<nav class="breadcrumbs text-text-muted text-sm mb-6">', '</nav>', false) !!}
                    @endif
                    
                    <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6 gradient-text animate-fade-in-up">
                        {!! $title !!}
                    </h1>
                    
                    @if($subtitle)
                        <div class="text-xl leading-relaxed text-text-secondary max-w-2xl mx-auto animate-fade-in-up animation-delay-200">
                            {!! $subtitle !!}
                        </div>
                    @endif
                    
                    @if($show_meta && get_the_modified_time() !== get_the_time())
                        <div class="text-sm text-text-muted mt-6 animate-fade-in-up animation-delay-400">
                            {{ __('Last updated:', 'blitz') }} {{ get_the_modified_date() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    
    {{-- Reading Progress Bar --}}
    <div class="reading-progress-bar fixed top-0 left-0 w-full h-1 bg-bg-tertiary z-50">
        <div class="h-full bg-gradient-to-r from-primary to-accent transition-all duration-300"
             :style="{ width: readingProgress + '%' }"></div>
    </div>
</section>

<style>
.page-header-section .standard-header {
    background: 
        radial-gradient(circle at 30% 20%, rgba(74, 124, 40, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 70% 80%, rgba(249, 115, 22, 0.1) 0%, transparent 50%),
        linear-gradient(to bottom right, var(--bg-secondary), var(--bg-tertiary));
}

.gradient-text {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out forwards;
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-400 {
    animation-delay: 0.4s;
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('pageHeader', () => ({
        readingProgress: 0,
        
        init() {
            this.trackReadingProgress();
        },
        
        trackReadingProgress() {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const maxHeight = document.documentElement.scrollHeight - window.innerHeight;
                this.readingProgress = Math.min((scrolled / maxHeight) * 100, 100);
            }, { passive: true });
        }
    }));
});
</script>