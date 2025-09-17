{{-- FAQ Section - Objection Handling with Transparency --}}
<section class="faq-section relative py-16 lg:py-24 bg-gradient-to-br from-gray-50 via-white to-gray-50 overflow-hidden">
  {{-- Subtle question mark pattern --}}
  <div class="absolute inset-0 opacity-5">
    <div class="absolute top-10 left-10 text-8xl text-gray-300 rotate-12">?</div>
    <div class="absolute top-1/3 right-20 text-8xl text-gray-300 -rotate-12">?</div>
    <div class="absolute bottom-20 left-1/3 text-8xl text-gray-300 rotate-45">?</div>
    <div class="absolute bottom-10 right-10 text-8xl text-gray-300 -rotate-45">?</div>
  </div>

  <div class="container max-w-5xl mx-auto px-6 lg:px-8 relative z-10" x-data="{ activeCategory: 'all', openFaq: null }">
    
    {{-- Section Header --}}
    <div class="text-center mb-12 lg:mb-16">
      <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-100 border border-amber-200 rounded-full mb-4">
        <span class="text-amber-600">💬</span>
        <span class="text-sm font-semibold text-amber-900">Risposte oneste</span>
      </div>
      
      <h2 class="text-3xl lg:text-5xl font-display font-bold text-gray-900 mb-4">
        Le domande che tutti fanno
      </h2>
      <p class="text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto">
        E le risposte sincere che meriti. Niente marketing, solo trasparenza.
      </p>
    </div>

    {{-- FAQ Categories --}}
    <div class="flex flex-wrap justify-center gap-3 mb-8">
      <button @click="activeCategory = 'all'" 
              :class="activeCategory === 'all' ? 'bg-green-600 text-white' : 'bg-white text-gray-700'"
              class="px-4 py-2 rounded-full font-medium shadow-md hover:shadow-lg transition-all text-sm">
        Tutte
      </button>
      <button @click="activeCategory = 'sicurezza'" 
              :class="activeCategory === 'sicurezza' ? 'bg-green-600 text-white' : 'bg-white text-gray-700'"
              class="px-4 py-2 rounded-full font-medium shadow-md hover:shadow-lg transition-all text-sm">
        🔒 Sicurezza
      </button>
      <button @click="activeCategory = 'costi'" 
              :class="activeCategory === 'costi' ? 'bg-green-600 text-white' : 'bg-white text-gray-700'"
              class="px-4 py-2 rounded-full font-medium shadow-md hover:shadow-lg transition-all text-sm">
        💰 Costi
      </button>
      <button @click="activeCategory = 'cani'" 
              :class="activeCategory === 'cani' ? 'bg-green-600 text-white' : 'bg-white text-gray-700'"
              class="px-4 py-2 rounded-full font-medium shadow-md hover:shadow-lg transition-all text-sm">
        🐕 Il mio cane
      </button>
      <button @click="activeCategory = 'pratico'" 
              :class="activeCategory === 'pratico' ? 'bg-green-600 text-white' : 'bg-white text-gray-700'"
              class="px-4 py-2 rounded-full font-medium shadow-md hover:shadow-lg transition-all text-sm">
        📍 Pratico
      </button>
    </div>

    {{-- FAQ Accordion --}}
    <div class="space-y-4">
      
      {{-- FAQ 1: Cane aggressivo --}}
      <div class="faq-item bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg"
           x-show="activeCategory === 'all' || activeCategory === 'cani'"
           data-category="cani">
        <button @click="openFaq = openFaq === 1 ? null : 1"
                class="w-full px-6 py-5 text-left flex items-start justify-between hover:bg-gray-50 transition-colors">
          <div class="flex items-start gap-3 flex-1 pr-4">
            <span class="text-red-500 text-xl mt-0.5">😟</span>
            <div>
              <h3 class="font-semibold text-gray-900 text-lg">
                "Il mio cane è aggressivo/reattivo. Posso venire?"
              </h3>
              <p class="text-sm text-gray-500 mt-1">La domanda più frequente in assoluto</p>
            </div>
          </div>
          <svg class="w-5 h-5 text-gray-400 mt-1 flex-shrink-0 transform transition-transform" 
               :class="{ 'rotate-180': openFaq === 1 }"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div x-show="openFaq === 1" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="px-6 pb-6">
          <div class="prose prose-gray max-w-none">
            <p class="text-gray-700 mb-3">
              <strong>Assolutamente sì!</strong> Anzi, siamo nati proprio per voi. 
              Il 60% dei nostri clienti ha cani reattivi o con difficoltà comportamentali.
            </p>
            <p class="text-gray-700 mb-3">
              Qui il tuo cane non incontrerà nessuno. Zero trigger, zero stress, zero giudizi. 
              Solo voi due (o tre, se siete una famiglia) in 2000mq di libertà totale.
            </p>
            <div class="p-4 bg-green-50 rounded-xl border border-green-200">
              <p class="text-sm text-green-800 flex items-start gap-2 mb-0">
                <span class="text-green-600 mt-0.5">✓</span>
                <span>
                  <strong>Nota:</strong> Non siamo un centro di riabilitazione. Siamo semplicemente 
                  uno spazio sicuro dove il tuo cane può rilassarsi senza pressioni. 
                  Se vuoi lavorare sui comportamenti, c'è Team Branco (ma è opzionale).
                </span>
              </p>
            </div>
          </div>
        </div>
      </div>

      {{-- FAQ 2: Costo --}}
      <div class="faq-item bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg"
           x-show="activeCategory === 'all' || activeCategory === 'costi'"
           data-category="costi">
        <button @click="openFaq = openFaq === 2 ? null : 2"
                class="w-full px-6 py-5 text-left flex items-start justify-between hover:bg-gray-50 transition-colors">
          <div class="flex items-start gap-3 flex-1 pr-4">
            <span class="text-yellow-500 text-xl mt-0.5">💭</span>
            <div>
              <h3 class="font-semibold text-gray-900 text-lg">
                "20€ all'ora mi sembra tanto..."
              </h3>
              <p class="text-sm text-gray-500 mt-1">Parliamo del valore, non del prezzo</p>
            </div>
          </div>
          <svg class="w-5 h-5 text-gray-400 mt-1 flex-shrink-0 transform transition-transform" 
               :class="{ 'rotate-180': openFaq === 2 }"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div x-show="openFaq === 2" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="px-6 pb-6">
          <div class="prose prose-gray max-w-none">
            <p class="text-gray-700 mb-3">
              Capisco perfettamente. Facciamo due conti insieme:
            </p>
            <ul class="space-y-2 text-gray-700 mb-4">
              <li class="flex items-start gap-2">
                <span class="text-green-500 mt-0.5">•</span>
                <span>Un dog sitter costa 25-30€/ora (e il cane è al guinzaglio)</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-green-500 mt-0.5">•</span>
                <span>Una visita dal veterinario per morso/incidente: 100-500€</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-green-500 mt-0.5">•</span>
                <span>Lo stress di un brutto incontro al parco: incalcolabile</span>
              </li>
            </ul>
            <p class="text-gray-700 mb-3">
              Con 20€ hai 2000mq tutti per voi, zero rischi, pulizia garantita, 
              acqua e giochi inclusi. È il prezzo di una pizza e una birra, 
              ma il tuo cane sarà felice per giorni.
            </p>
            <div class="p-4 bg-amber-50 rounded-xl border border-amber-200">
              <p class="text-sm text-amber-800 mb-0">
                💡 <strong>Suggerimento:</strong> Se vieni spesso, l'abbonamento VIP 
                ti fa risparmiare il 25% (150€ per 10 ore invece di 200€).
              </p>
            </div>
          </div>
        </div>
      </div>

      {{-- FAQ 3: Sicurezza fuga --}}
      <div class="faq-item bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg"
           x-show="activeCategory === 'all' || activeCategory === 'sicurezza'"
           data-category="sicurezza">
        <button @click="openFaq = openFaq === 3 ? null : 3"
                class="w-full px-6 py-5 text-left flex items-start justify-between hover:bg-gray-50 transition-colors">
          <div class="flex items-start gap-3 flex-1 pr-4">
            <span class="text-blue-500 text-xl mt-0.5">🏃</span>
            <div>
              <h3 class="font-semibold text-gray-900 text-lg">
                "E se il mio cane scappa?"
              </h3>
              <p class="text-sm text-gray-500 mt-1">Preoccupazione legittima</p>
            </div>
          </div>
          <svg class="w-5 h-5 text-gray-400 mt-1 flex-shrink-0 transform transition-transform" 
               :class="{ 'rotate-180': openFaq === 3 }"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div x-show="openFaq === 3" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="px-6 pb-6">
          <div class="prose prose-gray max-w-none">
            <p class="text-gray-700 mb-3">
              <strong>Non può succedere.</strong> Abbiamo un sistema a doppio cancello brevettato:
            </p>
            <ol class="space-y-2 text-gray-700 mb-4">
              <li>Entri dal primo cancello (si chiude automaticamente)</li>
              <li>Ti trovi in una "camera di sicurezza" di 3 metri</li>
              <li>Il secondo cancello si apre SOLO quando il primo è chiuso e bloccato</li>
            </ol>
            <p class="text-gray-700 mb-3">
              Inoltre: recinzione di 2 metri, interrata per 50cm (anti-scavo), 
              controlli giornalieri dell'integrità. In 3 anni: ZERO fughe.
            </p>
            <div class="p-4 bg-blue-50 rounded-xl border border-blue-200">
              <p class="text-sm text-blue-800 mb-0">
                🔒 <strong>Garanzia:</strong> Se non ti senti sicuro dopo aver visto 
                il sistema, ti rimborsiamo la prima ora senza domande.
              </p>
            </div>
          </div>
        </div>
      </div>

      {{-- FAQ 4: Pioggia --}}
      <div class="faq-item bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg"
           x-show="activeCategory === 'all' || activeCategory === 'pratico'"
           data-category="pratico">
        <button @click="openFaq = openFaq === 4 ? null : 4"
                class="w-full px-6 py-5 text-left flex items-start justify-between hover:bg-gray-50 transition-colors">
          <div class="flex items-start gap-3 flex-1 pr-4">
            <span class="text-gray-500 text-xl mt-0.5">🌧️</span>
            <div>
              <h3 class="font-semibold text-gray-900 text-lg">
                "Cosa succede se piove?"
              </h3>
              <p class="text-sm text-gray-500 mt-1">Milano, già...</p>
            </div>
          </div>
          <svg class="w-5 h-5 text-gray-400 mt-1 flex-shrink-0 transform transition-transform" 
               :class="{ 'rotate-180': openFaq === 4 }"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div x-show="openFaq === 4" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="px-6 pb-6">
          <div class="prose prose-gray max-w-none">
            <p class="text-gray-700 mb-3">
              Dipende da te e dal tuo cane! Molti cani adorano la pioggia 
              (e il fango che ne consegue 😅).
            </p>
            <p class="text-gray-700 mb-3">
              L'area resta aperta con pioggia leggera. Abbiamo:
            </p>
            <ul class="space-y-1 text-gray-700 mb-3">
              <li>• Zone coperte per ripararsi</li>
              <li>• Doccia esterna per pulire il cane dopo</li>
              <li>• Asciugamani a disposizione</li>
            </ul>
            <p class="text-gray-700 mb-3">
              In caso di temporale forte o grandine, ti avvisiamo via SMS e puoi:
              - Spostare gratuitamente la prenotazione
              - Ricevere rimborso completo
            </p>
            <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
              <p class="text-sm text-gray-700 mb-0">
                ☔ <strong>Tip:</strong> Alcuni dei momenti più belli sono sotto la pioggia 
                leggera. Meno caldo, cane felicissimo, foto epiche!
              </p>
            </div>
          </div>
        </div>
      </div>

      {{-- FAQ 5: Altri cani --}}
      <div class="faq-item bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg"
           x-show="activeCategory === 'all' || activeCategory === 'cani'"
           data-category="cani">
        <button @click="openFaq = openFaq === 5 ? null : 5"
                class="w-full px-6 py-5 text-left flex items-start justify-between hover:bg-gray-50 transition-colors">
          <div class="flex items-start gap-3 flex-1 pr-4">
            <span class="text-purple-500 text-xl mt-0.5">👥</span>
            <div>
              <h3 class="font-semibold text-gray-900 text-lg">
                "Posso portare più cani? Invitare amici?"
              </h3>
              <p class="text-sm text-gray-500 mt-1">Socializzazione controllata</p>
            </div>
          </div>
          <svg class="w-5 h-5 text-gray-400 mt-1 flex-shrink-0 transform transition-transform" 
               :class="{ 'rotate-180': openFaq === 5 }"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div x-show="openFaq === 5" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="px-6 pb-6">
          <div class="prose prose-gray max-w-none">
            <p class="text-gray-700 mb-3">
              <strong>Certo!</strong> L'area è tua per l'ora prenotata, gestiscila come preferisci:
            </p>
            <ul class="space-y-2 text-gray-700 mb-4">
              <li class="flex items-start gap-2">
                <span class="text-green-500 mt-0.5">✓</span>
                <span>Puoi portare fino a 5 cani (stessa famiglia o gruppo di amici)</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-green-500 mt-0.5">✓</span>
                <span>Perfetto per socializzazione controllata tra cani che si conoscono</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-green-500 mt-0.5">✓</span>
                <span>Ideale per puppy class private o incontri di gioco</span>
              </li>
            </ul>
            <p class="text-gray-700 mb-3">
              Il prezzo resta lo stesso: 20€/ora indipendentemente dal numero di cani. 
              È lo spazio che affitti, non il "posto cane".
            </p>
            <div class="p-4 bg-purple-50 rounded-xl border border-purple-200">
              <p class="text-sm text-purple-800 mb-0">
                💡 <strong>Idea:</strong> Dividete il costo tra amici! 
                5 cani = 4€ a testa per un'ora di paradiso privato.
              </p>
            </div>
          </div>
        </div>
      </div>

      {{-- FAQ 6: Cancellazione --}}
      <div class="faq-item bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg"
           x-show="activeCategory === 'all' || activeCategory === 'pratico'"
           data-category="pratico">
        <button @click="openFaq = openFaq === 6 ? null : 6"
                class="w-full px-6 py-5 text-left flex items-start justify-between hover:bg-gray-50 transition-colors">
          <div class="flex items-start gap-3 flex-1 pr-4">
            <span class="text-orange-500 text-xl mt-0.5">↩️</span>
            <div>
              <h3 class="font-semibold text-gray-900 text-lg">
                "Se devo cancellare?"
              </h3>
              <p class="text-sm text-gray-500 mt-1">La vita è imprevedibile</p>
            </div>
          </div>
          <svg class="w-5 h-5 text-gray-400 mt-1 flex-shrink-0 transform transition-transform" 
               :class="{ 'rotate-180': openFaq === 6 }"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div x-show="openFaq === 6" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="px-6 pb-6">
          <div class="prose prose-gray max-w-none">
            <p class="text-gray-700 mb-3">
              Siamo super flessibili:
            </p>
            <ul class="space-y-2 text-gray-700 mb-4">
              <li class="flex items-start gap-2">
                <span class="text-green-500 mt-0.5">✓</span>
                <span><strong>Fino a 24 ore prima:</strong> Cancellazione gratuita, rimborso 100%</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-yellow-500 mt-0.5">⚠️</span>
                <span><strong>Meno di 24 ore:</strong> Puoi spostare a un'altra data (gratis) o ricevere credito</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-blue-500 mt-0.5">💙</span>
                <span><strong>Emergenze:</strong> Se il cane sta male, rimborso totale con certificato vet</span>
              </li>
            </ul>
            <p class="text-gray-700">
              No stress, no penali nascoste. Siamo proprietari di cani anche noi, 
              capiamo che gli imprevisti capitano.
            </p>
          </div>
        </div>
      </div>

      {{-- FAQ 7: Prima volta --}}
      <div class="faq-item bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg"
           x-show="activeCategory === 'all' || activeCategory === 'pratico'"
           data-category="pratico">
        <button @click="openFaq = openFaq === 7 ? null : 7"
                class="w-full px-6 py-5 text-left flex items-start justify-between hover:bg-gray-50 transition-colors">
          <div class="flex items-start gap-3 flex-1 pr-4">
            <span class="text-green-500 text-xl mt-0.5">🆕</span>
            <div>
              <h3 class="font-semibold text-gray-900 text-lg">
                "È la prima volta, come funziona?"
              </h3>
              <p class="text-sm text-gray-500 mt-1">Ti guidiamo passo passo</p>
            </div>
          </div>
          <svg class="w-5 h-5 text-gray-400 mt-1 flex-shrink-0 transform transition-transform" 
               :class="{ 'rotate-180': openFaq === 7 }"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div x-show="openFaq === 7" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="px-6 pb-6">
          <div class="prose prose-gray max-w-none">
            <p class="text-gray-700 mb-3">
              <strong>Facilissimo!</strong> Ecco cosa succede:
            </p>
            <ol class="space-y-3 text-gray-700 mb-4">
              <li>
                <strong>Prenoti online</strong> (30 secondi, pagamento sicuro)
              </li>
              <li>
                <strong>Ricevi SMS/email</strong> con codice cancello e indicazioni stradali
              </li>
              <li>
                <strong>Arrivi 10 minuti prima</strong> (prima volta consigliamo questo)
              </li>
              <li>
                <strong>Inserisci il codice</strong> al cancello, entri nella camera di sicurezza
              </li>
              <li>
                <strong>Liberi il cane</strong> e vi godete il vostro spazio privato!
              </li>
            </ol>
            <div class="p-4 bg-green-50 rounded-xl border border-green-200">
              <p class="text-sm text-green-800 mb-0">
                🎁 <strong>Prima volta?</strong> Se arrivi 15 minuti prima, 
                facciamo un mini-tour gratuito e profiling base del cane (valore 10€, gratis per te).
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Still have questions CTA --}}
    <div class="mt-12 text-center p-8 bg-gradient-to-r from-amber-50 to-orange-50 rounded-3xl">
      <h3 class="text-2xl font-bold text-gray-900 mb-4">
        Non hai trovato la tua domanda?
      </h3>
      <p class="text-gray-700 mb-6 max-w-2xl mx-auto">
        Nessun problema! Siamo qui per rispondere a tutto. 
        Niente domande stupide, solo proprietari che vogliono il meglio per i loro cani.
      </p>
      
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="https://wa.me/393331234567?text=Ciao!%20Ho%20una%20domanda%20su%20Dog%20Safe%20Place" 
           target="_blank"
           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-green-600 text-white rounded-full font-semibold shadow-lg hover:shadow-xl transition-all">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
          </svg>
          <span>Chiedi su WhatsApp</span>
        </a>
        
        <button @click="$dispatch('open-chat')" 
                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-full font-semibold shadow-lg hover:shadow-xl transition-all">
          <span>Leggi altre FAQ</span>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
</section>