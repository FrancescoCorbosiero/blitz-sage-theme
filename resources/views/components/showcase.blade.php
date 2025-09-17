
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-16 max-w-7xl">
  <div class="flex flex-col items-center justify-center space-y-6 sm:space-y-8">
    {{-- Basic primary button --}}
    <x-button>Get Started</x-button>

    {{-- Secondary button with icon --}}
    <x-button 
        variant="secondary" 
        size="lg"
        icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>'>
        Add to Favorites
    </x-button>

    {{-- Outline button as link --}}
    <x-button 
        variant="outline" 
        href="/contact"
        icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>'
        iconPosition="right">
        Contact Us
    </x-button>

    {{-- Loading button --}}
    <x-button 
        variant="primary" 
        loading 
        loadingText="Saving..."
        disabled>
        Save Changes
    </x-button>

    {{-- Danger button with confirmation --}}
    <x-button 
        variant="danger" 
        size="sm"
        @click="confirm('Are you sure?') && deleteItem()">
        Delete
    </x-button>

    {{-- Full width button --}}
    <x-button 
        variant="success" 
        fullWidth
        glowing>
        Complete Purchase
    </x-button>

    <x-card title="Hello World">This is card content</x-card>
  </div>
</div>