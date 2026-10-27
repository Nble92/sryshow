<?php
global $post, $wpdb;

$user_id           = get_current_user_id();
$current_lesson_id = get_the_ID();

// ✅ Current course id
$current_course_id = get_queried_object_id();

$can_view           = false;
$allowed_lesson_ids = [];

// ✅ Create MemberPress lesson object
$lesson = new \memberpress\courses\models\Lesson($post);

// -----------------------------
// ✅ Section match boolean logic
// -----------------------------

// Get all section titles for this course (array)
$section_titles = $wpdb->get_col(
    $wpdb->prepare("SELECT title FROM {$wpdb->prefix}mpcs_sections WHERE course_id = %d", $current_course_id)
);

// Default: not matched
$is_section_match = false;

// If we have section titles, check lesson's section
if (!empty($section_titles)) {
    // Get this lesson’s section id and title
    $lesson_section_id = get_post_meta($current_lesson_id, '_mpcs_lesson_section_id', true);

    if (!empty($lesson_section_id)) {
        $lesson_section_title = $wpdb->get_var(
            $wpdb->prepare("SELECT title FROM {$wpdb->prefix}mpcs_sections WHERE id = %d", $lesson_section_id)
        );

        // If lesson's section title is one of the course's section titles -> match
        if (!empty($lesson_section_title) && in_array($lesson_section_title, $section_titles, true)) {
            $is_section_match = true;
        }
    }
}

// If not matched, do nothing (no HTML output)
if (!$is_section_match) {
    return;
}

// -----------------------------
// ✅ Access logic (unchanged)
// -----------------------------
if ($user_id) {
    $mepr_user        = new MeprUser($user_id);
    $user_memberships = $mepr_user->active_product_subscriptions();

    foreach ($user_memberships as $membership_id) {
        $acf_lessons = get_field('allowed_lessons', $membership_id);
        if (!empty($acf_lessons)) {
            foreach ($acf_lessons as $lesson_post) {
                $lesson_id = is_object($lesson_post) ? $lesson_post->ID : (int)$lesson_post;
                $allowed_lesson_ids[] = $lesson_id;
            }
        }
    }

    $allowed_lesson_ids = array_unique($allowed_lesson_ids);
    if (in_array($current_lesson_id, $allowed_lesson_ids, true)) {
        $can_view = true;
    }
}
?>
<?php if ($is_section_match) { ?>
<!-- ✅ Lesson Card UI (rendered ONLY if $is_section_match is true) -->
<div class="uabb-blog-post-content">
    <div class="uabb-post-thumbnail uabb-blog-post-section thumbnail">

        <?php if ($lesson->is_complete()): ?>
            <div class="lesson-completed">
                <img src="<?php echo esc_url(SYR_MODULES_URL . 'modules/course-lessons/img/checked.png'); ?>" alt="lesson completed">
            </div>
        <?php endif; ?>

        <?php if ($can_view): ?>
            <!-- ✅ Allowed: Link to lesson -->
            <a href="<?= esc_url(get_permalink($current_lesson_id)); ?>" class="lesson-link">
                <?= FLThemeBuilderFieldConnections::parse_shortcodes('[wpbb post:featured_image size="video-thumbnail" display="tag" linked="no"]'); ?>
                <div class="overlay">
                    <span class="button-primary"><?php _e('🔓ENTER'); ?></span>
                </div>
            </a>
        <?php else: ?>
            <!-- ❌ Locked -->
            <a href="javascript:void(0);" class="lesson-locked" onclick="alert('You do not have access to this lesson. Please upgrade your membership to unlock it.');">
                <div class="lesson-blocked">
                    <?= FLThemeBuilderFieldConnections::parse_shortcodes('[wpbb post:featured_image size="video-thumbnail" display="tag" linked="no"]'); ?>
                    <div class="overlay" style="background-color: rgba(0,0,0,0.6); text-align:center; padding: 1em; color: white;">
                        <strong>🔒</strong><br>
                        <small>This lesson is not included in your membership</small>
                    </div>
                </div>
            </a>
        <?php endif; ?>
    </div>

    <div class="info">
        <div class="title">
            <h6><?= FLThemeBuilderFieldConnections::parse_shortcodes('[wpbb post:title]'); ?></h6>
        </div>

        <?php
        // Show lesson section title if available
        if (!empty($lesson_section_title)): ?>
            <div class="lesson-section">
                <span>Section: <?= esc_html($lesson_section_title); ?></span>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php  } ?>
