<?php
/**
 * Blog Posts frontend content
 *
 * @package Blog Post
 */
global $post;

$user_id = get_current_user_id();
$current_lesson_id = get_the_ID();
$can_view = false;
$allowed_lesson_ids = [];

// ✅ Create MemberPress lesson object
$lesson = new \memberpress\courses\models\Lesson($post);

// ✅ Get allowed lessons for current user
if ($user_id) {
    $mepr_user = new MeprUser($user_id);
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
    if (in_array($current_lesson_id, $allowed_lesson_ids)) {
        $can_view = true;
    }
}
?>

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
                <?= FLThemeBuilderFieldConnections::parse_shortcodes('[wpbb post:featured_image size="dash-lesson-thumbnail" display="tag" linked="no"]'); ?>
                <div class="overlay">
                    <span class="button-primary"><?php _e('🔓 ENTER'); ?></span>
                </div>
            </a>
        <?php else: ?>
            <!-- ❌ Locked: Image with alert on click -->
            <div class="lesson-blocked" onclick="alert('You cannot access this lesson. To unlock it, please upgrade your membership.')"
                style="cursor: pointer;">
                <?= FLThemeBuilderFieldConnections::parse_shortcodes('[wpbb post:featured_image size="dash-lesson-thumbnail" display="tag" linked="no"]'); ?>
                <div class="overlay" style="background-color: rgba(0,0,0,0.6); text-align:center; padding: 1em; color: white;">
                    <strong>🔒</strong><br>
                    <small>This lesson is not included in your membership</small>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="info">
        <div class="title">
            <h3><?= FLThemeBuilderFieldConnections::parse_shortcodes('[wpbb post:title]'); ?></h3>
        </div>
       <!-- <div class="lesson">
        lesson Id and Title come from here
            <span><?php echo __('Lesson') . ' ' . esc_html(get_post_meta($current_lesson_id, '_mpcs_lesson_section_id', true)); ?></span>
        </div>-->
    </div>
</div>




