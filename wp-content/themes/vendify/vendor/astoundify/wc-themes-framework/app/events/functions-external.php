<?php
/**
 * Product external ticket functions.
 *
 * @since 1.0.0
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
 * External Ticket Providers
 *
 * @since 1.0.0
 *
 * @return array
 */
function astoundify_wc_themes_events_get_external_ticket_providers() {
	$data = array(
		''             => esc_html__( 'Select a provider&hellip;', 'astoundify-wc-themes' ),
		'ticketmaster' => esc_html__( 'Ticketmaster', 'astoundify-wc-themes' ),
		'eventbrite'   => esc_html__( 'Eventbrite', 'astoundify-wc-themes' ),
	);
	return apply_filters( 'astoundify_wc_themes_events_external_ticket_providers', $data );
}

/**
 * Sanitize Ticket Provider
 *
 * @since 1.0.0
 *
 * @param string $provider Provider.
 * @return string
 */
function astoundify_wc_themes_events_sanitize_ticket_provider( $provider ) {
	if ( array_key_exists( $provider, astoundify_wc_themes_events_get_external_ticket_providers() ) ) {
		return $provider;
	}
	return '';
}


/**
 * External Ticket Add To Cart Button.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_add_to_cart() {
	$product = wc_get_product();
	if ( 'event' === $product->get_type() && is_callable( array( $product, 'is_external_event' ) ) && $product->is_external_event() ) {
		if ( ! $product->add_to_cart_url() ) {
			return;
		}

		astoundify_wc_themes_get_template( 'single-product/add-to-cart/external-event.php', array(
			'product'         => $product,
			'ticket_url'      => $product->get_ticket_url(),
			'ticket_provider' => $product->get_ticket_provider(),
			'html_class'      => esc_attr( $product->get_ticket_provider() ? 'cart cart-ticket-' . $product->get_ticket_provider() : 'cart' ),
			'button_text'     => $product->single_add_to_cart_text(),
		) );
	}
}
add_action( 'woocommerce_event_add_to_cart', 'astoundify_wc_themes_events_add_to_cart', 30 );

/**
 * Get External Ticket URL.
 *
 * @since 1.0.0
 *
 * @param int $ticket_url Ticket URL.
 * @param int $product    Product object.
 * @return string
 */
function astoundify_wc_themes_events_format_external_ticket_url( $ticket_url, $product ) {

	// Bail if not event.
	if ( 'event' !== $product->get_type() ) {
		return $ticket_url;
	}

	$affiliate_info = get_option( 'astoundify_wc_themes_events_external_tickets_affiliate_info', array() );
	$affiliate_info = is_array( $affiliate_info ) ? $affiliate_info : array();

	$provider = $product->get_ticket_provider();

	if ( isset( $affiliate_info[ $provider ] ) ) {
		$ticket_url = astoundify_wc_themes_events_external_add_data_to_url( $ticket_url, $affiliate_info[ $provider ] );
	}

	return esc_url_raw( apply_filters( 'astoundify_wc_themes_events_external_ticket_url', $ticket_url, $product->get_ticket_provider(), $product ) );
}
add_filter( 'woocommerce_product_get_ticket_url', 'astoundify_wc_themes_events_format_external_ticket_url', 10, 2 );

/**
 * Utility to Add Affiliate Data to URL.
 *
 * @since 1.0.0
 *
 * @param string $url  URL.
 * @param string $data Affiliate Data.
 * @return string
 */
function astoundify_wc_themes_events_external_add_data_to_url( $url, $data ) {
	$url = wp_specialchars_decode( rawurldecode( $url ) );
	$data = str_replace( '?', '', $data );

	// Parse affiliate args.
	parse_str( $data, $url_params );

	// Remove any existing matching args from input URL.
	$url = remove_query_arg( array_keys( $url_params ), $url );

	// Add back our own args.
	$url = add_query_arg( $url_params, $url );

	return esc_url( $url );
}
