<?php
/*
 * Plugin Name: SYR Account
 * Plugin URI:
 * Description: Backend plugin to handle accounts for the School Yard Rap LMS.
 * Version: 1..7.0
 * Requires PHP: 8.0
 * Author: Tunji Ayoola
 * Author URI: https://www.toptal.com/resume/tunji-ayoola
 * License: MIT
 * Text Domain: syr-lms
 */

namespace Syr\Account;

define( 'SYR_ACCOUNT_PLUGIN_ABSOLUTE', __FILE__ );

if (!class_exists(Account::class) && is_readable(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

class_exists(Account::class) && Account::instance();
