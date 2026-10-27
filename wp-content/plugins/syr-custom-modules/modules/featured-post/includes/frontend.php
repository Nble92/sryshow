<?php /* @var syrFeaturedPost $module */ ?>

<?php if (! is_null($post = $module->get_post())): ?>
    <div class="syr-featured-post <?= $settings->featured ?>">
        <a href="<?= get_the_permalink($post); ?>">
            <div class="thumbnail">
                <div class="tag">
                    <span><?= $module->get_tag($post); ?></span>
                </div>
                <?= get_the_post_thumbnail($post, 'featured-post-thumbnail'); ?>
            </div>
            <div class="content">
                <div class="title">
                    <h4><?= get_the_title($post); ?></h4>
                </div>
                <div class="intro">
                    <p><?= get_the_excerpt($post); ?></p>
                </div>
                <div class="info">
                    <?php if ($settings->featured === 'mpcs-lesson'): ?>
                        <div class="time"><?php echo sprintf( _n( '%s min', '%s mins', $duration = $module->get_lesson_video_duration($post) ), $duration ); ?></div>
                    <?php elseif ($settings->featured === 'mpcs-course'): ?>
                        <div class="time">Time: <?php echo sprintf( _n( '%s hour', '%s hours', $duration = $module->get_course_total_time($post) ), $duration ); ?></div>
                        <div class="separator">|</div>
                        <div class="includes"><?php echo sprintf( _n( '%s lesson', '%s lessons', $lessons = $module->get_course_lesson_count($post) ), $lessons ); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </a>
    </div>
<?php endif; ?>