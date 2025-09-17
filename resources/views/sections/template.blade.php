{{-- Enhanced block template --}}
@php
$blockId = $blockId ?? uniqid('block-');
$blockClasses = implode(' ', [
    'block',
    "block-{$blockType ?? 'default'}",
    $theme ?? '',
    $spacing ?? 'py-16',
    $animation ?? ''
]);
@endphp

<section id="{{ $blockId }}" 
         class="{{ $blockClasses }}"
         x-data="block_{{ str_replace('-', '_', $blockType) }}(@json($data ?? []))"
         x-init="init()"
         @if($animation) data-aos="{{ $animation }}" @endif>
    
    {{-- Block Content --}}
    @yield('block-content')
    
</section>

{{-- Scoped Styles --}}
@push('block-styles')
<style>
    #{{ $blockId }} {
        /* Block-specific styles */
        @yield('block-styles')
    }
</style>
@endpush

{{-- Block Script --}}
@push('block-scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('block_{{ str_replace('-', '_', $blockType) }}', (data = {}) => ({
        ...data,
        blockId: '{{ $blockId }}',
        
        init() {
            this.setupBlock();
            @yield('block-init')
        },
        
        setupBlock() {
            // Common block initialization
            if (window.BlockUtils) {
                window.BlockUtils.trackEvent('block', 'view', '{{ $blockType }}');
            }
        },
        
        @yield('block-methods')
    }));
});
</script>
@endpush