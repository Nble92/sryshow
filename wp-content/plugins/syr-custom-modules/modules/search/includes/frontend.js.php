(function($) {

	$(function() {
		new SYRSearchModule({
			id: '<?php echo esc_attr( $id ); ?>',
			display: '<?php echo esc_attr( $settings->display ); ?>',
			btnAction: '<?php echo esc_attr( $settings->btn_action ); ?>',
		});
	});

})(jQuery);
