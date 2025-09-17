{{-- resources/views/partials/share-menu-compact.blade.php --}}
<div class="share-menu-compact">
    <div class="share-menu-inner">
        <div class="share-menu-header">
            <span class="text-xs font-semibold text-text-muted uppercase tracking-wider">
                {{ __('Share via', 'blitz') }}
            </span>
        </div>
        
        <div class="share-options">
            {{-- Twitter/X --}}
            <button @click="shareOn('twitter')" 
                    class="share-option twitter"
                    title="{{ __('Share on Twitter', 'blitz') }}">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                </svg>
            </button>
            
            {{-- Facebook --}}
            <button @click="shareOn('facebook')" 
                    class="share-option facebook"
                    title="{{ __('Share on Facebook', 'blitz') }}">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            </button>
            
            {{-- LinkedIn --}}
            <button @click="shareOn('linkedin')" 
                    class="share-option linkedin"
                    title="{{ __('Share on LinkedIn', 'blitz') }}">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
            </button>
            
            {{-- WhatsApp --}}
            <button @click="shareOn('whatsapp')" 
                    class="share-option whatsapp"
                    title="{{ __('Share on WhatsApp', 'blitz') }}">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
            </button>
            
            {{-- Email --}}
            <button @click="shareOn('email')" 
                    class="share-option email"
                    title="{{ __('Share via Email', 'blitz') }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </button>
            
            {{-- Copy Link --}}
            <button @click="copyPostLink" 
                    class="share-option copy"
                    :class="{ 'copied': linkCopied }"
                    title="{{ __('Copy Link', 'blitz') }}">
                <svg x-show="!linkCopied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
                <svg x-show="linkCopied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<style>
.share-menu-compact {
    position: absolute;
    left: calc(100% + 1rem);
    top: 50%;
    transform: translateY(-50%);
    z-index: 50;
    opacity: 0;
    animation: fadeInLeft 0.3s ease forwards;
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateY(-50%) translateX(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(-50%) translateX(0);
    }
}

.share-menu-inner {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 0.75rem;
    padding: 0.75rem;
    box-shadow: 0 10px 30px var(--shadow);
    min-width: 250px;
}

.share-menu-header {
    padding: 0.5rem 0.5rem 0.75rem;
    border-bottom: 1px solid var(--border-color);
    margin-bottom: 0.75rem;
}

.share-options {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.5rem;
}

.share-option {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-tertiary);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    color: var(--text-muted);
    cursor: pointer;
    transition: all 0.2s ease;
}

.share-option:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.share-option.twitter:hover {
    background: #1DA1F2;
    border-color: #1DA1F2;
    color: white;
}

.share-option.facebook:hover {
    background: #1877F2;
    border-color: #1877F2;
    color: white;
}

.share-option.linkedin:hover {
    background: #0A66C2;
    border-color: #0A66C2;
    color: white;
}

.share-option.whatsapp:hover {
    background: #25D366;
    border-color: #25D366;
    color: white;
}

.share-option.email:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
}

.share-option.copy.copied {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
}

/* Dark mode adjustments */
[data-theme="dark"] .share-menu-inner {
    background: var(--bg-secondary);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
}

[data-theme="dark"] .share-option {
    background: var(--bg-tertiary);
}

/* Mobile adjustments */
@media (max-width: 768px) {
    .share-menu-compact {
        position: fixed;
        bottom: 80px;
        left: 50%;
        top: auto;
        transform: translateX(-50%);
        width: calc(100% - 2rem);
        max-width: 320px;
    }
    
    .share-options {
        grid-template-columns: repeat(6, 1fr);
    }
}
</style>

<script>
// Add these methods to the Alpine component
Alpine.data('shareMenuCompact', () => ({
    linkCopied: false,
    
    shareOn(platform) {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(document.title);
        let shareUrl = '';
        
        switch(platform) {
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                break;
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                break;
            case 'linkedin':
                shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                break;
            case 'whatsapp':
                shareUrl = `https://wa.me/?text=${title}%20${url}`;
                break;
            case 'email':
                shareUrl = `mailto:?subject=${title}&body=${url}`;
                break;
        }
        
        if (shareUrl) {
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
        
        // Close the menu after sharing
        this.showShareMenu = false;
    },
    
    async copyPostLink() {
        try {
            await navigator.clipboard.writeText(window.location.href);
            this.linkCopied = true;
            setTimeout(() => {
                this.linkCopied = false;
            }, 2000);
        } catch (err) {
            console.error('Failed to copy link:', err);
        }
    }
}));
</script>