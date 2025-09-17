{{--
  🚀 Blitz Theme - Partials Showcase
  Clean, complete demonstration of all enhanced partials
--}}

@extends('layouts.app')

@section('content')
<div class="showcase-page bg-bg-primary min-h-screen" x-data="showcaseController()" x-init="init()">

    {{-- Page Header --}}
    @include('partials.page-header', [
        'title' => __('Blitz Theme Showcase', 'blitz'),
        'subtitle' => __('Enhanced Partials & Components Demo', 'blitz'),
        'size' => 'large',
        'gradient' => true,
        'animated' => true
    ])

    <div class="container mx-auto px-4 py-12">
        
        {{-- Navigation --}}
        <div class="flex flex-wrap justify-center gap-2 mb-8">
            <button @click="activeSection = 'content'" :class="{ 'bg-primary text-white': activeSection === 'content', 'bg-bg-secondary text-text-muted': activeSection !== 'content' }" class="px-4 py-2 rounded-lg transition-colors">
                {{ __('Content Partials', 'blitz') }}
            </button>
            <button @click="activeSection = 'widgets'" :class="{ 'bg-primary text-white': activeSection === 'widgets', 'bg-bg-secondary text-text-muted': activeSection !== 'widgets' }" class="px-4 py-2 rounded-lg transition-colors">
                {{ __('Widgets', 'blitz') }}
            </button>
            <button @click="activeSection = 'components'" :class="{ 'bg-primary text-white': activeSection === 'components', 'bg-bg-secondary text-text-muted': activeSection !== 'components' }" class="px-4 py-2 rounded-lg transition-colors">
                {{ __('Components', 'blitz') }}
            </button>
        </div>

        {{-- Content Partials Section --}}
        <section x-show="activeSection === 'content'" x-transition class="space-y-12">
            
            <h2 class="text-3xl font-bold text-text-primary text-center mb-8">{{ __('Content Partials Demo', 'blitz') }}</h2>

            {{-- Blog Cards Demo --}}
            <div class="demo-block">
                <h3 class="text-xl font-semibold mb-6">{{ __('Blog Content Cards', 'blitz') }}</h3>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $sample_posts = [
                            ['id' => 1, 'title' => 'Modern WordPress Development', 'excerpt' => 'Learn advanced techniques for building modern WordPress themes.'],
                            ['id' => 2, 'title' => 'Alpine.js Guide', 'excerpt' => 'Reactive functionality without complex frameworks.'],
                            ['id' => 3, 'title' => 'Tailwind CSS Tips', 'excerpt' => 'Utility-first CSS for rapid development.']
                        ];
                    @endphp

                    @foreach($sample_posts as $post)
                        <article class="bg-card-bg border border-border-color rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1" x-data="demoPost({{ $post['id'] }})">
                            <div class="aspect-video bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center">
                                <span class="text-4xl">📖</span>
                            </div>
                            
                            <div class="p-6">
                                <h4 class="text-lg font-semibold mb-2">{{ $post['title'] }}</h4>
                                <p class="text-text-secondary text-sm mb-4">{{ $post['excerpt'] }}</p>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-text-muted">Dec 15, 2024</span>
                                    <div class="flex gap-2">
                                        <button @click="toggleBookmark()" :class="{ 'text-accent': bookmarked, 'text-text-muted': !bookmarked }" class="hover:scale-110 transition-transform">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                            </svg>
                                        </button>
                                        <button @click="share()" class="text-text-muted hover:text-primary hover:scale-110 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-6 p-4 bg-bg-secondary rounded-lg">
                    <h4 class="font-medium mb-2">{{ __('Usage:', 'blitz') }}</h4>
                    <code class="text-sm">@include('partials.content')</code>
                </div>
            </div>

            {{-- Entry Meta Demo --}}
            <div class="demo-block">
                <h3 class="text-xl font-semibold mb-6">{{ __('Entry Meta Variations', 'blitz') }}</h3>
                
                <div class="space-y-6">
                    <div class="bg-card-bg border border-border-color rounded-lg p-6">
                        <h4 class="font-medium mb-4">{{ __('Horizontal Layout', 'blitz') }}</h4>
                        <div class="flex items-center gap-4 text-sm text-text-muted">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center">
                                    <span class="text-xs">👤</span>
                                </div>
                                <span>By John Doe</span>
                            </div>
                            <span>•</span>
                            <span>Dec 15, 2024</span>
                            <span>•</span>
                            <span>5 min read</span>
                        </div>
                        <div class="mt-3 text-xs bg-bg-secondary p-2 rounded">
                            <code>@include('partials.entry-meta', ['layout' => 'horizontal'])</code>
                        </div>
                    </div>

                    <div class="bg-card-bg border border-border-color rounded-lg p-6">
                        <h4 class="font-medium mb-4">{{ __('Vertical Layout', 'blitz') }}</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center">
                                    <span>👤</span>
                                </div>
                                <div>
                                    <div class="font-medium">Jane Smith</div>
                                    <div class="text-text-muted text-xs">WordPress Developer</div>
                                </div>
                            </div>
                            <div class="text-text-muted">December 15, 2024</div>
                            <div class="text-text-muted">8 min read</div>
                        </div>
                        <div class="mt-3 text-xs bg-bg-secondary p-2 rounded">
                            <code>@include('partials.entry-meta', ['layout' => 'vertical'])</code>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Widgets Section --}}
        <section x-show="activeSection === 'widgets'" x-transition class="space-y-12">
            
            <h2 class="text-3xl font-bold text-text-primary text-center mb-8">{{ __('Widget Gallery', 'blitz') }}</h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                {{-- Popular Posts Widget --}}
                <div class="widget bg-card-bg border border-border-color rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <span class="text-accent">⚡</span>
                        {{ __('Popular Posts', 'blitz') }}
                    </h3>
                    
                    <ul class="space-y-3">
                        @foreach(['Modern WordPress Themes', 'Alpine.js Tutorial', 'CSS Grid Mastery'] as $index => $title)
                            <li class="flex items-start gap-3 group">
                                <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-primary/30 transition-colors">
                                    <span class="text-primary font-bold">#{{ $index + 1 }}</span>
                                </div>
                                <div class="flex-1">
                                    <a href="#" class="font-medium hover:text-primary transition-colors">{{ $title }}</a>
                                    <div class="text-xs text-text-muted mt-1">Dec {{ 15 - $index }}, 2024</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Newsletter Widget --}}
                <div class="widget bg-gradient-to-br from-primary/5 to-accent/5 border border-primary/20 rounded-xl p-6" x-data="{ email: '', subscribed: false }">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <span class="text-primary">📧</span>
                        {{ __('Newsletter', 'blitz') }}
                    </h3>
                    
                    <div x-show="!subscribed">
                        <p class="text-sm text-text-secondary mb-4">{{ __('Get latest updates delivered to your inbox!', 'blitz') }}</p>
                        
                        <form @submit.prevent="subscribed = true" class="space-y-3">
                            <input type="email" x-model="email" placeholder="your@email.com" required class="w-full px-3 py-2 border border-border-color rounded-lg text-sm focus:ring-2 focus:ring-primary/20">
                            <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary-dark transition-colors text-sm">
                                {{ __('Subscribe', 'blitz') }}
                            </button>
                        </form>
                    </div>
                    
                    <div x-show="subscribed" x-transition class="text-center py-4">
                        <div class="text-green-600 mb-2">✅</div>
                        <p class="text-sm font-medium">{{ __('Thanks for subscribing!', 'blitz') }}</p>
                    </div>
                </div>

                {{-- Social Follow Widget --}}
                <div class="widget bg-card-bg border border-border-color rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <span class="text-accent">🌐</span>
                        {{ __('Follow Us', 'blitz') }}
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-3">
                        @php
                            $socials = [
                                ['name' => 'Twitter', 'color' => 'hover:bg-blue-400', 'icon' => '🐦'],
                                ['name' => 'Facebook', 'color' => 'hover:bg-blue-600', 'icon' => '📘'],
                                ['name' => 'Instagram', 'color' => 'hover:bg-pink-500', 'icon' => '📷'],
                                ['name' => 'YouTube', 'color' => 'hover:bg-red-600', 'icon' => '📺']
                            ];
                        @endphp
                        
                        @foreach($socials as $social)
                            <a href="#" class="flex items-center gap-2 p-2 bg-bg-secondary {{ $social['color'] }} hover:text-white rounded-lg transition-all text-sm">
                                <span>{{ $social['icon'] }}</span>
                                <span>{{ $social['name'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Recent Comments Widget --}}
                <div class="widget bg-card-bg border border-border-color rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <span class="text-primary">💬</span>
                        {{ __('Recent Comments', 'blitz') }}
                    </h3>
                    
                    <ul class="space-y-4">
                        @foreach([['author' => 'Sarah', 'comment' => 'Great article!'], ['author' => 'Mike', 'comment' => 'Very helpful guide.']] as $comment)
                            <li class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center text-xs font-bold text-primary">
                                    {{ substr($comment['author'], 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-sm">{{ $comment['author'] }}</div>
                                    <div class="text-xs text-text-secondary">{{ $comment['comment'] }}</div>
                                    <div class="text-xs text-text-muted mt-1">2 hours ago</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Search Widget --}}
                <div class="widget bg-card-bg border border-border-color rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <span class="text-primary">🔍</span>
                        {{ __('Search', 'blitz') }}
                    </h3>
                    
                    <form class="mb-4">
                        <div class="relative">
                            <input type="search" placeholder="Search posts..." class="w-full pl-4 pr-10 py-2 border border-border-color rounded-lg text-sm focus:ring-2 focus:ring-primary/20">
                            <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-text-muted hover:text-primary">
                                🔍
                            </button>
                        </div>
                    </form>
                    
                    <div>
                        <p class="text-xs text-text-muted mb-2">{{ __('Popular:', 'blitz') }}</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach(['WordPress', 'CSS', 'JavaScript'] as $tag)
                                <button class="text-xs px-2 py-1 bg-bg-tertiary hover:bg-primary hover:text-white rounded-full transition-colors">
                                    {{ $tag }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Archives Widget --}}
                <div class="widget bg-card-bg border border-border-color rounded-xl p-6" x-data="{ expanded: false }">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <span class="text-primary">📅</span>
                        {{ __('Archives', 'blitz') }}
                    </h3>
                    
                    <ul class="space-y-2">
                        @foreach(['December 2024', 'November 2024', 'October 2024'] as $month)
                            <li>
                                <a href="#" class="flex justify-between hover:text-primary transition-colors text-sm">
                                    <span>{{ $month }}</span>
                                    <span class="text-text-muted">({{ rand(5, 15) }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    
                    <div x-show="expanded" x-transition>
                        <ul class="space-y-2 mt-2">
                            @foreach(['September 2024', 'August 2024'] as $month)
                                <li>
                                    <a href="#" class="flex justify-between hover:text-primary transition-colors text-sm">
                                        <span>{{ $month }}</span>
                                        <span class="text-text-muted">({{ rand(3, 12) }})</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <button @click="expanded = !expanded" class="text-sm text-primary hover:text-primary-dark mt-3 flex items-center gap-1">
                        <span x-text="expanded ? '{{ __('Show Less', 'blitz') }}' : '{{ __('Show More', 'blitz') }}'"></span>
                        <svg class="w-3 h-3 transition-transform" :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="bg-card-bg border border-border-color rounded-xl p-6">
                <h4 class="font-semibold mb-4">{{ __('Widget Usage Examples', 'blitz') }}</h4>
                <pre class="bg-bg-secondary p-4 rounded-lg text-sm overflow-x-auto"><code>{{-- In sidebar.blade.php --}}
&lt;aside class="sidebar"&gt;
    @include('partials.widgets.popular-posts-inline')
    @include('partials.widgets.newsletter-inline')
    @include('partials.widgets.social-follow-inline')
    @php(dynamic_sidebar('sidebar-primary'))
&lt;/aside&gt;</code></pre>
            </div>
        </section>

        {{-- Components Section --}}
        <section x-show="activeSection === 'components'" x-transition class="space-y-12">
            
            <h2 class="text-3xl font-bold text-text-primary text-center mb-8">{{ __('Interactive Components', 'blitz') }}</h2>

            <div class="grid md:grid-cols-2 gap-8">
                
                {{-- Modal Demo --}}
                <div class="bg-card-bg border border-border-color rounded-xl p-6" x-data="{ modalOpen: false }">
                    <h4 class="font-medium mb-4">{{ __('Modal Component', 'blitz') }}</h4>
                    
                    <button @click="modalOpen = true" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                        {{ __('Open Modal', 'blitz') }}
                    </button>
                    
                    <div x-show="modalOpen" x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" @click.away="modalOpen = false">
                        <div class="bg-card-bg rounded-xl p-6 max-w-md mx-4" @click.stop>
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold">{{ __('Demo Modal', 'blitz') }}</h3>
                                <button @click="modalOpen = false" class="text-text-muted hover:text-text-primary">✕</button>
                            </div>
                            <p class="mb-4">{{ __('This is a sample modal with Alpine.js.', 'blitz') }}</p>
                            <div class="flex gap-3 justify-end">
                                <button @click="modalOpen = false" class="px-4 py-2 border border-border-color rounded-lg">{{ __('Cancel', 'blitz') }}</button>
                                <button @click="modalOpen = false" class="px-4 py-2 bg-primary text-white rounded-lg">{{ __('OK', 'blitz') }}</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3 text-xs bg-bg-secondary p-2 rounded">
                        <code>x-data="{ modalOpen: false }" @click="modalOpen = true"</code>
                    </div>
                </div>

                {{-- Tabs Demo --}}
                <div class="bg-card-bg border border-border-color rounded-xl p-6" x-data="{ activeTab: 'tab1' }">
                    <h4 class="font-medium mb-4">{{ __('Tab Navigation', 'blitz') }}</h4>
                    
                    <div class="border-b border-border-color mb-4">
                        <div class="flex">
                            <button @click="activeTab = 'tab1'" :class="{ 'border-primary text-primary': activeTab === 'tab1' }" class="px-4 py-2 -mb-px border-b-2 border-transparent text-sm">{{ __('Tab 1', 'blitz') }}</button>
                            <button @click="activeTab = 'tab2'" :class="{ 'border-primary text-primary': activeTab === 'tab2' }" class="px-4 py-2 -mb-px border-b-2 border-transparent text-sm">{{ __('Tab 2', 'blitz') }}</button>
                            <button @click="activeTab = 'tab3'" :class="{ 'border-primary text-primary': activeTab === 'tab3' }" class="px-4 py-2 -mb-px border-b-2 border-transparent text-sm">{{ __('Tab 3', 'blitz') }}</button>
                        </div>
                    </div>
                    
                    <div class="tab-content">
                        <div x-show="activeTab === 'tab1'" x-transition class="text-sm">{{ __('Content for tab 1', 'blitz') }}</div>
                        <div x-show="activeTab === 'tab2'" x-transition class="text-sm">{{ __('Content for tab 2', 'blitz') }}</div>
                        <div x-show="activeTab === 'tab3'" x-transition class="text-sm">{{ __('Content for tab 3', 'blitz') }}</div>
                    </div>
                    
                    <div class="mt-3 text-xs bg-bg-secondary p-2 rounded">
                        <code>x-data="{ activeTab: 'tab1' }" x-show="activeTab === 'tab1'"</code>
                    </div>
                </div>

                {{-- Form Demo --}}
                <div class="bg-card-bg border border-border-color rounded-xl p-6" x-data="{ name: '', email: '', submitted: false }">
                    <h4 class="font-medium mb-4">{{ __('Form Validation', 'blitz') }}</h4>
                    
                    <form @submit.prevent="submitted = true" x-show="!submitted" class="space-y-4">
                        <div>
                            <input type="text" x-model="name" placeholder="Your name" required class="w-full px-3 py-2 border border-border-color rounded-lg text-sm">
                        </div>
                        <div>
                            <input type="email" x-model="email" placeholder="your@email.com" required class="w-full px-3 py-2 border border-border-color rounded-lg text-sm">
                        </div>
                        <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary-dark transition-colors">
                            {{ __('Submit', 'blitz') }}
                        </button>
                    </form>
                    
                    <div x-show="submitted" x-transition class="text-center py-4">
                        <div class="text-green-600 mb-2">✅</div>
                        <p class="font-medium">{{ __('Form submitted!', 'blitz') }}</p>
                        <button @click="submitted = false; name = ''; email = ''" class="text-sm text-primary mt-2">{{ __('Reset', 'blitz') }}</button>
                    </div>
                    
                    <div class="mt-3 text-xs bg-bg-secondary p-2 rounded">
                        <code>x-model="name" @submit.prevent="submitted = true"</code>
                    </div>
                </div>

                {{-- Loading States --}}
                <div class="bg-card-bg border border-border-color rounded-xl p-6" x-data="{ loading: false }">
                    <h4 class="font-medium mb-4">{{ __('Loading States', 'blitz') }}</h4>
                    
                    <button @click="loading = true; setTimeout(() => loading = false, 2000)" :disabled="loading" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark disabled:opacity-50 transition-colors flex items-center gap-2">
                        <div x-show="loading" class="animate-spin w-4 h-4 border-2 border-white border-t-transparent rounded-full"></div>
                        <span x-text="loading ? '{{ __('Loading...', 'blitz') }}' : '{{ __('Start Demo', 'blitz') }}'"></span>
                    </button>
                    
                    <div class="mt-3 text-xs bg-bg-secondary p-2 rounded">
                        <code>:disabled="loading" x-show="loading"</code>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('showcaseController', () => ({
        activeSection: 'content',
        
        init() {
            console.log('Showcase initialized');
        }
    }));
    
    Alpine.data('demoPost', (id) => ({
        id,
        bookmarked: false,
        
        toggleBookmark() {
            this.bookmarked = !this.bookmarked;
            console.log(`Post ${this.id} ${this.bookmarked ? 'bookmarked' : 'unbookmarked'}`);
        },
        
        share() {
            if (navigator.share) {
                navigator.share({
                    title: `Demo Post ${this.id}`,
                    url: window.location.href
                });
            } else {
                console.log(`Sharing post ${this.id}`);
            }
        }
    }));
});
</script>
@endsection