  {{-- Testimonials - Warm and Friendly --}}
  <section id="testimonianze" class="py-16 lg:py-24 bg-gradient-to-br from-cream to-white">
    <div class="container max-w-7xl mx-auto px-6 lg:px-8">
      <div class="text-center mb-12 lg:mb-16">
        <div class="inline-flex items-center gap-2 text-orange-500 mb-4">
          <span class="text-2xl">💕</span>
          <span class="font-medium">Testimonianze</span>
          <span class="text-2xl">💕</span>
        </div>
        <h2 class="text-3xl lg:text-5xl font-display font-bold text-gray-900 mb-4">
          Storie che parlano da sole
        </h2>
        <p class="text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto">
          Ogni cane ha trovato il suo spazio di serenità
        </p>
      </div>
      
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        @php
          $testimonials = [
            [
              'quote' => 'Luna era sempre stressata al parco pubblico. Qui è rinata: corre, gioca e si rilassa come mai prima.',
              'author' => 'Giulia M.',
              'dog' => 'Luna, Pastore Tedesco',
              'rating' => 5,
              'emoji' => '🐕‍🦺'
            ],
            [
              'quote' => 'Il profiling con Team Branco è stato illuminante. Ora capisco meglio le esigenze di Max.',
              'author' => 'Marco R.',
              'dog' => 'Max, Labrador',
              'rating' => 5,
              'emoji' => '🦮'
            ],
            [
              'quote' => 'Finalmente un posto dove Bella può essere se stessa senza giudizi. Vale ogni centesimo.',
              'author' => 'Elena S.',
              'dog' => 'Bella, Meticcio',
              'rating' => 5,
              'emoji' => '🐕'
            ]
          ];
        @endphp
        
        @foreach($testimonials as $index => $testimonial)
          <div class="testimonial-card">
            {{-- Dog emoji decoration --}}
            <div class="absolute top-4 right-4 text-3xl opacity-20">{{ $testimonial['emoji'] }}</div>
            
            <div class="relative">
              {{-- Rating with paws --}}
              <div class="flex gap-1 mb-4">
                @for($i = 0; $i < $testimonial['rating']; $i++)
                  <span class="text-orange-400 text-lg">🐾</span>
                @endfor
              </div>
              
              <p class="text-gray-700 mb-6 leading-relaxed italic">
                "{{ $testimonial['quote'] }}"
              </p>
              
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                  <span class="text-xl">{{ $testimonial['emoji'] }}</span>
                </div>
                <div>
                  <p class="font-semibold text-gray-900">{{ $testimonial['author'] }}</p>
                  <p class="text-sm text-gray-600">{{ $testimonial['dog'] }}</p>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      
      {{-- CTA after testimonials --}}
      <div class="text-center mt-12">
        <p class="text-gray-600 mb-4">Unisciti alle famiglie felici!</p>
        <a href="{{ home_url('/prenota') }}" class="btn-primary inline-flex items-center">
          <span>Prenota la tua prima visita</span>
          <span class="ml-2">🎾</span>
        </a>
      </div>
    </div>
  </section>

  @push('styles')
  <style>
    .testimonial-card {
      position: relative;
      background: var(--card-bg);
      padding: 2.5rem;
      border-radius: 24px;
      transition: all 0.4s var(--ease-default);
      border: 1px solid var(--border-color);
    }

    .testimonial-card::before {
      content: '"';
      position: absolute;
      top: 1.5rem;
      left: 2rem;
      font-size: 5rem;
      font-family: var(--font-display);
      color: var(--primary-soft);
      opacity: 0.1;
      font-weight: 900;
      line-height: 1;
    }

    .testimonial-card:hover {
      transform: translateY(-4px);
      box-shadow: 
        0 20px 40px var(--shadow),
        0 5px 10px var(--shadow);
    }
  </style>
  @endpush