<?php
/**
 * WooCommerce Box Office Integration
 *
 * @since 1.0.0
 * @link https://www.woocommerce.com/products/woocommerce-box-office/
 *
 * @package WC_Themes
 * @category Event
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Ticket Option in Event Product
 *
 * @since 1.0.0
 *
 * @param array $options Options.
 * @return array
 */
function astoundify_wc_themes_events_woocommerce_box_office_product_type_options( $options = array() ) {
	if ( isset( $options['ticket']['wrapper_class'] ) ) {
		$options['ticket']['wrapper_class'] = $options['ticket']['wrapper_class'] . ' show_if_event';
	}
	return $options;
}
add_filter( 'product_type_options', 'astoundify_wc_themes_events_woocommerce_box_office_product_type_options', 11 );

/**
 * Change Priority Of Tickets Tabs
 *
 * @since 1.0.0
 *
 * @param array $options Options.
 * @return array
 */
function astoundify_wc_themes_events_woocommerce_box_office_product_data_tabs( $tabs = array() ) {
	if ( isset( $tabs['ticket'] ) ) {
		$tabs['ticket']['priority'] = 80;
	}
	if ( isset( $tabs['ticket-content'] ) ) {
		$tabs['ticket-content']['priority'] = 82;
	}
	if ( isset( $tabs['ticket-email'] ) ) {
		$tabs['ticket-email']['priority'] = 84;
	}
	return $tabs;
}
add_action( 'woocommerce_product_data_tabs', 'astoundify_wc_themes_events_woocommerce_box_office_product_data_tabs', 11 );
