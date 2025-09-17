{{-- resources/views/partials/popover.blade.php --}}
{{-- 
    Reusable Popover Component
    
    Usage:
    @include('partials.popover', [
        'trigger' => 'hover', // hover, click, focus
        'position' => 'top', // top, bottom, left, right
        'title' => 'Informazioni',
        'content' => 'Contenuto del popover'
    ])
--}}

@props([
    'id' => 'popover-' . uniqid(),
    'trigger' => 'hover',
    'position' => 'top',
    'title' => '',
    'content' => '',
    'arrow' => true,
    'maxWidth' => '320px',
])

<div x-data="{
        open: false,
        trigger: '{{ $trigger }}',
        position: '{{ $position }}',
        
        handleHover() {
            if (this.trigger === 'hover') {
                this.open = true;
            }
        },
        
        handleLeave() {
            if (this.trigger === 'hover') {
                setTimeout(() => {
                    this.open = false;
                }, 200);
            }
        },
        
        handleClick() {
            if (this.trigger === 'click') {
                this.open = !this.open;
            }
        },
        
        handleFocus() {
            if (this.trigger === 'focus') {
                this.open = true;
            }
        },
        
        handleBlur() {
            if (this.trigger === 'focus') {
                this.open = false;
            }
        }
    }"
    @mouseenter="handleHover()"
    @mouseleave="handleLeave()"
    @click="handleClick()"
    @focus="handleFocus()"
    @blur="handleBlur()"
    @click.away="open = false"
    class="popover-container relative inline-block">
    
    {{-- Trigger Element --}}
    <div class="popover-trigger">
        {{ $trigger_content ?? '' }}
        @if(!isset($trigger_content))
        <button type="button" class="popover-trigger-button">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </button>
        @endif
    </div>
    
    {{-- Popover Content --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="popover popover-{{ $position }}"
         style="display: none; max-width: {{ $maxWidth }};"
         @mouseenter="trigger === 'hover' ? open = true : null"
         @mouseleave="trigger === 'hover' ? open = false : null">
        
        @if($arrow)
        <div class="popover-arrow popover-arrow-{{ $position }}"></div>
        @endif
        
        @if($title)
        <div class="popover-header">
            <h4 class="popover-title">{{ $title }}</h4>
            @if($trigger === 'click')
            <button @click="open = false" class="popover-close">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            @endif
        </div>
        @endif
        
        <div class="popover-body">
            {{ $content }}
            {{ $slot ?? '' }}
        </div>
    </div>
</div>

<style>
/* Popover Container */
.popover-container {
    position: relative;
    display: inline-block;
}

/* Trigger Button */
.popover-trigger-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 50%;
    color: var(--text-secondary);
    transition: all 0.2s ease;
}

.popover-trigger-button:hover {
    background: rgba(0, 0, 0, 0.05);
    color: var(--primary);
}

/* Popover */
.popover {
    position: absolute;
    z-index: 1000;
    background: var(--bg-secondary, #ffffff);
    border-radius: 12px;
    box-shadow: 
        0 10px 25px -5px rgba(0, 0, 0, 0.1),
        0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border: 1px solid var(--border-color, #e8e8e0);
}

/* Position Variants */
.popover-top {
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    margin-bottom: 0.5rem;
}

.popover-bottom {
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    margin-top: 0.5rem;
}

.popover-left {
    right: 100%;
    top: 50%;
    transform: translateY(-50%);
    margin-right: 0.5rem;
}

.popover-right {
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    margin-left: 0.5rem;
}

/* Arrow */
.popover-arrow {
    position: absolute;
    width: 0.75rem;
    height: 0.75rem;
    background: var(--bg-secondary, #ffffff);
    border: 1px solid var(--border-color, #e8e8e0);
    transform: rotate(45deg);
}

.popover-arrow-top {
    bottom: -0.375rem;
    left: 50%;
    transform: translateX(-50%) rotate(45deg);
    border-top: none;
    border-left: none;
}

.popover-arrow-bottom {
    top: -0.375rem;
    left: 50%;
    transform: translateX(-50%) rotate(45deg);
    border-bottom: none;
    border-right: none;
}

.popover-arrow-left {
    right: -0.375rem;
    top: 50%;
    transform: translateY(-50%) rotate(45deg);
    border-left: none;
    border-bottom: none;
}

.popover-arrow-right {
    left: -0.375rem;
    top: 50%;
    transform: translateY(-50%) rotate(45deg);
    border-right: none;
    border-top: none;
}

/* Header */
.popover-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 1rem;
    border-bottom: 1px solid var(--border-color, #e8e8e0);
}

.popover-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
}

.popover-close {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.25rem;
    height: 1.25rem;
    border-radius: 0.25rem;
    color: var(--text-secondary);
    transition: all 0.2s ease;
}

.popover-close:hover {
    background: rgba(0, 0, 0, 0.05);
}

/* Body */
.popover-body {
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
    line-height: 1.5;
}

/* Dark Mode */
[data-theme="dark"] .popover {
    background: #1a1f2e;
    border-color: #2a2f3a;
}

[data-theme="dark"] .popover-arrow {
    background: #1a1f2e;
    border-color: #2a2f3a;
}

[data-theme="dark"] .popover-header {
    border-color: #2a2f3a;
}

[data-theme="dark"] .popover-trigger-button:hover,
[data-theme="dark"] .popover-close:hover {
    background: rgba(255, 255, 255, 0.05);
}
</style>