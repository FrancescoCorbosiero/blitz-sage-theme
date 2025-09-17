{{-- resources/views/components/picture.blade.php --}}
@props([
    'src',
    'alt',
    'sizes' => '100vw',
    'loading' => 'lazy',
    'class' => '',
    'responsive' => true,
    'isBackground' => false,
])

@php
    // Get the original asset URL through Vite
    $originalUrl = Vite::asset("resources/images/{$src}");
    
    // For responsive images, create srcset
    $imageSizes = $responsive ? [
        'small' => str_replace('.jpg', '-640w.jpg', $src),
        'medium' => str_replace('.jpg', '-1024w.jpg', $src),
        'large' => str_replace('.jpg', '-1920w.jpg', $src),
    ] : [];
@endphp

@if($isBackground)
    {{-- For background images (like hero) --}}
    <div {{ $attributes->merge(['class' => $class]) }}
         style="background-image: url('{{ $originalUrl }}');">
        {{ $slot }}
    </div>
@else
    {{-- Standard picture element --}}
    <picture>
        {{-- Only include source elements if files actually exist --}}
        @if(file_exists(public_path('build/assets/' . str_replace('.jpg', '.avif', basename($src)))))
            <source 
                type="image/avif"
                srcset="{{ Vite::asset('resources/images/' . str_replace('.jpg', '.avif', $src)) }}">
        @endif
        
        @if(file_exists(public_path('build/assets/' . str_replace('.jpg', '.webp', basename($src)))))
            <source 
                type="image/webp"
                srcset="{{ Vite::asset('resources/images/' . str_replace('.jpg', '.webp', $src)) }}">
        @endif
        
        <img 
            src="{{ $originalUrl }}"
            alt="{{ $alt }}"
            class="{{ $class }}"
            loading="{{ $loading }}"
            @if($responsive && !empty($imageSizes))
                srcset="
                    {{ Vite::asset('resources/images/' . $imageSizes['small']) }} 640w,
                    {{ Vite::asset('resources/images/' . $imageSizes['medium']) }} 1024w,
                    {{ Vite::asset('resources/images/' . $imageSizes['large']) }} 1920w
                "
                sizes="{{ $sizes }}"
            @endif
            decoding="async">
    </picture>
@endif