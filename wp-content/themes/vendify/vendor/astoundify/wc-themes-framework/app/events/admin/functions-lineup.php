<?php
/**
 * Lineup Functions.
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
 * Add Lineup Tab in Product Data Meta Box.
 *
 * @since 1.0.0
 *
 * @param array $tabs Tabs.
 * @return array
 */
function astoundify_wc_themes_lineup_product_data_tabs( $tabs ) {
	$tabs['lineup'] = array(
		'label'    => esc_html__( 'Lineup', 'astoundify-wc-themes' ),
		'target'   => 'lineup_product_data', // Target panel HTML ID in panel callback.
		'class'    => array( 'show_if_event' ),
		'priority' => 24,
	);
	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'astoundify_wc_themes_lineup_product_data_tabs' );

/**
 * Add Panel for Lineup Tab in Product Data Meta Box.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_lineup_product_data_panels() {
	echo '<div id="lineup_product_data" class="panel wc-metaboxes-wrapper">';
		require_once( ASTOUNDIFY_WC_THEMES_TEMPLATE_PATH . '/admin/panel-lineup.php' );
	echo '</div>';
}
add_action( 'woocommerce_product_data_panels', 'astoundify_wc_themes_lineup_product_data_panels' );

/**
 * Save product data.
 *
 * @since 1.0.0
 *
 * @param WC_Product $product Current product.
 */
function astoundify_wc_themes_lineup_admin_process_product_object( $product ) {
	// @codingStandardsIgnoreStart
	$errors = $product->set_props( array(
		'lineup' => isset( $_POST['wc_themes_lineup'] ) ? $_POST['wc_themes_lineup'] : array(),
	) );

	if ( is_wp_error( $errors ) ) {
		WC_Admin_Meta_Boxes::add_error( $errors->get_error_message() );
	}
	// @codingStandardsIgnoreEnd
}
add_action( 'woocommerce_admin_process_product_object', 'astoundify_wc_themes_lineup_admin_process_product_object' );

