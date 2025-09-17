{{-- resources/views/404.blade.php --}}
@extends('layouts.app')

@section('content')
<section class="error-404-premium min-h-screen relative overflow-hidden flex items-center justify-center" 
         x-data="error404Premium()" 
         x-init="init()">
    
    {{-- Dynamic Background Canvas --}}
    <canvas class="matrix-canvas absolute inset-0 z-0" x-ref="matrixCanvas"></canvas>
    
    {{-- Animated Gradient Orbs --}}
    <div class="orb-container absolute inset-0 z-1">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="orb orb-4"></div>
    </div>
    
    {{-- Glitch Grid --}}
    <div class="glitch-grid absolute inset-0 z-2">
        @for($i = 0; $i < 20; $i++)
            <div class="grid-line grid-line-{{ $i }}" style="animation-delay: {{ $i * 0.1 }}s"></div>
        @endfor
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            
            {{-- 3D Animated 404 --}}
            <div class="error-number-container perspective-2000 mb-12" x-ref="errorContainer">
                <div class="error-number-3d">
                    <div class="number-layer layer-main">
                        <span class="digit digit-4" data-text="4">4</span>
                        <span class="digit digit-0" data-text="0">0</span>
                        <span class="digit digit-4" data-text="4">4</span>
                    </div>
                    <div class="number-layer layer-shadow">404</div>
                    <div class="number-layer layer-glow">404</div>
                </div>
                
                {{-- Lightning Effect --}}
                <svg class="lightning-effect absolute inset-0 w-full h-full" viewBox="0 0 800 400">
                    <defs>
                        <filter id="glow">
                            <feGaussianBlur stdDeviation="4" result="coloredBlur"/>
                            <feMerge>
                                <feMergeNode in="coloredBlur"/>
                                <feMergeNode in="SourceGraphic"/>
                            </feMerge>
                        </filter>
                    </defs>
                    <path class="bolt-path" d="M200,50 L300,200 L250,200 L350,350" 
                          stroke="url(#bolt-gradient)" stroke-width="3" fill="none" filter="url(#glow)"/>
                    <path class="bolt-path" d="M600,50 L500,200 L550,200 L450,350" 
                          stroke="url(#bolt-gradient)" stroke-width="3" fill="none" filter="url(#glow)"/>
                    <defs>
                        <linearGradient id="bolt-gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#f97316;stop-opacity:1"/>
                            <stop offset="50%" style="stop-color:#fff;stop-opacity:1"/>
                            <stop offset="100%" style="stop-color:#4a7c28;stop-opacity:1"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            
            {{-- Glitched Message --}}
            <div class="error-message text-center mb-12" x-ref="errorMessage">
                <h1 class="glitch-text text-4xl md:text-6xl font-bold mb-6" data-text="{{ __('Reality Not Found', 'blitz') }}">
                    <span class="glitch-text-main">{{ __('Reality Not Found', 'blitz') }}</span>
                    <span class="glitch-text-clone glitch-1">{{ __('Reality Not Found', 'blitz') }}</span>
                    <span class="glitch-text-clone glitch-2">{{ __('Reality Not Found', 'blitz') }}</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-text-secondary max-w-3xl mx-auto leading-relaxed mb-8">
                    <span class="typewriter-text" x-ref="typewriter"></span>
                    <span class="typewriter-cursor">|</span>
                </p>
            </div>
            
            {{-- Interactive Portal Navigation --}}
            <div class="portal-navigation mb-16" x-ref="portalNav">
                <div class="portals-container grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                    {{-- Home Portal --}}
                    <div class="portal-card group" @click="navigatePortal('/')">
                        <div class="portal-frame">
                            <div class="portal-vortex">
                                <div class="vortex-ring ring-1"></div>
                                <div class="vortex-ring ring-2"></div>
                                <div class="vortex-ring ring-3"></div>
                            </div>
                            <div class="portal-content">
                                <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <h3 class="text-lg font-bold mb-2">{{ __('Return Home', 'blitz') }}</h3>
                                <p class="text-sm text-text-muted">{{ __('Back to safety', 'blitz') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Search Portal --}}
                    <div class="portal-card group" @click="activateSearch()">
                        <div class="portal-frame">
                            <div class="portal-vortex">
                                <div class="vortex-ring ring-1"></div>
                                <div class="vortex-ring ring-2"></div>
                                <div class="vortex-ring ring-3"></div>
                            </div>
                            <div class="portal-content">
                                <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <h3 class="text-lg font-bold mb-2">{{ __('Search Reality', 'blitz') }}</h3>
                                <p class="text-sm text-text-muted">{{ __('Find your path', 'blitz') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Contact Portal --}}
                    <div class="portal-card group" @click="navigatePortal('/contact')">
                        <div class="portal-frame">
                            <div class="portal-vortex">
                                <div class="vortex-ring ring-1"></div>
                                <div class="vortex-ring ring-2"></div>
                                <div class="vortex-ring ring-3"></div>
                            </div>
                            <div class="portal-content">
                                <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                <h3 class="text-lg font-bold mb-2">{{ __('Get Help', 'blitz') }}</h3>
                                <p class="text-sm text-text-muted">{{ __('Contact support', 'blitz') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Advanced Search Interface --}}
            <div class="search-interface" x-show="searchActive" x-transition x-ref="searchInterface">
                <div class="search-container glass-card-ultra p-8 rounded-3xl max-w-2xl mx-auto">
                    <form @submit.prevent="performSearch" class="relative">
                        <div class="search-field-wrapper">
                            <input type="search" 
                                   x-model="searchQuery"
                                   x-ref="searchInput"
                                   placeholder="{{ __('Search across dimensions...', 'blitz') }}"
                                   class="search-input-premium w-full px-6 py-4 pr-20 text-lg bg-transparent border-2 border-primary/30 rounded-2xl focus:border-primary focus:outline-none transition-all duration-300">
                            
                            <div class="search-particles absolute inset-0 pointer-events-none">
                                @for($i = 0; $i < 10; $i++)
                                    <span class="particle particle-{{ $i }}"></span>
                                @endfor
                            </div>
                            
                            <button type="submit" 
                                    class="search-submit absolute right-2 top-1/2 transform -translate-y-1/2 w-14 h-14 bg-gradient-to-br from-primary to-accent text-white rounded-xl hover:scale-110 transition-transform flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                    
                    {{-- Search Suggestions --}}
                    <div class="search-suggestions mt-6" x-show="searchQuery.length > 0">
                        <p class="text-sm text-text-muted mb-3">{{ __('Suggested destinations:', 'blitz') }}</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['About', 'Services', 'Blog', 'Portfolio', 'Team'] as $suggestion)
                                <button @click="searchQuery = '{{ $suggestion }}'" 
                                        class="suggestion-chip px-4 py-2 bg-bg-tertiary hover:bg-primary hover:text-white rounded-full text-sm transition-all duration-200">
                                    {{ $suggestion }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Lost Traveler Stats --}}
            <div class="stats-container text-center mt-16" x-ref="stats">
                <div class="stats-grid grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                    <div class="stat-card glass-card-ultra p-6 rounded-2xl">
                        <div class="stat-number text-3xl font-bold text-primary mb-2" x-text="visitorCount"></div>
                        <div class="stat-label text-sm text-text-muted">{{ __('Lost Visitors', 'blitz') }}</div>
                    </div>
                    <div class="stat-card glass-card-ultra p-6 rounded-2xl">
                        <div class="stat-number text-3xl font-bold text-accent mb-2" x-text="timeSpent"></div>
                        <div class="stat-label text-sm text-text-muted">{{ __('Seconds Here', 'blitz') }}</div>
                    </div>
                    <div class="stat-card glass-card-ultra p-6 rounded-2xl">
                        <div class="stat-number text-3xl font-bold text-primary-soft mb-2" x-text="clickCount"></div>
                        <div class="stat-label text-sm text-text-muted">{{ __('Clicks Made', 'blitz') }}</div>
                    </div>
                    <div class="stat-card glass-card-ultra p-6 rounded-2xl">
                        <div class="stat-number text-3xl font-bold text-primary-dark mb-2">∞</div>
                        <div class="stat-label text-sm text-text-muted">{{ __('Possibilities', 'blitz') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Easter Egg: Konami Code --}}
    <div class="easter-egg fixed inset-0 z-50 pointer-events-none" 
         x-show="konamiActivated" 
         x-transition>
        <div class="easter-egg-content flex items-center justify-center h-full">
            <h1 class="text-6xl md:text-8xl font-bold rainbow-text animate-bounce">
                {{ __('You Found It!', 'blitz') }}
            </h1>
        </div>
    </div>
</section>

<style>
/* Premium 404 Styles */
.error-404-premium {
    background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 50%, var(--bg-tertiary) 100%);
    position: relative;
}

/* Matrix Rain Effect Canvas */
.matrix-canvas {
    opacity: 0.1;
}

/* Animated Orbs */
.orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    animation: float-orb 20s infinite ease-in-out;
}

.orb-1 {
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
    top: -200px;
    left: -200px;
    animation-duration: 25s;
}

.orb-2 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, var(--accent) 0%, transparent 70%);
    bottom: -100px;
    right: -100px;
    animation-duration: 20s;
    animation-delay: 5s;
}

.orb-3 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, var(--primary-soft) 0%, transparent 70%);
    top: 50%;
    left: 30%;
    animation-duration: 30s;
    animation-delay: 10s;
}

.orb-4 {
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, var(--primary-dark) 0%, transparent 70%);
    bottom: 20%;
    right: 20%;
    animation-duration: 22s;
    animation-delay: 15s;
}

@keyframes float-orb {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    25% {
        transform: translate(50px, -100px) scale(1.1);
    }
    50% {
        transform: translate(-100px, 50px) scale(0.9);
    }
    75% {
        transform: translate(100px, 100px) scale(1.05);
    }
}

/* Glitch Grid */
.grid-line {
    position: absolute;
    background: linear-gradient(90deg, transparent, var(--primary), transparent);
    opacity: 0;
    animation: grid-flash 3s infinite;
}

.grid-line:nth-child(odd) {
    width: 1px;
    height: 100%;
    left: calc(var(--i) * 5%);
}

.grid-line:nth-child(even) {
    width: 100%;
    height: 1px;
    top: calc(var(--i) * 5%);
}

@keyframes grid-flash {
    0%, 95% { opacity: 0; }
    97% { opacity: 0.3; }
    100% { opacity: 0; }
}

/* 3D Error Number */
.perspective-2000 {
    perspective: 2000px;
}

.error-number-3d {
    position: relative;
    transform-style: preserve-3d;
    animation: rotate-3d 10s infinite linear;
}

.number-layer {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 10rem;
    font-weight: 900;
    line-height: 1;
}

@media (max-width: 768px) {
    .number-layer {
        font-size: 6rem;
    }
}

.layer-main {
    z-index: 3;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 50%, var(--primary-soft) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 0 0 40px rgba(249, 115, 22, 0.5);
}

.layer-shadow {
    z-index: 1;
    color: rgba(0, 0, 0, 0.2);
    transform: translate(-48%, -48%) translateZ(-50px);
    filter: blur(4px);
}

.layer-glow {
    z-index: 2;
    color: var(--accent);
    opacity: 0.5;
    transform: translate(-52%, -52%) translateZ(50px);
    filter: blur(2px);
    animation: pulse-glow 2s infinite;
}

@keyframes rotate-3d {
    0% { transform: rotateY(0deg) rotateX(0deg); }
    25% { transform: rotateY(180deg) rotateX(10deg); }
    50% { transform: rotateY(360deg) rotateX(0deg); }
    75% { transform: rotateY(540deg) rotateX(-10deg); }
    100% { transform: rotateY(720deg) rotateX(0deg); }
}

@keyframes pulse-glow {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 0.8; }
}

/* Digit Animation */
.digit {
    display: inline-block;
    position: relative;
    animation: digit-glitch 0.3s infinite alternate;
}

.digit::before,
.digit::after {
    content: attr(data-text);
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0.8;
}

.digit::before {
    color: var(--accent);
    animation: glitch-1 0.2s infinite linear alternate-reverse;
}

.digit::after {
    color: var(--primary);
    animation: glitch-2 0.3s infinite linear alternate-reverse;
}

@keyframes digit-glitch {
    0%, 100% { transform: translate(0); }
    20% { transform: translate(-1px, 1px); }
    40% { transform: translate(1px, -1px); }
    60% { transform: translate(-1px, -1px); }
    80% { transform: translate(1px, 1px); }
}

/* Lightning Bolts */
.bolt-path {
    stroke-dasharray: 500;
    stroke-dashoffset: 500;
    animation: lightning-strike 4s infinite;
}

.bolt-path:nth-child(2) {
    animation-delay: 2s;
}

@keyframes lightning-strike {
    0%, 90% {
        stroke-dashoffset: 500;
        opacity: 0;
    }
    95% {
        stroke-dashoffset: 0;
        opacity: 1;
    }
    100% {
        stroke-dashoffset: 0;
        opacity: 0;
    }
}

/* Glitch Text */
.glitch-text {
    position: relative;
}

.glitch-text-main {
    position: relative;
    z-index: 2;
}

.glitch-text-clone {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
    opacity: 0.8;
}

.glitch-1 {
    color: var(--accent);
    animation: glitch-anim-1 0.3s infinite linear alternate-reverse;
}

.glitch-2 {
    color: var(--primary);
    animation: glitch-anim-2 0.3s infinite linear alternate-reverse;
}

@keyframes glitch-anim-1 {
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

@keyframes glitch-anim-2 {
    0% {
        clip-path: polygon(0 25%, 100% 25%, 100% 45%, 0 45%);
        transform: translate(2px, 2px) skew(1deg);
    }
    50% {
        clip-path: polygon(0 65%, 100% 65%, 100% 85%, 0 85%);
        transform: translate(-2px, -2px) skew(-1deg);
    }
    100% {
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        transform: translate(0, 0) skew(0);
    }
}

/* Typewriter Effect */
.typewriter-cursor {
    display: inline-block;
    animation: blink 1s infinite;
    font-weight: 100;
    color: var(--accent);
}

@keyframes blink {
    0%, 49% { opacity: 1; }
    50%, 100% { opacity: 0; }
}

/* Portal Cards */
.portal-card {
    position: relative;
    cursor: pointer;
    transition: all 0.3s ease;
}

.portal-card:hover {
    transform: translateY(-10px);
}

.portal-frame {
    position: relative;
    height: 250px;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    overflow: hidden;
}

.portal-vortex {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.vortex-ring {
    position: absolute;
    border: 2px solid;
    border-radius: 50%;
    opacity: 0.3;
}

.ring-1 {
    width: 150px;
    height: 150px;
    border-color: var(--primary);
    animation: rotate-ring 10s linear infinite;
}

.ring-2 {
    width: 120px;
    height: 120px;
    border-color: var(--accent);
    animation: rotate-ring 8s linear infinite reverse;
}

.ring-3 {
    width: 90px;
    height: 90px;
    border-color: var(--primary-soft);
    animation: rotate-ring 6s linear infinite;
}

@keyframes rotate-ring {
    from { transform: rotate(0deg) scale(1); }
    50% { transform: rotate(180deg) scale(1.1); }
    to { transform: rotate(360deg) scale(1); }
}

.portal-card:hover .vortex-ring {
    opacity: 0.8;
    animation-duration: 2s;
}

.portal-content {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    padding: 2rem;
}

.portal-card:hover .portal-content svg {
    transform: scale(1.2);
    transition: transform 0.3s ease;
}

/* Glass Card Ultra */
.glass-card-ultra {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 
        0 20px 40px rgba(0, 0, 0, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

[data-theme="dark"] .glass-card-ultra {
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Search Interface */
.search-input-premium {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
}

.search-input-premium:focus {
    background: rgba(255, 255, 255, 0.08);
    box-shadow: 0 0 0 4px rgba(74, 124, 40, 0.1);
}

.search-particles .particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: var(--accent);
    border-radius: 50%;
    opacity: 0;
    animation: particle-float 3s infinite;
}

@keyframes particle-float {
    0% {
        opacity: 0;
        transform: translate(0, 0);
    }
    20% {
        opacity: 1;
    }
    100% {
        opacity: 0;
        transform: translate(100px, -100px);
    }
}

/* Stat Cards Animation */
.stat-card {
    animation: slide-up 0.6s ease-out forwards;
    opacity: 0;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }

@keyframes slide-up {
    to {
        opacity: 1;
        transform: translateY(0);
    }
    from {
        opacity: 0;
        transform: translateY(20px);
    }
}

/* Rainbow Text */
.rainbow-text {
    background: linear-gradient(
        90deg,
        #ff0000,
        #ff7f00,
        #ffff00,
        #00ff00,
        #0000ff,
        #4b0082,
        #9400d3
    );
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: rainbow-shift 2s linear infinite;
}

@keyframes rainbow-shift {
    to { background-position: 200% center; }
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .portal-frame {
        height: 200px;
    }
    
    .ring-1 { width: 100px; height: 100px; }
    .ring-2 { width: 80px; height: 80px; }
    .ring-3 { width: 60px; height: 60px; }
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('error404Premium', () => ({
        searchActive: false,
        searchQuery: '',
        konamiActivated: false,
        konamiCode: [],
        konamiSequence: ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'],
        visitorCount: 0,
        timeSpent: 0,
        clickCount: 0,
        typewriterText: "{{ __('You\'ve discovered a glitch in the matrix. The page you seek exists in another dimension.', 'blitz') }}",
        typewriterIndex: 0,
        
        init() {
            this.initializeMatrix();
            this.startTypewriter();
            this.initializeStats();
            this.setupKonamiListener();
            this.animateElements();
            this.trackPageView();
        },
        
        initializeMatrix() {
            const canvas = this.$refs.matrixCanvas;
            if (!canvas) return;
            
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            
            const columns = Math.floor(canvas.width / 20);
            const drops = Array(columns).fill(1);
            const characters = '01アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲン';
            
            function drawMatrix() {
                ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                ctx.fillStyle = '#4a7c28';
                ctx.font = '15px monospace';
                
                for (let i = 0; i < drops.length; i++) {
                    const text = characters[Math.floor(Math.random() * characters.length)];
                    ctx.fillText(text, i * 20, drops[i] * 20);
                    
                    if (drops[i] * 20 > canvas.height && Math.random() > 0.975) {
                        drops[i] = 0;
                    }
                    drops[i]++;
                }
            }
            
            setInterval(drawMatrix, 50);
            
            // Handle resize
            window.addEventListener('resize', () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
        },
        
        startTypewriter() {
            const element = this.$refs.typewriter;
            if (!element) return;
            
            const type = () => {
                if (this.typewriterIndex < this.typewriterText.length) {
                    element.textContent += this.typewriterText.charAt(this.typewriterIndex);
                    this.typewriterIndex++;
                    setTimeout(type, 50);
                }
            };
            
            setTimeout(type, 1000);
        },
        
        initializeStats() {
            // Animate visitor count
            const targetCount = Math.floor(Math.random() * 9000) + 1000;
            const increment = targetCount / 100;
            const timer = setInterval(() => {
                this.visitorCount = Math.min(Math.floor(this.visitorCount + increment), targetCount);
                if (this.visitorCount >= targetCount) {
                    clearInterval(timer);
                }
            }, 20);
            
            // Track time spent
            setInterval(() => {
                this.timeSpent++;
            }, 1000);
            
            // Track clicks
            document.addEventListener('click', () => {
                this.clickCount++;
            });
        },
        
        setupKonamiListener() {
            document.addEventListener('keydown', (e) => {
                this.konamiCode.push(e.key);
                this.konamiCode = this.konamiCode.slice(-10);
                
                if (this.konamiCode.join(',') === this.konamiSequence.join(',')) {
                    this.activateEasterEgg();
                }
            });
        },
        
        activateEasterEgg() {
            this.konamiActivated = true;
            setTimeout(() => {
                this.konamiActivated = false;
            }, 3000);
            
            // Party mode
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 }
            });
        },
        
        animateElements() {
            // 3D rotation for error number
            let rotation = 0;
            setInterval(() => {
                rotation += 1;
                if (this.$refs.errorContainer) {
                    const container = this.$refs.errorContainer.querySelector('.error-number-3d');
                    if (container) {
                        container.style.transform = `rotateY(${rotation}deg) rotateX(${Math.sin(rotation * 0.01) * 10}deg)`;
                    }
                }
            }, 50);
        },
        
        navigatePortal(url) {
            // Portal animation before navigation
            const portal = event.currentTarget;
            portal.style.animation = 'portal-activate 0.5s ease-out';
            
            setTimeout(() => {
                window.location.href = url;
            }, 500);
        },
        
        activateSearch() {
            this.searchActive = true;
            this.$nextTick(() => {
                this.$refs.searchInput?.focus();
            });
        },
        
        performSearch() {
            if (this.searchQuery.trim()) {
                window.location.href = `/?s=${encodeURIComponent(this.searchQuery)}`;
            }
        },
        
        trackPageView() {
            // Analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'page_view', {
                    'page_title': '404 - Premium Not Found',
                    'page_location': window.location.href,
                    'error_type': '404'
                });
            }
        }
    }));
});

// Add portal activation animation
const style = document.createElement('style');
style.textContent = `
@keyframes portal-activate {
    0% { transform: scale(1) rotate(0deg); }
    50% { transform: scale(1.2) rotate(180deg); }
    100% { transform: scale(0) rotate(360deg); opacity: 0; }
}
`;
document.head.appendChild(style);

// Simple confetti for easter egg
function confetti(options) {
    const defaults = {
        particleCount: 50,
        spread: 70,
        origin: { y: 0.6 }
    };
    
    const config = Object.assign({}, defaults, options);
    
    for (let i = 0; i < config.particleCount; i++) {
        const particle = document.createElement('div');
        particle.style.cssText = `
            position: fixed;
            top: ${config.origin.y * 100}%;
            left: 50%;
            width: 10px;
            height: 10px;
            background: hsl(${Math.random() * 360}, 100%, 50%);
            pointer-events: none;
            z-index: 9999;
        `;
        
        document.body.appendChild(particle);
        
        const angle = (Math.random() - 0.5) * config.spread * Math.PI / 180;
        const velocity = Math.random() * 10 + 5;
        const gravity = 0.5;
        let x = 0;
        let y = 0;
        let vy = -velocity;
        let vx = Math.sin(angle) * velocity;
        
        const animate = () => {
            vy += gravity;
            x += vx;
            y += vy;
            
            particle.style.transform = `translate(${x}px, ${y}px) rotate(${Math.random() * 360}deg)`;
            particle.style.opacity = Math.max(0, 1 - y / 500);
            
            if (y < 500) {
                requestAnimationFrame(animate);
            } else {
                particle.remove();
            }
        };
        
        requestAnimationFrame(animate);
    }
}
</script>
@endsection