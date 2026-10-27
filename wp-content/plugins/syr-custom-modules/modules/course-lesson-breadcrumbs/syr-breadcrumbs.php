<?php

class syrBreadcrumbs extends FLBuilderModule
{
    /**
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct([
            'name' => __('Course/Lesson Breadcrumbs'),
            'description' => __('Breadcrumbs for the singular lesson view.'),
            'category' => __('Course/Lesson'),
            'group' => 'SYR Modules',
            'dir' => SYR_MODULES_DIR . 'modules/course-lesson-breadcrumbs/',
            'url' => SYR_MODULES_URL . 'modules/course-lesson-breadcrumbs/',
            'partial_refresh' => true,
        ]);
    }
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('syrBreadcrumbs', []);