<?php

class syrSearchModule extends FLBuilderModule
{

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(
            [
                'name' => __('Search'),
                'description' => __('Add Search bar on your site.'),
                'category' => 'Basic',
                'group' => 'SYR Modules',
                'dir' => SYR_MODULES_DIR . 'modules/search/',
                'url' => SYR_MODULES_URL . 'modules/search/',
                'editor_export' => true, // Defaults to true and can be omitted.
                'partial_refresh' => true,
                'icon' => 'search.svg',
            ]
        );
    }

    /**
     * Function that gets form classes
     *
     * @method get_form_classes
     */
    public function get_form_classes()
    {
        $classname = 'syr-search-form';

        if (!empty($this->settings->display)) {
            $classname .= ' syr-search-form-' . $this->settings->display;
            if (!empty($this->settings->layout)) {
                $classname .= ' syr-search-form-' . $this->settings->layout;
            }
            if ('button' === $this->settings->display) {
                $classname .= ' syr-search-button-' . $this->settings->btn_action;

                if ('expand' === $this->settings->btn_action) {
                    $classname .= ' syr-search-button-expand-' . $this->settings->expand_position;
                }
            }
        }

        if (!empty($this->settings->width)) {
            $classname .= ' syr-search-form-width-' . $this->settings->width;
        }

        if (!empty($this->settings->form_align) && 'full' !== $this->settings->width) {
            $classname .= ' syr-search-form-' . $this->settings->form_align;
        }

        return $classname;
    }
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module(
    'syrSearchModule',
    [
        'layout' => [
            'title' => __('Layout'),
            'sections' => [
                'general' => [
                    'title' => '',
                    'fields' => [
                        'display' => [
                            'type' => 'select',
                            'label' => __('Display Layout'),
                            'default' => 'button',
                            'options' => [
                                'button' => __('Button Only'),
                            ],
                            'toggle' => [
                                'button' => [
                                    'fields' => ['btn_action', 'btn_text'],
                                    'sections' => ['btn-style', 'btn-icon', 'btn_typography'],
                                ],
                                'both' => [
                                    'fields' => ['layout', 'btn_text'],
                                    'sections' => ['btn-style', 'btn-icon', 'btn_typography'],
                                ],
                            ],
                        ],
                        'btn_action' => [
                            'type' => 'select',
                            'label' => __('Button Click Action'),
                            'default' => 'fullscreen',
                            'options' => [
                                'fullscreen' => __('Full Screen'),
                            ],
                            'toggle' => [
                                'fullscreen' => [
                                    'sections' => ['fullscreen_style'],
                                ],
                            ],
                            'preview' => [
                                'type' => 'none',
                            ],

                        ],
                    ],
                ],
            ],
        ],
        'style' => [
            'title' => __('Style'),
            'sections' => [
                'general_style' => [
                    'title' => 'Search Container',
                    'fields' => [
                        'width' => [
                            'type' => 'select',
                            'label' => __('Width'),
                            'default' => 'full',
                            'options' => [
                                'auto' => _x('Auto', 'Width.'),
                                'full' => __('Full Width'),
                                'custom' => __('Custom'),
                            ],
                            'toggle' => [
                                'auto' => [
                                    'fields' => ['form_align'],
                                ],
                                'full' => [],
                                'custom' => [
                                    'fields' => ['form_align', 'custom_width'],
                                ],
                            ],
                        ],
                        'custom_width' => [
                            'type' => 'unit',
                            'label' => __('Custom Width'),
                            'default' => '1100',
                            'sanitize' => 'absint',
                            'units' => ['px', '%'],
                            'slider' => [
                                'min' => 0,
                                'max' => 1100,
                                'step' => 10,
                            ],
                            'help' => __('The max width of the search form container.'),
                            'preview' => [
                                'type' => 'css',
                                'selector' => '{node} .syr-search-form-wrap',
                                'property' => 'width',
                            ],
                        ],
                        'form_height' => [
                            'type' => 'unit',
                            'label' => __('Height'),
                            'default' => '0',
                            'responsive' => true,
                            'sanitize' => 'absint',
                            'units' => [
                                'px',
                                'vw',
                                'vh',
                            ],
                            'slider' => [
                                'max' => 600,
                                'step' => 10,
                            ],
                            'help' => __('This setting is the minimum height of the form. Content will expand the height automatically.'),
                            'preview' => [
                                'type' => 'css',
                                'selector' => '{node} .syr-search-form-wrap',
                                'property' => 'min-height',
                                'important' => true,
                            ],
                        ],
                        'form_align' => [
                            'type' => 'align',
                            'label' => __('Alignment'),
                            'default' => 'center',
                            'responsive' => true,
                            'preview' => [
                                'type' => 'css',
                                'selector' => '.syr-search-form',
                                'property' => 'text-align',
                            ],
                        ],
                        'form_bg_color' => [
                            'type' => 'color',
                            'label' => __('Background Color'),
                            'show_reset' => true,
                            'show_alpha' => true,
                            'connections' => ['color'],
                            'preview' => [
                                'type' => 'css',
                                'selector' => '{node}.syr-module-search .syr-search-form-wrap',
                                'property' => 'background-color',
                            ],
                        ],
                        'form_bg_hover_color' => [
                            'type' => 'color',
                            'label' => __('Background Hover Color'),
                            'default' => '',
                            'show_reset' => true,
                            'show_alpha' => true,
                            'connections' => ['color'],
                            'preview' => [
                                'type' => 'none',
                            ],
                        ],
                        'form_border' => [
                            'type' => 'border',
                            'label' => __('Border'),
                            'preview' => [
                                'type' => 'css',
                                'selector' => '{node}.syr-module-search .syr-search-form-wrap',
                                'important' => true,
                            ],
                        ],
                        'form_border_hov_color' => [
                            'type' => 'color',
                            'label' => __('Border Hover Color'),
                            'show_reset' => true,
                            'connections' => ['color'],
                            'show_alpha' => true,
                            'preview' => [
                                'type' => 'none',
                            ],
                        ],
                        'form_padding' => [
                            'type' => 'dimension',
                            'label' => __('Padding'),
                            'default' => '10',
                            'responsive' => true,
                            'slider' => true,
                            'units' => ['px'],
                            'preview' => [
                                'type' => 'css',
                                'selector' => '{node}.syr-module-search .syr-search-form-wrap',
                                'property' => 'padding',
                            ],
                        ],
                    ],
                ],
                'input_style' => [
                    'title' => 'Input Style',
                    'collapsed' => true,
                    'fields' => [
                        'input_color' => [
                            'type' => 'color',
                            'label' => __('Text Color'),
                            'show_reset' => true,
                            'show_alpha' => true,
                            'preview' => [
                                'type' => 'css',
                                'selector' => '{node}.syr-module-search .syr-search-text, {node}.syr-module-search .syr-search-text::placeholder',
                                'property' => 'color',
                            ],
                        ],
                        'input_bg_color' => [
                            'type' => 'color',
                            'label' => __('Background Color'),
                            'show_reset' => true,
                            'show_alpha' => true,
                            'connections' => ['color'],
                            'preview' => [
                                'type' => 'css',
                                'selector' => 'input.syr-search-text',
                                'property' => 'background-color',
                            ],
                        ],
                        'input_bg_hover_color' => [
                            'type' => 'color',
                            'label' => __('Background Hover Color'),
                            'default' => '',
                            'show_reset' => true,
                            'show_alpha' => true,
                            'connections' => ['color'],
                            'preview' => [
                                'type' => 'none',
                            ],
                        ],
                        'input_border' => [
                            'type' => 'border',
                            'label' => __('Border'),
                            'preview' => [
                                'type' => 'css',
                                'selector' => '{node}.syr-module-search .syr-search-text',
                                'important' => true,
                            ],
                        ],
                        'input_border_hov_color' => [
                            'type' => 'color',
                            'label' => __('Border Hover Color'),
                            'show_reset' => true,
                            'connections' => ['color'],
                            'show_alpha' => true,
                            'preview' => [
                                'type' => 'none',
                            ],
                        ],
                        'input_padding' => [
                            'type' => 'dimension',
                            'label' => __('Padding'),
                            'default' => '15',
                            'responsive' => true,
                            'slider' => true,
                            'units' => ['px'],
                            'preview' => [
                                'type' => 'css',
                                'selector' => '{node}.syr-module-search .syr-search-text',
                                'property' => 'padding',
                            ],
                        ],
                    ],
                ],
                'fullscreen_style' => [
                    'title' => 'Fullscreen',
                    'collapsed' => true,
                    'fields' => [
                        'fs_input_width' => [
                            'type' => 'unit',
                            'label' => __('Input Width'),
                            'default' => '600',
                            'sanitize' => 'absint',
                            'units' => ['px', '%'],
                            'slider' => [
                                'min' => 0,
                                'max' => 1100,
                                'step' => 10,
                            ],
                            'help' => __('The max width of the input field on fullscreen.'),
                            'preview' => [
                                'type' => 'none',
                            ],
                        ],
                        'fs_overlay_bg' => [
                            'type' => 'color',
                            'label' => __('Overlay Background Color'),
                            'show_reset' => true,
                            'show_alpha' => true,
                            'connections' => ['color'],
                            'preview' => [
                                'type' => 'none',
                            ],
                        ],
                        'fs_close_button' => [
                            'type' => 'select',
                            'label' => __('Close Icon'),
                            'default' => 'show',
                            'options' => [
                                'hide' => __('Hide'),
                                'show' => __('Show'),
                            ],
                            'preview' => [
                                'type' => 'none',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'typography' => [
            'title' => __('Typography'),
            'sections' => [
                'input_typography' => [
                    'title' => __('Input Text'),
                    'fields' => [
                        'input_typo' => [
                            'type' => 'typography',
                            'label' => __('Typography'),
                            'responsive' => true,
                            'preview' => [
                                'type' => 'css',
                                'selector' => '{node}.syr-module-search .syr-search-text',
                                'important' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]
);

