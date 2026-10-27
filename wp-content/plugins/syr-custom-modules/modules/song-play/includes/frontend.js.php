<?php
/**
 * Your Audio Player Module front-end JS php file
 *
 * @package YourThemeOrPlugin
 */

?>

(function ($) {

    $(document).ready(function() {
        const audioTriggers = $('.play-audio-trigger');
        let audioElement;

        audioTriggers.each(function() {
            const trigger = $(this);
            const playIcon = trigger.find('.fa-play');
            const pauseIcon = trigger.find('.fa-pause');

            trigger.on('click', function() {
                const audioUrl = trigger.data('audioUrl');

                if (audioUrl) {
                    if (!audioElement) {
                        audioElement = new Audio(audioUrl);
                    } else if (audioElement.src !== audioUrl) {
                        audioElement.pause();
                        audioElement.currentTime = 0; // Reset playback
                        audioElement.src = audioUrl;
                    }

                    if (audioElement.paused) {
                        audioElement.play();
                        if (playIcon.length) playIcon.hide();
                        if (pauseIcon.length) pauseIcon.show();
                    } else {
                        audioElement.pause();
                        if (playIcon.length) playIcon.show();
                        if (pauseIcon.length) pauseIcon.hide();
                    }
                } else {
                    console.error('Audio URL not found in data attribute.');
                }
            });
        });

        // Stop audio when modal close button is clicked
        $('.uabb-modal-close').on('click', function () {
            if (audioElement && !audioElement.paused) {
                audioElement.pause();
                audioElement.currentTime = 0; // Optional: reset to start

                // Reset all play/pause icons
                $('.play-audio-trigger .fa-play').show();
                $('.play-audio-trigger .fa-pause').hide();
            }
        });
    });

})(jQuery);