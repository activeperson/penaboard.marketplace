<?php
/**
 * Product Location Functions.
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
 * Add Location Tab in Product Data Meta Box.
 *
 * @since 1.0.0
 *
 * @param array $tabs Tabs.
 * @return array
 */
function astoundify_wc_themes_location_product_data_tabs( $tabs ) {
	$tabs['location'] = array(
		'label'    => esc_html__( 'Location', 'astoundify-wc-themes' ),
		'target'   => 'location_product_data', // Target panel HTML ID in panel callback.
		'class'    => array( 'show_if_event' ),
		'priority' => 20,
	);
	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'astoundify_wc_themes_location_product_data_tabs' );

/**
 * Add Panel for Location Tab in Product Data Meta Box.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_location_product_data_panels() {
	echo '<div id="location_product_data" class="panel woocommerce_options_panel">';
		require_once( ASTOUNDIFY_WC_THEMES_TEMPLATE_PATH . '/admin/panel-location.php' );
	echo '</div>';
}
add_action( 'woocommerce_product_data_panels', 'astoundify_wc_themes_location_product_data_panels' );

/**
 * Save product data.
 *
 * @since 1.0.0
 *
 * @param WC_Product $product Current product.
 */
function astoundify_wc_themes_location_admin_process_product_object( $product ) {
	// @codingStandardsIgnoreStart

	// Only update if there is an original input location.
	if ( ! isset( $_POST['address'] ) ) {
		return;
	}

	$errors = $product->set_props( array(
		'location_address_1' => wc_clean( $_POST['address_1'] ),
		'location_address_2' => wc_clean( $_POST['address_2'] ),
		'location_city' => wc_clean( $_POST['city'] ),
		'location_state' => wc_clean( $_POST['state'] ),
		'location_postcode' => wc_clean( $_POST['postcode'] ),
		'location_country' => wc_clean( $_POST['country'] ),
		'location_longitude' => wc_clean( $_POST['longitude'] ),
		'location_latitude' => wc_clean( $_POST['latitude'] ),
		'location_formatted' => esc_attr( $_POST['formatted'] ),
		'location_input' => wc_clean( $_POST['address'] ),
	) );

	// @codingStandardsIgnoreEnd

	if ( is_wp_error( $errors ) ) {
		WC_Admin_Meta_Boxes::add_error( $errors->get_error_message() );
	}
}
add_action( 'woocommerce_admin_process_product_object', 'astoundify_wc_themes_location_admin_process_product_object' );
