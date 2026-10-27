<?php

class syrSongPlay extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(
            [
                'name' => __('SYR Song Play'),
                'description' => __('Module to display play button for song.'),
                'category' => __('Lesson'),
                'group' => 'SYR Modules',
                'dir' => SYR_MODULES_DIR . 'modules/song-play/',
                'url' => SYR_MODULES_URL . 'modules/song-play/',
            ]
        );

        $this->add_js( 'jquery-waypoints' );
    }

    
/**
     * Ensure backwards compatibility with old settings.
     *
     * @param object $settings A module settings object.
     * @param object $helper A settings compatibility helper.
     * @return object
     * @since 2.2
     */
    public function filter_settings($settings, $helper)
    {
        if (isset($settings->r_align) && 'custom' === $settings->r_align) {
            $settings->align_responsive = $settings->r_custom_align;
            unset($settings->r_align);
            unset($settings->r_custom_align);
        }
        return $settings;
    }

    /**
     * Returns link rel based on settings.
     * @return string
     * @since 2.2
     */
    public function get_rel()
    {
        $rel = [];
        if ('_blank' == $this->settings->link_target) {
            $rel[] = 'noopener';
        }
        if (isset($this->settings->link_nofollow) && 'yes' == $this->settings->link_nofollow) {
            $rel[] = 'nofollow';
        }
        $rel = implode(' ', $rel);
        if ($rel) {
            $rel = ' rel="' . $rel . '" ';
        }
        return $rel;
    }
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('syrSongPlay', [
    'general' => [ // Tab
        'title' => __('General'), // Tab title
        'sections' => [ // Tab Sections
            'general' => [ // Section
                'title' => '', // Section Title
                'fields' => [ // Section Fields
                    'icon' => [
                        'type' => 'icon',
                        'label' => __('Icon'),
                        'preview' => [
                            'type' => 'none',
                        ],
                    ],
                    'link' => [
                        'type' => 'link',
                        'label' => __('Link'),
                        'show_target' => true,
                        'show_nofollow' => true,
                        'connections' => ['url'],
                    ],
                    'download' => [
                        'type' => 'select',
                        'label' => __('Force Link to Download'),
                        'default' => 'no',
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No'),
                        ],
                    ],
                    'sr_text' => [
                        'type' => 'text',
                        'label' => __('Screen Reader Text'),
                        'default' => '',
                    ],
                ],
            ],
        ],
    ],
    'style' => [ // Tab
        'title' => __('Style'), // Tab title
        'sections' => [ // Tab Sections
            'structure' => [ // Section
                'title' => __('Icon'), // Section Title
                'fields' => [ // Section Fields
                    'size' => [
                        'type' => 'unit',
                        'label' => __('Size'),
                        'default' => '30',
                        'sanitize' => 'floatval',
                        'responsive' => true,
                        'units' => ['px', 'em', 'rem'],
                        'slider' => true,
                        'preview' => [
                            'type' => 'refresh',
                        ],
                    ],
                    'align' => [
                        'type' => 'align',
                        'label' => __('Alignment'),
                        'default' => 'left',
                        'responsive' => true,
                        'preview' => [
                            'type' => 'css',
                            'selector' => '{node}.fl-module-icon',
                            'property' => 'text-align',
                        ],
                    ],
                ],
            ],
            'colors' => [ // Section
                'title' => __('Icon Colors'), // Section Title
                'fields' => [ // Section Fields
                    'color' => [
                        'type' => 'color',
                        'connections' => ['color'],
                        'label' => __('Color'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'preview' => [
                            'type' => 'css',
                            'selector' => '.fl-icon i, .fl-icon i::before',
                            'property' => 'color',
                            'important' => true,
                        ],
                    ],
                    'hover_color' => [
                        'type' => 'color',
                        'connections' => ['color'],
                        'label' => __('Hover Color'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'preview' => [
                            'type' => 'css',
                            'selector' => '.fl-icon i:hover, .fl-icon i:hover::before',
                            'property' => 'color',
                            'important' => true,
                        ],
                    ],
                    'duo_color1' => [
                        'label' => __('DuoTone Icon Primary Color'),
                        'type' => 'color',
                        'connections' => ['color'],
                        'default' => '',
                        'show_reset' => true,
                        'show_alpha' => true,
                        'preview' => [
                            'type' => 'css',
                            'selector' => '.fl-icon i.fad:before',
                            'property' => 'color',
                            'important' => true,
                        ],
                    ],
                    'duo_color2' => [
                        'label' => __('DuoTone Icon Secondary Color'),
                        'type' => 'color',
                        'connections' => ['color'],
                        'default' => '',
                        'show_reset' => true,
                        'show_alpha' => true,
                        'preview' => [
                            'type' => 'css',
                            'selector' => '.fl-icon i.fad:after',
                            'property' => 'color',
                            'important' => true,
                        ],
                    ],
                    'bg_color' => [
                        'type' => 'color',
                        'connections' => ['color'],
                        'label' => __('Background Color'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ],
                    'bg_hover_color' => [
                        'type' => 'color',
                        'connections' => ['color'],
                        'label' => __('Background Hover Color'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'preview' => [
                            'type' => 'none',
                        ],
                    ],
                    'three_d' => [
                        'type' => 'select',
                        'label' => __('Gradient'),
                        'default' => '0',
                        'options' => [
                            '0' => __('No'),
                            '1' => __('Yes'),
                        ],
                    ],
                ],
            ],
        ],
    ],
]);

