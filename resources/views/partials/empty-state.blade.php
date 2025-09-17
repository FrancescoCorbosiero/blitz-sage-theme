{{-- resources/views/partials/empty-state.blade.php --}}
<div class="empty-state text-center py-16">
    <div class="w-24 h-24 mx-auto mb-6 bg-bg-tertiary rounded-full flex items-center justify-center">
        <svg class="w-12 h-12 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
    </div>
    <h2 class="text-2xl font-bold mb-4">{{ __('Content Coming Soon', 'blitz') }}</h2>
    <p class="text-text-secondary mb-8">{{ __('This page is being prepared. Please check back later.', 'blitz') }}</p>
    <a href="{{ home_url('/') }}" class="btn-primary inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        {{ __('Back to Homepage', 'blitz') }}
    </a>
</div>