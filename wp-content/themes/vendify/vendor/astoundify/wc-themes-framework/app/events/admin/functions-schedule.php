<?php
/**
 * Product schedule functionsn for the admin.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Admin
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Dates Tab in Product Data Meta Box.
 *
 * @since 1.0.0
 *
 * @param array $tabs Tabs.
 * @return array
 */
function astoundify_wc_themes_schedule_product_data_tabs( $tabs ) {
	$tabs['schedule'] = array(
		'label'    => esc_html__( 'Schedule', 'astoundify-wc-themes' ),
		'target'   => 'schedule_product_data', // Target panel HTML ID in panel callback.
		'class'    => array( 'show_if_event' ),
		'priority' => 21,
	);

	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'astoundify_wc_themes_schedule_product_data_tabs' );

/**
 * Add Panel for Dates Tab in Product Data Meta Box.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_schedule_product_data_panels() {
	echo '<div id="schedule_product_data" class="panel wc-metaboxes-wrapper">';
		require_once( ASTOUNDIFY_WC_THEMES_TEMPLATE_PATH . '/admin/panel-schedule.php' );
	echo '</div>';
}
add_action( 'woocommerce_product_data_panels', 'astoundify_wc_themes_schedule_product_data_panels' );

/**
 * Save product data.
 *
 * @since 1.0.0
 *
 * @param WC_Product $product Current product.
 */
function astoundify_wc_themes_schedule_admin_process_product_object( $product ) {
	// @codingStandardsIgnoreStart
	$schedule = isset( $_POST['wc_themes_schedule'] ) ? $_POST['wc_themes_schedule'] : array();
	$schedule_to_timestamps = array();

	// Check for a timezone string.
	$schedule_timezone = isset( $_POST['wc_themes_schedule_timezone'] ) ? esc_attr( $_POST['wc_themes_schedule_timezone'] ) : 'UTC+0';
	$schedule_utc_offset = '';

	// Use a UTC offset if available.
	if ( preg_match( '/^UTC[+-]/', $schedule_timezone ) ) {
		$schedule_utc_offset = $schedule_timezone;
		$schedule_timezone = '';
	}

	// Prefer a UTC offset when offsetting a date string.
	$from = $schedule_utc_offset ? $schedule_utc_offset : $schedule_timezone;

	foreach ( $schedule as $item ) {
		$schedule_to_timestamps[] = array(
			'date' => astoundify_wc_themes_date_string_to_timestamp( $item['date'] . ' 00:00:00', $from ),
			'start' => astoundify_wc_themes_date_string_to_timestamp( $item['date'] . ' ' . $item['start'], $from ),
			'end' => astoundify_wc_themes_date_string_to_timestamp( $item['date'] . ' ' . $item['end'], $from ),
		);
	}

	$errors = $product->set_props( array(
		'schedule' => $schedule_to_timestamps,
		'schedule_timezone' => $schedule_timezone,
		'schedule_utc_offset' => preg_replace( '/UTC\+?/', '', $schedule_utc_offset ), // Store only the offset numeral.
	) );

	if ( is_wp_error( $errors ) ) {
		WC_Admin_Meta_Boxes::add_error( $errors->get_error_message() );
	}
	// @codingStandardsIgnoreEnd
}
add_action( 'woocommerce_admin_process_product_object', 'astoundify_wc_themes_schedule_admin_process_product_object' );

/**
 * Schedule data For JS.
 *
 * @since 1.0.0
 *
 * @param int $event_id The ID of the event.
 * @return array
 */
function astoundify_wc_themes_event_get_schedule_js( $event_id ) {
	$schedule = astoundify_wc_themes_events_get_schedule( $event_id );
	$data = array();

	// Only if set.
	if ( empty( $schedule ) ) {
		return $data;
	}

	foreach ( $schedule as $day ) {
		$data[] = array(
			'date' => $day['date']->date( 'Y-m-d' ),
			'start' => $day['start']->date( 'H:i' ),
			'end' => $day['end']->date( 'H:i' ),
		);
	}

	return $data;
}
