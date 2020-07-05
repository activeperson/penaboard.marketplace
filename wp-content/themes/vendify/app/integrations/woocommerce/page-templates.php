<?php
/**
 * Page templates.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Auto apply page templates to assigned WooCommerce pages.
 *
 * @since 1.0.0
 *
 * @param array $templates The current list of templates.
 * @return array
 */
function woocommerce_assign_page_templates( $templates ) {
	$add  = [];
	$path = '/app/integrations/woocommerce/views/';

	if ( is_cart() ) {
		$add[] = $path . 'cart.php';
	}

	if ( is_checkout() && ! is_order_received_page() ) {
		$add[] = $path . 'checkout.php';
	}

	if ( is_checkout() && is_order_received_page() ) {
		$add[] = $path . 'vendor-dashboard.php';
	}

	if ( has_integration( 'woocommerce-product-vendors' )
		&& astoundify_wc_themes_has_support( 'vendors' )
		&& astoundify_wc_themes_vendors_is_dashboard()
	) {
		$add[] = $path . 'vendor-dashboard.php';
	}

	if ( is_account_page() ) {
		$add[] = $path . 'customer-dashboard.php';
	}

	if ( ! empty( $add ) ) {
		$templates = array_merge( $add, $templates );
	}

	return $templates;
}
add_filter( 'page_template_hierarchy', 'Astoundify\Vendify\woocommerce_assign_page_templates', 5 );
