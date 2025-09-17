{{-- resources/views/partials/alert.blade.php --}}
{{-- 
    Reusable Alert Component
    
    Usage:
    @include('partials.alert', [
        'type' => 'success', // success, error, warning, info
        'title' => 'Operazione completata',
        'message' => 'La prenotazione è stata confermata',
        'dismissible' => true,
        'icon' => true,
        'actions' => true
    ])
--}}

@props([
    'id' => 'alert-' . uniqid(),
    'type' => 'info',
    'title' => '',
    'message' => '',
    'dismissible' => true,
    'icon' => true,
    'actions' => false,
    'autoHide' => 0,
])

<div x-data="{ 
        show: true,
        autoHide: {{ $autoHide }},
        
        init() {
            if (this.autoHide > 0) {
                setTimeout(() => {
                    this.show = false;
                }, this.autoHide);
            }
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform -translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-2"
    class="alert alert-{{ $type }}"
    role="alert">
    
    <div class="alert-content">
        {{-- Icon --}}
        @if($icon)
        <div class="alert-icon-wrapper">
            @switch($type)
                @case('success')
                    <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    @break
                @case('error')
                    <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    @break
                @case('warning')
                    <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    @break
                @default
                    <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
            @endswitch
        </div>
        @endif
        
        {{-- Text Content --}}
        <div class="alert-body">
            @if($title)
            <h3 class="alert-title">{{ $title }}</h3>
            @endif
            
            @if($message)
            <p class="alert-message">{{ $message }}</p>
            @endif
            
            {{ $slot ?? '' }}
            
            {{-- Actions --}}
            @if($actions)
            <div class="alert-actions">
                @yield('alert-actions-' . $id)
                @if(!View::hasSection('alert-actions-' . $id))
                <button class="alert-action-primary">
                    Visualizza
                </button>
                <button class="alert-action-secondary" @click="show = false">
                    Ignora
                </button>
                @endif
            </div>
            @endif
        </div>
    </div>
    
    {{-- Dismiss Button --}}
    @if($dismissible)
    <button @click="show = false" 
            class="alert-dismiss"
            aria-label="Dismiss alert">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
    @endif
</div>

<style>
/* Alert Base */
.alert {
    position: relative;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 1rem;
    border-radius: 16px;
    border-width: 1px;
    border-style: solid;
    margin-bottom: 1rem;
}

.alert-content {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    flex: 1;
}

/* Type Variants */
.alert-success {
    background: linear-gradient(135deg, #dcfce7 0%, #d9f99d 100%);
    border-color: #86efac;
    color: #14532d;
}

.alert-error {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border-color: #fca5a5;
    color: #7f1d1d;
}

.alert-warning {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-color: #fbbf24;
    color: #78350f;
}

.alert-info {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border-color: #93c5fd;
    color: #1e3a8a;
}

/* Icon */
.alert-icon-wrapper {
    flex-shrink: 0;
}

.alert-icon {
    width: 1.5rem;
    height: 1.5rem;
}

.alert-success .alert-icon { color: #16a34a; }
.alert-error .alert-icon { color: #dc2626; }
.alert-warning .alert-icon { color: #f59e0b; }
.alert-info .alert-icon { color: #2563eb; }

/* Content */
.alert-body {
    flex: 1;
}

.alert-title {
    font-size: 0.9375rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.alert-message {
    font-size: 0.875rem;
    opacity: 0.9;
    line-height: 1.5;
}

/* Actions */
.alert-actions {
    display: flex;
    gap: 0.75rem;
    margin-top: 0.75rem;
}

.alert-action-primary,
.alert-action-secondary {
    padding: 0.375rem 0.875rem;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 100px;
    transition: all 0.2s ease;
}

.alert-success .alert-action-primary {
    background: #16a34a;
    color: white;
}

.alert-error .alert-action-primary {
    background: #dc2626;
    color: white;
}

.alert-warning .alert-action-primary {
    background: #f59e0b;
    color: white;
}

.alert-info .alert-action-primary {
    background: #2563eb;
    color: white;
}

.alert-action-secondary {
    background: rgba(0, 0, 0, 0.1);
}

.alert-action-primary:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.alert-action-secondary:hover {
    background: rgba(0, 0, 0, 0.15);
}

/* Dismiss Button */
.alert-dismiss {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.75rem;
    height: 1.75rem;
    border-radius: 0.5rem;
    color: inherit;
    opacity: 0.7;
    transition: all 0.2s ease;
}

.alert-dismiss:hover {
    opacity: 1;
    background: rgba(0, 0, 0, 0.1);
}

/* Dark Mode */
[data-theme="dark"] .alert-success {
    background: linear-gradient(135deg, #14532d 0%, #166534 100%);
    border-color: #16a34a;
    color: #dcfce7;
}

[data-theme="dark"] .alert-error {
    background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);
    border-color: #dc2626;
    color: #fee2e2;
}

[data-theme="dark"] .alert-warning {
    background: linear-gradient(135deg, #78350f 0%, #92400e 100%);
    border-color: #f59e0b;
    color: #fef3c7;
}

[data-theme="dark"] .alert-info {
    background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
    border-color: #2563eb;
    color: #dbeafe;
}

[data-theme="dark"] .alert-dismiss:hover {
    background: rgba(255, 255, 255, 0.1);
}
</style>