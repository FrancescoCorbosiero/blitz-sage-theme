{{-- resources/views/partials/toast.blade.php --}}
{{-- 
    Reusable Toast Notification Component
    
    Usage:
    @include('partials.toast')
    
    Then trigger via JavaScript:
    window.dispatchEvent(new CustomEvent('show-toast', { 
        detail: { 
            type: 'success',
            title: 'Prenotazione confermata!',
            message: 'Ti aspettiamo domani alle 10:00',
            duration: 5000
        } 
    }));
--}}

<div x-data="toastNotification()" 
     x-init="init()"
     class="toast-container fixed bottom-4 right-4 z-[10000] pointer-events-none">
    
    <template x-for="(toast, index) in toasts" :key="toast.id">
        <div x-show="toast.visible"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-x-full"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-x-0"
             x-transition:leave-end="opacity-0 transform translate-x-full"
             class="toast pointer-events-auto mb-3"
             :class="'toast-' + toast.type">
            
            {{-- Progress Bar --}}
            <div class="toast-progress" 
                 :style="'animation-duration: ' + toast.duration + 'ms'"
                 x-show="toast.duration > 0"></div>
            
            {{-- Icon --}}
            <div class="toast-icon">
                <template x-if="toast.type === 'success'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </template>
                <template x-if="toast.type === 'error'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </template>
                <template x-if="toast.type === 'warning'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </template>
                <template x-if="toast.type === 'info'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </template>
            </div>
            
            {{-- Content --}}
            <div class="toast-content">
                <h4 class="toast-title" x-text="toast.title"></h4>
                <p class="toast-message" x-text="toast.message" x-show="toast.message"></p>
            </div>
            
            {{-- Actions --}}
            <div class="toast-actions" x-show="toast.action">
                <button @click="handleAction(toast)" 
                        class="toast-action"
                        x-text="toast.actionText || 'View'">
                </button>
            </div>
            
            {{-- Close Button --}}
            <button @click="removeToast(toast.id)" 
                    class="toast-close">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
</div>

<script>
function toastNotification() {
    return {
        toasts: [],
        nextId: 1,
        
        init() {
            // Listen for toast events
            window.addEventListener('show-toast', (e) => {
                this.addToast(e.detail);
            });
        },
        
        addToast(options) {
            const toast = {
                id: this.nextId++,
                type: options.type || 'info',
                title: options.title || '',
                message: options.message || '',
                duration: options.duration !== undefined ? options.duration : 5000,
                action: options.action || null,
                actionText: options.actionText || 'View',
                visible: false
            };
            
            this.toasts.push(toast);
            
            // Show toast after a brief delay for animation
            setTimeout(() => {
                toast.visible = true;
            }, 10);
            
            // Auto remove if duration is set
            if (toast.duration > 0) {
                setTimeout(() => {
                    this.removeToast(toast.id);
                }, toast.duration);
            }
            
            // Limit to 5 toasts
            if (this.toasts.length > 5) {
                this.removeToast(this.toasts[0].id);
            }
        },
        
        removeToast(id) {
            const index = this.toasts.findIndex(t => t.id === id);
            if (index > -1) {
                this.toasts[index].visible = false;
                setTimeout(() => {
                    this.toasts.splice(index, 1);
                }, 300);
            }
        },
        
        handleAction(toast) {
            if (toast.action && typeof toast.action === 'function') {
                toast.action();
            }
            this.removeToast(toast.id);
        }
    }
}
</script>

<style>
/* Toast Container */
.toast-container {
    max-width: 24rem;
}

/* Toast Base */
.toast {
    position: relative;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 
        0 10px 25px -5px rgba(0, 0, 0, 0.1),
        0 10px 10px -5px rgba(0, 0, 0, 0.04);
    min-width: 300px;
    max-width: 100%;
    overflow: hidden;
}

/* Progress Bar */
.toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: currentColor;
    opacity: 0.3;
    animation: progress linear forwards;
}

@keyframes progress {
    from { width: 100%; }
    to { width: 0%; }
}

/* Type Variants */
.toast-success {
    background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
    border: 1px solid #86efac;
    color: #16a34a;
}

.toast-error {
    background: linear-gradient(135deg, #ffffff 0%, #fef2f2 100%);
    border: 1px solid #fca5a5;
    color: #dc2626;
}

.toast-warning {
    background: linear-gradient(135deg, #ffffff 0%, #fffbeb 100%);
    border: 1px solid #fbbf24;
    color: #f59e0b;
}

.toast-info {
    background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%);
    border: 1px solid #93c5fd;
    color: #2563eb;
}

/* Icon */
.toast-icon {
    flex-shrink: 0;
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: currentColor;
    opacity: 0.1;
}

.toast-icon svg {
    color: inherit;
    opacity: 10;
}

/* Content */
.toast-content {
    flex: 1;
    min-width: 0;
}

.toast-title {
    font-size: 0.9375rem;
    font-weight: 600;
    margin-bottom: 0.125rem;
    color: var(--text-primary);
}

.toast-message {
    font-size: 0.875rem;
    color: var(--text-secondary);
    line-height: 1.4;
}

/* Actions */
.toast-actions {
    flex-shrink: 0;
}

.toast-action {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: inherit;
    background: currentColor;
    opacity: 0.1;
    border-radius: 100px;
    transition: all 0.2s ease;
}

.toast-action:hover {
    opacity: 0.2;
}

/* Close Button */
.toast-close {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 0.375rem;
    color: var(--text-secondary);
    opacity: 0.5;
    transition: all 0.2s ease;
}

.toast-close:hover {
    opacity: 1;
    background: rgba(0, 0, 0, 0.05);
}

/* Dark Mode */
[data-theme="dark"] .toast {
    background: #1a1f2e;
    border-color: #2a2f3a;
}

[data-theme="dark"] .toast-success {
    background: linear-gradient(135deg, #1a1f2e 0%, #14532d 100%);
}

[data-theme="dark"] .toast-error {
    background: linear-gradient(135deg, #1a1f2e 0%, #7f1d1d 100%);
}

[data-theme="dark"] .toast-warning {
    background: linear-gradient(135deg, #1a1f2e 0%, #78350f 100%);
}

[data-theme="dark"] .toast-info {
    background: linear-gradient(135deg, #1a1f2e 0%, #1e3a8a 100%);
}

[data-theme="dark"] .toast-close:hover {
    background: rgba(255, 255, 255, 0.05);
}

/* Mobile */
@media (max-width: 640px) {
    .toast-container {
        left: 1rem;
        right: 1rem;
        bottom: 1rem;
        max-width: none;
    }
}
</style>