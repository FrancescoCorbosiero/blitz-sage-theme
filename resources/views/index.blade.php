@extends('layouts.app')

@section('content')

    {{-- Hero Section --}}
    {{-- Blog Section --}}
    @include('sections.hero.parallax')

    @include('sections.about.timeline')

    @include('sections.contact.cards')
    @include('sections.contact.bento-grid')
    @include('sections.contact.alpacode')

    @include('sections.pricing.pricing')

@endsection

<style>
  .blog-header {
    background-image: 
      radial-gradient(circle at 30% 20%, rgba(74, 124, 40, 0.1) 0%, transparent 50%),
      radial-gradient(circle at 70% 80%, rgba(249, 115, 22, 0.1) 0%, transparent 50%);
  }

  .post-card {
    transform: translateY(20px);
    opacity: 0;
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .post-card[data-visible="true"] {
    transform: translateY(0);
    opacity: 1;
  }

  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* Pagination Styling */
  .pagination {
    @apply flex flex-wrap justify-center items-center gap-2 mt-8;
  }

  .pagination .page-numbers {
    @apply px-4 py-2 bg-bg-secondary text-text-secondary rounded-lg transition-all duration-200 hover:bg-primary hover:text-white;
  }

  .pagination .current {
    @apply bg-primary text-white;
  }

  .pagination .prev,
  .pagination .next {
    @apply flex items-center gap-2 px-6 py-3 bg-transparent border-2 border-primary text-primary rounded-lg transition-all duration-200 hover:bg-primary hover:text-white;
  }
</style>

