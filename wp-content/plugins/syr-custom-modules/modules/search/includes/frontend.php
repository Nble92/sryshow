<?php
$form_classes = $module->get_form_classes();
?>

<div class="<?php echo esc_attr( apply_filters( 'uabb_search_form_classes', $form_classes ) ); ?>"
	<?php
	if ( isset( $module->template_id ) ) {
		echo 'data-template-id="' . esc_attr( $module->template_id ) . '" data-template-node-id="' . esc_attr( $module->template_node_id ) . '"';}
	?>
>
	<div class="syr-search-form-wrap">
		<div class="syr-search-form-fields">
			<div class="syr-search-form-input-wrap">
				<form role="search" aria-label="Search form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" data-nonce=<?php echo wp_kses_post( wp_create_nonce( 'syr-search-nonce' ) ); ?>>
					<div class="syr-form-field">
					<?php if ( 'button' === $settings->display && 'fullscreen' === $settings->btn_action && 'show' === $settings->fs_close_button ) { ?>
						<i class="syr-search-close fa fa-times"></i>
					<?php } ?>
					<?php if ( 'input' === $settings->display ) { ?>
						<i class="fa fa-search icon" aria-hidden="true"></i>
					<?php } ?>
						<input type="search" aria-label="Search input" class="syr-search-text" placeholder="" value="<?php get_search_query(); ?>" name="s" />
					</div>
				</form>
			</div>
            <div class="search-button-wrap">
                <a href="javascript:void(0)" class="syr-search-button">
                    <img width="24" height="24" src="<?php echo SYR_MODULES_URL . 'modules/header/images/magnifier.png'; ?>" alt="<?php esc_attr_e('search'); ?>">
                </a>
            </div>
		</div>
	</div>
	<div class="syr-search-overlay"></div>
</div>
