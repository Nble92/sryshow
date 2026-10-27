<?php
/**
 * Render the Frontend layout for Advanced Posts module.
 *
 * @package UABB Advanced Posts Module
 */

/* @var syrCourseLessons $module */

$uabb_args = $module->get_uabb_args();
$args = $module->render_args();

$uabb_args = apply_filters('uabb_blog_posts_query_args', $args, $settings);

$module->set_uabb_args($uabb_args);

global $post;

$supported_type = match ($post->post_type) {
    'mpcs-lesson' => 'lesson',
    'mpcs-course' => 'course',
    default => false,
};

if ($supported_type):
    $the_query = FLBuilderLoop::query($settings);
    /* @var WP_Query $the_query */
    $module->set_uabb_args([]);

    $col = ('carousel' === $settings->is_carousel) ? $settings->post_per_grid_desktop : (('feed' === $settings->is_carousel) ? 1 : $settings->post_per_grid);

    ?>
    <div class="uabb-module-content uabb-blog-posts <?php echo wp_kses_post(('carousel' === $settings->is_carousel) ? 'uabb-blog-posts-carousel' : (('grid' === $settings->is_carousel) ? 'uabb-blog-posts-grid' : '')); ?> uabb-post-grid-<?php echo esc_attr($col); ?> <?php echo ('masonary' === $settings->is_carousel) ? ' uabb-blog-posts-masonary ' : ''; ?>">
        <?php

        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
                ?>
                <div class="uabb-blog-posts-col uabb-post-wrapper syr-record-card">
                    <div class="uabb-blog-posts-shadow clearfix">
                        <div class="uabb-blog-post-inner-wrap">
                            <?php include plugin_dir_path(__FILE__) . 'dashboard-frontend.php'; ?>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>
    </div>

    <?php

    wp_reset_postdata();

endif;
?>
