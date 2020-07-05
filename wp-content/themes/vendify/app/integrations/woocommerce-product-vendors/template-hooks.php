<?php
/**
 * WooCommerce Product Vendors Template Hooks
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Dashboard transparency.
add_filter( 'vendify_is_transparent_header', 'Astoundify\Vendify\woocommerce_product_vendors_is_transparent_header' );

// Add default vendor meta.
add_filter( 'astoundify_wc_themes_vendor_dashboard_store_settings_data', 'Astoundify\Vendify\astoundify_wc_themes_vendor_dashboard_store_settings_data' );

// Private Messages compatibility.
add_action( 'wp_ajax_pm_recipients_list', function() {
	if ( class_exists( 'WC_Product_Vendors_Vendor_Admin' ) ) {
		remove_action( 'pre_get_users', [ WC_Product_Vendors_Vendor_Admin::get_instance(), 'filter_users' ] );
	}
}, 5 );

// JS config.
add_filter( 'vendify_i18n', 'Astoundify\Vendify\woocommerce_product_vendors_i18n' );

// Track search page.
add_action( 'save_post', 'Astoundify\Vendify\woocommerce_product_vendors_search_url_reset' );

/**
 * Remove auto output.
 *
 * @since 1.0.0
 */
remove_class_filter( 'woocommerce_after_shop_loop_item', 'WC_Product_Vendors_Vendor_Frontend', 'add_sold_by_loop', 9 );
remove_class_filter( 'woocommerce_single_product_summary', 'WC_Product_Vendors_Vendor_Frontend', 'add_sold_by_single', 39 );

/**
 * Use logo as avatar.
 *
 * @since 1.0.0
 */
add_filter( 'get_avatar_url', 'Astoundify\Vendify\wc_product_vendors_get_avatar_url', 10, 3 );

// Dashboard tab outputs.
add_action( 'vendify_vendor_archive_shop', 'Astoundify\Vendify\vendor_archive_shop' );
add_action( 'vendify_vendor_archive_reviews', 'Astoundify\Vendify\vendor_archive_reviews' );
add_action( 'vendify_vendor_archive_about', 'Astoundify\Vendify\vendor_archive_about' );
add_action( 'vendify_vendor_archive_policies', 'Astoundify\Vendify\woocommerce_product_policies_tab' );

add_filter( 'woocommerce_product_tabs', 'Astoundify\Vendify\woocommerce_product_tabs', 20 );
