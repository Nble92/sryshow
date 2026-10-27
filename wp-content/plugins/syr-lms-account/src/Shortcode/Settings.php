<?php

namespace Syr\Account\Shortcode;

use DecodeLabs\Tagged as HTML;

class Settings extends Shortcode
{
    public string $tag = 'syr_settings';

    public function render($atts = [], $content = null)
    {
        return HTML::{'div.syr-settings-form#syr-settings-form'}();
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('syr-settings-css', plugins_url("dist/css/settings.css", SYR_ACCOUNT_PLUGIN_ABSOLUTE));
        wp_enqueue_script('syr-manifest-js', plugins_url("dist/js/manifest.js", SYR_ACCOUNT_PLUGIN_ABSOLUTE), [], '', true);
        wp_enqueue_script('syr-vendor-js', plugins_url("dist/js/vendor.js", SYR_ACCOUNT_PLUGIN_ABSOLUTE), [], '', true);
        wp_enqueue_script('syr-settings-js', plugins_url("dist/js/settings.js", SYR_ACCOUNT_PLUGIN_ABSOLUTE), ['syr-manifest-js', 'syr-vendor-js'], '', true);
    }
}