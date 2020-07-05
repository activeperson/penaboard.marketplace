<?php
/**
 * Load the application.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Bootstrap
 * @author Astoundify
 */

namespace Astoundify\WC_Themes;

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialize plugin after other plugins are fully loaded.
 *
 * @since 1.0.0
 */
add_action( 'after_setup_theme', function() {
	// Check for WooCommerce. Fail silently.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	// Load functions.
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/functions.php' );
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/functions-template.php' );
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/functions-date.php' );
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/functions-api.php' );

	// Load functionality based on theme support.
	add_action( 'after_setup_theme', function() {
		if ( astoundify_wc_themes_has_support( 'events' ) ) {
			require_once( ASTOUNDIFY_WC_THEMES_PATH . 'bootstrap/events.php' );
		}

		if ( astoundify_wc_themes_has_support( 'vendors' ) && class_exists( 'WC_Product_Vendors' ) ) {
			require_once( ASTOUNDIFY_WC_THEMES_PATH . 'bootstrap/vendors.php' );
		}

		if ( astoundify_wc_themes_has_support( 'customers' ) && class_exists( 'WooCommerce' ) ) {
			require_once( ASTOUNDIFY_WC_THEMES_PATH . 'bootstrap/customers.php' );
		}
	}, 99 );

	// Load Plugin Setup.
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'bootstrap/setup.php' );

	// Load integrations.
	Integrations::load();
} );
