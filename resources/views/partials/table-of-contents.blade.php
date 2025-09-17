{{-- resources/views/partials/table-of-contents.blade.php --}}
<aside class="toc-sidebar hidden lg:block w-64 flex-shrink-0">
    <div class="sticky top-24 max-h-[calc(100vh-8rem)] overflow-y-auto">
        <div class="glass-card p-6">
            <h3 class="text-lg font-semibold mb-4">{{ __('Table of Contents', 'blitz') }}</h3>
            <nav class="toc-nav space-y-2"></nav>
        </div>
    </div>
</aside>

<style>
.toc-nav a {
    @apply block py-1 px-3 text-sm text-text-secondary rounded transition-colors;
}

.toc-nav a:hover {
    @apply bg-bg-tertiary text-primary;
}

.toc-nav a.active {
    @apply bg-primary/10 text-primary font-medium;
}
</style>