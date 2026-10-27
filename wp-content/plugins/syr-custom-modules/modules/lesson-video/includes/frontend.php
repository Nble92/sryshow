<?php
/* @var syrLessonVideo $module */
global $post;

$lesson_id = $settings->lesson_id ?? $post->ID ?? 0;
$video_url = $module->get_video($lesson_id);
$photo_src = $settings->photo_src ?? '';
$cloud_name = $module->getCloudName();
$close_icon = $settings->close_icon ?? 'fas fa-times';
$video_ratio = $settings->video_ratio ?? '16_9';
?>

<!-- Modal -->
<div id="<?php echo esc_attr( $id ); ?>-overlay" class="uabb-modal-parent-wrapper uabb-module-content uamodal-<?php echo esc_attr( $id ); ?>">
    <div class="uabb-modal uabb-drag-fix uabb-center-modal uabb-modal-video uabb-modal-custom uabb-aspect-ratio-<?php echo esc_attr($video_ratio); ?>" 
         id="modal-<?php echo esc_attr( $id ); ?>" 
         data-content="video">
        <div class="uabb-content">
            <span class="uabb-modal-close uabb-close-custom-top-right LessonVedioClose">
                <i class="uabb-close-icon <?php echo esc_attr($close_icon); ?>"></i>
            </span>
            <div class="uabb-modal-text uabb-modal-content-data fl-clearfix">
                <?php if ($video_url): ?>
                    <div class="uabb-video-wrap">
                        <video
                            controls
                            playsinline
                            width="1024px"
                            id="<?php echo esc_attr($id); ?>-player"
                            class="cld-video-player cld-video-player-skin-dark"
                            data-cld-public-id="<?php echo esc_attr($video_url); ?>">
                        </video>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="uabb-overlay"></div>
</div>

<!-- Trigger -->
<?php if ( 'photo' === $settings->modal_on && !empty($photo_src) ): ?>
<div class="uabb-modal-action-wrap">
    <div class="uabb-modal-action uabb-trigger uabb-modal-photo-wrap" 
         data-modal="<?php echo esc_attr( $id ); ?>"
         data-lesson-id="<?php echo esc_attr($lesson_id); ?>"
         data-video="<?php echo esc_attr($video_url); ?>"
         data-cloudinary-cloud-name="<?php echo esc_attr($cloud_name); ?>">
        <img class="uabb-modal-photo" src="<?php echo esc_url($photo_src); ?>" alt="">
    </div>
</div>
<?php endif; ?>
