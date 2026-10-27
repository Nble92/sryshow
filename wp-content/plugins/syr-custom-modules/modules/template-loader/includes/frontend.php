<?php

/* @var syrTemplateLoader $module */

global $wp_query;
global $post;

$global_wp_query_clone = clone $wp_query;

if ($settings->template && $lesson = $module->get_next_lesson()) {
    $new_query = new WP_Query([
            'p' => $lesson->ID,
            'post_type' => 'mpcs-lesson',
        ]);

    if ($new_query->have_posts()) {
        $wp_query = $new_query;
        while ($new_query->have_posts()) {
            $new_query->the_post();
            echo do_shortcode('[fl_builder_insert_layout id="' . $settings->template . '"]');
        }
    }

    $global_wp_query_clone->reset_postdata();
} elseif (FLBuilderModel::is_builder_active() && empty($settings->template)) { ?>
    <div class="builder-msg" style="text-align: center;">
        <h5><?php esc_html_e( 'Template Loader - ID ' ); ?><?php echo esc_attr( $module->node ); ?></h5>
        <?php esc_html_e( 'Click here to edit the "Template Loader" settings. This text will not be visible on frontend.' ); ?>
    </div>
<?php }