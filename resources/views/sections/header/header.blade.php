{{-- resources/views/sections/header.blade.php --}}
@props([
    'isSticky' => true,
    'showWhatsapp' => true,
    'showCta' => true,
    'transparentOnHero' => false,
])

<header 
    class="site-header group/header fixed top-0 left-0 right-0 z-[999] w-full"
    x-data="premiumNavigation()"
    x-init="init()"
    :class="{
        'is-scrolled': scrolled,
        'is-hidden': hidden && scrolled,
        'is-transparent': !scrolled && {{ $transparentOnHero ? 'true' : 'false' }}
    }"
    @scroll.window="handleScroll"
    @resize.window.debounce.500ms="checkBreakpoint"
>
    {{-- Magnetic Background Effect --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none" x-ref="magneticBg">
        <div class="magnetic-layer absolute inset-0 bg-gradient-to-br from-emerald-500/5 via-transparent to-orange-500/5"
             :style="`transform: translate(${mouseX * 0.02}px, ${mouseY * 0.02}px)`"></div>
        <div class="magnetic-layer absolute inset-0 bg-gradient-to-tr from-transparent via-green-500/3 to-transparent"
             :style="`transform: translate(${-mouseX * 0.01}px, ${-mouseY * 0.01}px) rotate(${mouseX * 0.01}deg)`"></div>
    </div>
    
    {{-- Ultra Premium Glass Morphism Background --}}
    <div class="header-bg absolute inset-0 transition-all duration-700 ease-out"
         :class="{
             'bg-white/80 dark:bg-gray-900/80 backdrop-blur-2xl shadow-2xl': scrolled,
             'bg-transparent': !scrolled
         }">
        {{-- Animated Grain Texture --}}
        <div class="absolute inset-0 opacity-[0.015] mix-blend-multiply hidden lg:block">
            <svg width="100%" height="100%">
                <filter id="noiseFilter">
                    <feTurbulence type="turbulence" baseFrequency="0.9" numOctaves="4" stitchTiles="stitch"/>
                </filter>
                <rect width="100%" height="100%" filter="url(#noiseFilter)"/>
            </svg>
        </div>
    </div>
    
    {{-- Liquid Animated Border --}}
    <div class="absolute bottom-0 left-0 right-0 h-px overflow-hidden">
        <div class="liquid-border h-full w-[300%] bg-gradient-to-r from-transparent via-emerald-500 to-transparent"
             :class="{ 'opacity-100': scrolled, 'opacity-0': !scrolled }"></div>
    </div>
    
    {{-- Container --}}
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <nav class="relative flex h-16 sm:h-20 items-center justify-between transition-[height] duration-500 ease-out"
             :class="{ 'lg:h-16': scrolled, 'lg:h-24': !scrolled }">
            
            {{-- Premium Logo with Magnetic Effect --}}
            <a 
                href="{{ home_url('/') }}" 
                class="logo-magnetic group/logo relative z-50 flex items-center gap-2 sm:gap-3"
                x-ref="logo"
                @mousemove="magneticEffect($event, $refs.logo)"
                @mouseleave="resetMagnetic($refs.logo)"
                aria-label="Dog Safe Place Camp - Home"
            >
                {{-- Glow Effect Container - Hidden on Mobile --}}
                <div class="absolute -inset-8 opacity-0 group-hover/logo:opacity-100 transition-opacity duration-700 hidden sm:block">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-400/20 to-orange-400/20 blur-3xl animate-pulse-slow"></div>
                </div>
                
                {{-- Logo Icon with 3D Layers --}}
                <div class="logo-icon relative w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 transition-all duration-500"
                     :class="{ 'sm:w-12 sm:h-12 lg:w-14 lg:h-14': scrolled }">
                    {{-- Shadow Layers for Depth - Reduced on Mobile --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-xl sm:rounded-2xl blur-md sm:blur-xl opacity-30 sm:opacity-40 scale-110 hidden sm:block"></div>
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl sm:rounded-2xl blur-sm sm:blur-md opacity-40 sm:opacity-60 scale-105 hidden sm:block"></div>
                    
                    {{-- Main Logo Container --}}
                    <div class="relative w-full h-full bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700 rounded-xl sm:rounded-2xl shadow-logo overflow-hidden group-hover/logo:scale-110 transition-transform duration-500 ease-out">
                        {{-- Animated Shine Effect --}}
                        <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/20 to-transparent -translate-x-full group-hover/logo:translate-x-full transition-transform duration-1000"></div>
                        
                        {{-- Logo Icon --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-9 lg:h-9 text-white drop-shadow-2xl" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.5 10.5C4.5 12.9853 6.51472 15 9 15C11.4853 15 13.5 12.9853 13.5 10.5C13.5 8.01472 11.4853 6 9 6C6.51472 6 4.5 8.01472 4.5 10.5ZM10.5 16.5C10.5 18.9853 12.5147 21 15 21C17.4853 21 19.5 18.9853 19.5 16.5C19.5 14.0147 17.4853 12 15 12C12.5147 12 10.5 14.0147 10.5 16.5Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                {{-- Logo Text with Split Animation --}}
                <div class="relative overflow-hidden">
                    <h1 class="logo-text font-display text-base sm:text-xl lg:text-2xl font-bold tracking-tight">
                        <span class="inline-block text-gray-900 dark:text-white transition-all duration-500"
                              :class="{ 'sm:text-lg lg:text-xl': scrolled }">Dog Safe</span>
                        <span class="inline-block text-emerald-600 dark:text-emerald-400 ml-1 sm:ml-2 transition-all duration-500 hidden sm:inline-block"
                              :class="{ 'sm:text-lg lg:text-xl': scrolled }">Place</span>
                    </h1>
                    <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400 font-medium tracking-wide mt-0.5 opacity-0 sm:opacity-100 lg:opacity-100 transition-opacity duration-500 hidden sm:block"
                       :class="{ 'lg:opacity-0': scrolled }">
                        Il paradiso dei cani
                    </p>
                </div>
            </a>
            
            {{-- Desktop Navigation with Premium Hover Effects --}}
            <div class="hidden lg:flex items-center gap-1 xl:gap-2">
                @php
                    $menu_items = [
                        ['url' => '/', 'label' => 'Home', 'icon' => '🏠'],
                        ['url' => '#servizi', 'label' => 'Servizi', 'icon' => '🎾', 'dropdown' => [
                            ['url' => '/servizi/area-privata', 'label' => 'Area Privata', 'description' => 'Spazio esclusivo per il tuo cane'],
                            ['url' => '/servizi/profiling', 'label' => 'Profiling', 'description' => 'Valutazione comportamentale'],
                            ['url' => '/servizi/team-branco', 'label' => 'Team Branco', 'description' => 'Esperti al tuo servizio'],
                            ['url' => '/servizi/vip', 'label' => 'Abbonamento VIP', 'description' => 'Accesso premium illimitato'],
                        ]],
                        ['url' => '#testimonianze', 'label' => 'Testimonianze', 'icon' => '💕'],
                        ['url' => '#faq', 'label' => 'FAQ', 'icon' => '❓'],
                        ['url' => '/blog', 'label' => 'Blog', 'icon' => '📝'],
                    ];
                @endphp
                
                @foreach($menu_items as $index => $item)
                    @if(isset($item['dropdown']))
                        {{-- Premium Dropdown --}}
                        <div class="nav-item-group" 
                             x-data="{ open: false, hovered: false }" 
                             @mouseenter="open = true; hovered = true" 
                             @mouseleave="open = false; hovered = false">
                            <button 
                                class="nav-link relative px-4 py-2 text-gray-700 dark:text-gray-200 font-medium tracking-wide transition-all duration-300 rounded-xl hover:text-emerald-600 dark:hover:text-emerald-400 group"
                                :class="{ 'text-emerald-600 dark:text-emerald-400': open }"
                            >
                                {{-- Hover Background --}}
                                <span class="absolute inset-0 bg-gradient-to-r from-emerald-50 to-orange-50 dark:from-emerald-900/20 dark:to-orange-900/20 rounded-xl scale-0 group-hover:scale-100 transition-transform duration-500 ease-out"></span>
                                
                                {{-- Text Content --}}
                                <span class="relative flex items-center gap-1.5">
                                    {{ $item['label'] }}
                                    <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                                
                                {{-- Active Indicator --}}
                                <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-emerald-500 to-emerald-600 group-hover:w-3/4 transition-all duration-500 ease-out rounded-full"></span>
                            </button>
                            
                            {{-- Premium Dropdown Panel --}}
                            <div 
                                x-show="open"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute top-full mt-2 w-80 origin-top"
                                @click.away="open = false"
                            >
                                <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-dropdown overflow-hidden">
                                    {{-- Gradient Border --}}
                                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 via-transparent to-orange-500/20 opacity-60"></div>
                                    
                                    <div class="relative bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl rounded-2xl p-2">
                                        @foreach($item['dropdown'] as $subindex => $subitem)
                                            <a 
                                                href="{{ home_url($subitem['url']) }}" 
                                                class="dropdown-item group flex flex-col px-4 py-3 rounded-xl transition-all duration-300 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-orange-50 dark:hover:from-emerald-900/20 dark:hover:to-orange-900/20"
                                                style="animation-delay: {{ $subindex * 50 }}ms"
                                            >
                                                <span class="font-medium text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                                                    {{ $subitem['label'] }}
                                                </span>
                                                @if(isset($subitem['description']))
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                        {{ $subitem['description'] }}
                                                    </span>
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Regular Nav Item --}}
                        <a 
                            href="{{ home_url($item['url']) }}" 
                            class="nav-link relative px-4 py-2 text-gray-700 dark:text-gray-200 font-medium tracking-wide transition-all duration-300 rounded-xl hover:text-emerald-600 dark:hover:text-emerald-400 group"
                            x-data="{ hovered: false }"
                            @mouseenter="hovered = true"
                            @mouseleave="hovered = false"
                        >
                            {{-- Hover Background --}}
                            <span class="absolute inset-0 bg-gradient-to-r from-emerald-50 to-orange-50 dark:from-emerald-900/20 dark:to-orange-900/20 rounded-xl scale-0 group-hover:scale-100 transition-transform duration-500 ease-out"></span>
                            
                            {{-- Text --}}
                            <span class="relative">{{ $item['label'] }}</span>
                            
                            {{-- Active Indicator --}}
                            <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-emerald-500 to-emerald-600 group-hover:w-3/4 transition-all duration-500 ease-out rounded-full"></span>
                        </a>
                    @endif
                @endforeach
            </div>
            
            {{-- Premium CTA Section --}}
            <div class="flex items-center gap-2 sm:gap-3">
                {{-- WhatsApp Button with Liquid Effect --}}
                @if($showWhatsapp)
                    <a 
                        href="https://wa.me/393331234567" 
                        target="_blank"
                        class="whatsapp-premium relative hidden sm:flex w-10 h-10 sm:w-12 sm:h-12 items-center justify-center rounded-full overflow-hidden group"
                        x-data="{ hovered: false }"
                        @mouseenter="hovered = true"
                        @mouseleave="hovered = false"
                    >
                        {{-- Liquid Background --}}
                        <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-green-600">
                            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        </div>
                        
                        {{-- Ripple Effect --}}
                        <div class="absolute inset-0 hidden lg:block">
                            <span class="absolute inset-0 animate-ping bg-green-400 opacity-20 rounded-full"></span>
                        </div>
                        
                        {{-- Icon --}}
                        <svg class="relative z-10 w-5 h-5 sm:w-6 sm:h-6 text-white transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                    </a>
                @endif
                
                {{-- Mobile CTA Button --}}
                @if($showCta)
                    <a 
                        href="{{ home_url('/prenota') }}" 
                        class="cta-mobile sm:hidden px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-sm font-semibold rounded-xl shadow-lg"
                    >
                        Prenota
                    </a>
                @endif
                
                {{-- Ultra Premium Desktop CTA Button --}}
                @if($showCta)
                    <a 
                        href="{{ home_url('/prenota') }}" 
                        class="cta-premium relative hidden sm:inline-flex items-center gap-2 px-4 sm:px-6 py-2 sm:py-3 overflow-hidden group"
                        x-data="{ hovered: false }"
                        @mouseenter="hovered = true"
                        @mouseleave="hovered = false"
                    >
                        {{-- Animated Background Layers --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-emerald-600 transition-transform duration-500 group-hover:scale-110"></div>
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        {{-- Shine Effect --}}
                        <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                        
                        {{-- Content --}}
                        <span class="relative z-10 font-semibold text-white tracking-wide text-sm sm:text-base">Prenota Ora</span>
                        <svg class="relative z-10 w-4 h-4 sm:w-5 sm:h-5 text-white transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                @endif
                
                {{-- Mobile Menu Toggle with Morphing Animation --}}
                <button 
                    @click="mobileOpen = !mobileOpen" 
                    class="menu-toggle relative w-10 h-10 sm:w-12 sm:h-12 lg:hidden flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800 transition-all duration-300"
                    :class="{ 'rotate-90': mobileOpen }"
                    aria-label="Menu"
                >
                    <div class="hamburger-lines relative w-5 h-4 sm:w-6 sm:h-5">
                        <span class="line line1 absolute w-full h-0.5 bg-gray-900 dark:bg-white rounded-full transition-all duration-300"
                              :class="{ 'rotate-45 translate-y-[8px] sm:translate-y-[10px]': mobileOpen }"></span>
                        <span class="line line2 absolute w-full h-0.5 bg-gray-900 dark:bg-white rounded-full top-1.5 sm:top-2 transition-all duration-300"
                              :class="{ 'opacity-0 scale-0': mobileOpen }"></span>
                        <span class="line line3 absolute w-full h-0.5 bg-gray-900 dark:bg-white rounded-full top-3 sm:top-4 transition-all duration-300"
                              :class="{ '-rotate-45 -translate-y-[8px] sm:-translate-y-[10px]': mobileOpen }"></span>
                    </div>
                </button>
            </div>
        </nav>
    </div>
    
    {{-- Premium Mobile Menu Overlay --}}
    <div 
        x-show="mobileOpen" 
        x-transition:enter="transition ease-out duration-400"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-md z-[998] lg:hidden"
        @click="mobileOpen = false"
    ></div>
    
    {{-- Premium Mobile Menu Panel --}}
    <div 
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-500 transform"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 bottom-0 w-full max-w-sm bg-white dark:bg-gray-900 shadow-2xl z-[999] lg:hidden overflow-y-auto"
    >
        {{-- Mobile Menu Header --}}
        <div class="sticky top-0 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 z-10">
            <div class="flex items-center justify-between p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Menu</h2>
                <button 
                    @click="mobileOpen = false"
                    class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 transition-colors hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        {{-- Mobile Menu Items --}}
        <div class="p-4 sm:p-6">
            <nav class="space-y-2">
                @foreach($menu_items as $item)
                    @if(isset($item['dropdown']))
                        <div x-data="{ subOpen: false }">
                            <button 
                                @click="subOpen = !subOpen"
                                class="w-full flex items-center justify-between px-4 py-3 text-gray-700 dark:text-gray-200 font-medium rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                            >
                                <span>{{ $item['label'] }}</span>
                                <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': subOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <div 
                                x-show="subOpen"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                class="mt-2 ml-4 space-y-1"
                            >
                                @foreach($item['dropdown'] as $subitem)
                                    <a 
                                        href="{{ home_url($subitem['url']) }}" 
                                        @click="mobileOpen = false"
                                        class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors"
                                    >
                                        {{ $subitem['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a 
                            href="{{ home_url($item['url']) }}" 
                            @click="mobileOpen = false"
                            class="block px-4 py-3 text-gray-700 dark:text-gray-200 font-medium rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>
            
            {{-- Mobile CTAs --}}
            <div class="mt-8 space-y-3">
                <a 
                    href="{{ home_url('/prenota') }}" 
                    @click="mobileOpen = false"
                    class="block w-full px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-semibold text-center rounded-xl shadow-lg hover:shadow-xl transition-all duration-300"
                >
                    Prenota il tuo spazio
                </a>
                
                @if($showWhatsapp)
                    <a 
                        href="https://wa.me/393331234567" 
                        @click="mobileOpen = false"
                        class="block w-full px-6 py-3 bg-green-500 text-white font-semibold text-center rounded-xl shadow-lg hover:shadow-xl transition-all duration-300"
                    >
                        WhatsApp
                    </a>
                @endif
            </div>
        </div>
    </div>
</header>

{{-- Alpine.js Component --}}
<script>
function premiumNavigation() {
    return {
        mobileOpen: false,
        scrolled: false,
        hidden: false,
        lastScroll: 0,
        mouseX: 0,
        mouseY: 0,
        
        init() {
            this.handleScroll();
            
            // Smooth magnetic mouse tracking - only on desktop
            if (window.innerWidth >= 1024) {
                document.addEventListener('mousemove', (e) => {
                    this.mouseX = (e.clientX - window.innerWidth / 2) / 25;
                    this.mouseY = (e.clientY - window.innerHeight / 2) / 25;
                });
            }
        },
        
        handleScroll() {
            const currentScroll = window.pageYOffset;
            this.scrolled = currentScroll > 20;
            
            // Hide header on scroll down (but not on mobile when menu is open)
            if (currentScroll > 100 && currentScroll > this.lastScroll && !this.mobileOpen) {
                this.hidden = true;
            } else {
                this.hidden = false;
            }
            
            this.lastScroll = currentScroll;
        },
        
        magneticEffect(e, element) {
            if (window.innerWidth < 1024) return; // Disable on mobile/tablet
            
            const rect = element.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            
            element.style.transform = `translate(${x * 0.1}px, ${y * 0.1}px)`;
            element.style.transition = 'transform 0.3s ease-out';
        },
        
        resetMagnetic(element) {
            if (window.innerWidth < 1024) return;
            
            element.style.transform = 'translate(0, 0)';
            element.style.transition = 'transform 0.5s ease-out';
        },
        
        checkBreakpoint() {
            if (window.innerWidth >= 1024) {
                this.mobileOpen = false;
            }
        }
    }
}
</script>

{{-- Premium Styles --}}
<style>
/* Premium animations */
@keyframes pulse-slow {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.05); }
}

.animate-pulse-slow {
    animation: pulse-slow 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Liquid border animation */
@keyframes liquid-flow {
    0% { transform: translateX(-33.33%); }
    100% { transform: translateX(0); }
}

.liquid-border {
    animation: liquid-flow 3s linear infinite;
}

/* Shadow styles */
.shadow-logo {
    box-shadow: 
        0 10px 25px -5px rgba(16, 185, 129, 0.25),
        0 5px 10px -5px rgba(0, 0, 0, 0.1),
        inset 0 1px 2px rgba(255, 255, 255, 0.2);
}

.shadow-dropdown {
    box-shadow: 
        0 20px 25px -5px rgba(0, 0, 0, 0.1),
        0 10px 10px -5px rgba(0, 0, 0, 0.04),
        0 0 0 1px rgba(0, 0, 0, 0.05);
}

/* Dropdown item animation */
.dropdown-item {
    animation: slideUp 0.3s ease-out forwards;
    opacity: 0;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* CTA button premium style */
.cta-premium, .cta-mobile {
    border-radius: 12px;
    font-size: 0.95rem;
    letter-spacing: 0.025em;
    box-shadow: 
        0 10px 25px -5px rgba(16, 185, 129, 0.3),
        0 5px 10px -5px rgba(0, 0, 0, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.cta-premium:hover {
    box-shadow: 
        0 20px 35px -5px rgba(16, 185, 129, 0.4),
        0 10px 15px -5px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

/* Header transitions */
.site-header {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.site-header.is-hidden {
    transform: translateY(-100%);
}

/* Mobile optimizations */
@media (max-width: 640px) {
    .site-header {
        backdrop-filter: blur(12px);
    }
    
    /* Simpler shadows on mobile for performance */
    .shadow-logo {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
}

/* Dark mode optimizations */
@media (prefers-color-scheme: dark) {
    .header-bg {
        background-color: rgba(17, 24, 39, 0.8);
    }
}

/* Performance optimizations */
.site-header * {
    backface-visibility: hidden;
    -webkit-font-smoothing: antialiased;
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

/* Fix mobile menu panel height */
@media (max-width: 1023px) {
    .site-header {
        z-index: 999;
    }
}
</style>