<?php
/**
 * Schedule tab panel.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category View
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Product object.
global $product_object;

// Add JS Data.
add_filter( 'astoundify_wc_themes_events_product_data_js', function( $data ) use ( $product_object ) {
	$data['schedule'] = array(
		'data' => astoundify_wc_themes_event_get_schedule_js( $product_object->get_id() ),
		'timezone' => method_exists( $product_object, 'get_schedule_timezone' ) ? $product_object->get_schedule_timezone() : '',
	);

	return $data;
} );

// Add Underscore Templates.
add_action( 'admin_footer', function() {
	astoundify_wc_themes_get_template( 'admin/tmpl-schedule.php' );
} );

// Placeholder HTML.
echo '<div id="wc_themes_schedule_options_inner"></div>';
