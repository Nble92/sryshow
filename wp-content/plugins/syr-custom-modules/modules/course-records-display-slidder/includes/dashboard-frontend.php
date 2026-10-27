<?php
/**
 * Blog Posts frontend content
 *
 * @package Blog Post
 */
?>
<div class="uabb-blog-post-content custom-class1111">
    <div class="uabb-post-thumbnail uabb-blog-post-section thumbnail">
        <?php if ($has_earned && $image_url): ?>
            <div class="record" onclick="showPopup('<?php echo esc_attr($post_id); ?>')">
                <img src="<?php echo esc_url($image_url); ?>" alt="Achieved record" width="165" height="162">
            </div>
        <?php else: ?>
            <img src="<?php echo esc_url(SYR_MODULES_URL . 'modules/course-records-display-slidder/images/empty-record.png'); ?>" alt="Empty record" width="165" height="162">
        <?php endif; ?>
    </div>

    <!-- Hidden popup content for this post -->
    <div id="popup-content-<?php echo esc_attr($post_id); ?>" style="display:none;">
        <?php echo do_shortcode($content); ?>
    </div>
</div>
