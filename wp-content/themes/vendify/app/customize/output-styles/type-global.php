<?php
/**
 * Global typography.
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

$family = astoundify_themecustomizer_get_typography_mod( 'typography-base-font-family' );
$size   = astoundify_themecustomizer_get_typography_mod( 'typography-base-font-size' );
$weight = astoundify_themecustomizer_get_typography_mod( 'typography-base-font-weight' );
$line   = astoundify_themecustomizer_get_typography_mod( 'typography-base-line-height' );

$text_color = astoundify_themecustomizer_get_colorscheme_mod( 'color-body-color' );

$base = [
	'html',
	'body',
	'input',
	'button',
	'select',
	'optgroup',
	'textarea',
	'.custom-textarea > *',
];

$config = [

	// base -- only family.
	[
		'exclude_editor' => false,
		'selectors'      => $base,
		'declarations'   => [
			'font-family' => '"' . esc_attr( $family ) . '" !important',
		],
	],

	// Everything else.
	[
		'exclude_editor' => false,
		'selectors'      => [
			'html',
			'body',
		],
		'declarations'   => [
			'font-size'   => esc_attr( $size . 'px' ),
			'font-weight' => esc_attr( $weight ),
			'line-height' => esc_attr( $line ),
		],
	],

	[
		'selectors'      => [ 'body' ],
		'declarations'   => [ 'color' => $text_color ],
	]
];

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
