<?php
/* @var syrLessonSpotlight $module */

// Get raw tab data
$tabs_raw = $module->get_data();

// Handle case where data is returned as JSON string
$tabs = is_string($tabs_raw) ? json_decode($tabs_raw, true) : $tabs_raw;

// Ensure $tabs is an array to avoid foreach error
$tabs = is_array($tabs) ? $tabs : [];
?>

<div class="syr-lesson-spotlight tabs">
    <div class="tabs-nav">
        <ul>
            <?php foreach ($tabs as $k => $tab): ?>
                <li data-index="<?= esc_attr($k); ?>" class="<?= 0 === $k ? 'active' : ''; ?>">
                    <div class="thumbnail">
                        <?= wp_get_attachment_image($tab['image'], 'spotlight-thumbnail'); ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="tabs-content">
        <?php foreach ($tabs as $k => $tab): ?>
            <div id="section-<?= esc_attr($k); ?>" class="section <?= 0 === $k ? 'active' : ''; ?>">
                
                <?php if (!empty(get_field('spotlight_pdf_file'))): ?>
                    <div class="fl-icon-wrap spotlight_pdf_file_icon">
                        <span class="fl-icon">
                            <a href="<?= esc_url(get_field('spotlight_pdf_file')); ?>" download target="_blank">
                                <i class="icon-download" aria-hidden="true"></i>
                            </a>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($tab['spotlight_audio'])): ?>
                    <div class="spotlight_audio_play">
                        <div class="spotlight-play-audio-trigger-auto" data-audio-url="<?= esc_url($tab['spotlight_audio']); ?>">
                            <i class="icon-text_to_speech" aria-hidden="true"></i>
                        </div>
                        <div class="spotlight-track-title">
                            <?= esc_html($tab['spotlight_track_title']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <h2 class="title"><?= esc_html($tab['title']); ?></h2>

                <div class="content">
                    <?= wp_kses_post(wpautop($tab['content'])); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

