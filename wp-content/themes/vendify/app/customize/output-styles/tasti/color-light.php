<?php
/**
 * Light color.
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

$light    = astoundify_themecustomizer_get_colorscheme_mod( 'color-light' );

$is_light = 1;

if ( astoundify_hex_is_light( $light ) ) {
	$is_light = -1;
}

$gray100 = astoundify_themecustomizer_darken_hex($light, 5 * $is_light );
$gray200 = astoundify_themecustomizer_darken_hex($light, 15.5 * $is_light );
$gray300 = astoundify_themecustomizer_darken_hex($light, 44 * $is_light );

$elements = vendify_customize_theme_color_elements(
	$light,
	[
		'btn'           => [ '.btn-light' ],
		'btn-outline'   => [
			'.btn-outline-light',
			'.wp-block-button.is-style-outline .has-light-color',
		],
		'badge'         => [ '.badge-light' ],
		'badge-outline' => [ '.badge-outline-light' ],
	]
);

$config = array_merge(
	$elements,
	[
		[
			'selectors'    => [
				'.ribbon',
				'.woocommerce-store-notice',
				'.shop-info__primary',
				'.shop-info__name',
				'.shop-info__stats',
				'.review-badge.active',
				'body .has-text-color.has-light-color',
				'.wp-block-button:not(:disabled):not(.disabled) .has-text-color.has-light-color',
			],
			'declarations' => [ 'color' => esc_attr( $light ) ],
		],

		[
			'selectors'    => [
				'aside.menu',
				'.site-footer',
				'.site-footer__dropup',
				'.section:nth-of-type(odd)',
				'.navigation--dashboard',
				'.navigation--profile',
				'.cnv__card',
				'.is-from-current-user .cnv__message__body',
				'.find-menu',
				'.checkout__header',
				'.order-card',
				'.order-card__body',
				'.activity',
				'.activity__item',
				'.noUi-handle',
				'.comment__thread',
				'.comment__item',
				'.chart',
				'.menu__footer',
				'.review-item__footer',
				'.product-thumbnail',
				'.has-background.has-light-background-color',
				'.hero--page, .hero--archive, .hero--blog-post'
			],
			'declarations' => [
				'background-color' => esc_attr( $light ),
			],
		],

		[
			'selectors'    => [
				'.access__header',
			],
			'declarations' => [
				'background-color' => esc_attr( $light ),
			],
			'media' => 'screen and (max-width: 767.98px)',
		],

		[
			'selectors'    => [
				'.review-badge.active .ico',
			],
			'declarations' => [
				'color' => esc_attr( $light ),
			],
		],

		[
			'selectors'    => [
				'.product-thumbnail',
			],
			'declarations' => [
				'border-color' => esc_attr( $light ),
			],
		],

		[
			'selectors'    => [
				'.single-vendor-tabs .review__item::before',
				'.single-vendor-tabs .review__item::after',
			],
			'declarations' => [ 'border-bottom-color' => esc_attr( $light ) ],
		],

		[
			'selectors'    => [
				'.dropdown--user .nav-link:focus',
				'.find-menu__header',
				'.find-menu__body .find-sidebar__heading',
				'.find-menu__footer',
				'.sh-dropdown--square .sh-dropdown__toggle',
				'.wc-layered-nav-rating.chosen',
				'.menu__footer--link',
				'.form-control--search',
				'.msg-preview--unread',
				'.access__header',
				'.modal--fullscreen .modal-content',
				'.hr--or:after',
				'.section, .wp-block-vendify-section, .main-content--single-section'
			],
			'declarations' => [
				'background-color' => esc_attr( $gray100 ),
			],
		],

		[
			'selectors'    => [
				'.order-card__header',
				'.cnv__header',
				'.cnv__footer',
			],
			'declarations' => [
				'background-color' => esc_attr( astoundify_themecustomizer_darken_hex( $gray100, 6 ) ),
			],
		],

		[
			'selectors'    => [
				'.product-standard-tabs .comment.odd .review__item:before',
				'.product-standard-tabs .comment.odd .review-item__footer',
				'.modal-body',
			],
			'declarations' => [
				'background-color' => esc_attr( vendify_customize_hex_to_rgba( $gray100, 0.75 ) ),
			],
		],

		[
			'selectors'    => [ '.product-standard-tabs .comment.odd .review-item__body' ],
			'declarations' => [ 'border-color' => esc_attr( vendify_customize_hex_to_rgba( $gray100, 0.75 ) ) ],
		],

		[
			'selectors'    => [
				'.cnv__message__body',
				'.flickity-page-dots .dot',
				'.noUi-target',
				'.select2-container--default .select2-results__option[aria-selected=true]',
				'.select2-container--default .select2-results__option[data-selected=true]',
				'.msg-preview--unread:hover',
				'.custom-file-control:before',
			],
			'declarations' => [
				'background-color' => esc_attr( $gray200 ),
			],
		],

		[
			'selectors'    => [
				'.site-footer__nav',
				'.site-footer__dropup',
				'.section + .section',
				'#astoundify-simple-social-login-woocommerce-profile-wrap h2',
				'.dashboard__subheading',
				'.find-menu__header',
				'.find-menu__body .find-sidebar__heading',
				'.find-menu__footer',
				'.order-update',
				'.order-card__header',
				'.wc-item-meta',
				'.cnv__header',
				'.woocommerce-checkout fieldset',
				'.form--checkout fieldset',
				'.checkout__sidebar__header',
				'.checkout-receipt',
				'.checkout-receipt__total',
				'.woocommerce-terms-and-conditions-wrap',
				'.filter-bar--shop-listing  .filter__search',
				'#vendor-dashboard-login-form .login-submit',
				'.wp-login-form .login-submit',
				'.comment-respond',
				'.dropdown-item--delete',
				'.order-item',
				'.order-item .btn-icon--close',
				'.activity__body--transparent .activity__item + .activity__item',
				'.widget > ul > li',
				'#wp-calendar tr',
				'.access__header',
				'#astoundify-simple-social-login-woocommerce-wrap .login-or span',
				'.login-or',
				'.comment__thread--alt',
				'.menu__footer',
				'.single-vendor-tabs .review-item__body',
				'.product-sidebar__social',
				'.show .dropdown-toggle',
				'.dropdown-toggle:active',
				'.widget_price_filter .price_slider_wrapper .ui-widget-content',
				'.msg-preview',
				'.filter',
				'.link:after'

			],
			'declarations' => [
				'border-color' => esc_attr( $gray200 ),
			],
		],

		[
			'selectors'    => [
				'.access__header',
			],
			'declarations' => [
				'border-bottom' => "1px solid " . esc_attr( $gray200 ),
			],
			'media' => 'screen and (max-width: 767.98px)',
		],

		[
			'selectors'    => [
				'.single-variation-tabs .review__item::after',
				'.cnv__message__body::before',
			],
			'declarations' => [
				'border-bottom-color' => esc_attr( $gray200 ),
			],
		],

		[
			'selectors'    => [
				'.activity__date',
				'.select2-selection__clear',
				'.msg-preview__date .dashicons'
			],
			'declarations' => [ 'color' => esc_attr( $gray300 ) ],
		],

		[
			'selectors'    => [ '.woocommerce-product-gallery--2 .flex-control-nav a' ],
			'declarations' => [ 'background-color' => esc_attr( $gray300 ) ],
		],

		[
			'selectors'    => [
				'#wp-calendar thead th',
				'.wp-block-separator',
				'#astoundify-simple-social-login-woocommerce-profile-wrap h2',
				'.woocommerce legend',
				'.woocommerce .title h3',
				'.link:hover:after'
			],
			'declarations' => [ 'border-color' => esc_attr( $gray300 ) ],
		],

		[
			'selectors'    => [ '.testimonial-banner__watch:after' ],
			'declarations' => [ 'border-left-color' => esc_attr( $gray300 ) ],
		],

		[
			'selectors'    => [
				'.ico',
				'.product-slider .flickity-prev-next-button .arrow',

				// not sure any of these are needed...
				'.cnv__actions .ico',
				'.order-item .btn-icon--close .ico',
				'.pi__content .btn .ico',
				'.msg-toggles svg',
			],
			'declarations' => [
				'fill' => esc_attr( $gray300 ),
			],
		]
	]
);

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
