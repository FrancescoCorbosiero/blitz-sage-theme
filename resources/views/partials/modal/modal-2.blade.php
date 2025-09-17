{{--
  Advanced Modal Component
  Full-featured modal with animations, sizes, and accessibility
--}}

@props([
    'name' => 'modal',                      // Unique modal identifier
    'size' => 'md',                         // xs, sm, md, lg, xl, full
    'position' => 'center',                 // center, top, bottom
    'backdrop' => 'blur',                   // blur, dark, light, none
    'closable' => true,                     // Allow closing
    'closeOnBackdrop' => true,              // Close when clicking backdrop
    'closeOnEscape' => true,                // Close on ESC key
    'persistent' => false,                  // Prevent closing (overrides closable)
    'title' => '',                          // Modal title
    'icon' => null,                         // Title icon
    'footer' => true,                       // Show footer slot
    'scrollable' => false,                  // Make content scrollable
    'fullscreen' => false,                  // Fullscreen mode
    'animation' => 'fade',                  // fade, slide, zoom, flip
])

@php
    // Size configurations
    $sizeClasses = match($size) {
        'xs' => 'max-w-sm',
        'sm' => 'max-w-md', 
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-none m-4',
        default => 'max-w-lg'
    };
    
    // Position classes
    $positionClasses = match($position) {
        'top' => 'items-start pt-16',
        'bottom' => 'items-end pb-16',
        default => 'items-center'
    };
    
    // Backdrop classes
    $backdropClasses = match($backdrop) {
        'blur' => 'bg-black/50 backdrop-blur-sm',
        'dark' => 'bg-black/75',
        'light' => 'bg-white/75',
        'none' => 'bg-transparent',
        default => 'bg-black/50 backdrop-blur-sm'
    };
    
    // Animation configurations
    $animationConfig = match($animation) {
        'slide' => [
            'enter' => 'transition ease-out duration-300',
            'enter_start' => 'opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-95',
            'enter_end' => 'opacity-100 transform translate-y-0 sm:scale-100',
            'leave' => 'transition ease-in duration-200',
            'leave_start' => 'opacity-100 transform translate-y-0 sm:scale-100', 
            'leave_end' => 'opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-95'
        ],
        'zoom' => [
            'enter' => 'transition ease-out duration-300',
            'enter_start' => 'opacity-0 transform scale-75',
            'enter_end' => 'opacity-100 transform scale-100',
            'leave' => 'transition ease-in duration-200',
            'leave_start' => 'opacity-100 transform scale-100',
            'leave_end' => 'opacity-0 transform scale-75'
        ],
        'flip' => [
            'enter' => 'transition ease-out duration-300',
            'enter_start' => 'opacity-0 transform rotateX-90',
            'enter_end' => 'opacity-100 transform rotateX-0',
            'leave' => 'transition ease-in duration-200', 
            'leave_start' => 'opacity-100 transform rotateX-0',
            'leave_end' => 'opacity-0 transform rotateX-90'
        ],
        default => [ // fade
            'enter' => 'transition ease-out duration-300',
            'enter_start' => 'opacity-0 transform scale-95',
            'enter_end' => 'opacity-100 transform scale-100',
            'leave' => 'transition ease-in duration-200',
            'leave_start' => 'opacity-100 transform scale-100',
            'leave_end' => 'opacity-0 transform scale-95'
        ]
    };
    
    $modalId = 'modal-' . $name;
@endphp

<div x-data="modalComponent('{{ $name }}', {{ $closeOnEscape ? 'true' : 'false' }}, {{ $persistent ? 'true' : 'false' }})"
     x-init="init()"
     x-show="$store.modal.isOpen('{{ $name }}')"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     aria-labelledby="{{ $modalId }}-title"
     aria-modal="true"
     role="dialog"
     @keydown.escape.window="handleEscape">

    {{-- Backdrop --}}
    <div class="fixed inset-0 {{ $backdropClasses }}"
         x-show="$store.modal.isOpen('{{ $name }}')"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @if($closeOnBackdrop && !$persistent)@click="$store.modal.close('{{ $name }}')"@endif>
    </div>

    {{-- Modal Container --}}
    <div class="flex min-h-full {{ $positionClasses }} justify-center p-4 text-center sm:p-0">
        
        {{-- Modal Panel --}}
        <div class="relative w-full {{ $fullscreen ? 'h-full' : $sizeClasses }} 
                    transform overflow-hidden rounded-2xl bg-card-bg shadow-2xl 
                    transition-all {{ $scrollable ? 'flex flex-col max-h-[90vh]' : '' }}"
             x-show="$store.modal.isOpen('{{ $name }}')"
             x-transition:enter="{{ $animationConfig['enter'] }}"
             x-transition:enter-start="{{ $animationConfig['enter_start'] }}"
             x-transition:enter-end="{{ $animationConfig['enter_end'] }}"
             x-transition:leave="{{ $animationConfig['leave'] }}"
             x-transition:leave-start="{{ $animationConfig['leave_start'] }}"
             x-transition:leave-end="{{ $animationConfig['leave_end'] }}"
             @click.stop>

            {{-- Header --}}
            @if($title || $closable)
                <div class="flex items-center justify-between p-6 border-b border-border-color {{ $scrollable ? 'flex-shrink-0' : '' }}">
                    @if($title || $icon)
                        <div class="flex items-center">
                            @if($icon)
                                <div class="flex-shrink-0 mr-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center">
                                        {!! $icon !!}
                                    </div>
                                </div>
                            @endif
                            
                            @if($title)
                                <h2 id="{{ $modalId }}-title" 
                                    class="text-xl font-semibold text-text-primary">
                                    {{ $title }}
                                </h2>
                            @endif
                        </div>
                    @endif

                    @if($closable && !$persistent)
                        <button type="button"
                                @click="$store.modal.close('{{ $name }}')"
                                class="ml-4 flex-shrink-0 p-2 text-text-muted hover:text-text-primary 
                                       hover:bg-bg-tertiary rounded-full transition-colors duration-200"
                                aria-label="{{ __('Close modal', 'blitz') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    @endif
                </div>
            @endif

            {{-- Content --}}
            <div class="p-6 {{ $scrollable ? 'flex-1 overflow-y-auto' : '' }}">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            @if($footer && isset($footer))
                <div class="flex justify-end space-x-3 p-6 border-t border-border-color bg-bg-secondary/50 {{ $scrollable ? 'flex-shrink-0' : '' }}">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Global Modal Store --}}
<script>
    document.addEventListener('alpine:init', () => {
        // Global modal store
        Alpine.store('modal', {
            modals: {},
            
            open(name, data = {}) {
                this.modals[name] = { open: true, data };
                document.body.style.overflow = 'hidden';
                this.trackEvent('modal_opened', name);
            },
            
            close(name) {
                if (this.modals[name]) {
                    this.modals[name].open = false;
                }
                
                // Check if any modals are still open
                const hasOpenModals = Object.values(this.modals).some(modal => modal.open);
                
                if (!hasOpenModals) {
                    document.body.style.overflow = '';
                }
                
                this.trackEvent('modal_closed', name);
            },
            
            toggle(name, data = {}) {
                if (this.isOpen(name)) {
                    this.close(name);
                } else {
                    this.open(name, data);
                }
            },
            
            isOpen(name) {
                return this.modals[name]?.open || false;
            },
            
            getData(name) {
                return this.modals[name]?.data || {};
            },
            
            closeAll() {
                Object.keys(this.modals).forEach(name => {
                    this.close(name);
                });
            },
            
            trackEvent(action, modalName) {
                if (typeof gtag !== 'undefined') {
                    gtag('event', action, {
                        'modal_name': modalName,
                        'event_category': 'ui_interaction'
                    });
                }
            }
        });
        
        // Individual modal component
        Alpine.data('modalComponent', (name, closeOnEscape = true, persistent = false) => ({
            name,
            closeOnEscape,
            persistent,
            
            init() {
                // Focus management
                this.$watch('$store.modal.isOpen(name)', (isOpen) => {
                    if (isOpen) {
                        this.handleOpen();
                    } else {
                        this.handleClose();
                    }
                });
                
                // Trap focus when modal is open
                this.$root.addEventListener('keydown', this.trapFocus.bind(this));
            },
            
            handleOpen() {
                // Set focus to first focusable element or close button
                this.$nextTick(() => {
                    const firstFocusable = this.getFirstFocusableElement();
                    if (firstFocusable) {
                        firstFocusable.focus();
                    }
                });
            },
            
            handleClose() {
                // Return focus to trigger element if it exists
                const trigger = document.querySelector(`[data-modal-trigger="${this.name}"]`);
                if (trigger) {
                    trigger.focus();
                }
            },
            
            handleEscape(event) {
                if (this.closeOnEscape && !this.persistent && this.$store.modal.isOpen(this.name)) {
                    this.$store.modal.close(this.name);
                }
            },
            
            trapFocus(event) {
                if (!this.$store.modal.isOpen(this.name) || event.key !== 'Tab') {
                    return;
                }
                
                const focusableElements = this.getFocusableElements();
                const firstFocusable = focusableElements[0];
                const lastFocusable = focusableElements[focusableElements.length - 1];
                
                if (event.shiftKey) {
                    if (document.activeElement === firstFocusable) {
                        event.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    if (document.activeElement === lastFocusable) {
                        event.preventDefault();
                        firstFocusable.focus();
                    }
                }
            },
            
            getFocusableElements() {
                const focusableSelectors = [
                    'button:not([disabled])',
                    'input:not([disabled])',
                    'textarea:not([disabled])',
                    'select:not([disabled])',
                    'a[href]',
                    '[tabindex]:not([tabindex="-1"])'
                ];
                
                return Array.from(this.$root.querySelectorAll(focusableSelectors.join(', ')));
            },
            
            getFirstFocusableElement() {
                const focusableElements = this.getFocusableElements();
                return focusableElements.length > 0 ? focusableElements[0] : null;
            }
        }));
    });
    
    // Global modal utilities
    window.Modal = {
        open: (name, data) => Alpine.store('modal').open(name, data),
        close: (name) => Alpine.store('modal').close(name),
        toggle: (name, data) => Alpine.store('modal').toggle(name, data),
        closeAll: () => Alpine.store('modal').closeAll(),
    };
    
    // Prevent body scroll when modal is open
    const originalBodyOverflow = document.body.style.overflow;
    
    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        document.body.style.overflow = originalBodyOverflow;
    });
</script>

<style>
    /* Custom scroll behavior for modal content */
    .modal-scrollable {
        scrollbar-width: thin;
        scrollbar-color: var(--text-muted) transparent;
    }
    
    .modal-scrollable::-webkit-scrollbar {
        width: 6px;
    }
    
    .modal-scrollable::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .modal-scrollable::-webkit-scrollbar-thumb {
        background-color: var(--text-muted);
        border-radius: 3px;
    }
    
    /* Animation enhancements */
    [x-cloak] {
        display: none !important;
    }
    
    /* Flip animation support */
    .transform {
        transform-style: preserve-3d;
    }
    
    .rotateX-90 {
        transform: rotateX(90deg);
    }
    
    .rotateX-0 {
        transform: rotateX(0deg);
    }
    
    /* Backdrop blur fallback */
    @supports not (backdrop-filter: blur(4px)) {
        .backdrop-blur-sm {
            background-color: rgba(0, 0, 0, 0.75);
        }
    }
    
    /* Dark mode enhancements */
    [data-theme="dark"] .bg-card-bg {
        @apply bg-gray-800 border-gray-700;
    }
    
    [data-theme="dark"] .border-border-color {
        @apply border-gray-700;
    }
    
    [data-theme="dark"] .bg-bg-secondary\/50 {
        @apply bg-gray-900/50;
    }
    
    /* Modal size responsive adjustments */
    @media (max-width: 640px) {
        .max-w-lg,
        .max-w-2xl,
        .max-w-4xl {
            max-width: calc(100vw - 2rem);
            margin: 1rem;
        }
    }
    
    /* Accessibility enhancements */
    .modal-panel:focus {
        outline: none;
    }
    
    /* Loading state for modal content */
    .modal-loading {
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-loading::before {
        content: '';
        width: 32px;
        height: 32px;
        border: 3px solid var(--primary);
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>

{{-- Helper Functions for Modal Usage --}}
@push('scripts')
<script>
    // Convenient modal trigger setup
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-setup modal triggers
        document.querySelectorAll('[data-modal-trigger]').forEach(trigger => {
            const modalName = trigger.getAttribute('data-modal-trigger');
            const modalData = trigger.hasAttribute('data-modal-data') 
                ? JSON.parse(trigger.getAttribute('data-modal-data')) 
                : {};
            
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                Modal.open(modalName, modalData);
            });
        });
        
        // Auto-setup modal close triggers
        document.querySelectorAll('[data-modal-close]').forEach(closer => {
            const modalName = closer.getAttribute('data-modal-close');
            
            closer.addEventListener('click', function(e) {
                e.preventDefault();
                if (modalName) {
                    Modal.close(modalName);
                } else {
                    Modal.closeAll();
                }
            });
        });
    });
    
    // Modal event system
    document.addEventListener('modal:open', function(e) {
        Modal.open(e.detail.name, e.detail.data);
    });
    
    document.addEventListener('modal:close', function(e) {
        Modal.close(e.detail.name);
    });
    
    // Dispatch custom events for integration
    document.addEventListener('alpine:init', () => {
        Alpine.store('modal').originalOpen = Alpine.store('modal').open;
        Alpine.store('modal').originalClose = Alpine.store('modal').close;
        
        Alpine.store('modal').open = function(name, data = {}) {
            this.originalOpen(name, data);
            document.dispatchEvent(new CustomEvent('modal:opened', { 
                detail: { name, data } 
            }));
        };
        
        Alpine.store('modal').close = function(name) {
            this.originalClose(name);
            document.dispatchEvent(new CustomEvent('modal:closed', { 
                detail: { name } 
            }));
        };
    });
</script>
@endpush