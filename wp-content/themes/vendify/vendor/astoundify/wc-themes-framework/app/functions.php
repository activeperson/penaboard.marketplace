<?php
/**
 * General functions.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Products
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if the current theme supports a feature.
 *
 * @since 1.0.0
 *
 * @param string $feature Feature to check.
 * @return bool
 */
function astoundify_wc_themes_has_support( $feature ) {
	$support = get_theme_support( 'astoundify-wc-themes' );
	if ( ! $support || ! is_array( $support ) || ! isset( $support[0] ) ) {
		return false;
	}

	return false !== array_search( $feature, $support[0], true );
}

/**
 * Google Maps URL
 *
 * @since 1.0.0
 *
 * @return string
 */
function astoundify_wc_themes_google_maps_url() {
	$url = 'https://maps.googleapis.com/maps/api/js';

	$url = add_query_arg( array(
		'key'       => apply_filters( 'astoundify_wc_themes_google_maps_api', 'AIzaSyBWmROOynGCTW3XiStDrdicLUzOZZP6fFA' ),
		'libraries' => 'places',
		'language'  => strtolower( substr( get_locale(), 0, 2 ) ),
	), $url );

	return esc_url_raw( apply_filters( 'astoundify_wc_themes_google_maps_url', $url ) );
}

/**
 * Register and Enqueue Scripts
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_register_scripts( $hook_suffix = '' ) {

	// Register Google Maps JS.
	wp_register_script( 'google-maps', astoundify_wc_themes_google_maps_url(), array(), ASTOUNDIFY_WC_THEMES_VERSION );

	// Register ChartJS.
	wp_register_script(
		'chartjs',
		ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/js/chartjs/chart.bundle' . ( SCRIPT_DEBUG ? '.min' : '' ) . '.js',
		array(),
		'2.8.0'
	);

	// Register Date Picker CSS.
	wp_register_style( 'astoundify-wc-themes-date-picker', ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/css/datepicker.css', array( 'dashicons' ), ASTOUNDIFY_WC_THEMES_VERSION );

}
add_action( 'wp_enqueue_scripts', 'astoundify_wc_themes_register_scripts', 1 );
add_action( 'admin_enqueue_scripts', 'astoundify_wc_themes_register_scripts', 1 );

/**
 * Helper Functions to Get jQuery UI DatePicker Format.
 *
 * @since 1.0.0
 *
 * @param string $data_format Date format to use. Default to WP date format.
 * @return string
 */
function astoundify_wc_themes_get_jquery_ui_dateformat( $date_format = null ) {
	$date_format = $date_format ? $date_format : get_option( 'date_format' );

	// @codingStandardsIgnoreStart
	$chars = array( 
		'd' => 'dd', 'j' => 'd', 'l' => 'DD', 'D' => 'D', // Day.
		'm' => 'mm', 'n' => 'm', 'F' => 'MM', 'M' => 'M', // Month.
		'Y' => 'yy', 'y' => 'y', // Year.
	); 
	// @codingStandardsIgnoreEnd

	return apply_filters( 'astoundify_wc_themes_jquery_ui_dateformat', strtr( $date_format, $chars ), $date_format );
}

/**
 * Additional Contact Methods
 *
 * @since 1.0.0
 * @uses wp_get_user_contact_methods()
 * @link https://developer.wordpress.org/reference/functions/wp_get_user_contact_methods/
 *
 * @return array
 */
function astoundify_wc_themes_get_additional_contact_methods() {
	// Get WP user contact methods.
	$user = wp_get_current_user();
	$methods = wp_get_user_contact_methods( $user );

	// Add default.
	$methods['facebook']  = esc_html__( 'Facebook URL', 'astoundify-wc-themes' );
	$methods['twitter']   = esc_html__( 'Twitter URL', 'astoundify-wc-themes' );
	$methods['instagram'] = esc_html__( 'Instagram URL', 'astoundify-wc-themes' );
	$methods['pinterest'] = esc_html__( 'Pinterest URL', 'astoundify-wc-themes' );
	$methods['url']       = esc_html__( 'Website URL', 'astoundify-wc-themes' );

	return apply_filters( 'astoundify_wc_themes_vendors_dashboard_vendor_contact_methods', $methods, $user );
}
