<?php

namespace Syr\Account\Shortcode;

use DecodeLabs\Tagged as HTML;

class Register extends Shortcode
{
    public string $tag = 'syr_registration';

    public function render($atts = [], $content = null)
    {
        return HTML::{'div.syr-register-form#syr-register-form'}();
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('syr-registration-css', plugins_url("dist/css/register.css", SYR_ACCOUNT_PLUGIN_ABSOLUTE));
        wp_enqueue_script('syr-manifest-js', plugins_url("dist/js/manifest.js", SYR_ACCOUNT_PLUGIN_ABSOLUTE), [], '', true);
        wp_enqueue_script('syr-vendor-js', plugins_url("dist/js/vendor.js", SYR_ACCOUNT_PLUGIN_ABSOLUTE), [], '', true);
        wp_enqueue_script('syr-registration-js', plugins_url("dist/js/register.js", SYR_ACCOUNT_PLUGIN_ABSOLUTE), ['syr-manifest-js', 'syr-vendor-js', 'jquery', 'wp-api'], '', true);
        wp_localize_script('syr-registration-js', 'syr_registration', [
            'assetUrl' => plugins_url('dist/images/profile/', SYR_ACCOUNT_PLUGIN_ABSOLUTE),
            'avatarCheckAssetUrl' => plugins_url('dist/images/profile/avatar-check.png', SYR_ACCOUNT_PLUGIN_ABSOLUTE),
            'submitAction' => esc_url(wp_unslash($_SERVER['REQUEST_URI']) . '#mepr_jump'),
            'basicMembershipId' => $this->get_basic_membership_id(),
            'avatars' => [
                plugins_url('dist/images/profile/av1.png', SYR_ACCOUNT_PLUGIN_ABSOLUTE),
                plugins_url('dist/images/profile/av2.png', SYR_ACCOUNT_PLUGIN_ABSOLUTE),
                plugins_url('dist/images/profile/av3.png', SYR_ACCOUNT_PLUGIN_ABSOLUTE),
                plugins_url('dist/images/profile/av4.png', SYR_ACCOUNT_PLUGIN_ABSOLUTE),
            ],
            'errors' => $_POST['errors'] ?? '',
        ]);
    }

    public function get_basic_membership_id()
    {
        $membership_name = 'basic';

        $args = [
            'name' => $membership_name,
            'post_type' => 'memberpressproduct',
            'post_status' => 'publish',
            'fields' => 'ids',
        ];

        $posts = get_posts($args);

        return $posts[0];
    }
}