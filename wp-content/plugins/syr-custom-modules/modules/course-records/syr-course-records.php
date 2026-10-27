<?php

class syrCourseRecords extends FLBuilderModule
{

    /**
     * Variable for editor
     *
     * @var null $_editor
     */
    protected $_editor = null; // phpcs:ignore PSR2.Classes.PropertyDeclaration.Underscore

    /**
     * Variable for UABB args
     *
     * @var array $uabb_args
     */
    protected $uabb_args = [];

    /**
     * Constructor function that constructs default values for the Advanced Posts module.
     *
     * @method __construct
     */
    public function __construct()
    {

        parent::__construct(
            [
                'name' => __('Course Records'),
                'description' => __('Display records in a course using the advanced posts module.'),
                'category' => 'Course',
                'group' => 'SYR Modules',
                'dir' => SYR_MODULES_DIR . 'modules/course-records/',
                'url' => SYR_MODULES_URL . 'modules/course-records/',
                'editor_export' => true, // Defaults to true and can be omitted.
                'enabled' => true, // Defaults to true and can be omitted.
                'partial_refresh' => true,
            ]
        );
        $this->add_css('font-awesome-5');
        add_filter('wp_footer', [$this, 'enqueue_scripts']);
        add_filter('fl_builder_loop_query_args', [$this, 'uabb_loop_query_args'], 1);
        add_action('template_redirect', [$this, 'uabb_posts_template_redirect'], 0);
    }

    /**
     * Handle redirection on single post pages when using pagination.
     *
     * @since x.x.x
     */
    public function uabb_posts_template_redirect()
    {
        if (is_singular()) {
            global $wp_query;
            if ($wp_query->is_paged()) {
                remove_action('template_redirect', 'redirect_canonical');
            }
        }
    }

    /**
     * Function that updates the rewrite rules.
     *
     * @param object $settings gets an object for the settings.
     * @since 1.10.7
     */
    public function update($settings)
    {
        global $wp_rewrite;
        $wp_rewrite->flush_rules(false); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.flush_rules_flush_rules
        return $settings;
    }

    /**
     * Mutator function to update $uabb_args
     *
     * @method Mutator function to update $uabb_args
     * @param array $args gets an array of arguments.
     */
    public function set_uabb_args($args)
    {
        $this->uabb_args = $args;
    }

    /**
     * Accessor function to get $uabb_args
     *
     * @method Accessor function to get $uabb_args
     * @public
     */
    public function get_uabb_args()
    {
        return $this->uabb_args;
    }

    /**
     * Filter to modify WP Query args
     *
     * @method Filter to modify WP Query args
     * @public
     * @param array $args gets an array of args.
     */
    public function uabb_loop_query_args($args)
    {
        if (is_array($args) && is_array($this->uabb_args)) {
            $args = array_merge($args, $this->uabb_args);
        }

        return $args;
    }

    /**
     * Filter to enqueue scripts
     */
    public function enqueue_scripts()
    {
         $this->add_js('carousel', BB_ULTIMATE_ADDON_URL . 'assets/js/global-scripts/jquery-carousel.js', ['jquery'], '', true);
    }

    /**
     * Function that renders args for pagination.
     *
     * @method render_args
     */
    public function render_args()
    {
        global $post;

        add_filter('fl_builder_loop_query_args', [$this, 'uabb_loop_query_args']);

        $args['post_type'] = 'mpcs-lesson';
        $args['order'] = 'ASC';
        $args['orderby'] = 'meta_value_num';
        $args['order_by_meta_key'] = '_mpcs_lesson_lesson_order';
        $args['posts_per_page'] = '10';

        if ('mpcs-lesson' === $post->post_type) {
            $args['post__in'] = syrMemberPressCourse::getLessonsInCourseByLesson(get_the_ID());
        } else {
            $args['post__in'] = syrMemberPressCourse::getLessonsInCourseByCourse(get_the_ID());
        }

        return $args;
    }
}

require_once SYR_MODULES_DIR . 'modules/course-records/settings.php';
