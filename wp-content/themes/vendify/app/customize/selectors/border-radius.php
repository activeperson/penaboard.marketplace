<?php
/**
 * Selectors for items needing border-radius.
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

return [
	// General.
	'img',
	'.badge',
	'.btn',
	'.button',
	'button',

	// Specific.
	'.product-shop-info__logo',
	'.order-card',
	'.activity',
	'.activity__thumbnail',
	'.noUi-tooltip',
	'.pi__img-holder',
	'.product-thumbnail',
	'.upload__placeholder',
	'.widget_price_filter .price_slider_wrapper .ui-widget-content',
	'.widget_price_filter .price_slider_wrapper .ui-slider .ui-slider-handle',
];
