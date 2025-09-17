{{--
  Versatile Card Component
  Multi-purpose card with header, body, footer, and various styles
--}}

@props([
    'variant' => 'default',                 // default, glass, gradient, hover, minimal, bordered
    'padding' => 'md',                      // none, sm, md, lg, xl
    'rounded' => 'lg',                      // sm, md, lg, xl, full
    'shadow' => 'md',                       // none, sm, md, lg, xl, inner
    'interactive' => false,                 // Add hover effects and cursor pointer
    'href' => null,                         // Make entire card clickable
    'target' => null,                       // Link target
    'animated' => true,                     // Entrance animations
    'image' => null,                        // Header image URL
    'imageAlt' => '',                       // Image alt text
    'imageAspect' => 'video',               // square, video, wide, tall
    'title' => '',                          // Card title
    'subtitle' => '',                       // Card subtitle
    'badge' => null,                        // Badge text/HTML
    'badgeColor' => 'primary',              // Badge color scheme
    'footer' => null,                       // Footer content
    'overlay' => false,                     // Text overlay on image
])

@php
    // Variant configurations
    $variants = [
        'default' => 'bg-card-bg border border-border-color',
        'glass' => 'bg-glass-bg backdrop-blur-xl border border-border-color/50',
        'gradient' => 'bg-gradient-to-br from-primary/5 to-primary-soft/10 border border-primary/20',
        'hover' => 'bg-card-bg border border-border-color hover:border-primary/30 hover:shadow-xl',
        'minimal' => 'bg-transparent',
        'bordered' => 'bg-card-bg border-2 border-primary/20',
    ];

    // Padding configurations
    $paddings = [
        'none' => '',
        'sm' => 'p-3',
        'md' => 'p-4 sm:p-6',
        'lg' => 'p-6 sm:p-8',
        'xl' => 'p-8 sm:p-10',
    ];

    // Shadow configurations
    $shadows = [
        'none' => '',
        'sm' => 'shadow-sm',
        'md' => 'shadow-md',
        'lg' => 'shadow-lg',
        'xl' => 'shadow-xl',
        'inner' => 'shadow-inner',
    ];

    // Rounded configurations
    $roundedClasses = [
        'sm' => 'rounded-md',
        'md' => 'rounded-lg',
        'lg' => 'rounded-xl',
        'xl' => 'rounded-2xl',
        'full' => 'rounded-3xl',
    ];

    // Image aspect ratios
    $aspectRatios = [
        'square' => 'aspect-square',
        'video' => 'aspect-video',
        'wide' => 'aspect-[21/9]',
        'tall' => 'aspect-[3/4]',
    ];

    // Badge colors
    $badgeColors = [
        'primary' => 'bg-primary text-white',
        'secondary' => 'bg-bg-tertiary text-text-primary',
        'success' => 'bg-green-500 text-white',
        'warning' => 'bg-yellow-500 text-white',
        'error' => 'bg-red-500 text-white',
        'info' => 'bg-blue-500 text-white',
    ];

    // Build classes
    $cardClasses = collect([
        'card-component',
        'relative overflow-hidden',
        $variants[$variant] ?? $variants['default'],
        $roundedClasses[$rounded] ?? $roundedClasses['lg'],
        $shadows[$shadow] ?? $shadows['md'],
        $interactive || $href ? 'transition-all duration-300 cursor-pointer group' : 'transition-colors duration-200',
        $animated ? 'transform hover:scale-105' : '',
        $variant === 'hover' ? 'hover:shadow-2xl hover:-translate-y-1' : '',
    ])->filter()->implode(' ');

    $contentClasses = $paddings[$padding] ?? $paddings['md'];
@endphp

@if($href)
    <a href="{{ $href }}" 
       @if($target) target="{{ $target }}" @endif
       {{ $attributes->merge(['class' => $cardClasses]) }}
       @if($target === '_blank') rel="noopener noreferrer" @endif>
        TEST
    </a>
@else
    <div {{ $attributes->merge(['class' => $cardClasses]) }}
         @if($animated) 
         x-data="{ isVisible: false }" 
         x-intersect="isVisible = true"
         :class="{ 'opacity-100 transform translate-y-0': isVisible, 'opacity-0 transform translate-y-4': !isVisible }"
         @endif>
        TEST
    </div>
@endif

{{-- Card Content (would typically be in separate partial) --}}
@php $cardContent = true; @endphp

{{-- Badge (floating) --}}
@if($badge)
    <div class="absolute top-3 right-3 z-10">
        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full {{ $badgeColors[$badgeColor] ?? $badgeColors['primary'] }}">
            {!! $badge !!}
        </span>
    </div>
@endif

{{-- Header Image --}}
@if($image)
    <div class="relative {{ $overlay ? '' : 'mb-4' }}">
        <div class="{{ $aspectRatios[$imageAspect] ?? $aspectRatios['video'] }} overflow-hidden {{ $overlay ? '' : $roundedClasses[$rounded] ?? 'rounded-xl' }}">
            <img src="{{ $image }}" 
                 alt="{{ $imageAlt }}" 
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                 loading="lazy">
        </div>
        
        @if($overlay)
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
        @endif
    </div>
@endif

{{-- Content --}}
<div class="{{ $overlay ? 'absolute inset-0 flex flex-col justify-end text-white' : '' }} {{ $contentClasses }}">
    {{-- Title & Subtitle --}}
    @if($title || $subtitle)
        <div class="mb-4">
            @if($title)
                <h3 class="text-lg font-semibold {{ $overlay ? 'text-white' : 'text-text-primary' }} mb-1 group-hover:text-primary transition-colors duration-200">
                    {{ $title }}
                </h3>
            @endif
            
            @if($subtitle)
                <p class="text-sm {{ $overlay ? 'text-white/80' : 'text-text-muted' }}">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    @endif

    {{-- Main Content --}}
    @if($slot->isNotEmpty())
        <div class="{{ $overlay ? 'text-white/90' : 'text-text-secondary' }}">
            {{ $slot }}
        </div>
    @endif
</div>

{{-- Footer --}}
@if($footer)
    <div class="border-t border-border-color {{ $overlay ? 'absolute bottom-0 left-0 right-0' : '' }} {{ $contentClasses }} pt-4 mt-4">
        {!! $footer !!}
    </div>
@endif

<style>
    /* Card hover effects */
    .card-component.group:hover {
        transform: translateY(-2px);
    }

    /* Glass effect enhancement */
    .bg-glass-bg {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    [data-theme="dark"] .bg-glass-bg {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Gradient animation */
    .bg-gradient-to-br.from-primary\/5.to-primary-soft\/10 {
        background-size: 200% 200%;
        animation: gradient-shift 8s ease-in-out infinite;
    }

    @keyframes gradient-shift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    /* Loading skeleton state */
    .card-skeleton {
        background: linear-gradient(90deg, var(--bg-tertiary) 25%, var(--bg-secondary) 50%, var(--bg-tertiary) 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .card-component {
            margin-bottom: 1rem;
        }
        
        .card-component.transform.hover\\:scale-105:hover {
            transform: none;
        }
    }
</style>