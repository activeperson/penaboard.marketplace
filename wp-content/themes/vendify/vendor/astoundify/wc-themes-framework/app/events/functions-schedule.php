<?php
/**
 * Product schedule functions.
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
 * Get a schedule for an event.
 *
 * @since 1.0.0
 *
 * @param int $event_id The ID of the event.
 * @return array
 */
function astoundify_wc_themes_events_get_schedule( $event_id ) {
	$event = wc_get_product( $event_id );

	if ( 'event' !== $event->get_type() ) {
		return array();
	}

	return apply_filters( 'astoundify_wc_themes_events_event_schedule', $event->get_schedule(), $event_id );
}

/**
 * Update the list of days associated with an Event's schedule.
 *
 * @since 1.0.0
 *
 * @param WC_Product $product Current product.
 * @param array      $updated_props A list of props that have been updated.
 */
function astoundify_wc_themes_events_update_schedule( $product, $updated_props ) {
	if ( false === array_search( 'schedule', $updated_props, true ) ) {
		return;
	}

	$product->get_data_store()->update_schedule_days( $product, $product->get_schedule( 'edit' ) );
}
add_action( 'woocommerce_product_object_updated_props', 'astoundify_wc_themes_events_update_schedule', 10, 2 );

/**
 * Convert schedule timestamps to WC_DateTime objects that can be used more easily.
 *
 * When `$event->get_schedule()` is called all timestamps are converted to WC_DateTime objects.
 * When `$event->get_schedule( 'edit' )` is called all times remain in a UTC timestamp.
 *
 * @since 1.0.0
 *
 * @param array      $schedule Current schedule value.
 * @param WC_Product $product Current product.
 */
function astoundify_wc_themes_events_product_format_schedule( $schedule, $product ) {
	$schedule_timezone = $product->get_schedule_timezone();
	$schedule_utc_offset = $product->get_schedule_utc_offset();

	try {
		$scheduletimezone = new DateTimeZone( $schedule_timezone );
	} catch ( Exception $e ) {
		$scheduletimezone = false;
	}

	foreach ( $schedule as $key => $entry ) {
		foreach ( $entry as $piece => $value ) {
			// Timestamp is UTC.
			$datetime = new WC_DateTime( "@{$value}", new DateTimeZone( 'UTC' ) );

			if ( $schedule_timezone ) {
				$datetime->setTimezone( new DateTimeZone( $schedule_timezone ) );
			} else {
				$datetime->set_utc_offset( astoundify_wc_themes_get_timezone_offset( $schedule_utc_offset ) );
			}

			$schedule[ $key ][ $piece ] = $datetime;
		}
	}

	return $schedule;
}
add_filter( 'woocommerce_product_get_schedule', 'astoundify_wc_themes_events_product_format_schedule', 10, 2 );

/**
 * Filter query variables to items suitable for a WP_Query.
 *
 * @since 1.0.0
 *
 * @param array  $wp_query_args WP_Query arguments.
 * @param array  $query_vars Defined query variables.
 * @param object $store current data store.
 * @return array
 */
function astoundify_wc_themes_events_product_data_store_cpt_get_products_query( $wp_query_args, $query_vars, $store ) {
	$event_date = isset( $query_vars['event_date'] ) && '' !== $query_vars['event_date'];

	if ( $event_date ) {
		// Remove any existing meta queries for the same keys to prevent conflicts.
		$existing_queries = wp_list_pluck( $wp_query_args['meta_query'], 'key', true );

		foreach ( $existing_queries as $query_index => $query_contents ) {
			unset( $wp_query_args['meta_query'][ $query_index ] );
		}

		$wp_query_args = $store->parse_date_for_wp_query( $query_vars['event_date'], '_astoundify_wc_themes_schedule_day', $wp_query_args );

		unset( $wp_query_args['event_date'] );
	}

	return $wp_query_args;
}
add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'astoundify_wc_themes_events_product_data_store_cpt_get_products_query', 10, 3 );

/**
 * Modify Product Query for Schedule Filter
 *
 * @since 1.0.0
 *
 * @param array    $meta_query Meta Query Args.
 * @param WC_Query $query      WC Query.
 * @return array
 */
function astoundify_wc_themes_events_product_query_schedule_filter( $meta_query, $query ) {
	// @codingStandardsIgnoreStart
	if ( isset( $_REQUEST['schedule_start'], $_REQUEST['schedule_end'] ) && $_REQUEST['schedule_start'] && $_REQUEST['schedule_end'] ) {
		$start = date( 'Y-m-d', strtotime( $_REQUEST['schedule_start'] ) );
		$end = date( 'Y-m-d', strtotime( $_REQUEST['schedule_end'] ) );

		$meta_query = WC_Data_Store::load( 'product' )->parse_date_for_wp_query( "{$start}...{$end}", '_astoundify_wc_themes_schedule_day', $meta_query );
	}
	// @codingStandardsIgnoreEnd

	return $meta_query;
}
add_filter( 'woocommerce_product_query_meta_query', 'astoundify_wc_themes_events_product_query_schedule_filter', 10, 2 );
