<?php

use memberpress\courses\lib\Utils;
use memberpress\courses\models\Course;
use memberpress\courses\models\Lesson;
use memberpress\courses\models\UserProgress;

class syrMemberPressCourse
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
        /* Shortcodes */
        add_shortcode('course-lesson-count', [$this, 'courseLessonCountShortcode']);
        add_shortcode('course-total-time', [$this, 'courseTotalTimeShortcode']);
        add_shortcode('lesson-excerpt', [$this, 'lessonExcerptShortcode']);
        add_shortcode('lesson-plan', [$this, 'lessonPlanShortcode']);
        add_shortcode('worksheet', [$this, 'worksheetShortcode']);

        /* Actions */
        // add_action('save_post_mpcs-lesson', [$this, 'updateLessonVideoLength']);

        /* TODO: test pre_get_posts instead */
        // add_action('pre_get_posts', [$this, 'load_lesson_in_dashboard']);
    }

    public static function get_next_lesson_for_bookmark()
    {
        global $post;

        $lesson_title = '';
        $bookmark_url = '';
        $current_user_id = 0;

        if(!is_single()) {
            return '';
        }

        if(is_user_logged_in()) {
            $current_user = Utils::get_currentuserinfo();
            $current_user_id = $current_user->ID;
        }

        $course = new Course($post->ID);

        $lesson = UserProgress::next_lesson($current_user_id, $course->ID);

        if($lesson!==false && is_object($lesson)) {
            $lesson_title = $lesson->post_title;
            $bookmark_url = get_permalink($lesson->ID);
        }

        $has_started_course = UserProgress::has_started_course($current_user_id, $course->ID);

        return compact('lesson_title', 'bookmark_url', 'has_started_course');
    }

    public static function getCourseLessonCount(WP_Post $post)
    {
        if ($course = Course::find($post->ID)) {
            return $course->number_of_lessons();
        }

        return false;
    }

    public static function getLessonVideoDuration(Lesson|WP_Post $post)
    {
        if ('mpcs-lesson' !== $post->post_type) {
            return false;
        }

        $video_id = get_post_meta($post->ID, 'video', true);
        $video_meta = get_post_meta($video_id, '_wp_attachment_metadata', true);

        if (!$video_meta || !is_array($video_meta) || !isset($video_meta['length'])) {
            return false; // or return 0; depending on your logic
        }

        return round($video_meta['length'] / 60);
    }

    public static function get_next_lesson_from_course_of_the_month()
    {
        add_filter('the_content', '__return_empty_string');

        $course_id = get_field('course_of_the_month', 'option');
        $course = Course::find($course_id);
        $lesson = false;

        if ($course) {
            $lesson = \memberpress\courses\models\UserProgress::next_lesson(get_current_user_id(), $course->ID);
        }

        if ($lesson) {
            return $lesson;
        }

        $args = [
            'post_type' => 'mpcs-lesson',
            'posts_per_page' => 1,
        ];

        $posts = get_posts($args);

        if (count($posts) > 0) {
            return $posts[0];
        }

        return $lesson;
    }

    public static function getCourseTotalTime(WP_Post $post)
    {
        if ($course = Course::find($post->ID)) {
            $lessons = $course->lessons();
            $video_duration = array_map(fn($lesson) => self::getLessonVideoDuration($lesson), $lessons);

            return round(array_sum($video_duration) / 60);
        }

        return false;
    }

    public function courseLessonCountShortcode()
    {
        $post = get_post(get_the_ID());

        return sprintf( _n( '%s lesson', '%s lessons', $lessons = self::getCourseLessonCount($post) ), $lessons );
    }

    public function courseTotalTimeShortcode()
    {
        $post = get_post(get_the_ID());

        return sprintf( _n( '%s hour', '%s hours', $duration = self::getCourseTotalTime($post) ), $duration );
    }

    public static function getLessonCourseLinkWithTitle()
    {
        $lesson = Lesson::find(get_the_ID());

        if ($lesson) {
            $course = $lesson->course();

            return '<a href="'.get_permalink($course->ID).'">' . $course?->post_title . '</a>';
        }

        return false;
    }

    public static function getLessonsInCourseByLesson($lesson_id = null)
    {
        $lesson = Lesson::find($lesson_id);

        if (! $lesson) {
            return ['0'];
        }

        return $lesson?->course()?->lessons('ids');
    }

    public static function getLessonsInCourseByCourse($course_id = null)
    {
        $course = Course::find($course_id);

        if (! $course) {
            return ['0'];
        }

        return $course->lessons('ids');
    }

    public function updateLessonVideoLength(int $post_id, WP_Post $post, bool $update)
    {
        $video  = get_post_meta($post_id, 'video', true);
    }

    public function load_lesson_in_dashboard(WP_Query $query)
    {
        if (isset( $_GET['fl_builder'] ) || isset( $post_data['fl_builder'] )) {
            return;
        }

        if ( ! is_admin() && $query->is_main_query() ) {
            $lesson = self::get_next_lesson_from_course_of_the_month();

            if ($lesson) {
                $query->set('p', $lesson->ID);
                $query->set('page_id', $lesson->ID);
                $query->set('post_type', 'mpcs-lesson');
            }
        }
    }

    public function lessonExcerptShortcode()
    {
        global $post;

        return wp_trim_excerpt($post->post_content, $post);
    }

    public function lessonPlanShortcode()
    {
        global $post;

        $lesson_plan = get_field('lesson_plan', $post->ID);

        return do_shortcode("[pdf-embedder url='$lesson_plan']");
    }

    public function worksheetShortcode()
    {
        global $post;

        $lesson_plan = get_field('worksheet', $post->ID);

        return do_shortcode("[pdf-embedder url='$lesson_plan']");
    }
}

syrMemberPressCourse::get_instance();
