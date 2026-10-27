<?php
/* @var syrRecordsArchive $module */

$query = new WP_Query($module->get_args());
?>

    <div class="syr-records-wrapper">
        <?php if ($query->max_num_pages > 1): ?>
            <div class="records-pagination">
                <?php if ($previous_link = $module->get_previous_link()): ?>
                    <a href="<?= esc_attr($previous_link); ?>" class="records-prev" aria-label="Previous">
                        <i class=" fas fa-angle-left"></i>
                    </a>
                <?php endif; ?>
                <?php if ($next_link = $module->get_next_link($query)): ?>
                    <a href="<?= esc_attr($next_link); ?>" class="records-next" aria-label="Next">
                        <i class="fas fa-angle-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="record-row">
            <?php $i = 1; while($query->have_posts()): $query->the_post(); ?>
            <div class="record">
                <div class="record-image">
                    <img src="<?php echo SYR_MODULES_URL . 'modules/records-archive/images/empty-record.png'; ?>" alt="">
                </div>
                <div class="record-disc">
                    <img src="<?php echo SYR_MODULES_URL . 'modules/records-archive/images/disc.png'; ?>" alt="">
                </div>
            </div>
            <?php if ($i % 4 === 0  && $query->post_count > 4): ?></div><div class="record-row"><?php endif; ?>
            <?php ++$i; endwhile; ?>
        </div>
    </div>
<?php

wp_reset_postdata();