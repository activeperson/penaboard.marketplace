<?php
/**
 * Info color.
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

$info     = astoundify_themecustomizer_get_colorscheme_mod( 'color-information' );
$elements = vendify_customize_theme_color_elements(
	$info,
	[
		'btn'           => [
			'.btn-info',
		],
		'btn-outline'   => [
			'.btn-outline-info',
			'.wp-block-button.is-style-outline .has-information-color',
		],
		'badge'         => [
			'.badge-info',
		],
		'badge-outline' => [
			'.badge--processing',
			'.badge-outline-info',
		],
	]
);

$config = array_merge(
	$elements,
	[
		[
			'selectors'    => [
				'.has-text-color.has-information-color',
				'.wp-block-button:not(:disabled):not(.disabled) .has-text-color.has-information-color',
			],
			'declarations' => [
				'color' => esc_attr( $info ),
			],
		],
		[
			'selectors'    => [
				'.has-background.has-information-background-color',
			],
			'declarations' => [
				'background-color' => esc_attr( $info ),
			],  
		]
	]
);

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
