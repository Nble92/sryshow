<?php

class syrCourseProgress extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(
            [
                'name'        => __('SYR Course Progress'),
                'description' => __('Module to display course progress.'),
                'category'    => __('Course'),
                'group'       => 'SYR Modules',
                'dir'         => SYR_MODULES_DIR . 'modules/course-progress/',
                'url'         => SYR_MODULES_URL . 'modules/course-progress/',
            ]
        );

        $this->add_js('jquery-waypoints');
    }

    public function get_args()
    {
        return [
            'paged'     => (get_query_var('paged')) ? get_query_var('paged') : 1,
            'post_type' => ['lessoncompleted'],
            'posts_per_page' => -1, // ensure we get ALL lessons
        ];
    }

    public function get_progress_bar_settings()
    {
        $args = $this->get_args();
        $lessoncompleted_query = new WP_Query($args);

        $user_id           = get_current_user_id();
        $completed_lessons = 0;
        $total_lessons     = 0;

        if ($lessoncompleted_query->have_posts()) {
            while ($lessoncompleted_query->have_posts()) {
                $lessoncompleted_query->the_post();

                $post_id = get_the_ID();
                $total_lessons++;

                // Check if user has earned this lesson
                $has_earned = function_exists('gamipress_has_user_earned_achievement') &&
                    gamipress_has_user_earned_achievement($post_id, $user_id);

                if ($has_earned) {
                    $completed_lessons++;
                }
            }
        } else {
            error_log("SYR Progress: No lessoncompleted posts found.");
            echo "<script>console.log('SYR Progress: No lessoncompleted posts found.');</script>";
        }

        wp_reset_postdata();

        // Debug logging
        error_log("SYR Progress: User {$user_id}, Completed {$completed_lessons}, Total {$total_lessons}");
        echo "<script>console.log('SYR Progress for user {$user_id}: Completed {$completed_lessons} / {$total_lessons}');</script>";

        // Calculate progress percentage
        $progress_percentage = $total_lessons > 0
            ? round(($completed_lessons / $total_lessons) * 100)
            : 0;

        $progress_settings = [
            "layout"     => "horizontal",
            "horizontal" => [
                [
                    "horizontal_number"       => $progress_percentage,
                    "horizontal_before_number"=> "Your Progress",
                    "progress_bg_type"        => "gradient",
                    "gradient_field"          => [
                        "color_one" => "E6A040",
                        "color_two" => "FCC983",
                        "direction" => "left_right",
                        "angle"     => "90",
                    ],
                    "gradient_color"   => "b7925f",
                    "background_color" => "140f14",
                ]
            ],
            "text_color"       => "ffffff",
            "stripped"         => "no",
            "horizontal_style" => "style3",
            "progress_border"  => [
                "style" => "solid",
                "color" => "b7925f",
                "width" => [
                    "top"    => "1",
                    "right"  => "1",
                    "bottom" => "1",
                    "left"   => "1",
                ],
                "radius" => [
                    "top_left"     => "4",
                    "top_right"    => "4",
                    "bottom_left"  => "4",
                    "bottom_right" => "4",
                ],
            ],
            "text_typo"  => [
                "text_transform" => "capitalize",
            ],
            "number_color"      => "ffffff",
            "completed_lessons" => $completed_lessons,
            "total_lessons"     => $total_lessons,
        ];

        return json_decode(json_encode($progress_settings));
    }

    public function render_progress_html()
    {
        FLBuilder::render_module_html('progress-bar', $this->get_progress_bar_settings());
    }

    public function render_progress_css($module_id)
    {
        FLBuilder::render_module_css('progress-bar', $module_id, $this->get_progress_bar_settings());
    }
}

FLBuilder::register_module('syrCourseProgress', []);
