<?php
/**
 * Dark color.
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

$dark     = astoundify_themecustomizer_get_colorscheme_mod( 'color-dark' );
$is_light = 1;

if ( astoundify_hex_is_light( $dark ) ) {
	$is_light = -1;
}

$gray400 = astoundify_themecustomizer_darken_hex($dark, 159 * $is_light );
$gray500 = astoundify_themecustomizer_darken_hex($dark, 118 * $is_light );
$gray600 = astoundify_themecustomizer_darken_hex($dark, 78 * $is_light );
$gray700 = astoundify_themecustomizer_darken_hex($dark, 40 * $is_light );

$elements = vendify_customize_theme_color_elements(
	$dark,
	[
		'btn'           => [ '.btn-dark' ],
		'btn-outline'   => [
			'.btn-outline-dark',
			'.wp-block-button.is-style-outline .has-dark-color',
		],
		'badge'         => [
			'.badge-dark',
			'.collection-card__badge',
		],
		'badge-outline' => [ '.badge-outline-dark' ]
	]
);

$elements400 = vendify_customize_theme_color_elements(
	$gray400,
	[
		'btn-outline'   => [
//			'.woocommerce-pagination a',
//			'.woocommerce-pagination .current',
//			'.woocommerce-pagination .page-number',
			'.page-numbers',
			'.nav-links a',
			'.nav-links .current',
			'.nav-links .page-number'
		],
		'badge'         => [],
		'badge-outline' => [ '.badge-outline-gray-400' ],
	]
);
$elements500 = vendify_customize_theme_color_elements(
	$gray500,
	[
		'btn-outline'   => [ '.comment-reply-link' ],
		'badge'         => [],
		'badge-outline' => [ '.badge-outline-gray-500' ],
	]
);
$elements600 = vendify_customize_theme_color_elements(
	$gray600,
	[
		'badge'         => [],
		'badge-outline' => [ '.badge-outline-gray-600' ]
	]
);
$elements700 = vendify_customize_theme_color_elements(
	$gray700,
	[
		'badge'         => [],
		'badge-outline' => [ '.badge-outline-gray-700' ],
	]
);

$config = array_merge(
	$elements,
	$elements400,
	$elements500,
	$elements600,
	$elements700,
	[
		[
			'selectors'    => [
				'a',
				// Headings.
				'h1, h2, h3, h4, h5, h6',
				'.h1, .h2, .h3, .h4, .h5, .h6',
				'.link:hover, .dropdown-menu__more:hover .link',
				'.page-title',
				'.site-footer__heading',
				'.widget > .product_list_widget .product-title',
				'.woocommerce legend',
				'.woocommerce .title h3',
				'.woocommerce-orders-table__cell-order-number a',
				'.find-menu__header',
				'.cnv__sender__name',
				'.checkout-receipt__total',
				'.history__item__name',
				'#vendor-dashboard-login-form label',
				'.wp-login-form label',
				'.order-item__name',
				'.hero-column--womens',
				'body .ui-datepicker thead',
				'.metric__value',
				'.menu__footer--link',
				'.review-item__author',
				'.product-thumbnail:hover',
				'.product-thumbnail__count',
				'.notice strong',
				'.product-sidebar__price',
				'.card--specs th',
				'.widget_price_filter .price_slider_amount .price_label span',
				'.msg-preview__sender',
				'.review-item__category',
				'.select2-container--default .select2-results__option[aria-selected=true]',
				'.select2-container--default .select2-results__option[data-selected=true]',
				'.label',
				'.has-text-color.has-dark-color',
				'.wp-block-button:not(:disabled):not(.disabled) .has-text-color.has-dark-color',
				'.site-header--transparent .dropdown-menu a:hover'
			],
			'declarations' => [ 'color' => esc_attr( $dark ) ]
		],

		[
			'selectors'    => [
				'.access__slide:after',
				'.wp-block-quote.is-large',
				'.tooltip::after',
				'.has-background.has-dark-background-color'
			],
			'declarations' => [
				'background-color' => esc_attr( $dark ),
			],
		],

		[
			'selectors'    => [
				'.msg-toggles .is-active',
			],
			'declarations' => [
				'fill' => esc_attr( $dark ),
			],
		],

		[
			'selectors'    => [
				'.tooltip--top::before',
			],
			'declarations' => [
				'border-top-color' => esc_attr( $dark ),
			],
		],

		[
			'selectors'    => [
				'.tooltip--left::before',
			],
			'declarations' => [
				'border-left-color' => esc_attr( $dark ),
			],
		],

		[
			'selectors'    => [
				'.tooltip--right::before',
			],
			'declarations' => [
				'border-right-color' => esc_attr( $dark ),
			],
		],

		[
			'selectors'    => [
				'.tooltip--bottom::before',
			],
			'declarations' => [
				'border-bottom-color' => esc_attr( $dark ),
			],
		],

		[
			'selectors'    => [
				'.order-update__date',
				'.cnv__sender__date',
				'.order-item__quantity',
				'.comment__date',
				'.review-item__date',
				'.review-item__date a',
				'.rating__score',
				'.seller-item__quantity',
				'.product-sidebar__buy-label',
				'.switch__label:last-child'
			],
			'declarations' => [
				'color' => esc_attr( $gray400 ),
			],
		],

		[
			'selectors'    => [
				'.collection-card',
				'.site-footer__column [href*="pinterest.com"]:before',
				'.site-footer__column [href*="facebook.com"]:before',
				'.site-footer__column [href*="twitter.com"]:before',
				'.site-footer__column [href*="instagram.com"]:before',
				'.woocommerce-error ul li:before',
				'.woocommerce-notice ul li:before',
				'.woocommerce-success ul li:before',
				'.notice ul li:before',
				'.wcpv-registration-message ul li:before'
			],
			'declarations' => [
				'background-color' => esc_attr( $gray400 ),
			],
		],

		[
			'selectors'    => [
				'.woocommerce-product-gallery__trigger:before',
				'.woocommerce-product-gallery__trigger:after',
				'.widget_search .custom-search .form-control'
			],
			'declarations' => [
				'border-color' => esc_attr( $gray400 ),
			],
		],

		[
			'selectors'    => [
				'.order-item .btn-icon--close:hover .ico',
				'.custom-search__icon svg:hover',
				'a:hover .ico, button:hover .ico',
			],
			'declarations' => [
				'fill' => esc_attr( $gray400 ),
			],
		],

		[
			'selectors'    => [
				'.nav-tabs .nav-link:hover',
			],
			'declarations' => [
				'box-shadow' =>  'inset 0 -2px 0 0 ' . esc_attr( $gray400 ),
			],
		],


		// Legacy gray 500 color.
		[
			'selectors'    => [
				'.site-footer',
				'.site-footer__column a',
				'.woocommerce-orders-table__cell-order-number span',
				'.order-update-body',
				'.rss-date',
				'.pi__content .btn:hover',
				'.nav--copyright a',
				'.wp-caption-text',
				'.astoundify-wc-re-tooltip-toggle',
				'.dropdown-toggle',
				'.sh-dropdown__toggle',
				'.hero-column',
				'.hero-column .link-cta',
				'.product-thumbnail',
				'.review-badge',
				'.site-header--transparent .dropdown-menu a',
				'.has-text-color.has-gray500-color'
			],
			'declarations' => [
				'color' => esc_attr( $gray500 ),
			],
		],

		// Legacy gray 500 border-color
		[
			'selectors'    => [ '.wp-block-pullquote', '.post_tags' ],
			'declarations' => [ 'border-color' => esc_attr( $gray500 ) ],
		],

		[
			'selectors'    => [
				'.checkout-receipt__item',
				'.hero-column .link-cta:hover',
				'.comment__toggle-replies',
				'.product-sidebar__social',
				'.product-sidebar__social-link',
				'.seller-item__shop-name',
				'.select2-container .select2-selection--single:focus',
				'.product_meta',
				'.product_meta a',
				'.wp-block-pullquote',
//				'.wp-block-pullquote cite',
				'.wp-block-pullquote footer',
				'.custom-select:focus',
				'.switch__label',
				'.comment__toggle-replies',
				'.dropdown-toggle:hover',
				'.nav-link:hover, .nav-link:focus'
			],
			'declarations' => [	'color' => esc_attr( $gray600 ) ],
		],

		[
			'selectors'    => [
				// '.site-footer__column a:hover',
				'.site-footer__column',
				'.order-item__quantity .custom-numeric-input .form-control',
				'li .rsswidget',
				'.custom-file-control:before'
			],
			'declarations' => [ 'color' => esc_attr( $gray700 ) ],
		],

		[
			'selectors'    => [
				'.site-footer__column [href*="pinterest.com"]:hover:before',
				'.site-footer__column [href*="facebook.com"]:hover:before',
				'.site-footer__column [href*="twitter.com"]:hover:before',
				'.site-footer__column [href*="instagram.com"]:hover:before'
			],
			'declarations' => [ 'background-color' => esc_attr( $gray700 ) ],
		]
	]
);

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
