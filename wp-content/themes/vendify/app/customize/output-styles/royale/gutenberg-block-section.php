<?php
/**
 * Section block.
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

$colors = vendify_customize_get_theme_color_controls();

foreach ( $colors as $name => $label ) {
	astoundify_themecustomizer_add_css( [
		'selectors'    => [
			'.wp-block-vendify-section.has-' . str_replace( 'color-', '', $name ) . '-background-color',
		],
		'declarations' => [
			'background-color' => esc_attr( astoundify_themecustomizer_get_colorscheme_mod( $name ) ),
		]
	] );

	astoundify_themecustomizer_add_css( [
		'selectors'    => [
			'.wp-block-vendify-section.has-' . str_replace( 'color-', '', $name ) . '-border-color',
		],
		'declarations' => [
			'border-color' => esc_attr( astoundify_themecustomizer_get_colorscheme_mod( $name ) ),
		]
	] );
}
