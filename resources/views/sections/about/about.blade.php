{{-- Self-contained About Section - Blitz Theme --}}
@props([
    'layout' => 'split',         // split, centered, cards
    'showStats' => true,         // Show statistics
    'imagePosition' => 'right',  // left, right (for split layout)
])

<section class="about-section py-20 lg:py-32 bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($layout === 'split')
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                {{-- Content --}}
                <div class="{{ $imagePosition === 'right' ? 'lg:order-1' : 'lg:order-2' }}"
                     x-data="{ visible: false }"
                     x-intersect="visible = true">
                    
                    <span class="inline-block px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-semibold mb-4"
                          x-show="visible"
                          x-transition:enter="transition ease-out duration-700"
                          x-transition:enter-start="opacity-0 -translate-x-4"
                          x-transition:enter-end="opacity-100 translate-x-0">
                        {{ get_theme_mod('about_label', 'About Us') }}
                    </span>
                    
                    <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6"
                        x-show="visible"
                        x-transition:enter="transition ease-out duration-700 delay-100"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        {{ get_theme_mod('about_title', 'We Create Amazing Digital Experiences') }}
                    </h2>
                    
                    <div class="prose prose-lg text-gray-600 dark:text-gray-300 mb-8"
                         x-show="visible"
                         x-transition:enter="transition ease-out duration-700 delay-200">
                        {!! get_theme_mod('about_content', 'Lorem ipsum dolor sit amet...') !!}
                    </div>
                    
                    {{-- Features List --}}
                    <ul class="space-y-4 mb-8"
                        x-show="visible"
                        x-transition:enter="transition ease-out duration-700 delay-300">
                        @foreach(get_theme_mod('about_features', ['Innovation', 'Quality', 'Support']) as $feature)
                        <li class="flex items-center gap-3">
                            <span class="flex-shrink-0 w-6 h-6 bg-primary/20 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-gray-700 dark:text-gray-300">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                    
                    <a href="{{ get_theme_mod('about_cta_url', '/about') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors"
                       x-show="visible"
                       x-transition:enter="transition ease-out duration-700 delay-400">
                        {{ get_theme_mod('about_cta_text', 'Learn More') }}
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
                
                {{-- Image --}}
                <div class="{{ $imagePosition === 'right' ? 'lg:order-2' : 'lg:order-1' }}"
                     x-data="{ visible: false }"
                     x-intersect="visible = true">
                    <div class="relative"
                         x-show="visible"
                         x-transition:enter="transition ease-out duration-1000"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100">
                        
                        @if($image = get_theme_mod('about_image'))
                            <img src="{{ $image }}" alt="About us" class="rounded-2xl shadow-2xl w-full">
                        @else
                            <div class="aspect-video bg-gradient-to-br from-primary to-primary-dark rounded-2xl"></div>
                        @endif
                        
                        {{-- Decorative Elements --}}
                        <div class="absolute -top-4 -right-4 w-32 h-32 bg-accent/20 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-4 -left-4 w-40 h-40 bg-primary/20 rounded-full blur-3xl"></div>
                    </div>
                </div>
            </div>
        @endif
        
        {{-- Statistics --}}
        @if($showStats)
        <div class="mt-20 grid grid-cols-2 lg:grid-cols-4 gap-8"
             x-data="{ visible: false }"
             x-intersect="visible = true">
            @foreach(get_theme_mod('about_stats', [
                ['number' => '100+', 'label' => 'Projects'],
                ['number' => '50+', 'label' => 'Clients'],
                ['number' => '10+', 'label' => 'Years'],
                ['number' => '24/7', 'label' => 'Support'],
            ]) as $index => $stat)
            <div class="text-center"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-700 delay-{{ $index * 100 }}">
                <div class="text-4xl lg:text-5xl font-bold text-primary mb-2">{{ $stat['number'] }}</div>
                <div class="text-gray-600 dark:text-gray-400">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

<style>
/* About Section Styles */
.about-section {
    position: relative;
    overflow: hidden;
}

.about-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: -50%;
    width: 200%;
    height: 100%;
    background: radial-gradient(circle, rgba(var(--primary-rgb, 74, 124, 40), 0.05) 0%, transparent 70%);
    pointer-events: none;
}
</style>