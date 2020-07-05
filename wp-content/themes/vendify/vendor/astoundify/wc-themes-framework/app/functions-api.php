<?php
/**
 * REST API functions.
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

// REST API was included starting WordPress 4.4.
if ( ! class_exists( 'WP_REST_Server' ) ) {
	return;
}

/**
 * Register custom REST routes.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_register_rest_routes() {
	$controllers = array();

	if ( class_exists( 'WC_Product_Vendors' ) ) {
		$controllers[] = 'Astoundify\WC_Themes\API\Vendors\Dashboard_Overview_REST_Controller';
		$controllers[] = 'Astoundify\WC_Themes\API\Vendors\Dashboard_Report_By_Date_REST_Controller';
	}

	$controllers = apply_filters( 'astoundify_wc_themes_rest_routes', $controllers );

	foreach ( $controllers as $controller ) {
		if ( class_exists( $controller ) ) {
			$controller = new $controller;
			$controller->register_routes();
		}
	}
}
add_action( 'rest_api_init', 'astoundify_wc_themes_register_rest_routes' );

