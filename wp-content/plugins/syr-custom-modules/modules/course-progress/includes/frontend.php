<?php
/* @var syrCourseProgress $module */
$settings = $module->get_progress_bar_settings();
?>

<div class="syr-course-progress-wrapper">
    <!-- Render the progress bar -->
    <div class="syr-course-progress-bar">
        <?php $module->render_progress_html(); ?>
    </div>

    <!-- Display "X / Y lessons completed" -->
    <?php if (isset($settings->completed_lessons) && isset($settings->total_lessons)) : ?>
        <div class="syr-course-progress-count" style="color: #ffffff; font-weight: bold; display: flex; align-items: center;">
            <img src="<?php echo SYR_MODULES_URL . 'modules/course-progress/img/lesson_completed.png'; ?>" alt="lesson completed" style="height: 20px; margin-right: 6px;">
            <?= esc_html($settings->completed_lessons) ?>/<?= esc_html($settings->total_lessons) ?>
        </div>
    <?php endif; ?>
</div>

<style type="text/css">
    .overlay-tag wp-tag,
    .overlay-tag.cld-tag {
        display: none;
    }
    .syr-course-progress-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>
