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

global $post, $wpdb;

$supported_type = match ($post->post_type) {
    'mpcs-lesson' => 'lesson',
    'mpcs-course' => 'course',
    default => false,
};

// -----------------------------------------------------
// ✅ CASE 1: COURSE PAGE — Show only lessons of that course
// -----------------------------------------------------
if ($supported_type === 'course') :

    $current_course_id = get_queried_object_id();

    // Get sections for this course
    $sections = $wpdb->get_results(
        $wpdb->prepare("
            SELECT id, title
            FROM {$wpdb->prefix}mpcs_sections
            WHERE course_id = %d
            ORDER BY section_order ASC
        ", $current_course_id)
    );

    if (!empty($sections)) {
        $section_ids = wp_list_pluck($sections, 'id');
        $placeholders = implode(',', array_fill(0, count($section_ids), '%d'));

        // Get all lessons for this course
        $sql = "
            SELECT p.ID, p.post_title, pm.meta_value AS section_id
            FROM {$wpdb->posts} AS p
            INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
            WHERE pm.meta_key = '_mpcs_lesson_section_id'
              AND pm.meta_value IN ($placeholders)
              AND p.post_type = 'mpcs-lesson'
              AND p.post_status = 'publish'
            ORDER BY pm.meta_value, p.menu_order, p.ID
        ";

        $prepare_sql = $wpdb->prepare($sql, $section_ids);
        $lessons = $wpdb->get_results($prepare_sql);
    }

    if (empty($lessons)) {
        echo '<p>No lessons found for this course.</p>';
        return;
    }

    ?>
    <div class="uabb-module-content uabb-blog-posts <?php echo wp_kses_post(('carousel' === $settings->is_carousel) ? 'uabb-blog-posts-carousel' : (('grid' === $settings->is_carousel) ? 'uabb-blog-posts-grid' : '')); ?> uabb-post-grid-<?php echo esc_attr($col); ?> <?php echo ('masonary' === $settings->is_carousel) ? ' uabb-blog-posts-masonary ' : ''; ?>">
        <?php
        foreach ($lessons as $lesson_data) :
            $post = get_post($lesson_data->ID);
            setup_postdata($post);

            // Include single lesson layout
            ob_start();
            include plugin_dir_path(__FILE__) . $settings->layout . '-frontend.php';
            $lesson_html = trim(ob_get_clean());

            if (!empty($lesson_html)) :
                ?>
                <div class="uabb-blog-posts-col uabb-post-wrapper syr-<?= esc_attr($settings->layout) ?>-card">
                    <div class="uabb-blog-posts-shadow clearfix">
                        <div class="uabb-blog-post-inner-wrap">
                            <?= $lesson_html; ?>
                        </div>
                    </div>
                </div>
            <?php 
            endif;
        endforeach;
        wp_reset_postdata();
        ?>
    </div>

<?php 
// -----------------------------------------------------
// ✅ CASE 2: OTHER PAGES (Dashboard, etc.) — Default UABB behavior
// -----------------------------------------------------
else :
    $the_query = new WP_Query($uabb_args);

    $col = ('carousel' === $settings->is_carousel)
        ? $settings->post_per_grid_desktop
        : (('feed' === $settings->is_carousel)
            ? 1
            : $settings->post_per_grid);
    ?>

    <div class="uabb-module-content uabb-blog-posts <?php echo wp_kses_post(('carousel' === $settings->is_carousel) ? 'uabb-blog-posts-carousel' : (('grid' === $settings->is_carousel) ? 'uabb-blog-posts-grid' : '')); ?> uabb-post-grid-<?php echo esc_attr($col); ?> <?php echo ('masonary' === $settings->is_carousel) ? ' uabb-blog-posts-masonary ' : ''; ?>">
        <?php if ($the_query->have_posts()) : ?>
            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                <?php
                ob_start();
                include plugin_dir_path(__FILE__) . $settings->layout . '-frontend.php';
                $lesson_html = trim(ob_get_clean());
                if (!empty($lesson_html)) :
                ?>
                    <div class="uabb-blog-posts-col uabb-post-wrapper syr-<?= esc_attr($settings->layout) ?>-card">
                        <div class="uabb-blog-posts-shadow clearfix">
                            <div class="uabb-blog-post-inner-wrap">
                                <?= $lesson_html; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p>No lessons found.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>
