<?php ?>

(function ($) {

    var audioElement;

    $(document).ready(function() {
        if (typeof SYRTabs === 'function') {
            var SYRTabs_<?php echo esc_attr($id); ?> = new SYRTabs({
                id: '<?php echo esc_attr($id); ?>'
            });

            // When a tab is clicked, stop the audio if playing
            $('.syr-lesson-spotlight .tabs-nav li').on('click', function () {
                // Get active tab content after the click has processed
                setTimeout(function() {
                    const activeTab = $('.tabs-content .section.active');
                    const audioUrl = activeTab.find('.spotlight-play-audio-trigger-auto').data('audio-url');

                    if (audioElement && !audioElement.paused) {
                        audioElement.pause();

                        // Reset all play/pause icons
                        $('.spotlight-play-audio-trigger-auto .fa-play').show();
                        $('.spotlight-play-audio-trigger-auto .fa-pause').hide();
                    }
                }, 100); // small timeout to allow tab switching to complete
            });
        }

        // Audio play/pause logic
        const audioTriggers = $('.spotlight-play-audio-trigger-auto');

        audioTriggers.each(function () {
            const trigger = $(this);
            const playIcon = trigger.find('.fa-play');
            const pauseIcon = trigger.find('.fa-pause');

            trigger.on('click', function () {
                const audioUrl = trigger.data('audio-url');

                if (audioUrl) {
                    if (!audioElement) {
                        audioElement = new Audio(audioUrl);
                    } else if (audioElement.src !== audioUrl) {
                        audioElement.pause();
                        audioElement.currentTime = 0;
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
                $('.spotlight-play-audio-trigger-auto .fa-play').show();
                $('.spotlight-play-audio-trigger-auto .fa-pause').hide();
            }
        });

    });

})(jQuery);

