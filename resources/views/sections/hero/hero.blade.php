{{-- Self-contained Hero Section - Blitz Theme --}}
@props([
    'variant' => 'gradient',     // gradient, video, parallax, split, minimal
    'height' => 'full',          // full, large, medium, auto
    'overlay' => true,           // Dark overlay for better text visibility
    'animated' => true,          // Enable animations
])

<section class="hero-section relative overflow-hidden {{ $height === 'full' ? 'min-h-screen' : ($height === 'large' ? 'min-h-[80vh]' : 'min-h-[60vh]') }}"
         x-data="heroComponent()"
         x-init="init()">
    
    {{-- Background Layer --}}
    <div class="absolute inset-0">
        @if($variant === 'gradient')
            <div class="absolute inset-0 bg-gradient-to-br from-primary via-primary-dark to-primary-soft"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
        @elseif($variant === 'video')
            <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
                <source src="{{ get_theme_mod('hero_video_url', '') }}" type="video/mp4">
            </video>
        @else
            @if($bg_image = get_theme_mod('hero_background_image'))
                <img src="{{ $bg_image }}" alt="" class="absolute inset-0 w-full h-full object-cover">
            @endif
        @endif
        
        @if($overlay)
            <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/30 to-black/50"></div>
        @endif
    </div>
    
    {{-- Animated Particles --}}
    @if($animated)
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
    </div>
    @endif
    
    {{-- Content --}}
    <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
        <div class="max-w-4xl mx-auto text-center text-white">
            {{-- Subtitle --}}
            @if($subtitle = get_theme_mod('hero_subtitle'))
                <div class="mb-4 inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full"
                     x-show="visible"
                     x-transition:enter="transition ease-out duration-1000 delay-100"
                     x-transition:enter-start="opacity-0 -translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <span class="w-2 h-2 bg-accent rounded-full animate-pulse"></span>
                    <span class="text-sm font-medium">{{ $subtitle }}</span>
                </div>
            @endif
            
            {{-- Title --}}
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold mb-6"
                x-show="visible"
                x-transition:enter="transition ease-out duration-1000 delay-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0">
                {{ get_theme_mod('hero_title', get_bloginfo('name')) }}
            </h1>
            
            {{-- Description --}}
            <p class="text-xl sm:text-2xl text-white/90 mb-8 max-w-2xl mx-auto"
               x-show="visible"
               x-transition:enter="transition ease-out duration-1000 delay-500"
               x-transition:enter-start="opacity-0 translate-y-4"
               x-transition:enter-end="opacity-100 translate-y-0">
                {{ get_theme_mod('hero_description', get_bloginfo('description')) }}
            </p>
            
            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1000 delay-700"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                @if($primary_cta = get_theme_mod('hero_primary_cta_text'))
                    <a href="{{ get_theme_mod('hero_primary_cta_url', '#') }}" 
                       class="btn-hero-primary">
                        {{ $primary_cta }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                @endif
                
                @if($secondary_cta = get_theme_mod('hero_secondary_cta_text'))
                    <a href="{{ get_theme_mod('hero_secondary_cta_url', '#') }}" 
                       class="btn-hero-secondary">
                        {{ $secondary_cta }}
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Scroll Indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/60 animate-bounce">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

<style>
/* Hero Styles */
.hero-section {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Buttons */
.btn-hero-primary {
    display: inline-flex;
    align-items: center;
    padding: 1rem 2rem;
    background: white;
    color: var(--primary);
    font-weight: 600;
    border-radius: 9999px;
    transition: all 0.3s ease;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.btn-hero-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
}

.btn-hero-secondary {
    display: inline-flex;
    align-items: center;
    padding: 1rem 2rem;
    background: transparent;
    color: white;
    font-weight: 600;
    border: 2px solid white;
    border-radius: 9999px;
    transition: all 0.3s ease;
}

.btn-hero-secondary:hover {
    background: white;
    color: var(--primary);
}

/* Particles */
.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: white;
    border-radius: 50%;
    opacity: 0.3;
}

.particle-1 {
    top: 20%;
    left: 10%;
    animation: float-particle 20s infinite;
}

.particle-2 {
    top: 60%;
    right: 20%;
    animation: float-particle 25s infinite reverse;
}

.particle-3 {
    bottom: 20%;
    left: 30%;
    animation: float-particle 30s infinite;
}

@keyframes float-particle {
    0%, 100% { transform: translate(0, 0); }
    25% { transform: translate(100px, -100px); }
    50% { transform: translate(-100px, 100px); }
    75% { transform: translate(-50px, -50px); }
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('heroComponent', () => ({
        visible: false,
        
        init() {
            this.visible = true;
        }
    }));
});
</script>