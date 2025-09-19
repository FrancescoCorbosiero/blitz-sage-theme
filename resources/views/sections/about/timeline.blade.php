{{-- resources/views/sections/about/about-timeline.blade.php --}}
{{-- Interactive Timeline About Section --}}

<section class="about-timeline relative py-20 lg:py-32 overflow-hidden"
         x-data="aboutTimeline()"
         x-init="init()">
    
    {{-- Background Elements --}}
    <div class="absolute inset-0 bg-gradient-to-b from-white via-gray-50 to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-900"></div>
    
    {{-- Animated Background Pattern --}}
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500 rounded-full filter blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>
    
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-16 lg:mb-24">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 dark:bg-blue-900/30 rounded-full mb-6"
                 x-data="{ show: false }"
                 x-init="setTimeout(() => show = true, 100)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-600"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Our Story</span>
            </div>
            
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 bg-gradient-to-r from-gray-900 via-blue-800 to-purple-800 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                Building the Future of WordPress
            </h2>
            
            <p class="text-xl text-gray-600 dark:text-gray-400 leading-relaxed">
                From a simple idea to a revolutionary theme framework, discover how Blitz is transforming 
                the way developers build WordPress sites.
            </p>
        </div>
        
        {{-- Interactive Timeline --}}
        <div class="relative">
            {{-- Timeline Line --}}
            <div class="absolute left-1/2 transform -translate-x-1/2 w-0.5 h-full bg-gradient-to-b from-blue-500 via-purple-500 to-pink-500 opacity-20"></div>
            
            {{-- Timeline Progress --}}
            <div class="absolute left-1/2 transform -translate-x-1/2 w-0.5 bg-gradient-to-b from-blue-500 to-purple-500"
                 :style="`height: ${timelineProgress}%`"></div>
            
            {{-- Timeline Items --}}
            <div class="space-y-24">
                @php
                    $milestones = [
                        [
                            'year' => '2020',
                            'title' => 'The Beginning',
                            'description' => 'Started with a vision to create the most performant WordPress theme.',
                            'icon' => '<path d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                            'stats' => ['100+ hours', 'Research', '50+ themes', 'Analyzed'],
                            'image' => null
                        ],
                        [
                            'year' => '2021',
                            'title' => 'First Release',
                            'description' => 'Launched Blitz 1.0 with revolutionary performance optimizations.',
                            'icon' => '<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>',
                            'stats' => ['100/100', 'PageSpeed', '< 50ms', 'Load Time'],
                            'image' => null
                        ],
                        [
                            'year' => '2023',
                            'title' => 'Community Growth',
                            'description' => 'Built an amazing community of developers and designers.',
                            'icon' => '<path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
                            'stats' => ['10k+', 'Users', '50+', 'Contributors'],
                            'image' => null
                        ],
                        [
                            'year' => '2024',
                            'title' => 'AI Integration',
                            'description' => 'Integrated cutting-edge AI tools for content generation and optimization.',
                            'icon' => '<path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                            'stats' => ['GPT-4', 'Powered', 'Auto', 'Optimization'],
                            'image' => null
                        ]
                    ];
                @endphp
                
                @foreach($milestones as $index => $milestone)
                    <div class="timeline-item relative"
                         x-data="{ visible: false }"
                         x-intersect:enter="visible = true"
                         :class="{ 'timeline-visible': visible }">
                        
                        {{-- Timeline Node --}}
                        <div class="absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2 top-1/2">
                            <div class="timeline-node relative">
                                <div class="w-6 h-6 bg-white dark:bg-gray-800 rounded-full border-4 border-blue-500 z-10"></div>
                                <div class="absolute inset-0 w-6 h-6 bg-blue-500 rounded-full animate-ping"></div>
                            </div>
                        </div>
                        
                        {{-- Content Card --}}
                        <div class="grid md:grid-cols-2 gap-8 items-center {{ $index % 2 === 0 ? '' : 'md:flex-row-reverse' }}">
                            
                            {{-- Text Content --}}
                            <div class="{{ $index % 2 === 0 ? 'md:text-right md:pr-16' : 'md:text-left md:pl-16' }}"
                                 x-show="visible"
                                 x-transition:enter="transition ease-out duration-1000"
                                 x-transition:enter-start="opacity-0 {{ $index % 2 === 0 ? 'translate-x-10' : '-translate-x-10' }}"
                                 x-transition:enter-end="opacity-100 translate-x-0">
                                
                                <div class="inline-flex items-center gap-3 mb-4 {{ $index % 2 === 0 ? 'md:justify-end' : '' }}">
                                    <span class="text-3xl font-bold text-gray-300 dark:text-gray-700">{{ $milestone['year'] }}</span>
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $milestone['icon'] !!}
                                        </svg>
                                    </div>
                                </div>
                                
                                <h3 class="text-2xl md:text-3xl font-bold mb-4 text-gray-900 dark:text-white">
                                    {{ $milestone['title'] }}
                                </h3>
                                
                                <p class="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                                    {{ $milestone['description'] }}
                                </p>
                                
                                {{-- Stats Grid --}}
                                <div class="grid grid-cols-2 gap-4 {{ $index % 2 === 0 ? 'md:justify-end' : '' }}">
                                    @for($i = 0; $i < count($milestone['stats']); $i += 2)
                                        <div class="stat-card bg-white dark:bg-gray-800 rounded-lg p-4 shadow-lg border border-gray-100 dark:border-gray-700">
                                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                                {{ $milestone['stats'][$i] }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $milestone['stats'][$i + 1] }}
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            
                            {{-- Visual Element --}}
                            <div class="{{ $index % 2 === 0 ? 'md:order-first' : '' }}"
                                 x-show="visible"
                                 x-transition:enter="transition ease-out duration-1000 delay-300"
                                 x-transition:enter-start="opacity-0 scale-90"
                                 x-transition:enter-end="opacity-100 scale-100">
                                
                                <div class="visual-container relative">
                                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl blur-2xl opacity-20"></div>
                                    <div class="relative bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-8 border border-gray-200 dark:border-gray-700">
                                        
                                        {{-- Animated Code Block --}}
                                        <div class="code-preview font-mono text-sm">
                                            <div class="flex items-center gap-2 mb-4">
                                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                            </div>
                                            <pre class="text-gray-700 dark:text-gray-300"><code x-data="{ text: '' }"
                                                  x-init="
                                                      const code = `// {{ $milestone['title'] }}
const performance = {
  score: 100,
  metrics: 'perfect'
};`;
                                                      let i = 0;
                                                      const type = () => {
                                                          if (i < code.length) {
                                                              text += code.charAt(i);
                                                              i++;
                                                              setTimeout(type, 30);
                                                          }
                                                      };
                                                      setTimeout(type, 1000);
                                                  "
                                                  x-text="text"></code></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        {{-- Team Section --}}
        <div class="mt-32">
            <div class="text-center mb-16">
                <h3 class="text-3xl md:text-4xl font-bold mb-4 text-gray-900 dark:text-white">
                    Meet the Team
                </h3>
                <p class="text-xl text-gray-600 dark:text-gray-400">
                    Passionate developers and designers crafting excellence
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                @php
                    $team = [
                        ['name' => 'Alex Chen', 'role' => 'Lead Developer', 'avatar' => null],
                        ['name' => 'Sarah Johnson', 'role' => 'UX Designer', 'avatar' => null],
                        ['name' => 'Mike Wilson', 'role' => 'Performance Engineer', 'avatar' => null],
                    ];
                @endphp
                
                @foreach($team as $member)
                    <div class="team-card group cursor-pointer"
                         x-data="{ hover: false }"
                         @mouseenter="hover = true"
                         @mouseleave="hover = false">
                        
                        <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 transition-all duration-500"
                             :class="{ 'scale-105 shadow-2xl': hover }">
                            
                            {{-- Avatar --}}
                            <div class="aspect-square bg-gradient-to-br from-blue-400 to-purple-600 relative overflow-hidden">
                                <div class="absolute inset-0 flex items-center justify-center text-white text-4xl font-bold">
                                    {{ substr($member['name'], 0, 1) }}
                                </div>
                                <div class="absolute inset-0 bg-black opacity-0 transition-opacity duration-300"
                                     :class="{ 'opacity-20': hover }"></div>
                            </div>
                            
                            {{-- Info --}}
                            <div class="p-6">
                                <h4 class="text-xl font-bold mb-1 text-gray-900 dark:text-white">{{ $member['name'] }}</h4>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $member['role'] }}</p>
                                
                                {{-- Social Links --}}
                                <div class="flex gap-3 opacity-0 transform translate-y-2 transition-all duration-300"
                                     :class="{ 'opacity-100 translate-y-0': hover }">
                                    <a href="#" class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center hover:bg-blue-500 hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </a>
                                    <a href="#" class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center hover:bg-blue-500 hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        {{-- Values Grid --}}
        <div class="mt-32">
            <div class="text-center mb-16">
                <h3 class="text-3xl md:text-4xl font-bold mb-4 text-gray-900 dark:text-white">
                    Our Core Values
                </h3>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $values = [
                        ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Performance', 'desc' => 'Speed is not a feature, it\'s a requirement'],
                        ['icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4', 'title' => 'Flexibility', 'desc' => 'Adapt to any design requirement'],
                        ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Security', 'desc' => 'Built with security best practices'],
                        ['icon' => 'M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z', 'title' => 'Support', 'desc' => 'Community-driven development'],
                    ];
                @endphp
                
                @foreach($values as $value)
                    <div class="value-card text-center group"
                         x-data="{ count: 0 }"
                         x-intersect:enter.once="
                             let target = Math.floor(Math.random() * 50) + 50;
                             let interval = setInterval(() => {
                                 if (count < target) {
                                     count += 2;
                                 } else {
                                     clearInterval(interval);
                                 }
                             }, 30);
                         ">
                        
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $value['icon'] }}"/>
                            </svg>
                        </div>
                        
                        <h4 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">{{ $value['title'] }}</h4>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $value['desc'] }}</p>
                        
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                            <span x-text="count"></span>%
                        </div>
                        <div class="text-sm text-gray-500">Commitment Level</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<style>
.timeline-item {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease-out;
}

.timeline-visible {
    opacity: 1;
    transform: translateY(0);
}

.stat-card {
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('aboutTimeline', () => ({
        timelineProgress: 0,
        
        init() {
            this.trackScroll();
        },
        
        trackScroll() {
            window.addEventListener('scroll', () => {
                const timeline = this.$el.querySelector('.timeline-item:last-child');
                if (!timeline) return;
                
                const rect = timeline.getBoundingClientRect();
                const windowHeight = window.innerHeight;
                const documentHeight = document.documentElement.scrollHeight;
                const scrollTop = window.scrollY;
                
                // Calculate progress based on section visibility
                const sectionTop = this.$el.offsetTop;
                const sectionHeight = this.$el.offsetHeight;
                const sectionBottom = sectionTop + sectionHeight;
                
                if (scrollTop + windowHeight > sectionTop && scrollTop < sectionBottom) {
                    const progress = Math.min(100, ((scrollTop + windowHeight - sectionTop) / sectionHeight) * 100);
                    this.timelineProgress = progress;
                }
            });
        }
    }));
});
</script>