<?php

class syrCustomHeader extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(
            [
                'name' => __('SYR Header'),
                'description' => __('SYR Header'),
                'category' => __('Basic'),
                'group' => 'SYR Modules',
                'dir' => SYR_MODULES_DIR . 'modules/header/',
                'url' => SYR_MODULES_URL . 'modules/header/',
                'editor_export' => true, // Defaults to true and can be omitted.
                'icon' => 'schedule.svg',
            ]
        );
    }
}

FLBuilder::register_module('syrCustomHeader', []);
