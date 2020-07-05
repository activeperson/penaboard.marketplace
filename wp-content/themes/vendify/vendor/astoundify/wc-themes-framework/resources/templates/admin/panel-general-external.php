<?php
/**
 * External Ticket Fields in General Tab
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category View
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Product object.
global $product_object;
?>

<div id="events-external-fields" class="options_group show_if_external_event">

	<?php
		woocommerce_wp_select( array(
			'id'             => '_ticket_provider',
			'value'          => is_callable( array( $product_object, 'get_ticket_provider' ) ) ? $product_object->get_ticket_provider( 'edit' ) : '',
			'label'          => esc_html__( 'Ticket Provider', 'astoundify-wc-themes' ),
			'options'        => astoundify_wc_themes_events_get_external_ticket_providers(),
			'desc_tip'       => true,
			'description'    => esc_html__( 'Select external ticket provider.', 'astoundify-wc-themes' ),
		) );
	?>

	<?php
		woocommerce_wp_text_input( array(
			'id'             => '_ticket_url',
			'value'          => is_callable( array( $product_object, 'get_ticket_url' ) ) ? $product_object->get_ticket_url( 'edit' ) : '',
			'label'          => esc_html__( 'Ticket URL', 'astoundify-wc-themes' ),
			'placeholder'    => 'http://',
			'desc_tip'       => true,
			'description'    => esc_html__( 'Enter the external URL to purchase the ticket.', 'astoundify-wc-themes' ),
		) );
	?>

	<?php do_action( 'astoundify_wc_themes_events_options_external_ticket' ); ?>

</div>
