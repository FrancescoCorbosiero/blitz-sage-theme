<section class="new-block-section" 
         x-data="newBlock(@json($data))"
         x-init="init()">
    
    {{-- HTML --}}
    <div class="new-block-content">
        <!-- Content here -->
    </div>
</section>

<style>
    .new-block-section {
        /* Scoped styles */
    }
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('newBlock', (data = {}) => ({
        // State
        ...data,
        
        // Init
        init() {
            // Use global features if needed
            console.log('Block initialized');
        },
        
        // Methods specific to this block
        customMethod() {
            // Block logic
        }
    }));
});
</script>