{{-- resources/views/partials/dropdown.blade.php --}}
{{-- 
    Reusable Dropdown Menu Component
    
    Usage:
    @include('partials.dropdown', [
        'trigger' => 'Options',
        'position' => 'bottom-right', // bottom-left, top-right, top-left
        'items' => [
            ['label' => 'Edit', 'icon' => 'edit', 'action' => '#'],
            ['label' => 'Delete', 'icon' => 'trash', 'action' => '#', 'danger' => true],
        ]
    ])
--}}

@props([
    'id' => 'dropdown-' . uniqid(),
    'trigger' => 'Options',
    'position' => 'bottom-right',
    'items' => [],
    'icon' => true,
    'dividers' => false,
])

<div x-data="{ open: false }" 
     @click.away="open = false"
     @keydown.escape="open = false"
     class="dropdown-wrapper relative">
    
    {{-- Trigger Button --}}
    <button @click="open = !open"
            :aria-expanded="open"
            class="dropdown-trigger"
            type="button">
        
        @if(isset($trigger_slot))
            {{ $trigger_slot }}
        @else
            <span>{{ $trigger }}</span>
            <svg class="dropdown-chevron" :class="{ 'rotate-180': open }" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        @endif
    </button>
    
    {{-- Dropdown Menu --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="dropdown-menu dropdown-{{ $position }}"
         style="display: none;">
        
        @if(!empty($items))
            @foreach($items as $index => $item)
                @if(isset($item['divider']) && $item['divider'])
                    <div class="dropdown-divider"></div>
                @else
                    <a href="{{ $item['action'] ?? '#' }}"
                       @if(isset($item['onclick']))
                           onclick="{{ $item['onclick'] }}"
                       @endif
                       class="dropdown-item {{ isset($item['danger']) && $item['danger'] ? 'dropdown-item-danger' : '' }}">
                        
                        @if($icon && isset($item['icon']))
                            @switch($item['icon'])
                                @case('edit')
                                    <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    @break
                                @case('trash')
                                    <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    @break
                                @case('download')
                                    <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    @break
                                @case('share')
                                    <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m9.032 4.026a3 3 0 10-4.42 4.42l1.232-1.232a3 3 0 01-4.24-4.24l.83.83m1.588 1.588l7.07-7.07m0 0L18.75 5.25m1.25 1.25v5.25m0-5.25h-5.25"/>
                                    </svg>
                                    @break
                                @case('settings')
                                    <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    @break
                                @default
                                    @if(isset($item['emoji']))
                                        <span class="dropdown-item-emoji">{{ $item['emoji'] }}</span>
                                    @endif
                            @endswitch
                        @endif
                        
                        <span>{{ $item['label'] }}</span>
                        
                        @if(isset($item['badge']))
                            <span class="dropdown-item-badge">{{ $item['badge'] }}</span>
                        @endif
                    </a>
                @endif
            @endforeach
        @else
            {{ $slot ?? '' }}
        @endif
    </div>
</div>

<style>
/* Dropdown Wrapper */
.dropdown-wrapper {
    position: relative;
    display: inline-block;
}

/* Trigger Button */
.dropdown-trigger {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    background: var(--bg-secondary, #ffffff);
    color: var(--text-primary);
    font-weight: 500;
    font-size: 0.9375rem;
    border: 1px solid var(--border-color, #e8e8e0);
    border-radius: 12px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.dropdown-trigger:hover {
    background: var(--bg-tertiary, #f5f5f5);
    border-color: var(--primary-soft);
}

.dropdown-chevron {
    width: 1rem;
    height: 1rem;
    transition: transform 0.2s ease;
}

/* Dropdown Menu */
.dropdown-menu {
    position: absolute;
    z-index: 1000;
    min-width: 12rem;
    padding: 0.5rem;
    background: var(--bg-secondary, #ffffff);
    border: 1px solid var(--border-color, #e8e8e0);
    border-radius: 12px;
    box-shadow: 
        0 10px 25px -5px rgba(0, 0, 0, 0.1),
        0 10px 10px -5px rgba(0, 0, 0, 0.04);
    margin-top: 0.5rem;
}

/* Position Variants */
.dropdown-bottom-right {
    top: 100%;
    right: 0;
}

.dropdown-bottom-left {
    top: 100%;
    left: 0;
}

.dropdown-top-right {
    bottom: 100%;
    right: 0;
    margin-top: 0;
    margin-bottom: 0.5rem;
}

.dropdown-top-left {
    bottom: 100%;
    left: 0;
    margin-top: 0;
    margin-bottom: 0.5rem;
}

/* Dropdown Item */
.dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.625rem 0.75rem;
    color: var(--text-primary);
    font-size: 0.9375rem;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.2s ease;
    text-decoration: none;
}

.dropdown-item:hover {
    background: var(--bg-tertiary, #f5f5f5);
    color: var(--primary);
}

/* Danger Item */
.dropdown-item-danger {
    color: #dc2626;
}

.dropdown-item-danger:hover {
    background: #fee2e2;
    color: #b91c1c;
}

/* Item Icon */
.dropdown-item-icon {
    width: 1.25rem;
    height: 1.25rem;
    flex-shrink: 0;
    opacity: 0.7;
}

.dropdown-item:hover .dropdown-item-icon {
    opacity: 1;
}

.dropdown-item-emoji {
    font-size: 1.25rem;
    width: 1.25rem;
    height: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Item Badge */
.dropdown-item-badge {
    margin-left: auto;
    padding: 0.125rem 0.5rem;
    background: var(--primary-soft);
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 100px;
}

/* Divider */
.dropdown-divider {
    height: 1px;
    background: var(--border-color, #e8e8e0);
    margin: 0.5rem 0;
}

/* Dark Mode */
[data-theme="dark"] .dropdown-trigger {
    background: #1a1f2e;
    border-color: #2a2f3a;
}

[data-theme="dark"] .dropdown-trigger:hover {
    background: #242938;
}

[data-theme="dark"] .dropdown-menu {
    background: #1a1f2e;
    border-color: #2a2f3a;
}

[data-theme="dark"] .dropdown-item:hover {
    background: #242938;
}

[data-theme="dark"] .dropdown-item-danger:hover {
    background: #7f1d1d;
    color: #fca5a5;
}

[data-theme="dark"] .dropdown-divider {
    background: #2a2f3a;
}

/* Mobile */
@media (max-width: 640px) {
    .dropdown-menu {
        min-width: 10rem;
    }
}
</style>