{{-- resources/views/sections/contact/contact-3d-cards.blade.php --}}
{{-- Interactive 3D Contact Cards Section with Advanced Animations --}}

@php
$blockId = 'contact-' . uniqid();
$contactInfo = [
    'email' => get_theme_mod('contact_email', 'hello@blitztheme.com'),
    'phone' => get_theme_mod('contact_phone', '+1 (555) 123-4567'),
    'address' => get_theme_mod('contact_address', '123 Innovation Street, San Francisco, CA 94105'),
    'hours' => get_theme_mod('business_hours', 'Mon-Fri: 9AM-6PM PST')
];
@endphp

<section id="{{ $blockId }}" 
         class="contact-3d-cards relative py-20 lg:py-32 overflow-hidden bg-gradient-to-br from-slate-900 via-blue-900/20 to-purple-900/20"
         x-data="contact3D()"
         x-init="init()"
         @mousemove.window="handleMouseMove($event)">
    
    {{-- Animated Background --}}
    <div class="absolute inset-0">
        {{-- Gradient Orbs --}}
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full filter blur-[128px] opacity-20 animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full filter blur-[128px] opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
        
        {{-- Grid Pattern --}}
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="0.5" opacity="0.05"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"/%3E%3C/svg%3E')]"></div>
    </div>
    
    {{-- Floating Particles --}}
    <div class="absolute inset-0 pointer-events-none">
        @for($i = 0; $i < 20; $i++)
            <div class="particle absolute w-1 h-1 bg-blue-400 rounded-full opacity-40"
                 style="
                     top: {{ rand(0, 100) }}%;
                     left: {{ rand(0, 100) }}%;
                     animation: float-{{ $i }} {{ rand(15, 30) }}s infinite ease-in-out;
                 "></div>
        @endfor
    </div>
    
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-16 lg:mb-20">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-6"
                 x-data="{ show: false }"
                 x-init="setTimeout(() => show = true, 100)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-600"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-sm font-medium text-white/90">Available 24/7</span>
            </div>
            
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                <span class="bg-gradient-to-r from-white via-blue-200 to-purple-200 bg-clip-text text-transparent">
                    Let's Build Something Amazing
                </span>
            </h2>
            
            <p class="text-xl text-gray-300 leading-relaxed">
                Transform your WordPress vision into reality. Get in touch and let's discuss how Blitz can elevate your web presence.
            </p>
        </div>
        
        <div class="grid lg:grid-cols-2 gap-12 items-start">
            
            {{-- Contact Form Card --}}
            <div class="contact-form-card relative"
                 x-data="{ formHover: false }"
                 @mouseenter="formHover = true"
                 @mouseleave="formHover = false">
                
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-purple-600 rounded-3xl blur-xl opacity-30"
                     :style="`transform: translate(${mouseX * 0.02}px, ${mouseY * 0.02}px)`"></div>
                
                <div class="relative bg-white/10 backdrop-blur-md rounded-3xl p-8 md:p-10 border border-white/20 shadow-2xl"
                     :style="`transform: perspective(1000px) rotateY(${mouseX * 0.05}deg) rotateX(${-mouseY * 0.05}deg)`">
                    
                    <h3 class="text-2xl font-bold text-white mb-6">Send Us a Message</h3>
                    
                    <form @submit.prevent="submitForm" class="space-y-6">
                        {{-- Name Field --}}
                        <div class="form-group relative"
                             x-data="{ focused: false, filled: false }"
                             @focusin="focused = true"
                             @focusout="focused = false; filled = $event.target.value !== ''">
                            <input type="text"
                                   id="name"
                                   name="name"
                                   required
                                   class="w-full px-4 py-3 bg-white/5 border-2 border-white/10 rounded-xl text-white placeholder-transparent focus:border-blue-400 focus:bg-white/10 transition-all duration-300"
                                   placeholder="Your Name"
                                   @input="filled = $event.target.value !== ''">
                            <label for="name"
                                   class="absolute left-4 transition-all duration-300 pointer-events-none"
                                   :class="focused || filled ? 'text-xs -top-2 bg-slate-900 px-2 text-blue-400' : 'top-3 text-white/60'">
                                Your Name
                            </label>
                        </div>
                        
                        {{-- Email Field --}}
                        <div class="form-group relative"
                             x-data="{ focused: false, filled: false }">
                            <input type="email"
                                   id="email"
                                   name="email"
                                   required
                                   class="w-full px-4 py-3 bg-white/5 border-2 border-white/10 rounded-xl text-white placeholder-transparent focus:border-blue-400 focus:bg-white/10 transition-all duration-300"
                                   placeholder="Email"
                                   @focus="focused = true"
                                   @blur="focused = false; filled = $event.target.value !== ''"
                                   @input="filled = $event.target.value !== ''">
                            <label for="email"
                                   class="absolute left-4 transition-all duration-300 pointer-events-none"
                                   :class="focused || filled ? 'text-xs -top-2 bg-slate-900 px-2 text-blue-400' : 'top-3 text-white/60'">
                                Email Address
                            </label>
                        </div>
                        
                        {{-- Subject Field --}}
                        <div class="form-group relative"
                             x-data="{ focused: false, filled: false }">
                            <select id="subject"
                                    name="subject"
                                    required
                                    class="w-full px-4 py-3 bg-white/5 border-2 border-white/10 rounded-xl text-white focus:border-blue-400 focus:bg-white/10 transition-all duration-300"
                                    @focus="focused = true"
                                    @blur="focused = false; filled = $event.target.value !== ''"
                                    @change="filled = $event.target.value !== ''">
                                <option value="" class="bg-slate-900">Select a Subject</option>
                                <option value="general" class="bg-slate-900">General Inquiry</option>
                                <option value="support" class="bg-slate-900">Technical Support</option>
                                <option value="custom" class="bg-slate-900">Custom Development</option>
                                <option value="partnership" class="bg-slate-900">Partnership</option>
                            </select>
                        </div>
                        
                        {{-- Message Field --}}
                        <div class="form-group relative"
                             x-data="{ focused: false, filled: false, charCount: 0 }">
                            <textarea id="message"
                                      name="message"
                                      rows="4"
                                      required
                                      maxlength="500"
                                      class="w-full px-4 py-3 bg-white/5 border-2 border-white/10 rounded-xl text-white placeholder-transparent focus:border-blue-400 focus:bg-white/10 transition-all duration-300 resize-none"
                                      placeholder="Message"
                                      @focus="focused = true"
                                      @blur="focused = false; filled = $event.target.value !== ''"
                                      @input="filled = $event.target.value !== ''; charCount = $event.target.value.length"></textarea>
                            <label for="message"
                                   class="absolute left-4 transition-all duration-300 pointer-events-none"
                                   :class="focused || filled ? 'text-xs -top-2 bg-slate-900 px-2 text-blue-400' : 'top-3 text-white/60'">
                                Your Message
                            </label>
                            <div class="text-right mt-1 text-xs text-white/40">
                                <span x-text="charCount"></span>/500
                            </div>
                        </div>
                        
                        {{-- Submit Button --}}
                        <button type="submit"
                                class="group w-full relative overflow-hidden rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 p-px"
                                :disabled="loading">
                            <div class="relative flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-3 text-white font-semibold transition-all duration-300 group-hover:bg-opacity-0">
                                <template x-if="!loading">
                                    <span class="flex items-center gap-2">
                                        Send Message
                                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </span>
                                </template>
                                <template x-if="loading">
                                    <span class="flex items-center gap-2">
                                        <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                                        </svg>
                                        Sending...
                                    </span>
                                </template>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
            
            {{-- Contact Info Cards --}}
            <div class="space-y-6">
                {{-- Quick Contact Card --}}
                <div class="info-card relative group"
                     x-data="{ hover: false }"
                     @mouseenter="hover = true"
                     @mouseleave="hover = false">
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                    
                    <div class="relative bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 transition-all duration-500"
                         :class="{ 'scale-105': hover }"
                         :style="hover ? `transform: translateY(-4px)` : ''">
                        
                        <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <div class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            Quick Contact
                        </h3>
                        
                        <div class="space-y-3">
                            <a href="mailto:{{ $contactInfo['email'] }}" 
                               class="flex items-center gap-3 text-gray-300 hover:text-white transition-colors">
                                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                {{ $contactInfo['email'] }}
                            </a>
                            
                            <a href="tel:{{ str_replace(' ', '', $contactInfo['phone']) }}" 
                               class="flex items-center gap-3 text-gray-300 hover:text-white transition-colors">
                                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                {{ $contactInfo['phone'] }}
                            </a>
                            
                            <div class="flex items-start gap-3 text-gray-300">
                                <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $contactInfo['address'] }}</span>
                            </div>
                            
                            <div class="flex items-center gap-3 text-gray-300">
                                <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                {{ $contactInfo['hours'] }}
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Social Links Card --}}
                <div class="social-card relative group"
                     x-data="{ hover: false }"
                     @mouseenter="hover = true"
                     @mouseleave="hover = false">
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                    
                    <div class="relative bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                        <h3 class="text-xl font-bold text-white mb-4">Connect With Us</h3>
                        
                        <div class="grid grid-cols-4 gap-3">
                            @php
                                $socials = [
                                    ['name' => 'Facebook', 'icon' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z', 'color' => 'from-blue-400 to-blue-600'],
                                    ['name' => 'Twitter', 'icon' => 'M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z', 'color' => 'from-cyan-400 to-blue-500'],
                                    ['name' => 'LinkedIn', 'icon' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z', 'color' => 'from-blue-600 to-blue-800'],
                                    ['name' => 'GitHub', 'icon' => 'M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z', 'color' => 'from-gray-600 to-gray-800'],
                                ];
                            @endphp
                            
                            @foreach($socials as $social)
                                <a href="#" 
                                   class="social-link relative group/social"
                                   x-data="{ hoverSocial: false }"
                                   @mouseenter="hoverSocial = true"
                                   @mouseleave="hoverSocial = false">
                                    <div class="w-14 h-14 bg-white/10 rounded-xl flex items-center justify-center border border-white/20 transition-all duration-300"
                                         :class="{ 'scale-110 bg-gradient-to-br {{ $social['color'] }}': hoverSocial }">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="{{ $social['icon'] }}"/>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                {{-- FAQ Quick Links --}}
                <div class="faq-card relative">
                    <div class="relative bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                        <h3 class="text-xl font-bold text-white mb-4">Common Questions</h3>
                        
                        <div class="space-y-2">
                            <a href="#" class="block text-gray-300 hover:text-white transition-colors">
                                → How fast is Blitz Theme?
                            </a>
                            <a href="#" class="block text-gray-300 hover:text-white transition-colors">
                                → What's included in the package?
                            </a>
                            <a href="#" class="block text-gray-300 hover:text-white transition-colors">
                                → Do you provide support?
                            </a>
                            <a href="#" class="block text-gray-300 hover:text-white transition-colors">
                                → Can I customize the theme?
                            </a>
                        </div>
                        
                        <a href="#" class="inline-flex items-center gap-2 mt-4 text-blue-400 hover:text-blue-300 transition-colors">
                            View All FAQs
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Bottom CTA --}}
        <div class="mt-20 text-center">
            <div class="inline-flex items-center gap-4 px-8 py-4 bg-white/10 backdrop-blur-md rounded-full border border-white/20">
                <svg class="w-6 h-6 text-green-400 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                </svg>
                <span class="text-white">
                    Our team typically responds within 
                    <span class="font-bold text-green-400">2 hours</span> 
                    during business hours
                </span>
            </div>
        </div>
    </div>
</section>

{{-- Scoped Styles --}}
<style>
#{{ $blockId }} {
    position: relative;
}

#{{ $blockId }} .form-group input:focus,
#{{ $blockId }} .form-group textarea:focus,
#{{ $blockId }} .form-group select:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

#{{ $blockId }} .form-group label {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes float-0 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(30px, -30px); } }
@keyframes float-1 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-30px, 20px); } }
@keyframes float-2 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(20px, 30px); } }
@keyframes float-3 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-20px, -20px); } }
@keyframes float-4 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(25px, -15px); } }
@keyframes float-5 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-15px, 25px); } }
@keyframes float-6 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(15px, -25px); } }
@keyframes float-7 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-25px, 15px); } }
@keyframes float-8 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(35px, -10px); } }
@keyframes float-9 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-10px, 35px); } }
@keyframes float-10 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(10px, -35px); } }
@keyframes float-11 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-35px, 10px); } }
@keyframes float-12 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(40px, 0); } }
@keyframes float-13 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(0, 40px); } }
@keyframes float-14 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-40px, 0); } }
@keyframes float-15 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(0, -40px); } }
@keyframes float-16 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(30px, 30px); } }
@keyframes float-17 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-30px, -30px); } }
@keyframes float-18 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(20px, -40px); } }
@keyframes float-19 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-20px, 40px); } }
</style>

{{-- Block Script --}}
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('contact3D', () => ({
        mouseX: 0,
        mouseY: 0,
        loading: false,
        formData: {
            name: '',
            email: '',
            subject: '',
            message: ''
        },
        
        init() {
            // Initialize smooth animations
            this.setupAnimations();
            
            // Form validation setup
            this.setupFormValidation();
        },
        
        handleMouseMove(event) {
            const rect = this.$el.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            
            this.mouseX = (event.clientX - centerX) / (rect.width / 2);
            this.mouseY = (event.clientY - centerY) / (rect.height / 2);
        },
        
        async submitForm(event) {
            this.loading = true;
            
            // Get form data
            const formData = new FormData(event.target);
            
            try {
                // WordPress AJAX handler
                const response = await fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Success animation
                    this.showSuccess();
                    event.target.reset();
                } else {
                    this.showError(result.message);
                }
            } catch (error) {
                this.showError('An error occurred. Please try again.');
            } finally {
                this.loading = false;
            }
        },
        
        showSuccess() {
            // Create success notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl z-50 animate-slide-in';
            notification.innerHTML = `
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <span>Message sent successfully! We'll get back to you soon.</span>
                </div>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 5000);
        },
        
        showError(message) {
            // Create error notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-xl z-50 animate-slide-in';
            notification.innerHTML = `
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 5000);
        },
        
        setupAnimations() {
            // Intersection observer for scroll animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, { threshold: 0.1 });
            
            this.$el.querySelectorAll('.info-card, .social-card, .faq-card').forEach(card => {
                observer.observe(card);
            });
        },
        
        setupFormValidation() {
            // Real-time validation feedback
            const inputs = this.$el.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('invalid', (e) => {
                    e.preventDefault();
                    input.classList.add('border-red-500');
                });
                
                input.addEventListener('input', () => {
                    if (input.validity.valid) {
                        input.classList.remove('border-red-500');
                    }
                });
            });
        }
    }));
});
</script>