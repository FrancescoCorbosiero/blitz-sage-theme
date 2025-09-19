{{-- resources/views/sections/contact/contact-bento-grid.blade.php --}}
{{-- Modern Bento Grid Contact Section with Dynamic Interactions --}}

@php
$blockId = 'contact-' . uniqid();
$businessInfo = [
    'name' => get_bloginfo('name'),
    'email' => get_theme_mod('contact_email', 'hello@blitztheme.com'),
    'phone' => get_theme_mod('contact_phone', '+1 (555) 123-4567'),
    'address' => get_theme_mod('contact_address', 'San Francisco, CA'),
    'response_time' => get_theme_mod('response_time', '2 hours'),
];
@endphp

<section id="{{ $blockId }}" 
         class="contact-bento relative py-20 lg:py-32 bg-gradient-to-br from-gray-50 via-white to-gray-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 overflow-hidden"
         x-data="contactBento()"
         x-init="init()">
    
    {{-- Animated Background Elements --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-br from-purple-300 to-pink-300 rounded-full filter blur-3xl opacity-20 animate-float"></div>
        <div class="absolute bottom-40 right-20 w-96 h-96 bg-gradient-to-br from-blue-300 to-cyan-300 rounded-full filter blur-3xl opacity-20 animate-float-delayed"></div>
    </div>
    
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-12 lg:mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 rounded-full mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                </span>
                <span class="text-sm font-medium text-purple-700 dark:text-purple-300">Let's Connect</span>
            </div>
            
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                <span class="bg-gradient-to-r from-gray-900 via-purple-800 to-pink-800 dark:from-white dark:via-purple-300 dark:to-pink-300 bg-clip-text text-transparent">
                    Get in Touch
                </span>
            </h2>
            
            <p class="text-xl text-gray-600 dark:text-gray-400 leading-relaxed">
                Have a project in mind? Let's create something amazing together.
            </p>
        </div>
        
        {{-- Bento Grid Layout --}}
        <div class="bento-grid grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            {{-- Main Contact Form - Spans 8 columns --}}
            <div class="lg:col-span-8 group"
                 x-data="{ formStep: 1, formHover: false }"
                 @mouseenter="formHover = true"
                 @mouseleave="formHover = false">
                
                <div class="relative h-full bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden transition-all duration-500"
                     :class="{ 'shadow-2xl scale-[1.02]': formHover }">
                    
                    {{-- Gradient Border Effect --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 opacity-0 transition-opacity duration-500"
                         :class="{ 'opacity-10': formHover }"></div>
                    
                    <div class="relative p-8 lg:p-10">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Send a Message</h3>
                        
                        {{-- Progress Indicator --}}
                        <div class="flex items-center gap-2 mb-8">
                            <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-purple-500 to-pink-500 rounded-full transition-all duration-500"
                                     :style="`width: ${formStep === 1 ? '33%' : formStep === 2 ? '66%' : '100%'}`"></div>
                            </div>
                        </div>
                        
                        <form @submit.prevent="submitForm" class="space-y-6">
                            {{-- Step 1: Personal Info --}}
                            <div x-show="formStep === 1" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-x-4"
                                 x-transition:enter-end="opacity-100 translate-x-0">
                                
                                <div class="grid md:grid-cols-2 gap-4 mb-4">
                                    <div class="form-field relative">
                                        <input type="text" 
                                               name="name" 
                                               required
                                               class="peer w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-purple-500 focus:outline-none transition-colors"
                                               placeholder=" "
                                               x-model="formData.name">
                                        <label class="absolute left-4 top-3 text-gray-500 transition-all duration-300 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:text-purple-500 peer-[:not(:placeholder-shown)]:-translate-y-6 peer-[:not(:placeholder-shown)]:scale-90">
                                            Your Name
                                        </label>
                                    </div>
                                    
                                    <div class="form-field relative">
                                        <input type="email" 
                                               name="email" 
                                               required
                                               class="peer w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-purple-500 focus:outline-none transition-colors"
                                               placeholder=" "
                                               x-model="formData.email">
                                        <label class="absolute left-4 top-3 text-gray-500 transition-all duration-300 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:text-purple-500 peer-[:not(:placeholder-shown)]:-translate-y-6 peer-[:not(:placeholder-shown)]:scale-90">
                                            Email Address
                                        </label>
                                    </div>
                                </div>
                                
                                <button type="button"
                                        @click="formStep = 2"
                                        class="w-full py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-300 transform hover:scale-[1.02]">
                                    Next Step →
                                </button>
                            </div>
                            
                            {{-- Step 2: Project Info --}}
                            <div x-show="formStep === 2"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-x-4"
                                 x-transition:enter-end="opacity-100 translate-x-0">
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        What can we help you with?
                                    </label>
                                    <div class="grid grid-cols-2 gap-3">
                                        @php
                                            $services = [
                                                ['value' => 'website', 'label' => 'Website', 'icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9'],
                                                ['value' => 'seo', 'label' => 'SEO', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                                                ['value' => 'design', 'label' => 'Design', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                                                ['value' => 'other', 'label' => 'Other', 'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                            ];
                                        @endphp
                                        
                                        @foreach($services as $service)
                                            <label class="service-option cursor-pointer">
                                                <input type="radio" 
                                                       name="service" 
                                                       value="{{ $service['value'] }}"
                                                       class="sr-only peer"
                                                       x-model="formData.service">
                                                <div class="p-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/20 transition-all duration-300">
                                                    <svg class="w-6 h-6 mx-auto mb-1 text-gray-400 peer-checked:text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $service['icon'] }}"/>
                                                    </svg>
                                                    <span class="text-xs font-medium text-gray-600 dark:text-gray-400">{{ $service['label'] }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="flex gap-3">
                                    <button type="button"
                                            @click="formStep = 1"
                                            class="flex-1 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                        ← Back
                                    </button>
                                    <button type="button"
                                            @click="formStep = 3"
                                            class="flex-1 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-300">
                                        Next →
                                    </button>
                                </div>
                            </div>
                            
                            {{-- Step 3: Message --}}
                            <div x-show="formStep === 3"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-x-4"
                                 x-transition:enter-end="opacity-100 translate-x-0">
                                
                                <div class="mb-4">
                                    <textarea name="message"
                                              rows="4"
                                              class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-purple-500 focus:outline-none transition-colors resize-none"
                                              placeholder="Tell us about your project..."
                                              x-model="formData.message"></textarea>
                                </div>
                                
                                <div class="flex gap-3">
                                    <button type="button"
                                            @click="formStep = 2"
                                            class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                        ← Back
                                    </button>
                                    <button type="submit"
                                            class="flex-1 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white font-semibold rounded-xl hover:from-green-600 hover:to-emerald-600 transition-all duration-300 transform hover:scale-[1.02]"
                                            :disabled="loading">
                                        <span x-show="!loading">Send Message ✨</span>
                                        <span x-show="loading" class="flex items-center justify-center gap-2">
                                            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                            </svg>
                                            Sending...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            {{-- Quick Contact Card - Spans 4 columns --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- Response Time Card --}}
                <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-3xl p-6 text-white shadow-xl"
                     x-data="{ count: 0 }"
                     x-intersect:enter.once="
                         let target = {{ (int)str_replace(' hours', '', $businessInfo['response_time']) }};
                         let interval = setInterval(() => {
                             if (count < target) {
                                 count += 0.1;
                             } else {
                                 count = target;
                                 clearInterval(interval);
                             }
                         }, 50);
                     ">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 0116 0zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="text-3xl font-bold" x-text="count.toFixed(1) + 'h'"></span>
                    </div>
                    <h4 class="text-lg font-semibold mb-1">Average Response Time</h4>
                    <p class="text-white/80 text-sm">We'll get back to you quickly</p>
                </div>
                
                {{-- Contact Methods --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Direct Contact</h4>
                    
                    <div class="space-y-3">
                        <a href="mailto:{{ $businessInfo['email'] }}" 
                           class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900 rounded-xl hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors group">
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Email</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $businessInfo['email'] }}</div>
                            </div>
                        </a>
                        
                        <a href="tel:{{ str_replace(' ', '', $businessInfo['phone']) }}" 
                           class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900 rounded-xl hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors group">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Phone</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $businessInfo['phone'] }}</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            {{-- FAQ Section - Spans 6 columns --}}
            <div class="lg:col-span-6">
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl h-full">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Common Questions</h4>
                    
                    <div class="space-y-3" x-data="{ activeQuestion: null }">
                        @php
                            $faqs = [
                                ['q' => 'How quickly do you respond?', 'a' => 'We typically respond within 2 hours during business hours.'],
                                ['q' => 'What services do you offer?', 'a' => 'We offer web development, design, SEO, and digital marketing services.'],
                                ['q' => 'Do you work with small businesses?', 'a' => 'Yes! We work with businesses of all sizes, from startups to enterprises.'],
                            ];
                        @endphp
                        
                        @foreach($faqs as $index => $faq)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                                <button @click="activeQuestion = activeQuestion === {{ $index }} ? null : {{ $index }}"
                                        class="w-full px-4 py-3 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $faq['q'] }}</span>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform"
                                         :class="{ 'rotate-180': activeQuestion === {{ $index }} }"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="activeQuestion === {{ $index }}"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 -translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="px-4 pb-3">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $faq['a'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            {{-- Location Card - Spans 6 columns --}}
            <div class="lg:col-span-6">
                <div class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-3xl p-6 shadow-xl h-full relative overflow-hidden">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="black" stroke-width="0.5" opacity="0.1"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"/%3E%3C/svg%3E')]"></div>
                    
                    <div class="relative">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Find Us</h4>
                        
                        <div class="flex items-start gap-3 mb-4">
                            <div class="w-10 h-10 bg-white dark:bg-gray-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $businessInfo['address'] }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Open Mon-Fri, 9AM-6PM PST</p>
                            </div>
                        </div>
                        
                        {{-- Map Placeholder --}}
                        <div class="aspect-video bg-gray-300 dark:bg-gray-600 rounded-xl flex items-center justify-center">
                            <span class="text-gray-500 dark:text-gray-400">Map Integration</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Scoped Styles --}}
<style>
#{{ $blockId }} .form-field input:focus ~ label,
#{{ $blockId }} .form-field input:not(:placeholder-shown) ~ label {
    transform: translateY(-1.5rem) scale(0.9);
    background: linear-gradient(to bottom, transparent 0%, transparent 40%, white 40%, white 60%, transparent 60%, transparent 100%);
    padding: 0 0.25rem;
}

.dark #{{ $blockId }} .form-field input:focus ~ label,
.dark #{{ $blockId }} .form-field input:not(:placeholder-shown) ~ label {
    background: linear-gradient(to bottom, transparent 0%, transparent 40%, rgb(31, 41, 55) 40%, rgb(31, 41, 55) 60%, transparent 60%, transparent 100%);
}

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(10deg); }
}

@keyframes float-delayed {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-30px) rotate(-10deg); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 8s ease-in-out infinite;
    animation-delay: 2s;
}

#{{ $blockId }} .bento-grid > div {
    animation: slideUp 0.6s ease-out forwards;
    opacity: 0;
    transform: translateY(20px);
}

#{{ $blockId }} .bento-grid > div:nth-child(1) { animation-delay: 0.1s; }
#{{ $blockId }} .bento-grid > div:nth-child(2) { animation-delay: 0.2s; }
#{{ $blockId }} .bento-grid > div:nth-child(3) { animation-delay: 0.3s; }
#{{ $blockId }} .bento-grid > div:nth-child(4) { animation-delay: 0.4s; }

@keyframes slideUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

{{-- Block Script --}}
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('contactBento', () => ({
        loading: false,
        formData: {
            name: '',
            email: '',
            service: '',
            message: ''
        },
        
        init() {
            this.setupInteractions();
        },
        
        async submitForm() {
            this.loading = true;
            
            // Simulate API call
            await new Promise(resolve => setTimeout(resolve, 2000));
            
            // Show success notification
            this.showNotification('Success! We\'ll be in touch soon. 🎉');
            
            // Reset form
            this.resetForm();
            this.loading = false;
        },
        
        resetForm() {
            Object.keys(this.formData).forEach(key => {
                this.formData[key] = '';
            });
            
            // Reset to first step
            const formElement = this.$el.querySelector('[x-data*="formStep"]');
            if (formElement && formElement.__x) {
                formElement.__x.$data.formStep = 1;
            }
        },
        
        showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed bottom-4 right-4 px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-2xl shadow-2xl z-50 transform transition-all duration-500 translate-y-full';
            notification.innerHTML = `
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateY(0)';
            }, 100);
            
            // Remove after delay
            setTimeout(() => {
                notification.style.transform = 'translateY(100%)';
                setTimeout(() => notification.remove(), 500);
            }, 5000);
        },
        
        setupInteractions() {
            // Add hover effects to cards
            const cards = this.$el.querySelectorAll('.bento-grid > div');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-2px)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0)';
                });
            });
        }
    }));
});
</script>