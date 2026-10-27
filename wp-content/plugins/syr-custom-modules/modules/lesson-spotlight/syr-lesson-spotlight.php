<?php

class syrLessonSpotlight extends FLBuilderModule
{
    /**
     * @property $data
     */
    public $data = [];

    public function __construct()
    {
        parent::__construct(
            [
                'name' => __('SYR Lesson Spotlight'),
                'description' => __('SYR Header'),
                'category' => __('Lesson'),
                'group' => 'SYR Modules',
                'dir' => SYR_MODULES_DIR . 'modules/lesson-spotlight/',
                'url' => SYR_MODULES_URL . 'modules/lesson-spotlight/',
                'editor_export' => true, // Defaults to true and can be omitted.
            ]
        );
    }

    /**
     * @method get_data
     */
    public function get_data()
    {
        $this->data = get_field('spotlight') ?? [];

        return $this->data;
    }
}

FLBuilder::register_module('syrLessonSpotlight', []);
