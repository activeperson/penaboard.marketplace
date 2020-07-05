<?php
/**
 * Product attendee functions.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Events
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sanitize Single Attendee.
 *
 * @since 1.0.0
 *
 * @param int|array $attendee User ID or Attendee data.
 * @return false|int|array False if invalid. Int if WP User. Array if External.
 */
function astoundify_wc_themes_event_sanitize_attendee( $attendee ) {
	if ( ! $attendee ) {
		return false;
	}

	// External attendee (not a user).
	if ( is_array( $attendee ) ) {
		// Required attendee fields.
		$default = array(
			'name'     => '',
			'email'    => '',
			'location' => '',
		);

		$attendee = wp_parse_args( $attendee, $default );

		// Name can't be empty.
		return '' !== $attendee['name'] ? $attendee : false;
	} else { // WP User.
		return get_user_by( 'ID', $attendee ) ? absint( $attendee ) : false;
	}

	return false;
}

/**
 * Get an attendee.
 *
 * @since 1.0.0
 *
 * @param int|array $attendee User ID for an internal WP_User or array of data for external.
 * @return Astoundify\WC_Themes\Events\Attendee|false
 */
function astoundify_wc_themes_event_get_attendee( $attendee ) {
	$attendee = astoundify_wc_themes_event_sanitize_attendee( $attendee );

	if ( ! $attendee ) {
		return false;
	}

	return new \Astoundify\WC_Themes\Events\Attendee( $attendee );
}

/**
 * Get all attendees for event product.
 *
 * @since 1.0.0
 *
 * @param int $attendees Attendees Data.
 * @param int $product   Product object.
 * @return array of Astoundify\WC_Themes\Events\Attendee objects.
 */
function astoundify_wc_themes_event_format_attendees( $attendees, $product ) {

	return array_filter( array_map( 'astoundify_wc_themes_event_get_attendee', (array) $attendees ) );
}
add_filter( 'woocommerce_product_get_attendees', 'astoundify_wc_themes_event_format_attendees', 10, 2 );

/**
 * Attendees Data For JS.
 *
 * @since 1.0.0
 *
 * @param int $product Product Object.
 * @return array
 */
function astoundify_wc_themes_event_get_attendees_js( $product ) {
	// Bail if not event.
	if ( 'event' !== $product->get_type() ) {
		return array();
	}

	$attendees = $product->get_attendees();
	$data = array();

	// Only if set.
	if ( empty( $attendees ) ) {
		return $data;
	}

	foreach ( $attendees as $attendee ) {
		$name = $attendee->get_name();

		if ( $attendee->is_user() ) {
			// Use the same format as WC customer select dropdown.
			$name = sprintf( '%1$s (#%2$s &ndash; %3$s)',
				$attendee->get_name(),
				$attendee->user_id(),
				$attendee->get_email()
			);
		}

		$data[] = array(
			'type'     => $attendee->get_type(),
			'user_id'  => $attendee->user_id(),
			'name'     => $name,
			'email'    => $attendee->get_email(),
			'location' => $attendee->get_location(),
		);
	}

	return $data;
}
