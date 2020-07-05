<?php
/**
 * Product location functions.
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
 * Filter WooCommerce's orderby dropdown.
 *
 * @since 1.0.0
 *
 * @param array $orderby Order by options.
 * @return array
 */
function astoundify_wc_themes_events_woocommerce_catalog_orderby( $orderby ) {
	$filters = astoundify_wc_themes_events_product_filters();
	$all_filters = array();

	foreach ( $filters as $section => $filters ) {
		$all_filters[] = $filters;
	}

	if ( false !== array_search( 'location', $all_filters, true ) ) {
		return $orderby;
	}

	$orderby['distance'] = __( 'Sort by distance', 'astoundify-wc-themes' );

	return $orderby;
}
add_filter( 'woocommerce_catalog_orderby', 'astoundify_wc_themes_events_woocommerce_catalog_orderby' );

/**
 * Select our orderby by default when searching by location.
 *
 * @since 1.0.0
 *
 * @param string $orderby Current orderby.
 * @return string $order
 */
function astoundify_wc_themes_events_woocommerce_default_catalog_orderby( $orderby ) {
	// @codingStandardsIgnoreStart
	if ( isset( $_REQUEST[ 'location' ] ) && '' !== $_REQUEST['location'] ) {
		$orderby = 'distance';
	}
	// @codingStandardsIgnoreEnd

	return $orderby;
}
add_filter( 'woocommerce_default_catalog_orderby', 'astoundify_wc_themes_events_woocommerce_default_catalog_orderby' );

/**
 * Distance Unit
 *
 * @since 1.0.0
 *
 * @return string
 */
function astoundify_wc_themes_events_distance_unit() {
	$unit = 'km';
	$english = apply_filters( 'astoundify_wc_themes_events_distance_english_unit', array( 'US', 'GB', 'LR', 'MM' ) );

	if ( in_array( wc_get_base_location()['country'], $english, true ) ) {
		$unit = 'mi';
	}

	return apply_filters( 'astoundify_wc_themes_events_distance_unit', $unit );
}

/**
 * Retrieve a list of product IDs (ordered by distance) based on a given input.
 *
 * @since 1.0.0
 *
 * @param array $location Location data to search by.
 * @return array
 */
function astoundify_wc_themes_events_get_products_by_location( $location ) {
	global $wpdb;

	$defaults = array(
		'lat'    => false,
		'lng'    => false,
		'radius' => 50,
		'unit'   => astoundify_wc_themes_events_distance_unit(),
	);

	$args = wp_parse_args( $location, $defaults );

	$earth_radius = ( 'mi' === $args['unit'] ) ? 3959 : 6371;
	$lat = (float) $args['lat'];
	$lng = (float) $args['lng'];
	$radius = (float) $args['radius'];

	$sql = "
		SELECT DISTINCT product_id, ( %s * acos(
			greatest( -1, least( 1, ( /* acos() must be between -1 and 1 */
				cos( radians( %s ) ) *
				cos( radians( latitude ) ) *
				cos( radians( longitude ) - radians( %s ) ) +
				sin( radians( %s ) ) *
				sin( radians( latitude ) )
			) ) )
		) ) AS distance
		FROM {$wpdb->prefix}wc_product_locations
		HAVING distance < %d
		ORDER BY distance";

	// @codingStandardsIgnoreStart
	return $wpdb->get_col( $wpdb->prepare( $sql, $earth_radius, $lat, $lng, $lat, $radius ) );
	// @codingStandardsIgnoreEnd
}

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
function astoundify_wc_themes_events_product_data_store_cpt_get_products_query_location( $wp_query_args, $query_vars, $store ) {
	$location = isset( $query_vars['location'] ) && '' !== $query_vars['location'];

	if ( $location ) {
		$product_ids = astoundify_wc_themes_events_get_products_by_location( $query_vars['location'] );

		if ( ! empty( $product_ids ) ) {
			$wp_query_args['post__in'] = $product_ids;
			$wp_query_args['orderby'] = 'post__in';
		}

		unset( $wp_query_args['location'] );
	}

	return $wp_query_args;
}
add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'astoundify_wc_themes_events_product_data_store_cpt_get_products_query_location', 99, 3 );

/**
 * Modify Product Query for Location Filter
 *
 * @since 1.0.0
 *
 * @param array $post_in Posts IDs.
 * @return array
 */
function astoundify_wc_themes_events_product_query_location_filter( $post_in ) {
	// @codingStandardsIgnoreStart
	if ( isset( $_REQUEST['lat'], $_REQUEST['lng'], $_REQUEST['radius'] ) && $_REQUEST['lat'] && $_REQUEST['lng'] ) {
		$post_in = astoundify_wc_themes_events_get_products_by_location( array(
			'lat'    => $_REQUEST['lat'],
			'lng'    => $_REQUEST['lng'],
			'radius' => $_REQUEST['radius'] ? $_REQUEST['radius'] : 50,
		) );
	}
	// @codingStandardsIgnoreend

	return $post_in;
}
add_filter( 'loop_shop_post_in', 'astoundify_wc_themes_events_product_query_location_filter', 10 );

/**
 * Ensure location post__in support maintains order.
 *
 * @since 1.0.0
 *
 * @param WP_Query $query WP_Query instance.
 * @param WC_Query $wc_query WC_Query instance.
 * @return WP_Query
 */
function astoundify_wc_themes_events_woocommerce_get_catalog_ordering_args( $args ) {
	// Only apply if a location is set and no explicit orderby or an explicit orderby set to distance.
	// @codingStandardsIgnoreStart
	if ( isset( $_REQUEST[ 'location' ] ) && '' !== $_REQUEST['location'] && ( ! isset( $_REQUEST['orderby'] ) || ( isset( $_REQUEST['orderby'] ) && 'distance' === $_REQUEST['orderby'] ) ) ) {
		$args['orderby'] = 'post__in';
	}
	// @codingStandardsIgnoreEnd

	return $args;
}
add_filter( 'woocommerce_get_catalog_ordering_args', 'astoundify_wc_themes_events_woocommerce_get_catalog_ordering_args' );
