<?php

class syrFeaturedPost extends FLBuilderModule
{
    /**
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct([
            'name' => __('Featured Lesson/Course'),
            'description' => __('Display a featured lesson or course'),
            'category' => __('Course Archive'),
            'group' => 'SYR Modules',
            'dir' => SYR_MODULES_DIR . 'modules/featured-post/',
            'url' => SYR_MODULES_URL . 'modules/featured-post/',
            'partial_refresh' => true,
            'icon' => 'schedule.svg',
        ]);
    }

    public function get_post()
    {
        $selected_post = match ($this->settings->featured) {
            'mpcs-lesson' => get_field('lesson_of_the_week', 'option'),
            'mpcs-course' => get_field('course_of_the_month', 'option'),
            default => null,
        };

        if (! empty($selected_post)) {
            return get_post($selected_post);
        }

        $args = [
            'post_type' => $this->settings->featured,
            'posts_per_page' => 1,
        ];

        $posts = get_posts($args);

        if (count($posts) > 0) {
            return get_post($posts[0]);
        }

        return null;
    }

    public function get_course_lesson_count($post)
    {
        return syrMemberPressCourse::getCourseLessonCount($post);
    }

    public function get_lesson_video_duration($post)
    {
        return syrMemberPressCourse::getLessonVideoDuration($post);
    }

    public function get_course_total_time($post)
    {
        return syrMemberPressCourse::getCourseTotalTime($post);
    }

    public function get_tag($post)
    {
        return match ($post->post_type) {
            'mpcs-lesson' => __('LESSON OF THE WEEK'),
            'mpcs-course' => __('COURSE OF THE MONTH'),
        };
    }
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('syrFeaturedPost', [
    'general' => [
        'title' => __('General'),
        'sections' => [
            'general' => [
                'title' => '',
                'fields' => [
                    'featured' => [
                        'type' => 'select',
                        'label' => __('Select Featured Post to Show'),
                        'default' => 'mpcs-lesson',
                        'options' => [
                            'mpcs-lesson' => __('Lesson'),
                            'mpcs-course' => __('Course'),
                        ],
                    ],
                ],
            ],
        ],
    ],
]);