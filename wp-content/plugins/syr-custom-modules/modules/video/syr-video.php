<?php

class syrVideoModule extends FLBuilderModule
{
    /**
     * @property $data
     */
    public $data = null;

    /**
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct([
            'name' => __('SYR Video'),
            'description' => __('Render a WordPress video.'),
            'category' => __('Basic'),
            'group' => 'SYR Modules',
            'dir' => SYR_MODULES_DIR . 'modules/video/',
            'url' => SYR_MODULES_URL . 'modules/video/',
            'partial_refresh' => true,
            'icon' => 'format-video.svg',
        ]);

        $this->add_js('jquery-fitvids');

        add_filter('wp_video_shortcode', __CLASS__ . '::mute_video', 10, 4);
    }

    /**
     * @method get_data
     */
    public function get_data()
    {
        if (!$this->data) {

            $this->data = FLBuilderPhoto::get_attachment_data($this->settings->video);

            if (!$this->data && isset($this->settings->data)) {
                $this->data = $this->settings->data;
            }
            if ($this->data) {
                $parts = explode('.', $this->data->filename);
                $this->data->extension = array_pop($parts);
                $this->data->poster = isset($this->settings->poster_src) ? $this->settings->poster_src : '';
                $this->data->loop = isset($this->settings->loop) && $this->settings->loop ? ' loop="yes"' : '';
                $this->data->autoplay = isset($this->settings->autoplay) && $this->settings->autoplay ? ' autoplay="yes"' : '';
            }
        }

        return $this->data;
    }

    /**
     * @since 2.4
     * @method render_poster_html
     */
    public function render_video_html($schema)
    {
        $video_html = '';
        $video_poster = $this->get_poster_url();
        $video_meta = '';

        $vid_data = $this->get_data();
        $preload = FLBuilderModel::is_builder_active() && !empty($vid_data->poster) ? ' preload="none"' : '';

        $video_meta .= '<meta itemprop="url" content="' . (empty($vid_data->url) ? '' : $vid_data->url) . '" />';
        if ($schema) {
            $video_meta .= '<meta itemprop="thumbnail" content="' . $video_poster . '" />';
        }

        $video_html = $video_meta;

        $video_sc = sprintf('%s', __('Video not specified. Please select one to display.'));

        if (!empty($vid_data->url)) {
            $video_sc = '[video ' . $vid_data->extension . '="' . preg_replace('/\/?\?.*/', '', $vid_data->url) . '"' . ' poster="' . $video_poster . '" ' . $vid_data->autoplay . $vid_data->loop . $preload . '][/video]';
        }

        if ('yes' === $this->settings->video_lightbox) {
            $video_html .= '<div id="fl-node-' . $this->node . '-lightbox-content" class="fl-node-' . $this->node . '-lightbox-content' . ' syr-wp-video-lightbox-content ' . (empty($vid_data->url) ? '' : 'mfp-hide') . '">';
            $video_html .= $video_sc;
            $video_html .= '</div>';
        } else {
            $video_html .= $video_sc;
        }

        echo $video_html;
    }

    /**
     * @since 2.4
     * @method render_poster_html
     */
    public function render_poster_html()
    {
        $poster_html = '';
        if ('yes' === $this->settings->video_lightbox) {
            $poster_url = $this->get_poster_url();
            if (empty($poster_url)) {
                $poster_html .= '<div class="syr-wp-video-poster">';
                $poster_html .= sprintf('%s', __('Please specify a poster image if Video Lightbox is enabled.'));
                $poster_html .= '</div>';
            } else {
                $video_url = $this->get_video_url();
                $size = isset($this->settings->poster_size) && !empty($this->settings->poster_size) ? $this->settings->poster_size : 'large';
                $poster_html .= '<div class="syr-wp-video-poster" data-mfp-src="' . $video_url . '">';
                $poster_html .= wp_get_attachment_image($this->settings->poster, $size, '', ['class' => 'img-responsive']);
                $poster_html .= '</div>';
            }
        }

        echo $poster_html;
    }

    /**
     * @since 2.4
     * @method get_poster_url
     */
    private function get_poster_url()
    {
        $url = empty($this->settings->poster) ? '' : $this->settings->poster_src;
        return $url;
    }

    /**
     * @since 2.4
     * @method get_video_url
     */
    private function get_video_url()
    {
        $settings = $this->settings;
        $video_url = '';

        if ('yes' === $settings->video_lightbox) {
            $vid_data = $this->get_data();
            $video_url = !empty($vid_data->url) ? $vid_data->url : '';
        }

        return $video_url;
    }

    /**
     * @method update
     * @param $settings {object}
     */
    public function update($settings)
    {
        $video = FLBuilderPhoto::get_attachment_data($settings->video);

        if ($video) {
            $settings->data = $video;
        } else {
            $settings->data = null;
        }

        return $settings;
    }

    /**
     * Temporary fix for autoplay in Chrome & Safari. Video shortcode doesn't support `muted` parameter.
     * Bug report: https://core.trac.wordpress.org/ticket/42718.
     *
     * @param string $output Video shortcode HTML output.
     * @param array $atts Array of video shortcode attributes.
     * @param string $video Video file.
     * @param int $post_id Post ID.
     * @return string
     * @since 2.1.3
     */
    static public function mute_video($output, $atts, $video, $post_id)
    {
        if (false !== strpos($output, 'autoplay="1"') && FLBuilderModel::get_post_id() == $post_id) {
            $output = str_replace('<video', '<video muted', $output);
        }
        return $output;
    }

    /**
     * Calculate video aspect ratio for style.
     *
     * @return float
     * @since 2.2
     */
    public function video_aspect_ratio()
    {
        $data = $this->get_data();
        if ($data && function_exists('bcdiv') && isset($data->width) && isset($data->height) && ((int)$data->height > 0) && ((int)$data->width > 0)) {
            $ratio = ($data->height / $data->width) * 100;
            return bcdiv($ratio, 1, 2);
        }
    }

    /**
     * Returns structured data markup.
     * @since 2.2
     */
    public function get_structured_data()
    {
        $settings = $this->settings;

        if ('yes' != $settings->schema_enabled) {
            return false;
        }

        $markup = '';
        if (!empty($settings->name)) {
            $markup .= sprintf('<meta itemprop="name" content="%s" />', esc_attr($settings->name));
        }
        if (!empty($settings->up_date)) {
            $markup .= sprintf('<meta itemprop="uploadDate" content="%s" />', esc_attr(gmdate(DATE_ATOM, strtotime($settings->up_date))));
        }
        if (!empty($settings->thumbnail_src)) {
            $markup .= sprintf('<meta itemprop="thumbnailUrl" content="%s" />', $settings->thumbnail_src);
        }
        if (!empty($settings->description)) {
            $markup .= sprintf('<meta itemprop="description" content="%s" />', esc_attr($settings->description));
        }
        if (!empty($settings->content_url)) {
            $markup .= sprintf('<meta itemprop="contentUrl" content="%s" />', esc_attr($settings->content_url));
        }

        return $markup;
    }

    /**
     * @method enqueue_scripts
     * @since 2.4
     */
    public function enqueue_scripts()
    {
        if ($this->settings && 'yes' == $this->settings->video_lightbox) {
            $this->add_js('jquery-magnificpopup');
            $this->add_css('jquery-magnificpopup');
        }
    }
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('syrVideoModule', [
    'general' => [
        'title' => __('General'),
        'sections' => [
            'general' => [
                'title' => '',
                'fields' => [
                    'video' => [
                        'type' => 'video',
                        'label' => __('Video (MP4)'),
                        'help' => __('A video in the MP4 format. Most modern browsers support this format.'),
                        'connections' => ['custom_field'],
                        'show_remove' => true,
                    ],
                    'video_lightbox' => [
                        'type' => 'select',
                        'label' => __('Show Video on Lightbox'),
                        'default' => 'no',
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No'),
                        ],
                        'help' => __('Poster Image must be specified for the Lightbox to work.'),
                    ],
                    'poster' => [
                        'type' => 'photo',
                        'show_remove' => true,
                        'connections' => ['photo', 'url'],
                        'label' => _x('Poster', 'Video preview/fallback image.'),
                        'help' => __('An image must be specified for the Lightbox to work.'),
                    ],
                    'autoplay' => [
                        'type' => 'select',
                        'label' => __('Auto Play'),
                        'default' => '0',
                        'options' => [
                            '0' => __('No'),
                            '1' => __('Yes'),
                        ],
                        'preview' => [
                            'type' => 'none',
                        ],
                    ],
                    'loop' => [
                        'type' => 'select',
                        'label' => __('Loop'),
                        'default' => '0',
                        'options' => [
                            '0' => __('No'),
                            '1' => __('Yes'),
                        ],
                        'preview' => [
                            'type' => 'none',
                        ],
                    ],
                    'sticky_on_scroll' => [
                        'type' => 'select',
                        'label' => __('Sticky on Scroll'),
                        'default' => 'no',
                        'options' => [
                            'no' => __('No'),
                            'yes' => __('Yes'),
                        ],
                        'preview' => [
                            'type' => 'none',
                        ],
                    ],
                ],
            ],
            'video_controls_section' => [
                'title' => 'Video Controls',
                'fields' => [
                    'play_pause' => [
                        'type' => 'select',
                        'label' => __('Play/Pause'),
                        'default' => 'show',
                        'options' => [
                            'show' => __('Show'),
                            'hide' => __('Hide'),
                        ],
                    ],
                    'timer' => [
                        'type' => 'select',
                        'label' => __('Timer'),
                        'default' => 'show',
                        'options' => [
                            'show' => __('Show'),
                            'hide' => __('Hide'),
                        ],
                    ],
                    'time_rail' => [
                        'type' => 'select',
                        'label' => __('Time Rail'),
                        'default' => 'show',
                        'options' => [
                            'show' => __('Show'),
                            'hide' => __('Hide'),
                        ],
                    ],
                    'duration' => [
                        'type' => 'select',
                        'label' => __('Duration'),
                        'default' => 'show',
                        'options' => [
                            'show' => __('Show'),
                            'hide' => __('Hide'),
                        ],
                    ],
                    'volume' => [
                        'type' => 'select',
                        'label' => __('Volume'),
                        'default' => 'show',
                        'options' => [
                            'show' => __('Show'),
                            'hide' => __('Hide'),
                        ],
                    ],
                    'full_screen' => [
                        'type' => 'select',
                        'label' => __('Fullscreen'),
                        'default' => 'show',
                        'options' => [
                            'show' => __('Show'),
                            'hide' => __('Hide'),
                        ],
                    ],
                ],
            ],
        ],
    ],
    'schema' => [
        'title' => 'Structured Data',
        'sections' => [
            'schema' => [
                'fields' => [
                    'schema_enabled' => [
                        'type' => 'select',
                        'label' => __('Enable Structured Data?'),
                        'default' => 'no',
                        'preview' => [
                            'type' => 'none',
                        ],
                        'toggle' => [
                            'yes' => [
                                'fields' => ['name', 'description', 'thumbnail', 'up_date', 'content_url'],
                            ],
                        ],
                        'options' => [
                            'yes' => __('Yes'),
                            'no' => __('No'),
                        ],
                    ],
                    'name' => [
                        'type' => 'text',
                        'label' => __('Video Name'),
                        'connections' => ['string'],
                        'preview' => [
                            'type' => 'none',
                        ],
                    ],
                    'description' => [
                        'type' => 'text',
                        'label' => __('Video Description'),
                        'connections' => ['string'],
                        'preview' => [
                            'type' => 'none',
                        ],
                    ],
                    'content_url' => [
                        'type' => 'text',
                        'label' => __('Content URL'),
                        'connections' => ['url'],
                        'preview' => [
                            'type' => 'none',
                        ],
                    ],
                    'thumbnail' => [
                        'type' => 'photo',
                        'label' => __('Video Thumbnail'),
                        'connections' => ['photo', 'url'],
                        'show_remove' => true,
                        'preview' => [
                            'type' => 'none',
                        ],
                    ],
                    'up_date' => [
                        'type' => 'date',
                        'label' => __('Upload Date'),
                        'connections' => ['string'],
                        'preview' => [
                            'type' => 'none',
                        ],
                    ],
                ],
            ],
        ],
    ],
]);
