{{-- resources/views/components/back-to-top.blade.php --}}

@php
    $showAfter = $showAfter ?? 300;
    $position = $position ?? 'right'; // 'left' or 'right'
    $style = $style ?? 'circular'; // 'circular' or 'square'
@endphp

<button 
    id="back-to-top"
    class="back-to-top back-to-top-{{ $position }} back-to-top-{{ $style }}"
    aria-label="{{ __('Back to top', 'blitz') }}"
    x-data="{ visible: false, scrollProgress: 0 }"
    x-init="
        window.addEventListener('scroll', () => {
            visible = window.pageYOffset > {{ $showAfter }};
            const max = document.documentElement.scrollHeight - window.innerHeight;
            scrollProgress = (window.pageYOffset / max) * 100;
        }, { passive: true })
    "
    x-show="visible"
    x-transition
    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
    style="display: none;">
    
    {{-- Progress Ring --}}
    <svg class="progress-ring" width="48" height="48">
        <circle cx="24" cy="24" r="20" stroke-width="3" fill="none" class="progress-bg"/>
        <circle cx="24" cy="24" r="20" stroke-width="3" fill="none" class="progress-fill"
                :style="`stroke-dasharray: 126; stroke-dashoffset: ${126 - (scrollProgress * 1.26)}`"/>
    </svg>
    
    {{-- Arrow Icon --}}
    <svg class="arrow-icon" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
    </svg>
</button>

<style>
.back-to-top {
    position: fixed;
    bottom: 2rem;
    width: 48px;
    height: 48px;
    background: var(--gradient-primary);
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 25px -5px rgba(var(--primary-rgb), 0.25);
    transition: all 0.3s var(--ease-default);
    z-index: 40;
}

.back-to-top-right { right: 2rem; }
.back-to-top-left { left: 2rem; }
.back-to-top-circular { border-radius: 50%; }
.back-to-top-square { border-radius: 0.75rem; }

.back-to-top:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(var(--primary-rgb), 0.35);
}

.back-to-top:focus-visible {
    outline: 2px solid var(--primary);
    outline-offset: 4px;
}

.progress-ring {
    position: absolute;
    transform: rotate(-90deg);
}

.progress-bg {
    stroke: rgba(255, 255, 255, 0.2);
}

.progress-fill {
    stroke: white;
    transition: stroke-dashoffset 0.1s linear;
}

.arrow-icon {
    position: relative;
    z-index: 1;
    color: white;
}

@media (max-width: 768px) {
    .back-to-top {
        bottom: 1rem;
        right: 1rem !important;
        left: auto !important;
    }
}

[data-theme="dark"] .back-to-top {
    background: var(--gradient-accent);
}
</style>