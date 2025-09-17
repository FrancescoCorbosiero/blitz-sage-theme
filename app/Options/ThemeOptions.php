<?php
namespace App\Options;

use Log1x\AcfComposer\Options as Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ThemeOptions extends Field
{
    public $name = 'Theme Options';
    public $title = 'Theme Options';
    
    public function fields()
    {
        $options = new FieldsBuilder('theme_options');
        
        $options
            ->addTab('general')
                ->addTrueFalse('enable_animations')
                ->addSelect('animation_style')
                    ->addChoices(['fade', 'slide', 'zoom'])
            ->addTab('advanced')
                ->addTrueFalse('enable_speculation_rules');
                
        return $options->build();
    }
}