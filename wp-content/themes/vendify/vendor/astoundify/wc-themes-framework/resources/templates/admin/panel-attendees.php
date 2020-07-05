<?php
/**
 * Attendees tab panel.
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
	$data['attendees']['data'] = astoundify_wc_themes_event_get_attendees_js( $product_object );

	return $data;
} );

// Add Underscore Templates.
add_action( 'admin_footer', function() {
	astoundify_wc_themes_get_template( 'admin/tmpl-attendees.php' );
} );

// Placeholder HTML.
echo '<div id="wc_themes_attendees_options_inner"></div>';
