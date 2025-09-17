{{-- resources/views/page.blade.php --}}
@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    
    {{-- Page Header --}}
    @include('partials.page-header', [
      'title' => get_the_title(),
      'subtitle' => has_excerpt() ? get_the_excerpt() : '',
      'featured_image' => has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'full') : null,
      'show_breadcrumbs' => true,
      'show_meta' => true
    ])

    {{-- Page Content --}}
    @include('partials.content-page')

    {{-- Related Pages --}}
    @include('partials.related-pages')

    {{-- Comments (if enabled) --}}
    @if(comments_open())
      <section class="page-comments py-16 bg-bg-secondary">
        <div class="container mx-auto px-4">
          <div class="max-w-4xl mx-auto">
            @include('partials.comments')
          </div>
        </div>
      </section>
    @endif

  @endwhile
@endsection