<?php
/**
 * Vendor Dashboard block.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Block
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Only register if plugin exists.
if ( ! has_integration( 'woocommerce-product-vendors' ) ) {
	return;
}

use WC_Product_Vendors_Utils;

/**
 * Output a vendor registration form.
 *
 * @since 1.0.0
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function gutenberg_vendor_dashboard( $attributes ) {
	ob_start();

	if ( ! astoundify_wc_is_vendor_dashboard() ) {
		return wpautop( esc_html__( 'Please use vendor dashboard block only on selected page.', 'vendify' ) );
	}

	if ( is_user_logged_in() && WC_Product_Vendors_Utils::is_vendor() ) {
		astoundify_wc_themes_get_template( 'vendor-dashboard/vendor-dashboard.php' );
	} else {
		astoundify_wc_themes_get_template( 'vendor-dashboard/form-login-register.php' );
	}

	return ob_get_clean();
}

// Register block.
register_block_type(
	'vendify/vendor-dashboard',
	[
		'render_callback' => 'Astoundify\Vendify\gutenberg_vendor_dashboard'
	]
);
