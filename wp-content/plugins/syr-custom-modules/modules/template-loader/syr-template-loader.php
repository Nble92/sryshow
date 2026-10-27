<?php


class syrTemplateLoader extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(
            [
                'name' => __('Template Loader'),
                'description' => __('Module to load saved beaver builder templates.'),
                'category' => __('Advanced'),
                'group' => 'SYR Modules',
                'dir' => SYR_MODULES_DIR . 'modules/template-loader/',
                'url' => SYR_MODULES_URL . 'modules/template-loader/',
            ]
        );
    }

    public function get_next_lesson()
    {
        return syrMemberPressCourse::get_next_lesson_from_course_of_the_month();
    }
}

FLBuilder::register_module('syrTemplateLoader', [
    'general' => [
        'title' => __('General'),
        'sections' => [
            'general' => [
                'title' => '',
                'fields' => [
                    'template' => [
                        'type' => 'text',
                        'label' => __('Enter template id.'),
                        'default' => '',
                        'sanitize' => 'sanitize_title_with_dashes'
                    ],
                ],
            ],
        ],
    ],
]);
