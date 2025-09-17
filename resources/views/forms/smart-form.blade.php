{{--
  Smart Form Field Component
  Comprehensive form field with validation, icons, and accessibility
--}}

@props([
    'type' => 'text',                       // text, email, password, tel, url, number, textarea, select, checkbox, radio
    'name' => '',                           // Field name
    'label' => '',                          // Field label
    'placeholder' => '',                    // Placeholder text
    'value' => '',                          // Default value
    'options' => [],                        // Options for select/radio/checkbox
    'required' => false,                    // Required field
    'disabled' => false,                    // Disabled state
    'readonly' => false,                    // Readonly state
    'icon' => null,                         // Icon (left side)
    'iconRight' => null,                    // Icon (right side)
    'help' => '',                           // Help text
    'error' => '',                          // Error message
    'success' => '',                        // Success message
    'size' => 'md',                         // sm, md, lg
    'rounded' => 'lg',                      // sm, md, lg, xl, full
    'variant' => 'default',                 // default, filled, outlined, underlined
    'validation' => null,                   // Validation rules (array)
    'autocomplete' => null,                 // Autocomplete attribute
    'maxlength' => null,                    // Maximum length
    'rows' => 4,                           // Textarea rows
    'floating' => false,                    // Floating label
])

@php
    $fieldId = $name ? "field-{$name}" : "field-" . uniqid();
    
    // Size configurations
    $sizeClasses = [
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-3 text-base',
        'lg' => 'px-5 py-4 text-lg',
    ];
    
    // Variant styles
    $variants = [
        'default' => [
            'input' => 'bg-bg-secondary border border-border-color focus:border-primary focus:ring-primary/20',
            'label' => 'text-text-primary font-medium',
        ],
        'filled' => [
            'input' => 'bg-bg-tertiary border-0 border-b-2 border-border-color focus:border-primary focus:ring-0',
            'label' => 'text-text-secondary font-medium',
        ],
        'outlined' => [
            'input' => 'bg-transparent border-2 border-border-color focus:border-primary focus:ring-primary/20',
            'label' => 'text-text-primary font-semibold',
        ],
        'underlined' => [
            'input' => 'bg-transparent border-0 border-b-2 border-border-color focus:border-primary focus:ring-0 rounded-none px-0',
            'label' => 'text-text-primary font-medium',
        ],
    ];
    
    $variantConfig = $variants[$variant] ?? $variants['default'];
    
    // Build input classes
    $inputClasses = collect([
        'form-input w-full',
        'transition-all duration-200',
        'focus:outline-none focus:ring-2 focus:ring-offset-1',
        'disabled:opacity-50 disabled:cursor-not-allowed',
        'placeholder:text-text-muted',
        $sizeClasses[$size] ?? $sizeClasses['md'],
        $variantConfig['input'],
        $icon ? 'pl-10' : '',
        $iconRight ? 'pr-10' : '',
        $error ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20' : '',
        $success ? 'border-green-500 focus:border-green-500 focus:ring-green-500/20' : '',
        $rounded === 'full' ? 'rounded-full' : "rounded-{$rounded}",
    ])->filter()->implode(' ');
@endphp

<div class="form-field" 
     x-data="formField('{{ $name }}', {{ json_encode($validation ?: []) }})"
     x-init="init()">
    
    {{-- Label --}}
    @if($label && !$floating)
        <label for="{{ $fieldId }}" 
               class="block mb-2 {{ $variantConfig['label'] }} {{ $required ? "after:content-['*'] after:ml-1 after:text-red-500" : '' }}">
            {{ $label }}
        </label>
    @endif
    
    {{-- Input Container --}}
    <div class="relative {{ $floating ? 'floating-label' : '' }}">
        
        {{-- Left Icon --}}
        @if($icon)
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <div class="w-5 h-5 text-text-muted">
                    {!! $icon !!}
                </div>
            </div>
        @endif
        
        {{-- Input Field --}}
        @switch($type)
            @case('textarea')
                <textarea id="{{ $fieldId }}"
                         name="{{ $name }}"
                         rows="{{ $rows }}"
                         class="{{ $inputClasses }}"
                         placeholder="{{ $placeholder }}"
                         @if($required) required @endif
                         @if($disabled) disabled @endif
                         @if($readonly) readonly @endif
                         @if($maxlength) maxlength="{{ $maxlength }}" @endif
                         @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
                         x-model="value"
                         @blur="validate"
                         @input="clearError">{{ $value }}</textarea>
                @break
                
            @case('select')
                <select id="{{ $fieldId }}"
                        name="{{ $name }}"
                        class="{{ $inputClasses }}"
                        @if($required) required @endif
                        @if($disabled) disabled @endif
                        x-model="value"
                        @change="validate">
                    
                    @if($placeholder)
                        <option value="">{{ $placeholder }}</option>
                    @endif
                    
                    @foreach($options as $optionValue => $optionLabel)
                        <option value="{{ $optionValue }}" 
                                @if($optionValue == $value) selected @endif>
                            {{ $optionLabel }}
                        </option>
                    @endforeach
                </select>
                @break
                
            @case('checkbox')
                <div class="flex items-center">
                    <input type="checkbox"
                           id="{{ $fieldId }}"
                           name="{{ $name }}"
                           value="1"
                           class="w-4 h-4 text-primary bg-bg-secondary border-border-color rounded focus:ring-primary/20 focus:ring-2"
                           @if($value) checked @endif
                           @if($required) required @endif
                           @if($disabled) disabled @endif
                           x-model="checked"
                           @change="validate">
                    
                    @if($label)
                        <label for="{{ $fieldId }}" 
                               class="ml-3 text-sm {{ $variantConfig['label'] }}">
                            {{ $label }}
                        </label>
                    @endif
                </div>
                @break
                
            @case('radio')
                <div class="space-y-2">
                    @foreach($options as $optionValue => $optionLabel)
                        <div class="flex items-center">
                            <input type="radio"
                                   id="{{ $fieldId }}-{{ $loop->index }}"
                                   name="{{ $name }}"
                                   value="{{ $optionValue }}"
                                   class="w-4 h-4 text-primary bg-bg-secondary border-border-color focus:ring-primary/20 focus:ring-2"
                                   @if($optionValue == $value) checked @endif
                                   @if($required) required @endif
                                   @if($disabled) disabled @endif
                                   x-model="value"
                                   @change="validate">
                            
                            <label for="{{ $fieldId }}-{{ $loop->index }}" 
                                   class="ml-3 text-sm {{ $variantConfig['label'] }}">
                                {{ $optionLabel }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @break
                
            @default
                <input type="{{ $type }}"
                       id="{{ $fieldId }}"
                       name="{{ $name }}"
                       class="{{ $inputClasses }}"
                       placeholder="{{ $floating ? '' : $placeholder }}"
                       value="{{ $value }}"
                       @if($required) required @endif
                       @if($disabled) disabled @endif
                       @if($readonly) readonly @endif
                       @if($maxlength) maxlength="{{ $maxlength }}" @endif
                       @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
                       x-model="value"
                       @blur="validate"
                       @input="clearError">
        @endswitch
        
        {{-- Floating Label --}}
        @if($floating && $label)
            <label for="{{ $fieldId }}" 
                   class="absolute left-4 transition-all duration-200 pointer-events-none
                          {{ $variantConfig['label'] }}
                          {{ $required ? "after:content-['*'] after:ml-1 after:text-red-500" : '' }}"
                   :class="{ 
                       'top-3 text-base text-text-muted': !value && !$el.previousElementSibling?.matches(':focus'),
                       '-top-2 left-2 text-xs bg-card-bg px-2 text-primary': value || $el.previousElementSibling?.matches(':focus')
                   }">
                {{ $label }}
            </label>
        @endif
        
        {{-- Right Icon --}}
        @if($iconRight)
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <div class="w-5 h-5 text-text-muted">
                    {!! $iconRight !!}
                </div>
            </div>
        @endif
        
        {{-- Validation Icons --}}
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            {{-- Error Icon --}}
            <svg x-show="hasError" 
                 class="w-5 h-5 text-red-500" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            
            {{-- Success Icon --}}
            <svg x-show="isValid && !hasError && value" 
                 class="w-5 h-5 text-green-500" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
    </div>
    
    {{-- Help Text --}}
    @if($help)
        <p class="mt-2 text-sm text-text-muted">
            {{ $help }}
        </p>
    @endif
    
    {{-- Error Message --}}
    <div x-show="hasError" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform translate-y-1"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         class="mt-2">
        <p class="text-sm text-red-600" x-text="errorMessage">
            {{ $error }}
        </p>
    </div>
    
    {{-- Success Message --}}
    @if($success)
        <div class="mt-2">
            <p class="text-sm text-green-600">
                {{ $success }}
            </p>
        </div>
    @endif
    
    {{-- Character Counter (for fields with maxlength) --}}
    @if($maxlength)
        <div class="flex justify-end mt-1">
            <span class="text-xs text-text-muted" 
                  x-text="`${value ? value.length : 0}/${maxlength}`">
                0/{{ $maxlength }}
            </span>
        </div>
    @endif
</div>

<style>
    /* Floating label enhancements */
    .floating-label input:focus + label,
    .floating-label input:not(:placeholder-shown) + label,
    .floating-label textarea:focus + label,
    .floating-label textarea:not(:placeholder-shown) + label {
        transform: translateY(-1.5rem) scale(0.85);
        background: var(--card-bg);
        padding: 0 0.5rem;
        color: var(--primary);
    }
    
    /* Custom select styling */
    select.form-input {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5rem 1.5rem;
        padding-right: 2.5rem;
    }
    
    /* Dark mode select arrow */
    [data-theme="dark"] select.form-input {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%9ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    }
    
    /* Custom checkbox and radio styling */
    input[type="checkbox"]:checked,
    input[type="radio"]:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    
    input[type="checkbox"]:focus,
    input[type="radio"]:focus {
        ring-color: var(--primary);
        ring-opacity: 0.2;
    }
    
    /* Underlined variant specific styles */
    .form-input.bg-transparent.border-0.border-b-2 {
        padding-left: 0;
        padding-right: 0;
        border-radius: 0;
    }
    
    /* Loading state */
    .form-input.loading {
        background-image: linear-gradient(90deg, var(--bg-secondary) 25%, var(--bg-tertiary) 50%, var(--bg-secondary) 75%);
        background-size: 200% 100%;
        animation: loadingShimmer 1.5s infinite linear;
    }

    @keyframes loadingShimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>