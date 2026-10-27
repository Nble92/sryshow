<?php

class syrLanguageSwitcher extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(
            [
                'name' => __('Language Switcher'),
                'description' => __('Language Switcher'),
                'category' => __('Basic'),
                'group' => 'SYR Modules',
                'dir' => SYR_MODULES_DIR . 'modules/language-switcher/',
                'url' => SYR_MODULES_URL . 'modules/language-switcher/',
                'editor_export' => true, // Defaults to true and can be omitted.
            ]
        );
    }
}

FLBuilder::register_module('syrLanguageSwitcher', []);
