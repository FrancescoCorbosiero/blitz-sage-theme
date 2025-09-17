{{-- Newsletter Widget (self-contained) --}}
<div class="widget newsletter-widget" 
     x-data="newsletterWidget()" 
     x-init="init()">
    
    <div class="newsletter-content">
        <div class="newsletter-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        
        <h3 class="newsletter-title">{{ __('Stay Updated', 'blitz') }}</h3>
        <p class="newsletter-description">{{ __('Get the latest posts delivered directly to your inbox.', 'blitz') }}</p>
        
        <form class="newsletter-form" @submit.prevent="subscribe">
            <div class="form-group">
                <input type="email" 
                       x-model="email"
                       placeholder="{{ __('Enter your email', 'blitz') }}"
                       required
                       class="email-input"
                       :disabled="loading || subscribed">
                
                <button type="submit" 
                        class="subscribe-btn"
                        :disabled="loading || subscribed"
                        :class="{ 'loading': loading, 'success': subscribed }">
                    <span x-show="!loading && !subscribed">{{ __('Subscribe', 'blitz') }}</span>
                    <span x-show="loading">{{ __('Subscribing...', 'blitz') }}</span>
                    <span x-show="subscribed">{{ __('Subscribed!', 'blitz') }}</span>
                </button>
            </div>
            
            <p class="newsletter-privacy">
                {{ __('We respect your privacy. Unsubscribe anytime.', 'blitz') }}
            </p>
        </form>
        
        <div x-show="subscribed" x-transition class="success-message">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ __('Thanks for subscribing!', 'blitz') }}</span>
        </div>
    </div>
</div>

<style>
.newsletter-widget {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    text-align: center;
}

.newsletter-icon {
    display: inline-flex;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    margin-bottom: 1rem;
}

.newsletter-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.newsletter-description {
    font-size: 0.875rem;
    opacity: 0.9;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.newsletter-form {
    margin-bottom: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.email-input {
    padding: 0.75rem 1rem;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 0.5rem;
    color: white;
    font-size: 0.875rem;
    outline: none;
    transition: all 0.3s ease;
}

.email-input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.email-input:focus {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
}

.subscribe-btn {
    padding: 0.75rem 1.5rem;
    background: white;
    color: var(--primary);
    border: none;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.subscribe-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.subscribe-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.subscribe-btn.loading {
    background: rgba(255, 255, 255, 0.8);
}

.subscribe-btn.success {
    background: #10b981;
    color: white;
}

.newsletter-privacy {
    font-size: 0.75rem;
    opacity: 0.8;
    margin: 0;
}

.success-message {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem;
    background: rgba(16, 185, 129, 0.2);
    border: 1px solid rgba(16, 185, 129, 0.3);
    border-radius: 0.5rem;
    font-size: 0.875rem;
}

@media (min-width: 640px) {
    .form-group {
        flex-direction: row;
    }
    
    .email-input {
        flex: 1;
    }
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('newsletterWidget', () => ({
        email: '',
        loading: false,
        subscribed: false,
        
        init() {
            // Check if already subscribed
            this.subscribed = localStorage.getItem('newsletter_subscribed') === 'true';
        },
        
        async subscribe() {
            if (this.loading || this.subscribed) return;
            
            this.loading = true;
            
            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 1500));
                
                // Store subscription status
                localStorage.setItem('newsletter_subscribed', 'true');
                this.subscribed = true;
                
                // Track subscription
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'newsletter_subscribe', {
                        'event_category': 'engagement'
                    });
                }
                
            } catch (error) {
                console.error('Subscription failed:', error);
            } finally {
                this.loading = false;
            }
        }
    }));
});
</script>