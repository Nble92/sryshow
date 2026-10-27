<?php

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

/**
 * Helper class for child theme functions.
 *
 * @class FLChildTheme
 */
final class FLChildTheme
{
    /**
     * Load the class instance.
     *
     * @var static Instance.
     */
    private static $instance = null;

    /**
     * Set the plugin instance
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        // Include Stylesheets
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts'], 1000);

        add_filter('fl_builder_color_presets', [$this, 'theme_colors']);
        add_filter('tiny_mce_before_init', [$this, 'add_colors_to_customizer']);

        // Custom Image Sizes
        // add_filter('after_theme_setup', [$this, 'custom_image_sizes']);
        add_filter('image_size_names_choose', [$this, 'custom_image_sizes_names']);
        add_filter('uabb_blog_posts_featured_image_sizes', [$this, 'custom_image_sizes_names']);

        // Theme Customizations
        add_filter( 'body_class',  [$this, 'add_slug_to_body_class'] );

        $this->theme_updater();
    }

    /**
     * Enqueues scripts and styles.
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style('fl-child-theme', FL_CHILD_THEME_URL . '/style.css');
        wp_enqueue_style('syr-lms', FL_CHILD_THEME_URL . '/assets/css/lms.css', [], time());

        if (class_exists('FLBuilderIcons')) {
            FLBuilderIcons::enqueue_all_custom_icons_styles();
        }
    }

    public function theme_colors()
    {
        $colors = [];

        $colors[] = 'B7925F'; /* --syr-primary */
        $colors[] = '513A4E'; /* --syr-secondary */

        $colors[] = '140F14'; /* --syr-shade-1 */
        $colors[] = 'FFEBFC'; /* --syr-shade-2 */
        $colors[] = 'FFF6EB'; /* --syr-shade-3 */
        $colors[] = '998D97'; /* --syr-shade-4 */
        $colors[] = 'FFFFFF'; /* --syr-shade-5 */

        $colors[] = '7C8A48'; /* --syr-calm-accent-1 */
        $colors[] = 'E5B333'; /* --syr-calm-accent-2 */
        $colors[] = 'FCC983'; /* --syr-calm-accent-3 */

        $colors[] = 'F23024'; /* --syr-vibrant-accent-1 */
        $colors[] = 'F27824'; /* --syr-vibrant-accent-2 */
        $colors[] = 'F2B524'; /* --syr-vibrant-accent-3 */

        return $colors;
    }

    public function add_colors_to_customizer($init)
    {
        $custom_colours = '
            "B7925F", "--syr-primary",
            "513A4E", "--syr-secondary",
    
            "140F14", "--syr-shade-1",
            "FFEBFC", "--syr-shade-2",
            "FFF6EB", "--syr-shade-3",
            "998D97", "--syr-shade-4",
            "FFFFFF", "--syr-shade-5",
    
            "7C8A48", "--syr-calm-accent-1",
            "E5B333", "--syr-calm-accent-2",
            "FCC983", "--syr-calm-accent-3",
    
            "F23024", "--syr-vibrant-accent-1",
            "F27824", "--syr-vibrant-accent-2",
            "F2B524", "--syr-vibrant-accent-3"
        ';

        // build colour grid default+custom colors
        $init['textcolor_map'] = '[' . $custom_colours . ']';

        // change the number of rows in the grid if the number of colors changes
        // 8 swatches per row
        $init['textcolor_rows'] = 1;

        return $init;
    }

    public function custom_image_sizes()
    {
        add_image_size('book-image', 356, 356);
        add_image_size('book-cat-icon', 24, 24);
    }

    public function custom_image_sizes_names($size_names)
    {
        return array_merge( $size_names, [
            'book-image' => 'Book Image',
            'video-thumbnail' => 'Video Thumbnail',
        ] );
    }

    public function theme_updater()
    {
        $updateChecker = PucFactory::buildUpdateChecker(
            'https://github.com/School-Yard-Rap/school-yard-rap-lms-theme',
            SYR_THEME_ABSOLUTE,
            'school-yard-rap-lms-theme',
        );

        $updateChecker->setAuthentication(GITHUB_ACCESS_TOKEN);
    }

    public function add_slug_to_body_class($classes)
    {
        global $wpdb, $post;

        if ( isset( $post ) ) {
            $classes[] = $post->post_type . '-' . $post->post_name;
        }

        if (is_page()) {
            if ($post->post_parent) {
                $post_ancestors = get_post_ancestors($post->ID);
                $parent = end($post_ancestors);
            } else {
                $parent = $post->ID;
            }
            $post_data = get_post($parent, ARRAY_A);
            $classes[] = 'parent-' . $post_data['post_name'];
        }

        return $classes;
    }
}

FLChildTheme::get_instance();