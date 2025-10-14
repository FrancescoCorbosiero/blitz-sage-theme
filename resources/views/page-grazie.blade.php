{{-- resources/views/page-prenota.blade.php --}}
@extends('layouts.app')

@section('content')
{{-- Hero Booking Section --}}
<section class="booking-hero relative min-h-screen py-20 lg:py-24 overflow-hidden"
         x-data="bookingPage()"
         x-init="init()">
    
    {{-- Background Elements --}}
    <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-bg-primary to-accent/5"></div>
    
    {{-- Animated Elements --}}
    <div class="absolute top-1/4 right-1/4 w-64 h-64 bg-primary/10 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-1/4 left-1/4 w-80 h-80 bg-accent/10 rounded-full blur-3xl animate-float-delayed"></div>
    
    <div class="relative z-10 container max-w-7xl mx-auto px-4">
        {{-- Hero Content Grid --}}
        <div class="grid lg:grid-cols-2 gap-12 items-start">
            
            {{-- Left: Content --}}
            <div class="space-y-8">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-medium">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                    <span>{{ __('Real-time Availability', 'blitz') }}</span>
                </div>
                
                {{-- Main Heading --}}
                <div class="space-y-4">
                    <h1 class="text-4xl lg:text-6xl font-bold text-text-primary leading-tight">
                        {{ __('Book Your', 'blitz') }}
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-primary-dark">
                            {{ __('Private Space', 'blitz') }}
                        </span>
                    </h1>
                    
                    <p class="text-xl text-text-secondary leading-relaxed max-w-lg">
                        {{ __('Choose your day and time for an exclusive experience. Complete privacy and safety for you and your companion.', 'blitz') }}
                    </p>
                </div>
                
                {{-- Features Grid --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    @php
                        $features = [
                            [
                                'icon' => 'M5 13l4 4L19 7',
                                'title' => __('Instant Confirmation', 'blitz'),
                                'description' => __('Email & SMS confirmation', 'blitz')
                            ],
                            [
                                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                'title' => __('Free Cancellation', 'blitz'),
                                'description' => __('Up to 24 hours before', 'blitz')
                            ],
                            [
                                'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                                'title' => __('Secure Payment', 'blitz'),
                                'description' => __('Stripe, PayPal or on-site', 'blitz')
                            ],
                            [
                                'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                                'title' => __('Trusted by 200+', 'blitz'),
                                'description' => __('Happy customers this month', 'blitz')
                            ]
                        ];
                    @endphp
                    
                    @foreach($features as $feature)
                        <div class="feature-card group">
                            <div class="feature-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <h3 class="feature-title">{{ $feature['title'] }}</h3>
                                <p class="feature-description">{{ $feature['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Social Proof --}}
                <div class="social-proof">
                    <div class="flex items-center gap-6 pt-6 border-t border-border-color">
                        <div class="avatar-stack">
                            @for($i = 1; $i <= 4; $i++)
                                <img class="avatar" 
                                     src="https://i.pravatar.cc/100?img={{ $i + 20 }}" 
                                     alt="{{ __('Customer', 'blitz') }} {{ $i }}">
                            @endfor
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-text-primary">{{ __('200+ bookings', 'blitz') }}</p>
                            <p class="text-xs text-text-muted">{{ __('this month', 'blitz') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Right: Booking Widget --}}
            <div class="booking-widget-container lg:sticky lg:top-24">
                
                {{-- Mobile Booking CTA --}}
                <div x-show="isMobile" class="mobile-booking-card">
                    <div class="card-header">
                        <div class="header-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="header-text">
                            <p class="text-white/90 text-sm">{{ __('Book Now', 'blitz') }}</p>
                            <p class="font-semibold text-lg">{{ __('Choose Date & Time', 'blitz') }}</p>
                        </div>
                    </div>
                    
                    <a :href="calUrl" target="_blank" class="primary-cta-btn">
                        <span class="btn-content">
                            <span>{{ __('Open Calendar', 'blitz') }}</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </span>
                    </a>
                    
                    <p class="text-center text-white/80 text-xs mt-3">
                        {{ __('Opens in new window', 'blitz') }}
                    </p>
                    
                    {{-- Quick Contact Options --}}
                    <div class="quick-contact-grid">
                        <a href="https://wa.me/{{ get_theme_mod('whatsapp_number', '393331234567') }}?text={{ urlencode(__('I would like to book a slot', 'blitz')) }}" 
                           target="_blank" class="contact-option whatsapp">
                            <div class="contact-icon">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                            </div>
                            <div class="contact-info">
                                <p class="contact-label">{{ __('Book via', 'blitz') }}</p>
                                <p class="contact-method">WhatsApp</p>
                            </div>
                        </a>
                        
                        <a href="tel:+{{ get_theme_mod('phone_number', '393331234567') }}" class="contact-option phone">
                            <div class="contact-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div class="contact-info">
                                <p class="contact-label">{{ __('Call us', 'blitz') }}</p>
                                <p class="contact-method">{{ get_theme_mod('phone_display', '333 123 4567') }}</p>
                            </div>
                        </a>
                    </div>
                    
                    {{-- Availability Preview --}}
                    <div class="availability-preview">
                        <p class="preview-title">🟢 {{ __('Available today:', 'blitz') }}</p>
                        <div class="time-slots">
                            @foreach(['14:00', '15:00', '17:00', '18:00'] as $time)
                                <span class="time-slot">{{ $time }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                {{-- Desktop Booking Widget --}}
                <div x-show="!isMobile" class="desktop-booking-widget">
                    <div class="widget-container">
                        <div class="widget-header">
                            <a href="{{ get_theme_mod('cal_url', 'https://cal.com/francesco-corbosiero-auuvro/') }}" 
                               target="_blank" 
                               class="header-link">
                                {{ __('Book Online with Cal.com - Open in New Tab', 'blitz') }}
                            </a>
                        </div>
                        
                        <div class="widget-content">
                            <iframe :src="calUrl"   
                                    frameborder="0"
                                    class="cal-iframe"
                                    loading="lazy">
                            </iframe>
                        </div>
                    </div>
                    
                    {{-- Help Section --}}
                    <div class="help-section">
                        <div class="help-content">
                            <svg class="help-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="help-title">{{ __('Need Help?', 'blitz') }}</p>
                                <p class="help-text">
                                    {{ __('Message us on WhatsApp or call', 'blitz') }} 
                                    <a href="tel:+{{ get_theme_mod('phone_number', '393331234567') }}" class="help-phone">{{ get_theme_mod('phone_display', '333 123 4567') }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Service Details Section --}}
<section class="service-details py-20 bg-gradient-to-b from-bg-primary to-bg-secondary">
    <div class="container max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4">
                {{ __('Everything You Need to Know', 'blitz') }}
            </h2>
            <p class="text-lg text-text-secondary max-w-2xl mx-auto">
                {{ __('Transparent pricing, easy access, and simple rules for everyone\'s safety', 'blitz') }}
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            {{-- Pricing Card --}}
            <div class="detail-card pricing-card">
                <div class="card-icon">
                    <span class="text-3xl">💰</span>
                </div>
                <h3 class="card-title">{{ __('Transparent Pricing', 'blitz') }}</h3>
                <p class="card-description">{{ __('No hidden costs, everything clear', 'blitz') }}</p>
                <div class="pricing-list">
                    <div class="price-item">
                        <span class="service-name">{{ __('Private Area', 'blitz') }}</span>
                        <span class="service-price">€20/{{ __('hour', 'blitz') }}</span>
                    </div>
                    <div class="price-item">
                        <span class="service-name">{{ __('Profiling', 'blitz') }}</span>
                        <span class="service-price">€10</span>
                    </div>
                    <div class="price-item special">
                        <span class="service-name">{{ __('First time?', 'blitz') }}</span>
                        <span class="service-price">-50%</span>
                    </div>
                </div>
            </div>
            
            {{-- Location Card --}}
            <div class="detail-card location-card">
                <div class="card-icon">
                    <span class="text-3xl">📍</span>
                </div>
                <h3 class="card-title">{{ __('How to Reach Us', 'blitz') }}</h3>
                <p class="card-description">{{ __('Easily accessible from Milan', 'blitz') }}</p>
                <div class="location-info">
                    <p class="address-line">{{ get_theme_mod('address_line1', 'Via dei Cani Felici, 123') }}</p>
                    <p class="address-line">{{ get_theme_mod('address_line2', '20100 Milano MI') }}</p>
                    <a href="{{ get_theme_mod('maps_url', '#') }}" 
                       target="_blank"
                       class="directions-link">
                        {{ __('Get Directions', 'blitz') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            {{-- Rules Card --}}
            <div class="detail-card rules-card">
                <div class="card-icon">
                    <span class="text-3xl">📋</span>
                </div>
                <h3 class="card-title">{{ __('Simple Rules', 'blitz') }}</h3>
                <p class="card-description">{{ __('For everyone\'s safety', 'blitz') }}</p>
                <ul class="rules-list">
                    @php
                        $rules = [
                            __('Maximum 5 dogs per group', 'blitz'),
                            __('Waste collection required', 'blitz'),
                            __('Supervision always required', 'blitz')
                        ];
                    @endphp
                    
                    @foreach($rules as $rule)
                        <li class="rule-item">
                            <span class="rule-check">✓</span>
                            <span class="rule-text">{{ $rule }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- FAQ Section --}}
@include('sections.faq.faq-booking')
@endsection

<style>
/* Booking Page Styles */
.booking-hero {
    min-height: 100vh;
    display: flex;
    align-items: center;
}

/* Animations */
@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    33% { transform: translateY(-20px) rotate(2deg); }
    66% { transform: translateY(10px) rotate(-1deg); }
}

@keyframes float-delayed {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    33% { transform: translateY(15px) rotate(-2deg); }
    66% { transform: translateY(-10px) rotate(1deg); }
}

.animate-float {
    animation: float 15s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 18s ease-in-out infinite;
}

/* Feature Cards */
.feature-card {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 0.75rem;
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px var(--shadow);
    border-color: var(--primary)/0.3;
}

.feature-icon {
    flex-shrink: 0;
    width: 2.5rem;
    height: 2.5rem;
    background: var(--primary)/0.1;
    color: var(--primary);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.feature-card:hover .feature-icon {
    background: var(--primary);
    color: white;
    transform: scale(1.1);
}

.feature-content {
    flex: 1;
}

.feature-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.feature-description {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

/* Social Proof */
.avatar-stack {
    display: flex;
    margin-left: -0.5rem;
}

.avatar {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    border: 2px solid white;
    margin-left: -0.5rem;
}

/* Mobile Booking Card */
.mobile-booking-card {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: 1rem;
    padding: 1.5rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.mobile-booking-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 8rem;
    height: 8rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    filter: blur(2rem);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 10;
}

.header-icon {
    width: 3rem;
    height: 3rem;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.primary-cta-btn {
    display: block;
    width: 100%;
    background: white;
    color: var(--primary);
    font-weight: 600;
    text-align: center;
    padding: 1rem 1.5rem;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 10;
}

.primary-cta-btn:hover {
    background: var(--bg-secondary);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.btn-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

/* Quick Contact Grid */
.quick-contact-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
    margin-top: 1rem;
}

.contact-option {
    background: white;
    border-radius: 0.75rem;
    padding: 1rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.contact-option:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.contact-icon {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.contact-option.whatsapp .contact-icon {
    background: #25D366/0.1;
    color: #25D366;
}

.contact-option.phone .contact-icon {
    background: var(--primary)/0.1;
    color: var(--primary);
}

.contact-label {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.contact-method {
    font-weight: 600;
    color: var(--text-primary);
}

/* Availability Preview */
.availability-preview {
    margin-top: 1rem;
    padding: 1rem;
    background: var(--primary)/0.1;
    border-radius: 0.75rem;
    position: relative;
    z-index: 10;
}

.preview-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 0.5rem;
}

.time-slots {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.time-slot {
    padding: 0.25rem 0.75rem;
    background: white;
    color: var(--primary);
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
}

/* Desktop Widget */
.desktop-booking-widget {
    display: block;
}

.widget-container {
    background: var(--card-bg);
    border-radius: 1rem;
    box-shadow: 0 10px 25px var(--shadow);
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.widget-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    padding: 1rem;
}

.header-link {
    color: white;
    font-weight: 500;
    text-align: center;
    display: block;
    transition: color 0.3s ease;
}

.header-link:hover {
    color: rgba(255, 255, 255, 0.8);
}

.cal-iframe {
    width: 100%;
    height: 600px;
    min-height: 500px;
}

/* Help Section */
.help-section {
    margin-top: 1rem;
    padding: 1rem;
    background: var(--primary)/0.1;
    border-radius: 0.75rem;
}

.help-content {
    display: flex;
    gap: 0.75rem;
}

.help-icon {
    width: 1.25rem;
    height: 1.25rem;
    color: var(--primary);
    flex-shrink: 0;
    margin-top: 0.125rem;
}

.help-title {
    font-weight: 600;
    color: var(--primary);
}

.help-text {
    font-size: 0.875rem;
    color: var(--primary);
}

.help-phone {
    text-decoration: underline;
}

/* Service Details Cards */
.detail-card {
    background: var(--card-bg);
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 12px var(--shadow);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.detail-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px var(--shadow);
    border-color: var(--primary)/0.2;
}

.card-icon {
    width: 3rem;
    height: 3rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.pricing-card .card-icon {
    background: var(--primary)/0.1;
}

.location-card .card-icon {
    background: var(--accent)/0.1;
}

.rules-card .card-icon {
    background: #8B5CF6/0.1;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.card-description {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin-bottom: 1.5rem;
}

/* Pricing List */
.pricing-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.price-item {
    display: flex;
    justify-content: between;
    align-items: center;
}

.service-name {
    color: var(--text-secondary);
}

.service-price {
    font-weight: 600;
    color: var(--text-primary);
}

.price-item.special .service-name {
    color: var(--primary);
}

.price-item.special .service-price {
    color: var(--primary);
    font-weight: 700;
}

/* Location Info */
.location-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.address-line {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.directions-link {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    color: var(--primary);
    font-weight: 500;
    margin-top: 0.5rem;
    transition: color 0.3s ease;
}

.directions-link:hover {
    color: var(--primary-dark);
}

/* Rules List */
.rules-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    list-style: none;
    padding: 0;
    margin: 0;
}

.rule-item {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}

.rule-check {
    color: var(--primary);
    font-weight: bold;
    margin-top: 0.125rem;
}

.rule-text {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .booking-widget-container {
        position: static;
    }
    
    .desktop-booking-widget {
        display: none;
    }
}

@media (max-width: 768px) {
    .booking-hero {
        padding-top: 5rem;
        padding-bottom: 5rem;
        min-height: auto;
    }
    
    .feature-card {
        flex-direction: column;
        text-align: center;
    }
    
    .social-proof {
        text-align: center;
    }
    
    .avatar-stack {
        justify-content: center;
    }
}

/* Dark Mode */
[data-theme="dark"] .cal-iframe {
    filter: brightness(0.9);
}

[data-theme="dark"] .detail-card {
    background: var(--bg-secondary);
    border-color: var(--border-color);
}

[data-theme="dark"] .contact-option {
    background: var(--bg-secondary);
}

/* Utility Classes */
[x-cloak] { 
    display: none !important; 
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('bookingPage', () => ({
        isMobile: window.innerWidth < 1024,
        calUrl: '{{ get_theme_mod("cal_url", "https://cal.com/francesco-corbosiero-auuvro/") }}',
        
        init() {
            this.setupResponsive();
            this.trackPageView();
        },
        
        setupResponsive() {
            window.addEventListener('resize', () => {
                this.isMobile = window.innerWidth < 1024;
            });
        },
        
        trackPageView() {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'page_view', {
                    'page_title': 'Booking Page',
                    'event_category': 'engagement'
                });
            }
        }
    }));
});
</script>