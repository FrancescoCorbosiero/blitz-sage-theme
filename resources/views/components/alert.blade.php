{{--
  Enhanced Alert Component
  Flexible alert system with multiple types, animations, and interactions
--}}

@props([
    'type' => 'info',                       // info, success, warning, error, custom
    'title' => '',                          // Alert title (optional)
    'message' => '',                        // Alert message
    'dismissible' => false,                 // Show close button
    'icon' => true,                         // Show icon
    'border' => true,                       // Show border
    'rounded' => true,                      // Rounded corners
    'shadow' => true,                       // Drop shadow
    'animated' => true,                     // Entrance animation
    'autoHide' => false,                    // Auto hide after delay
    'hideDelay' => 5000,                    // Auto hide delay (ms)
    'actions' => null,                      // Action buttons array
    'progress' => false,                    // Show progress bar (for auto-hide)
])

@php
    // Type-based styling
    $typeConfig = match($type) {
        'success' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-200',
            'text' => 'text-green-800',
            'icon_bg' => 'bg-green-100',
            'icon_color' => 'text-green-600',
            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'progress' => 'bg-green-600'
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'border' => 'border-yellow-200', 
            'text' => 'text-yellow-800',
            'icon_bg' => 'bg-yellow-100',
            'icon_color' => 'text-yellow-600',
            'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z',
            'progress' => 'bg-yellow-600'
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'text' => 'text-red-800', 
            'icon_bg' => 'bg-red-100',
            'icon_color' => 'text-red-600',
            'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
            'progress' => 'bg-red-600'
        ],
        'info' => [
            'bg' => 'bg-blue-50',
            'border' => 'border-blue-200',
            'text' => 'text-blue-800',
            'icon_bg' => 'bg-blue-100', 
            'icon_color' => 'text-blue-600',
            'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'progress' => 'bg-blue-600'
        ],
        default => [
            'bg' => 'bg-gray-50',
            'border' => 'border-gray-200',
            'text' => 'text-gray-800',
            'icon_bg' => 'bg-gray-100',
            'icon_color' => 'text-gray-600', 
            'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'progress' => 'bg-gray-600'
        ]
    };

    // Dark mode variants
    $darkConfig = match($type) {
        'success' => [
            'bg' => '[data-theme="dark"] &:bg-green-900/50',
            'border' => '[data-theme="dark"] &:border-green-700/50',
            'text' => '[data-theme="dark"] &:text-green-300'
        ],
        'warning' => [
            'bg' => '[data-theme="dark"] &:bg-yellow-900/50',
            'border' => '[data-theme="dark"] &:border-yellow-700/50', 
            'text' => '[data-theme="dark"] &:text-yellow-300'
        ],
        'error' => [
            'bg' => '[data-theme="dark"] &:bg-red-900/50',
            'border' => '[data-theme="dark"] &:border-red-700/50',
            'text' => '[data-theme="dark"] &:text-red-300'
        ],
        'info' => [
            'bg' => '[data-theme="dark"] &:bg-blue-900/50',
            'border' => '[data-theme="dark"] &:border-blue-700/50',
            'text' => '[data-theme="dark"] &:text-blue-300'
        ],
        default => [
            'bg' => '[data-theme="dark"] &:bg-gray-800/50',
            'border' => '[data-theme="dark"] &:border-gray-600/50',
            'text' => '[data-theme="dark"] &:text-gray-300'
        ]
    };

    // Build classes
    $classes = collect([
        'alert-component',
        'relative',
        'p-4',
        $typeConfig['bg'],
        $typeConfig['text'],
        $border ? $typeConfig['border'] . ' border' : '',
        $rounded ? 'rounded-lg' : '',
        $shadow ? 'shadow-sm' : '',
        $animated ? 'transform transition-all duration-300 ease-out' : ''
    ])->filter()->implode(' ');

    // Final message content
    $finalMessage = $message ?: $slot;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}
     x-data="alertComponent({{ $autoHide }}, {{ $hideDelay }})"
     x-init="init()"
     x-show="visible"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-95 translate-y-2"
     x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200" 
     x-transition:leave-start="opacity-100 transform scale-100"
     x-transition:leave-end="opacity-0 transform scale-95"
     role="alert"
     aria-live="polite">

    {{-- Progress bar (for auto-hide) --}}
    @if($progress && $autoHide)
        <div class="absolute top-0 left-0 h-1 {{ $typeConfig['progress'] }} rounded-t-lg transition-all duration-100 ease-linear"
             x-show="autoHide && visible"
             :style="{ width: progressWidth + '%' }"></div>
    @endif

    <div class="flex items-start">
        {{-- Icon --}}
        @if($icon)
            <div class="flex-shrink-0">
                <div class="w-8 h-8 {{ $typeConfig['icon_bg'] }} rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 {{ $typeConfig['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeConfig['icon'] }}"/>
                    </svg>
                </div>
            </div>
        @endif

        {{-- Content --}}
        <div class="flex-1 {{ $icon ? 'ml-3' : '' }}">
            @if($title)
                <h3 class="text-sm font-semibold mb-1">
                    {{ $title }}
                </h3>
            @endif

            <div class="text-sm {{ $title ? '' : 'font-medium' }}">
                {!! $finalMessage !!}
            </div>

            {{-- Action buttons --}}
            @if($actions)
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach($actions as $action)
                        <button type="button"
                                @if(isset($action['click'])) @click="{{ $action['click'] }}" @endif
                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md 
                                       {{ $action['style'] ?? 'bg-white/80 hover:bg-white border border-gray-300 text-gray-700' }} 
                                       transition-colors duration-200">
                            @if(isset($action['icon']))
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"/>
                                </svg>
                            @endif
                            {{ $action['text'] }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Dismiss button --}}
        @if($dismissible)
            <div class="flex-shrink-0 ml-3">
                <button type="button" 
                        @click="dismiss"
                        class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 
                               {{ $typeConfig['text'] }} hover:bg-black/5 focus:ring-{{ substr($typeConfig['icon_color'], 5) }}"
                        aria-label="{{ __('Dismiss alert', 'blitz') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif
    </div>
</div>

<style>
    /* Dark mode overrides */
    [data-theme="dark"] .alert-component.bg-green-50 {
        @apply bg-green-900/50 border-green-700/50 text-green-300;
    }
    
    [data-theme="dark"] .alert-component.bg-yellow-50 {
        @apply bg-yellow-900/50 border-yellow-700/50 text-yellow-300;
    }
    
    [data-theme="dark"] .alert-component.bg-red-50 {
        @apply bg-red-900/50 border-red-700/50 text-red-300;
    }
    
    [data-theme="dark"] .alert-component.bg-blue-50 {
        @apply bg-blue-900/50 border-blue-700/50 text-blue-300;
    }
    
    [data-theme="dark"] .alert-component.bg-gray-50 {
        @apply bg-gray-800/50 border-gray-600/50 text-gray-300;
    }

    /* Icon background adjustments for dark mode */
    [data-theme="dark"] .alert-component .bg-green-100 {
        @apply bg-green-800/50;
    }
    
    [data-theme="dark"] .alert-component .bg-yellow-100 {
        @apply bg-yellow-800/50;
    }
    
    [data-theme="dark"] .alert-component .bg-red-100 {
        @apply bg-red-800/50;
    }
    
    [data-theme="dark"] .alert-component .bg-blue-100 {
        @apply bg-blue-800/50;
    }
    
    [data-theme="dark"] .alert-component .bg-gray-100 {
        @apply bg-gray-700/50;
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('alertComponent', (autoHide = false, hideDelay = 5000) => ({
            visible: true,
            autoHide,
            hideDelay,
            progressWidth: 100,
            progressInterval: null,
            
            init() {
                if (this.autoHide) {
                    this.startAutoHide();
                }
            },
            
            dismiss() {
                this.visible = false;
                this.clearAutoHide();
                
                // Remove element from DOM after transition
                setTimeout(() => {
                    this.$root.remove();
                }, 300);
                
                // Track dismissal
                this.trackEvent('alert_dismissed');
            },
            
            startAutoHide() {
                const interval = 100; // Update every 100ms
                const steps = this.hideDelay / interval;
                const stepSize = 100 / steps;
                
                this.progressInterval = setInterval(() => {
                    this.progressWidth -= stepSize;
                    
                    if (this.progressWidth <= 0) {
                        this.dismiss();
                    }
                }, interval);
            },
            
            clearAutoHide() {
                if (this.progressInterval) {
                    clearInterval(this.progressInterval);
                    this.progressInterval = null;
                }
            },
            
            pauseAutoHide() {
                this.clearAutoHide();
            },
            
            resumeAutoHide() {
                if (this.autoHide && this.visible) {
                    this.startAutoHide();
                }
            },
            
            trackEvent(action) {
                if (typeof gtag !== 'undefined') {
                    gtag('event', action, {
                        'alert_type': '{{ $type }}',
                        'event_category': 'ui_interaction'
                    });
                }
            }
        }));
    });
</script>