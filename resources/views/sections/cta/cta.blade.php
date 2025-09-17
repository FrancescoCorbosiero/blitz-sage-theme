{{-- Final CTA Section - Ultimate Conversion Push --}}
<section class="final-cta-section relative py-20 lg:py-28 bg-gradient-to-br from-green-900 via-green-800 to-green-900 overflow-hidden">
  {{-- Animated background --}}
  <div class="absolute inset-0">
    <div class="absolute top-0 left-0 w-full h-full bg-[url('data:image/svg+xml,%3Csvg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" stroke="%23ffffff" stroke-width="0.1"%3E%3Cpath d="M0 20h40M20 0v40"/%3E%3C/g%3E%3C/svg%3E')] opacity-10"></div>
    <div class="absolute top-20 left-10 w-96 h-96 bg-green-600 rounded-full opacity-20 blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-emerald-600 rounded-full opacity-20 blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
  </div>

  <div class="container max-w-5xl mx-auto px-6 lg:px-8 relative z-10">
    
    {{-- Urgency Banner --}}
    <div class="text-center mb-8">
      <div class="inline-flex items-center gap-3 px-5 py-3 bg-white/10 backdrop-blur border border-white/20 rounded-full text-white animate-pulse-soft">
        <span class="relative flex h-3 w-3">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
          <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
        </span>
        <span class="text-sm font-medium">3 persone stanno guardando questa pagina ora</span>
      </div>
    </div>

    {{-- Main CTA Content --}}
    <div class="text-center text-white mb-12">
      <h2 class="text-4xl lg:text-6xl font-display font-bold mb-6 animate-fade-in">
        Il tuo cane ti sta aspettando
      </h2>
      
      <p class="text-xl lg:text-2xl mb-8 text-green-100 max-w-3xl mx-auto animate-fade-in-delay">
        Ogni giorno che passa è un giorno di stress in più al parco pubblico. 
        <span class="font-semibold text-white">Regalagli la libertà che merita.</span>
      </p>

      {{-- Value Reminders --}}
      <div class="grid md:grid-cols-4 gap-4 mb-10 max-w-4xl mx-auto">
        <div class="text-center animate-slide-up" style="animation-delay: 0.1s;">
          <div class="text-3xl mb-2">🔒</div>
          <p class="text-sm text-green-100">100% Sicuro</p>
        </div>
        <div class="text-center animate-slide-up" style="animation-delay: 0.2s;">
          <div class="text-3xl mb-2">🏃</div>
          <p class="text-sm text-green-100">2000mq Libertà</p>
        </div>
        <div class="text-center animate-slide-up" style="animation-delay: 0.3s;">
          <div class="text-3xl mb-2">🎓</div>
          <p class="text-sm text-green-100">Team Branco</p>
        </div>
        <div class="text-center animate-slide-up" style="animation-delay: 0.4s;">
          <div class="text-3xl mb-2">💚</div>
          <p class="text-sm text-green-100">Zero Stress</p>
        </div>
      </div>
    </div>

    {{-- Limited Time Offer --}}
    <div class="bg-white/10 backdrop-blur rounded-3xl p-8 mb-10 border border-white/20">
      <div class="text-center text-white">
        <h3 class="text-2xl font-bold mb-4 flex items-center justify-center gap-2">
          <span class="text-yellow-400">⚡</span>
          Offerta Prima Visita
          <span class="text-yellow-400">⚡</span>
        </h3>
        
        <div class="mb-6">
          <p class="text-4xl font-bold mb-2">
            50% di sconto sulla prima ora
          </p>
          <p class="text-xl text-green-200">
            Solo <span class="line-through opacity-50">€20</span> 
            <span class="text-3xl font-bold text-yellow-400 ml-2">€10</span>
          </p>
        </div>

        {{-- Scarcity --}}
        <div class="flex items-center justify-center gap-8 mb-6">
          <div>
            <p class="text-3xl font-bold text-yellow-400">7</p>
            <p class="text-sm text-green-200">Slot rimasti oggi</p>
          </div>
          <div class="w-px h-12 bg-white/20"></div>
          <div>
            <p class="text-3xl font-bold text-yellow-400">24h</p>
            <p class="text-sm text-green-200">Offerta valida</p>
          </div>
        </div>

        {{-- Main CTA Buttons --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-6">
          <a href="{{ home_url('/prenota') }}" 
             class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-yellow-400 to-orange-400 text-gray-900 rounded-full font-bold text-lg shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300">
            {{-- Button pulse effect --}}
            <span class="absolute inset-0 rounded-full bg-white opacity-25 animate-ping"></span>
            
            <span class="relative">Prenota Ora con lo Sconto</span>
            <svg class="relative w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
          </a>
          
          <button @click="$dispatch('book-free-visit')" 
                  class="inline-flex items-center justify-center gap-2 px-6 py-4 bg-white/10 backdrop-blur text-white border-2 border-white/30 rounded-full font-semibold text-lg hover:bg-white/20 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            <span>Guarda il Video Tour</span>
          </button>
        </div>

        {{-- Trust Elements --}}
        <div class="flex flex-wrap items-center justify-center gap-6 text-sm text-green-200">
          <span class="flex items-center gap-2">
            <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
            Cancellazione gratuita
          </span>
          <span class="flex items-center gap-2">
            <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
            Pagamento sicuro
          </span>
          <span class="flex items-center gap-2">
            <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
            Soddisfatti o rimborsati
          </span>
        </div>
      </div>
    </div>

    {{-- Alternative Actions --}}
    <div class="text-center">
      <p class="text-green-200 mb-4">Non sei ancora sicuro?</p>
      
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="https://wa.me/393331234567?text=Ciao!%20Vorrei%20più%20informazioni%20su%20Dog%20Safe%20Place" 
           target="_blank"
           class="inline-flex items-center justify-center gap-2 px-6 py-3 text-white hover:text-green-100 transition-colors">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
          </svg>
          <span>Chatta con noi su WhatsApp</span>
        </a>
        
        <a href="{{ home_url('/faq') }}" 
           class="inline-flex items-center justify-center gap-2 px-6 py-3 text-white hover:text-green-100 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span>Leggi le FAQ</span>
        </a>
      </div>
    </div>

    {{-- Final Emotional Appeal --}}
    <div class="mt-16 text-center">
      <blockquote class="text-xl lg:text-2xl text-green-100 italic max-w-3xl mx-auto">
        "Dopo la prima visita, Luna ha dormito serena per la prima volta in mesi. 
        Vale ogni centesimo."
      </blockquote>
      <p class="text-green-200 mt-4">— Giulia M., cliente da 6 mesi</p>
    </div>
  </div>
</section>

{{-- Animation Styles --}}
<style>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes fade-in-delay {
  0% { opacity: 0; transform: translateY(20px); }
  50% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}

@keyframes slide-up {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes pulse-soft {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.8; }
}

.animate-fade-in {
  animation: fade-in 1s ease-out;
}

.animate-fade-in-delay {
  animation: fade-in-delay 1.5s ease-out;
}

.animate-slide-up {
  animation: slide-up 0.6s ease-out forwards;
  opacity: 0;
}

.animate-pulse-soft {
  animation: pulse-soft 2s ease-in-out infinite;
}
</style>