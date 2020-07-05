<?php
/**
 * External Product Functions.
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
 * Product Type Options
 *
 * @since 1.0.0
 *
 * @param array $options Options.
 * @return array
 */
function astoundify_wc_themes_events_product_type_options( $options = array() ) {

	$options['external_event'] = array(
		'id'            => '_external_event',
		'wrapper_class' => 'show_if_event',
		'label'         => esc_html__( 'External Event', 'astoundify-wc-themes' ),
		'description'   => esc_html__( 'Enable if external event.', 'astoundify-wc-themes' ),
		'default'       => 'no',
	);

	return $options;
}
add_filter( 'product_type_options', 'astoundify_wc_themes_events_product_type_options' );

/**
 * Add General Tab Fields For External Ticket
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_external_fields() {
	require_once( ASTOUNDIFY_WC_THEMES_TEMPLATE_PATH . '/admin/panel-general-external.php' );
}
add_action( 'woocommerce_product_options_general_product_data', 'astoundify_wc_themes_events_external_fields' );

/**
 * Save product data.
 *
 * @since 1.0.0
 *
 * @param WC_Product $product Current product.
 */
function astoundify_wc_themes_events_admin_external_process_product_object( $product ) {
	// @codingStandardsIgnoreStart
	$errors = $product->set_props( array(
		'external_event'  => isset( $_POST['_external_event'] ) ? 'yes' : 'no',
		'ticket_url'      => isset( $_POST['_ticket_url'] ) ? esc_url( $_POST['_ticket_url'] ) : '',
		'ticket_provider' => isset( $_POST['_ticket_provider'] ) ? esc_attr( $_POST['_ticket_provider'] ) : '',
	) );

	if ( is_wp_error( $errors ) ) {
		WC_Admin_Meta_Boxes::add_error( $errors->get_error_message() );
	}
	// @codingStandardsIgnoreEnd
}
add_action( 'woocommerce_admin_process_product_object', 'astoundify_wc_themes_events_admin_external_process_product_object' );

