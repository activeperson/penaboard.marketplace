<?php
/**
 * Primary color.
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

$primary = astoundify_themecustomizer_get_colorscheme_mod( 'color-primary' );
$is_light = 1;

if ( astoundify_hex_is_light( $primary ) ) {
	$is_light = -1;
}

$elements = vendify_customize_theme_color_elements(
	$primary,
	[
		'btn'           => [
			'.btn-primary',
			'.collection-card__visit',
			'#vendor-dashboard-login-form input[type="submit"]',
			'.wp-login-form input[type="submit"]',
		],
		'btn-outline'   => [
			'.btn-outline-primary',
			'.woocommerce-pagination .current',
			'.page-numbers .current',
			'.nav-links .current',
			'.wp-block-button.is-style-outline .has-primary-color',
		],
		'badge'         => [ '.badge-primary' ],
		'badge-outline' => [ '.badge-outline-primary' ]
	]
);

$config = array_merge(
	$elements,
	[
		[
			'selectors'    => [
				'a:hover',
				'.has-text-color.has-primary-color',
				'.wp-block-button:not(:disabled):not(.disabled) .has-text-color.has-primary-color',
			],
			'declarations' => [ 'color' => esc_attr( $primary ) ],
		],

		[
			'selectors'    => [ '.has-background.has-primary-background-color' ],
			'declarations' => [ 'background-color' => esc_attr( $primary ) ],
		],

		[
			'selectors'    => [
				'.nav-tabs .is-active .nav-link',
				'.nav-tabs .active .nav-link',
				'.nav-tabs .nav-link.active',
				'.nav-tabs .nav-item.show .nav-link',
			],
			'declarations' => [
				'color'      => esc_attr( $primary ),
				'box-shadow' => esc_attr( 'inset 0 -2px 0 ' . $primary ) . ' !important',
			],
		],
	]
);

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
