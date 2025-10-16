// resources/js/editor.js

/**
 * Blitz Theme Block Editor Enhancements
 * Customizations for the WordPress block editor
 */

// Wait for editor to be ready
wp.domReady(() => {
  // Add custom block styles
  registerBlockStyles();
  
  // Add block variations
  registerBlockVariations();
  
  // Add block patterns
  registerBlockPatterns();
  
  // Add additional block styles
  registerAdditionalBlockStyles();
  
  // Enhance editor experience
  enhanceEditor();
  
  // Add custom inspector controls
  enhanceBlockInspector();
});

/**
 * Register custom block styles
 */
function registerBlockStyles() {
  // Button styles
  wp.blocks.registerBlockStyle('core/button', {
    name: 'blitz-primary',
    label: 'Primary',
    isDefault: true
  });
  
  wp.blocks.registerBlockStyle('core/button', {
    name: 'blitz-secondary',
    label: 'Secondary'
  });
  
  wp.blocks.registerBlockStyle('core/button', {
    name: 'blitz-outline',
    label: 'Outline'
  });
  
  wp.blocks.registerBlockStyle('core/button', {
    name: 'blitz-ghost',
    label: 'Ghost'
  });
  
  // Group/Section styles
  wp.blocks.registerBlockStyle('core/group', {
    name: 'blitz-section',
    label: 'Full Section'
  });
  
  wp.blocks.registerBlockStyle('core/group', {
    name: 'blitz-card',
    label: 'Card'
  });
  
  wp.blocks.registerBlockStyle('core/group', {
    name: 'blitz-card-hover',
    label: 'Card with Hover'
  });
  
  // Image styles
  wp.blocks.registerBlockStyle('core/image', {
    name: 'blitz-rounded',
    label: 'Rounded'
  });
  
  wp.blocks.registerBlockStyle('core/image', {
    name: 'blitz-shadow',
    label: 'With Shadow'
  });
  
  wp.blocks.registerBlockStyle('core/image', {
    name: 'blitz-zoom-hover',
    label: 'Zoom on Hover'
  });
  
  // Quote styles
  wp.blocks.registerBlockStyle('core/quote', {
    name: 'blitz-testimonial',
    label: 'Testimonial'
  });
  
  wp.blocks.registerBlockStyle('core/quote', {
    name: 'blitz-large',
    label: 'Large'
  });
}

/**
 * Register block variations
 */
function registerBlockVariations() {
  // Hero variation for Cover block
  wp.blocks.registerBlockVariation('core/cover', {
    name: 'blitz-hero',
    title: 'Hero Section',
    description: 'A hero section with heading and button',
    attributes: {
      align: 'full',
      dimRatio: 60,
      minHeight: 600,
      contentPosition: 'center center'
    },
    innerBlocks: [
      ['core/heading', {
        level: 1,
        placeholder: 'Hero Title',
        className: 'has-text-align-center'
      }],
      ['core/paragraph', {
        placeholder: 'Hero description...',
        className: 'has-text-align-center'
      }],
      ['core/buttons', {
        className: 'is-content-justification-center'
      }, [
        ['core/button', {
          text: 'Get Started',
          className: 'is-style-blitz-primary'
        }]
      ]]
    ],
    scope: ['inserter']
  });
  
  // CTA variation for Group block
  wp.blocks.registerBlockVariation('core/group', {
    name: 'blitz-cta',
    title: 'Call to Action',
    description: 'A call to action section',
    attributes: {
      align: 'wide',
      backgroundColor: 'primary',
      textColor: 'white',
      className: 'blitz-cta-block'
    },
    innerBlocks: [
      ['core/heading', {
        level: 2,
        placeholder: 'CTA Title',
        className: 'has-text-align-center'
      }],
      ['core/paragraph', {
        placeholder: 'CTA description...',
        className: 'has-text-align-center'
      }],
      ['core/buttons', {
        className: 'is-content-justification-center'
      }, [
        ['core/button', {
          text: 'Take Action',
          backgroundColor: 'white',
          textColor: 'primary'
        }]
      ]]
    ],
    scope: ['inserter']
  });
  
  // Features variation for Columns block
  wp.blocks.registerBlockVariation('core/columns', {
    name: 'blitz-features',
    title: 'Features Grid',
    description: 'A grid of feature cards',
    attributes: {
      align: 'wide',
      className: 'blitz-features-grid'
    },
    innerBlocks: [
      ['core/column', {}, [
        ['core/image', { 
          sizeSlug: 'thumbnail',
          className: 'is-style-blitz-rounded'
        }],
        ['core/heading', { 
          level: 3,
          placeholder: 'Feature Title'
        }],
        ['core/paragraph', { 
          placeholder: 'Feature description...'
        }]
      ]],
      ['core/column', {}, [
        ['core/image', { 
          sizeSlug: 'thumbnail',
          className: 'is-style-blitz-rounded'
        }],
        ['core/heading', { 
          level: 3,
          placeholder: 'Feature Title'
        }],
        ['core/paragraph', { 
          placeholder: 'Feature description...'
        }]
      ]],
      ['core/column', {}, [
        ['core/image', { 
          sizeSlug: 'thumbnail',
          className: 'is-style-blitz-rounded'
        }],
        ['core/heading', { 
          level: 3,
          placeholder: 'Feature Title'
        }],
        ['core/paragraph', { 
          placeholder: 'Feature description...'
        }]
      ]]
    ],
    scope: ['inserter']
  });
}

/**
 * Enhance editor experience
 */
function enhanceEditor() {
  // Remove unwanted block styles
  wp.blocks.unregisterBlockStyle('core/button', 'outline');
  wp.blocks.unregisterBlockStyle('core/button', 'squared');
  
  // Remove unwanted blocks (optional - comment out if needed)
  const unwantedBlocks = [
    'core/verse',
    'core/preformatted',
    'core/pullquote',
    'core/nextpage'
  ];
  
  unwantedBlocks.forEach(block => {
    try {
      wp.blocks.unregisterBlockType(block);
    } catch(e) {
      // Block might not exist
    }
  });
  
  // Add editor-only CSS
  addEditorStyles();
  
  // Add format types
  registerFormatTypes();
}

/**
 * Add custom editor styles
 */
function addEditorStyles() {
  const style = document.createElement('style');
  style.innerHTML = `
    /* Editor enhancements */
    .editor-styles-wrapper {
      font-family: var(--font-body, system-ui, -apple-system, sans-serif);
    }
    
    /* Blitz block styles */
    .is-style-blitz-primary {
      background: var(--primary, #1a3d0a) !important;
      color: white !important;
    }
    
    .is-style-blitz-secondary {
      background: var(--accent, #f97316) !important;
      color: white !important;
    }
    
    .is-style-blitz-outline {
      background: transparent !important;
      border: 2px solid var(--primary, #1a3d0a) !important;
      color: var(--primary, #1a3d0a) !important;
    }
    
    .is-style-blitz-ghost {
      background: transparent !important;
      color: var(--primary, #1a3d0a) !important;
      border: 1px solid transparent !important;
    }
    
    .is-style-blitz-ghost:hover {
      border-color: var(--primary, #1a3d0a) !important;
    }
    
    .is-style-blitz-card {
      padding: 2rem;
      background: var(--bg-secondary, #f8f8f8);
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .is-style-blitz-card-hover {
      padding: 2rem;
      background: var(--bg-secondary, #f8f8f8);
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .is-style-blitz-card-hover:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }
    
    .is-style-blitz-section {
      padding: 4rem 0;
    }
    
    .is-style-blitz-rounded img {
      border-radius: 12px;
    }
    
    .is-style-blitz-shadow img {
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }
    
    .is-style-blitz-zoom-hover {
      overflow: hidden;
      border-radius: 12px;
    }
    
    .is-style-blitz-zoom-hover img {
      transition: transform 0.3s ease;
    }
    
    .is-style-blitz-zoom-hover:hover img {
      transform: scale(1.05);
    }
    
    .is-style-blitz-testimonial {
      border-left: 4px solid var(--primary, #1a3d0a);
      padding-left: 1.5rem;
      font-style: italic;
    }
    
    .is-style-blitz-large {
      font-size: 1.5rem;
      line-height: 1.6;
    }
    
    /* Custom block variations */
    .blitz-cta-block {
      padding: 3rem 2rem;
      border-radius: 12px;
      text-align: center;
    }
    
    .blitz-features-grid {
      gap: 2rem;
    }
    
    .blitz-features-grid .wp-block-column {
      text-align: center;
    }
    
    /* Helper classes in editor */
    .has-shadow {
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }
    
    .has-rounded-corners {
      border-radius: 12px;
      overflow: hidden;
    }
  `;
  
  document.head.appendChild(style);
}

/**
 * Register custom format types
 */
function registerFormatTypes() {
  const { registerFormatType } = wp.richText;
  const { RichTextToolbarButton } = wp.blockEditor;
  const { toggleFormat } = wp.richText;
  
  // Highlight format
  registerFormatType('blitz/highlight', {
    title: 'Highlight',
    tagName: 'mark',
    className: 'blitz-highlight',
    edit({ isActive, value, onChange }) {
      const onToggle = () => {
        onChange(toggleFormat(value, { type: 'blitz/highlight' }));
      };
      
      return wp.element.createElement(
        RichTextToolbarButton,
        {
          icon: 'admin-customizer',
          title: 'Highlight',
          onClick: onToggle,
          isActive: isActive
        }
      );
    }
  });
  
  // Small text format
  registerFormatType('blitz/small', {
    title: 'Small',
    tagName: 'small',
    className: 'blitz-small',
    edit({ isActive, value, onChange }) {
      const onToggle = () => {
        onChange(toggleFormat(value, { type: 'blitz/small' }));
      };
      
      return wp.element.createElement(
        RichTextToolbarButton,
        {
          icon: 'editor-textcolor',
          title: 'Small Text',
          onClick: onToggle,
          isActive: isActive
        }
      );
    }
  });
}

/**
 * Register block patterns
 */
function registerBlockPatterns() {
  // Register custom pattern category first
  try {
    wp.blocks.registerBlockPatternCategory('blitz', {
      label: 'Blitz Sections'
    });
  } catch(e) {
    // Category might already exist
  }

  // Testimonial pattern
  wp.blocks.registerBlockPattern('blitz/testimonial-section', {
    title: 'Testimonial Section',
    description: 'Customer testimonial with image',
    categories: ['blitz'],
    content: `
      <!-- wp:group {"className":"blitz-testimonial-pattern"} -->
      <div class="wp-block-group blitz-testimonial-pattern">
        <!-- wp:columns -->
        <div class="wp-block-columns">
          <!-- wp:column {"width":"33.33%"} -->
          <div class="wp-block-column" style="flex-basis:33.33%">
            <!-- wp:image {"className":"is-style-blitz-rounded"} /-->
          </div>
          <!-- /wp:column -->
          <!-- wp:column {"width":"66.66%"} -->
          <div class="wp-block-column" style="flex-basis:66.66%">
            <!-- wp:quote {"className":"is-style-blitz-testimonial"} -->
            <blockquote class="wp-block-quote is-style-blitz-testimonial">
              <p>Your testimonial here...</p>
              <cite>Client Name</cite>
            </blockquote>
            <!-- /wp:quote -->
          </div>
          <!-- /wp:column -->
        </div>
        <!-- /wp:columns -->
      </div>
      <!-- /wp:group -->
    `
  });

  // Pricing table pattern
  wp.blocks.registerBlockPattern('blitz/pricing-table', {
    title: 'Pricing Table (3 Columns)',
    categories: ['blitz'],
    content: `
      <!-- wp:columns {"className":"blitz-pricing-grid"} -->
      <div class="wp-block-columns blitz-pricing-grid">
        <!-- wp:column {"className":"pricing-card"} -->
        <div class="wp-block-column pricing-card">
          <!-- wp:heading {"level":3,"textAlign":"center"} -->
          <h3 class="has-text-align-center">Basic</h3>
          <!-- /wp:heading -->
          <!-- wp:paragraph {"align":"center","className":"price"} -->
          <p class="has-text-align-center price"><strong>$29</strong>/month</p>
          <!-- /wp:paragraph -->
          <!-- wp:list -->
          <ul><li>Feature 1</li><li>Feature 2</li><li>Feature 3</li></ul>
          <!-- /wp:list -->
          <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
          <div class="wp-block-buttons">
            <!-- wp:button {"className":"is-style-blitz-outline"} -->
            <div class="wp-block-button is-style-blitz-outline">
              <a class="wp-block-button__link">Choose Plan</a>
            </div>
            <!-- /wp:button -->
          </div>
          <!-- /wp:buttons -->
        </div>
        <!-- /wp:column -->
      </div>
      <!-- /wp:columns -->
    `
  });

  // Stats section pattern
  wp.blocks.registerBlockPattern('blitz/stats-section', {
    title: 'Stats Grid',
    categories: ['blitz'],
    content: `
      <!-- wp:columns {"className":"blitz-stats-grid"} -->
      <div class="wp-block-columns blitz-stats-grid">
        <!-- wp:column -->
        <div class="wp-block-column">
          <!-- wp:heading {"level":2,"textAlign":"center"} -->
          <h2 class="has-text-align-center">500+</h2>
          <!-- /wp:heading -->
          <!-- wp:paragraph {"align":"center"} -->
          <p class="has-text-align-center">Happy Clients</p>
          <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->
      </div>
      <!-- /wp:columns -->
    `
  });
}

/**
 * Register additional block styles
 */
function registerAdditionalBlockStyles() {
  // List styles
  wp.blocks.registerBlockStyle('core/list', {
    name: 'blitz-checklist',
    label: 'Checklist'
  });

  wp.blocks.registerBlockStyle('core/list', {
    name: 'blitz-icons',
    label: 'With Icons'
  });

  // Heading styles
  wp.blocks.registerBlockStyle('core/heading', {
    name: 'blitz-gradient',
    label: 'Gradient Text'
  });

  wp.blocks.registerBlockStyle('core/heading', {
    name: 'blitz-underline',
    label: 'With Underline'
  });

  // Columns/Layout
  wp.blocks.registerBlockStyle('core/columns', {
    name: 'blitz-stacked-mobile',
    label: 'Stack on Mobile',
    isDefault: true
  });

  wp.blocks.registerBlockStyle('core/columns', {
    name: 'blitz-equal-height',
    label: 'Equal Heights'
  });

  // Separator
  wp.blocks.registerBlockStyle('core/separator', {
    name: 'blitz-gradient',
    label: 'Gradient Line'
  });

  wp.blocks.registerBlockStyle('core/separator', {
    name: 'blitz-dots',
    label: 'Dots'
  });

  // Media & Text
  wp.blocks.registerBlockStyle('core/media-text', {
    name: 'blitz-overlap',
    label: 'Overlap Effect'
  });

  // Table
  wp.blocks.registerBlockStyle('core/table', {
    name: 'blitz-striped',
    label: 'Striped Rows'
  });

  wp.blocks.registerBlockStyle('core/table', {
    name: 'blitz-bordered',
    label: 'Bordered'
  });
}

/**
 * Add custom inspector controls
 */
function enhanceBlockInspector() {
  const { createHigherOrderComponent } = wp.compose;
  const { Fragment } = wp.element;
  const { InspectorControls } = wp.blockEditor;
  const { PanelBody, SelectControl, ToggleControl, RangeControl } = wp.components;
  const { addFilter } = wp.hooks;

  // Add custom attributes to all blocks
  function addBlitzAttributes(settings) {
    settings.attributes = Object.assign(settings.attributes, {
      blitzAnimation: {
        type: 'string',
        default: 'none'
      },
      blitzAnimationDuration: {
        type: 'number',
        default: 600
      },
      blitzPadding: {
        type: 'string',
        default: 'default'
      },
      blitzSticky: {
        type: 'boolean',
        default: false
      },
      blitzFullWidth: {
        type: 'boolean',
        default: false
      }
    });
    
    return settings;
  }

  addFilter(
    'blocks.registerBlockType',
    'blitz/custom-attributes',
    addBlitzAttributes
  );

  // Add inspector controls
  const withBlitzControls = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      const { attributes, setAttributes } = props;

      return wp.element.createElement(
        Fragment,
        null,
        wp.element.createElement(BlockEdit, props),
        wp.element.createElement(
          InspectorControls,
          null,
          wp.element.createElement(
            PanelBody,
            {
              title: 'Blitz Animation',
              initialOpen: false
            },
            wp.element.createElement(SelectControl, {
              label: 'Animation Type',
              value: attributes.blitzAnimation || 'none',
              options: [
                { label: 'None', value: 'none' },
                { label: 'Fade In', value: 'fade-in' },
                { label: 'Slide Up', value: 'slide-up' },
                { label: 'Zoom In', value: 'zoom-in' },
                { label: 'Rotate', value: 'rotate' }
              ],
              onChange: (value) => {
                const newClassName = (attributes.className || '').replace(/animate-\S+/g, '').trim();
                setAttributes({
                  blitzAnimation: value,
                  className: value !== 'none' ? `${newClassName} animate-${value}`.trim() : newClassName
                });
              }
            }),
            wp.element.createElement(RangeControl, {
              label: 'Animation Duration (ms)',
              value: attributes.blitzAnimationDuration || 600,
              min: 200,
              max: 2000,
              step: 100,
              onChange: (value) => {
                setAttributes({ blitzAnimationDuration: value });
              }
            })
          ),
          wp.element.createElement(
            PanelBody,
            {
              title: 'Blitz Spacing',
              initialOpen: false
            },
            wp.element.createElement(SelectControl, {
              label: 'Padding',
              value: attributes.blitzPadding || 'default',
              options: [
                { label: 'None', value: 'none' },
                { label: 'Small', value: 'sm' },
                { label: 'Default', value: 'default' },
                { label: 'Large', value: 'lg' },
                { label: 'Extra Large', value: 'xl' }
              ],
              onChange: (value) => {
                const paddingClasses = {
                  'none': 'p-0',
                  'sm': 'p-4',
                  'default': 'p-8',
                  'lg': 'p-12',
                  'xl': 'p-16'
                };
                const newClassName = (attributes.className || '').replace(/p-\d+/g, '').trim();
                setAttributes({
                  blitzPadding: value,
                  className: `${newClassName} ${paddingClasses[value]}`.trim()
                });
              }
            })
          ),
          wp.element.createElement(
            PanelBody,
            {
              title: 'Blitz Advanced',
              initialOpen: false
            },
            wp.element.createElement(ToggleControl, {
              label: 'Sticky Positioning',
              checked: attributes.blitzSticky || false,
              onChange: (value) => {
                const newClassName = value
                  ? `${attributes.className || ''} sticky top-0 z-50`.trim()
                  : (attributes.className || '').replace(/sticky|top-\d+|z-\d+/g, '').trim();
                setAttributes({
                  blitzSticky: value,
                  className: newClassName
                });
              }
            }),
            wp.element.createElement(ToggleControl, {
              label: 'Full Width',
              checked: attributes.blitzFullWidth || false,
              onChange: (value) => {
                setAttributes({
                  blitzFullWidth: value,
                  align: value ? 'full' : 'none'
                });
              }
            })
          )
        )
      );
    };
  }, 'withBlitzControls');

  addFilter(
    'editor.BlockEdit',
    'blitz/with-blitz-controls',
    withBlitzControls
  );
}

// Export for debugging
window.BlitzEditor = {
  registerBlockStyles,
  registerBlockVariations,
  registerFormatTypes,
  registerBlockPatterns,
  registerAdditionalBlockStyles
};