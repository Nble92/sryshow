<?php

FLBuilder::register_module(
    'syrCourseRecords',
    [
        'general' => [ // Tab.
            'title' => __('General'), // Tab title.
            'sections' => [ // Tab Sections.
                'general' => [ // Section.
                    'title' => '', // Section Title.
                    'fields' => [
                        'is_carousel' => [
                            'type' => 'select',
                            'label' => __('Post Appearance'),
                            'default' => 'carousel',
                            'help' => __('This is how your posts you want to display.'),
                            'options' => [
                                'carousel' => __('Carousel'),
                            ],
                        ],
                        'layout' => [
                            'type' => 'select',
                            'label' => __('Select layout'),
                            'default' => 'dashboard',
                            'help' => __('This is how your posts you want to display.'),
                            'options' => [
                                'dashboard' => __('Dashboard'),
                            ],
                        ],
                    ],
                ],
                'grid_filter' => [
                    'title' => __('Number of Posts to Show '),
                    'fields' => [
                        'post_per_grid_desktop' => [
                            'type' => 'select',
                            'label' => __('Desktop'),
                            'default' => '3',
                            'help' => __('This is how many posts you want to show at one time on desktop.'),
                            'options' => [
                                '1' => __('1 Column'),
                                '2' => __('2 Columns'),
                                '3' => __('3 Columns'),
                                '4' => __('4 Columns'),
                                '5' => __('5 Columns'),
                                '6' => __('6 Columns'),
                                '7' => __('7 Columns'),
                                '8' => __('8 Columns'),
                            ],
                        ],
                        'post_per_grid_medium' => [
                            'type' => 'select',
                            'label' => __('Medium Devices'),
                            'default' => '2',
                            'help' => __('This is how many posts you want to show at one time on tablet devices.'),
                            'options' => [
                                '1' => __('1 Column'),
                                '2' => __('2 Columns'),
                                '3' => __('3 Columns'),
                                '4' => __('4 Columns'),
                                '5' => __('5 Columns'),
                                '6' => __('6 Columns'),
                                '7' => __('7 Columns'),
                                '8' => __('8 Columns'),
                            ],
                        ],
                        'post_per_grid_small' => [
                            'type' => 'select',
                            'label' => __('Small Devices'),
                            'default' => '1',
                            'help' => __('This is how many posts you want to show at a time on mobile devices.'),
                            'options' => [
                                '1' => __('1 Column'),
                                '2' => __('2 Columns'),
                                '3' => __('3 Columns'),
                                '4' => __('4 Columns'),
                            ],
                        ],
                    ],
                ],
                'carousel_filter' => [
                    'title' => __('Carousel Filter'),
                    'fields' => [
                        'slides_to_scroll' => [
                            'type' => 'unit',
                            'label' => __('Posts to Scroll'),
                            'help' => __('This is how many posts you want to scroll at a time.'),
                            'placeholder' => '1',
                            'units' => ['posts'],
                            'slider' => [
                                '' => [
                                    'min' => 0,
                                    'max' => 100,
                                    'step' => 10,
                                ],
                            ],
                        ],
                        'autoplay' => [
                            'type' => 'select',
                            'label' => __('Autoplay Post Scroll'),
                            'help' => __('Enables auto play of posts.'),
                            'default' => 'no',
                            'options' => [
                                'yes' => __('Yes'),
                                'no' => __('No'),
                            ],
                            'toggle' => [
                                'yes' => [
                                    'fields' => ['animation_speed'],
                                ],
                            ],
                        ],
                        'animation_speed' => [
                            'type' => 'unit',
                            'label' => __('Autoplay Speed'),
                            'help' => __('Enter the time interval to scroll post automatically.'),
                            'placeholder' => '1000',
                            'slider' => true,
                            'units' => ['ms'],
                        ],
                        'infinite_loop' => [
                            'type' => 'select',
                            'label' => __('Infinite Loop'),
                            'help' => __('Enable this to scroll posts in infinite loop.'),
                            'default' => 'yes',
                            'options' => [
                                'yes' => __('Yes'),
                                'no' => __('No'),
                            ],
                        ],
                        'center_mode' => [
                            'type' => 'select',
                            'label' => __('Center Mode'),
                            'help' => __('Enables centered view with partial prev/next slides. Use with odd numbered slidesToShow counts.'),
                            'default' => 'no',
                            'options' => [
                                'yes' => __('Yes'),
                                'no' => __('No'),
                            ],
                        ],
                        'variable_width' => [
                            'type' => 'select',
                            'label' => __('Variable Width'),
                            'help' => __('Variable width slides.'),
                            'default' => 'no',
                            'options' => [
                                'yes' => __('Yes'),
                                'no' => __('No'),
                            ],
                        ],
                        'lazyload' => [
                            'type' => 'select',
                            'label' => __('Enable Lazy Load'),
                            'help' => __('Enable this to load the image as soon as user slide to it.'),
                            'default' => 'no',
                            'options' => [
                                'yes' => __('Yes'),
                                'no' => __('No'),
                            ],
                        ],
                        'enable_arrow' => [
                            'type' => 'select',
                            'label' => __('Enable Arrows'),
                            'help' => __('Enable Next/Prev arrows to your carousel slider.'),
                            'default' => 'yes',
                            'options' => [
                                'yes' => __('Yes'),
                                'no' => __('No'),
                            ],
                        ],
                        'enable_dots' => [
                            'type' => 'select',
                            'label' => __('Enable Dots'),
                            'help' => __('Enable Dots for the navigation'),
                            'default' => 'no',
                            'options' => [
                                'yes' => __('Yes'),
                                'no' => __('No'),
                            ],
                            'toggle' => [
                                'yes' => [
                                    'fields' => ['post_dots_size', 'post_dots_color'],
                                ],
                            ],
                        ],
                        'arrow_position' => [
                            'type' => 'select',
                            'label' => __('Arrow Position'),
                            'default' => 'outside',
                            'options' => [
                                'outside' => __('Outside'),
                                'inside' => __('Inside'),
                            ],
                        ],
                        'icon_left' => [
                            'type' => 'icon',
                            'label' => __('Left Arrow Icon'),
                            'show_remove' => true,
                        ],
                        'icon_right' => [
                            'type' => 'icon',
                            'label' => __('Right Arrow Icon'),
                            'show_remove' => true,
                        ],
                        'arrow_style' => [
                            'type' => 'select',
                            'label' => __('Arrow Style'),
                            'default' => 'circle',
                            'options' => [
                                'square' => __('Square Background'),
                                'circle' => __('Circle Background'),
                                'square-border' => __('Square Border'),
                                'circle-border' => __('Circle Border'),
                            ],
                            'toggle' => [
                                'square-border' => [
                                    'fields' => ['arrow_color', 'arrow_color_border', 'arrow_border_size'],
                                ],
                                'circle-border' => [
                                    'fields' => ['arrow_color', 'arrow_color_border', 'arrow_border_size'],
                                ],
                                'square' => [
                                    'fields' => ['arrow_color', 'arrow_background_color'],
                                ],
                                'circle' => [
                                    'fields' => ['arrow_color', 'arrow_background_color'],
                                ],
                            ],
                        ],
                        'arrow_color' => [
                            'type' => 'color',
                            'label' => __('Arrow Color'),
                            'default' => '',
                            'show_reset' => true,
                            'show_alpha' => true,
                            'connections' => ['color'],
                        ],
                        'arrow_background_color' => [
                            'type' => 'color',
                            'label' => __('Arrow Background Color'),
                            'default' => '',
                            'show_reset' => true,
                            'show_alpha' => true,
                            'connections' => ['color'],
                        ],
                        'arrow_color_border' => [
                            'type' => 'color',
                            'label' => __('Arrow Border Color'),
                            'default' => '',
                            'show_reset' => true,
                            'show_alpha' => true,
                            'connections' => ['color'],
                        ],
                        'arrow_border_size' => [
                            'type' => 'unit',
                            'label' => __('Border Size'),
                            'default' => '1',
                            'units' => ['px'],
                            'size' => '8',
                            'max_length' => '3',
                            'slider' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 10,
                                ],
                            ],
                        ],
                        'post_dots_size' => [
                            'type' => 'unit',
                            'label' => __('Dots Size'),
                            'units' => ['px'],
                            'preview' => [
                                'type' => 'css',
                                'selector' => '.uabb-blog-posts .slick-dots li button:before',
                                'property' => 'font-size',
                                'unit' => 'px',
                            ],
                            'slider' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 10,
                                ],
                            ],
                        ],
                        'post_dots_color' => [
                            'type' => 'color',
                            'label' => __('Dots Color'),
                            'show_alpha' => 'true',
                            'show_reset' => 'true',
                            'connections' => ['color'],
                            'preview' => [
                                'type' => 'css',
                                'selector' => '.uabb-blog-posts ul.slick-dots li button:before, .uabb-blog-post ul.slick-dots li.slick-active button:before',
                                'property' => 'color',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'style' => [ // Tab.
            'title' => __('Style'), // Tab title.
            'sections' => [ // Tab Sections.
                'alignment' => [
                    'title' => __('Content Basic Styling'),
                    'fields' => [
                        'overall_alignment' => [
                            'type' => 'align',
                            'label' => __('Overall Alignment'),
                            'help' => __('Controls the content alignment of each individual post.'),
                            'default' => 'center',
                            'preview' => [
                                'type' => 'css',
                                'selector' => '.uabb-blog-post-content',
                                'property' => 'text-align',
                                'important' => true,
                            ],
                        ],
                        'overall_padding_dimension' => [
                            'type' => 'dimension',
                            'label' => __('Overall Padding'),
                            'help' => __('Manage the outside spacing of entire area of post.'),
                            'units' => ['px'],
                            'preview' => [
                                'type' => 'css',
                                'selector' => '.uabb-blog-post-inner-wrap',
                                'property' => 'padding',
                                'unit' => 'px',
                                'important' => true,
                            ],
                            'responsive' => [
                                'placeholder' => [
                                    'default' => '0',
                                    'medium' => '',
                                    'responsive' => '',
                                ],
                            ],
                            'slider' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 10,
                                ],
                            ],
                        ],
                        'element_space' => [
                            'type' => 'unit',
                            'label' => __('Space Between Posts'),
                            'size' => '8',
                            'placeholder' => '15',
                            'units' => ['px'],
                            'help' => __('Manage the spacing between two posts.'),
                            'slider' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 10,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]
);
