<?php
/**
 * API functions.
 *
 * @since 1.0.0
 *
 * @package Astoundify\WC_Product_Editor
 * @category Functions
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom REST routes.
 *
 * @since 1.0.0
 */
function astoundify_wc_product_editor_register_rest_routes() {
	$controllers = [];

	if ( class_exists( 'WC_Product_Vendors' ) ) {
		$controllers[] = Astoundify\WC_Product_Editor\API\Products\Categories::class;
		$controllers[] = Astoundify\WC_Product_Editor\API\Products\Tags::class;
	}

	foreach ( $controllers as $controller ) {
		if ( class_exists( $controller ) ) {
			$controller = new $controller();
			$controller->register_routes();
		}
	}
}
add_action( 'rest_api_init', 'astoundify_wc_product_editor_register_rest_routes' );
