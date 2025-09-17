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
  
  // Enhance editor experience
  enhanceEditor();
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
  
  // Group/Section styles
  wp.blocks.registerBlockStyle('core/group', {
    name: 'blitz-section',
    label: 'Full Section'
  });
  
  wp.blocks.registerBlockStyle('core/group', {
    name: 'blitz-card',
    label: 'Card'
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
  
  // Remove unwanted blocks
  const unwantedBlocks = [
    'core/verse',
    'core/preformatted',
    'core/pullquote',
    'core/nextpage'
  ];
  
  unwantedBlocks.forEach(block => {
    wp.blocks.unregisterBlockType(block);
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
    
    .is-style-blitz-card {
      padding: 2rem;
      background: var(--bg-secondary, #f8f8f8);
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
  const { Fragment } = wp.element;
  const { toggleFormat } = wp.richText;
  
  // Highlight format
  registerFormatType('blitz/highlight', {
    title: 'Highlight',
    tagName: 'mark',
    className: 'blitz-highlight',
    edit({ isActive, value, onChange }) {
      return wp.element.createElement(
        RichTextToolbarButton,
        {
          icon: 'admin-customizer',
          title: 'Highlight',
          onClick: () => {
            onChange(toggleFormat(value, {
              type: 'blitz/highlight'
            }));
          },
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
      return wp.element.createElement(
        RichTextToolbarButton,
        {
          icon: 'editor-textcolor',
          title: 'Small Text',
          onClick: () => {
            onChange(toggleFormat(value, {
              type: 'blitz/small'
            }));
          },
          isActive: isActive
        }
      );
    }
  });
}

// Listen for block insertions
wp.data.subscribe(() => {
  const blocks = wp.data.select('core/block-editor').getBlocks();
  
  // Auto-add classes to certain blocks
  blocks.forEach(block => {
    if (block.name === 'core/button') {
      if (!block.attributes.className?.includes('is-style-')) {
        wp.data.dispatch('core/block-editor').updateBlockAttributes(
          block.clientId,
          { className: 'is-style-blitz-primary' }
        );
      }
    }
  });
});

// Export for debugging
window.BlitzEditor = {
  registerBlockStyles,
  registerBlockVariations,
  registerFormatTypes
};