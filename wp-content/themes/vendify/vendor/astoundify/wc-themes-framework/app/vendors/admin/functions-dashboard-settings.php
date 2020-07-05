<?php
/**
 * Vendor Dashboard Settings
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Vendors
 * @author Astoundify
 */

/**
 * Add Product Settings Section
 *
 * @since 1.0.0
 *
 * @param array $sections Settings sections.
 * @return array
 */
function astoundify_wc_themes_vendors_admin_dashboard_settings_section( $sections ) {
	// Need to be more than 1 to be visible.
	$sections['astoundify_wc_themes_my_account_settings'] = esc_html__( 'My Account', 'astoundify-wc-themes' ); // Faux.
	$sections['astoundify_wc_themes_vendors_dashboard_settings'] = esc_html__( 'Vendor Dashboard', 'astoundify-wc-themes' );

	return $sections;
}
add_filter( 'woocommerce_get_sections_account', 'astoundify_wc_themes_vendors_admin_dashboard_settings_section' );

/**
 * Add Vendors Dashboard Settings
 *
 * @since 1.0.0
 *
 * @param array $settings Existing settings.
 * @return array $settings
 */
function astoundify_wc_themes_vendors_admin_get_settings_dashboard( $settings ) {
	if ( ! ( isset( $_GET['section'] ) && 'astoundify_wc_themes_vendors_dashboard_settings' === $_GET['section'] ) ) {
		return $settings;
	}

	$settings = array(

		// Pages.
		array(
			'title'    => esc_html__( 'Vendor dashboard pages', 'astoundify-wc-themes' ),
			'id'       => 'astoundify_wc_themes_vendors_dashboard_settings_pages',
			'type'     => 'title',
		),

		array(
			'title'    => esc_html__( 'Vendor dashboard page', 'astoundify-wc-themes' ),
			'desc'     => esc_html__( 'Must have the Vendor Dashboard block in content.', 'astoundify-wc-themes' ),
			'id'       => 'astoundify_wc_themes_vendors_dashboard_page_id',
			'type'     => 'single_select_page',
			'default'  => '',
			'class'    => 'wc-enhanced-select-nostd',
			'css'      => 'min-width:300px;',
			'desc_tip' => true,
		),

		array(
			'title'    => esc_html__( 'Vendor registration', 'astoundify-wc-themes' ),
			'desc'     => esc_html__( 'Enable vendor registration on the "Vendor Dashboard" page.', 'astoundify-wc-themes' ),
			'id'       => 'astoundify_wc_themes_vendors_dashboard_enable_registration',
			'default'  => 'yes',
			'type'     => 'checkbox',
		),

		array(
			'type'     => 'sectionend',
			'id'       => 'astoundify_wc_themes_vendors_dashboard_settings_pages_end',
		),

		// Vendor Dashboard EndPoints.
		array(
			'title'    => esc_html__( 'Vendor dashboard endpoints', 'astoundify-wc-themes' ),
			'id'       => 'astoundify_wc_themes_vendors_dashboard_settings_endpoints',
			'type'     => 'title',
			'desc'     => esc_html__( 'Endpoints are appended to your page URLs to handle specific actions on the vendor dashboard pages. They should be unique and cannot use the same endpoints as my account page.', 'astoundify-wc-themes' ),
		),

		array(
			'title'    => esc_html__( 'Purchases', 'astoundify-wc-themes' ),
			'desc'     => esc_html__( 'Endpoint for the "Vendor Dashboard &rarr; Orders" page.', 'astoundify-wc-themes' ),
			'id'       => 'astoundify_wc_themes_vendors_dashboard_orders_endpoints',
			'type'     => 'text',
			'default'  => 'vendor-orders',
			'desc_tip' => true,
		),

		array(
			'title'    => esc_html__( 'View orders', 'astoundify-wc-themes' ),
			'desc'     => esc_html__( 'Endpoint for the "Vendor Dashboard &rarr; View order" page.', 'astoundify-wc-themes' ),
			'id'       => 'astoundify_wc_themes_vendors_dashboard_view_order_endpoints',
			'type'     => 'text',
			'default'  => 'vendor-view-order',
			'desc_tip' => true,
		),

		array(
			'title'    => esc_html__( 'Reports', 'astoundify-wc-themes' ),
			'desc'     => esc_html__( 'Endpoint for the "Vendor Dashboard &rarr; Reports" page.', 'astoundify-wc-themes' ),
			'id'       => 'astoundify_wc_themes_vendors_dashboard_view_reports_endpoints',
			'type'     => 'text',
			'default'  => 'vendor-reports',
			'desc_tip' => true,
		),

		array(
			'title'    => esc_html__( 'Products', 'astoundify-wc-themes' ),
			'desc'     => esc_html__( 'Endpoint for the "Vendor Dashboard &rarr; Products" page.', 'astoundify-wc-themes' ),
			'id'       => 'astoundify_wc_themes_vendors_dashboard_view_products_endpoints',
			'type'     => 'text',
			'default'  => 'vendor-products',
			'desc_tip' => true,
		),

		array(
			'title'    => esc_html__( 'Store settings', 'astoundify-wc-themes' ),
			'desc'     => esc_html__( 'Endpoint for the "Vendor Dashboard &rarr; Store settings" page.', 'astoundify-wc-themes' ),
			'id'       => 'astoundify_wc_themes_vendors_dashboard_view_store_settings_endpoints',
			'type'     => 'text',
			'default'  => 'vendor-store-settings',
			'desc_tip' => true,
		),

		array(
			'title'    => esc_html__( 'Support', 'astoundify-wc-themes' ),
			'desc'     => esc_html__( 'Endpoint for the "Vendor Dashboard &rarr; Support" page.', 'astoundify-wc-themes' ),
			'id'       => 'astoundify_wc_themes_vendors_dashboard_view_support_endpoints',
			'type'     => 'text',
			'default'  => 'vendor-support',
			'desc_tip' => true,
		),

		array(
			'type'     => 'sectionend',
			'id'       => 'astoundify_wc_themes_vendors_dashboard_settings_endpoints_end',
		),
	);

	return apply_filters( 'astoundify_wc_themes_vendors_admin_get_settings_dashboard', $settings );
}
add_filter( 'woocommerce_get_settings_account', 'astoundify_wc_themes_vendors_admin_get_settings_dashboard', 99 );

/**
 * Add Vendor Archive Display Settings
 *
 * @since 1.0.0
 *
 * @param array $settings Settings configuration.
 * @return array
 */
function astoundify_wc_themes_vendors_admin_products_tab_vendor_settings( $settings ) {

	$settings[] = array(
		'title'    => esc_html__( 'Archive Display', 'astoundify-wc-themes' ),
		'id'       => ' astoundify_wc_themes_vendors_admin_products_tab_vendor_archive',
		'type'     => 'title',
		'desc'     => esc_html__( 'Vendor archives (profiles) can show sub-pages but is not prominent by default; however, some themes may utilize them.', 'astoundify-wc-themes' ),
	);

	foreach ( astoundify_wc_themes_vendors_archive_endpoints() as $key => $endpoint ) {
		$settings[] = array(
			'title'    => $endpoint['title'],
			'desc'     => sprintf( esc_html__( 'Endpoint for the "Vendor Archive &rarr; %s" page.', 'astoundify-wc-themes' ), $endpoint['title'] ),
			'id'       => sprintf( 'astoundify_wc_themes_vendors_archive_endpoints[%s]', $key ),
			'type'     => 'text',
			'default'  => $key,
			'desc_tip' => true,
		);
	}

	$settings[] = array(
		'id'       => ' astoundify_wc_themes_vendors_admin_products_tab_vendor_archive_end',
		'type'     => 'sectionend',
	);

	return $settings;
}
add_filter( 'wcpv_vendor_settings', 'astoundify_wc_themes_vendors_admin_products_tab_vendor_settings' );
