<button 
  id="back-to-top" 
  class="fixed bottom-6 right-6 w-12 h-12 bg-primary text-white rounded-full shadow-lg opacity-0 pointer-events-none transition-all duration-300 hover:bg-primary-dark hover:scale-110 z-40"
  aria-label="{{ __('Back to top', 'blitz') }}"
  x-data="{ show: false }"
  x-show="show"
  x-transition
  @scroll.window="show = window.pageYOffset > 300"
  @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
>
  <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
  </svg>
</button>