<?php
/**
 * Danger color.
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

$danger   = astoundify_themecustomizer_get_colorscheme_mod( 'color-danger' );
$elements = vendify_customize_theme_color_elements(
	$danger,
	[
		'btn'           => [ '.btn-danger' ],
		'btn-outline'   => [
			'.btn-outline-danger',
			'#cancel-comment-reply-link',
			'.wp-block-button.is-style-outline .has-danger-color',
		],
		'badge'         => [
			'.badge-danger',
		],
		'badge-outline' => [
			'.badge-outline-danger',
			'.badge--failed',
			'.badge--refunded',
			'.badge--cancelled',
		],
	]
);

$config = array_merge(
	$elements,
	[
		[
			'selectors'    => [
				'.dropdown-item--delete',
				'.product-sidebar__status.out-of-stock',
				'.stock.out-of-stock',
				'.pm-mark-all-as-read',
				'.dropdown-item--delete',
				'.astoundify-favorites-submit-field .astoundify-favorites-remove-favorite',
				'code',
				'.has-text-color.has-danger-color',
				'.wp-block-button:not(:disabled):not(.disabled) .has-text-color.has-danger-color',
			],
			'declarations' => [
				'color' => esc_attr( $danger ),
			],
		],
		[
			'selectors'    => [
				'.has-background.has-danger-background-color',
				'.label--required:after',
			],
			'declarations' => [
				'background-color' => esc_attr( $danger ),
			],
		],
		[
			'selectors'    => [
				'.astoundify-favorites-link.astoundify-favorites-link--active .fav-hear',
				'.fav-heart-inner',
				'.dropdown-item--delete .ico',
			],
			'declarations' => [
				'fill' => esc_attr( $danger ),
			],
		],
		[
			'selectors'    => [
				'.dropdown-item--delete:hover .ico',
			],
			'declarations' => [
				'fill' => esc_attr( astoundify_themecustomizer_darken_hex( $danger, 12 ) ),
			],
		],

	]
);

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
