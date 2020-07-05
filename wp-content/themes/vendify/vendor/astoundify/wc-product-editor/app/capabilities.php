<?php
/**
 * Modify capabilities.
 *
 * @since 1.0.0
 *
 * @package Astoundify\WC_Product_Editor
 * @category Functions
 * @author Astoundify
 */

namespace Astoundify\WC_Product_Editor;

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Allow Vendor Admins to view their own products in the REST API.
 *
 * @since 1.0.0
 *
 * @link https://github.com/woocommerce/woocommerce-product-vendors/issues/358
 *
 * @param array $capabilities Current capabilities.
 * @return array
 */
function wcpv_default_admin_vendor_role_caps( $caps ) {
	$caps['read_private_products'] = true;

	return $caps;
}
add_filter( 'wcpv_default_admin_vendor_role_caps', 'Astoundify\WC_Product_Editor\wcpv_default_admin_vendor_role_caps' );
add_filter( 'wcpv_default_manager_vendor_role_caps', 'Astoundify\WC_Product_Editor\wcpv_default_admin_vendor_role_caps' );
