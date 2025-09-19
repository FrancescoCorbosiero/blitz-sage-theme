{{-- resources/views/sections/hero/hero-3d-parallax.blade.php --}}
{{-- Enhanced 3D Parallax Hero with Pronounced Depth Effects --}}

<section class="hero-parallax relative min-h-screen overflow-hidden bg-gradient-to-b from-slate-900 via-purple-900/20 to-slate-900"
         x-data="hero3D()"
         x-init="init()"
         @mousemove.window="handleMouseMove($event)"
         @deviceorientation.window="handleOrientation($event)">
    
    {{-- Far Background Layer - Moves Slowest --}}
    <div class="absolute inset-0 w-[120%] h-[120%] -top-[10%] -left-[10%]"
         :style="`transform: translate(${parallaxX * -30}px, ${parallaxY * -30}px)`">
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-20 left-20 w-96 h-96 bg-purple-600 rounded-full filter blur-[128px]"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-blue-600 rounded-full filter blur-[128px]"></div>
        </div>
    </div>
    
    {{-- Middle Layer 1 - Grid Pattern --}}
    <div class="absolute inset-0 w-[110%] h-[110%] -top-[5%] -left-[5%]"
         :style="`transform: translate(${parallaxX * -20}px, ${parallaxY * -20}px) scale(1.1)`">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="100" height="100" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 100 0 L 0 0 0 100" fill="none" stroke="white" stroke-width="0.5" opacity="0.1"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"/%3E%3C/svg%3E')] opacity-20"></div>
    </div>
    
    {{-- Middle Layer 2 - Floating Elements --}}
    <div class="absolute inset-0 pointer-events-none">
        {{-- Large floating card - back --}}
        <div class="absolute top-[10%] left-[10%] w-64 h-80 transform rotate-12"
             :style="`transform: translate(${parallaxX * -15}px, ${parallaxY * -15}px) rotate(12deg)`">
            <div class="w-full h-full bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm rounded-2xl border border-white/20"></div>
        </div>
        
        {{-- Medium floating card - middle --}}
        <div class="absolute bottom-[20%] right-[15%] w-48 h-64 transform -rotate-6"
             :style="`transform: translate(${parallaxX * -10}px, ${parallaxY * -10}px) rotate(-6deg)`">
            <div class="w-full h-full bg-gradient-to-br from-purple-500/20 to-blue-500/10 backdrop-blur-sm rounded-2xl border border-white/10"></div>
        </div>
        
        {{-- Small floating elements --}}
        <div class="absolute top-[40%] right-[30%] w-32 h-32"
             :style="`transform: translate(${parallaxX * -8}px, ${parallaxY * -8}px)`">
            <div class="w-full h-full bg-gradient-to-br from-pink-500/30 to-orange-500/20 rounded-full filter blur-xl"></div>
        </div>
    </div>
    
    {{-- Main Content Layer - Moves Medium --}}
    <div class="relative z-10 min-h-screen flex items-center justify-center px-6">
        <div class="max-w-5xl mx-auto text-center"
             :style="`transform: translate(${parallaxX * -5}px, ${parallaxY * -5}px)`">
            
            {{-- Glowing Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 mb-8 bg-white/10 backdrop-blur-md rounded-full border border-white/20"
                 :style="`transform: translate(${parallaxX * 2}px, ${parallaxY * 2}px)`">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-sm text-white/90">WordPress Redefined</span>
            </div>
            
            {{-- Main Title with Shadow --}}
            <div class="relative mb-8">
                <h1 class="text-6xl md:text-8xl font-bold relative"
                    :style="`transform: translate(${parallaxX * 3}px, ${parallaxY * 3}px)`">
                    {{-- Shadow Layer --}}
                    <span class="absolute inset-0 text-black/30 blur-lg"
                          :style="`transform: translate(${parallaxX * -2}px, ${parallaxY * -2}px)`">
                        Blitz Theme
                    </span>
                    {{-- Main Text --}}
                    <span class="relative bg-gradient-to-r from-white via-blue-200 to-purple-200 bg-clip-text text-transparent">
                        Blitz Theme
                    </span>
                </h1>
            </div>
            
            {{-- Subtitle with separate parallax --}}
            <p class="text-2xl md:text-3xl text-gray-300 mb-12"
               :style="`transform: translate(${parallaxX * 4}px, ${parallaxY * 4}px)`">
                Experience the depth of modern web development
            </p>
            
            {{-- Feature Cards with Icons --}}

{{-- Stats Section with Icons --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-20">
    @php
        $stats = [
            ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'value' => '100/100', 'label' => 'PageSpeed'],
            ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'value' => '<50ms', 'label' => 'Load Time'],
            ['icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'value' => 'A+', 'label' => 'Security'],
            ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'value' => '10k+', 'label' => 'Happy Users']
        ];
    @endphp
    
    @foreach($stats as $stat)
        <div class="text-center group cursor-pointer"
             :style="`transform: translate(${parallaxX * {{ 3 + $loop->index }}}px, ${parallaxY * {{ 3 + $loop->index }}}px)`">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-3 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                </svg>
            </div>
            <div class="text-2xl font-bold text-white">{{ $stat['value'] }}</div>
            <div class="text-sm text-white/60">{{ $stat['label'] }}</div>
        </div>
    @endforeach
</div>
            
            {{-- CTAs with different parallax speeds --}}
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mt-16">
                <button class="group px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl shadow-2xl transition-all duration-300"
                        :style="`transform: translate(${parallaxX * 8}px, ${parallaxY * 8}px)`"
                        @mouseenter="$el.style.transform = `translate(${parallaxX * 8}px, ${parallaxY * 8}px) scale(1.05)`"
                        @mouseleave="$el.style.transform = `translate(${parallaxX * 8}px, ${parallaxY * 8}px) scale(1)`">
                    <span class="flex items-center gap-2">
                        Get Started
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </span>
                </button>
                
                <button class="px-8 py-4 bg-white/10 backdrop-blur-md border border-white/20 text-white font-semibold rounded-xl transition-all duration-300"
                        :style="`transform: translate(${parallaxX * 10}px, ${parallaxY * 10}px)`">
                    View Demo
                </button>
            </div>
        </div>
    </div>
    
    {{-- Foreground Layer - Moves Fastest --}}
    <div class="absolute inset-0 pointer-events-none">
        {{-- Floating particles --}}
        @for($i = 0; $i < 5; $i++)
            <div class="absolute w-2 h-2 bg-white rounded-full opacity-60"
                 style="top: {{ rand(10, 90) }}%; left: {{ rand(10, 90) }}%"
                 :style="`transform: translate(${parallaxX * {{ 15 + $i * 2 }}}px, ${parallaxY * {{ 15 + $i * 2 }}}px)`">
            </div>
        @endfor
        
        {{-- Large foreground element --}}
        <div class="absolute -bottom-20 -right-20 w-96 h-96"
             :style="`transform: translate(${parallaxX * 20}px, ${parallaxY * 20}px)`">
            <div class="w-full h-full bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-full filter blur-3xl"></div>
        </div>
    </div>
    
    {{-- Scroll indicator with parallax --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2"
         :style="`transform: translateX(-50%) translate(${parallaxX * 12}px, ${parallaxY * 12}px)`">
        <div class="animate-bounce">
            <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </div>
</section>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('hero3D', () => ({
        parallaxX: 0,
        parallaxY: 0,
        targetX: 0,
        targetY: 0,
        animationFrame: null,
        
        init() {
            this.animate();
            
            // Add smooth scrolling parallax
            window.addEventListener('scroll', () => {
                const scrolled = window.scrollY;
                const rate = scrolled * -0.2;
                this.$el.style.transform = `translateY(${rate}px)`;
            });
        },
        
        handleMouseMove(event) {
            const centerX = window.innerWidth / 2;
            const centerY = window.innerHeight / 2;
            
            // Calculate target positions with stronger effect
            this.targetX = (event.clientX - centerX) / centerX;
            this.targetY = (event.clientY - centerY) / centerY;
        },
        
        handleOrientation(event) {
            // For mobile devices with gyroscope
            if (event.gamma && event.beta) {
                this.targetX = event.gamma / 45; // Limit to -1 to 1
                this.targetY = event.beta / 45;
            }
        },
        
        animate() {
            // Smooth animation with easing
            this.parallaxX += (this.targetX - this.parallaxX) * 0.1;
            this.parallaxY += (this.targetY - this.parallaxY) * 0.1;
            
            this.animationFrame = requestAnimationFrame(() => this.animate());
        },
        
        destroy() {
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
            }
        }
    }));
});
</script>