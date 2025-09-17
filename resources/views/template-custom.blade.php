{{-- resources/views/template-custom.blade.php --}}
{{--
  Template Name: Custom Sections Page
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    
    {{-- Get custom sections from post meta (WordPress native) --}}
    @php
      $custom_sections = get_post_meta(get_the_ID(), '_page_sections', true) ?: [];
      $show_bottom_cta = get_post_meta(get_the_ID(), '_show_bottom_cta', true);
      $bottom_cta = get_post_meta(get_the_ID(), '_bottom_cta_content', true) ?: [];
    @endphp
    
    {{-- Page Header --}}
    @include('sections.page-header.page-header', [
      'title' => get_the_title(),
      'subtitle' => has_excerpt() ? get_the_excerpt() : '',
      'featured_image' => has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'full') : null,
      'show_breadcrumbs' => true,
      'show_meta' => false
    ])

    {{-- Dynamic Sections or Default Content --}}
    @if(!empty($custom_sections))
      @foreach($custom_sections as $section)
        @includeIf('sections.' . $section['type'] . '.' . $section['type'], $section['data'] ?? [])
      @endforeach
    @else
      {{-- Fallback to standard content --}}
      @include('sections.page-content.page-content', [
        'content' => get_the_content(),
        'show_toc' => true,
        'enable_sharing' => false
      ])
    @endif

    {{-- Bottom CTA --}}
    @if($show_bottom_cta)
      @include('sections.cta.cta', array_merge([
        'title' => __('Ready to get started?', 'blitz'),
        'description' => __('Take the next step and contact us today.', 'blitz'),
        'primary_button_text' => __('Get Started', 'blitz'),
        'primary_button_url' => '/contact'
      ], $bottom_cta))
    @endif

    {{-- Related Pages --}}
    @include('sections.related-pages.related-pages', [
      'page_id' => get_the_ID(),
      'show_children' => true,
      'show_siblings' => true
    ])

  @endwhile
@endsection