<?php
/**
 * Sponsors Functions.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Admin
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Sponsors Tab in Product Data Meta Box.
 *
 * @since 1.0.0
 *
 * @param array $tabs Tabs.
 * @return array
 */
function astoundify_wc_themes_events_sponsors_product_data_tabs( $tabs ) {
	$tabs['sponsors'] = array(
		'label'    => esc_html__( 'Sponsors', 'astoundify-wc-themes' ),
		'target'   => 'sponsors_product_data', // Target panel HTML ID in panel callback.
		'class'    => array( 'show_if_event' ),
		'priority' => 23,
	);

	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'astoundify_wc_themes_events_sponsors_product_data_tabs' );

/**
 * Add Panel for Sponsors Tab in Product Data Meta Box.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_sponsors_product_data_panels() {
	echo '<div id="sponsors_product_data" class="panel wc-metaboxes-wrapper">';
		require_once( ASTOUNDIFY_WC_THEMES_TEMPLATE_PATH . '/admin/panel-sponsors.php' );
	echo '</div>';
}
add_action( 'woocommerce_product_data_panels', 'astoundify_wc_themes_events_sponsors_product_data_panels' );

/**
 * Save product data.
 *
 * @since 1.0.0
 *
 * @param WC_Product $product Current product.
 */
function astoundify_wc_themes_events_sponsors_admin_process_product_object( $product ) {
	// @codingStandardsIgnoreStart
	$errors = $product->set_props( array(
		'sponsors' => isset( $_POST['wc_themes_sponsors'] ) ? $_POST['wc_themes_sponsors'] : array(),
	) );

	if ( is_wp_error( $errors ) ) {
		WC_Admin_Meta_Boxes::add_error( $errors->get_error_message() );
	}
	// @codingStandardsIgnoreEnd
}
add_action( 'woocommerce_admin_process_product_object', 'astoundify_wc_themes_events_sponsors_admin_process_product_object' );
