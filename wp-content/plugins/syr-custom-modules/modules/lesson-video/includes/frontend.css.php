<?php
/* @var syrLessonVideo $module */

$settings->content_bg_color = FLBuilderColor::hex_or_rgb( $settings->content_bg_color );
$settings->overlay_color    = FLBuilderColor::hex_or_rgb( $settings->overlay_color );

$settings->close_icon_color = FLBuilderColor::hex_or_rgb( $settings->close_icon_color );

$settings->icon_color       = FLBuilderColor::hex_or_rgb( $settings->icon_color );
$settings->icon_hover_color = FLBuilderColor::hex_or_rgb( $settings->icon_hover_color );

?>

.fl-node-<?php echo esc_attr( $id ); ?> {
    width: 100%;
}

.fl-node-<?php echo esc_attr( $id ); ?> .uabb-modal-action-wrap {
    text-align: <?php echo esc_attr( $settings->all_align ); ?>;
}

/* Global Css */
<?php if ( 'icon' === $settings->close_source ) { ?>
.uamodal-<?php echo esc_attr( $id ); ?> .uabb-modal-close {
    font-size: <?php echo esc_attr( $settings->close_icon_size ); ?>px;
}

.uamodal-<?php echo esc_attr( $id ); ?> .uabb-close-icon {
    width: <?php echo esc_attr( $settings->close_icon_size ); ?>px;
    height: <?php echo esc_attr( $settings->close_icon_size ); ?>px;
    line-height: <?php echo esc_attr( $settings->close_icon_size ); ?>px;
    font-size: <?php echo esc_attr( $settings->close_icon_size ); ?>px;
    color: <?php echo esc_attr( $settings->close_icon_color ); ?>;
}

<?php } else { ?>
.uamodal-<?php echo esc_attr( $id ); ?> .uabb-modal-close,
.uamodal-<?php echo esc_attr( $id ); ?> .uabb-close-image {
    width: <?php echo ( '' !== $settings->close_icon_size ) ? esc_attr( $settings->close_icon_size ) : '25'; ?>px;
    height: <?php echo ( '' !== $settings->close_icon_size ) ? esc_attr( $settings->close_icon_size ) : '25'; ?>px;
}

<?php } ?>

<?php if ( 'popup-edge-top-right' === $settings->icon_position ) { ?>
.uamodal-<?php echo esc_attr( $id ); ?> .uabb-modal-close {
    top: -<?php echo ( '' !== $settings->close_icon_size ) ? intval( $settings->close_icon_size ) / 2 : '12.5'; ?>px;
    right: -<?php echo ( '' !== $settings->close_icon_size ) ? intval( $settings->close_icon_size ) / 2 : '12.5'; ?>px;
    left: auto;
}

<?php } elseif ( 'popup-edge-top-left' === $settings->icon_position ) { ?>
.uamodal-<?php echo esc_attr( $id ); ?> .uabb-modal-close {
    top: -<?php echo ( '' !== $settings->close_icon_size ) ? intval( $settings->close_icon_size ) / 2 : '12.5'; ?>px;
    left: -<?php echo ( '' !== $settings->close_icon_size ) ? intval( $settings->close_icon_size ) / 2 : '12.5'; ?>px;
    right: auto;
}

<?php } ?>


.uamodal-<?php echo esc_attr( $id ); ?> .uabb-content {
    background: <?php echo ( '' !== $settings->content_bg_color ) ? esc_attr( $settings->content_bg_color ) : ''; ?>;
}

.uamodal-<?php echo esc_attr( $id ); ?> .uabb-overlay {
    background: <?php echo ( '' !== $settings->overlay_color ) ? esc_attr( $settings->overlay_color ) : ''; ?>;
}

.uamodal-<?php echo esc_attr( $id ); ?> .uabb-modal-content-data {
<?php if ( isset( $settings->modal_spacing ) && '' !== $settings->modal_spacing && isset( $settings->modal_spacing_dimension_top ) && '' === $settings->modal_spacing_dimension_top && isset( $settings->modal_spacing_dimension_bottom ) && '' === $settings->modal_spacing_dimension_bottom && isset( $settings->modal_spacing_dimension_left ) && '' === $settings->modal_spacing_dimension_left && isset( $settings->modal_spacing_dimension_right ) && '' === $settings->modal_spacing_dimension_right ) {
    echo esc_attr( $settings->modal_spacing );
    ?>;
<?php } ?>
}

<?php if ( '' !== $settings->modal_width && is_numeric( $settings->modal_width ) ) { ?>
.uamodal-<?php echo esc_attr( $id ); ?> .uabb-modal,
.uamodal-<?php echo esc_attr( $id ); ?> .uabb-content {
    width: <?php echo esc_attr( $settings->modal_width ); ?>px;
    max-width: 100%;
}

<?php $size = $module->get_width_height(); ?>

<?php } elseif ( '' === $settings->modal_width ) { ?>
.uamodal-<?php echo esc_attr( $id ); ?> .uabb-modal,
.uamodal-<?php echo esc_attr( $id ); ?> .uabb-content {
    width: 100%;
    max-width: 100%;
}

<?php } ?>

/* Responsive Center CSS */
<?php if ( '' !== $settings->modal_width ) { ?>
@media ( max-width: <?php echo ( intval( $settings->modal_width ) + 50 ) . 'px'; ?> ) {
    /*.uamodal-
<?php echo esc_attr( $id ); ?> .uabb-modal,*/
    .uamodal-<?php echo esc_attr( $id ); ?> .uabb-content {
        width: 80%;
    }
}

<?php } ?>

<?php if ( $global_settings->responsive_enabled ) { ?>
@media ( max-width: <?php echo esc_attr( $global_settings->medium_breakpoint ) . 'px'; ?> ) {
    .uamodal-<?php echo esc_attr( $id ); ?> .uabb-modal-content-data {
    <?php
    if ( isset( $settings->modal_spacing_dimension_top_medium ) ) {
        echo ( '' !== $settings->modal_spacing_dimension_top_medium ) ? 'padding-top:' . esc_attr( $settings->modal_spacing_dimension_top_medium ) . 'px;' : '';
    }
    if ( isset( $settings->modal_spacing_dimension_bottom_medium ) ) {
        echo ( '' !== $settings->modal_spacing_dimension_bottom_medium ) ? 'padding-bottom:' . esc_attr( $settings->modal_spacing_dimension_bottom_medium ) . 'px;' : '';
    }
    if ( isset( $settings->modal_spacing_dimension_left_medium ) ) {
        echo ( '' !== $settings->modal_spacing_dimension_left_medium ) ? 'padding-left:' . esc_attr( $settings->modal_spacing_dimension_left_medium ) . 'px;' : '';
    }
    if ( isset( $settings->modal_spacing_dimension_right_medium ) ) {
        echo ( '' !== $settings->modal_spacing_dimension_right_medium ) ? 'padding-right:' . esc_attr( $settings->modal_spacing_dimension_right_medium ) . 'px;' : '';
    }
    ?>
    }
}

@media ( max-width: <?php echo esc_attr( $global_settings->responsive_breakpoint ) . 'px'; ?> ) {
    .uamodal-<?php echo esc_attr( $id ); ?> .uabb-modal-content-data {
    <?php
    if ( isset( $settings->modal_spacing_dimension_top_responsive ) ) {
        echo ( '' !== $settings->modal_spacing_dimension_top_responsive ) ? 'padding-top:' . esc_attr( $settings->modal_spacing_dimension_top_responsive ) . 'px;' : '';
    }
    if ( isset( $settings->modal_spacing_dimension_bottom_responsive ) ) {
        echo ( '' !== $settings->modal_spacing_dimension_bottom_responsive ) ? 'padding-bottom:' . esc_attr( $settings->modal_spacing_dimension_bottom_responsive ) . 'px;' : '';
    }
    if ( isset( $settings->modal_spacing_dimension_left_responsive ) ) {
        echo ( '' !== $settings->modal_spacing_dimension_left_responsive ) ? 'padding-left:' . esc_attr( $settings->modal_spacing_dimension_left_responsive ) . 'px;' : '';
    }
    if ( isset( $settings->modal_spacing_dimension_right_responsive ) ) {
        echo ( '' !== $settings->modal_spacing_dimension_right_responsive ) ? 'padding-right:' . esc_attr( $settings->modal_spacing_dimension_right_responsive ) . 'px;' : '';
    }
    ?>
    }
}

<?php } ?>


.uamodal-<?php echo esc_attr( $id ); ?> .uabb-loader::before {
    border: 3px solid rgba(0, 0, 0, 0.8);
    border-left-color: transparent;
    border-right-color: transparent;
}

<?php
if ( class_exists( 'FLBuilderCSS' ) && isset( $settings->modal_border ) ) {
	FLBuilderCSS::border_field_rule(
		[
			'settings'     => $settings,
			'setting_name' => 'modal_border',
			'selector'     => ".uamodal-$id .uabb-content",
		]
	);
}
?>
