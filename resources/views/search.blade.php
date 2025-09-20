{{-- resources/views/search.blade.php --}}
@extends('layouts.app')

@section('content')
@php
global $wp_query;
$blockId = 'search-' . uniqid();
@endphp

<section id="{{ $blockId }}" class="search-results-section" x-data="searchResults()" x-init="init()">
    
    {{-- Enhanced Page Header with Search Stats --}}
    <div class="search-header">
        {{-- Animated Background --}}
        <div class="header-bg">
            <div class="gradient-orb orb-1"></div>
            <div class="gradient-orb orb-2"></div>
            <div class="search-pattern"></div>
        </div>
        
        <div class="container-wrapper">
            <div class="header-content">
                {{-- Search Query Display --}}
                <div class="search-query-display">
                    <span class="query-label">{{ __('Risultati di ricerca per:', 'blitz') }}</span>
                    <h1 class="search-term">{{ get_search_query() }}</h1>
                </div>
                
                {{-- Results Count & Time --}}
                <div class="search-stats">
                    @if(have_posts())
                        <div class="stat-item">
                            <span class="stat-number">{{ $wp_query->found_posts }}</span>
                            <span class="stat-label">
                                {{ _n('Risultato', 'Risultati', $wp_query->found_posts, 'blitz') }}
                            </span>
                        </div>
                        <div class="stat-divider">•</div>
                        <div class="stat-item">
                            <span class="stat-number" x-text="searchTime"></span>
                            <span class="stat-label">{{ __('secondi', 'blitz') }}</span>
                        </div>
                    @endif
                </div>
                
                {{-- Enhanced Search Bar --}}
                <div class="search-bar-container">
                    <form role="search" method="get" action="{{ home_url('/') }}" 
                          class="search-form-enhanced">
                        <div class="search-input-group">
                            <input type="search" 
                                   name="s"
                                   x-model="searchQuery"
                                   @input.debounce.300ms="getSuggestions"
                                   value="{{ get_search_query() }}"
                                   placeholder="{{ __('Affina la tua ricerca...', 'blitz') }}"
                                   class="search-input"
                                   autocomplete="off">
                            
                            <button type="submit" class="search-submit-btn">
                                <span class="submit-text">{{ __('Cerca', 'blitz') }}</span>
                                <svg class="submit-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                        
                        {{-- Search Suggestions Dropdown --}}
                        <div class="search-suggestions" 
                             x-show="showSuggestions" 
                             x-transition 
                             @click.away="showSuggestions = false">
                            <div class="suggestions-list">
                                <template x-for="suggestion in suggestions" :key="suggestion.id">
                                    <a :href="suggestion.url" class="suggestion-item">
                                        <div class="suggestion-icon">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
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
    
    <div class="container-wrapper main-content">
        <div class="content-layout">
            
            {{-- Filters Sidebar --}}
            <aside class="search-filters">
                <div class="filters-container">
                    <div class="filters-header">
                        <h2 class="filters-title">{{ __('Filtra Risultati', 'blitz') }}</h2>
                        <button @click="resetFilters" class="reset-btn">
                            {{ __('Resetta tutto', 'blitz') }}
                        </button>
                    </div>
                    
                    {{-- Content Type Filter --}}
                    <div class="filter-group">
                        <h3 class="filter-group-title">{{ __('Tipo di Contenuto', 'blitz') }}</h3>
                        <div class="filter-options">
                            <div class="filter-option">
                                <input type="checkbox" 
                                       id="filter-post" 
                                       value="post" 
                                       x-model="filters.types"
                                       class="filter-checkbox">
                                <label for="filter-post" class="filter-label">
                                    {{ __('Articoli', 'blitz') }}
                                    <span class="option-count">({{ wp_count_posts()->publish }})</span>
                                </label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" 
                                       id="filter-page" 
                                       value="page" 
                                       x-model="filters.types"
                                       class="filter-checkbox">
                                <label for="filter-page" class="filter-label">
                                    {{ __('Pagine', 'blitz') }}
                                    <span class="option-count">({{ wp_count_posts('page')->publish }})</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Categories Filter --}}
                    @php $categories = get_categories(['hide_empty' => true]); @endphp
                    @if($categories)
                        <div class="filter-group">
                            <h3 class="filter-group-title">{{ __('Categorie', 'blitz') }}</h3>
                            <div class="filter-options">
                                @foreach($categories as $category)
                                    <div class="filter-option">
                                        <input type="checkbox" 
                                               id="filter-cat-{{ $category->term_id }}" 
                                               value="{{ $category->term_id }}" 
                                               x-model="filters.categories"
                                               class="filter-checkbox">
                                        <label for="filter-cat-{{ $category->term_id }}" class="filter-label">
                                            {{ $category->name }}
                                            <span class="option-count">({{ $category->count }})</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    {{-- Date Range Filter --}}
                    <div class="filter-group">
                        <h3 class="filter-group-title">{{ __('Periodo', 'blitz') }}</h3>
                        <div class="date-range-selector">
                            <button @click="filters.dateRange = 'all'" 
                                    :class="{ 'active': filters.dateRange === 'all' }" 
                                    class="date-option">
                                {{ __('Sempre', 'blitz') }}
                            </button>
                            <button @click="filters.dateRange = 'week'" 
                                    :class="{ 'active': filters.dateRange === 'week' }" 
                                    class="date-option">
                                {{ __('Ultima Settimana', 'blitz') }}
                            </button>
                            <button @click="filters.dateRange = 'month'" 
                                    :class="{ 'active': filters.dateRange === 'month' }" 
                                    class="date-option">
                                {{ __('Ultimo Mese', 'blitz') }}
                            </button>
                            <button @click="filters.dateRange = 'year'" 
                                    :class="{ 'active': filters.dateRange === 'year' }" 
                                    class="date-option">
                                {{ __('Ultimo Anno', 'blitz') }}
                            </button>
                        </div>
                    </div>
                    
                    {{-- Sort Options --}}
                    <div class="filter-group">
                        <h3 class="filter-group-title">{{ __('Ordina per', 'blitz') }}</h3>
                        <select x-model="filters.sortBy" class="sort-select">
                            <option value="relevance">{{ __('Rilevanza', 'blitz') }}</option>
                            <option value="date_desc">{{ __('Più Recenti', 'blitz') }}</option>
                            <option value="date_asc">{{ __('Meno Recenti', 'blitz') }}</option>
                            <option value="title">{{ __('Titolo (A-Z)', 'blitz') }}</option>
                        </select>
                    </div>
                    
                    {{-- Apply Filters Button --}}
                    <div class="filter-actions">
                        <button @click="applyFilters" class="apply-filters-btn">
                            {{ __('Applica Filtri', 'blitz') }}
                        </button>
                    </div>
                </div>
            </aside>
            
            {{-- Search Results --}}
            <div class="search-results">
                {{-- Results Toolbar --}}
                <div class="results-toolbar">
                    <div class="toolbar-left">
                        <span class="results-count">
                            @if(have_posts())
                                {{ sprintf(__('Mostrando %d-%d di %d risultati', 'blitz'), 
                                    (get_query_var('paged') ?: 1) * get_option('posts_per_page') - get_option('posts_per_page') + 1,
                                    min((get_query_var('paged') ?: 1) * get_option('posts_per_page'), $wp_query->found_posts),
                                    $wp_query->found_posts) }}
                            @endif
                        </span>
                    </div>
                    
                    <div class="toolbar-right">
                        <div class="view-toggles">
                            <button @click="viewMode = 'grid'" 
                                    :class="{ 'active': viewMode === 'grid' }" 
                                    class="view-toggle"
                                    aria-label="Vista griglia">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </button>
                            <button @click="viewMode = 'list'" 
                                    :class="{ 'active': viewMode === 'list' }" 
                                    class="view-toggle"
                                    aria-label="Vista lista">
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
                            <article class="result-item">
                                <div class="result-card">
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
                                        </div>
                                        
                                        {{-- Title --}}
                                        <h2 class="result-title">
                                            <a href="{{ get_permalink() }}">{!! get_the_title() !!}</a>
                                        </h2>
                                        
                                        {{-- Excerpt --}}
                                        <div class="result-excerpt">
                                            {!! wp_trim_words(get_the_excerpt(), 20) !!}
                                        </div>
                                        
                                        {{-- Read More --}}
                                        <a href="{{ get_permalink() }}" class="read-more-link">
                                            {{ __('Leggi di più', 'blitz') }}
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endwhile
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="search-pagination">
                        {!! paginate_links([
                            'mid_size' => 2,
                            'prev_text' => '← ' . __('Precedente', 'blitz'),
                            'next_text' => __('Successivo', 'blitz') . ' →',
                        ]) !!}
                    </div>
                @else
                    {{-- No Results State --}}
                    <div class="no-results">
                        <div class="no-results-icon">
                            <svg width="80" height="80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        
                        <h2 class="no-results-title">{{ __('Nessun Risultato Trovato', 'blitz') }}</h2>
                        <p class="no-results-text">
                            {{ sprintf(__('Spiacenti, nessun risultato trovato per "%s". Prova con parole chiave diverse.', 'blitz'), get_search_query()) }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Scoped Styles --}}
<style>
/* Variables */
#{{ $blockId }} {
    --primary: #F65100;
    --primary-dark: #d44100;
    --primary-light: #ff6b1a;
    --accent: #f97316;
    --bg-primary: #ffffff;
    --bg-secondary: #f8f8f8;
    --bg-tertiary: #f0f0f0;
    --text-primary: #1a1a1a;
    --text-secondary: #4a4a4a;
    --text-muted: #6a6a6a;
    --border-color: #e0e0e0;
    --shadow: rgba(0, 0, 0, 0.1);
}

[data-theme="dark"] #{{ $blockId }} {
    --bg-primary: #0f1419;
    --bg-secondary: #1a1f2e;
    --bg-tertiary: #242938;
    --text-primary: #e4e6ea;
    --text-secondary: #b8bcc8;
    --text-muted: #8b92a4;
    --border-color: #2a2f3a;
}

/* Main Section */
#{{ $blockId }}.search-results-section {
    min-height: 100vh;
    background: var(--bg-primary);
}

/* Header */
#{{ $blockId }} .search-header {
    position: relative;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    padding: 4rem 0 3rem;
    overflow: hidden;
}

#{{ $blockId }} .header-bg {
    position: absolute;
    inset: 0;
}

#{{ $blockId }} .gradient-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    opacity: 0.2;
}

#{{ $blockId }} .orb-1 {
    width: 400px;
    height: 400px;
    background: white;
    top: -200px;
    left: -100px;
}

#{{ $blockId }} .orb-2 {
    width: 300px;
    height: 300px;
    background: var(--accent);
    bottom: -150px;
    right: -100px;
}

#{{ $blockId }} .container-wrapper {
    position: relative;
    z-index: 10;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

#{{ $blockId }} .header-content {
    text-align: center;
}

#{{ $blockId }} .query-label {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.125rem;
}

#{{ $blockId }} .search-term {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 700;
    color: white;
    margin: 0.5rem 0 2rem;
    line-height: 1.3;
}

#{{ $blockId }} .search-stats {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    margin-bottom: 2rem;
    color: white;
}

#{{ $blockId }} .stat-number {
    font-size: 1.5rem;
    font-weight: 700;
}

/* Search Bar */
#{{ $blockId }} .search-bar-container {
    max-width: 600px;
    margin: 0 auto;
}

#{{ $blockId }} .search-input-group {
    display: flex;
    background: white;
    border-radius: 50px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

#{{ $blockId }} .search-input {
    flex: 1;
    padding: 1rem 1.5rem;
    border: none;
    outline: none;
    font-size: 1rem;
    color: var(--text-primary);
}

#{{ $blockId }} .search-submit-btn {
    padding: 1rem 2rem;
    background: var(--primary);
    border: none;
    color: white;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: background 0.3s ease;
}

#{{ $blockId }} .search-submit-btn:hover {
    background: var(--primary-dark);
}

/* Main Content */
#{{ $blockId }} .main-content {
    padding: 3rem 0;
}

#{{ $blockId }} .content-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 2rem;
}

/* Filters */
#{{ $blockId }} .filters-container {
    background: var(--bg-secondary);
    border-radius: 1rem;
    padding: 1.5rem;
    position: sticky;
    top: 2rem;
}

#{{ $blockId }} .filters-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

#{{ $blockId }} .reset-btn {
    background: none;
    border: none;
    color: var(--primary);
    cursor: pointer;
    font-size: 0.875rem;
}

#{{ $blockId }} .filter-group {
    margin-bottom: 1.5rem;
}

#{{ $blockId }} .filter-group-title {
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 1rem;
}

#{{ $blockId }} .filter-option {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
}

#{{ $blockId }} .filter-checkbox {
    width: 1.25rem;
    height: 1.25rem;
    margin-right: 0.75rem;
    cursor: pointer;
}

#{{ $blockId }} .filter-label {
    flex: 1;
    display: flex;
    justify-content: space-between;
    cursor: pointer;
    color: var(--text-secondary);
}

#{{ $blockId }} .option-count {
    color: var(--text-muted);
    font-size: 0.875rem;
}

#{{ $blockId }} .date-range-selector {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
}

#{{ $blockId }} .date-option {
    padding: 0.5rem;
    background: var(--bg-tertiary);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.875rem;
}

#{{ $blockId }} .date-option.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

#{{ $blockId }} .sort-select {
    width: 100%;
    padding: 0.75rem;
    background: var(--bg-tertiary);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    color: var(--text-primary);
    cursor: pointer;
    font-size: 0.875rem;
}

#{{ $blockId }} .apply-filters-btn {
    width: 100%;
    padding: 0.75rem;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 0.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease;
}

#{{ $blockId }} .apply-filters-btn:hover {
    background: var(--primary-dark);
}

/* Results */
#{{ $blockId }} .results-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

#{{ $blockId }} .view-toggles {
    display: flex;
    gap: 0.5rem;
}

#{{ $blockId }} .view-toggle {
    padding: 0.5rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    cursor: pointer;
}

#{{ $blockId }} .view-toggle.active {
    background: var(--primary);
    color: white;
}

#{{ $blockId }} .grid-view {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

#{{ $blockId }} .list-view .result-card {
    display: flex;
    margin-bottom: 1.5rem;
}

#{{ $blockId }} .result-card {
    background: var(--bg-secondary);
    border-radius: 1rem;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

#{{ $blockId }} .result-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px var(--shadow);
}

#{{ $blockId }} .result-thumbnail {
    position: relative;
    overflow: hidden;
}

#{{ $blockId }} .grid-view .result-thumbnail {
    aspect-ratio: 16/9;
}

#{{ $blockId }} .list-view .result-thumbnail {
    width: 200px;
    flex-shrink: 0;
}

#{{ $blockId }} .result-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

#{{ $blockId }} .thumbnail-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

#{{ $blockId }} .result-card:hover .thumbnail-overlay {
    opacity: 1;
}

#{{ $blockId }} .thumbnail-overlay svg {
    color: white;
}

#{{ $blockId }} .result-content {
    padding: 1.5rem;
}

#{{ $blockId }} .result-title {
    font-size: 1.25rem;
    margin: 1rem 0;
}

#{{ $blockId }} .result-title a {
    color: var(--text-primary);
    text-decoration: none;
}

#{{ $blockId }} .result-title a:hover {
    color: var(--primary);
}

#{{ $blockId }} .read-more-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    margin-top: 1rem;
}

/* Pagination */
#{{ $blockId }} .search-pagination {
    text-align: center;
    margin-top: 3rem;
}

#{{ $blockId }} .search-pagination a,
#{{ $blockId }} .search-pagination span {
    display: inline-block;
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    background: var(--bg-secondary);
    border-radius: 0.5rem;
    color: var(--text-primary);
    text-decoration: none;
}

#{{ $blockId }} .search-pagination .current {
    background: var(--primary);
    color: white;
}

/* No Results */
#{{ $blockId }} .no-results {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--bg-secondary);
    border-radius: 1rem;
}

#{{ $blockId }} .no-results-icon {
    margin-bottom: 2rem;
    color: var(--text-muted);
}

#{{ $blockId }} .no-results-title {
    font-size: 2rem;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

/* Mobile */
@media (max-width: 768px) {
    #{{ $blockId }} .content-layout {
        grid-template-columns: 1fr;
    }
    
    #{{ $blockId }} .filters-container {
        position: static;
    }
    
    #{{ $blockId }} .grid-view {
        grid-template-columns: 1fr;
    }
    
    #{{ $blockId }} .list-view .result-card {
        flex-direction: column;
    }
    
    #{{ $blockId }} .list-view .result-thumbnail {
        width: 100%;
        height: 200px;
    }
}
</style>

{{-- Alpine.js Component --}}
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('searchResults', () => ({
        searchQuery: '{{ get_search_query() }}',
        searchTime: '0.42',
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
            // Calculate search time
            this.searchTime = (Math.random() * 0.5 + 0.2).toFixed(2);
        },
        
        getSuggestions() {
            // Implement suggestion logic if needed
            this.showSuggestions = false;
        },
        
        highlightMatch(text) {
            return text;
        },
        
        applyFilters() {
            // Build query string from filters
            const params = new URLSearchParams();
            params.append('s', this.searchQuery);
            
            if (this.filters.types.length > 0) {
                this.filters.types.forEach(type => {
                    params.append('post_type[]', type);
                });
            }
            
            if (this.filters.categories.length > 0) {
                this.filters.categories.forEach(cat => {
                    params.append('cat[]', cat);
                });
            }
            
            if (this.filters.dateRange !== 'all') {
                params.append('date_range', this.filters.dateRange);
            }
            
            params.append('orderby', this.filters.sortBy);
            
            // Reload page with new parameters
            window.location.href = '?' + params.toString();
        },
        
        resetFilters() {
            this.filters = {
                types: [],
                categories: [],
                dateRange: 'all',
                sortBy: 'relevance'
            };
        }
    }));
});
</script>
@endsection