<?php
/**
 * Product lineup functions.
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
 * Sanitize lineup person.
 *
 * @since 1.0.0
 *
 * @param int|array $person Person.
 * @return false|int|array False if invalid. Int if WP User. Array if External.
 */
function astoundify_wc_themes_events_sanitize_lineup_person( $person ) {
	if ( ! $person ) {
		return false;
	}

	// Required sponsor fields.
	$default = array(
		'name'     => '',
		'email'    => '',
		'image'    => '',
		'title'    => '',
		'url'      => '',
	);

	$person = wp_parse_args( $person, $default );

	// Name can't be empty.
	return '' !== $person['name'] ? $person : false;
}

/**
 * Get a lineup person.
 *
 * @since 1.0.0
 *
 * @param int|array $person User ID for an internal WP_User or array of data for external.
 * @return Astoundify\WC_Themes\Events\Lineup_Person|false
 */
function astoundify_wc_themes_events_get_lineup_person( $person ) {
	$person = astoundify_wc_themes_events_sanitize_lineup_person( $person );

	if ( ! $person ) {
		return false;
	}

	return new \Astoundify\WC_Themes\Events\Lineup_Person( $person );
}

/**
 * Get a lineup for event product.
 *
 * @since 1.0.0
 *
 * @param int $lineup  Lineup data.
 * @param int $product   Product object.
 * @return array of Astoundify\WC_Themes\Events\Lineup_Person objects.
 */
function astoundify_wc_themes_events_format_lineup( $lineup, $product ) {
	return array_filter( array_map( 'astoundify_wc_themes_events_get_lineup_person', $lineup ) );
}
add_filter( 'woocommerce_product_get_lineup', 'astoundify_wc_themes_events_format_lineup', 10, 2 );

/**
 * Lineup Data For JS.
 *
 * @since 1.0.0
 *
 * @param int $product Product Object.
 * @return array
 */
function astoundify_wc_themes_events_get_lineup_js( $product ) {
	// Bail if not event.
	if ( 'event' !== $product->get_type() ) {
		return array();
	}

	$lineup = $product->get_lineup();
	$data = array();

	// Only if set.
	if ( empty( $lineup ) ) {
		return $data;
	}

	foreach ( $lineup as $person ) {
		$data[] = array(
			'type' => 'external',
			'name' => $person->get_name(),
			'email' => $person->get_email(),
			'image' => array(
				'id' => $person->get_image(),
				'thumbnail' => wp_get_attachment_image_url( $person->get_image(), 'thumbnail' ),
			),
			'title' => $person->get_title(),
			'url' => $person->get_url(),
		);
	}

	return $data;
}
