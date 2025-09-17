{{-- Self-contained Services Section - Blitz Theme --}}
@props([
    'columns' => 3,
    'showIcons' => true,
    'variant' => 'cards', // cards, list, grid
])

<section class="services-section py-20 lg:py-32 bg-white dark:bg-gray-900"
         x-data="{ selectedService: null }">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-block px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-semibold mb-4">
                {{ get_theme_mod('services_label', 'Our Services') }}
            </span>
            <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                {{ get_theme_mod('services_title', 'What We Offer') }}
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                {{ get_theme_mod('services_description', 'We provide comprehensive solutions for your business needs') }}
            </p>
        </div>
        
        {{-- Services Grid --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-{{ $columns }} gap-8">
            @foreach(get_theme_mod('services_list', [
                [
                    'icon' => '🚀',
                    'title' => 'Web Development',
                    'description' => 'Custom websites and web applications built with modern technologies',
                    'features' => ['Responsive Design', 'SEO Optimized', 'Fast Loading']
                ],
                [
                    'icon' => '🎨',
                    'title' => 'UI/UX Design',
                    'description' => 'Beautiful and intuitive user interfaces that users love',
                    'features' => ['User Research', 'Wireframing', 'Prototyping']
                ],
                [
                    'icon' => '📱',
                    'title' => 'Mobile Apps',
                    'description' => 'Native and cross-platform mobile applications',
                    'features' => ['iOS Development', 'Android Development', 'React Native']
                ],
            ]) as $index => $service)
            <div class="service-card group"
                 x-data="{ visible: false }"
                 x-intersect="visible = true"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-700 delay-{{ $index * 100 }}"
                 @click="selectedService = {{ $index }}">
                
                @if($showIcons)
                <div class="service-icon">
                    {{ $service['icon'] }}
                </div>
                @endif
                
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                    {{ $service['title'] }}
                </h3>
                
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ $service['description'] }}
                </p>
                
                @if(isset($service['features']))
                <ul class="space-y-2">
                    @foreach($service['features'] as $feature)
                    <li class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4 text-primary flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $feature }}
                    </li>
                    @endforeach
                </ul>
                @endif
                
                <a href="{{ $service['url'] ?? '#' }}" class="service-link">
                    Learn More
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.service-card {
    padding: 2rem;
    background: var(--card-bg);
    border-radius: 1rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    cursor: pointer;
}

.service-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border-color: var(--primary);
}

.service-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-soft) 0%, var(--primary) 100%);
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.service-card:hover .service-icon {
    transform: scale(1.1) rotate(5deg);
}

.service-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 1rem;
    color: var(--primary);
    font-weight: 600;
    transition: all 0.3s ease;
}

.service-link:hover {
    gap: 0.75rem;
}
</style>