{{-- resources/views/partials/modal.blade.php --}}
{{-- 
    Reusable Modal Component
    
    Usage:
    @include('partials.modal', [
        'id' => 'booking-modal',
        'title' => 'Prenota il tuo spazio',
        'size' => 'lg', // sm, md, lg, xl, full
        'showClose' => true,
        'backdrop' => true,
        'centered' => true
    ])
    
    Trigger: 
    <button @click="$dispatch('open-modal', { id: 'booking-modal' })">Open Modal</button>
--}}

@props([
    'id' => 'modal-' . uniqid(),
    'title' => '',
    'size' => 'md',
    'showClose' => true,
    'backdrop' => true,
    'centered' => true,
    'showFooter' => true,
])

<div x-data="{ 
        open: false,
        modalId: '{{ $id }}'
    }"
    x-init="
        // Listen for open event
        window.addEventListener('open-modal', (e) => {
            if (e.detail.id === modalId) {
                open = true;
                document.body.style.overflow = 'hidden';
            }
        });
        
        // Listen for close event
        window.addEventListener('close-modal', (e) => {
            if (!e.detail.id || e.detail.id === modalId) {
                open = false;
                document.body.style.overflow = '';
            }
        });
        
        // Close on escape
        $watch('open', value => {
            if (!value) {
                document.body.style.overflow = '';
            }
        });
    "
    @keydown.escape.window="open = false"
    class="modal-container"
    style="display: none;"
    x-show="open">
    
    {{-- Backdrop --}}
    @if($backdrop)
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false"
         class="modal-backdrop fixed inset-0 bg-black/60 backdrop-blur-sm z-[9990]">
    </div>
    @endif
    
    {{-- Modal --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.away="open = false"
         class="modal-wrapper fixed inset-0 z-[9999] overflow-y-auto">
        
        <div class="modal-position {{ $centered ? 'flex min-h-screen items-center justify-center' : 'flex justify-center py-12' }} px-4 sm:px-6">
            <div class="modal modal-{{ $size }} relative">
                
                {{-- Header --}}
                @if($title || $showClose)
                <div class="modal-header">
                    @if($title)
                    <h3 class="modal-title">{{ $title }}</h3>
                    @endif
                    
                    @if($showClose)
                    <button @click="open = false" 
                            class="modal-close"
                            aria-label="Close modal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    @endif
                </div>
                @endif
                
                {{-- Body --}}
                <div class="modal-body">
                    {{ $slot ?? '' }}
                    @yield('modal-content-' . $id)
                </div>
                
                {{-- Footer --}}
                @if($showFooter)
                <div class="modal-footer">
                    @yield('modal-footer-' . $id)
                    @if(!View::hasSection('modal-footer-' . $id))
                    <button @click="open = false" class="btn-ghost">
                        Chiudi
                    </button>
                    <button class="btn-primary">
                        Conferma
                    </button>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Modal Styles */
.modal {
    background: var(--bg-secondary, #ffffff);
    border-radius: 24px;
    box-shadow: 
        0 20px 25px -5px rgba(0, 0, 0, 0.1),
        0 10px 10px -5px rgba(0, 0, 0, 0.04);
    width: 100%;
    max-height: 90vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

/* Size Variants */
.modal-sm { max-width: 24rem; }
.modal-md { max-width: 32rem; }
.modal-lg { max-width: 48rem; }
.modal-xl { max-width: 64rem; }
.modal-full { 
    max-width: calc(100vw - 2rem);
    max-height: calc(100vh - 2rem);
}

/* Header */
.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color, #e8e8e0);
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    font-family: var(--font-heading);
}

.modal-close {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    border-radius: 0.5rem;
    color: var(--text-secondary);
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: rgba(0, 0, 0, 0.05);
    color: var(--text-primary);
}

/* Body */
.modal-body {
    flex: 1;
    padding: 1.5rem;
    overflow-y: auto;
    overscroll-behavior: contain;
}

/* Footer */
.modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.75rem;
    padding: 1.5rem;
    border-top: 1px solid var(--border-color, #e8e8e0);
}

/* Buttons */
.modal .btn-primary {
    padding: 0.625rem 1.5rem;
    background: linear-gradient(135deg, var(--primary-soft) 0%, var(--primary) 100%);
    color: white;
    font-weight: 600;
    border-radius: 100px;
    transition: all 0.3s ease;
}

.modal .btn-ghost {
    padding: 0.625rem 1.5rem;
    color: var(--text-secondary);
    font-weight: 500;
    border-radius: 100px;
    transition: all 0.3s ease;
}

.modal .btn-ghost:hover {
    background: rgba(0, 0, 0, 0.05);
}

/* Dark Mode */
[data-theme="dark"] .modal {
    background: #1a1f2e;
}

[data-theme="dark"] .modal-header,
[data-theme="dark"] .modal-footer {
    border-color: #2a2f3a;
}

[data-theme="dark"] .modal-close:hover {
    background: rgba(255, 255, 255, 0.05);
}

/* Mobile */
@media (max-width: 640px) {
    .modal {
        max-height: 100vh;
        border-radius: 24px 24px 0 0;
    }
    
    .modal-position {
        align-items: flex-end;
    }
}
</style>