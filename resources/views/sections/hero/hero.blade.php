{{-- resources/views/sections/hero/hero-constellation.blade.php --}}
{{-- Particle Constellation Hero with Interactive Canvas --}}

<section class="hero-constellation relative min-h-screen flex items-center justify-center overflow-hidden"
         x-data="heroConstellation()"
         x-init="init()"
         @mousemove="updateMousePosition($event)"
         @resize.window="handleResize()">
    
    {{-- Canvas Background --}}
    <canvas x-ref="canvas" 
            class="absolute inset-0 w-full h-full"
            :width="canvasWidth"
            :height="canvasHeight"></canvas>
    
    {{-- Gradient Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/90 via-purple-900/80 to-pink-900/90"></div>
    
    {{-- Content --}}
    <div class="relative z-10 container max-w-6xl mx-auto px-6 text-center">
        <div class="space-y-8">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20"
                 x-data="{ show: false }"
                 x-init="setTimeout(() => show = true, 300)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-sm text-white/90">WordPress Theme of the Future</span>
            </div>
            
            {{-- Main Title --}}
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold text-white"
                x-data="{ show: false }"
                x-init="setTimeout(() => show = true, 500)"
                x-show="show"
                x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0 translate-y-8"
                x-transition:enter-end="opacity-100 translate-y-0">
                <span class="block">Build</span>
                <span class="block mt-2 bg-gradient-to-r from-cyan-400 via-blue-400 to-purple-400 bg-clip-text text-transparent">
                    Extraordinary
                </span>
                <span class="block mt-2">Websites</span>
            </h1>
            
            {{-- Subtitle --}}
            <p class="text-xl md:text-2xl text-white/80 max-w-3xl mx-auto"
               x-data="{ show: false }"
               x-init="setTimeout(() => show = true, 700)"
               x-show="show"
               x-transition:enter="transition ease-out duration-1000"
               x-transition:enter-start="opacity-0"
               x-transition:enter-end="opacity-100">
                Blitz Theme combines cutting-edge performance with stunning design. 
                Built on Sage 10, optimized for Core Web Vitals, and crafted for developers who demand excellence.
            </p>
            
            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center"
                 x-data="{ show: false }"
                 x-init="setTimeout(() => show = true, 900)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0">
                
                <button @click="$dispatch('demo-modal')"
                        class="group px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-full hover:shadow-2xl hover:shadow-purple-500/25 transform hover:scale-105 transition-all duration-300">
                    <span class="flex items-center gap-2">
                        View Live Demo
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </span>
                </button>
                
                <a href="#features"
                   class="px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-full hover:bg-white/20 transform hover:scale-105 transition-all duration-300">
                    Explore Features
                </a>
            </div>
            
            {{-- Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16"
                 x-data="{ show: false }"
                 x-init="setTimeout(() => show = true, 1100)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0">
                
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white"
                         x-data="{ count: 0 }"
                         x-init="
                            $nextTick(() => {
                                let interval = setInterval(() => {
                                    if (count < 100) {
                                        count += 2;
                                    } else {
                                        clearInterval(interval);
                                    }
                                }, 20);
                            })
                         "
                         x-text="count">0</div>
                    <div class="text-white/60 text-sm mt-1">PageSpeed Score</div>
                </div>
                
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white">&lt;50ms</div>
                    <div class="text-white/60 text-sm mt-1">First Input Delay</div>
                </div>
                
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white">A+</div>
                    <div class="text-white/60 text-sm mt-1">Security Grade</div>
                </div>
                
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white">∞</div>
                    <div class="text-white/60 text-sm mt-1">Possibilities</div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Scroll Indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('heroConstellation', () => ({
        particles: [],
        mouseX: 0,
        mouseY: 0,
        canvasWidth: window.innerWidth,
        canvasHeight: window.innerHeight,
        ctx: null,
        animationFrame: null,
        
        init() {
            this.setupCanvas();
            this.createParticles();
            this.animate();
        },
        
        setupCanvas() {
            this.ctx = this.$refs.canvas.getContext('2d');
            this.canvasWidth = window.innerWidth;
            this.canvasHeight = window.innerHeight;
        },
        
        createParticles() {
            const particleCount = Math.floor((this.canvasWidth * this.canvasHeight) / 15000);
            
            for (let i = 0; i < particleCount; i++) {
                this.particles.push({
                    x: Math.random() * this.canvasWidth,
                    y: Math.random() * this.canvasHeight,
                    vx: (Math.random() - 0.5) * 0.5,
                    vy: (Math.random() - 0.5) * 0.5,
                    radius: Math.random() * 2 + 1,
                    opacity: Math.random() * 0.5 + 0.5
                });
            }
        },
        
        updateMousePosition(event) {
            this.mouseX = event.clientX;
            this.mouseY = event.clientY;
        },
        
        animate() {
            this.ctx.clearRect(0, 0, this.canvasWidth, this.canvasHeight);
            
            // Update and draw particles
            this.particles.forEach(particle => {
                // Mouse interaction
                const dx = this.mouseX - particle.x;
                const dy = this.mouseY - particle.y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < 100) {
                    const force = (100 - distance) / 100;
                    particle.vx += (dx / distance) * force * 0.05;
                    particle.vy += (dy / distance) * force * 0.05;
                }
                
                // Update position
                particle.x += particle.vx;
                particle.y += particle.vy;
                
                // Friction
                particle.vx *= 0.98;
                particle.vy *= 0.98;
                
                // Wrap around edges
                if (particle.x < 0) particle.x = this.canvasWidth;
                if (particle.x > this.canvasWidth) particle.x = 0;
                if (particle.y < 0) particle.y = this.canvasHeight;
                if (particle.y > this.canvasHeight) particle.y = 0;
                
                // Draw particle
                this.ctx.beginPath();
                this.ctx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2);
                this.ctx.fillStyle = `rgba(255, 255, 255, ${particle.opacity})`;
                this.ctx.fill();
            });
            
            // Draw connections
            this.particles.forEach((particle, i) => {
                this.particles.slice(i + 1).forEach(otherParticle => {
                    const dx = particle.x - otherParticle.x;
                    const dy = particle.y - otherParticle.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);
                    
                    if (distance < 150) {
                        this.ctx.beginPath();
                        this.ctx.moveTo(particle.x, particle.y);
                        this.ctx.lineTo(otherParticle.x, otherParticle.y);
                        this.ctx.strokeStyle = `rgba(255, 255, 255, ${0.15 * (1 - distance / 150)})`;
                        this.ctx.stroke();
                    }
                });
            });
            
            this.animationFrame = requestAnimationFrame(() => this.animate());
        },
        
        handleResize() {
            this.canvasWidth = window.innerWidth;
            this.canvasHeight = window.innerHeight;
        },
        
        destroy() {
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
            }
        }
    }));
});
</script>