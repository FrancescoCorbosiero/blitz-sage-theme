{{--
  Universal Button Component
  Flexible button system supporting multiple variants, sizes, and states
--}}

@props([
    'variant' => 'primary',                 // primary, secondary, outline, ghost, danger, success
    'size' => 'md',                         // xs, sm, md, lg, xl
    'type' => 'button',                     // button, submit, reset
    'href' => null,                         // If provided, renders as link
    'target' => null,                       // Link target (_blank, etc.)
    'disabled' => false,                    // Disabled state
    'loading' => false,                     // Loading state with spinner
    'loadingText' => '',                    // Text to show when loading
    'icon' => null,                         // Icon component/SVG
    'iconPosition' => 'left',               // left, right, only
    'rounded' => null,                      // Override default roundedness
    'fullWidth' => false,                   // Full width button
    'animated' => true,                     // Hover animations
    'gradient' => false,                    // Use gradient background
    'shadow' => null,                       // Custom shadow (sm, md, lg, xl, none)
    'glowing' => false,                     // Glowing effect on hover
])

@php
    // Variant configurations
    $variants = [
        'primary' => [
            'base' => 'bg-primary text-white border-primary',
            'hover' => 'hover:bg-primary-dark hover:border-primary-dark',
            'focus' => 'focus:ring-primary/20',
            'disabled' => 'disabled:bg-primary/50 disabled:border-primary/50',
            'gradient' => 'bg-gradient-to-r from-primary to-primary-dark',
        ],
        'secondary' => [
            'base' => 'bg-bg-secondary text-text-primary border-border-color',
            'hover' => 'hover:bg-bg-tertiary hover:border-primary/20',
            'focus' => 'focus:ring-primary/20',
            'disabled' => 'disabled:bg-bg-secondary/50 disabled:text-text-muted',
            'gradient' => 'bg-gradient-to-r from-bg-secondary to-bg-tertiary',
        ],
        'outline' => [
            'base' => 'bg-transparent text-primary border-primary',
            'hover' => 'hover:bg-primary hover:text-white',
            'focus' => 'focus:ring-primary/20',
            'disabled' => 'disabled:border-primary/50 disabled:text-primary/50',
            'gradient' => 'bg-gradient-to-r from-primary/10 to-primary-soft/10 border-primary',
        ],
        'ghost' => [
            'base' => 'bg-transparent text-text-primary border-transparent',
            'hover' => 'hover:bg-bg-tertiary hover:text-primary',
            'focus' => 'focus:ring-primary/20',
            'disabled' => 'disabled:text-text-muted',
            'gradient' => 'bg-gradient-to-r from-transparent to-bg-tertiary/50',
        ],
        'danger' => [
            'base' => 'bg-red-600 text-white border-red-600',
            'hover' => 'hover:bg-red-700 hover:border-red-700',
            'focus' => 'focus:ring-red-600/20',
            'disabled' => 'disabled:bg-red-600/50 disabled:border-red-600/50',
            'gradient' => 'bg-gradient-to-r from-red-600 to-red-700',
        ],
        'success' => [
            'base' => 'bg-green-600 text-white border-green-600',
            'hover' => 'hover:bg-green-700 hover:border-green-700',
            'focus' => 'focus:ring-green-600/20',
            'disabled' => 'disabled:bg-green-600/50 disabled:border-green-600/50',
            'gradient' => 'bg-gradient-to-r from-green-600 to-green-700',
        ],
    ];

    // Size configurations
    $sizes = [
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        'xl' => 'px-8 py-4 text-lg',
    ];

    // Icon sizes
    $iconSizes = [
        'xs' => 'w-3 h-3',
        'sm' => 'w-4 h-4', 
        'md' => 'w-4 h-4',
        'lg' => 'w-5 h-5',
        'xl' => 'w-6 h-6',
    ];

    // Shadow configurations
    $shadows = [
        'none' => '',
        'sm' => 'shadow-sm',
        'md' => 'shadow-md',
        'lg' => 'shadow-lg',
        'xl' => 'shadow-xl',
    ];

    // Get variant config
    $variantConfig = $variants[$variant] ?? $variants['primary'];
    
    // Build base classes
    $baseClasses = collect([
        'inline-flex items-center justify-center',
        'border font-medium',
        'transition-all duration-200',
        'focus:outline-none focus:ring-2 focus:ring-offset-2',
        'disabled:cursor-not-allowed disabled:opacity-60',
        $fullWidth ? 'w-full' : '',
        $sizes[$size] ?? $sizes['md'],
        $gradient ? $variantConfig['gradient'] : $variantConfig['base'],
        $variantConfig['hover'],
        $variantConfig['focus'],
        $variantConfig['disabled'],
        $rounded ?? ($size === 'xs' || $size === 'sm' ? 'rounded-md' : 'rounded-lg'),
        $shadow ? $shadows[$shadow] : ($variant === 'primary' ? 'shadow-sm' : ''),
        $animated ? 'transform hover:scale-105 active:scale-95' : '',
        $glowing ? 'hover:shadow-lg hover:shadow-primary/25' : '',
    ])->filter()->implode(' ');

    // Loading spinner size
    $spinnerSize = $iconSizes[$size] ?? $iconSizes['md'];
    
    // Final content
    $content = $slot->isNotEmpty() ? $slot : '';
    
    // Determine if we need spacing for icon + text
    $hasText = $content || ($loading && $loadingText);
    $iconSpacing = match($iconPosition) {
        'left' => $hasText ? 'mr-2' : '',
        'right' => $hasText ? 'ml-2' : '',
        'only' => '',
        default => $hasText ? 'mr-2' : ''
    };
@endphp

@php
    // Button content logic
    $buttonContent = function() use ($loading, $loadingText, $icon, $iconPosition, $content, $iconSizes, $size, $iconSpacing, $spinnerSize) {
        if ($loading) {
            // Loading state
            $output = '<svg class="' . $spinnerSize . ' animate-spin ' . $iconSpacing . '" fill="none" viewBox="0 0 24 24">';
            $output .= '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>';
            $output .= '<path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>';
            $output .= '</svg>';
            
            if ($loadingText) {
                $output .= $loadingText;
            } elseif ($iconPosition !== 'only' && $content) {
                $output .= $content;
            }
            
            return $output;
        } else {
            // Normal state
            $output = '';
            $hasText = $content || ($loading && $loadingText);
            
            // Left Icon
            if ($icon && $iconPosition === 'left') {
                $iconSize = $iconSizes[$size] ?? $iconSizes['md'];
                $spacing = $hasText ? 'mr-2' : '';
                $output .= '<span class="' . $iconSize . ' ' . $spacing . '">' . $icon . '</span>';
            }
            
            // Button Text
            if ($iconPosition !== 'only' && $content) {
                $output .= $content;
            }
            
            // Right Icon
            if ($icon && $iconPosition === 'right') {
                $iconSize = $iconSizes[$size] ?? $iconSizes['md'];
                $spacing = $hasText ? 'ml-2' : '';
                $output .= '<span class="' . $iconSize . ' ' . $spacing . '">' . $icon . '</span>';
            }
            
            // Icon Only
            if ($icon && $iconPosition === 'only') {
                $iconSize = $iconSizes[$size] ?? $iconSizes['md'];
                $output .= '<span class="' . $iconSize . '">' . $icon . '</span>';
            }
            
            return $output;
        }
    };
@endphp

@if($href && !$disabled)
    <a href="{{ $href }}" 
       @if($target) target="{{ $target }}" @endif
       {{ $attributes->merge(['class' => $baseClasses]) }}
       @if($target === '_blank') rel="noopener noreferrer" @endif>
        {!! $buttonContent() !!}
    </a>
@else
    <button type="{{ $type }}"
            {{ $attributes->merge(['class' => $baseClasses]) }}
            @if($disabled || $loading) disabled @endif
            x-data="buttonComponent"
            @click="handleClick">
        {!! $buttonContent() !!}
    </button>
@endif

<style>
    /* Glowing effect */
    .hover\:shadow-primary\/25:hover {
        box-shadow: 0 10px 25px -3px rgba(74, 124, 40, 0.25), 0 4px 6px -2px rgba(74, 124, 40, 0.05);
    }
    
    /* Enhanced focus states for accessibility */
    .focus\:ring-primary\/20:focus {
        ring-color: rgba(74, 124, 40, 0.2);
    }
    
    .focus\:ring-red-600\/20:focus {
        ring-color: rgba(220, 38, 38, 0.2);
    }
    
    .focus\:ring-green-600\/20:focus {
        ring-color: rgba(22, 163, 74, 0.2);
    }
    
    /* Dark mode adjustments */
    [data-theme="dark"] .bg-bg-secondary {
        @apply bg-gray-800;
    }
    
    [data-theme="dark"] .hover\:bg-bg-tertiary:hover {
        @apply bg-gray-700;
    }
    
    [data-theme="dark"] .text-text-primary {
        @apply text-gray-100;
    }
    
    [data-theme="dark"] .border-border-color {
        @apply border-gray-600;
    }

    /* Gradient button enhancements */
    .bg-gradient-to-r.from-primary.to-primary-dark {
        background-size: 200% 100%;
        background-position: 100% 0;
        transition: background-position 0.3s ease;
    }
    
    .bg-gradient-to-r.from-primary.to-primary-dark:hover {
        background-position: 0 0;
    }

    /* Button group support */
    .btn-group .inline-flex:not(:first-child) {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        margin-left: -1px;
    }
    
    .btn-group .inline-flex:not(:last-child) {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('buttonComponent', () => ({
            clicked: false,
            
            handleClick(event) {
                // Prevent double-clicks
                if (this.clicked) {
                    event.preventDefault();
                    return false;
                }
                
                // Add click animation
                this.clicked = true;
                
                // Reset click state
                setTimeout(() => {
                    this.clicked = false;
                }, 300);
                
                // Track button clicks
                this.trackClick();
            },
            
            trackClick() {
                const buttonText = this.$root.textContent?.trim() || 'Button';
                const buttonVariant = '{{ $variant }}';
                
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'button_click', {
                        'button_text': buttonText,
                        'button_variant': buttonVariant,
                        'event_category': 'ui_interaction'
                    });
                }
                
                console.log('Button clicked:', buttonText, buttonVariant);
            }
        }));
    });
    
    // Button ripple effect (optional enhancement)
    document.addEventListener('click', function(e) {
        const button = e.target.closest('button, a[role="button"]');
        if (!button || button.disabled) return;
        
        const rect = button.getBoundingClientRect();
        const ripple = document.createElement('span');
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
            z-index: 1;
        `;
        
        button.style.position = 'relative';
        button.style.overflow = 'hidden';
        button.appendChild(ripple);
        
        // Remove ripple after animation
        setTimeout(() => ripple.remove(), 600);
    });
    
    // Add ripple keyframes
    if (!document.querySelector('#button-ripple-styles')) {
        const style = document.createElement('style');
        style.id = 'button-ripple-styles';
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(2);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }
</script>