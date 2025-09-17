{{-- resources/views/404.blade.php --}}
@extends('layouts.app')

@section('content')
<section class="error-404-premium min-h-screen relative overflow-hidden flex items-center justify-center" 
         x-data="error404Premium()" 
         x-init="init()">
    
    {{-- Animated Geometric Background --}}
    <div class="geometric-bg absolute inset-0 z-0">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
        <div class="shape shape-5"></div>
    </div>
    
    {{-- Gradient Mesh --}}
    <div class="gradient-mesh absolute inset-0 z-1">
        <div class="mesh-layer mesh-1"></div>
        <div class="mesh-layer mesh-2"></div>
        <div class="mesh-layer mesh-3"></div>
    </div>
    
    {{-- Particle System --}}
    <canvas class="particle-canvas absolute inset-0 z-2" x-ref="particleCanvas"></canvas>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            
            {{-- Animated 404 Number --}}
            <div class="error-number-container mb-12" x-ref="errorContainer">
                <div class="error-number-wrapper">
                    <div class="number-group">
                        <span class="digit digit-4" data-text="4">4</span>
                        <span class="digit digit-0" data-text="0">
                        <span class="zero-content">0</span>
                            <div class="zero-decoration">
                                <svg class="compass-icon" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="2" fill="none"/>
                                    <path d="M50 20 L60 50 L50 80 L40 50 Z" fill="currentColor" opacity="0.5"/>
                                    <circle cx="50" cy="50" r="5" fill="currentColor"/>
                                </svg>
                            </div>
                        </span>
                        <span class="digit digit-4" data-text="4">4</span>
                    </div>
                    <div class="number-shadow">404</div>
                </div>
            </div>
            
            {{-- Error Message --}}
            <div class="error-message text-center mb-12" x-ref="errorMessage">
                <h1 class="error-title text-4xl md:text-6xl font-bold mb-6">
                    {{ __('Page Not Found', 'blitz') }}
                </h1>
                
                <p class="error-description text-xl md:text-2xl text-text-secondary max-w-3xl mx-auto leading-relaxed mb-8">
                    <span class="animated-text" x-ref="animatedText"></span>
                    <span class="text-cursor">|</span>
                </p>
            </div>
            
            {{-- Navigation Cards --}}
            <div class="navigation-cards mb-16" x-ref="navCards">
                <div class="cards-container grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                    
                    {{-- Home Card --}}
                    <div class="nav-card group" @click="navigateTo('/')" @mouseenter="hoverCard($event)" @mouseleave="unhoverCard($event)">
                        <div class="card-inner">
                            <div class="card-icon">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </div>
                            <h3 class="card-title">{{ __('Homepage', 'blitz') }}</h3>
                            <p class="card-description">{{ __('Return to the main page', 'blitz') }}</p>
                            <div class="card-arrow">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Search Card --}}
                    <div class="nav-card group" @click="activateSearch()" @mouseenter="hoverCard($event)" @mouseleave="unhoverCard($event)">
                        <div class="card-inner">
                            <div class="card-icon">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <h3 class="card-title">{{ __('Search', 'blitz') }}</h3>
                            <p class="card-description">{{ __('Find what you need', 'blitz') }}</p>
                            <div class="card-arrow">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Support Card --}}
                    <div class="nav-card group" @click="navigateTo('/contact')" @mouseenter="hoverCard($event)" @mouseleave="unhoverCard($event)">
                        <div class="card-inner">
                            <div class="card-icon">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <h3 class="card-title">{{ __('Support', 'blitz') }}</h3>
                            <p class="card-description">{{ __('Get help from our team', 'blitz') }}</p>
                            <div class="card-arrow">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Search Interface --}}
            <div class="search-overlay" x-show="searchActive" x-transition @click.self="searchActive = false">
                <div class="search-modal" @click.stop>
                    <button class="close-search" @click="searchActive = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    
                    <h2 class="search-title">{{ __('What are you looking for?', 'blitz') }}</h2>
                    
                    <form @submit.prevent="performSearch" class="search-form">
                        <div class="search-input-wrapper">
                            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="search" 
                                   x-model="searchQuery"
                                   x-ref="searchInput"
                                   placeholder="{{ __('Type keywords...', 'blitz') }}"
                                   class="search-input">
                            <button type="submit" class="search-submit">
                                {{ __('Search', 'blitz') }}
                            </button>
                        </div>
                    </form>
                    
                    {{-- Quick Links --}}
                    <div class="quick-links" x-show="searchQuery.length === 0">
                        <h3 class="quick-links-title">{{ __('Popular Pages', 'blitz') }}</h3>
                        <div class="links-grid">
                            @foreach(['About Us', 'Services', 'Blog', 'Portfolio', 'Contact'] as $link)
                                <a href="/{{ strtolower(str_replace(' ', '-', $link)) }}" 
                                   class="quick-link">
                                    {{ __($link, 'blitz') }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    {{-- Search Suggestions --}}
                    <div class="search-suggestions" x-show="searchQuery.length > 0">
                        <h3 class="suggestions-title">{{ __('Suggestions', 'blitz') }}</h3>
                        <div class="suggestions-list">
                            <template x-for="suggestion in getSearchSuggestions()" :key="suggestion">
                                <button @click="searchQuery = suggestion; performSearch()" 
                                        class="suggestion-item" x-text="suggestion"></button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Help Section --}}
            <div class="help-section text-center mt-16">
                <p class="help-text text-text-muted mb-4">
                    {{ __('Need immediate assistance?', 'blitz') }}
                </p>
                <div class="help-actions flex flex-wrap justify-center gap-4">
                    <a href="mailto:support@example.com" 
                       class="help-link">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ __('Email Support', 'blitz') }}
                    </a>
                    <a href="/sitemap" 
                       class="help-link">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        {{ __('Sitemap', 'blitz') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Premium 404 Styles - Professional */
.error-404-premium {
    background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 50%, var(--bg-tertiary) 100%);
    position: relative;
    min-height: 100vh;
}

/* Geometric Background */
.geometric-bg {
    opacity: 0.05;
}

.shape {
    position: absolute;
    background: var(--primary);
    opacity: 0.5;
}

.shape-1 {
    width: 300px;
    height: 300px;
    top: 10%;
    left: 5%;
    border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
    animation: float-shape 20s infinite ease-in-out;
}

.shape-2 {
    width: 200px;
    height: 200px;
    top: 60%;
    right: 10%;
    border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
    animation: float-shape 25s infinite ease-in-out reverse;
}

.shape-3 {
    width: 150px;
    height: 150px;
    bottom: 20%;
    left: 15%;
    border-radius: 40% 60% 60% 40% / 60% 30% 70% 40%;
    animation: float-shape 30s infinite ease-in-out;
}

.shape-4 {
    width: 250px;
    height: 250px;
    top: 30%;
    right: 30%;
    border-radius: 50%;
    animation: float-shape 35s infinite ease-in-out reverse;
}

.shape-5 {
    width: 100px;
    height: 100px;
    bottom: 10%;
    right: 25%;
    transform: rotate(45deg);
    animation: rotate-shape 20s infinite linear;
}

@keyframes float-shape {
    0%, 100% {
        transform: translate(0, 0) rotate(0deg);
    }
    33% {
        transform: translate(30px, -30px) rotate(120deg);
    }
    66% {
        transform: translate(-20px, 20px) rotate(240deg);
    }
}

@keyframes rotate-shape {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Gradient Mesh */
.mesh-layer {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0.03;
}

.mesh-1 {
    background: radial-gradient(circle at 20% 50%, var(--primary) 0%, transparent 50%);
    animation: mesh-move 30s infinite ease-in-out;
}

.mesh-2 {
    background: radial-gradient(circle at 80% 80%, var(--accent) 0%, transparent 50%);
    animation: mesh-move 40s infinite ease-in-out reverse;
}

.mesh-3 {
    background: radial-gradient(circle at 50% 30%, var(--primary-soft) 0%, transparent 50%);
    animation: mesh-move 35s infinite ease-in-out;
}

@keyframes mesh-move {
    0%, 100% { transform: translate(0, 0); }
    25% { transform: translate(-5%, 5%); }
    50% { transform: translate(5%, -5%); }
    75% { transform: translate(-5%, -5%); }
}

/* Error Number Styling */
.error-number-container {
    text-align: center;
    margin-bottom: 3rem;
}

.error-number-wrapper {
    position: relative;
    display: inline-block;
}

.number-group {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
}

.digit {
    font-size: clamp(6rem, 15vw, 10rem);
    font-weight: 900;
    line-height: 1;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
    display: inline-block;
    animation: pulse-number 3s infinite ease-in-out;
}

.digit:nth-child(2) { animation-delay: 0.1s; }
.digit:nth-child(3) { animation-delay: 0.2s; }

@keyframes pulse-number {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.digit-0 {
    position: relative;
}

.zero-decoration {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60%;
    height: 60%;
}

.compass-icon {
    width: 100%;
    height: 100%;
    color: var(--accent);
    opacity: 0.3;
    animation: rotate-compass 10s infinite linear;
}

@keyframes rotate-compass {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.number-shadow {
    position: absolute;
    top: 5px;
    left: 5px;
    font-size: clamp(6rem, 15vw, 10rem);
    font-weight: 900;
    color: rgba(0, 0, 0, 0.1);
    z-index: -1;
    filter: blur(10px);
}

/* Error Message */
.error-title {
    color: var(--text-primary);
    margin-bottom: 1.5rem;
}

.animated-text {
    color: var(--text-secondary);
}

.text-cursor {
    display: inline-block;
    color: var(--accent);
    animation: blink-cursor 1s infinite;
    font-weight: 300;
}

@keyframes blink-cursor {
    0%, 49% { opacity: 1; }
    50%, 100% { opacity: 0; }
}

/* Navigation Cards */
.nav-card {
    cursor: pointer;
    transition: all 0.3s ease;
}

.card-inner {
    position: relative;
    padding: 2rem;
    background: var(--card-bg);
    border: 2px solid var(--border-color);
    border-radius: 1rem;
    overflow: hidden;
    transition: all 0.3s ease;
}

.nav-card:hover .card-inner {
    transform: translateY(-5px);
    border-color: var(--primary);
    box-shadow: 0 20px 40px var(--shadow);
}

.card-inner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 100%);
    transform: translateX(-100%);
    transition: transform 0.3s ease;
}

.nav-card:hover .card-inner::before {
    transform: translateX(0);
}

.card-icon {
    width: 3rem;
    height: 3rem;
    margin-bottom: 1rem;
    color: var(--primary);
    transition: all 0.3s ease;
}

.nav-card:hover .card-icon {
    transform: scale(1.1);
    color: var(--accent);
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.card-description {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
}

.card-arrow {
    position: absolute;
    bottom: 1.5rem;
    right: 1.5rem;
    width: 1.5rem;
    height: 1.5rem;
    color: var(--primary);
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s ease;
}

.nav-card:hover .card-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Search Overlay */
.search-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(10px);
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.search-modal {
    position: relative;
    width: 100%;
    max-width: 600px;
    background: var(--card-bg);
    border-radius: 1.5rem;
    padding: 3rem;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
}

.close-search {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-tertiary);
    border-radius: 50%;
    color: var(--text-muted);
    transition: all 0.3s ease;
}

.close-search:hover {
    background: var(--primary);
    color: white;
    transform: rotate(90deg);
}

.search-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 2rem;
    text-align: center;
}

.search-form {
    margin-bottom: 2rem;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    background: var(--bg-secondary);
    border: 2px solid var(--border-color);
    border-radius: 1rem;
    overflow: hidden;
    transition: all 0.3s ease;
}

.search-input-wrapper:focus-within {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(74, 124, 40, 0.1);
}

.search-icon {
    width: 1.5rem;
    height: 1.5rem;
    margin: 0 1rem;
    color: var(--text-muted);
}

.search-input {
    flex: 1;
    padding: 1rem 0;
    background: transparent;
    border: none;
    outline: none;
    font-size: 1.125rem;
    color: var(--text-primary);
}

.search-submit {
    padding: 1rem 2rem;
    background: var(--primary);
    color: white;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-submit:hover {
    background: var(--primary-dark);
}

/* Quick Links */
.quick-links-title,
.suggestions-title {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-muted);
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 0.75rem;
}

.quick-link,
.suggestion-item {
    padding: 0.75rem 1rem;
    background: var(--bg-tertiary);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.quick-link:hover,
.suggestion-item:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
}

/* Help Section */
.help-section {
    margin-top: 4rem;
}

.help-text {
    font-size: 1rem;
    color: var(--text-muted);
}

.help-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.help-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 0.75rem;
    color: var(--text-secondary);
    text-decoration: none;
    transition: all 0.3s ease;
}

.help-link:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px var(--shadow);
}

/* Dark Mode Adjustments */
[data-theme="dark"] .error-404-premium {
    background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #2a2a2a 100%);
}

[data-theme="dark"] .search-overlay {
    background: rgba(0, 0, 0, 0.95);
}

[data-theme="dark"] .number-shadow {
    color: rgba(255, 255, 255, 0.05);
}

/* Responsive Design */
@media (max-width: 768px) {
    .cards-container {
        grid-template-columns: 1fr;
    }
    
    .search-modal {
        padding: 2rem 1.5rem;
    }
    
    .links-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .help-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .help-link {
        width: 100%;
        max-width: 250px;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('error404Premium', () => ({
        searchActive: false,
        searchQuery: '',
        animationTexts: [
            "{{ __('The page you are looking for seems to have moved, been deleted, or never existed.', 'blitz') }}",
            "{{ __('We couldn\'t find the page you requested. Perhaps searching can help.', 'blitz') }}",
            "{{ __('This page has gone missing. Let us help you find what you need.', 'blitz') }}"
        ],
        currentTextIndex: 0,
        charIndex: 0,
        
        init() {
            this.initParticles();
            this.startTextAnimation();
            this.trackPageView();
        },
        
        initParticles() {
            const canvas = this.$refs.particleCanvas;
            if (!canvas) return;
            
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            
            const particles = [];
            const particleCount = 50;
            
            class Particle {
                constructor() {
                    this.reset();
                }
                
                reset() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 2 + 1;
                    this.speedX = (Math.random() - 0.5) * 0.5;
                    this.speedY = (Math.random() - 0.5) * 0.5;
                    this.opacity = Math.random() * 0.5 + 0.2;
                }
                
                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;
                    
                    if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
                    if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
                }
                
                draw() {
                    ctx.globalAlpha = this.opacity;
                    ctx.fillStyle = '#4a7c28';
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
                
                // Draw connections
                ctx.globalAlpha = 0.1;
                ctx.strokeStyle = '#4a7c28';
                ctx.lineWidth = 0.5;
                
                for (let i = 0; i < particles.length; i++) {
                    for (let j = i + 1; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const distance = Math.sqrt(dx * dx + dy * dy);
                        
                        if (distance < 100) {
                            ctx.beginPath();
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.stroke();
                        }
                    }
                }
                
                requestAnimationFrame(animate);
            }
            
            animate();
            
            window.addEventListener('resize', () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
        },
        
        startTextAnimation() {
            const element = this.$refs.animatedText;
            if (!element) return;
            
            const currentText = this.animationTexts[this.currentTextIndex];
            
            const typeChar = () => {
                if (this.charIndex < currentText.length) {
                    element.textContent += currentText.charAt(this.charIndex);
                    this.charIndex++;
                    setTimeout(typeChar, 30);
                } else {
                    setTimeout(() => {
                        this.deleteText();
                    }, 3000);
                }
            };
            
            typeChar();
        },
        
        deleteText() {
            const element = this.$refs.animatedText;
            if (!element) return;
            
            const deleteChar = () => {
                if (element.textContent.length > 0) {
                    element.textContent = element.textContent.slice(0, -1);
                    setTimeout(deleteChar, 20);
                } else {
                    this.currentTextIndex = (this.currentTextIndex + 1) % this.animationTexts.length;
                    this.charIndex = 0;
                    setTimeout(() => this.startTextAnimation(), 500);
                }
            };
            
            deleteChar();
        },
        
        navigateTo(url) {
            const card = event.currentTarget;
            card.style.transform = 'scale(0.95)';
            
            setTimeout(() => {
                window.location.href = url;
            }, 200);
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
        
        getSearchSuggestions() {
            const suggestions = ['Homepage', 'About Us', 'Services', 'Contact', 'Blog', 'Portfolio'];
            if (this.searchQuery.length > 0) {
                return suggestions.filter(s => 
                    s.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            }
            return suggestions;
        },
        
        hoverCard(event) {
            const card = event.currentTarget;
            const rect = card.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;
            
            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);
        },
        
        unhoverCard(event) {
            const card = event.currentTarget;
            card.style.removeProperty('--mouse-x');
            card.style.removeProperty('--mouse-y');
        },
        
        trackPageView() {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'page_view', {
                    'page_title': '404 - Page Not Found',
                    'page_location': window.location.href,
                    'error_type': '404'
                });
            }
        }
    }));
});
</script>
@endsection