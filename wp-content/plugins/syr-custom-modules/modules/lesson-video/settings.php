<?php
/**
 * Register the module and its form settings with new typography, border, align param settings provided in beaver builder version 2.2.
 * Applicable for BB version greater than 2.2 and UABB version 1.14.0 or later.
 *
 * Converted font, align, border settings to respective param setting.
 *
 * @package UABB Modal Popup Module
 */

FLBuilder::register_module(
    'syrLessonVideo',
    [
        'general' => [ // Tab.
            'title' => __('Content'), // Tab title.
            'sections' => [ // Tab Sections.
                'preview' => [
                    'title' => '',
                    'fields' => [
                        'preview_modal' => [
                            'type' => 'select',
                            'label' => __('Preview Modal Popup'),
                            'default' => '1',
                            'options' => [
                                '1' => __('Yes'),
                                '0' => __('No'),
                            ],
                            'help' => __('If enabled, you will see preview of modal popup at backend. This option is just for preview purpose.'),
                        ],
                    ],
                ],
                'type_general' => [ // Section.
                    'title' => __('Modal Popup Setting'), // Section Title.
                    'fields' => [ // Section Fields.
                        'modal_width' => [
                            'type' => 'unit',
                            'label' => __('Maximum Width of Content'),
                            'default' => '500',
                            'maxlength' => '5',
                            'size' => '6',
                            'units' => ['px'],
                            'slider' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 10,
                                ],
                            ],
                            'help' => __('If you keep this empty title will not display'),
                        ],
                        'modal_spacing_dimension' => [
                            'type' => 'dimension',
                            'label' => __('Content Padding'),
                            'units' => ['px'],
                            'slider' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 10,
                                ],
                            ],
                            'default' => '25',
                            'responsive' => [
                                'placeholder' => [
                                    'default' => '25',
                                    'medium' => '',
                                    'responsive' => '',
                                ],
                            ],
                        ],
                        'modal_effect' => [
                            'type' => 'select',
                            'label' => __('Modal Appear Effect'),
                            'default' => 'uabb-effect-1',
                            'options' => [
                                'uabb-effect-1' => __('Fade in &amp; Scale'),
                                'uabb-effect-2' => __('Slide in (right)'),
                                'uabb-effect-3' => __('Slide in (bottom)'),
                                'uabb-effect-4' => __('Newspaper'),
                                'uabb-effect-5' => __('Fall'),
                                'uabb-effect-6' => __('Side Fall'),
                                'uabb-effect-8' => __('3D Flip (horizontal)'),
                                'uabb-effect-9' => __('3D Flip (vertical)'),
                                'uabb-effect-10' => __('3D Sign'),
                                'uabb-effect-11' => __('Super Scaled'),
                                'uabb-effect-13' => __('3D Slit'),
                                'uabb-effect-14' => __('3D Rotate Bottom'),
                                'uabb-effect-15' => __('3D Rotate In Left'),
                                'uabb-effect-17' => __('Let me in'),
                                'uabb-effect-18' => __('Make way!'),
                                'uabb-effect-19' => __('Slip from top'),
                            ],
                            'preview' => [
                                'type' => 'none',
                            ],
                        ],
                        'content_bg_color' => [
                            'type' => 'color',
                            'label' => __('Background Color'),
                            'default' => 'ffffff',
                            'show_reset' => true,
                            'show_alpha' => true,
                            'preview' => [
                                'type' => 'css',
                                'selector' => '.uabb-content',
                                'property' => 'background',
                            ],
                            'connections' => ['color'],
                        ],
                        'overlay_color' => [
                            'type' => 'color',
                            'label' => __('Overlay Color'),
                            'default' => 'rgba(0,0,0,0.75)',
                            'show_reset' => true,
                            'show_alpha' => true,
                            'connections' => ['color'],
                        ],
                        'modal_border' => [
                            'type' => 'border',
                            'label' => __('Modal Popup Border'),
                            'slider' => true,
                            'units' => ['px'],
                            'preview' => [
                                'type' => 'css',
                                'selector' => '.uabb-content',
                                'property' => 'border',
                                'unit' => 'px',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'modal' => [
            'title' => __('Display Settings'),
            'sections' => [
                'modal_sec' => [ // Section.
                    'fields' => [ // Section Fields.
                        'modal_on' => [
                            'type' => 'select',
                            'label' => __('Display Modal On'),
                            'default' => 'button',
                            'options' => [
                                'photo' => __('Image'),
                            ],
                            'toggle' => [
                                'photo' => [
                                    'fields' => ['all_align'],
                                    'sections' => ['modal_photo'],
                                ],
                            ],
                        ],
                        'all_align' => [
                            'type' => 'align',
                            'label' => __('Alignment'),
                            'default' => 'left',
                            'help' => __('To align Icon/Image/text use this settings'),
                        ],
                    ],
                ],
                'modal_photo' => [
                    'title' => __('Image'),
                    'fields' => [
                        'photo' => [
                            'type' => 'photo',
                            'label' => __('Image'),
                            'show_remove' => true,
                            'connections' => ['photo'],
                        ],
                    ],
                ],
            ],
        ],
        'close' => [
            'title' => __('Close Button'),
            'sections' => [
                /* Icon Basic Setting */
                'close_button' => [ // Section.
                    'title' => __('Close Button'), // Section Title.
                    'fields' => [ // Section Fields.
                        'close_source' => [
                            'type' => 'select',
                            'label' => __('Close as'),
                            'default' => 'icon',
                            'options' => [
                                'icon' => __('Icon'),
                                'image' => __('Image'),
                            ],
                            'toggle' => [
                                'icon' => [
                                    'fields' => ['close_icon', 'close_icon_color'],
                                ],
                                'image' => [
                                    'fields' => ['close_photo'],
                                ],
                            ],
                        ],
                        'close_icon' => [
                            'type' => 'icon',
                            'label' => __('Close Icon'),
                            'default' => 'fas fa-times',
                            'show_remove' => true,
                        ],
                        'close_photo' => [
                            'type' => 'photo',
                            'label' => __('Image'),
                            'show_remove' => true,
                            'connections' => ['photo'],
                        ],
                        'close_icon_size' => [
                            'type' => 'unit',
                            'label' => __('Size'),
                            'default' => '',
                            'placeholder' => '25',
                            'maxlength' => '5',
                            'size' => '6',
                            'units' => ['px'],
                            'slider' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 10,
                                ],
                            ],
                        ],
                        'close_icon_color' => [
                            'type' => 'color',
                            'label' => __('Color'),
                            'default' => '',
                            'show_reset' => true,
                            'show_alpha' => true,
                            'preview' => [
                                'type' => 'css',
                                'selector' => '.uabb-close-icon',
                                'property' => 'color',
                            ],
                            'connections' => ['color'],
                        ],
                        'icon_position' => [
                            'type' => 'select',
                            'label' => __('Image / Icon Position'),
                            'default' => 'top-right',
                            'options' => [
                                'top-left' => __('Window - Top Left'),
                                'top-right' => __('Window - Top Right'),
                                'popup-top-left' => __('Popup - Top Left'),
                                'popup-top-right' => __('Popup - Top Right'),
                                'popup-edge-top-left' => __('Popup Edge - Top Left'),
                                'popup-edge-top-right' => __('Popup Edge - Top Right'),
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]
);
