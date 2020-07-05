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

$background = astoundify_themecustomizer_get_colorscheme_mod( 'color-menu-bg' );
$color = astoundify_themecustomizer_get_colorscheme_mod( 'color-menu-color' );
$icon_color = astoundify_themecustomizer_darken_hex( $color, +93 );
$hover_icon_color = astoundify_themecustomizer_darken_hex( $color, +70 );

$config = [

	// menu background-color
	[
		'selectors'    => [
			'.site-header--static',
			'.site-header--static .dropdown-menu',
			'.site-header--static .nav-item:hover',
			'.site-header--static .nav-link:hover',
			'.site-header--static .dropdown-menu .order-item:hover'
		],
		'declarations' => [
			'background-color' => esc_attr( $background ),
		],
	],
	// darker hovers
	// [
	// 	'selectors'    => [
	// 		'.site-header--static .dropdown-menu .nav-link:hover',
	// 		'.site-header--static .dropdown-menu > .msg-preview:hover'
	// 	],
	// 	'declarations' => [
	// 		'background-color' => esc_attr( astoundify_themecustomizer_darken_hex( $background, -5 ) ) . ' !important',
	// 	]
	// ],
	// search input background
	[
		'selectors' => [
			'.site-header--static .custom-search .form-control',
			'.site-header--static .sh-dropdown--square .sh-dropdown__toggle',
			'.site-header--static .custom-search--centered .form-control',
			'.site-header--static .custom-search--centered .form-control:focus',
		],
		'declarations' => [
			'background-color' => esc_attr( astoundify_themecustomizer_darken_hex( $background, -10 ) ),
		]
	],

	// search input border
	[
		'selectors' => [
			'.site-header--static .site-header .dropdown-toggle:active',
			'.site-header--static .show button.dropdown-toggle',
			'.site-header--static .dropdown-menu',
			'.site-header--static .form-control',
			'.site-header--static .form-control:focus',
			'.site-header--static .msg-preview',
			'.site-header--static .link:after',
		],
		'declarations' => [
			'border-color' => esc_attr( astoundify_themecustomizer_darken_hex( $background, -30 ) ),
		]
	],

	// icons color
	[
		'selectors' => [
			'.site-header--static .ico',
			'.site-header--static button:hover .ico',
			'.site-header--static .sh-dropdown__toggle',
			'.site-header--static .dropdown-toggle',
		],
		'declarations' => [
			'color' => esc_attr( $icon_color ) . '',
			'fill' => esc_attr( $icon_color ) . '',
		]
	],
	// dropdown arrow
	[
		'selectors' => [
			'.site-header--static .dropdown-toggle:after'
		],
		'declarations' => [
			'background-color' => esc_attr( $icon_color ),
		]
	],

	// darker hover colors
	// [
	// 	'selectors' => [
	// 		// '.site-header--static button:hover',
	// 		// '.site-header--static button:hover .ico',
	// 		'.site-header--static button:focus',
	// 	],
	// 	'declarations' => [
	// 		'color' => esc_attr( $hover_icon_color ) . '',
	// 		'fill' => esc_attr( $hover_icon_color ) . '',
	// 	]
	// ],

	// darkest hover colors
	 [
	 	'selectors' => [
	 		// '.site-header--static .sh-dropdown.show .ico',
	 		// '.site-header--static .sh-dropdown.show .sh-dropdown__toggle',
	 		// '.site-header--static .dropdown.show .dropdown-toggle',
//	 		'.site-header--static .custom-search__label--active ~ .custom-search__icon .ico',
	 		// '.site-header--static .nav-link:hover'

		  '.site-header--static .custom-search__icon svg',
		  '.site-header--static .custom-search__icon',
	 	],
	 	'declarations' => [
	 		'color' => esc_attr( astoundify_themecustomizer_darken_hex( $background, -40 ) ) . ' !important',
	 		'fill' => esc_attr( astoundify_themecustomizer_darken_hex( $background, -40 ) ) . ' !important',
	 	]
	 ],

	// text color
	[
		'selectors' => [
			'.site-header--static a',
			'.site-header--static .nav-link',
			'.site-header--static .form-control',
			'.site-header--static .dropdown-menu',
			'.site-header--static .msg-preview__date'
		],
		'declarations' => [
			'color' => esc_attr( $color ),
		]
	]

];

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
