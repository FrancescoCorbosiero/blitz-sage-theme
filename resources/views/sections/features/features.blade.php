{{-- Self-contained Features Section - Blitz Theme --}}
@props([
    'layout' => 'grid',      // grid, alternating, centered
    'columns' => 3,
])

<section class="features-section py-20 lg:py-32 bg-gradient-to-b from-gray-50 to-white dark:from-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                {{ get_theme_mod('features_title', 'Powerful Features') }}
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                {{ get_theme_mod('features_subtitle', 'Everything you need to succeed') }}
            </p>
        </div>
        
        {{-- Features Grid --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-{{ $columns }} gap-8">
            @foreach(get_theme_mod('features_list', [
                ['icon' => '⚡', 'title' => 'Lightning Fast', 'description' => 'Optimized for speed and performance'],
                ['icon' => '🔒', 'title' => 'Secure', 'description' => 'Enterprise-grade security built-in'],
                ['icon' => '📱', 'title' => 'Responsive', 'description' => 'Works perfectly on all devices'],
                ['icon' => '🎨', 'title' => 'Customizable', 'description' => 'Tailor everything to your needs'],
                ['icon' => '🚀', 'title' => 'Scalable', 'description' => 'Grows with your business'],
                ['icon' => '💬', 'title' => 'Support', 'description' => '24/7 customer support'],
            ]) as $index => $feature)
            <div class="feature-item"
                 x-data="{ visible: false, hovered: false }"
                 x-intersect="visible = true"
                 @mouseenter="hovered = true"
                 @mouseleave="hovered = false">
                
                <div class="feature-card"
                     x-show="visible"
                     x-transition:enter="transition ease-out duration-700 delay-{{ $index * 100 }}">
                    
                    <div class="feature-icon" :class="{ 'scale-110 rotate-12': hovered }">
                        {{ $feature['icon'] }}
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ $feature['title'] }}
                    </h3>
                    
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ $feature['description'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.feature-card {
    padding: 2rem;
    background: var(--card-bg);
    border-radius: 1rem;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
}

.feature-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.feature-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, var(--primary-soft) 0%, var(--primary) 100%);
    border-radius: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    transition: all 0.3s ease;
}
</style>