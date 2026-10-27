<?php
/**
 * Blog Posts frontend content
 *
 * @package Blog Post
 */

?>
<div class="uabb-blog-post-content">
    <div class="uabb-post-thumbnail uabb-blog-post-section thumbnail">
        <?php if (\memberpress\courses\models\UserProgress::has_completed_course(get_current_user_id(), get_the_ID())):
            $image = get_field('record_image');
            echo wp_get_attachment_image($image, 'record-small');
        else: ?>
            <img src="<?php echo SYR_MODULES_URL . 'modules/records-archive/images/empty-record.png'; ?>" alt="empty record">
        <?php endif; ?>
    </div>
</div>
