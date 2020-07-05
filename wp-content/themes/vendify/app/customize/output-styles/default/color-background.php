<?php
/**
 * Background color.
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

$background = maybe_hash_hex_color( get_background_color() );

$neutral = astoundify_themecustomizer_darken_hex($background, -15.5 );

$neutral_elements = vendify_customize_theme_color_elements(
	$neutral,
	[
		'btn'           => [ '.btn-neutral' ],
		'btn-outline'   => [
			'.btn-outline-neutral',
			'.wp-block-button.is-style-outline .has-neutral-color',
		],
		'badge'         => [ '.badge-neutral' ],
		'badge-outline' => [ '.badge-outline-neutral' ],
	]
);

$config = [

	$neutral_elements,
	[
		'selectors'    => [
			'body',
			'.section',
		],
		'declarations' => [ 'background-color' => $background ],
	],

	[
		'selectors'    => [
			'.has-text-color.has-neutral-color',
			'.wp-block-button:not(:disabled):not(.disabled) .has-text-color.has-neutral-color',
		],
		'declarations' => [ 'color' => esc_attr( $neutral ) ],
		'editor' => true
	],
	[
		'selectors'    => [ '.has-background.has-neutral-background-color' ],
		'declarations' => [ 'background-color' => esc_attr( $neutral ) ],
	],
	[
		'selectors'    => [ '.has-border-color.has-neutral-border-color' ],
		'declarations' => [ 'border-color' => esc_attr( $neutral ) ],
	],
];

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
