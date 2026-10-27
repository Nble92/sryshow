<?php
/**
 * Register the module's CSS file for Advanced Posts module
 *
 * @package UABB Advanced Posts Module
 */

global $post;
$converted        = UABB_Compatibility::$uabb_migration;



$settings->arrow_color            = FLBuilderColor::hex_or_rgb( $settings->arrow_color );
$settings->arrow_background_color = FLBuilderColor::hex_or_rgb( $settings->arrow_background_color );
$settings->arrow_color_border     = FLBuilderColor::hex_or_rgb( $settings->arrow_color_border );

$settings->post_dots_color              = FLBuilderColor::hex_or_rgb( $settings->post_dots_color );

$settings->element_space = ( isset( $settings->element_space ) && '' !== $settings->element_space ) ? $settings->element_space : '15';

$column_desktop       = isset( $settings->post_per_grid_desktop ) && ! empty( $settings->post_per_grid_desktop ) && intval( $settings->post_per_grid_desktop ) > 0 ? intval( $settings->post_per_grid_desktop ) : 3;
$column_tablet        = isset( $settings->post_per_grid_medium ) && ! empty( $settings->post_per_grid_medium ) && intval( $settings->post_per_grid_medium ) > 0 ? intval( $settings->post_per_grid_medium ) : 2;
$column_mobile        = isset( $settings->post_per_grid_small ) && ! empty( $settings->post_per_grid_small ) && intval( $settings->post_per_grid_small ) > 0 ? intval( $settings->post_per_grid_small ) : 1;
$spacing              = isset( $settings->element_space ) && '' !== $settings->element_space ? $settings->element_space : '15';
$space_desktop        = ( $column_desktop - 1 ) * $spacing;
$space_large          = ( $column_desktop - 1 ) * $spacing;
$space_tablet         = ( $column_tablet - 1 ) * $spacing;
$space_mobile         = ( $column_mobile - 1 ) * $spacing;
$post_columns_desktop = ( 100 - $space_desktop ) / $column_desktop;
$post_columns_large   = ( 100 - $space_large ) / $column_desktop;
$post_columns_tablet  = ( 100 - $space_tablet ) / $column_tablet;
$post_columns_mobile  = ( 100 - $space_mobile ) / $column_mobile;
$settings->show_meta  = ( isset( $settings->show_meta ) ) ? $settings->show_meta : 'yes';

?>

.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .uabb-post-wrapper {
	<?php
		if ( 1 === $settings->post_per_grid_desktop ) {
			echo 'padding: 0;';
		} elseif ( 'grid' === $settings->is_carousel || 'masonary' === $settings->is_carousel || 'carousel' === $settings->is_carousel ) {
			echo ( '' !== $settings->element_space ) ? 'padding-left: ' . esc_attr( $settings->element_space / 2 ) . 'px;' : 'padding-left: 7.5px;';
			echo ( '' !== $settings->element_space ) ? 'padding-right: ' . esc_attr( $settings->element_space / 2 ) . 'px;' : 'padding-right: 7.5px;';
		}
	?>
}

.fl-node-<?php echo esc_attr( $id ); ?> .uabb-post-wrapper .uabb-blog-post-content {
	<?php
	if ( 'yes' === $converted || isset( $settings->content_padding_dimension_top ) && isset( $settings->content_padding_dimension_bottom ) && isset( $settings->content_padding_dimension_left ) && isset( $settings->content_padding_dimension_right ) ) {
		if ( isset( $settings->content_padding_dimension_top ) ) {
			echo ( '' !== $settings->content_padding_dimension_top ) ? 'padding-top:' . esc_attr( $settings->content_padding_dimension_top ) . 'px;' : 'padding-top: 25px;';
		}
		if ( isset( $settings->content_padding_dimension_bottom ) ) {
			echo ( '' !== $settings->content_padding_dimension_bottom ) ? 'padding-bottom:' . esc_attr( $settings->content_padding_dimension_bottom ) . 'px;' : 'padding-bottom: 25px;';
		}
		if ( isset( $settings->content_padding_dimension_left ) ) {
			echo ( '' !== $settings->content_padding_dimension_left ) ? 'padding-left:' . esc_attr( $settings->content_padding_dimension_left ) . 'px;' : 'padding-left: 25px;';
		}
		if ( isset( $settings->content_padding_dimension_right ) ) {
			echo ( '' !== $settings->content_padding_dimension_right ) ? 'padding-right:' . esc_attr( $settings->content_padding_dimension_right ) . 'px;' : 'padding-right: 25px;';
		}
	} elseif ( isset( $settings->content_padding ) && '' !== $settings->content_padding && isset( $settings->content_padding_dimension_top ) && '' === $settings->content_padding_dimension_top && isset( $settings->content_padding_dimension_bottom ) && '' === $settings->content_padding_dimension_bottom && isset( $settings->content_padding_dimension_left ) && '' === $settings->content_padding_dimension_left && isset( $settings->content_padding_dimension_right ) && '' === $settings->content_padding_dimension_right ) {
		echo esc_attr( $settings->content_padding );
		?>
		;
	<?php } ?>
}

<?php
if ( 'carousel' === $settings->is_carousel ) {

	if ( method_exists( 'FLBuilder', 'fa5_pro_enabled' ) ) {
		if ( FLBuilder::fa5_pro_enabled() ) {
			?>
			.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts ul.slick-dots li button:before {
				font-family: 'Font Awesome 5 Pro';
			}
			<?php
		}
	}
	?>

.fl-node-<?php echo esc_attr( $id ); ?> .slick-prev i,
.fl-node-<?php echo esc_attr( $id ); ?> .slick-next i,
.fl-node-<?php echo esc_attr( $id ); ?> .slick-prev i:hover,
.fl-node-<?php echo esc_attr( $id ); ?> .slick-next i:hover,
.fl-node-<?php echo esc_attr( $id ); ?> .slick-prev i:focus,
.fl-node-<?php echo esc_attr( $id ); ?> .slick-next i:focus {
	outline: none;
	<?php
	$color       = uabb_theme_base_color( $settings->arrow_color );
	$arrow_color = ( '' !== $color ) ? $color : '#fff';
	?>
	color: <?php echo esc_attr( $arrow_color ); ?>;
	<?php
	switch ( $settings->arrow_style ) {
		case 'square':
			?>
	background: <?php echo ( '' !== $settings->arrow_background_color ) ? esc_attr( $settings->arrow_background_color ) : '#efefef'; ?>;
			<?php
			break;

		case 'circle':
			?>
	border-radius: 50%;
	background: <?php echo ( '' !== $settings->arrow_background_color ) ? esc_attr( $settings->arrow_background_color ) : '#efefef'; ?>;
			<?php
			break;

		case 'square-border':
			?>
	border: <?php echo esc_attr( $settings->arrow_border_size ); ?>px solid <?php echo esc_attr( $settings->arrow_color_border ); ?>;
			<?php
			break;

		case 'circle-border':
			?>
	border: <?php echo esc_attr( $settings->arrow_border_size ); ?>px solid <?php echo esc_attr( $settings->arrow_color_border ); ?>;
	border-radius: 50%;
			<?php
			break;
	}
	?>
}

	<?php
	if ( 'outside' !== $settings->arrow_position ) {
		?>
	.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-prev,
	.fl-node-<?php echo esc_attr( $id ); ?> [dir='rtl'] .uabb-blog-posts .slick-next
	{
		left: -15px;
	}
	.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-next,
	.fl-node-<?php echo esc_attr( $id ); ?> [dir='rtl'] .uabb-blog-posts .slick-prev
	{
		right: -15px;
	}
	.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-prev i,
	.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-next i,
	.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-prev i:hover,
	.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-prev i:focus,
	.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-next i:focus,
	.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-next i:hover {
		width: 30px;
		height: 30px;
		line-height: 30px;
	}
		<?php
	}
	?>

.fl-node-<?php echo esc_attr( $id ); ?> .fl-node-content .slick-list,
.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-list {
	<?php
	if ( 1 === $settings->post_per_grid_desktop ) {
		?>
	margin: 0;
		<?php
	} else {
		?>
	margin: 0 -<?php echo ( '' !== $settings->element_space ) ? ( esc_attr( $settings->element_space / 2 ) ) : '7.5'; ?>px;
		<?php
	}
	?>
}

	<?php

	if ( 'yes' === $settings->enable_dots ) {
		if ( '' !== $settings->post_dots_size && isset( $settings->post_dots_size ) ) {
			?>
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-dots li button:before {
				<?php echo ( '' !== $settings->post_dots_size ) ? 'font-size:' . esc_attr( $settings->post_dots_size ) . 'px;' : ''; ?>
		}
				<?php
		}

		if ( '' !== $settings->post_dots_color && isset( $settings->post_dots_color ) ) {
			?>
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts ul.slick-dots li button:before {
				<?php echo ( '' !== $settings->post_dots_color ) ? 'color:' . esc_attr( $settings->post_dots_color ) . ';' : ''; ?>
		}
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts ul.slick-dots li.slick-active button:before {
				<?php echo ( '' !== $settings->post_dots_color ) ? 'color:' . esc_attr( $settings->post_dots_color ) . ';' : ''; ?>
			opacity:1;
		}
				<?php
		}
	}
}
?>


<?php if ( $global_settings->responsive_enabled ) { // Global Setting If started. ?>
	@media ( max-width: <?php echo esc_attr( $global_settings->medium_breakpoint ); ?>px ) {
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-post-wrapper .uabb-blog-post-content {
			<?php
			if ( isset( $settings->content_padding_dimension_top_medium ) ) {
				echo ( '' !== $settings->content_padding_dimension_top_medium ) ? 'padding-top:' . esc_attr( $settings->content_padding_dimension_top_medium ) . 'px;' : '';
			}
			if ( isset( $settings->content_padding_dimension_bottom_medium ) ) {
				echo ( '' !== $settings->content_padding_dimension_bottom_medium ) ? 'padding-bottom:' . esc_attr( $settings->content_padding_dimension_bottom_medium ) . 'px;' : '';
			}
			if ( isset( $settings->content_padding_dimension_left_medium ) ) {
				echo ( '' !== $settings->content_padding_dimension_left_medium ) ? 'padding-left:' . esc_attr( $settings->content_padding_dimension_left_medium ) . 'px;' : '';
			}
			if ( isset( $settings->content_padding_dimension_right_medium ) ) {
				echo ( '' !== $settings->content_padding_dimension_right_medium ) ? 'padding-right:' . esc_attr( $settings->content_padding_dimension_right_medium ) . 'px;' : '';
			}
			?>
		}

		<?php if ( 'carousel' === $settings->is_carousel ) { ?>
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-prev,
		.fl-node-<?php echo esc_attr( $id ); ?> [dir='rtl'] .uabb-blog-posts .slick-next
		{
			left: -15px;
		}
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-next,
		.fl-node-<?php echo esc_attr( $id ); ?> [dir='rtl'] .uabb-blog-posts .slick-prev
		{
			right: -15px;
		}
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-prev i,
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-next i,
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-prev i:hover,
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-prev i:focus,
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-next i:focus,
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-next i:hover {
			width: 25px;
			height: 25px;
			line-height: 25px;
		}
			<?php
		}

		if ( 1 === $settings->post_per_grid_medium ) {
			?>
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .uabb-post-wrapper {
			padding: 0;
		}
		.fl-node-<?php echo esc_attr( $id ); ?> .fl-node-content .slick-list,
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-list {
			margin: 0;
		}
			<?php
		} elseif ( 'grid' !== $settings->is_carousel ) {
			?>
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .uabb-post-wrapper {
			<?php
			echo ( '' !== $settings->element_space ) ? 'padding-left: ' . esc_attr( $settings->element_space / 2 ) . 'px;' : 'padding-left: 7.5px;';
			echo ( '' !== $settings->element_space ) ? 'padding-right: ' . esc_attr( $settings->element_space / 2 ) . 'px;' : 'padding-right: 7.5px;';
			?>
		}
		.fl-node-<?php echo esc_attr( $id ); ?> .fl-node-content .slick-list,
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-list {
			margin: 0 -<?php echo ( '' !== $settings->element_space ) ? esc_attr( $settings->element_space / 2 ) : '7.5'; ?>px;
		}
			<?php
		}
		?>
	}

	@media ( max-width: <?php echo esc_attr( $global_settings->responsive_breakpoint ); ?>px ) {
		.fl-node-<?php echo esc_attr( $id ); ?> .uabb-post-wrapper .uabb-blog-post-content {
			<?php
			if ( isset( $settings->content_padding_dimension_top_responsive ) ) {
				echo ( '' !== $settings->content_padding_dimension_top_responsive ) ? 'padding-top:' . esc_attr( $settings->content_padding_dimension_top_responsive ) . 'px;' : '';
			}
			if ( isset( $settings->content_padding_dimension_bottom_responsive ) ) {
				echo ( '' !== $settings->content_padding_dimension_bottom_responsive ) ? 'padding-bottom:' . esc_attr( $settings->content_padding_dimension_bottom_responsive ) . 'px;' : '';
			}
			if ( isset( $settings->content_padding_dimension_left_responsive ) ) {
				echo ( '' !== $settings->content_padding_dimension_left_responsive ) ? 'padding-left:' . esc_attr( $settings->content_padding_dimension_left_responsive ) . 'px;' : '';
			}
			if ( isset( $settings->content_padding_dimension_right_responsive ) ) {
				echo ( '' !== $settings->content_padding_dimension_right_responsive ) ? 'padding-right:' . esc_attr( $settings->content_padding_dimension_right_responsive ) . 'px;' : '';
			}
			?>
		}

		<?php
		if ( 'carousel' === $settings->is_carousel ) {
			if ( 1 === $settings->post_per_grid_small ) {
				?>
			/*.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .uabb-post-wrapper {
				padding: 0;
			}*/
			.fl-node-<?php echo esc_attr( $id ); ?> .fl-node-content .slick-list,
			.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-list {
				margin: 0;
			}
				<?php
			} else {
				?>
			.fl-node-<?php echo esc_attr( $id ); ?> .fl-node-content .slick-list,
			.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .slick-list {
				margin: 0 -<?php echo ( '' !== $settings->element_space ) ? ( esc_attr( $settings->element_space / 2 ) ) : '7.5'; ?>px;
			}
			.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .uabb-post-wrapper {
				<?php
				echo ( '' !== $settings->element_space ) ? 'padding-left: ' . esc_attr( $settings->element_space / 2 ) . 'px;' : 'padding-left: 7.5px;';
				echo ( '' !== $settings->element_space ) ? 'padding-right: ' . esc_attr( $settings->element_space / 2 ) . 'px;' : 'padding-right: 7.5px;';
				?>
			}
				<?php
			}
		}
		?>
	}

	@media ( max-width: <?php echo ( esc_attr( $global_settings->responsive_breakpoint - 1 ) ); ?>px ) {
		<?php
		if ( 'carousel' === $settings->is_carousel ) {
			if ( 1 === $settings->post_per_grid_small ) {
				?>
			.fl-node-<?php echo esc_attr( $id ); ?> .uabb-blog-posts .uabb-post-wrapper {
				padding: 0;
			}
				<?php
			}
		}
		?>
	}
	<?php
}
