(function($){
	<?php if ( isset( $settings->video_lightbox ) && 'yes' == $settings->video_lightbox ) : ?>
		$('.fl-node-<?php echo $id; ?> .syr-wp-video-poster').magnificPopup({
			type: 'iframe',
			mainClass: 'syr-wp-video-lightbox-wrap',
			closeBtnInside: true,
			tLoading: '<i class="fas fa-spinner fa-spin fa-3x fa-fw"></i>'
        });
		<?php
	endif;

	if ( ! FLBuilderModel::is_builder_active() && isset( $settings->sticky_on_scroll ) && 'yes' === $settings->sticky_on_scroll ) :
		?>

		new SYRVideo({
			id: '<?php echo $id; ?>'
        });
	<?php endif; ?>
})(jQuery);
