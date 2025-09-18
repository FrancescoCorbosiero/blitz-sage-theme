{{-- resources/views/components/action-board.blade.php --}}

@php
    // Get data from Sage/Theme Service
    $themeService = app('blitz.theme');
    $contactInfo = $themeService->getContactInfo();
    $socialLinks = $themeService->getSocialLinks();
    
    // Configuration
    $layout = $layout ?? 'vertical'; // 'vertical', 'horizontal', 'compact'
    $position = $position ?? 'right'; // 'left', 'right', 'bottom'
    $showBackToTop = $showBackToTop ?? true;
    $showThemeToggle = $showThemeToggle ?? get_theme_mod('show_theme_toggle', true);
    $showSocials = $showSocials ?? !empty($socialLinks);
    $showContact = $showContact ?? !empty($contactInfo['whatsapp']);
    $expandable = $expandable ?? true;
    $autoHide = $autoHide ?? false;
    
    // Prepare config for Alpine
    $alpineConfig = [
        'layout' => $layout,
        'position' => $position,
        'expandable' => $expandable,
        'autoHide' => $autoHide
    ];
@endphp

<div class="action-board action-board-{{ $layout }} action-board-{{ $position }}"
     x-data="actionBoard({{ json_encode($alpineConfig) }})"
     x-init="init()"
     :class="{ 
         'is-expanded': expanded,
         'is-collapsed': !expanded,
         'is-hidden': hidden,
         'is-scrolled': scrolled
     }">
    
    {{-- Toggle Button (for expandable boards) --}}
    @if($expandable)
    <button @click="toggleBoard()" 
            class="board-toggle"
            :aria-label="expanded ? '{{ __('Collapse menu', 'blitz') }}' : '{{ __('Expand menu', 'blitz') }}'">
        <svg class="toggle-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  x-bind:d="expanded ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'"/>
        </svg>
    </button>
    @endif
    
    {{-- Actions Container --}}
    <div class="actions-container" 
         x-show="!expandable || expanded"
         x-transition>
        
        {{-- Back to Top --}}
        @if($showBackToTop)
        <button @click="scrollToTop()"
                x-show="showBackTop"
                x-transition
                class="action-btn action-back-top"
                aria-label="{{ __('Back to top', 'blitz') }}"
                title="{{ __('Back to top', 'blitz') }}">
            <svg class="action-icon" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
            <span class="action-label">{{ __('Top', 'blitz') }}</span>
        </button>
        @endif
        
        {{-- Theme Toggle --}}
        @if($showThemeToggle)
        <button @click="toggleTheme()"
                class="action-btn action-theme-toggle"
                :aria-label="'{{ __('Theme', 'blitz') }}: ' + currentTheme"
                title="{{ __('Switch theme', 'blitz') }}">
            <template x-if="currentTheme === 'light'">
                <svg class="action-icon" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </template>
            <template x-if="currentTheme === 'dark'">
                <svg class="action-icon" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </template>
            <template x-if="currentTheme === 'auto'">
                <svg class="action-icon" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </template>
            <span class="action-label">{{ __('Theme', 'blitz') }}</span>
        </button>
        @endif
        
        {{-- Divider --}}
        @if(($showBackToTop || $showThemeToggle) && ($showSocials || $showContact))
        <div class="action-divider"></div>
        @endif
        
        {{-- Social Links --}}
        @if($showSocials && !empty($socialLinks))
        <div class="action-group social-group">
            @foreach($socialLinks as $platform => $url)
            <a href="{{ $url }}"
               target="_blank"
               rel="noopener noreferrer"
               class="action-btn action-social action-{{ $platform }}"
               aria-label="{{ ucfirst($platform) }}"
               title="{{ ucfirst($platform) }}">
                @switch($platform)
                    @case('facebook')
                        <svg class="action-icon" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        @break
                    @case('instagram')
                        <svg class="action-icon" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                        </svg>
                        @break
                    @case('twitter')
                        <svg class="action-icon" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                        @break
                    @case('linkedin')
                        <svg class="action-icon" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        @break
                    @default
                        <span class="action-icon">{{ substr($platform, 0, 2) }}</span>
                @endswitch
                <span class="action-label">{{ ucfirst($platform) }}</span>
            </a>
            @endforeach
        </div>
        @endif
        
        {{-- Contact Button --}}
        @if($showContact && !empty($contactInfo['whatsapp']))
        <div class="action-divider"></div>
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactInfo['whatsapp']) }}"
           target="_blank"
           rel="noopener noreferrer"
           class="action-btn action-contact action-whatsapp"
           aria-label="{{ __('Contact us on WhatsApp', 'blitz') }}"
           title="{{ __('WhatsApp', 'blitz') }}">
            <svg class="action-icon" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
            </svg>
            <span class="action-label">{{ __('Chat', 'blitz') }}</span>
            <span class="action-badge">1</span>
        </a>
        @endif
    </div>
    
    {{-- Scroll Progress (for vertical layout) --}}
    @if($layout === 'vertical' && $showBackToTop)
    <div class="scroll-progress" x-show="scrollProgress > 0">
        <div class="progress-bar" :style="'height: ' + scrollProgress + '%'"></div>
    </div>
    @endif
</div>

{{-- CSS stays the same as before --}}
<style>
/* Base Board Styles */
.action-board {
    position: fixed;
    z-index: 50;
    transition: all 0.3s var(--ease-default);
}

/* Layout: Vertical Sidebar */
.action-board-vertical {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 0.75rem;
    background: var(--card-bg);
    border-radius: 1rem;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--border-light);
}

.action-board-vertical.action-board-right {
    right: 1.5rem;
    top: 50%;
    transform: translateY(-50%);
}

.action-board-vertical.action-board-left {
    left: 1.5rem;
    top: 50%;
    transform: translateY(-50%);
}

/* Layout: Horizontal Bar */
.action-board-horizontal {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: var(--card-bg);
    border-radius: 2rem;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--border-light);
}

.action-board-horizontal.action-board-bottom {
    bottom: 1.5rem;
    left: 50%;
    transform: translateX(-50%);
}

/* Layout: Compact (Floating Action Button style) */
.action-board-compact {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.action-board-compact .actions-container {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 0.5rem;
    background: var(--card-bg);
    border-radius: 2rem;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
}

/* Board Toggle Button */
.board-toggle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--gradient-primary);
    border: none;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 10px 25px -5px rgba(var(--primary-rgb), 0.3);
    transition: all 0.3s var(--ease-bounce);
    margin-bottom: 0.5rem;
}

.board-toggle:hover {
    transform: scale(1.1);
    box-shadow: 0 10px 25px -5px rgba(var(--primary-rgb), 0.4);
}

/* Action Button Base */
.action-btn {
    position: relative;
    width: 48px;
    height: 48px;
    border-radius: 12px;
    border: none;
    background: var(--bg-secondary);
    color: var(--text-primary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s var(--ease-default);
    text-decoration: none;
    overflow: hidden;
}

.action-btn:hover {
    background: var(--bg-tertiary);
    transform: translateX(-4px);
}

.action-btn:focus-visible {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}

/* Action Icons */
.action-icon {
    width: 20px;
    height: 20px;
    transition: transform 0.2s var(--ease-bounce);
}

.action-btn:hover .action-icon {
    transform: scale(1.15);
}

/* Action Labels (for expanded state) */
.action-label {
    position: absolute;
    left: 100%;
    margin-left: 0.75rem;
    background: var(--text-primary);
    color: var(--bg-primary);
    padding: 0.25rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s;
}

.action-board-vertical .action-btn:hover .action-label {
    opacity: 1;
}

/* Horizontal layout shows labels inline */
.action-board-horizontal .action-label {
    position: static;
    margin-left: 0.5rem;
    background: none;
    color: inherit;
    padding: 0;
    opacity: 1;
}

.action-board-horizontal .action-btn {
    width: auto;
    padding: 0.75rem 1rem;
    flex-direction: row;
    gap: 0.5rem;
}

/* Special Button Styles */
.action-back-top {
    background: var(--gradient-primary);
    color: white;
}

.action-theme-toggle {
    background: var(--gradient-accent);
    color: white;
}

.action-whatsapp {
    background: linear-gradient(135deg, #25D366, #128C7E);
    color: white;
}

.action-facebook {
    background: #1877F2;
    color: white;
}

.action-instagram {
    background: linear-gradient(135deg, #833AB4, #FD1D1D, #FCAF45);
    color: white;
}

.action-twitter {
    background: #1DA1F2;
    color: white;
}

.action-linkedin {
    background: #0A66C2;
    color: white;
}

/* Action Badge */
.action-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background: #ef4444;
    color: white;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

/* Divider */
.action-divider {
    width: 100%;
    height: 1px;
    background: var(--border-color);
    margin: 0.25rem 0;
}

.action-board-horizontal .action-divider {
    width: 1px;
    height: 24px;
    margin: 0 0.25rem;
}

/* Scroll Progress */
.scroll-progress {
    position: absolute;
    left: -4px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: var(--border-light);
    border-radius: 2px;
    overflow: hidden;
}

.progress-bar {
    width: 100%;
    background: var(--gradient-primary);
    transition: height 0.1s linear;
}

/* Collapsed State */
.action-board.is-collapsed .actions-container {
    display: none;
}

/* Hidden State (auto-hide) */
.action-board.is-hidden {
    transform: translateX(calc(100% + 2rem));
}

.action-board-left.is-hidden {
    transform: translateX(calc(-100% - 2rem));
}

/* Mobile Adjustments */
@media (max-width: 768px) {
    .action-board-vertical {
        right: 0.75rem;
    }
    
    .action-board-horizontal {
        bottom: 0.75rem;
        width: calc(100% - 1.5rem);
        left: 0.75rem;
        transform: none;
    }
    
    .action-btn {
        width: 40px;
        height: 40px;
    }
    
    .action-label {
        display: none;
    }
    
    .action-board-horizontal .action-btn {
        width: 40px;
        padding: 0;
    }
    
    .action-board-horizontal .action-label {
        display: none;
    }
}

/* Dark Mode */
[data-theme="dark"] .action-board {
    background: var(--bg-secondary);
    border-color: var(--border-color);
}

[data-theme="dark"] .action-btn {
    background: var(--bg-tertiary);
}

[data-theme="dark"] .action-btn:hover {
    background: var(--bg-primary);
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    .action-board,
    .action-btn,
    .action-icon {
        transition: none !important;
    }
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('actionBoard', (config = {}) => ({
        // State
        expanded: !config.expandable,
        hidden: false,
        scrolled: false,
        showBackTop: false,
        scrollProgress: 0,
        currentTheme: localStorage.getItem('blitz-theme-preference') || 'auto',
        lastScrollY: 0,
        
        // Init
        init() {
            this.setupScrollListener();
            this.setupThemeListener();
        },
        
        // Scroll handling
        setupScrollListener() {
            window.addEventListener('scroll', () => {
                const scrollY = window.pageYOffset;
                
                // Show/hide back to top
                this.showBackTop = scrollY > 300;
                
                // Calculate scroll progress
                const max = document.documentElement.scrollHeight - window.innerHeight;
                this.scrollProgress = (scrollY / max) * 100;
                
                // Auto-hide on scroll down (if enabled)
                if (config.autoHide) {
                    this.hidden = scrollY > this.lastScrollY && scrollY > 100;
                }
                
                this.lastScrollY = scrollY;
                this.scrolled = scrollY > 50;
            }, { passive: true });
        },
        
        // Theme handling
        setupThemeListener() {
            window.addEventListener('theme:changed', (e) => {
                this.currentTheme = e.detail.theme;
            });
        },
        
        // Actions
        toggleBoard() {
            this.expanded = !this.expanded;
        },
        
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        
        toggleTheme() {
            if (window.themeManager) {
                window.themeManager.cycleTheme();
            }
        }
    }));
});
</script>