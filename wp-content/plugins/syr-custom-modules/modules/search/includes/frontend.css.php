<?php

$form_selector      = ".fl-node-$id .syr-search-form";
$form_selector_wrap = ".fl-node-$id .syr-search-form-wrap";
$input_selector     = ".fl-node-$id .syr-form-field input[type=search]";
$input_placeholder  = $input_selector . '::placeholder';

// Default form styles.
FLBuilderCSS::rule(
	array(
		'selector' => $form_selector_wrap,
		'props'    => array(
			'font-size' => '16px',
			'padding'   => '10px',
		),
	)
);

// Form width.
FLBuilderCSS::rule(
	array(
		'selector' => $form_selector_wrap,
		'enabled'  => 'custom' === $settings->width,
		'props'    => array(
			'width' => array(
				'value' => $settings->custom_width,
				'unit'  => $settings->custom_width_unit,
			),
		),
	)
);

// Overall Alignment.
FLBuilderCSS::responsive_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'form_align',
		'selector'     => $form_selector,
		'prop'         => 'text-align',
	)
);

// Form height.
FLBuilderCSS::responsive_rule(
	array(
		'settings'     => $settings,
		'unit'         => 'px',
		'setting_name' => 'form_height',
		'selector'     => $form_selector_wrap,
		'prop'         => 'min-height',
	)
);

// Form background color.
FLBuilderCSS::rule(
	array(
		'selector' => $form_selector_wrap,
		'props'    => array(
			'background-color' => $settings->form_bg_color,
		),
	)
);

// Form hover background.
FLBuilderCSS::rule(
	array(
		'selector' => $form_selector_wrap . ':hover',
		'props'    => array(
			'background-color' => $settings->form_bg_hover_color,
		),
	)
);

// Form Border - Settings.
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'form_border',
		'selector'     => $form_selector_wrap,
	)
);

// Form Border - Hover color.
FLBuilderCSS::rule(
	array(
		'selector' => $form_selector_wrap . ':hover',
		'props'    => array(
			'border-color' => $settings->form_border_hov_color,
		),
	)
);

// Form padding.
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'form_padding',
		'selector'     => $form_selector_wrap,
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'form_padding_top',
			'padding-right'  => 'form_padding_right',
			'padding-bottom' => 'form_padding_bottom',
			'padding-left'   => 'form_padding_left',
		),
	)
);

// Default input styles.
FLBuilderCSS::rule(
	array(
		'selector' => $input_selector,
		'props'    => array(
			'border-radius' => '4px',
			'font-size'     => '16px',
			'line-height'   => '16px',
			'padding'       => '12px 24px',
		),
	)
);

// Input color.
FLBuilderCSS::rule(
	array(
		'selector' => $input_selector . ',' . $input_placeholder . ", .fl-node-$id .syr-search-form.syr-search-form-input .icon",
		'enabled'  => ! empty( $settings->input_color ),
		'props'    => array(
			'color' => $settings->input_color,
		),
	)
);

// Input background color.
FLBuilderCSS::rule(
	array(
		'selector' => $input_selector . ", .fl-node-$id .syr-search-results-content",
		'props'    => array(
			'background-color' => $settings->input_bg_color,
		),
	)
);

// input hover background.
FLBuilderCSS::rule(
	array(
		'selector' => $input_selector . ':hover',
		'props'    => array(
			'background-color' => $settings->input_bg_hover_color,
		),
	)
);

// Input typography.
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'input_typo',
		'selector'     => $input_selector . ", .fl-node-$id .syr-search-post-text, .fl-node-$id .syr-search-form.syr-search-button-fullscreen .syr-form-field input[type=search]",
	)
);

// Input Border.
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'input_border',
		'selector'     => $input_selector,
	)
);

// Input Border Hover color.
FLBuilderCSS::rule(
	array(
		'selector' => $input_selector . ':hover,' . $input_selector . ':focus',
		'props'    => array(
			'border-color' => $settings->input_border_hov_color,
		),
	)
);

// Input padding.
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'input_padding',
		'selector'     => $input_selector,
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'input_padding_top',
			'padding-right'  => 'input_padding_right',
			'padding-bottom' => 'input_padding_bottom',
			'padding-left'   => 'input_padding_left',
		),
	)
);
