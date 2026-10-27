<?php global $post; ?>
jQuery(document).ready(function ($) {

    $('.uabb-modal-action-wrap .uabb-trigger').each(function () {

        var $trigger = $(this);
        var modalId = $trigger.data('modal');
        var videoUrl = $trigger.data('video');
        var lessonId = $trigger.data('lesson-id');
        var cloudName = $trigger.data('cloudinary-cloud-name');

        // Debug: make sure all required data is present
        console.log('Initializing modal:', {
            modalId: modalId,
            videoUrl: videoUrl,
            lessonId: lessonId,
            cloudName: cloudName,
            modalOn: $trigger.data('modal-on')
        });

        // Initialize UABB modal
        if (typeof syrLessonVideo === 'function' && modalId) {
            new syrLessonVideo({
                id: modalId,
                modal_on: $trigger.data('modal-on') || 'photo',  // REQUIRED to avoid includes error
                modal_custom: $trigger.data('modal-custom') || '',
                modal_content: 'video',
                video_autoplay: $trigger.data('video-autoplay') || false,
                enable_cookies: $trigger.data('enable-cookies') || false,
                expire_cookie: $trigger.data('expire-cookie') || 0,
                responsive_display: $trigger.data('responsive-display') || '',
                medium_device: $trigger.data('medium-device') || 768,
                small_device: $trigger.data('small-device') || 480,
                lesson: lessonId || '',
                cloudinaryCloudName: cloudName || '',
                security: $trigger.data('security') || ''
            });
        }

        // Dynamically set video when modal opens
        $('#modal-' + modalId).on('uabb_modal_open', function () {
            var $video = $('#' + modalId + '-player');
            if ($video.length && videoUrl) {
                $video.attr('data-cld-public-id', videoUrl);

                // Destroy previous Cloudinary player if exists
                if ($video.data('player')) $video.data('player').destroy();

                if (typeof cloudinary !== 'undefined' && typeof cloudinary.CloudinaryVideoPlayer === 'function') {
                    var player = cloudinary.CloudinaryVideoPlayer($video[0], {
                        cloud_name: cloudName,
                        controls: true,
                        autoplay: $trigger.data('video-autoplay') || false
                    });
                    $video.data('player', player);
                    player.play();
                }
            }
        });

        // Optional: FitVids for responsive video
        setTimeout(function () {
            $(".uamodal-" + modalId + " .uabb-modal-content-data").fitVids();
        }, 300);

    });

});
