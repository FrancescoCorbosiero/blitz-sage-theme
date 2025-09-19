{{-- resources/views/sections/contact/contact-bento-grid.blade.php --}}
{{-- Modern Bento Grid Contact Section with ContactFormHandler Integration --}}

@php
$blockId = 'contact-' . uniqid();
$businessInfo = [
    'name' => get_bloginfo('name'),
    'email' => get_theme_mod('contact_email', 'contact@alpacode.studio'),
    'phone' => get_theme_mod('contact_phone', '+39 351 400 3240'),
    'whatsapp' => get_theme_mod('contact_whatsapp', '393514003240'),
    'address' => get_theme_mod('contact_address', 'Monza Brianza, Lombardia, Italia'),
    'response_time' => get_theme_mod('response_time', '48 ore'),
];

// Service options matching ContactFormHandler
$service_options = [
    'sito-web' => ['label' => 'Sito Web', 'icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9'],
    'ecommerce' => ['label' => 'E-commerce', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
    'webapp' => ['label' => 'Web App', 'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z'],
    'redesign' => ['label' => 'Redesign', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
    'consulenza' => ['label' => 'Consulenza', 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
    'altro' => ['label' => 'Altro', 'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
];

$timeline_options = [
    'asap' => 'Il prima possibile',
    '1-mese' => 'Entro 1 mese',
    '2-3-mesi' => 'Tra 2-3 mesi',
    'oltre' => 'Oltre 3 mesi'
];

$budget_options = [
    '1k-5k' => '€1.000 - €5.000',
    '5k-10k' => '€5.000 - €10.000',
    '10k-25k' => '€10.000 - €25.000',
    '25k-50k' => '€25.000 - €50.000',
    '50k+' => 'Oltre €50.000'
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
                <span class="text-sm font-medium text-purple-700 dark:text-purple-300">Iniziamo a collaborare</span>
            </div>
            
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                <span class="bg-gradient-to-r from-gray-900 via-purple-800 to-pink-800 dark:from-white dark:via-purple-300 dark:to-pink-300 bg-clip-text text-transparent">
                    Raccontaci il tuo progetto
                </span>
            </h2>
            
            <p class="text-xl text-gray-600 dark:text-gray-400 leading-relaxed">
                Siamo pronti a trasformare la tua visione in realtà digitale
            </p>
        </div>
        
        {{-- Bento Grid Layout --}}
        <div class="bento-grid grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            {{-- Main Contact Form - Spans 8 columns --}}
            <div class="lg:col-span-8 group"
                 x-data="{ formStep: 1, formHover: false, privacyAccepted: false, newsletterOptIn: false }"
                 @mouseenter="formHover = true"
                 @mouseleave="formHover = false">
                
                <div class="relative h-full bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden transition-all duration-500"
                     :class="{ 'shadow-2xl scale-[1.02]': formHover }">
                    
                    {{-- Gradient Border Effect --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 opacity-0 transition-opacity duration-500"
                         :class="{ 'opacity-10': formHover }"></div>
                    
                    <div class="relative p-8 lg:p-10">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Compila il form</h3>
                        
                        {{-- Progress Indicator --}}
                        <div class="flex items-center gap-2 mb-8">
                            <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-purple-500 to-pink-500 rounded-full transition-all duration-500"
                                     :style="`width: ${formStep === 1 ? '25%' : formStep === 2 ? '50%' : formStep === 3 ? '75%' : '100%'}`"></div>
                            </div>
                            <span class="text-sm text-gray-500">Passo <span x-text="formStep"></span> di 4</span>
                        </div>
                        
                        <form @submit.prevent="submitForm" 
                              id="contact-form"
                              class="space-y-6">
                            
                            {{-- Hidden nonce field --}}
                            <input type="hidden" name="nonce" value="{{ wp_create_nonce('contact-form') }}">
                            
                            {{-- Step 1: Personal Info --}}
                            <div x-show="formStep === 1" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-x-4"
                                 x-transition:enter-end="opacity-100 translate-x-0">
                                
                                <div class="space-y-4">
                                    {{-- Name --}}
                                    <div class="form-field relative">
                                        <input type="text" 
                                               name="name" 
                                               required
                                               class="peer w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-purple-500 focus:outline-none transition-colors"
                                               placeholder=" "
                                               x-model="formData.name">
                                        <label class="absolute left-4 top-3 text-gray-500 transition-all duration-300 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:text-purple-500 peer-[:not(:placeholder-shown)]:-translate-y-6 peer-[:not(:placeholder-shown)]:scale-90">
                                            Nome completo *
                                        </label>
                                    </div>
                                    
                                    {{-- Email --}}
                                    <div class="form-field relative">
                                        <input type="email" 
                                               name="email" 
                                               required
                                               class="peer w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-purple-500 focus:outline-none transition-colors"
                                               placeholder=" "
                                               x-model="formData.email">
                                        <label class="absolute left-4 top-3 text-gray-500 transition-all duration-300 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:text-purple-500 peer-[:not(:placeholder-shown)]:-translate-y-6 peer-[:not(:placeholder-shown)]:scale-90">
                                            Email *
                                        </label>
                                    </div>
                                    
                                    <div class="grid md:grid-cols-2 gap-4">
                                        {{-- Company --}}
                                        <div class="form-field relative">
                                            <input type="text" 
                                                   name="company"
                                                   class="peer w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-purple-500 focus:outline-none transition-colors"
                                                   placeholder=" "
                                                   x-model="formData.company">
                                            <label class="absolute left-4 top-3 text-gray-500 transition-all duration-300 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:text-purple-500 peer-[:not(:placeholder-shown)]:-translate-y-6 peer-[:not(:placeholder-shown)]:scale-90">
                                                Azienda
                                            </label>
                                        </div>
                                        
                                        {{-- Phone --}}
                                        <div class="form-field relative">
                                            <input type="tel" 
                                                   name="phone"
                                                   class="peer w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-purple-500 focus:outline-none transition-colors"
                                                   placeholder=" "
                                                   x-model="formData.phone">
                                            <label class="absolute left-4 top-3 text-gray-500 transition-all duration-300 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:text-purple-500 peer-[:not(:placeholder-shown)]:-translate-y-6 peer-[:not(:placeholder-shown)]:scale-90">
                                                Telefono
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="button"
                                        @click="formStep = 2"
                                        class="w-full mt-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-300 transform hover:scale-[1.02]">
                                    Avanti →
                                </button>
                            </div>
                            
                            {{-- Step 2: Service Selection --}}
                            <div x-show="formStep === 2"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-x-4"
                                 x-transition:enter-end="opacity-100 translate-x-0">
                                
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                        Di cosa hai bisogno? *
                                    </label>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                        @foreach($service_options as $value => $service)
                                            <label class="service-option cursor-pointer">
                                                <input type="radio" 
                                                       name="service" 
                                                       value="{{ $value }}"
                                                       required
                                                       class="sr-only peer"
                                                       x-model="formData.service">
                                                <div class="p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/20 transition-all duration-300 hover:shadow-lg">
                                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-400 peer-checked:text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $service['icon'] }}"/>
                                                    </svg>
                                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $service['label'] }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="flex gap-3 mt-6">
                                    <button type="button"
                                            @click="formStep = 1"
                                            class="flex-1 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                        ← Indietro
                                    </button>
                                    <button type="button"
                                            @click="formStep = 3"
                                            class="flex-1 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-300">
                                        Avanti →
                                    </button>
                                </div>
                            </div>
                            
                            {{-- Step 3: Project Details --}}
                            <div x-show="formStep === 3"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-x-4"
                                 x-transition:enter-end="opacity-100 translate-x-0">
                                
                                <div class="space-y-4">
                                    {{-- Budget --}}
                                    <div>
                                        <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Budget indicativo
                                        </label>
                                        <select name="budget"
                                                id="budget"
                                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-purple-500 focus:outline-none transition-colors"
                                                x-model="formData.budget">
                                            <option value="">Seleziona un budget</option>
                                            @foreach($budget_options as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    {{-- Timeline --}}
                                    <div>
                                        <label for="timeline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Tempistiche *
                                        </label>
                                        <select name="timeline"
                                                id="timeline"
                                                required
                                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-purple-500 focus:outline-none transition-colors"
                                                x-model="formData.timeline">
                                            <option value="">Quando vuoi iniziare?</option>
                                            @foreach($timeline_options as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    {{-- Message --}}
                                    <div>
                                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Descrivi il tuo progetto *
                                        </label>
                                        <textarea name="message"
                                                  id="message"
                                                  rows="4"
                                                  required
                                                  class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-purple-500 focus:outline-none transition-colors resize-none"
                                                  placeholder="Raccontaci la tua idea, gli obiettivi e qualsiasi requisito specifico..."
                                                  x-model="formData.message"></textarea>
                                    </div>
                                </div>
                                
                                <div class="flex gap-3 mt-6">
                                    <button type="button"
                                            @click="formStep = 2"
                                            class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                        ← Indietro
                                    </button>
                                    <button type="button"
                                            @click="formStep = 4"
                                            class="flex-1 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-300">
                                        Quasi fatto →
                                    </button>
                                </div>
                            </div>
                            
                            {{-- Step 4: Privacy & Submit --}}
                            <div x-show="formStep === 4"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-x-4"
                                 x-transition:enter-end="opacity-100 translate-x-0">
                                
                                <div class="space-y-4">
                                    {{-- Newsletter Opt-in --}}
                                    <label class="flex items-start gap-3 cursor-pointer p-4 bg-gray-50 dark:bg-gray-900 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                        <input type="checkbox" 
                                               name="newsletter" 
                                               class="mt-1 w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                                               x-model="newsletterOptIn">
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">Iscrivimi alla newsletter</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Ricevi aggiornamenti su design, sviluppo web e marketing digitale</div>
                                        </div>
                                    </label>
                                    
                                    {{-- Privacy Policy --}}
                                    <label class="flex items-start gap-3 cursor-pointer p-4 bg-purple-50 dark:bg-purple-900/20 border-2 border-purple-200 dark:border-purple-800 rounded-xl">
                                        <input type="checkbox" 
                                               name="privacy" 
                                               required
                                               class="mt-1 w-5 h-5 text-purple-600 border-purple-300 rounded focus:ring-purple-500"
                                               x-model="privacyAccepted">
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                Accetto la Privacy Policy *
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Ho letto e accetto la <a href="/privacy-policy" target="_blank" class="text-purple-600 hover:underline">Privacy Policy</a> 
                                                e autorizzo il trattamento dei miei dati personali
                                            </div>
                                        </div>
                                    </label>
                                    
                                    {{-- Error message --}}
                                    <div x-show="showError" 
                                         x-transition
                                         class="p-4 bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-xl">
                                        <p class="text-red-600 dark:text-red-400 text-sm" x-text="errorMessage"></p>
                                    </div>
                                    
                                    {{-- Success message --}}
                                    <div x-show="showSuccess" 
                                         x-transition
                                         class="p-4 bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800 rounded-xl">
                                        <p class="text-green-600 dark:text-green-400 text-sm">Messaggio inviato con successo! Ti risponderemo presto.</p>
                                    </div>
                                </div>
                                
                                <div class="flex gap-3 mt-6">
                                    <button type="button"
                                            @click="formStep = 3"
                                            class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                        ← Indietro
                                    </button>
                                    <button type="submit"
                                            class="flex-1 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white font-semibold rounded-xl hover:from-green-600 hover:to-emerald-600 transition-all duration-300 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed"
                                            :disabled="loading || !privacyAccepted">
                                        <span x-show="!loading">Invia Richiesta ✨</span>
                                        <span x-show="loading" class="flex items-center justify-center gap-2">
                                            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                            </svg>
                                            Invio in corso...
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
                <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-3xl p-6 text-white shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 0116 0zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="text-3xl font-bold">{{ str_replace(' ore', 'h', $businessInfo['response_time']) }}</span>
                    </div>
                    <h4 class="text-lg font-semibold mb-1">Tempo di risposta</h4>
                    <p class="text-white/80 text-sm">Ti risponderemo entro {{ $businessInfo['response_time'] }} lavorative</p>
                </div>
                
                {{-- Contact Methods --}}
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Contatto diretto</h4>
                    
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
                        
                        <a href="https://wa.me/{{ $businessInfo['whatsapp'] }}" 
                           target="_blank"
                           class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900 rounded-xl hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors group">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414-.074-.123-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">WhatsApp</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $businessInfo['phone'] }}</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            {{-- FAQ Section - Spans 6 columns --}}
            <div class="lg:col-span-6">
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl h-full">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Domande frequenti</h4>
                    
                    <div class="space-y-3" x-data="{ activeQuestion: null }">
                        @php
                            $faqs = [
                                ['q' => 'Quanto tempo richiede un sito web?', 'a' => 'Un sito web standard richiede 3-6 settimane. Progetti più complessi come e-commerce o web app possono richiedere 2-3 mesi.'],
                                ['q' => 'Offrite servizi di manutenzione?', 'a' => 'Sì, offriamo pacchetti di manutenzione mensili che includono aggiornamenti, backup, sicurezza e supporto tecnico.'],
                                ['q' => 'Posso vedere esempi dei vostri lavori?', 'a' => 'Certamente! Visita la sezione Portfolio per vedere i nostri progetti più recenti e case study dettagliati.'],
                                ['q' => 'Come funziona il processo di sviluppo?', 'a' => 'Iniziamo con una consulenza gratuita, seguita da proposta e preventivo. Dopo l\'approvazione, procediamo con design, sviluppo, test e lancio.'],
                            ];
                        @endphp
                        
                        @foreach($faqs as $index => $faq)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                                <button @click="activeQuestion = activeQuestion === {{ $index }} ? null : {{ $index }}"
                                        class="w-full px-4 py-3 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white pr-2">{{ $faq['q'] }}</span>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform flex-shrink-0"
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
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Dove siamo</h4>
                        
                        <div class="flex items-start gap-3 mb-4">
                            <div class="w-10 h-10 bg-white dark:bg-gray-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $businessInfo['address'] }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Lunedì - Venerdì, 9:00 - 18:00</p>
                            </div>
                        </div>
                        
                        {{-- Trust Badges --}}
                        <div class="grid grid-cols-3 gap-3 mt-6">
                            <div class="text-center p-3 bg-white dark:bg-gray-900 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600">50+</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Progetti</div>
                            </div>
                            <div class="text-center p-3 bg-white dark:bg-gray-900 rounded-lg">
                                <div class="text-2xl font-bold text-green-600">100%</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Clienti soddisfatti</div>
                            </div>
                            <div class="text-center p-3 bg-white dark:bg-gray-900 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">5★</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Recensioni</div>
                            </div>
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
        showError: false,
        showSuccess: false,
        errorMessage: '',
        formData: {
            name: '',
            email: '',
            company: '',
            phone: '',
            service: '',
            budget: '',
            timeline: '',
            message: ''
        },
        
        init() {
            this.setupInteractions();
        },
        
        async submitForm(event) {
            event.preventDefault();
            this.loading = true;
            this.showError = false;
            this.showSuccess = false;
            
            // Get form element
            const form = event.target;
            const formData = new FormData(form);
            
            // Add action for WordPress AJAX
            formData.append('action', 'handle_contact_form');
            
            try {
                const response = await fetch(contact_form_ajax.ajax_url, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                });
                
                const result = await response.json();
                
                if (result.success) {
                    this.showSuccess = true;
                    this.resetForm();
                    
                    // Optional: redirect after success
                    if (result.data && result.data.redirect) {
                        setTimeout(() => {
                            window.location.href = result.data.redirect;
                        }, 2000);
                    }
                } else {
                    this.showError = true;
                    this.errorMessage = result.data ? result.data.message : 'Si è verificato un errore. Riprova.';
                }
            } catch (error) {
                console.error('Form submission error:', error);
                this.showError = true;
                this.errorMessage = 'Errore di connessione. Per favore contattaci direttamente via email o WhatsApp.';
            } finally {
                this.loading = false;
            }
        },
        
        resetForm() {
            // Reset all form data
            Object.keys(this.formData).forEach(key => {
                this.formData[key] = '';
            });
            
            // Reset form element
            const form = document.getElementById('contact-form');
            if (form) {
                form.reset();
            }
            
            // Reset to first step
            const formElement = this.$el.querySelector('[x-data*="formStep"]');
            if (formElement && formElement.__x) {
                formElement.__x.$data.formStep = 1;
                formElement.__x.$data.privacyAccepted = false;
                formElement.__x.$data.newsletterOptIn = false;
            }
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