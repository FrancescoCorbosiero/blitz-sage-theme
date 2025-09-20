{{-- resources/views/sections/header.blade.php --}}
{{-- Premium Header for Dog Safe Place Camp - Fixed Mobile & Spacing --}}

@props([
    'isTransparent' => false,
    'showBookingCta' => true,
    'currentPage' => request()->path(),
])

{{-- Spacer to prevent content overlap --}}
<div class="header-spacer" aria-hidden="true"></div>

<header 
    x-data="{ 
        mobileOpen: false,
        scrolled: false,
        dropdownOpen: false,
        searchOpen: false,
        init() {
            // Handle scroll behavior
            const handleScroll = () => {
                this.scrolled = window.scrollY > 20;
            };
            
            window.addEventListener('scroll', handleScroll);
            handleScroll(); // Check initial state
            
            // Close mobile menu on resize to desktop
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    this.mobileOpen = false;
                    document.body.style.overflow = '';
                }
            });
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', (e) => {
                if (!this.$el.contains(e.target)) {
                    this.dropdownOpen = false;
                    this.searchOpen = false;
                }
            });
            
            // Handle body scroll lock for mobile menu
            this.$watch('mobileOpen', value => {
                if (value) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
        }
    }"
    :class="{ 
        'is-scrolled': scrolled,
        'is-transparent': {{ $isTransparent ? 'true' : 'false' }} && !scrolled 
    }"
    class="site-header fixed top-0 left-0 right-0 transition-all duration-500"
    style="z-index: 9000;"
>
    {{-- Premium glass morphism background --}}
    <div class="header-backdrop absolute inset-0 transition-all duration-500"
         :class="{ 'backdrop-blur-xl': scrolled || !{{ $isTransparent ? 'true' : 'false' }} }">
    </div>

    {{-- Main Container --}}
    <div class="relative container max-w-7xl mx-auto">
        <nav class="header-nav px-4 sm:px-6 lg:px-8 transition-all duration-500"
             :class="{ 'py-2 sm:py-3': scrolled, 'py-3 sm:py-4 lg:py-5': !scrolled }">
            
            {{-- Desktop Layout --}}
            <div class="flex items-center justify-between">
                
                {{-- Logo Section - Enhanced with better spacing --}}
                <div class="flex items-center">
                    <a href="{{ home_url('/') }}" 
                       class="logo-link group flex items-center gap-2 sm:gap-3 lg:gap-4 transition-all duration-300"
                       :class="{ 'scale-95': scrolled }">
                        
                        {{-- Logo Icon Container --}}
                        <div class="logo-icon relative">
                            <div class="logo-icon-bg absolute inset-0 rounded-xl sm:rounded-2xl transition-all duration-500 group-hover:scale-110"></div>
                            <div class="relative w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 flex items-center justify-center">
                                <img src="{{ Vite::asset('resources/images/logo-icon.svg') }}" 
                                     alt="Dog Safe Place" 
                                     class="w-7 h-7 sm:w-8 sm:h-8 lg:w-10 lg:h-10"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                {{-- Fallback emoji if image fails --}}
                                <span class="text-xl sm:text-2xl lg:text-3xl hidden">🐾</span>
                            </div>
                        </div>
                        
                        {{-- Logo Text - Better typography --}}
                        <div class="logo-text">
                            <h1 class="text-base sm:text-lg lg:text-xl font-bold leading-tight tracking-tight">
                                Dog Safe Place
                            </h1>
                            <p class="text-[10px] sm:text-xs lg:text-sm opacity-70 font-medium hidden sm:block">
                                Milano Camp
                            </p>
                        </div>
                    </a>
                </div>

                {{-- Center Navigation - Desktop Only --}}
                <div class="hidden lg:flex items-center justify-center flex-1 px-8">
                    <ul class="nav-list flex items-center gap-1">
                        
                        {{-- Home --}}
                        <li>
                            <a href="{{ home_url('/') }}" 
                               class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                                Home
                            </a>
                        </li>
                        
                        {{-- Services Dropdown --}}
                        <li class="relative" @click.away="dropdownOpen = false">
                            <button @click="dropdownOpen = !dropdownOpen"
                                    class="nav-link nav-dropdown {{ request()->is('servizi*') ? 'active' : '' }}">
                                <span>Servizi</span>
                                <svg class="dropdown-arrow" :class="{ 'rotate-180': dropdownOpen }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            {{-- Dropdown Menu --}}
                            <div x-show="dropdownOpen"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-2"
                                 class="dropdown-menu absolute top-full left-0 mt-2 w-64 rounded-2xl overflow-hidden shadow-2xl"
                                 style="display: none;">
                                
                                <div class="dropdown-content">
                                    <a href="{{ home_url('/servizi/area-privata') }}" 
                                       class="dropdown-item group">
                                        <span class="dropdown-icon">🏞️</span>
                                        <div>
                                            <div class="dropdown-title">Area Privata</div>
                                            <div class="dropdown-desc">2000mq solo per voi</div>
                                        </div>
                                    </a>
                                    
                                    <a href="{{ home_url('/servizi/profiling') }}" 
                                       class="dropdown-item group">
                                        <span class="dropdown-icon">📋</span>
                                        <div>
                                            <div class="dropdown-title">Profiling</div>
                                            <div class="dropdown-desc">Valutazione comportamentale</div>
                                        </div>
                                    </a>
                                    
                                    <a href="{{ home_url('/servizi/team-branco') }}" 
                                       class="dropdown-item group">
                                        <span class="dropdown-icon">👥</span>
                                        <div>
                                            <div class="dropdown-title">Team Branco</div>
                                            <div class="dropdown-desc">Educazione professionale</div>
                                        </div>
                                    </a>
                                    
                                    <a href="{{ home_url('/servizi/abbonamenti') }}" 
                                       class="dropdown-item group">
                                        <span class="dropdown-icon">👑</span>
                                        <div>
                                            <div class="dropdown-title">Abbonamenti VIP</div>
                                            <div class="dropdown-desc">Vantaggi esclusivi</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        
                        {{-- Other Nav Items --}}
                        <li>
                            <a href="{{ home_url('/prezzi') }}" 
                               class="nav-link {{ request()->is('prezzi*') ? 'active' : '' }}">
                                Prezzi
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ home_url('/chi-siamo') }}" 
                               class="nav-link {{ request()->is('chi-siamo*') ? 'active' : '' }}">
                                Chi Siamo
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ home_url('/blog') }}" 
                               class="nav-link {{ request()->is('blog*') ? 'active' : '' }}">
                                Blog
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ home_url('/contatti') }}" 
                               class="nav-link {{ request()->is('contatti*') ? 'active' : '' }}">
                                Contatti
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Right Actions --}}
                <div class="flex items-center gap-2 sm:gap-3 lg:gap-4">
                    
                    {{-- Search Button - Desktop Only --}}
                    <button @click="searchOpen = !searchOpen"
                            class="search-btn hidden lg:flex">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                    
                    {{-- WhatsApp - Desktop Only (Hidden on Mobile) --}}
                    <a href="https://wa.me/393331234567" 
                       target="_blank"
                       class="whatsapp-btn hidden sm:flex">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                    </a>
                    
                    {{-- CTA Button - Desktop Only (Hidden on Mobile) --}}
                    @if($showBookingCta)
                    <a href="{{ home_url('/prenota') }}" 
                       class="btn-primary hidden sm:flex">
                        <span class="hidden sm:inline">Prenota ora</span>
                        <span class="sm:hidden">Prenota</span>
                        <svg class="btn-arrow hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    @endif
                    
                    {{-- Mobile Menu Toggle - Only show on mobile/tablet --}}
                    <button @click="mobileOpen = !mobileOpen"
                            class="mobile-toggle flex lg:hidden"
                            aria-label="Toggle menu"
                            aria-expanded="false"
                            :aria-expanded="mobileOpen.toString()">
                        <span class="hamburger" :class="{ 'active': mobileOpen }">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>
            </div>

            {{-- Search Bar - Hidden by default --}}
            <div x-show="searchOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="search-bar absolute left-0 right-0 top-full mt-2 px-4 sm:px-6 lg:px-8"
                 style="display: none;">
                <form action="{{ home_url('/') }}" method="GET" class="search-form">
                    <input type="search" 
                           name="s" 
                           placeholder="Cerca servizi, articoli..."
                           class="search-input"
                           @keydown.escape="searchOpen = false">
                    <button type="submit" class="search-submit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </nav>
    </div>

    {{-- Mobile Menu Overlay - Fixed positioning --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="mobile-menu-overlay lg:hidden fixed inset-0 bg-black/50 backdrop-blur-sm"
         @click="mobileOpen = false"
         style="display: none; z-index: 9998;">
    </div>

    {{-- Mobile Menu Drawer - Fixed height issue --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="mobile-menu lg:hidden fixed inset-y-0 left-0 w-[85%] max-w-sm overflow-y-auto"
         style="display: none; z-index: 9999; top: 0; bottom: 0; height: 100vh;">
        
        {{-- Mobile Menu Header --}}
        <div class="mobile-menu-header flex items-center justify-between p-4 sm:p-6 sticky top-0 z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center">
                    <span class="text-white text-xl">🐾</span>
                </div>
                <div>
                    <div class="font-bold text-sm sm:text-base">Dog Safe Place</div>
                    <div class="text-[10px] sm:text-xs opacity-70">Milano Camp</div>
                </div>
            </div>
            <button @click="mobileOpen = false" class="mobile-close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Mobile Menu Content --}}
        <nav class="mobile-nav px-4 sm:px-6 pb-6">
            <ul class="space-y-1">
                <li>
                    <a href="{{ home_url('/') }}" 
                       @click="mobileOpen = false"
                       class="mobile-nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <span class="mobile-nav-icon">🏠</span>
                        <span>Home</span>
                    </a>
                </li>
                
                {{-- Services Accordion --}}
                <li x-data="{ open: false }">
                    <button @click="open = !open" class="mobile-nav-link w-full">
                        <span class="mobile-nav-icon">🎾</span>
                        <span>Servizi</span>
                        <svg class="ml-auto w-5 h-5 transition-transform" :class="{ 'rotate-180': open }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" 
                         x-transition
                         class="mobile-submenu"
                         style="display: none;">
                        <a href="{{ home_url('/servizi/area-privata') }}" 
                           @click="mobileOpen = false"
                           class="mobile-submenu-link">
                            Area Privata
                        </a>
                        <a href="{{ home_url('/servizi/profiling') }}" 
                           @click="mobileOpen = false"
                           class="mobile-submenu-link">
                            Profiling Comportamentale
                        </a>
                        <a href="{{ home_url('/servizi/team-branco') }}" 
                           @click="mobileOpen = false"
                           class="mobile-submenu-link">
                            Team Branco
                        </a>
                        <a href="{{ home_url('/servizi/abbonamenti') }}" 
                           @click="mobileOpen = false"
                           class="mobile-submenu-link">
                            Abbonamenti VIP
                        </a>
                    </div>
                </li>
                
                <li>
                    <a href="{{ home_url('/prezzi') }}" 
                       @click="mobileOpen = false"
                       class="mobile-nav-link {{ request()->is('prezzi*') ? 'active' : '' }}">
                        <span class="mobile-nav-icon">💰</span>
                        <span>Prezzi</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ home_url('/chi-siamo') }}" 
                       @click="mobileOpen = false"
                       class="mobile-nav-link {{ request()->is('chi-siamo*') ? 'active' : '' }}">
                        <span class="mobile-nav-icon">👥</span>
                        <span>Chi Siamo</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ home_url('/blog') }}" 
                       @click="mobileOpen = false"
                       class="mobile-nav-link {{ request()->is('blog*') ? 'active' : '' }}">
                        <span class="mobile-nav-icon">📝</span>
                        <span>Blog</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ home_url('/contatti') }}" 
                       @click="mobileOpen = false"
                       class="mobile-nav-link {{ request()->is('contatti*') ? 'active' : '' }}">
                        <span class="mobile-nav-icon">📞</span>
                        <span>Contatti</span>
                    </a>
                </li>
            </ul>

            {{-- Mobile CTAs --}}
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 space-y-3">
                @if($showBookingCta)
                <a href="{{ home_url('/prenota') }}" 
                   @click="mobileOpen = false"
                   class="btn-primary w-full justify-center">
                    <span>Prenota ora</span>
                    <span class="ml-2">🎾</span>
                </a>
                @endif
                
                <a href="https://wa.me/393331234567" 
                   target="_blank"
                   class="btn-secondary w-full justify-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Chat WhatsApp</span>
                </a>
            </div>

            {{-- Mobile Footer Info --}}
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    © 2024 Dog Safe Place Camp<br>
                    Partnership con Team Branco
                </p>
            </div>
        </nav>
    </div>
</header>

{{-- Inline Styles for the Header Component --}}
<style>
/* CSS Custom Properties for theming */
:root {
    --header-height: 72px;
    --header-height-scrolled: 64px;
    --header-height-mobile: 60px;
    --header-height-mobile-scrolled: 56px;
}

/* Header Spacer to prevent content overlap */
.header-spacer {
    height: var(--header-height-mobile);
    transition: height 0.3s ease;
}

@media (min-width: 640px) {
    .header-spacer {
        height: var(--header-height);
    }
}

/* When header is scrolled, adjust spacer */
.is-scrolled + .header-spacer {
    height: var(--header-height-mobile-scrolled);
}

@media (min-width: 640px) {
    .is-scrolled + .header-spacer {
        height: var(--header-height-scrolled);
    }
}

/* Header Base Styles */
.site-header {
    background: var(--bg-primary, #faf7f2);
    border-bottom: 1px solid transparent;
    contain: layout style;
    z-index: 9000 !important; /* Ensure header is always on top */
}

/* Mobile Menu Overlay - Maximum z-index */
.mobile-menu-overlay {
    z-index: 99998 !important;
}

/* Mobile Menu Drawer - Above overlay */
.mobile-menu {
    z-index: 99999 !important;
}

.site-header.is-scrolled {
    border-bottom-color: var(--border-color, #e8e8e0);
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
}

.site-header.is-transparent:not(.is-scrolled) {
    background: transparent;
}

.header-backdrop {
    background: var(--bg-primary, #faf7f2);
    opacity: 0.95;
}

/* Logo Styles */
.logo-icon-bg {
    background: linear-gradient(135deg, #7ba65d 0%, #4a7c28 100%);
    box-shadow: 0 4px 12px rgba(74, 124, 40, 0.15);
}

.logo-link:hover .logo-icon-bg {
    box-shadow: 0 6px 20px rgba(74, 124, 40, 0.25);
}

.logo-text h1 {
    color: var(--text-primary, #1a1a1a);
    font-family: 'Comfortaa', system-ui, sans-serif;
}

.logo-text p {
    color: var(--text-secondary, #3a3a3a);
}

/* Navigation Links */
.nav-link {
    position: relative;
    padding: 0.625rem 1rem;
    color: var(--text-secondary, #3a3a3a);
    font-weight: 500;
    font-size: 0.9375rem;
    border-radius: 0.75rem;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.nav-link:hover {
    color: var(--primary, #2d5016);
    background: rgba(74, 124, 40, 0.08);
}

.nav-link.active {
    color: var(--primary, #2d5016);
    background: rgba(74, 124, 40, 0.12);
    font-weight: 600;
}

/* Dropdown Styles */
.dropdown-arrow {
    width: 1rem;
    height: 1rem;
    transition: transform 0.2s ease;
}

.dropdown-menu {
    background: var(--bg-secondary, #ffffff);
    border: 1px solid var(--border-color, #e8e8e0);
    min-width: 280px;
}

.dropdown-content {
    padding: 0.5rem;
}

.dropdown-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.75rem;
    border-radius: 0.75rem;
    transition: all 0.2s ease;
    color: var(--text-primary, #1a1a1a);
}

.dropdown-item:hover {
    background: rgba(74, 124, 40, 0.08);
}

.dropdown-icon {
    font-size: 1.25rem;
    line-height: 1.5rem;
    flex-shrink: 0;
}

.dropdown-title {
    font-weight: 600;
    font-size: 0.9375rem;
    margin-bottom: 0.125rem;
}

.dropdown-desc {
    font-size: 0.8125rem;
    color: var(--text-secondary, #3a3a3a);
    opacity: 0.8;
}

/* Button Styles */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #7ba65d 0%, #4a7c28 100%);
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
    border-radius: 2rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(74, 124, 40, 0.2);
}

@media (min-width: 640px) {
    .btn-primary {
        padding: 0.625rem 1.25rem;
        font-size: 0.9375rem;
    }
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 124, 40, 0.3);
}

.btn-arrow {
    width: 1.125rem;
    height: 1.125rem;
    transition: transform 0.3s ease;
}

.btn-primary:hover .btn-arrow {
    transform: translateX(2px);
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    background: var(--bg-secondary, #ffffff);
    color: var(--primary, #2d5016);
    font-weight: 600;
    font-size: 0.9375rem;
    border: 2px solid var(--primary-soft, #7ba65d);
    border-radius: 2rem;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: rgba(74, 124, 40, 0.08);
    border-color: var(--primary, #2d5016);
}

/* Icon Buttons */
.search-btn,
.whatsapp-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.75rem;
    color: var(--text-secondary, #3a3a3a);
    background: var(--bg-secondary, #ffffff);
    border: 1px solid var(--border-color, #e8e8e0);
    transition: all 0.2s ease;
}

.search-btn:hover,
.whatsapp-btn:hover {
    color: var(--primary, #2d5016);
    border-color: var(--primary-soft, #7ba65d);
    background: rgba(74, 124, 40, 0.08);
}

/* Search Bar */
.search-form {
    position: relative;
    max-width: 32rem;
    margin: 0 auto;
}

.search-input {
    width: 100%;
    padding: 0.75rem 3rem 0.75rem 1rem;
    background: var(--bg-secondary, #ffffff);
    border: 2px solid var(--border-color, #e8e8e0);
    border-radius: 1rem;
    font-size: 0.875rem;
    color: var(--text-primary, #1a1a1a);
    transition: all 0.2s ease;
}

@media (min-width: 640px) {
    .search-input {
        padding: 0.875rem 3.5rem 0.875rem 1.25rem;
        font-size: 0.9375rem;
    }
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-soft, #7ba65d);
    box-shadow: 0 0 0 3px rgba(74, 124, 40, 0.1);
}

.search-submit {
    position: absolute;
    right: 0.375rem;
    top: 50%;
    transform: translateY(-50%);
    width: 2.25rem;
    height: 2.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary, #2d5016);
    color: white;
    border-radius: 0.625rem;
    transition: all 0.2s ease;
}

@media (min-width: 640px) {
    .search-submit {
        width: 2.5rem;
        height: 2.5rem;
    }
}

.search-submit:hover {
    background: var(--primary-soft, #7ba65d);
}

/* Mobile Menu */
.mobile-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.75rem;
    background: var(--bg-secondary, #ffffff);
    border: 1px solid var(--border-color, #e8e8e0);
    transition: all 0.2s ease;
}

@media (min-width: 640px) {
    .mobile-toggle {
        width: 2.5rem;
        height: 2.5rem;
    }
}

.hamburger {
    width: 1.25rem;
    height: 1rem;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.hamburger span {
    display: block;
    width: 100%;
    height: 2px;
    background: var(--text-primary, #1a1a1a);
    border-radius: 2px;
    transition: all 0.3s ease;
    transform-origin: center;
}

.hamburger.active span:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
}

.hamburger.active span:nth-child(2) {
    opacity: 0;
    transform: scaleX(0);
}

.hamburger.active span:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
}

/* Mobile Menu Drawer - Fixed full height */
.mobile-menu {
    background: var(--bg-primary, #faf7f2);
    box-shadow: 2px 0 20px rgba(0, 0, 0, 0.1);
    z-index: 99999 !important;
    position: fixed !important;
    top: 0 !important;
    bottom: 0 !important;
    left: 0 !important;
    height: 100vh !important;
    height: 100dvh !important; /* Dynamic viewport height for mobile */
    max-height: none !important;
    min-height: 100vh !important;
}

.mobile-menu-header {
    background: var(--bg-secondary, #ffffff);
    border-bottom: 1px solid var(--border-color, #e8e8e0);
    color: var(--text-primary, #1a1a1a);
}

.mobile-close {
    width: 2.25rem;
    height: 2.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.5rem;
    color: var(--text-secondary, #3a3a3a);
    transition: all 0.2s ease;
}

.mobile-close:hover {
    background: rgba(0, 0, 0, 0.05);
    color: var(--text-primary, #1a1a1a);
}

.mobile-nav-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    color: var(--text-primary, #1a1a1a);
    font-weight: 500;
    font-size: 0.9375rem;
    transition: all 0.2s ease;
}

.mobile-nav-link:hover {
    background: rgba(74, 124, 40, 0.08);
    color: var(--primary, #2d5016);
}

.mobile-nav-link.active {
    background: rgba(74, 124, 40, 0.12);
    color: var(--primary, #2d5016);
    font-weight: 600;
}

.mobile-nav-icon {
    font-size: 1.25rem;
    width: 1.75rem;
    text-align: center;
}

.mobile-submenu {
    margin-top: 0.25rem;
    margin-left: 3rem;
    padding-left: 1rem;
    border-left: 2px solid var(--border-color, #e8e8e0);
}

.mobile-submenu-link {
    display: block;
    padding: 0.5rem 0.75rem;
    color: var(--text-secondary, #3a3a3a);
    font-size: 0.875rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
}

.mobile-submenu-link:hover {
    background: rgba(74, 124, 40, 0.08);
    color: var(--primary, #2d5016);
}

/* Dark Mode Support */
[data-theme="dark"] {
    --bg-primary: #0f1419;
    --bg-secondary: #1a1f2e;
    --border-color: #2a2f3a;
    --text-primary: #e4e6ea;
    --text-secondary: #b8bcc8;
    --primary: #a3c394;
    --primary-soft: #6b9654;
}

[data-theme="dark"] .site-header {
    background: #0f1419;
}

[data-theme="dark"] .header-backdrop {
    background: rgba(15, 20, 25, 0.95);
}

[data-theme="dark"] .dropdown-menu,
[data-theme="dark"] .mobile-menu {
    background: #1a1f2e;
    border-color: #2a2f3a;
}

[data-theme="dark"] .search-btn,
[data-theme="dark"] .whatsapp-btn,
[data-theme="dark"] .mobile-toggle,
[data-theme="dark"] .btn-secondary {
    background: #1a1f2e;
    border-color: #2a2f3a;
}

[data-theme="dark"] .search-input {
    background: #1a1f2e;
    border-color: #2a2f3a;
}

[data-theme="dark"] .mobile-menu-header {
    background: #242938;
    border-color: #2a2f3a;
}

/* Responsive Breakpoints */
@media (min-width: 360px) {
    /* Slightly larger phones */
    .xs\:flex {
        display: flex;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .site-header,
    .nav-link,
    .dropdown-menu,
    .btn-primary,
    .hamburger span,
    .mobile-menu {
        transition: none;
    }
}

/* Print Styles */
@media print {
    .site-header {
        display: none;
    }
    
    .header-spacer {
        display: none;
    }
}

/* Prevent body scroll when mobile menu is open */
body.overflow-hidden {
    overflow: hidden;
    position: fixed;
    width: 100%;
}
</style>