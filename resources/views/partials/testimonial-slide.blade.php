<div class="testimonial-slide bg-white rounded-xl p-6 shadow-lg">
  <div class="flex items-start gap-4 mb-4">
    <div class="w-16 h-16 bg-gradient-to-br from-[#4A7C28] to-[#2D5016] rounded-full flex items-center justify-center text-white font-bold text-xl">
      {{ substr($author, 0, 1) }}
    </div>
    <div class="flex-1">
      <div class="flex gap-1 mb-2">
        @for($i = 0; $i < 5; $i++)
          <svg class="w-5 h-5 text-[#FFD700] fill-current" viewBox="0 0 20 20">
            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
          </svg>
        @endfor
      </div>
      <cite class="font-semibold not-italic">{{ $author }}</cite>
      <p class="text-sm text-gray-500">{{ $dog }}</p>
    </div>
  </div>
  
  <blockquote class="text-gray-600 italic relative">
    <svg class="absolute -top-2 -left-2 w-8 h-8 text-gray-200" fill="currentColor" viewBox="0 0 24 24">
      <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
    </svg>
    <p class="relative z-10 pl-6">{{ $quote }}</p>
  </blockquote>
</div>