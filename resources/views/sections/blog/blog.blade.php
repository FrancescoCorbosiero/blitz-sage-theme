{{-- Blog Preview Section - SEO & Content Marketing --}}
<section class="blog-preview-section relative py-16 lg:py-24 bg-gradient-to-br from-white via-green-50/20 to-white overflow-hidden">
  {{-- Decorative elements --}}
  <div class="absolute inset-0 opacity-5">
    <div class="absolute top-20 left-10 text-6xl">📚</div>
    <div class="absolute bottom-20 right-10 text-6xl">✍️</div>
  </div>

  <div class="container max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
    
    {{-- Section Header --}}
    <div class="text-center mb-12 lg:mb-16">
      <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-100 border border-purple-200 rounded-full mb-4">
        <span class="text-purple-600">📖</span>
        <span class="text-sm font-semibold text-purple-900">Dal nostro blog</span>
      </div>
      
      <h2 class="text-3xl lg:text-5xl font-display font-bold text-gray-900 mb-4">
        Consigli utili per te e il tuo cane
      </h2>
      <p class="text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto">
        Guide pratiche, storie di successo e tutto quello che serve sapere 
        per cani felici e proprietari sereni.
      </p>
    </div>

    {{-- Featured Article --}}
    <div class="mb-12">
      <article class="bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-shadow duration-300">
        <div class="grid lg:grid-cols-2">
          {{-- Featured Image --}}
          <div class="relative h-64 lg:h-auto bg-gradient-to-br from-purple-100 to-pink-100">
            <img src="{{ Vite::asset('resources/images/blog/cane-reattivo-hero.jpg') }}" 
                 alt="Cane reattivo che gioca libero" 
                 class="w-full h-full object-cover">
            <div class="absolute top-4 left-4">
              <span class="px-3 py-1 bg-red-600 text-white text-xs font-bold rounded-full shadow-lg">
                PIÙ LETTO
              </span>
            </div>
          </div>
          
          {{-- Featured Content --}}
          <div class="p-8 lg:p-10">
            <div class="flex items-center gap-3 text-sm text-gray-500 mb-4">
              <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">
                Comportamento
              </span>
              <span>•</span>
              <span>5 min lettura</span>
              <span>•</span>
              <span>2 giorni fa</span>
            </div>
            
            <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4 hover:text-green-600 transition-colors">
              <a href="{{ home_url('/blog/cane-reattivo-5-segnali') }}">
                5 Segnali che il Tuo Cane Ha Bisogno di Più Privacy
              </a>
            </h3>
            
            <p class="text-gray-600 mb-6 line-clamp-3">
              Non tutti i cani sono farfalle sociali, e va benissimo così. 
              Se il tuo cane mostra questi comportamenti, potrebbe comunicarti 
              il bisogno di spazi più tranquilli e controllati. Scopri come riconoscere 
              i segnali e cosa fare per aiutarlo...
            </p>
            
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-3">
                <img src="https://i.pravatar.cc/40?img=5" 
                     alt="Dr. Laura Bianchi" 
                     class="w-10 h-10 rounded-full">
                <div>
                  <p class="font-medium text-gray-900 text-sm">Dr. Laura Bianchi</p>
                  <p class="text-xs text-gray-500">Team Branco Expert</p>
                </div>
              </div>
              
              <a href="{{ home_url('/blog/cane-reattivo-5-segnali') }}" 
                 class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 font-medium">
                <span>Leggi tutto</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </article>
    </div>

    {{-- Blog Categories --}}
    <div class="flex flex-wrap justify-center gap-3 mb-8">
      <button class="px-4 py-2 bg-green-600 text-white rounded-full font-medium shadow-md hover:shadow-lg transition-all text-sm">
        Tutti
      </button>
      <button class="px-4 py-2 bg-white text-gray-700 rounded-full font-medium shadow-md hover:shadow-lg transition-all text-sm">
        🧠 Comportamento
      </button>
      <button class="px-4 py-2 bg-white text-gray-700 rounded-full font-medium shadow-md hover:shadow-lg transition-all text-sm">
        🎓 Educazione
      </button>
      <button class="px-4 py-2 bg-white text-gray-700 rounded-full font-medium shadow-md hover:shadow-lg transition-all text-sm">
        💚 Storie di Successo
      </button>
      <button class="px-4 py-2 bg-white text-gray-700 rounded-full font-medium shadow-md hover:shadow-lg transition-all text-sm">
        📍 News Locali
      </button>
    </div>

    {{-- Recent Articles Grid --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
      @php
        $articles = [
          [
            'category' => 'Educazione',
            'category_color' => 'blue',
            'title' => 'Come Preparare il Tuo Cane alla Prima Visita',
            'excerpt' => 'Consigli pratici per rendere la prima esperienza nell\'area privata un successo. Dal viaggio all\'ambientamento.',
            'author' => 'Marco Rossi',
            'read_time' => '3 min',
            'date' => '1 settimana fa',
            'url' => '/blog/preparare-prima-visita',
            'image' => 'prima-visita.jpg'
          ],
          [
            'category' => 'Storie',
            'category_color' => 'green',
            'title' => 'Luna: Da Reattiva a Rilassata in 2 Mesi',
            'excerpt' => 'La trasformazione di Luna, pastore tedesco di 3 anni, grazie allo spazio privato e al supporto Team Branco.',
            'author' => 'Giulia M.',
            'read_time' => '4 min',
            'date' => '2 settimane fa',
            'url' => '/blog/storia-luna',
            'image' => 'storia-luna.jpg'
          ],
          [
            'category' => 'Comportamento',
            'category_color' => 'purple',
            'title' => 'Socializzazione: Non È Sempre la Risposta',
            'excerpt' => 'Perché forzare le interazioni può essere controproducente e come rispettare i tempi del tuo cane.',
            'author' => 'Dr. Laura Bianchi',
            'read_time' => '6 min',
            'date' => '3 settimane fa',
            'url' => '/blog/socializzazione-miti',
            'image' => 'socializzazione.jpg'
          ],
          [
            'category' => 'Pratico',
            'category_color' => 'orange',
            'title' => 'Giochi Fai-da-Te per Stimolare il Tuo Cane',
            'excerpt' => '10 idee creative per costruire giochi di attivazione mentale con oggetti di casa. Perfetti per l\'area privata!',
            'author' => 'Team Dog Safe',
            'read_time' => '5 min',
            'date' => '1 mese fa',
            'url' => '/blog/giochi-fai-da-te',
            'image' => 'giochi-diy.jpg'
          ],
          [
            'category' => 'News',
            'category_color' => 'red',
            'title' => 'Nuovo Regolamento Aree Cani Milano 2024',
            'excerpt' => 'Cosa cambia per i proprietari di cani a Milano e perché gli spazi privati diventano ancora più importanti.',
            'author' => 'Redazione',
            'read_time' => '4 min',
            'date' => '1 mese fa',
            'url' => '/blog/regolamento-milano-2024',
            'image' => 'news-milano.jpg'
          ],
          [
            'category' => 'Salute',
            'category_color' => 'teal',
            'title' => 'Estate e Cani: Guida Completa al Caldo',
            'excerpt' => 'Orari migliori, idratazione, segnali di stress da calore. Tutto per un\'estate sicura con il tuo amico.',
            'author' => 'Dr. Paolo Verdi',
            'read_time' => '7 min',
            'date' => '2 mesi fa',
            'url' => '/blog/estate-cani-guida',
            'image' => 'estate-cani.jpg'
          ]
        ];
      @endphp

      @foreach($articles as $article)
        <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group">
          {{-- Article Image --}}
          <div class="relative h-48 bg-gray-200 overflow-hidden">
            <img src="{{ Vite::asset('resources/images/blog/' . $article['image']) }}" 
                 alt="{{ $article['title'] }}" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            <div class="absolute top-3 left-3">
              <span class="px-3 py-1 bg-{{ $article['category_color'] }}-100 text-{{ $article['category_color'] }}-700 text-xs font-medium rounded-full">
                {{ $article['category'] }}
              </span>
            </div>
          </div>
          
          {{-- Article Content --}}
          <div class="p-5">
            <h3 class="font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-green-600 transition-colors">
              <a href="{{ home_url($article['url']) }}">
                {{ $article['title'] }}
              </a>
            </h3>
            
            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
              {{ $article['excerpt'] }}
            </p>
            
            <div class="flex items-center justify-between text-xs text-gray-500">
              <div class="flex items-center gap-2">
                <span>{{ $article['author'] }}</span>
                <span>•</span>
                <span>{{ $article['read_time'] }}</span>
              </div>
              <span>{{ $article['date'] }}</span>
            </div>
          </div>
        </article>
      @endforeach
    </div>

    {{-- Newsletter Signup --}}
    <div class="bg-gradient-to-r from-purple-100 to-pink-100 rounded-3xl p-8 text-center">
      <h3 class="text-2xl font-bold text-gray-900 mb-4">
        Non perderti i nostri consigli settimanali
      </h3>
      <p class="text-gray-700 mb-6 max-w-2xl mx-auto">
        Ogni venerdì, una email con tips pratici, storie ispiranti e novità 
        dal mondo Dog Safe Place. Zero spam, solo contenuti utili.
      </p>
      
      <form class="max-w-md mx-auto flex gap-3">
        <input type="email" 
               placeholder="La tua email" 
               class="flex-1 px-5 py-3 bg-white rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-purple-500">
        <button type="submit" 
                class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-full shadow-md hover:shadow-lg transition-all">
          Iscriviti
        </button>
      </form>
      
      <p class="text-xs text-gray-600 mt-3">
        Unisciti a 500+ proprietari che già ricevono i nostri consigli
      </p>
    </div>

    {{-- View All Articles CTA --}}
    <div class="text-center mt-12">
      <a href="{{ home_url('/blog') }}" 
         class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-purple-600 text-purple-600 rounded-full font-semibold hover:bg-purple-50 transition-all">
        <span>Leggi tutti gli articoli</span>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
        </svg>
      </a>
    </div>
  </div>
</section>