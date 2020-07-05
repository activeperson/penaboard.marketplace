<?php
/**
 * Astoundify WC Themes Template Hooks
 *
 * Action/filter hooks used for Astoundify WC Themes functions/templates.
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

/**
 * General.
 *
 * @since 1.0.0
 */
add_action( 'init', function() {
		remove_action( 'init', 'astoundify_wc_themes_vendors_dashboard_set_endpoints_page_title' );
}, 5 );

// Add contaact methods to admin.
add_filter( 'user_contactmethods', 'Astoundify\Vendify\astoundify_wc_themes_contact_methods' );

/**
 * Templates.
 *
 * @since 1.0.0
 */
add_filter( 'astoundify_wc_themes_locate_template', 'Astoundify\Vendify\astoundify_wc_themes_locate_template', 10, 3 );
add_action( 'wp_enqueue_scripts', 'Astoundify\Vendify\astoundify_wc_themes_enqueue_scripts', 20 );

/**
 * Vendor dashboard.
 *
 * @since 1.0.0
 */
add_filter( 'astoundify_wc_themes_report_by_date_chart', 'Astoundify\Vendify\astoundify_wc_themes_report_by_date_chart' );

add_filter( 'astoundify_wc_themes_vendors_dashboard_orders_columns', 'Astoundify\Vendify\astoundify_wc_themes_vendors_dashboard_orders_columns' );

// Wait a bit for these to be registered.
add_action( 'init', function() {
		remove_action(
			'astoundify_wc_themes_vendors_orders_column_order-number',
			'astoundify_wc_themes_vendors_dashboard_orders_columns_order_number',
			10
		);

		add_action(
			'astoundify_wc_themes_vendors_orders_column_order-number',
			'Astoundify\Vendify\astoundify_wc_themes_vendors_dashboard_orders_columns_order_number',
			10,
			2
		);

		remove_action(
			'astoundify_wc_themes_vendors_orders_column_commission-status',
			'astoundify_wc_themes_vendors_dashboard_columns_order_commission_status',
			10
		);

		add_action(
			'astoundify_wc_themes_vendors_orders_column_commission-status',
			'Astoundify\Vendify\wc_themes_vendors_dashboard_columns_order_commission_status',
			10,
			2
		);

		remove_action(
			'astoundify_wc_themes_vendors_orders_column_commission-fulfillment-status',
			'astoundify_wc_themes_vendors_dashboard_orders_columns_order_commission_fulfillment_status',
			10
		);

		add_action(
			'astoundify_wc_themes_vendors_orders_column_commission-fulfillment-status',
			'Astoundify\Vendify\astoundify_wc_themes_vendors_dashboard_orders_columns_order_commission_fulfillment_status',
			10,
			2
		);

		remove_action(
			'astoundify_wc_themes_vendors_orders_column_actions',
			'astoundify_wc_themes_vendors_dashboard_orders_columns_order_actions',
			10
		);

		add_action(
			'astoundify_wc_themes_vendors_orders_column_actions',
			'Astoundify\Vendify\wc_themes_vendors_orders_column_actions',
			10,
			2
		);
	}
);
