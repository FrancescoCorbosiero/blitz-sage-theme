{{-- resources/views/partials/page-header.blade.php --}}
@props([
    'title' => '',
    'subtitle' => '',
    'featured_image' => null,
    'show_breadcrumbs' => true,
    'show_meta' => false,
    'overlay_opacity' => 60
])

<section class="page-header-section relative overflow-hidden" 
         x-data="pageHeaderPremium()"
         x-init="init()">
    
    {{-- Animated Background Particles --}}
    <div class="particle-container absolute inset-0 pointer-events-none">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
        <div class="particle particle-4"></div>
        <div class="particle particle-5"></div>
    </div>
    
    @if($featured_image)
        {{-- Premium Hero Image Header --}}
        <div class="hero-container relative h-[70vh] lg:h-[85vh]">
            {{-- Multi-layer Parallax --}}
            <div class="parallax-container absolute inset-0">
                <div class="parallax-layer layer-bg absolute inset-0" data-speed="0.5">
                    <img src="{{ $featured_image }}" 
                         alt="{{ $title }}"
                         class="w-full h-full object-cover scale-110"
                         loading="eager">
                </div>
                <div class="parallax-layer layer-overlay absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent" data-speed="0.3"></div>
                <div class="parallax-layer layer-particles absolute inset-0" data-speed="0.8">
                    <canvas class="particle-canvas w-full h-full"></canvas>
                </div>
            </div>
            
            {{-- Premium Content --}}
            <div class="relative z-20 h-full flex items-center">
                <div class="container mx-auto px-4">
                    <div class="max-w-5xl">
                        @if($show_breadcrumbs)
                            <nav class="breadcrumbs-premium mb-8" x-ref="breadcrumbs">
                                @include('partials.breadcrumbs')
                            </nav>
                        @endif
                        
                        {{-- Glitch Effect Title --}}
                        <h1 class="page-title-premium text-5xl md:text-7xl lg:text-8xl font-bold leading-none mb-6"
                            data-text="{!! strip_tags($title) !!}">
                            <span class="title-main">{!! $title !!}</span>
                            <span class="title-glitch glitch-1" aria-hidden="true">{!! $title !!}</span>
                            <span class="title-glitch glitch-2" aria-hidden="true">{!! $title !!}</span>
                        </h1>
                        
                        @if($subtitle)
                            <div class="subtitle-premium text-xl md:text-2xl lg:text-3xl leading-relaxed text-white/90 max-w-3xl">
                                <span class="subtitle-text" x-ref="subtitle">{!! $subtitle !!}</span>
                                <span class="subtitle-cursor"></span>
                            </div>
                        @endif
                        
                        {{-- Scroll Indicator --}}
                        <div class="scroll-indicator absolute bottom-8 left-1/2 transform -translate-x-1/2">
                            <div class="mouse-icon">
                                <div class="wheel"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Premium Standard Header --}}
        <div class="standard-header-premium relative py-24 lg:py-32">
            {{-- Animated Mesh Gradient Background --}}
            <div class="mesh-gradient absolute inset-0">
                <div class="gradient-orb orb-1"></div>
                <div class="gradient-orb orb-2"></div>
                <div class="gradient-orb orb-3"></div>
            </div>
            
            {{-- Noise Texture Overlay --}}
            <div class="noise-overlay absolute inset-0 opacity-[0.03]"></div>
            
            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-5xl mx-auto text-center">
                    @if($show_breadcrumbs)
                        @include('partials.breadcrumbs')
                    @endif
                    
                    {{-- 3D Rotating Title --}}
                    <div class="title-3d-container perspective-1000 mb-8">
                        <h1 class="title-3d text-5xl md:text-7xl lg:text-8xl font-bold leading-none"
                            x-ref="title3d">
                            <span class="title-word" x-text="titleWords[0]"></span>
                            <span class="title-word" x-text="titleWords[1]"></span>
                            <span class="title-word" x-text="titleWords[2]"></span>
                        </h1>
                    </div>
                    
                    @if($subtitle)
                        {{-- Animated Subtitle with Wave Effect --}}
                        <div class="subtitle-wave text-xl md:text-2xl leading-relaxed text-text-secondary max-w-3xl mx-auto">
                            @foreach(str_split($subtitle) as $index => $char)
                                <span class="wave-char" style="animation-delay: {{ $index * 0.02 }}s">{{ $char === ' ' ? '&nbsp;' : $char }}</span>
                            @endforeach
                        </div>
                    @endif
                    
                    @if($show_meta)
                        <div class="meta-premium mt-8 flex items-center justify-center gap-8">
                            <div class="meta-item">
                                <span class="meta-label text-text-muted text-sm">{{ __('Published', 'blitz') }}</span>
                                <span class="meta-value text-text-primary font-semibold">{{ get_the_date() }}</span>
                            </div>
                            @if(get_the_modified_time() !== get_the_time())
                                <div class="meta-divider w-px h-8 bg-border-color"></div>
                                <div class="meta-item">
                                    <span class="meta-label text-text-muted text-sm">{{ __('Updated', 'blitz') }}</span>
                                    <span class="meta-value text-text-primary font-semibold">{{ get_the_modified_date() }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            
            {{-- Lightning Bolts Animation --}}
            <svg class="lightning-bolts absolute inset-0 w-full h-full pointer-events-none" viewBox="0 0 1920 500">
                <path class="bolt bolt-1" d="M0,0 L200,250 L150,250 L300,500" stroke="url(#lightning-gradient)" stroke-width="2" fill="none"/>
                <path class="bolt bolt-2" d="M1920,0 L1720,250 L1770,250 L1620,500" stroke="url(#lightning-gradient)" stroke-width="2" fill="none"/>
                <defs>
                    <linearGradient id="lightning-gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:var(--accent);stop-opacity:0.8"/>
                        <stop offset="100%" style="stop-color:var(--primary);stop-opacity:0.2"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
    @endif
    
    {{-- Premium Reading Progress Bar with Glow --}}
    <div class="reading-progress-premium fixed top-0 left-0 w-full h-1 z-50">
        <div class="progress-track bg-bg-tertiary/50 backdrop-blur-sm h-full">
            <div class="progress-bar relative h-full bg-gradient-to-r from-primary via-accent to-primary-soft transition-all duration-300"
                 :style="{ width: readingProgress + '%' }">
                <div class="progress-glow absolute inset-0 blur-md"></div>
                <div class="progress-particle absolute right-0 top-1/2 transform -translate-y-1/2"></div>
            </div>
        </div>
    </div>
</section>

<style>
/* Premium Header Styles */
.page-header-section {
    position: relative;
    background: var(--bg-primary);
}

/* Particle Effects */
.particle {
    position: absolute;
    background: radial-gradient(circle, var(--accent) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
    animation: float-particle 20s infinite ease-in-out;
}

.particle-1 {
    width: 80px;
    height: 80px;
    top: 10%;
    left: 10%;
    animation-delay: 0s;
    opacity: 0.3;
}

.particle-2 {
    width: 60px;
    height: 60px;
    top: 70%;
    left: 80%;
    animation-delay: 2s;
    opacity: 0.4;
}

.particle-3 {
    width: 120px;
    height: 120px;
    top: 40%;
    left: 40%;
    animation-delay: 4s;
    opacity: 0.2;
}

.particle-4 {
    width: 40px;
    height: 40px;
    top: 80%;
    left: 20%;
    animation-delay: 6s;
    opacity: 0.5;
}

.particle-5 {
    width: 100px;
    height: 100px;
    top: 20%;
    right: 15%;
    animation-delay: 8s;
    opacity: 0.25;
}

@keyframes float-particle {
    0%, 100% {
        transform: translate(0, 0) rotate(0deg) scale(1);
    }
    25% {
        transform: translate(100px, -100px) rotate(90deg) scale(1.1);
    }
    50% {
        transform: translate(-50px, 100px) rotate(180deg) scale(0.9);
    }
    75% {
        transform: translate(-100px, -50px) rotate(270deg) scale(1.05);
    }
}

/* Glitch Effect for Title */
.page-title-premium {
    position: relative;
    color: white;
    text-shadow: 
        0 0 10px rgba(255, 255, 255, 0.5),
        0 0 20px rgba(255, 255, 255, 0.3),
        0 0 30px rgba(255, 255, 255, 0.2);
}

.title-glitch {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0.8;
}

.glitch-1 {
    color: var(--accent);
    animation: glitch-1 0.3s infinite linear alternate-reverse;
}

.glitch-2 {
    color: var(--primary);
    animation: glitch-2 0.3s infinite linear alternate-reverse;
}

@keyframes glitch-1 {
    0% {
        clip-path: polygon(0 0, 100% 0, 100% 35%, 0 35%);
        transform: translate(-2px, -2px);
    }
    25% {
        clip-path: polygon(0 35%, 100% 35%, 100% 55%, 0 55%);
        transform: translate(2px, 0);
    }
    50% {
        clip-path: polygon(0 55%, 100% 55%, 100% 75%, 0 75%);
        transform: translate(-2px, 2px);
    }
    75% {
        clip-path: polygon(0 75%, 100% 75%, 100% 100%, 0 100%);
        transform: translate(0, -2px);
    }
    100% {
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        transform: translate(2px, 2px);
    }
}

@keyframes glitch-2 {
    0% {
        clip-path: polygon(0 25%, 100% 25%, 100% 45%, 0 45%);
        transform: translate(2px, 2px);
    }
    50% {
        clip-path: polygon(0 65%, 100% 65%, 100% 85%, 0 85%);
        transform: translate(-2px, -2px);
    }
    100% {
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        transform: translate(0, 0);
    }
}

/* Animated Mesh Gradient */
.mesh-gradient {
    background: 
        radial-gradient(at 20% 30%, var(--primary) 0%, transparent 50%),
        radial-gradient(at 80% 70%, var(--accent) 0%, transparent 50%),
        radial-gradient(at 40% 60%, var(--primary-soft) 0%, transparent 50%);
    filter: blur(40px);
    opacity: 0.4;
}

.gradient-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    mix-blend-mode: screen;
    animation: float-orb 15s infinite ease-in-out;
}

.orb-1 {
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
    top: -200px;
    left: -200px;
    animation-delay: 0s;
}

.orb-2 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, var(--accent) 0%, transparent 70%);
    bottom: -100px;
    right: -100px;
    animation-delay: 5s;
}

.orb-3 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, var(--primary-soft) 0%, transparent 70%);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation-delay: 10s;
}

@keyframes float-orb {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(50px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-50px, 50px) scale(0.9);
    }
}

/* 3D Title Effect */
.perspective-1000 {
    perspective: 1000px;
}

.title-3d {
    transform-style: preserve-3d;
    animation: rotate-3d 10s infinite linear;
    background: linear-gradient(
        135deg,
        var(--primary) 0%,
        var(--accent) 25%,
        var(--primary-soft) 50%,
        var(--primary) 75%,
        var(--accent) 100%
    );
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradient-shift 3s ease infinite;
}

@keyframes rotate-3d {
    0% {
        transform: rotateY(0deg) rotateX(0deg);
    }
    25% {
        transform: rotateY(10deg) rotateX(5deg);
    }
    50% {
        transform: rotateY(0deg) rotateX(0deg);
    }
    75% {
        transform: rotateY(-10deg) rotateX(-5deg);
    }
    100% {
        transform: rotateY(0deg) rotateX(0deg);
    }
}

@keyframes gradient-shift {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}

/* Wave Animation for Subtitle */
.wave-char {
    display: inline-block;
    animation: wave-motion 2s ease-in-out infinite;
}

@keyframes wave-motion {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-5px);
    }
}

/* Lightning Bolts */
.bolt {
    stroke-dasharray: 1000;
    stroke-dashoffset: 1000;
    animation: lightning-strike 3s infinite;
    filter: drop-shadow(0 0 10px var(--accent));
}

.bolt-1 {
    animation-delay: 0s;
}

.bolt-2 {
    animation-delay: 1.5s;
}

@keyframes lightning-strike {
    0%, 95% {
        stroke-dashoffset: 1000;
        opacity: 0;
    }
    95.1% {
        opacity: 1;
    }
    100% {
        stroke-dashoffset: 0;
        opacity: 1;
    }
}

/* Scroll Indicator */
.mouse-icon {
    width: 30px;
    height: 50px;
    border: 2px solid rgba(255, 255, 255, 0.6);
    border-radius: 25px;
    position: relative;
    animation: bounce 2s infinite;
}

.wheel {
    width: 4px;
    height: 10px;
    background: white;
    border-radius: 2px;
    position: absolute;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    animation: scroll-wheel 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

@keyframes scroll-wheel {
    0% {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    100% {
        opacity: 0;
        transform: translateX(-50%) translateY(15px);
    }
}

/* Reading Progress Bar Premium */
.progress-bar {
    position: relative;
    overflow: hidden;
}

.progress-bar::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.4),
        transparent
    );
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% {
        left: -100%;
    }
    100% {
        left: 200%;
    }
}

.progress-glow {
    background: inherit;
    filter: blur(8px);
    opacity: 0.6;
}

.progress-particle {
    width: 20px;
    height: 20px;
    background: radial-gradient(circle, white 0%, transparent 70%);
    border-radius: 50%;
    animation: pulse-particle 1s infinite;
}

@keyframes pulse-particle {
    0%, 100% {
        transform: scale(1) translateY(-50%);
        opacity: 1;
    }
    50% {
        transform: scale(1.5) translateY(-50%);
        opacity: 0.5;
    }
}

/* Noise Texture */
.noise-overlay {
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
}

/* Parallax Scrolling */
.parallax-layer {
    will-change: transform;
    transition: transform 0.1s linear;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .page-title-premium {
        font-size: 3rem;
    }
    
    .gradient-orb {
        filter: blur(80px);
    }
    
    .orb-1 { width: 300px; height: 300px; }
    .orb-2 { width: 200px; height: 200px; }
    .orb-3 { width: 250px; height: 250px; }
}

/* Dark Mode Enhancements */
[data-theme="dark"] .mesh-gradient {
    opacity: 0.2;
}

[data-theme="dark"] .gradient-orb {
    mix-blend-mode: plus-lighter;
}

[data-theme="dark"] .noise-overlay {
    opacity: 0.05;
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('pageHeaderPremium', () => ({
        readingProgress: 0,
        titleWords: [],
        
        init() {
            this.initializeAnimations();
            this.trackReadingProgress();
            this.setupParallax();
            this.initializeCanvas();
            this.splitTitle();
        },
        
        initializeAnimations() {
            // GSAP-like animations with Alpine
            this.$nextTick(() => {
                // Animate breadcrumbs
                if (this.$refs.breadcrumbs) {
                    this.animateElement(this.$refs.breadcrumbs, 'fadeInDown', 0);
                }
                
                // Typewriter effect for subtitle
                if (this.$refs.subtitle) {
                    this.typewriterEffect(this.$refs.subtitle);
                }
                
                // 3D title animation
                if (this.$refs.title3d) {
                    this.animate3DTitle();
                }
            });
        },
        
        splitTitle() {
            const title = '{{ strip_tags($title) }}';
            this.titleWords = title.split(' ').slice(0, 3);
            if (this.titleWords.length < 3) {
                while (this.titleWords.length < 3) {
                    this.titleWords.push('');
                }
            }
        },
        
        animateElement(element, animation, delay = 0) {
            setTimeout(() => {
                element.style.animation = `${animation} 1s ease-out forwards`;
            }, delay * 100);
        },
        
        typewriterEffect(element) {
            const text = element.textContent;
            element.textContent = '';
            let index = 0;
            
            const type = () => {
                if (index < text.length) {
                    element.textContent += text.charAt(index);
                    index++;
                    setTimeout(type, 50);
                }
            };
            
            setTimeout(type, 1000);
        },
        
        animate3DTitle() {
            let rotation = 0;
            setInterval(() => {
                rotation += 0.5;
                if (this.$refs.title3d) {
                    this.$refs.title3d.style.transform = `rotateY(${Math.sin(rotation * 0.01) * 10}deg) rotateX(${Math.cos(rotation * 0.01) * 5}deg)`;
                }
            }, 50);
        },
        
        trackReadingProgress() {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const maxHeight = document.documentElement.scrollHeight - window.innerHeight;
                this.readingProgress = Math.min((scrolled / maxHeight) * 100, 100);
            }, { passive: true });
        },
        
        setupParallax() {
            const parallaxLayers = document.querySelectorAll('.parallax-layer');
            
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                
                parallaxLayers.forEach(layer => {
                    const speed = layer.dataset.speed || 0.5;
                    const yPos = -(scrolled * speed);
                    layer.style.transform = `translateY(${yPos}px)`;
                });
            }, { passive: true });
        },
        
        initializeCanvas() {
            const canvas = document.querySelector('.particle-canvas');
            if (!canvas) return;
            
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            
            const particles = [];
            const particleCount = 50;
            
            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 3 + 1;
                    this.speedX = Math.random() * 2 - 1;
                    this.speedY = Math.random() * 2 - 1;
                    this.opacity = Math.random() * 0.5 + 0.2;
                }
                
                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;
                    
                    if (this.x > canvas.width) this.x = 0;
                    if (this.x < 0) this.x = canvas.width;
                    if (this.y > canvas.height) this.y = 0;
                    if (this.y < 0) this.y = canvas.height;
                }
                
                draw() {
                    ctx.fillStyle = `rgba(255, 255, 255, ${this.opacity})`;
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }
            
            for (let i = 0; i < particleCount; i++) {
                particles.push(new Particle());
            }
            
            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                particles.forEach(particle => {
                    particle.update();
                    particle.draw();
                });
                
                requestAnimationFrame(animate);
            }
            
            animate();
            
            // Handle resize
            window.addEventListener('resize', () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
        }
    }));
});
</script>