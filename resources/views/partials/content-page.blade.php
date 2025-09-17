
@php
    $show_toc = get_post_meta(get_the_ID(), '_show_table_of_contents', true) == '1';
    $enable_sharing = get_post_meta(get_the_ID(), '_enable_page_sharing', true) == '1';
@endphp

<section class="page-content-premium py-24 lg:py-32 relative overflow-hidden" 
         x-data="pageContentPremium(@json(['show_toc' => $show_toc, 'enable_sharing' => $enable_sharing]))"
         x-init="init()">
    
    {{-- Animated Background --}}
    <div class="content-bg-animation absolute inset-0 pointer-events-none">
        <div class="bg-gradient-wave"></div>
        <div class="bg-mesh-pattern"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex gap-12">
            {{-- Main Content with Premium Typography --}}
            <div class="content-wrapper flex-1 max-w-4xl mx-auto">
                @if(get_the_content())
                    <article class="prose-premium" x-ref="content">
                        <div class="content-inner">
                            {!! apply_filters('the_content', get_the_content()) !!}
                        </div>
                    </article>
                @else
                    @include('partials.empty-state')
                @endif
                
                {{-- Content Enhancement Toolbar --}}
                <div class="content-toolbar fixed bottom-8 left-8 z-40 glass-card p-2 rounded-full"
                     x-show="showToolbar"
                     x-transition>
                    <div class="flex items-center gap-2">
                        <button @click="toggleReadingMode()" 
                                class="toolbar-btn"
                                title="Reading Mode">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </button>
                        
                        <button @click="adjustFontSize('increase')" 
                                class="toolbar-btn"
                                title="Increase Font Size">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </button>
                        
                        <button @click="adjustFontSize('decrease')" 
                                class="toolbar-btn"
                                title="Decrease Font Size">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>
                        
                        <button @click="toggleHighlight()" 
                                class="toolbar-btn"
                                title="Highlight Mode">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Premium Table of Contents --}}
            @if($show_toc)
                <aside class="toc-premium hidden lg:block w-80 flex-shrink-0"
                       x-show="show_toc"
                       x-transition>
                    <div class="sticky top-32">
                        <div class="toc-card glass-card-premium p-6 rounded-2xl">
                            <div class="toc-header flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-text-primary">{{ __('Contents', 'blitz') }}</h3>
                                <div class="toc-progress">
                                    <svg class="progress-ring w-10 h-10">
                                        <circle class="progress-ring-bg" cx="20" cy="20" r="16" 
                                                stroke="var(--border-color)" stroke-width="3" fill="none"/>
                                        <circle class="progress-ring-fill" cx="20" cy="20" r="16" 
                                                stroke="var(--primary)" stroke-width="3" fill="none"
                                                :stroke-dasharray="progressCircumference"
                                                :stroke-dashoffset="progressOffset"/>
                                    </svg>
                                    <span class="progress-text absolute inset-0 flex items-center justify-center text-xs font-bold"
                                          x-text="Math.round(readProgress) + '%'"></span>
                                </div>
                            </div>
                            <nav class="toc-nav space-y-1" x-ref="tocNav"></nav>
                        </div>
                    </div>
                </aside>
            @endif
        </div>
        
        {{-- Premium Sharing Toolbar --}}
        @if($enable_sharing)
            <div class="sharing-toolbar-premium fixed bottom-8 right-8 z-40"
                 x-show="showShareButtons"
                 x-transition>
                <div class="share-container glass-card-premium p-4 rounded-2xl">
                    <div class="share-buttons flex flex-col gap-3">
                        @foreach(['twitter', 'facebook', 'linkedin', 'whatsapp'] as $platform)
                            <button @click="share('{{ $platform }}')" 
                                    class="share-btn share-{{ $platform }}"
                                    title="Share on {{ ucfirst($platform) }}">
                                <span class="share-icon"></span>
                                <span class="share-tooltip">{{ ucfirst($platform) }}</span>
                            </button>
                        @endforeach
                        
                        <div class="share-divider"></div>
                        
                        <button @click="copyLink()" 
                                class="share-btn share-copy"
                                title="Copy link">
                            <span class="share-icon"></span>
                            <span class="share-tooltip">Copy Link</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<style>
/* Premium Content Styles */
.page-content-premium {
    position: relative;
    min-height: 60vh;
}

/* Animated Background */
.bg-gradient-wave {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        transparent 0%,
        rgba(74, 124, 40, 0.03) 25%,
        transparent 50%,
        rgba(249, 115, 22, 0.03) 75%,
        transparent 100%
    );
    background-size: 200% 200%;
    animation: wave-gradient 15s ease infinite;
}

@keyframes wave-gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.bg-mesh-pattern {
    position: absolute;
    inset: 0;
    background-image: 
        linear-gradient(rgba(74, 124, 40, 0.1) 1px, transparent 1px),
        linear-gradient(90deg, rgba(74, 124, 40, 0.1) 1px, transparent 1px);
    background-size: 50px 50px;
    animation: mesh-move 20s linear infinite;
    opacity: 0.3;
}

@keyframes mesh-move {
    0% { transform: translate(0, 0); }
    100% { transform: translate(50px, 50px); }
}

/* Premium Typography */
.prose-premium {
    font-family: var(--font-body);
    color: var(--text-secondary);
    line-height: 1.8;
    position: relative;
}

.prose-premium h1,
.prose-premium h2,
.prose-premium h3,
.prose-premium h4,
.prose-premium h5,
.prose-premium h6 {
    font-family: var(--font-heading);
    font-weight: 700;
    color: var(--text-primary);
    position: relative;
    margin-top: 3rem;
    margin-bottom: 1.5rem;
}

.prose-premium h2 {
    font-size: 2.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid transparent;
    background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 100%);
    background-clip: padding-box;
    border-image: linear-gradient(90deg, var(--primary) 0%, var(--accent) 100%) 1;
}

.prose-premium h2::before {
    content: '';
    position: absolute;
    left: -2rem;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 60%;
    background: linear-gradient(180deg, var(--primary) 0%, var(--accent) 100%);
    border-radius: 2px;
}

.prose-premium p {
    margin-bottom: 1.5rem;
    text-align: justify;
    hyphens: auto;
}

.prose-premium p:first-of-type::first-letter {
    float: left;
    font-size: 4rem;
    line-height: 1;
    font-weight: 700;
    margin-right: 0.5rem;
    margin-top: -0.1rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.prose-premium a {
    color: var(--primary);
    text-decoration: none;
    position: relative;
    transition: all 0.3s ease;
}

.prose-premium a::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 100%);
    transition: width 0.3s ease;
}

.prose-premium a:hover::after {
    width: 100%;
}

.prose-premium blockquote {
    position: relative;
    padding: 2rem 2rem 2rem 3rem;
    margin: 2rem 0;
    background: linear-gradient(135deg, var(--bg-tertiary) 0%, transparent 100%);
    border-left: 4px solid var(--primary);
    border-radius: 0.5rem;
    font-style: italic;
}

.prose-premium blockquote::before {
    content: '"';
    position: absolute;
    top: -1rem;
    left: 1rem;
    font-size: 4rem;
    color: var(--primary);
    opacity: 0.3;
}

.prose-premium img {
    border-radius: 1rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.prose-premium img:hover {
    transform: scale(1.02);
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
}

/* Content Toolbar */
.content-toolbar {
    backdrop-filter: blur(20px);
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.toolbar-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: transparent;
    color: var(--text-primary);
    transition: all 0.3s ease;
}

.toolbar-btn:hover {
    background: var(--primary);
    color: white;
    transform: scale(1.1);
}

/* Premium TOC */
.glass-card-premium {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

[data-theme="dark"] .glass-card-premium {
    background: rgba(0, 0, 0, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.progress-ring {
    transform: rotate(-90deg);
}

.progress-ring-fill {
    transition: stroke-dashoffset 0.3s ease;
}

.toc-nav a {
    display: block;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.toc-nav a::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 0;
    background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 100%);
    opacity: 0.1;
    transition: width 0.3s ease;
}

.toc-nav a:hover::before {
    width: 100%;
}

.toc-nav a.active {
    color: var(--primary);
    font-weight: 600;
}

.toc-nav a.active::before {
    width: 100%;
    opacity: 0.2;
}

/* Premium Share Buttons */
.share-btn {
    position: relative;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    overflow: hidden;
}

.share-btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.share-btn:hover::before {
    opacity: 1;
}

.share-btn:hover {
    transform: scale(1.1) rotate(5deg);
}

.share-twitter { background: linear-gradient(135deg, #1DA1F2, #0A8BD9); }
.share-facebook { background: linear-gradient(135deg, #1877F2, #0C5FD9); }
.share-linkedin { background: linear-gradient(135deg, #0077B5, #005885); }
.share-whatsapp { background: linear-gradient(135deg, #25D366, #128C7E); }
.share-copy { background: linear-gradient(135deg, var(--primary), var(--accent)); }

.share-icon {
    width: 24px;
    height: 24px;
    display: block;
    background: white;
    mask-size: contain;
    mask-repeat: no-repeat;
    mask-position: center;
}

.share-twitter .share-icon { mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z'/%3E%3C/svg%3E"); }

.share-tooltip {
    position: absolute;
    right: 60px;
    background: var(--bg-tertiary);
    color: var(--text-primary);
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transform: translateX(10px);
    transition: all 0.3s ease;
}

.share-btn:hover .share-tooltip {
    opacity: 1;
    transform: translateX(0);
}

.share-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--border-color), transparent);
    margin: 0.5rem 0;
}

/* Reading Mode */
.reading-mode {
    max-width: 700px;
    margin: 0 auto;
    font-size: 1.125rem;
    line-height: 2;
    background: var(--bg-secondary);
    padding: 3rem;
    border-radius: 1rem;
}

.reading-mode .prose-premium {
    color: var(--text-primary);
}

/* Highlight Mode */
.highlight-mode p::selection,
.highlight-mode h1::selection,
.highlight-mode h2::selection,
.highlight-mode h3::selection {
    background: rgba(249, 115, 22, 0.3);
    color: var(--text-primary);
}

/* Responsive */
@media (max-width: 1024px) {
    .toc-premium {
        display: none;
    }
}

@media (max-width: 768px) {
    .prose-premium h2 {
        font-size: 1.875rem;
    }
    
    .prose-premium p:first-of-type::first-letter {
        font-size: 3rem;
    }
    
    .content-toolbar {
        left: 50%;
        transform: translateX(-50%);
    }
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('pageContentPremium', (config = {}) => ({
        show_toc: config.show_toc || false,
        enable_sharing: config.enable_sharing || false,
        showShareButtons: false,
        showToolbar: false,
        readProgress: 0,
        progressCircumference: 2 * Math.PI * 16,
        progressOffset: 2 * Math.PI * 16,
        fontSize: 100,
        readingMode: false,
        highlightMode: false,
        
        init() {
            this.setupReadingProgress();
            this.setupScrollEffects();
            
            if (this.show_toc) {
                this.$nextTick(() => this.generatePremiumToc());
            }
            
            // Show toolbar after scroll
            window.addEventListener('scroll', () => {
                this.showToolbar = window.pageYOffset > 300;
                this.showShareButtons = window.pageYOffset > 200;
            }, { passive: true });
        },
        
        setupReadingProgress() {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const maxHeight = document.documentElement.scrollHeight - window.innerHeight;
                this.readProgress = Math.min((scrolled / maxHeight) * 100, 100);
                
                // Update circular progress
                this.progressOffset = this.progressCircumference - (this.readProgress / 100) * this.progressCircumference;
            }, { passive: true });
        },
        
        setupScrollEffects() {
            const content = this.$refs.content;
            if (!content) return;
            
            // Add reveal animations to elements
            const elements = content.querySelectorAll('p, h2, h3, blockquote, img');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('content-revealed');
                    }
                });
            }, { threshold: 0.1 });
            
            elements.forEach(el => {
                el.classList.add('content-reveal');
                observer.observe(el);
            });
        },
        
        generatePremiumToc() {
            const headings = this.$refs.content?.querySelectorAll('h2, h3, h4');
            if (!headings || headings.length < 3) {
                this.show_toc = false;
                return;
            }
            
            const tocNav = this.$refs.tocNav;
            if (!tocNav) return;
            
            headings.forEach((heading, index) => {
                const id = heading.id || `heading-${index}`;
                heading.id = id;
                
                const link = document.createElement('a');
                link.href = `#${id}`;
                link.textContent = heading.textContent;
                link.className = 'toc-link';
                
                const level = parseInt(heading.tagName.substring(1));
                link.style.paddingLeft = `${(level - 2) * 1.5 + 1}rem`;
                
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    heading.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start',
                        inline: 'nearest'
                    });
                });
                
                tocNav.appendChild(link);
            });
            
            // Active section tracking
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const link = tocNav.querySelector(`a[href="#${entry.target.id}"]`);
                    if (link) {
                        if (entry.isIntersecting) {
                            tocNav.querySelectorAll('a').forEach(a => a.classList.remove('active'));
                            link.classList.add('active');
                        }
                    }
                });
            }, { rootMargin: '-20% 0px -70% 0px' });
            
            headings.forEach(heading => observer.observe(heading));
        },
        
        toggleReadingMode() {
            this.readingMode = !this.readingMode;
            const content = this.$refs.content;
            if (content) {
                content.classList.toggle('reading-mode');
            }
        },
        
        adjustFontSize(direction) {
            if (direction === 'increase' && this.fontSize < 150) {
                this.fontSize += 10;
            } else if (direction === 'decrease' && this.fontSize > 70) {
                this.fontSize -= 10;
            }
            
            const content = this.$refs.content;
            if (content) {
                content.style.fontSize = `${this.fontSize}%`;
            }
        },
        
        toggleHighlight() {
            this.highlightMode = !this.highlightMode;
            const content = this.$refs.content;
            if (content) {
                content.classList.toggle('highlight-mode');
            }
        },
        
        share(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
            
            const urls = {
                twitter: `https://twitter.com/intent/tweet?url=${url}&text=${title}`,
                facebook: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
                linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${url}`,
                whatsapp: `https://wa.me/?text=${title}%20${url}`
            };
            
            if (urls[platform]) {
                window.open(urls[platform], '_blank', 'width=600,height=400');
            }
        },
        
        async copyLink() {
            try {
                await navigator.clipboard.writeText(window.location.href);
                
                // Premium toast notification
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 bg-gradient-to-r from-primary to-accent text-white px-6 py-3 rounded-full shadow-2xl z-50 flex items-center gap-2';
                toast.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Link copied successfully!</span>
                `;
                document.body.appendChild(toast);
                
                // Animate in
                toast.style.animation = 'slide-in-right 0.3s ease-out';
                
                setTimeout(() => {
                    toast.style.animation = 'slide-out-right 0.3s ease-in';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            } catch (err) {
                console.error('Failed to copy:', err);
            }
        }
    }));
});

// Animation keyframes
const style = document.createElement('style');
style.textContent = `
@keyframes slide-in-right {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slide-out-right {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

.content-reveal {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.content-revealed {
    opacity: 1;
    transform: translateY(0);
}
`;
document.head.appendChild(style);
</script>