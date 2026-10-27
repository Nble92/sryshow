<?php
/* @var syrCourseBookmark $module */

$data = $module->get_data();
?>

<div class="bookmark">
    <a class="bookmark-link button button-primary" href="<?php echo $data['bookmark_url'] ?? "#0"; ?>" title="<?php echo $data['lesson_title'] ?? __('Completed', 'memberpress-courses'); ?>">
        <i class="fl-button-icon fl-button-icon-before icon-resume" aria-hidden="true"></i>
        <?php if (isset($data['bookmark_url'])): ?>
            <?php if (!$data['has_started_course']): ?>
                <?php _e('Start Course'); ?>
            <?php else: ?>
                <?php _e('Continue Course'); ?>
            <?php endif; ?>
        <?php else: ?>
            <?php _e('Completed'); ?>
        <?php endif; ?>
    </a>
</div>