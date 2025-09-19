{{-- resources/views/sections/about/about-interactive.blade.php --}}
{{-- Interactive Skills & Mission About Section --}}

<section class="about-interactive relative py-20 lg:py-32 bg-white dark:bg-gray-900 overflow-hidden"
         x-data="aboutInteractive()">
    
    {{-- Animated Mesh Background --}}
    <canvas x-ref="canvas" class="absolute inset-0 w-full h-full opacity-10"></canvas>
    
    <div class="container max-w-7xl mx-auto px-4 relative z-10">
        
        {{-- Split Hero --}}
        <div class="grid lg:grid-cols-2 gap-16 items-center mb-32">
            
            {{-- Content Side --}}
            <div>
                <h2 class="text-5xl lg:text-6xl font-bold mb-8">
                    <span class="block text-gray-900 dark:text-white">We craft</span>
                    <span class="block mt-2">
                        <span class="animated-text text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600"
                              x-text="currentWord"></span>
                        <span class="cursor text-blue-600 animate-pulse">|</span>
                    </span>
                    <span class="block text-gray-900 dark:text-white">experiences</span>
                </h2>
                
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                    With over a decade of experience in WordPress development, we've mastered the art 
                    of creating themes that are not just beautiful, but blazingly fast and incredibly flexible.
                </p>
                
                {{-- Stats Row --}}
                <div class="grid grid-cols-3 gap-8 mb-8">
                    <div>
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400" 
                             x-data="{ count: 0 }"
                             x-init="
                                 setTimeout(() => {
                                     let interval = setInterval(() => {
                                         if (count < 10) count++;
                                         else clearInterval(interval);
                                     }, 100);
                                 }, 500)
                             "
                             x-text="count + '+'"></div>
                        <div class="text-sm text-gray-500">Years Experience</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-purple-600 dark:text-purple-400"
                             x-data="{ count: 0 }"
                             x-init="
                                 setTimeout(() => {
                                     let interval = setInterval(() => {
                                         if (count < 500) count += 10;
                                         else clearInterval(interval);
                                     }, 20);
                                 }, 700)
                             "
                             x-text="count + '+'"></div>
                        <div class="text-sm text-gray-500">Projects Done</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400"
                             x-data="{ count: 0 }"
                             x-init="
                                 setTimeout(() => {
                                     let interval = setInterval(() => {
                                         if (count < 100) count += 2;
                                         else clearInterval(interval);
                                     }, 30);
                                 }, 900)
                             "
                             x-text="count + '%'"></div>
                        <div class="text-sm text-gray-500">Client Satisfaction</div>
                    </div>
                </div>
                
                {{-- CTA Buttons --}}
                <div class="flex flex-wrap gap-4">
                    <button class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                        Start a Project
                    </button>
                    <button class="px-8 py-4 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white font-semibold rounded-xl hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        View Portfolio
                    </button>
                </div>
            </div>
            
            {{-- Interactive Skills Radar --}}
            <div class="relative">
                <div class="skills-radar relative w-full aspect-square max-w-lg mx-auto"
                     @mousemove="updateRadar($event)">
                    
                    {{-- Radar Background --}}
                    <svg class="absolute inset-0 w-full h-full" viewBox="0 0 400 400">
                        @for($i = 1; $i <= 5; $i++)
                            <circle cx="200" cy="200" r="{{ $i * 35 }}" 
                                    fill="none" 
                                    stroke="currentColor" 
                                    stroke-width="1" 
                                    class="text-gray-200 dark:text-gray-700"
                                    opacity="{{ 1 - ($i * 0.15) }}"/>
                        @endfor
                        
                        {{-- Skill Points --}}
                        <g class="skill-points">
                            @php
                                $skills = [
                                    ['name' => 'WordPress', 'value' => 95, 'angle' => 0],
                                    ['name' => 'Performance', 'value' => 100, 'angle' => 60],
                                    ['name' => 'SEO', 'value' => 90, 'angle' => 120],
                                    ['name' => 'Security', 'value' => 95, 'angle' => 180],
                                    ['name' => 'Design', 'value' => 85, 'angle' => 240],
                                    ['name' => 'Support', 'value' => 100, 'angle' => 300],
                                ];
                            @endphp
                            
                            @foreach($skills as $skill)
                                @php
                                    $rad = deg2rad($skill['angle'] - 90);
                                    $x = 200 + cos($rad) * ($skill['value'] * 1.75);
                                    $y = 200 + sin($rad) * ($skill['value'] * 1.75);
                                    $labelX = 200 + cos($rad) * 190;
                                    $labelY = 200 + sin($rad) * 190;
                                @endphp
                                
                                <circle cx="{{ $x }}" cy="{{ $y }}" r="8" 
                                        class="skill-dot fill-blue-600 dark:fill-blue-400"
                                        data-skill="{{ $skill['name'] }}"
                                        data-value="{{ $skill['value'] }}"/>
                                
                                <text x="{{ $labelX }}" y="{{ $labelY }}" 
                                      text-anchor="middle" 
                                      class="fill-gray-600 dark:fill-gray-400 text-sm font-semibold">
                                    {{ $skill['name'] }}
                                </text>
                            @endforeach
                            
                            {{-- Connecting Lines --}}
                            <polygon points="
                                {{ 200 + cos(deg2rad(-90)) * 166.25 }},{{ 200 + sin(deg2rad(-90)) * 166.25 }}
                                {{ 200 + cos(deg2rad(30-90)) * 175 }},{{ 200 + sin(deg2rad(30-90)) * 175 }}
                                {{ 200 + cos(deg2rad(120-90)) * 157.5 }},{{ 200 + sin(deg2rad(120-90)) * 157.5 }}
                                {{ 200 + cos(deg2rad(180-90)) * 166.25 }},{{ 200 + sin(deg2rad(180-90)) * 166.25 }}
                                {{ 200 + cos(deg2rad(240-90)) * 148.75 }},{{ 200 + sin(deg2rad(240-90)) * 148.75 }}
                                {{ 200 + cos(deg2rad(300-90)) * 175 }},{{ 200 + sin(deg2rad(300-90)) * 175 }}
                            "
                            fill="url(#gradient)"
                            fill-opacity="0.3"
                            stroke="url(#gradient)"
                            stroke-width="2"/>
                        </g>
                        
                        <defs>
                            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#3B82F6"/>
                                <stop offset="100%" stop-color="#8B5CF6"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    
                    {{-- Hover Info --}}
                    <div class="skill-tooltip absolute bg-white dark:bg-gray-800 rounded-lg shadow-xl p-4 pointer-events-none opacity-0 transition-opacity duration-300"
                         :style="tooltipPosition"
                         :class="{ 'opacity-100': hoveredSkill }">
                        <div class="font-semibold text-gray-900 dark:text-white" x-text="hoveredSkill"></div>
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400" x-text="hoveredValue + '%'"></div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Process Section --}}
        <div class="relative">
            <h3 class="text-3xl md:text-4xl font-bold text-center mb-16 text-gray-900 dark:text-white">
                Our Process
            </h3>
            
            <div class="process-timeline relative">
                <div class="absolute left-0 right-0 top-1/2 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 transform -translate-y-1/2 hidden md:block"></div>
                
                <div class="grid md:grid-cols-4 gap-8 relative">
                    @php
                        $processes = [
                            ['title' => 'Discover', 'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', 'desc' => 'Understanding your needs'],
                            ['title' => 'Design', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'desc' => 'Creating the perfect look'],
                            ['title' => 'Develop', 'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4', 'desc' => 'Building with precision'],
                            ['title' => 'Deploy', 'icon' => 'M7 4v16M17 4v16M3 12h18M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'desc' => 'Launching your success'],
                        ];
                    @endphp
                    
                    @foreach($processes as $index => $process)
                        <div class="process-step text-center group"
                             x-data="{ visible: false }"
                             x-intersect:enter="setTimeout(() => visible = true, {{ $index * 200 }})"
                             x-show="visible"
                             x-transition:enter="transition ease-out duration-800"
                             x-transition:enter-start="opacity-0 translate-y-10"
                             x-transition:enter-end="opacity-100 translate-y-0">
                            
                            <div class="w-24 h-24 mx-auto mb-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 relative z-10">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <svg class="w-12 h-12 text-blue-600 group-hover:text-white relative z-10 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $process['icon'] }}"/>
                                </svg>
                            </div>
                            
                            <h4 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">{{ $process['title'] }}</h4>
                            <p class="text-gray-600 dark:text-gray-400">{{ $process['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('aboutInteractive', () => ({
        words: ['beautiful', 'powerful', 'fast', 'secure', 'scalable'],
        currentWord: 'beautiful',
        wordIndex: 0,
        hoveredSkill: null,
        hoveredValue: null,
        tooltipPosition: { left: '0px', top: '0px' },
        
        init() {
            this.animateWords();
            this.initCanvas();
        },
        
        animateWords() {
            setInterval(() => {
                this.wordIndex = (this.wordIndex + 1) % this.words.length;
                this.currentWord = this.words[this.wordIndex];
            }, 2000);
        },
        
        updateRadar(event) {
            const rect = event.currentTarget.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;
            
            // Check if hovering over a skill point
            const dots = event.currentTarget.querySelectorAll('.skill-dot');
            let hovered = false;
            
            dots.forEach(dot => {
                const cx = parseFloat(dot.getAttribute('cx'));
                const cy = parseFloat(dot.getAttribute('cy'));
                const distance = Math.sqrt(Math.pow(x - cx, 2) + Math.pow(y - cy, 2));
                
                if (distance < 20) {
                    this.hoveredSkill = dot.dataset.skill;
                    this.hoveredValue = dot.dataset.value;
                    this.tooltipPosition = {
                        left: cx + 'px',
                        top: (cy - 60) + 'px'
                    };
                    hovered = true;
                }
            });
            
            if (!hovered) {
                this.hoveredSkill = null;
            }
        },
        
        initCanvas() {
            const canvas = this.$refs.canvas;
            const ctx = canvas.getContext('2d');
            canvas.width = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;
            
            // Create animated mesh background
            let time = 0;
            const animate = () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                // Draw animated lines
                for (let i = 0; i < 5; i++) {
                    ctx.beginPath();
                    ctx.moveTo(0, canvas.height * (i + 1) / 6);
                    
                    for (let x = 0; x < canvas.width; x += 10) {
                        const y = canvas.height * (i + 1) / 6 + Math.sin((x + time) * 0.01) * 20;
                        ctx.lineTo(x, y);
                    }
                    
                    ctx.strokeStyle = '#3B82F6';
                    ctx.stroke();
                }
                
                time += 2;
                requestAnimationFrame(animate);
            };
            
            animate();
        }
    }));
});
</script>