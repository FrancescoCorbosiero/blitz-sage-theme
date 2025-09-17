{{-- resources/views/partials/sharing-toolbar.blade.php --}}
<div class="sharing-toolbar fixed bottom-8 right-8 z-40"
     x-show="showShareButtons"
     x-transition>
    <div class="flex flex-col gap-3">
        <button @click="share('twitter')" 
                class="w-12 h-12 bg-blue-400 text-white rounded-full shadow-lg hover:scale-110 transition-transform"
                title="Share on Twitter">
            <svg class="w-6 h-6 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
            </svg>
        </button>
        
        <button @click="copyLink()" 
                class="w-12 h-12 bg-gray-600 text-white rounded-full shadow-lg hover:scale-110 transition-transform"
                title="Copy link">
            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
        </button>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('sharingToolbar', () => ({
        share(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
            
            const urls = {
                twitter: `https://twitter.com/intent/tweet?url=${url}&text=${title}`,
                facebook: `https://www.facebook.com/sharer/sharer.php?u=${url}`
            };
            
            if (urls[platform]) {
                window.open(urls[platform], '_blank', 'width=600,height=400');
            }
        },
        
        async copyLink() {
            try {
                await navigator.clipboard.writeText(window.location.href);
                // Simple toast notification
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 bg-primary text-white px-6 py-3 rounded-lg shadow-lg z-50';
                toast.textContent = 'Link copied!';
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            } catch (err) {
                console.error('Failed to copy:', err);
            }
        }
    }));
});
</script>