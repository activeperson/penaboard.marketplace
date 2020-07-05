<?php
/**
 * Secondary color.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Customize
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$secondary = astoundify_themecustomizer_get_colorscheme_mod( 'color-secondary' );
$elements  = vendify_customize_theme_color_elements(
	$secondary,
	[
		'btn'           => [
			'.btn-secondary',
			'.dropdown-menu .checkout',
			// '.wp-block-button .has-background.has-secondary-background-color',
		],
		'btn-outline'   => [
			'.btn-outline-secondary',
			'.wp-block-button.is-style-outline .has-secondary-color',
		],
		'badge'         => [
			'.badge-secondary',
		],
		'badge-outline' => [
			'.badge-outline-secondary',
		],
	]
);

$config = array_merge(
	$elements,
	[
		[
			'selectors'    => [
				'.history__item__price',
				'.blog-card [rel^="category"]',
				'.has-text-color.has-secondary-color',
				'.wp-block-button:not(:disabled):not(.disabled) .has-text-color.has-secondary-color',
			],
			'declarations' => [
				'color' => esc_attr( $secondary ),
			],
		],

		[
			'selectors'    => [
				'.icon-badge',
				'.btn-add',
				'.is-from-current-user .cnv__message__body',
				'.noUi-connect',
				'body .ui-datepicker .ui-widget-header',
				'body .ui-datepicker .ui-datepicker-header',
				'body .ui-datepicker td.ui-datepicker-current-day',
				'.select2-container--default .select2-results__option--highlighted[aria-selected]',
				'.select2-container--default .select2-results__option--highlighted[data-selected]',
				'.widget_price_filter .ui-slider .ui-slider-range',
				'.has-background.has-secondary-background-color'
			],
			'declarations' => [
				'background-color' => esc_attr( $secondary ),
			],
		],

		[
			'selectors'    => [
				'.pi__price.badge-outline-secondary',
			],
			'declarations' => [
				'background-color' => esc_attr( vendify_customize_hex_to_rgba( $secondary, 0.21 ) ),
			],
		],

		[
			'selectors'    => [
				'body .ui-datepicker td .ui-state-hover',
				'body .ui-datepicker td.ui-datepicker-today',
			],
			'declarations' => [
				'background-color' => esc_attr( astoundify_themecustomizer_darken_hex( $secondary, 10 ) ),
			],
		],

		[
			'selectors'    => [
				'.is-from-current-user .cnv__message__body::before',
			],
			'declarations' => [
				'border-bottom-color' => esc_attr( $secondary ),
			],
		],
	]
);

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
