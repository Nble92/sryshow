<?php /* @var syrIcon $module */?>
<?php if ( ! isset( $settings->exclude_wrapper ) || ( isset( $settings->exclude_wrapper ) && ! $settings->exclude_wrapper ) ) : ?>
<div class="fl-icon-wrap">
<?php endif; ?>
	<span class="fl-icon">
		<?php if ( ! empty( $settings->link ) ) : ?>
        <a href="<?php echo esc_url( do_shortcode( $settings->link ) ); ?>" target="<?php echo esc_attr( $settings->link_target ); ?>"<?php echo $module->get_rel(); ?> <?php echo 'yes' === $settings->download ? 'download' : '' ?>>
		<?php endif; ?>
            <i class="<?php echo $settings->icon; ?>" aria-hidden="true"></i>
            <?php if ( isset( $settings->sr_text ) && '' !== $settings->sr_text ) : ?>
                <span class="sr-only"><?php echo $settings->sr_text; ?></span>
            <?php endif; ?>
		<?php if ( ! empty( $settings->link ) ) : ?>
        </a>
		<?php endif; ?>
	</span>
<?php if ( ! isset( $settings->exclude_wrapper ) || ( isset( $settings->exclude_wrapper ) && ! $settings->exclude_wrapper ) ) : ?>
</div>
<?php endif; ?>
