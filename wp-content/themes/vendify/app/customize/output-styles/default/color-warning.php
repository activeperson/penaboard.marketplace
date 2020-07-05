<?php
/**
 * Warning color.
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

$warning  = astoundify_themecustomizer_get_colorscheme_mod( 'color-warning' );
$elements = vendify_customize_theme_color_elements(
	$warning,
	[
		'btn'           => [
			'.btn-warning',
		],
		'btn-outline'   => [
			'.btn-outline-warning',
			'.wp-block-button.is-style-outline .has-warning-color',
		],
		'badge'         => [
			'.badge-warning',
			'.badge--pending',
		],
		'badge-outline' => [
			'.badge-outline-warning',
			'.badge--on-hold',
		],
	]
);

$config = array_merge(
	$elements,
	[

		[
			'selectors'    => [
				'.has-text-color.has-warning-color',
				'.wp-block-button:not(:disabled):not(.disabled) .has-text-color.has-warning-color',
			],
			'declarations' => [
				'color' => esc_attr( $warning ),
			],
		],

		[
			'selectors'    => [
				'.woocommerce-store-notice',
				'.has-background.has-warning-background-color',
			],
			'declarations' => [
				'background-color' => esc_attr( $warning ),
			],
		],

	]
);

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
