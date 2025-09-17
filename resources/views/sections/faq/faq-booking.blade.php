{{-- FAQ Booking Section --}}
<section class="faq-booking py-20 bg-gradient-to-b from-bg-secondary to-bg-primary">
    <div class="container max-w-4xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4">
                {{ __('Frequently Asked Questions', 'blitz') }}
            </h2>
            <p class="text-lg text-text-secondary">
                {{ __('Everything you need to know about booking', 'blitz') }}
            </p>
        </div>
        
        <div class="space-y-4" x-data="{ openFaq: null }">
            @php
                $faqs = [
                    [
                        'question' => __('How do I make a reservation?', 'blitz'),
                        'answer' => __('You can book directly through our online calendar, send us a WhatsApp message, or call us. You will receive immediate confirmation via email and SMS.', 'blitz')
                    ],
                    [
                        'question' => __('What is included in the price?', 'blitz'),
                        'answer' => __('The price includes exclusive use of our private area, basic equipment (bowls, toys), and professional assistance. Additional services like profiling are separate.', 'blitz')
                    ],
                    [
                        'question' => __('Can I cancel my reservation?', 'blitz'),
                        'answer' => __('Yes, you can cancel free of charge up to 24 hours before your scheduled time. For cancellations with less notice, a 50% fee applies.', 'blitz')
                    ],
                    [
                        'question' => __('How many dogs can I bring?', 'blitz'),
                        'answer' => __('You can bring up to 5 dogs per session. For larger groups, please contact us to discuss special arrangements.', 'blitz')
                    ],
                    [
                        'question' => __('What payment methods do you accept?', 'blitz'),
                        'answer' => __('We accept all major credit cards through Stripe, PayPal, and cash payments on-site. Payment is required at the time of booking.', 'blitz')
                    ]
                ];
            @endphp
            
            @foreach($faqs as $index => $faq)
                <div class="faq-item bg-card-bg border border-border-color rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
                            class="faq-question w-full text-left p-6 flex items-center justify-between hover:bg-bg-tertiary transition-colors">
                        <span class="font-semibold text-text-primary pr-4">{{ $faq['question'] }}</span>
                        <svg class="w-5 h-5 text-text-muted transition-transform duration-200"
                             :class="{ 'rotate-180': openFaq === {{ $index }} }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="openFaq === {{ $index }}"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 max-h-0"
                         x-transition:enter-end="opacity-100 max-h-96"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 max-h-96"
                         x-transition:leave-end="opacity-0 max-h-0"
                         class="faq-answer overflow-hidden">
                        <div class="p-6 pt-0 text-text-secondary">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <p class="text-text-muted mb-4">{{ __('Still have questions?', 'blitz') }}</p>
            <a href="https://wa.me/{{ get_theme_mod('whatsapp_number', '393331234567') }}" 
               target="_blank"
               class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                {{ __('Contact Us', 'blitz') }}
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
            </a>
        </div>
    </div>
</section>