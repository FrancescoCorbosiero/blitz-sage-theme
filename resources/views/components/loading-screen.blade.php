<div 
  class="loader-default fixed inset-0 z-50 flex items-center justify-center bg-white dark:bg-gray-900 transition-opacity duration-500"
  x-data="{ loading: true }"
  x-show="loading"
  x-init="window.addEventListener('load', () => { setTimeout(() => loading = false, 300) })"
  x-transition:leave="transition ease-in duration-300"
  x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0"
>
  <div class="flex items-center justify-center space-x-2">
    <div class="w-8 h-8 bg-primary rounded-full animate-bounce"></div>
    <div class="w-8 h-8 bg-primary-soft rounded-full animate-bounce" style="animation-delay: -0.1s"></div>
    <div class="w-8 h-8 bg-accent rounded-full animate-bounce" style="animation-delay: -0.2s"></div>
  </div>
</div>