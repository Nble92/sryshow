<?php
/*
 * Plugin Name: SYR Custom Modules
 * Plugin URI:
 * Description: Custom Beaver Builder modules for School Yard Rap
 * Version: 1.20.1
 * Requires PHP: 8.0
 * Author: Tunji Ayoola
 * Author URI: https://www.toptal.com/resume/tunji-ayoola
 * License: MIT
 */

define( 'SYR_MODULES_DIR', plugin_dir_path( __FILE__ ) );
define( 'SYR_MODULES_URL', plugins_url( '/', __FILE__ ) );

require 'lib/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

require SYR_MODULES_DIR . 'classes/syrScripts.php';
require SYR_MODULES_DIR . 'classes/MemberPressCourse.php';

add_action( 'init', function () {
    if (class_exists('FLBuilder')) {
        require SYR_MODULES_DIR . 'modules/header/syr-header.php';
        require SYR_MODULES_DIR . 'modules/video/syr-video.php';
        require SYR_MODULES_DIR . 'modules/featured-post/syr-featured-post.php';
        require SYR_MODULES_DIR . 'modules/course-bookmark/course-bookmark.php';
        require SYR_MODULES_DIR . 'modules/video-clone/syr-video-clone.php';
        require SYR_MODULES_DIR . 'modules/course-lesson-breadcrumbs/syr-breadcrumbs.php';
        require SYR_MODULES_DIR . 'modules/lesson-spotlight/syr-lesson-spotlight.php';
        require SYR_MODULES_DIR . 'modules/search/syr-search.php';
        require SYR_MODULES_DIR . 'modules/language-switcher/syr-switcher.php';
        require SYR_MODULES_DIR . 'modules/course-lessons/syr-course-lessons.php';
        require SYR_MODULES_DIR . 'modules/records-archive/syr-records-archive.php';
        require SYR_MODULES_DIR . 'modules/records-display/syr-records-display.php';
        require SYR_MODULES_DIR . 'modules/template-loader/syr-template-loader.php';
        require SYR_MODULES_DIR . 'modules/course-progress/syr-course-progress.php';
        require SYR_MODULES_DIR . 'modules/song-play/syr-song-play.php';
        require SYR_MODULES_DIR . 'modules/spotlight-audio-play/syr-spotlight-audio-play.php';
        require SYR_MODULES_DIR . 'modules/course-records/syr-course-records.php';
        require SYR_MODULES_DIR . 'modules/course-records-display-slidder/syr-course-records-display-slidder.php';
        require SYR_MODULES_DIR . 'modules/lesson-video/syr-lesson-video.php';
        require SYR_MODULES_DIR . 'modules/icon/syr-icon.php';
    }
});

$updateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/School-Yard-Rap/syr-custom-modules',
    __FILE__,
    'syr-custom-modules',
);

$updateChecker->setAuthentication(GITHUB_ACCESS_TOKEN);
