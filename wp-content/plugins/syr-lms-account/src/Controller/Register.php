<?php

namespace Syr\Account\Controller;

use memberpress\courses\lib\Exception;

class Register extends Controller
{
    public function handle_registration()
    {
        if (! class_exists('MeprUtils')) {
            exit;
        }

        if($this->is_post_request() && isset($_POST['syr_process_signup_form'])) {

            $checkout_ctrl = \MeprCtrlFactory::fetch('checkout');
            $checkout_ctrl->process_signup_form();
        }
    }

    public function handle_redirects()
    {
        $user_id = isset($_REQUEST['user_id']) ? sanitize_text_field($_REQUEST['user_id']) : '';
        $_wpnonce = isset($_REQUEST['_wpnonce']) ? sanitize_text_field($_REQUEST['_wpnonce']) : '';

        if (is_page('verify-email')) {
            if (empty($user_id)) {
                wp_redirect(site_url('login'));
            }
        }

        if (is_page('register') && is_user_logged_in()) {
            wp_redirect(site_url());
        }
    }

    public function register_routes()
    {
        add_action('init', [$this, 'handle_registration']);
        add_action('wp', [$this, 'handle_redirects']);
    }
}