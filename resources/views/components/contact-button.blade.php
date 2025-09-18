{{-- resources/views/components/contact-button.blade.php --}}

@php
    // Get data from Sage/Theme Service
    $contactInfo = app('blitz.theme')->getContactInfo();
    $siteName = get_bloginfo('name');
    
    // Configuration with defaults
    $type = $type ?? 'whatsapp'; // 'whatsapp', 'phone', 'email'
    $phoneNumber = $phoneNumber ?? $contactInfo['whatsapp'] ?? $contactInfo['phone'] ?? '';
    $email = $email ?? $contactInfo['email'];
    $message = $message ?? __('Hi! I would like more information.', 'blitz');
    
    // Build URL based on type
    $contactUrl = match($type) {
        'whatsapp' => 'https://wa.me/' . preg_replace('/[^0-9]/', '', $phoneNumber) . '?text=' . urlencode($message),
        'phone' => 'tel:' . $phoneNumber,
        'email' => 'mailto:' . $email,
        default => '#'
    };
@endphp

<div class="contact-button-wrapper"
     x-data="{ 
         showWelcome: false,
         hovering: false,
         messageCount: 0
     }"
     x-init="
         setTimeout(() => { 
             showWelcome = true;
             messageCount = 1;
             setTimeout(() => { showWelcome = false; }, 5000);
         }, 3000)
     ">
    
    {{-- Welcome Bubble --}}
    <div x-show="showWelcome"
         x-transition
         @click="showWelcome = false"
         class="welcome-bubble">
        
        <div class="bubble-tail"></div>
        
        <div class="bubble-header">
            <div class="bubble-avatar">
                @if($type === 'whatsapp')
                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                @else
                    💬
                @endif
            </div>
            <div class="bubble-info">
                <p class="bubble-title">{{ $siteName }}</p>
                <p class="bubble-status">{{ __('Usually responds quickly', 'blitz') }}</p>
            </div>
            <button @click.stop="showWelcome = false" class="bubble-close">✕</button>
        </div>
        
        <div class="bubble-message">
            <p>{{ __('👋 Need help? Click to chat with us!', 'blitz') }}</p>
        </div>
    </div>
    
    {{-- Contact Button --}}
    <a href="{{ $contactUrl }}"
       target="_blank"
       @mouseenter="hovering = true"
       @mouseleave="hovering = false"
       @click="messageCount = 0; showWelcome = false"
       class="contact-button contact-{{ $type }}">
        
        {{-- Notification Badge --}}
        <span x-show="messageCount > 0" x-transition class="notification-badge" x-text="messageCount"></span>
        
        {{-- Pulse Rings --}}
        <div class="pulse-ring pulse-1"></div>
        <div class="pulse-ring pulse-2"></div>
        
        {{-- Button --}}
        <div class="button-circle">
            @if($type === 'whatsapp')
                <svg width="28" height="28" fill="white" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
            @elseif($type === 'phone')
                <svg width="28" height="28" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
            @else
                <svg width="28" height="28" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            @endif
        </div>
        
        {{-- Hover Tooltip --}}
        <span x-show="hovering && !showWelcome" x-transition class="tooltip">
            {{ __('Chat with us!', 'blitz') }}
        </span>
    </a>
</div>

<style>
.contact-button-wrapper {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 40;
}

/* Welcome Bubble */
.welcome-bubble {
    position: absolute;
    bottom: 5rem;
    right: 0;
    width: 18rem;
    background: white;
    border-radius: 1rem;
    padding: 1rem;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--border-light);
    cursor: pointer;
}

.bubble-tail {
    position: absolute;
    bottom: -0.5rem;
    right: 1.5rem;
    width: 1rem;
    height: 1rem;
    background: white;
    border-right: 1px solid var(--border-light);
    border-bottom: 1px solid var(--border-light);
    transform: rotate(45deg);
}

.bubble-header {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.bubble-avatar {
    width: 2.5rem;
    height: 2.5rem;
    background: linear-gradient(135deg, #25D366, #128C7E);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bubble-info {
    flex: 1;
}

.bubble-title {
    font-weight: 600;
    font-size: 0.875rem;
    margin: 0;
    color: var(--text-primary);
}

.bubble-status {
    font-size: 0.75rem;
    color: var(--text-muted);
    margin: 0;
}

.bubble-close {
    background: none;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    padding: 0;
    font-size: 1rem;
}

.bubble-message {
    background: var(--bg-secondary);
    border-radius: 0.5rem;
    padding: 0.75rem;
}

.bubble-message p {
    margin: 0;
    font-size: 0.875rem;
    color: var(--text-primary);
}

/* Contact Button */
.contact-button {
    position: relative;
    display: block;
}

.notification-badge {
    position: absolute;
    top: -0.25rem;
    right: -0.25rem;
    width: 1.25rem;
    height: 1.25rem;
    background: #ef4444;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: bold;
    z-index: 1;
}

.pulse-ring {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    opacity: 0.3;
    animation: pulse 2s infinite;
}

.pulse-1 { 
    background: var(--gradient-primary);
}

.pulse-2 {
    background: var(--gradient-primary);
    animation-delay: 1s;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 0.3;
    }
    100% {
        transform: scale(1.5);
        opacity: 0;
    }
}

.button-circle {
    position: relative;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s var(--ease-bounce);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
}

.contact-whatsapp .button-circle {
    background: linear-gradient(135deg, #25D366, #128C7E);
}

.contact-phone .button-circle {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.contact-email .button-circle {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
}

.contact-button:hover .button-circle {
    transform: scale(1.1) rotate(10deg);
}

.tooltip {
    position: absolute;
    bottom: 100%;
    right: 50%;
    transform: translateX(50%);
    margin-bottom: 0.5rem;
    background: var(--text-primary);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    white-space: nowrap;
    pointer-events: none;
}

/* Mobile */
@media (max-width: 768px) {
    .contact-button-wrapper {
        bottom: 1rem;
        right: 1rem;
    }
    
    .welcome-bubble {
        width: 16rem;
    }
    
    .button-circle {
        width: 50px;
        height: 50px;
    }
}

/* Dark Mode */
[data-theme="dark"] .welcome-bubble {
    background: var(--bg-secondary);
    border-color: var(--border-color);
}

[data-theme="dark"] .bubble-tail {
    background: var(--bg-secondary);
    border-color: var(--border-color);
}

[data-theme="dark"] .bubble-message {
    background: var(--bg-tertiary);
}
</style>