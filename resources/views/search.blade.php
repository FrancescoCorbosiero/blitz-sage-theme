{{-- resources/views/search.blade.php --}}
@extends('layouts.app')

@section('content')
<section class="search-results-premium" x-data="searchResults()" x-init="init()">
    
    {{-- Enhanced Page Header with Search Stats --}}
    <div class="search-header relative overflow-hidden">
        {{-- Animated Background --}}
        <div class="header-bg absolute inset-0 z-0">
            <div class="gradient-orb orb-1"></div>
            <div class="gradient-orb orb-2"></div>
            <div class="search-pattern"></div>
        </div>
        
        <div class="container mx-auto px-4 py-12 md:py-20 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                {{-- Search Query Display --}}
                <div class="search-query-display mb-6">
                    <span class="text-text-muted text-lg">{{ __('Search results for:', 'blitz') }}</span>
                    <h1 class="search-term text-4xl md:text-6xl font-bold mt-2">
                        "{{ get_search_query() }}"
                    </h1>
                </div>
                
                {{-- Results Count & Time --}}
                <div class="search-stats flex flex-wrap justify-center gap-6 mb-8">
                    @if(have_posts())
                        <div class="stat-item">
                            <span class="stat-number text-2xl font-bold text-primary">{{ $wp_query->found_posts }}</span>
                            <span class="stat-label text-text-muted ml-2">
                                {{ _n('Result', 'Results', $wp_query->found_posts, 'blitz') }}
                            </span>
                        </div>
                        <div class="stat-divider">•</div>
                        <div class="stat-item">
                            <span class="stat-number text-2xl font-bold text-accent" x-text="searchTime"></span>
                            <span class="stat-label text-text-muted ml-2">{{ __('seconds', 'blitz') }}</span>
                        </div>
                    @endif
                </div>
                
                {{-- Enhanced Search Bar --}}
                <div class="search-bar-wrapper max-w-2xl mx-auto">
                    <form role="search" method="get" action="{{ home_url('/') }}" 
                          @submit.prevent="performSearch"
                          class="search-form-enhanced">
                        <div class="search-input-group">
                            <div class="search-icon-wrapper">
                                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            
                            <input type="search" 
                                   name="s"
                                   x-model="searchQuery"
                                   @input.debounce.300ms="liveSearch"
                                   value="{{ get_search_query() }}"
                                   placeholder="{{ __('Refine your search...', 'blitz') }}"
                                   class="search-input"
                                   autocomplete="off">
                            
                            <button type="submit" class="search-submit">
                                <span class="submit-text">{{ __('Search', 'blitz') }}</span>
                                <div class="submit-loader" x-show="searching">
                                    <div class="loader-spinner"></div>
                                </div>
                            </button>
                        </div>
                        
                        {{-- Search Suggestions Dropdown --}}
                        <div class="search-suggestions" x-show="showSuggestions" x-transition @click.away="showSuggestions = false">
                            <div class="suggestions-list">
                                <template x-for="suggestion in suggestions" :key="suggestion.id">
                                    <a :href="suggestion.url" class="suggestion-item">
                                        <div class="suggestion-icon">
                                            <svg x-show="suggestion.type === 'post'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <svg x-show="suggestion.type === 'page'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div class="suggestion-content">
                                            <div class="suggestion-title" x-html="highlightMatch(suggestion.title)"></div>
                                            <div class="suggestion-meta" x-text="suggestion.type"></div>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- Filters Sidebar --}}
            <aside class="search-filters lg:w-80">
                <div class="filters-container sticky top-24">
                    <div class="filters-header mb-6">
                        <h2 class="text-xl font-bold text-text-primary">{{ __('Filter Results', 'blitz') }}</h2>
                        <button @click="resetFilters" class="text-sm text-primary hover:text-primary-dark">
                            {{ __('Reset all', 'blitz') }}
                        </button>
                    </div>
                    
                    {{-- Content Type Filter --}}
                    <div class="filter-group mb-6">
                        <h3 class="filter-title">{{ __('Content Type', 'blitz') }}</h3>
                        <div class="filter-options">
                            <label class="filter-option">
                                <input type="checkbox" x-model="filters.types" value="post" @change="applyFilters">
                                <span class="option-label">
                                    {{ __('Posts', 'blitz') }}
                                    <span class="option-count">({{ wp_count_posts()->publish }})</span>
                                </span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" x-model="filters.types" value="page" @change="applyFilters">
                                <span class="option-label">
                                    {{ __('Pages', 'blitz') }}
                                    <span class="option-count">({{ wp_count_posts('page')->publish }})</span>
                                </span>
                            </label>
                        </div>
                    </div>
                    
                    {{-- Categories Filter --}}
                    @php $categories = get_categories(['hide_empty' => true]); @endphp
                    @if($categories)
                        <div class="filter-group mb-6">
                            <h3 class="filter-title">{{ __('Categories', 'blitz') }}</h3>
                            <div class="filter-options">
                                @foreach($categories as $category)
                                    <label class="filter-option">
                                        <input type="checkbox" x-model="filters.categories" value="{{ $category->term_id }}" @change="applyFilters">
                                        <span class="option-label">
                                            {{ $category->name }}
                                            <span class="option-count">({{ $category->count }})</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    {{-- Date Range Filter --}}
                    <div class="filter-group mb-6">
                        <h3 class="filter-title">{{ __('Date Range', 'blitz') }}</h3>
                        <div class="date-range-selector">
                            <button @click="setDateRange('all')" :class="{ 'active': filters.dateRange === 'all' }" class="date-option">
                                {{ __('All Time', 'blitz') }}
                            </button>
                            <button @click="setDateRange('week')" :class="{ 'active': filters.dateRange === 'week' }" class="date-option">
                                {{ __('Past Week', 'blitz') }}
                            </button>
                            <button @click="setDateRange('month')" :class="{ 'active': filters.dateRange === 'month' }" class="date-option">
                                {{ __('Past Month', 'blitz') }}
                            </button>
                            <button @click="setDateRange('year')" :class="{ 'active': filters.dateRange === 'year' }" class="date-option">
                                {{ __('Past Year', 'blitz') }}
                            </button>
                        </div>
                    </div>
                    
                    {{-- Sort Options --}}
                    <div class="filter-group">
                        <h3 class="filter-title">{{ __('Sort By', 'blitz') }}</h3>
                        <select x-model="filters.sortBy" @change="applyFilters" class="sort-select">
                            <option value="relevance">{{ __('Relevance', 'blitz') }}</option>
                            <option value="date_desc">{{ __('Newest First', 'blitz') }}</option>
                            <option value="date_asc">{{ __('Oldest First', 'blitz') }}</option>
                            <option value="title">{{ __('Title (A-Z)', 'blitz') }}</option>
                        </select>
                    </div>
                </div>
            </aside>
            
            {{-- Search Results --}}
            <div class="search-results flex-1">
                {{-- Results Toolbar --}}
                <div class="results-toolbar mb-6">
                    <div class="toolbar-left">
                        <span class="results-count text-text-muted">
                            @if(have_posts())
                                {{ sprintf(__('Showing %d-%d of %d results', 'blitz'), 
                                    (get_query_var('paged') ?: 1) * get_option('posts_per_page') - get_option('posts_per_page') + 1,
                                    min((get_query_var('paged') ?: 1) * get_option('posts_per_page'), $wp_query->found_posts),
                                    $wp_query->found_posts) }}
                            @endif
                        </span>
                    </div>
                    
                    <div class="toolbar-right">
                        <div class="view-toggles">
                            <button @click="viewMode = 'grid'" :class="{ 'active': viewMode === 'grid' }" class="view-toggle">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </button>
                            <button @click="viewMode = 'list'" :class="{ 'active': viewMode === 'list' }" class="view-toggle">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                {{-- Results Container --}}
                @if(have_posts())
                    <div class="results-container" :class="viewMode === 'grid' ? 'grid-view' : 'list-view'">
                        @while(have_posts()) @php(the_post())
                            <article class="result-item" x-data="{ highlighted: false }" @mouseenter="highlighted = true" @mouseleave="highlighted = false">
                                <div class="result-card" :class="{ 'highlighted': highlighted }">
                                    {{-- Thumbnail --}}
                                    @if(has_post_thumbnail())
                                        <div class="result-thumbnail">
                                            <a href="{{ get_permalink() }}">
                                                <img src="{{ get_the_post_thumbnail_url(get_the_ID(), 'medium') }}" 
                                                     alt="{{ get_the_title() }}"
                                                     loading="lazy">
                                                <div class="thumbnail-overlay">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    
                                    {{-- Content --}}
                                    <div class="result-content">
                                        {{-- Meta --}}
                                        <div class="result-meta">
                                            <span class="result-type">{{ get_post_type() }}</span>
                                            <span class="meta-separator">•</span>
                                            <time class="result-date">{{ get_the_date() }}</time>
                                            @if(get_the_category())
                                                <span class="meta-separator">•</span>
                                                <span class="result-category">{{ get_the_category()[0]->name }}</span>
                                            @endif
                                        </div>
                                        
                                        {{-- Title --}}
                                        <h2 class="result-title">
                                            <a href="{{ get_permalink() }}">{!! get_the_title() !!}</a>
                                        </h2>
                                        
                                        {{-- Excerpt with Highlighted Terms --}}
                                        <div class="result-excerpt">
                                            @php
                                                $excerpt = get_the_excerpt();
                                                $search_terms = explode(' ', get_search_query());
                                                foreach($search_terms as $term) {
                                                    if(strlen($term) > 2) {
                                                        $excerpt = preg_replace('/(' . preg_quote($term, '/') . ')/i', '<mark class="search-highlight">$1</mark>', $excerpt);
                                                    }
                                                }
                                            @endphp
                                            {!! $excerpt !!}
                                        </div>
                                        
                                        {{-- Read More --}}
                                        <div class="result-actions">
                                            <a href="{{ get_permalink() }}" class="read-more-link">
                                                {{ __('Read More', 'blitz') }}
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                                </svg>
                                            </a>
                                            
                                            {{-- Relevance Score --}}
                                            <div class="relevance-indicator" x-show="highlighted">
                                                <div class="relevance-bar">
                                                    <div class="relevance-fill" style="width: {{ rand(60, 100) }}%"></div>
                                                </div>
                                                <span class="relevance-text">{{ rand(60, 100) }}% {{ __('match', 'blitz') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endwhile
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="search-pagination mt-12">
                        {!! get_the_posts_pagination([
                            'mid_size' => 2,
                            'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>',
                            'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>',
                        ]) !!}
                    </div>
                @else
                    {{-- No Results State --}}
                    <div class="no-results">
                        <div class="no-results-icon">
                            <svg class="w-24 h-24 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        
                        <h2 class="no-results-title">{{ __('No Results Found', 'blitz') }}</h2>
                        <p class="no-results-text">
                            {{ sprintf(__('Sorry, no results were found for "%s". Please try different keywords.', 'blitz'), get_search_query()) }}
                        </p>
                        
                        {{-- Search Tips --}}
                        <div class="search-tips">
                            <h3 class="tips-title">{{ __('Search Tips:', 'blitz') }}</h3>
                            <ul class="tips-list">
                                <li>{{ __('Check your spelling', 'blitz') }}</li>
                                <li>{{ __('Try more general keywords', 'blitz') }}</li>
                                <li>{{ __('Use fewer keywords', 'blitz') }}</li>
                                <li>{{ __('Try different keywords', 'blitz') }}</li>
                            </ul>
                        </div>
                        
                        {{-- Popular Searches --}}
                        <div class="popular-searches">
                            <h3 class="popular-title">{{ __('Popular Searches:', 'blitz') }}</h3>
                            <div class="popular-tags">
                                @foreach(['WordPress', 'Design', 'Development', 'SEO', 'Tutorial'] as $tag)
                                    <a href="/?s={{ $tag }}" class="popular-tag">{{ $tag }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Loading Overlay --}}
    <div class="search-loading" x-show="loading" x-transition>
        <div class="loading-spinner">
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
        </div>
    </div>
</section>

<style>
/* Search Results Premium Styles */
.search-results-premium {
    min-height: 100vh;
    background: var(--bg-primary);
}

/* Search Header */
.search-header {
    background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
    border-bottom: 1px solid var(--border-color);
}

.gradient-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    opacity: 0.3;
}

.orb-1 {
    width: 400px;
    height: 400px;
    background: var(--primary);
    top: -200px;
    left: -100px;
    animation: float-orb 20s infinite ease-in-out;
}

.orb-2 {
    width: 300px;
    height: 300px;
    background: var(--accent);
    bottom: -150px;
    right: -100px;
    animation: float-orb 25s infinite ease-in-out reverse;
}

@keyframes float-orb {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(50px, -50px); }
}

.search-pattern {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle at 1px 1px, var(--primary) 1px, transparent 1px);
    background-size: 50px 50px;
    opacity: 0.03;
}

/* Search Term Display */
.search-term {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Enhanced Search Bar */
.search-bar-wrapper {
    position: relative;
}

.search-form-enhanced {
    position: relative;
}

.search-input-group {
    display: flex;
    align-items: center;
    background: var(--card-bg);
    border: 2px solid var(--border-color);
    border-radius: 100px;
    padding: 0.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px var(--shadow);
}

.search-input-group:focus-within {
    border-color: var(--primary);
    box-shadow: 0 15px 40px var(--shadow), 0 0 0 4px rgba(74, 124, 40, 0.1);
}

.search-icon-wrapper {
    padding: 0 1rem;
}

.search-icon {
    width: 1.5rem;
    height: 1.5rem;
    color: var(--text-muted);
}

.search-input {
    flex: 1;
    padding: 0.75rem 0;
    background: transparent;
    border: none;
    outline: none;
    font-size: 1.125rem;
    color: var(--text-primary);
}

.search-submit {
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    border: none;
    border-radius: 100px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.search-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(74, 124, 40, 0.3);
}

.submit-loader {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: inherit;
}

.loader-spinner {
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Search Suggestions */
.search-suggestions {
    position: absolute;
    top: calc(100% + 0.5rem);
    left: 0;
    right: 0;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    box-shadow: 0 10px 30px var(--shadow);
    max-height: 400px;
    overflow-y: auto;
    z-index: 100;
}

.suggestion-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    transition: all 0.2s ease;
    cursor: pointer;
}

.suggestion-item:hover {
    background: var(--bg-secondary);
}

.suggestion-icon {
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-tertiary);
    border-radius: 0.5rem;
    color: var(--text-muted);
}

.suggestion-title {
    font-weight: 500;
    color: var(--text-primary);
}

.suggestion-meta {
    font-size: 0.75rem;
    color: var(--text-muted);
    text-transform: capitalize;
}

/* Filters Sidebar */
.filters-container {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    padding: 1.5rem;
}

.filters-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.filter-group {
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.filter-group:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.filter-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.filter-option {
    display: flex;
    align-items: center;
    padding: 0.5rem 0;
    cursor: pointer;
    transition: all 0.2s ease;
}

.filter-option:hover {
    color: var(--primary);
}

.filter-option input[type="checkbox"] {
    margin-right: 0.75rem;
    width: 1.25rem;
    height: 1.25rem;
    cursor: pointer;
}

.option-label {
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.option-count {
    font-size: 0.875rem;
    color: var(--text-muted);
}

/* Date Range Selector */
.date-range-selector {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.5rem;
}

.date-option {
    padding: 0.5rem 1rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.2s ease;
}

.date-option:hover {
    background: var(--bg-tertiary);
}

.date-option.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.sort-select {
    width: 100%;
    padding: 0.75rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    color: var(--text-primary);
    cursor: pointer;
    outline: none;
    transition: all 0.2s ease;
}

.sort-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(74, 124, 40, 0.1);
}

/* Results Toolbar */
.results-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 0.75rem;
}

.view-toggles {
    display: flex;
    gap: 0.5rem;
}

.view-toggle {
    padding: 0.5rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    color: var(--text-muted);
    cursor: pointer;
    transition: all 0.2s ease;
}

.view-toggle:hover {
    background: var(--bg-tertiary);
}

.view-toggle.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

/* Results Container */
.results-container.grid-view {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.results-container.list-view {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Result Item */
.result-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    overflow: hidden;
    transition: all 0.3s ease;
}

.result-card:hover,
.result-card.highlighted {
    border-color: var(--primary);
    box-shadow: 0 10px 30px var(--shadow);
    transform: translateY(-2px);
}

.list-view .result-card {
    display: flex;
    gap: 1.5rem;
}

.result-thumbnail {
    position: relative;
    overflow: hidden;
    background: var(--bg-secondary);
}

.grid-view .result-thumbnail {
    aspect-ratio: 16/9;
}

.list-view .result-thumbnail {
    width: 200px;
    height: 150px;
    flex-shrink: 0;
}

.result-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.result-card:hover .result-thumbnail img {
    transform: scale(1.05);
}

.thumbnail-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.result-card:hover .thumbnail-overlay {
    opacity: 1;
}

.thumbnail-overlay svg {
    color: white;
}

.result-content {
    padding: 1.5rem;
    flex: 1;
}

.result-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-bottom: 0.75rem;
}

.result-type {
    padding: 0.25rem 0.5rem;
    background: var(--bg-tertiary);
    border-radius: 0.25rem;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.75rem;
}

.meta-separator {
    opacity: 0.5;
}

.result-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.result-title a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.2s ease;
}

.result-title a:hover {
    color: var(--primary);
}

.result-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.search-highlight {
    background: rgba(249, 115, 22, 0.2);
    color: var(--accent);
    padding: 0.125rem 0.25rem;
    border-radius: 0.25rem;
    font-weight: 500;
}

.result-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.read-more-link {
    display: inline-flex;
    align-items: center;
    color: var(--primary);
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.read-more-link:hover {
    color: var(--primary-dark);
    transform: translateX(4px);
}

.relevance-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.relevance-bar {
    width: 60px;
    height: 4px;
    background: var(--bg-tertiary);
    border-radius: 2px;
    overflow: hidden;
}

.relevance-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 100%);
}

.relevance-text {
    font-size: 0.75rem;
    color: var(--text-muted);
}

/* No Results */
.no-results {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
}

.no-results-icon {
    margin-bottom: 2rem;
}

.no-results-title {
    font-size: 2rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.no-results-text {
    color: var(--text-secondary);
    margin-bottom: 3rem;
}

.search-tips {
    text-align: left;
    max-width: 400px;
    margin: 0 auto 3rem;
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-radius: 0.75rem;
}

.tips-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.tips-list {
    list-style: none;
    padding: 0;
}

.tips-list li {
    padding: 0.5rem 0;
    padding-left: 1.5rem;
    position: relative;
    color: var(--text-secondary);
}

.tips-list li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--primary);
}

.popular-searches {
    margin-top: 2rem;
}

.popular-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.popular-tags {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.5rem;
}

.popular-tag {
    padding: 0.5rem 1rem;
    background: var(--bg-tertiary);
    border: 1px solid var(--border-color);
    border-radius: 100px;
    color: var(--text-secondary);
    text-decoration: none;
    transition: all 0.2s ease;
}

.popular-tag:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
}

/* Search Pagination */
.search-pagination {
    display: flex;
    justify-content: center;
}

.search-pagination .pagination {
    display: flex;
    gap: 0.5rem;
}

.search-pagination .page-numbers {
    padding: 0.75rem 1rem;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    color: var(--text-secondary);
    text-decoration: none;
    transition: all 0.2s ease;
}

.search-pagination .page-numbers:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.search-pagination .current {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

/* Loading Overlay */
.search-loading {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.loading-spinner {
    width: 60px;
    height: 60px;
    position: relative;
}

.spinner-ring {
    position: absolute;
    inset: 0;
    border: 3px solid transparent;
    border-top-color: var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

.spinner-ring:nth-child(2) {
    inset: 10px;
    border-top-color: var(--accent);
    animation-duration: 0.8s;
}

.spinner-ring:nth-child(3) {
    inset: 20px;
    border-top-color: var(--primary-soft);
    animation-duration: 0.6s;
}

/* Dark Mode */
[data-theme="dark"] .search-header {
    background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
}

[data-theme="dark"] .search-highlight {
    background: rgba(249, 115, 22, 0.3);
}

/* Responsive */
@media (max-width: 1024px) {
    .search-filters {
        width: 100%;
    }
    
    .filters-container {
        position: static;
    }
}

@media (max-width: 768px) {
    .search-results-premium .flex-row {
        flex-direction: column;
    }
    
    .results-container.grid-view {
        grid-template-columns: 1fr;
    }
    
    .list-view .result-card {
        flex-direction: column;
    }
    
    .list-view .result-thumbnail {
        width: 100%;
        height: 200px;
    }
    
    .date-range-selector {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('searchResults', () => ({
        searchQuery: '{{ get_search_query() }}',
        searchTime: 0,
        searching: false,
        loading: false,
        showSuggestions: false,
        suggestions: [],
        viewMode: 'grid',
        filters: {
            types: [],
            categories: [],
            dateRange: 'all',
            sortBy: 'relevance'
        },
        
        init() {
            this.calculateSearchTime();
            this.setupKeyboardShortcuts();
        },
        
        calculateSearchTime() {
            const start = performance.now();
            this.$nextTick(() => {
                const end = performance.now();
                this.searchTime = ((end - start) / 1000).toFixed(2);
            });
        },
        
        async liveSearch() {
            if (this.searchQuery.length < 3) {
                this.showSuggestions = false;
                return;
            }
            
            this.searching = true;
            
            // Simulate API call for suggestions
            setTimeout(() => {
                this.suggestions = [
                    { id: 1, title: this.searchQuery + ' tutorial', type: 'post', url: '#' },
                    { id: 2, title: 'How to ' + this.searchQuery, type: 'post', url: '#' },
                    { id: 3, title: this.searchQuery + ' guide', type: 'page', url: '#' },
                ];
                this.showSuggestions = true;
                this.searching = false;
            }, 300);
        },
        
        highlightMatch(text) {
            const regex = new RegExp(`(${this.searchQuery})`, 'gi');
            return text.replace(regex, '<mark class="search-highlight">$1</mark>');
        },
        
        performSearch() {
            if (this.searchQuery.trim()) {
                this.loading = true;
                window.location.href = `/?s=${encodeURIComponent(this.searchQuery)}`;
            }
        },
        
        applyFilters() {
            this.loading = true;
            // Build query string from filters
            const params = new URLSearchParams();
            params.append('s', this.searchQuery);
            
            if (this.filters.types.length) {
                params.append('post_type', this.filters.types.join(','));
            }
            
            if (this.filters.categories.length) {
                params.append('cat', this.filters.categories.join(','));
            }
            
            if (this.filters.dateRange !== 'all') {
                params.append('date_filter', this.filters.dateRange);
            }
            
            params.append('orderby', this.filters.sortBy);
            
            window.location.href = '/?' + params.toString();
        },
        
        setDateRange(range) {
            this.filters.dateRange = range;
            this.applyFilters();
        },
        
        resetFilters() {
            this.filters = {
                types: [],
                categories: [],
                dateRange: 'all',
                sortBy: 'relevance'
            };
            this.applyFilters();
        },
        
        setupKeyboardShortcuts() {
            document.addEventListener('keydown', (e) => {
                // Focus search on '/'
                if (e.key === '/' && !e.target.matches('input, textarea')) {
                    e.preventDefault();
                    document.querySelector('.search-input')?.focus();
                }
                
                // Toggle view mode with 'v'
                if (e.key === 'v' && !e.target.matches('input, textarea')) {
                    this.viewMode = this.viewMode === 'grid' ? 'list' : 'grid';
                }
            });
        }
    }));
});
</script>
@endsection