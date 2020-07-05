<?php
/**
 * Heading typography.
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

$family = astoundify_themecustomizer_get_typography_mod( 'typography-headings-font-family' );
$weight = astoundify_themecustomizer_get_typography_mod( 'typography-headings-font-weight' );

$config = [

	// base -- only family.
	[
		'selectors'    => [
			'h1, h2, h3, h4, h5, h6',
			'.h1, .h2, .h3, .h4, .h5, .h6',
			'.hero-block__content p',
			'.collection-card__title',
			'.page-title',
		],
		'declarations' => [
			'font-family' => '"' . esc_attr( $family ) . '"',
			'font-weight' => esc_attr( $weight )
		],
	],

];

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
