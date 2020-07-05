<?php
/**
 * Product sponsor functions.
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
 * Sanitize Single Sponsor.
 *
 * @since 1.0.0
 *
 * @param int|array $sponsor Sponsor data.
 * @return false|int|array False if invalid. Int if WP User. Array if External.
 */
function astoundify_wc_themes_events_sanitize_sponsor( $sponsor ) {
	if ( ! $sponsor ) {
		return false;
	}

	// Required sponsor fields.
	$default = array(
		'name'     => '',
		'email'    => '',
		'image'    => '',
		'url'      => '',
	);

	$sponsor = wp_parse_args( $sponsor, $default );

	// Name can't be empty.
	return '' !== $sponsor['name'] ? $sponsor : false;
}

/**
 * Get an sponsor.
 *
 * @since 1.0.0
 *
 * @param int|array $sponsor User ID for an internal WP_User or array of data for external.
 * @return Astoundify\WC_Themes\Events\Sponsor|false
 */
function astoundify_wc_themes_events_get_sponsor( $sponsor ) {
	$sponsor = astoundify_wc_themes_events_sanitize_sponsor( $sponsor );

	if ( ! $sponsor ) {
		return false;
	}

	return new \Astoundify\WC_Themes\Events\Sponsor( $sponsor );
}

/**
 * Get all sponsors for event product.
 *
 * @since 1.0.0
 *
 * @param int $sponsors  Sponsors Data.
 * @param int $product   Product object.
 * @return array of Astoundify\WC_Themes\Events\Sponsor objects.
 */
function astoundify_wc_themes_events_format_sponsors( $sponsors, $product ) {

	return array_filter( array_map( 'astoundify_wc_themes_events_get_sponsor', $sponsors ) );
}
add_filter( 'woocommerce_product_get_sponsors', 'astoundify_wc_themes_events_format_sponsors', 10, 2 );

/**
 * Sponsors Data For JS.
 *
 * @since 1.0.0
 *
 * @param int $product Product Object.
 * @return array
 */
function astoundify_wc_themes_events_get_sponsors_js( $product ) {
	// Bail if not event.
	if ( 'event' !== $product->get_type() ) {
		return array();
	}

	$sponsors = $product->get_sponsors();
	$data = array();

	// Only if set.
	if ( empty( $sponsors ) ) {
		return $data;
	}

	foreach ( $sponsors as $sponsor ) {
		$data[] = array(
			'type'     => 'external',
			'name'     => $sponsor->get_name(),
			'email'    => $sponsor->get_email(),
			'image' => array(
				'id' => $sponsor->get_image(),
				'thumbnail' => wp_get_attachment_image_url( $sponsor->get_image(), 'thumbnail' ),
			),
			'url'      => $sponsor->get_url(),
		);
	}

	return $data;
}
