{{-- resources/views/sections/hero/hero-morphing.blade.php --}}
{{-- Morphing Gradient Hero with Text Effects --}}

<section class="hero-morphing relative min-h-screen flex items-center overflow-hidden"
         x-data="heroMorphing()"
         x-init="init()">
    
    {{-- Animated Background --}}
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900"></div>
        <div class="absolute inset-0 opacity-30">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
        </div>
    </div>
    
    {{-- Grid Pattern --}}
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="0.5" opacity="0.1"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"/%3E%3C/svg%3E')]"></div>
    
    <div class="relative z-10 container max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            {{-- Text Content --}}
            <div class="text-white space-y-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur rounded-full text-sm">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <span>Now Available</span>
                </div>
                
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight">
                    <span class="block">The Ultimate</span>
                    <span class="block mt-2">
                        <span x-data="{ 
                            words: ['WordPress', 'Performance', 'Developer'],
                            currentIndex: 0,
                            currentWord: 'WordPress'
                        }"
                        x-init="
                            setInterval(() => {
                                currentIndex = (currentIndex + 1) % words.length;
                                currentWord = words[currentIndex];
                            }, 2000)
                        "
                        class="text-gradient inline-block"
                        x-text="currentWord">WordPress</span>
                        <span> Theme</span>
                    </span>
                </h1>
                
                <p class="text-xl text-white/80 leading-relaxed">
                    Experience the perfect blend of speed, beauty, and functionality. 
                    Blitz Theme sets new standards for WordPress development with its 
                    modern architecture and blazing-fast performance.
                </p>
                
                <div class="flex flex-wrap gap-6">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Sage 10 Framework</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>100% PageSpeed</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Dark Mode</span>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <button class="px-8 py-4 bg-white text-purple-900 font-semibold rounded-lg hover:shadow-2xl hover:shadow-white/25 transform hover:scale-105 transition-all duration-300">
                        Get Started Free
                    </button>
                    <button class="px-8 py-4 bg-white/10 backdrop-blur border border-white/20 text-white font-semibold rounded-lg hover:bg-white/20 transform hover:scale-105 transition-all duration-300">
                        Documentation
                    </button>
                </div>
            </div>
            
            {{-- Interactive Preview --}}
            <div class="relative"
                 x-data="{ activeTab: 'desktop' }">
                
                {{-- Device Switcher --}}
                <div class="flex justify-center gap-2 mb-8">
                    <button @click="activeTab = 'desktop'"
                            :class="activeTab === 'desktop' ? 'bg-white text-purple-900' : 'bg-white/10 text-white'"
                            class="px-4 py-2 rounded-lg transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <button @click="activeTab = 'tablet'"
                            :class="activeTab === 'tablet' ? 'bg-white text-purple-900' : 'bg-white/10 text-white'"
                            class="px-4 py-2 rounded-lg transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zM9 14a1 1 0 100 2 1 1 0 000-2z"/>
                        </svg>
                    </button>
                    <button @click="activeTab = 'mobile'"
                            :class="activeTab === 'mobile' ? 'bg-white text-purple-900' : 'bg-white/10 text-white'"
                            class="px-4 py-2 rounded-lg transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 2a2 2 0 00-2 2v12a2 2 0 002 2h4a2 2 0 002-2V4a2 2 0 00-2-2H8zm1 14a1 1 0 100 2 1 1 0 000-2z"/>
                        </svg>
                    </button>
                </div>
                
                {{-- Device Preview --}}
                <div class="relative flex justify-center">
                    <div class="transition-all duration-500"
                         :class="{
                             'w-full max-w-2xl': activeTab === 'desktop',
                             'w-96': activeTab === 'tablet',
                             'w-64': activeTab === 'mobile'
                         }">
                        <div class="bg-gray-900 rounded-t-lg p-2 flex items-center gap-2">
                            <div class="flex gap-1">
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            </div>
                            <div class="flex-1 bg-gray-800 rounded text-xs text-gray-400 px-2 py-1 text-center">
                                blitz-theme.test
                            </div>
                        </div>
                        <div class="bg-white rounded-b-lg overflow-hidden shadow-2xl">
                            <img src="{{ Vite::asset('resources/images/theme-preview.png') }}" 
                                 alt="Theme Preview"
                                 class="w-full h-auto">
                        </div>
                    </div>
                </div>
                
                {{-- Floating Elements --}}
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-gradient-to-br from-blue-400 to-purple-400 rounded-full blur-xl opacity-60 animate-float"></div>
                <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-gradient-to-br from-pink-400 to-orange-400 rounded-full blur-xl opacity-60 animate-float-delayed"></div>
            </div>
        </div>
    </div>
</section>

<style>
/* Morphing blobs */
.blob {
    position: absolute;
    width: 400px;
    height: 400px;
    border-radius: 50%;
    filter: blur(100px);
}

.blob-1 {
    top: -200px;
    left: -200px;
    background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
    animation: blob-move 20s infinite;
}

.blob-2 {
    top: 50%;
    right: -200px;
    background: linear-gradient(45deg, #f093fb 0%, #f5576c 100%);
    animation: blob-move 25s infinite reverse;
}

.blob-3 {
    bottom: -200px;
    left: 30%;
    background: linear-gradient(45deg, #4facfe 0%, #00f2fe 100%);
    animation: blob-move 30s infinite;
}

@keyframes blob-move {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(100px, -100px) scale(1.1);
    }
    66% {
        transform: translate(-100px, 100px) scale(0.9);
    }
}

.text-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: gradient-shift 3s ease infinite;
}

@keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float 6s ease-in-out infinite;
    animation-delay: 3s;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('heroMorphing', () => ({
        init() {
            // Initialize any needed animations
        }
    }));
});
</script>