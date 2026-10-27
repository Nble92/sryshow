<?php

namespace Syr\Account;

use Syr\Account\Controller\Register as RegisterController;
use Syr\Account\Shortcode\Register;
use Syr\Account\Shortcode\Settings;
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

final class Account
{
    public static function instance()
    {
        static $instance;

        if (! $instance) {
            $instance = new self();
            $instance->init();
        }

        return $instance;
    }

    public function init()
    {
        if (wp_installing()) {
            return;
        }

        $this->pluginUpdater();

        /* Shortcodes */
        (new Register())->register();
        (new Settings())->register();

        /* Route Handler */
        (new RegisterController())->register_routes();
    }

    public function pluginUpdater()
    {
        $updateChecker = PucFactory::buildUpdateChecker(
            'https://github.com/School-Yard-Rap/syr-lms-account',
            SYR_ACCOUNT_PLUGIN_ABSOLUTE,
            'syr-lms-account',
        );

        $updateChecker->setAuthentication(GITHUB_ACCESS_TOKEN);
        $updateChecker->getVcsApi()->enableReleaseAssets('/syr-lms-account\.zip($|[?&#])/i');
    }
}