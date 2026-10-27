<?php

class syrCourseBookmark extends FLBuilderModule
{
    /**
     * @property $data
     */
    public $data = [];

    /**
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct([
            'name' => __('Course Bookmark Link'),
            'description' => __('Render a link to start and navigate course.'),
            'category' => __('Course Archive'),
            'group' => 'SYR Modules',
            'dir' => SYR_MODULES_DIR . 'modules/course-bookmark/',
            'url' => SYR_MODULES_URL . 'modules/course-bookmark/',
            'partial_refresh' => true,
        ]);
    }

    public function get_data()
    {
        if (! empty($this->data)) {
            return $this->data;
        }

        $this->data = syrMemberPressCourse::get_next_lesson_for_bookmark();

        return $this->data;
    }
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('syrCourseBookmark', []);