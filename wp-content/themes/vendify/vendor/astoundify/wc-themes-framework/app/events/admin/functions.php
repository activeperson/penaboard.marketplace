<?php
/**
 * Product Functions.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Admin
 * @author Astoundify
 */

/**
 * Admin Script
 *
 * @since 1.0.0
 *
 * @param string $hook_suffix Current page ID.
 */
function astoundify_wc_themes_events_admin_scripts( $hook_suffix ) {
	global $post_type;

	// Product Edit Screen.
	if ( 'post.php' === $hook_suffix || 'post-new.php' === $hook_suffix ) {

		// Script Vars.
		$debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? true : false;
		$version = $debug ? time() : ASTOUNDIFY_WC_THEMES_VERSION;

		/* === CSS === */

		$url = ASTOUNDIFY_WC_THEMES_URL . 'public/assets/css/product-data.min.css';
		if ( $debug ) {
			$url = ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/css/product-data.css';
		}
		wp_enqueue_style( 'astoundify-wc-themes-product-data', $url, array(), $version );

		/* === JS === */

		// Product Data JS.
		$url = ASTOUNDIFY_WC_THEMES_URL . 'public/assets/js/product-data.min.js'; // Includes all section scripts.
		$deps = array( 'jquery', 'jquery-ui-datepicker', 'backbone', 'wp-util', 'google-maps' );
		if ( $debug ) {
			$url = ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/js/product-data.js'; // Only contain primary script.
		}
		wp_enqueue_script( 'astoundify-wc-themes-product-data', $url, $deps, $version, true );

		// Product data scripts for each section, only loaded on debug.
		if ( $debug ) {
			wp_enqueue_script( 'astoundify-wc-themes-product-data-attendees', ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/js/product-data-attendees.js', array( 'astoundify-wc-themes-product-data' ), $version, true );
			wp_enqueue_script( 'astoundify-wc-themes-product-data-lineup', ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/js/product-data-lineup.js', array( 'astoundify-wc-themes-product-data' ), $version, true );
			wp_enqueue_script( 'astoundify-wc-themes-product-data-sponsors', ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/js/product-data-sponsors.js', array( 'astoundify-wc-themes-product-data' ), $version, true );
			wp_enqueue_script( 'astoundify-wc-themes-product-data-schedule', ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/js/product-data-schedule.js', array( 'astoundify-wc-themes-product-data' ), $version, true );
			wp_enqueue_script( 'astoundify-wc-themes-product-data-location', ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/js/product-data-location.js', array( 'astoundify-wc-themes-product-data' ), $version, true );
		}

		// Delay so it can be filtered by WooCommerce panels.
		add_action( 'admin_footer', function() {
			wp_localize_script( 'astoundify-wc-themes-product-data', 'astoundifyWcThemesEventsProductData', apply_filters( 'astoundify_wc_themes_events_product_data_js', array() ) );
		} );
	}// End if().
}
add_action( 'admin_enqueue_scripts', 'astoundify_wc_themes_events_admin_scripts' );
