<?php if (is_singular('mpcs-lesson')): ?>
    <div class="breadcrumbs">
        <ol>
            <li><h6><a href="<?php echo get_post_type_archive_link('mpcs-course'); ?>"><?php _e('Courses') ?></a> / </h6></li>
            <li><h6><?php echo syrMemberPressCourse::getLessonCourseLinkWithTitle() ?> / </h6></li>
            <li><h6><?php echo get_the_title(); ?></h6></li>
        </ol>
    </div>
<?php elseif (is_singular('mpcs-course')): ?>
    <div class="breadcrumbs">
        <h6>
            <a href="<?php echo get_post_type_archive_link('mpcs-course'); ?>">
                <i class="fl-button-icon fl-button-icon-before fas fa-arrow-left" aria-hidden="true"></i>
                <?php _e('back'); ?>
            </a>
        </h6>
    </div>
<?php endif; ?>
