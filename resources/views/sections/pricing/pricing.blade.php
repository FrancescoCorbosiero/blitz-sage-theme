{{-- Pricing Comparison Section - Clear Value Proposition --}}
<section class="pricing-comparison-section relative py-16 lg:py-24 bg-gradient-to-br from-white via-gray-50 to-white overflow-hidden">
  {{-- Decorative Background --}}
  <div class="absolute inset-0 opacity-30">
    <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-green-200 to-emerald-200 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-blue-200 to-cyan-200 rounded-full blur-3xl"></div>
  </div>

  <div class="container max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
    {{-- Section Header --}}
    <div class="text-center mb-12 lg:mb-16">
      <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 border border-green-200 rounded-full text-sm font-medium text-green-700 mb-4">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
          <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
        </svg>
        Confronta e risparmia
      </span>
      <h2 class="text-3xl lg:text-5xl font-display font-bold text-gray-900 mb-4">
        Perché pagare di più per avere meno?
      </h2>
      <p class="text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto">
        Abbiamo fatto i conti: la nostra soluzione non è solo migliore, è anche più conveniente.
      </p>
    </div>

    {{-- Comparison Table - Desktop --}}
    <div class="hidden lg:block overflow-hidden rounded-3xl shadow-2xl border border-gray-200"
         x-data="{ 
           selectedHours: 10,
           prices: {
             dogSafePlace: { hourly: 20, monthly: 150 },
             publicPark: { stress: 100, incidents: 50 },
             dogSitter: { hourly: 25, daily: 150 },
             stayHome: { opportunity: 500 }
           }
         }">
      
      {{-- Hours Calculator --}}
      <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
          <label class="text-lg font-semibold text-gray-900">
            Calcola per le tue esigenze:
          </label>
          <div class="flex items-center gap-4">
            <span class="text-sm text-gray-600">Ore al mese:</span>
            <div class="flex items-center gap-2">
              <button @click="selectedHours = Math.max(1, selectedHours - 1)" 
                      class="w-10 h-10 rounded-full bg-white border-2 border-gray-300 hover:border-green-500 transition-colors flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                </svg>
              </button>
              <input type="number" x-model="selectedHours" min="1" max="50"
                     class="w-20 px-3 py-2 text-center text-lg font-bold border-2 border-gray-300 rounded-xl focus:border-green-500 focus:outline-none">
              <button @click="selectedHours = Math.min(50, selectedHours + 1)" 
                      class="w-10 h-10 rounded-full bg-white border-2 border-gray-300 hover:border-green-500 transition-colors flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>

      <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
          <tr>
            <th class="px-6 py-4 text-left">
              <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Confronta</span>
            </th>
            <th class="px-6 py-4 text-center bg-gradient-to-b from-green-50 to-green-100 relative">
              <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg">MIGLIORE SCELTA</span>
              </div>
              <div class="pt-2">
                <p class="text-lg font-bold text-gray-900">Dog Safe Place</p>
                <p class="text-sm text-green-600">La nostra soluzione</p>
              </div>
            </th>
            <th class="px-6 py-4 text-center">
              <p class="text-lg font-semibold text-gray-900">Parco Pubblico</p>
              <p class="text-sm text-gray-500">"Gratuito"</p>
            </th>
            <th class="px-6 py-4 text-center">
              <p class="text-lg font-semibold text-gray-900">Dog Sitter</p>
              <p class="text-sm text-gray-500">Passeggiata</p>
            </th>
            <th class="px-6 py-4 text-center">
              <p class="text-lg font-semibold text-gray-900">Restare a Casa</p>
              <p class="text-sm text-gray-500">Nessuna uscita</p>
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          {{-- Row: Costo --}}
          <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4 text-sm font-medium text-gray-900">
              💰 Costo mensile
            </td>
            <td class="px-6 py-4 text-center bg-green-50/50">
              <div class="font-bold text-lg text-green-600">
                <span x-show="selectedHours <= 10">€<span x-text="selectedHours * 20"></span></span>
                <span x-show="selectedHours > 10">
                  <span class="line-through text-gray-400 text-sm">€<span x-text="selectedHours * 20"></span></span>
                  <span class="block">€150</span>
                  <span class="text-xs text-green-500">Abbonamento VIP</span>
                </span>
              </div>
            </td>
            <td class="px-6 py-4 text-center">
              <div class="text-gray-900">
                <span class="font-medium">€0</span>
                <span class="block text-xs text-red-500">+ costi nascosti</span>
              </div>
            </td>
            <td class="px-6 py-4 text-center">
              <div class="font-bold text-lg text-gray-900">
                €<span x-text="selectedHours * 25"></span>
              </div>
            </td>
            <td class="px-6 py-4 text-center">
              <span class="text-gray-900">€0</span>
            </td>
          </tr>

          {{-- Row: Sicurezza --}}
          <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4 text-sm font-medium text-gray-900">
              🛡️ Sicurezza
            </td>
            <td class="px-6 py-4 text-center bg-green-50/50">
              <div class="flex flex-col items-center gap-1">
                <div class="flex text-green-500">
                  @for($i = 0; $i < 5; $i++)
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                  @endfor
                </div>
                <span class="text-xs text-green-600 font-medium">100% Garantita</span>
              </div>
            </td>
            <td class="px-6 py-4 text-center">
              <div class="flex flex-col items-center gap-1">
                <div class="flex text-gray-300">
                  @for($i = 0; $i < 2; $i++)
                    <svg class="w-5 h-5 fill-current text-orange-400" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                  @endfor
                  @for($i = 0; $i < 3; $i++)
                    <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                  @endfor
                </div>
                <span class="text-xs text-gray-500">Rischio incidenti</span>
              </div>
            </td>
            <td class="px-6 py-4 text-center">
              <div class="flex flex-col items-center gap-1">
                <div class="flex text-gray-300">
                  @for($i = 0; $i < 3; $i++)
                    <svg class="w-5 h-5 fill-current text-blue-400" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                  @endfor
                  @for($i = 0; $i < 2; $i++)
                    <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                  @endfor
                </div>
                <span class="text-xs text-gray-500">Dipende dal dog sitter</span>
              </div>
            </td>
            <td class="px-6 py-4 text-center">
              <div class="flex flex-col items-center gap-1">
                <div class="flex text-gray-300">
                  @for($i = 0; $i < 5; $i++)
                    <svg class="w-5 h-5 fill-current text-green-400" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                  @endfor
                </div>
                <span class="text-xs text-gray-500">Ma zero stimoli</span>
              </div>
            </td>
          </tr>

          {{-- More comparison rows --}}
          @php
            $features = [
              ['icon' => '😌', 'label' => 'Tranquillità', 'dogSafe' => '✅ Totale', 'public' => '❌ Zero', 'sitter' => '⚠️ Variabile', 'home' => '✅ Sì'],
              ['icon' => '🏃', 'label' => 'Libertà di correre', 'dogSafe' => '✅ 2000mq', 'public' => '⚠️ Limitata', 'sitter' => '⚠️ Al guinzaglio', 'home' => '❌ No'],
              ['icon' => '👥', 'label' => 'Socializzazione', 'dogSafe' => '✅ Opzionale', 'public' => '❌ Forzata', 'sitter' => '⚠️ Casuale', 'home' => '❌ Zero'],
              ['icon' => '🎯', 'label' => 'Controllo ambiente', 'dogSafe' => '✅ 100%', 'public' => '❌ 0%', 'sitter' => '⚠️ 30%', 'home' => '✅ 100%'],
              ['icon' => '📅', 'label' => 'Flessibilità orari', 'dogSafe' => '✅ Alta', 'public' => '✅ Sempre aperto', 'sitter' => '❌ Dipende', 'home' => '✅ Totale'],
              ['icon' => '🧼', 'label' => 'Igiene garantita', 'dogSafe' => '✅ Sanificato', 'public' => '❌ Scarsa', 'sitter' => '⚠️ N/A', 'home' => '✅ Casa tua'],
            ];
          @endphp

          @foreach($features as $feature)
            <tr class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4 text-sm font-medium text-gray-900">
                {{ $feature['icon'] }} {{ $feature['label'] }}
              </td>
              <td class="px-6 py-4 text-center bg-green-50/50 font-medium">
                {{ $feature['dogSafe'] }}
              </td>
              <td class="px-6 py-4 text-center text-sm">
                {{ $feature['public'] }}
              </td>
              <td class="px-6 py-4 text-center text-sm">
                {{ $feature['sitter'] }}
              </td>
              <td class="px-6 py-4 text-center text-sm">
                {{ $feature['home'] }}
              </td>
            </tr>
          @endforeach
        </tbody>

        {{-- Summary Footer --}}
        <tfoot class="bg-gray-900 text-white">
          <tr>
            <td class="px-6 py-6 text-lg font-bold">
              Valore Totale
            </td>
            <td class="px-6 py-6 text-center bg-green-600">
              <div class="text-2xl font-bold">Imbattibile</div>
              <div class="text-sm opacity-90">Miglior rapporto qualità/prezzo</div>
            </td>
            <td class="px-6 py-6 text-center">
              <div class="text-lg font-medium">Costi nascosti</div>
              <div class="text-sm opacity-75">Stress, rischi, tempo perso</div>
            </td>
            <td class="px-6 py-6 text-center">
              <div class="text-lg font-medium">Costoso</div>
              <div class="text-sm opacity-75">€25+/ora</div>
            </td>
            <td class="px-6 py-6 text-center">
              <div class="text-lg font-medium">Costo sociale</div>
              <div class="text-sm opacity-75">Benessere compromesso</div>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>

    {{-- Mobile Comparison Cards --}}
    <div class="lg:hidden space-y-4"
         x-data="{ selectedOption: 'dogSafePlace' }">
      
      {{-- Option Selector --}}
      <div class="flex gap-2 overflow-x-auto pb-2">
        <button @click="selectedOption = 'dogSafePlace'"
                :class="selectedOption === 'dogSafePlace' ? 'bg-green-600 text-white' : 'bg-white text-gray-700'"
                class="px-4 py-2 rounded-full font-medium whitespace-nowrap transition-colors">
          Dog Safe Place ⭐
        </button>
        <button @click="selectedOption = 'public'"
                :class="selectedOption === 'public' ? 'bg-gray-600 text-white' : 'bg-white text-gray-700'"
                class="px-4 py-2 rounded-full font-medium whitespace-nowrap transition-colors">
          Parco Pubblico
        </button>
        <button @click="selectedOption = 'sitter'"
                :class="selectedOption === 'sitter' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700'"
                class="px-4 py-2 rounded-full font-medium whitespace-nowrap transition-colors">
          Dog Sitter
        </button>
        <button @click="selectedOption = 'home'"
                :class="selectedOption === 'home' ? 'bg-purple-600 text-white' : 'bg-white text-gray-700'"
                class="px-4 py-2 rounded-full font-medium whitespace-nowrap transition-colors">
          Casa
        </button>
      </div>

      {{-- Comparison Cards --}}
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        {{-- Dog Safe Place --}}
        <div x-show="selectedOption === 'dogSafePlace'" class="p-6">
          <div class="text-center mb-6">
            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">MIGLIORE SCELTA</span>
            <h3 class="text-2xl font-bold mt-3">Dog Safe Place</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">€20/ora</p>
            <p class="text-sm text-gray-500">o €150/mese VIP</p>
          </div>
          <div class="space-y-3">
            <div class="flex items-center gap-3">
              <span class="text-green-500">✅</span>
              <span>2000mq completamente privati</span>
            </div>
            <div class="flex items-center gap-3">
              <span class="text-green-500">✅</span>
              <span>100% sicuro e recintato</span>
            </div>
            <div class="flex items-center gap-3">
              <span class="text-green-500">✅</span>
              <span>Zero stress da altri cani</span>
            </div>
            <div class="flex items-center gap-3">
              <span class="text-green-500">✅</span>
              <span>Team Branco partner</span>
            </div>
          </div>
        </div>

        {{-- Other options (hidden by default) --}}
        <div x-show="selectedOption === 'public'" class="p-6" style="display: none;">
          <h3 class="text-2xl font-bold text-center mb-4">Parco Pubblico</h3>
          <p class="text-3xl font-bold text-center text-gray-600 mb-6">"Gratuito"</p>
          <div class="space-y-3">
            <div class="flex items-center gap-3">
              <span class="text-red-500">❌</span>
              <span>Cani imprevedibili ovunque</span>
            </div>
            <div class="flex items-center gap-3">
              <span class="text-red-500">❌</span>
              <span>Rischio incidenti alto</span>
            </div>
            <div class="flex items-center gap-3">
              <span class="text-red-500">❌</span>
              <span>Stress garantito</span>
            </div>
            <div class="flex items-center gap-3">
              <span class="text-orange-500">⚠️</span>
              <span>Igiene discutibile</span>
            </div>
          </div>
        </div>

        {{-- Similar for other options... --}}
      </div>
    </div>

    {{-- ROI Calculator --}}
    <div class="mt-12 p-8 bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl border-2 border-green-200">
      <h3 class="text-2xl font-bold text-center mb-6">💡 Lo sapevi che...</h3>
      <div class="grid md:grid-cols-3 gap-6 text-center">
        <div>
          <p class="text-4xl font-bold text-green-600">€180</p>
          <p class="text-sm text-gray-600 mt-2">Risparmio medio mensile vs dog sitter</p>
        </div>
        <div>
          <p class="text-4xl font-bold text-green-600">0</p>
          <p class="text-sm text-gray-600 mt-2">Incidenti in 3 anni di attività</p>
        </div>
        <div>
          <p class="text-4xl font-bold text-green-600">97%</p>
          <p class="text-sm text-gray-600 mt-2">Clienti che tornano regolarmente</p>
        </div>
      </div>
    </div>

    {{-- CTA Section --}}
    <div class="mt-12 text-center">
      <p class="text-lg text-gray-600 mb-6">
        Non è solo una questione di prezzo. È una questione di <strong>valore</strong>.
      </p>
      <a href="{{ home_url('/prenota') }}" 
         class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full font-semibold text-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
        <span>Investi nella felicità del tuo cane</span>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
        </svg>
      </a>
    </div>
  </div>
</section>