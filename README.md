# Blitz Theme - Usage Guide

Quick reference for using Blitz theme sections and components.

## 📑 Table of Contents
- [Sections Usage](#sections-usage)
- [Components Usage](#components-usage)
- [Customization](#customization)
- [Tips & Tricks](#tips--tricks)

---

## 🎨 Sections Usage

### Hero Section

**Basic Usage:**
```blade
@include('sections.hero.hero', [
    'title' => 'Welcome to Blitz',
    'subtitle' => 'The fastest WordPress theme',
    'button_text' => 'Get Started',
    'button_link' => '/contact',
    'background_image' => asset('images/hero-bg.jpg'),
])
```

**Full Options:**
```blade
@include('sections.hero.hero', [
    'title' => 'Your Title',
    'subtitle' => 'Your Subtitle',
    'description' => 'Optional longer description',
    'button_text' => 'Primary Button',
    'button_link' => '/link',
    'secondary_button_text' => 'Learn More',
    'secondary_button_link' => '/about',
    'background_image' => asset('images/hero.jpg'),
    'overlay_opacity' => 60, // 0-100
    'text_align' => 'center', // left, center, right
    'min_height' => 'screen', // screen, 600, 500, etc.
])
```

---

### Features Section

**Basic Grid:**
```blade
@include('sections.features.features', [
    'title' => 'Our Features',
    'subtitle' => 'Everything you need',
    'layout' => 'grid',
    'columns' => 3,
])
```

**Customizer Integration:**
Add features via **Appearance > Customize > Features Section**

---

### Services Section

**With Custom Post Type:**
```blade
{{-- Automatically displays all 'service' posts --}}
@include('sections.services.services')
```

**Custom Data:**
```blade
@include('sections.services.services', [
    'title' => 'Our Services',
    'services' => [
        [
            'title' => 'Web Design',
            'description' => 'Beautiful designs',
            'icon' => 'paintbrush',
            'link' => '/services/web-design'
        ],
        // ... more services
    ]
])
```

---

### Testimonials Section

**Default (uses testimonial CPT):**
```blade
@include('sections.testimonials.testimonials')
```

**Manual Testimonials:**
```blade
@include('sections.testimonials.testimonials', [
    'title' => 'What Clients Say',
    'testimonials' => [
        [
            'name' => 'John Doe',
            'role' => 'CEO, Company',
            'content' => 'Amazing theme!',
            'avatar' => asset('images/john.jpg'),
            'rating' => 5
        ],
    ]
])
```

---

### Contact Section

**Basic Contact Form:**
```blade
@include('sections.contact.contact', [
    'title' => 'Get in Touch',
    'subtitle' => 'We\'d love to hear from you',
    'show_map' => true,
    'show_info' => true,
])
```

Contact info is pulled from **Appearance > Customize > Contact Information**

---

### CTA (Call-to-Action) Section

**Simple CTA:**
```blade
@include('sections.cta.cta', [
    'title' => 'Ready to get started?',
    'subtitle' => 'Join thousands of satisfied customers',
    'button_text' => 'Start Free Trial',
    'button_link' => '/signup',
    'style' => 'gradient', // solid, gradient, outline
])
```

---

### FAQ Section

**With Accordion:**
```blade
@include('sections.faq.faq', [
    'title' => 'Frequently Asked Questions',
    'faqs' => [
        [
            'question' => 'How do I install the theme?',
            'answer' => 'Upload the theme...'
        ],
    ]
])
```

Or use FAQ Custom Post Type (auto-loads from `faq` CPT)

---

### Stats/Counter Section

**Animated Counters:**
```blade
@include('sections.stats.stats', [
    'stats' => [
        [
            'number' => 10000,
            'suffix' => '+',
            'label' => 'Happy Clients',
            'icon' => 'users'
        ],
        [
            'number' => 50,
            'suffix' => 'k',
            'label' => 'Projects Completed',
            'icon' => 'check-circle'
        ],
    ]
])
```

---

### Team Section

**Team Grid:**
```blade
@include('sections.team.team', [
    'title' => 'Meet Our Team',
    'columns' => 4,
])
```

Uses Team Custom Post Type or manual data:
```blade
@include('sections.team.team', [
    'members' => [
        [
            'name' => 'Jane Doe',
            'role' => 'CEO',
            'bio' => 'Founder of company',
            'image' => asset('images/jane.jpg'),
            'social' => [
                'linkedin' => 'https://linkedin.com/in/jane',
                'twitter' => 'https://twitter.com/jane',
            ]
        ],
    ]
])
```

---

### Pricing Section

**Pricing Tables:**
```blade
@include('sections.pricing.pricing', [
    'title' => 'Choose Your Plan',
    'plans' => [
        [
            'name' => 'Starter',
            'price' => 19,
            'period' => 'month',
            'features' => [
                '10 Projects',
                '5GB Storage',
                'Email Support'
            ],
            'button_text' => 'Get Started',
            'button_link' => '/signup?plan=starter',
            'featured' => false,
        ],
        [
            'name' => 'Pro',
            'price' => 49,
            'period' => 'month',
            'features' => [
                'Unlimited Projects',
                '50GB Storage',
                'Priority Support',
                'Advanced Features'
            ],
            'button_text' => 'Go Pro',
            'button_link' => '/signup?plan=pro',
            'featured' => true, // Highlighted
        ],
    ]
])
```

---

### Blog Section

**Latest Posts:**
```blade
@include('sections.blog.blog', [
    'title' => 'Latest Articles',
    'posts_per_page' => 6,
    'columns' => 3,
    'show_excerpt' => true,
    'show_date' => true,
    'show_author' => true,
])
```

---

### Process/Steps Section

**Step-by-Step Guide:**
```blade
@include('sections.process.process', [
    'title' => 'How It Works',
    'steps' => [
        [
            'number' => 1,
            'title' => 'Sign Up',
            'description' => 'Create your account in seconds',
            'icon' => 'user-plus'
        ],
        [
            'number' => 2,
            'title' => 'Configure',
            'description' => 'Set up your preferences',
            'icon' => 'settings'
        ],
        [
            'number' => 3,
            'title' => 'Launch',
            'description' => 'Go live and start growing',
            'icon' => 'rocket'
        ],
    ]
])
```

---

## 🧩 Components Usage

### WhatsApp Button

**Floating Button:**
```blade
@include('components.whatsapp-button', [
    'number' => '+1234567890',
    'message' => 'Hi! I have a question',
    'position' => 'bottom-right', // bottom-right, bottom-left
])
```

Auto-loads from **Customize > Contact Information > WhatsApp**

---

### Modal

**Trigger Modal:**
```blade
<button @click="$dispatch('open-modal', { id: 'my-modal' })">
    Open Modal
</button>

@include('partials.modal.modal', [
    'id' => 'my-modal',
    'title' => 'Modal Title',
    'content' => 'Modal content goes here',
])
```

---

### Toast Notifications

**Show Toast (JavaScript):**
```javascript
BlockUtils.showToast('Success message!', 'success');
BlockUtils.showToast('Error occurred', 'error');
BlockUtils.showToast('Warning!', 'warning');
BlockUtils.showToast('Info message', 'info');
```

---

### Alert

**Inline Alert:**
```blade
@include('partials.alert.alert', [
    'type' => 'success', // success, error, warning, info
    'message' => 'Your changes have been saved!',
    'dismissible' => true,
])
```

---

### Dropdown

**Dropdown Menu:**
```blade
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="btn">
        Menu
    </button>
    
    @include('partials.dropdown.dropdown', [
        'items' => [
            ['label' => 'Profile', 'url' => '/profile'],
            ['label' => 'Settings', 'url' => '/settings'],
            ['label' => 'Logout', 'url' => '/logout'],
        ]
    ])
</div>
```

---

## ⚙️ Customization

### Custom Colors

**Edit `tailwind.config.js`:**
```javascript
colors: {
    primary: {
        DEFAULT: '#3B82F6', // Your brand color
        dark: '#2563EB',
        light: '#60A5FA',
    },
    secondary: '#8B5CF6',
    accent: '#EC4899',
}
```

Then rebuild:
```bash
npm run build
```

---

### Custom Fonts

**Add to `resources/css/core/typography.css`:**
```css
@font-face {
    font-family: 'YourFont';
    src: url('../fonts/YourFont.woff2') format('woff2');
    font-weight: 400;
    font-display: swap;
}

:root {
    --font-primary: 'YourFont', sans-serif;
}
```

---

### Dark Mode Colors

**Edit in `resources/css/core/color.css`:**
```css
:root[data-theme="dark"] {
    --color-bg-primary: #1a1a1a;
    --color-text-primary: #ffffff;
    /* Add more custom dark mode colors */
}
```

---

## 💡 Tips & Tricks

### 1. Quick Section Testing

Create a test page template:
```blade
{{-- resources/views/template-test.blade.php --}}

{{-- Template Name: Section Test --}}

@extends('layouts.app')

@section('content')
    @include('sections.hero.hero')
    @include('sections.features.features')
    @include('sections.cta.cta')
@endsection
```

### 2. Reusable Data

Create a data file:
```php
// app/Data/homepage-data.php
return [
    'hero' => [
        'title' => 'Welcome',
        'subtitle' => 'Subtitle',
    ],
    'features' => [
        // features data
    ],
];
```

Use in template:
```blade
@php
$data = include(app_path('Data/homepage-data.php'));
@endphp

@include('sections.hero.hero', $data['hero'])
```

### 3. Conditional Sections
```blade
@if(get_theme_mod('show_testimonials', true))
    @include('sections.testimonials.testimonials')
@endif
```

### 4. Section Ordering

Control via WordPress Customizer or use array:
```blade
@php
$sections = [
    'hero',
    'features',
    'services',
    'testimonials',
    'cta'
];
@endphp

@foreach($sections as $section)
    @include("sections.{$section}.{$section}")
@endforeach
```

### 5. Custom Block Animations

Add to any section:
```blade
<section data-aos="fade-up" data-aos-delay="100">
    <!-- Content -->
</section>
```

Available animations:
- `fade-up`, `fade-down`, `fade-left`, `fade-right`
- `zoom-in`, `zoom-out`
- `flip-up`, `flip-down`

---

## 🚀 Performance Tips

1. **Lazy Load Images:**
```html
<img src="placeholder.jpg" data-src="actual-image.jpg" loading="lazy" alt="...">
```

2. **Optimize Images:**
```bash
./scripts/optimize-images.sh
```

3. **Enable Caching:**
Go to **Customize > Performance** and enable all options

4. **Use WebP:**
Serve WebP with fallback:
```html
<picture>
    <source srcset="image.webp" type="image/webp">
    <img src="image.jpg" alt="...">
</picture>
```

---

## 🆘 Need Help?

- **Docs:** [README.md](README.md)
- **Migration:** [MIGRATION-GUIDE.md](MIGRATION-GUIDE.md)
- **Issues:** [GitHub Issues](https://github.com/FrancescoCorbosiero/blitz-sage-theme/issues)

---

Happy building with Blitz! ⚡