<?php
/**
 * Success color.
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

$success  = astoundify_themecustomizer_get_colorscheme_mod( 'color-success' );
$elements = vendify_customize_theme_color_elements(
	$success,
	[
		'btn'           => [
			'.btn-success',
		],
		'btn-outline'   => [
			'.btn-outline-success',
			'.wp-block-button.is-style-outline .has-success-color',
		],
		'badge'         => [
			'.badge-success',
			'.wcpv-registration-message ul a.wc-forward',
			'.woocommerce-error ul a.wc-forward',
			'.woocommerce-notice ul a.wc-forward',
			'.woocommerce-success ul a.wc-forward',
			'.notice ul a.wc-forward',
			'.badge--completed',
		],
		'badge-outline' => [
			'.badge-outline-success',
		],
	]
);

$config = array_merge(
	$elements,
	[
		[
			'selectors'    => [
				'.product-sidebar__status.in-stock',
				'.has-text-color.has-success-color',
				'.wp-block-button:not(:disabled):not(.disabled) .has-text-color.has-success-color',
			],
			'declarations' => [
				'color' => esc_attr( $success ),
			],
		],
		[
			'selectors'    => [
				'.has-background.has-success-background-color',
				'.badge--completed',
			],
			'declarations' => [ 'background-color' => esc_attr( $success ) ],
		],
		[
			'selectors'    => [
				'.badge--completed',
			],
			'declarations' => [ 'border-color' => esc_attr( $success ) ],
		],
		[
			'selectors'    => [ '.activity__item--purchase .ico' ],
			'declarations' => [ 'fill' => esc_attr( $success ) ],
		],

	]
);

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
