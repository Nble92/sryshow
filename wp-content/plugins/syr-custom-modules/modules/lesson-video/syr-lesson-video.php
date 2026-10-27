<?php

/**
 * Lesson Video Modal Module
 */
class syrLessonVideo extends FLBuilderModule
{
    public $cloudinaryCloudName = 'dcy1fqf4w';

    public function __construct()
    {
        parent::__construct([
            'name' => __('Lesson Video'),
            'description' => __('Lesson Video'),
            'category' => 'Lesson',
            'group' => 'SYR Modules',
            'dir' => SYR_MODULES_DIR . 'modules/lesson-video/',
            'url' => SYR_MODULES_URL . 'modules/lesson-video/',
            'icon' => 'button.svg',
        ]);

        // Include CSS/JS
        $this->add_css('font-awesome-5');
        $this->add_js('jquery-fitvids');
        $this->add_js('uabbpopup-cookies', $this->url . 'js/js_cookie.js', [], '', true);
        $this->add_css('cloudinary-video-player', 'https://cdnjs.cloudflare.com/ajax/libs/cloudinary-video-player/2.1.0/cld-video-player.min.css');
        $this->add_js('cloudinary-video-player', 'https://cdnjs.cloudflare.com/ajax/libs/cloudinary-video-player/2.1.0/cld-video-player.min.js');

        // Ajax for lesson completion
        add_action('wp_ajax_mark_lesson_as_completed', [$this, 'mark_lesson_as_completed']);
        add_action('wp_ajax_nopriv_mark_lesson_as_completed', [$this, 'mark_lesson_as_completed']);
    }

    /**
     * Calculate modal width and height
     */
    public function get_width_height()
    {
        $size = ['width' => '', 'height' => ''];

        if (!empty($this->settings->modal_width) && is_numeric($this->settings->modal_width)) {
            $size['width'] = $this->settings->modal_width;
            $size['height'] = ($this->settings->video_ratio === '16_9')
                ? ($size['width'] / 16) * 9
                : ($size['width'] / 4) * 3;
        }

        return $size;
    }

    /**
     * Get video for a specific lesson
     */
    public function get_video($lesson_id = null)
    {
        if (!$lesson_id) {
            global $post;
            $lesson_id = $post->ID ?? 0;
        }

        if (!$lesson_id) return false;

        $lesson_post = get_post($lesson_id);
        if (!$lesson_post || $lesson_post->post_type !== 'mpcs-lesson') return false;

        return get_post_meta($lesson_id, 'cloudinary_video_id', true);
    }

    /**
     * Cloudinary cloud name
     */
    public function getCloudName()
    {
        if (empty($this->cloudinaryCloudName)) {
            $this->cloudinaryCloudName = get_field('cloudinary_cloud_name', 'option');
        }
        return $this->cloudinaryCloudName;
    }

    /**
     * Mark lesson as completed (AJAX)
     */
    public function mark_lesson_as_completed()
    {
        if (isset($_POST['security']) && wp_verify_nonce(sanitize_text_field($_POST['security']), 'lesson-completed-nonce')) {
            $lesson_id = isset($_POST['lesson']) ? sanitize_text_field($_POST['lesson']) : false;
            if ($lesson_id) {
                $lesson = \memberpress\courses\models\Lesson::find($lesson_id);
                $lesson->complete(get_current_user_id());
                wp_send_json_success('DONE');
            }
        }
        wp_send_json_error();
    }
}

// Load settings
require_once SYR_MODULES_DIR . 'modules/lesson-video/settings.php';
