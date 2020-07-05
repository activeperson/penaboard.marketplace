<?php
/**
 * Settings.
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
 * Add Product Settings Section
 *
 * @since 1.0.0
 *
 * @param array $sections Settings sections.
 * @return array
 */
function astoundify_wc_themes_events_admin_products_settings_section( $sections ) {
	$sections['astoundify_wc_themes_event_settings'] = esc_html__( 'Events', 'astoundify-wc-themes' );
	return $sections;
}
add_filter( 'woocommerce_get_sections_products', 'astoundify_wc_themes_events_admin_products_settings_section' );

/**
 * Add Products Events Settings
 *
 * @since 1.0.0
 *
 * @param array $settings Existing settings.
 * @return array $settings
 */
function astoundify_wc_themes_events_admin_get_settings_products( $settings ) {
	if ( ! ( isset( $_GET['section'] ) && 'astoundify_wc_themes_event_settings' === $_GET['section'] ) ) {
		return $settings;
	}

	$settings = array(

		// External Ticket Settings.
		array(
			'title'    => esc_html__( 'External Tickets', 'astoundify-wc-themes' ),
			'id'       => 'astoundify_wc_themes_events_external_settings',
			'type'     => 'title',
		),

		array(
			'title'    => __( 'Ticketmaster URL', 'astoundify-wc-themes' ),
			'desc'     => __( 'Add affiliate ID to all Ticketmaster events URL.', 'astoundify-wc-themes' ),
			'id'       => 'astoundify_wc_themes_events_external_tickets_affiliate_info[ticketmaster]',
			'default'  => '',
			'type'     => 'text',
		),

		array(
			'title'    => __( 'Eventbrite URL', 'astoundify-wc-themes' ),
			'desc'     => __( 'Add affiliate ID to all Eventbrite events URL.', 'astoundify-wc-themes' ),
			'id'       => 'astoundify_wc_themes_events_external_tickets_affiliate_info[eventbrite]',
			'default'  => '',
			'type'     => 'text',
		),

		array(
			'type'     => 'sectionend',
			'id'       => 'astoundify_wc_themes_events_external_settings_end',
		),

	);

	return apply_filters( 'astoundify_wc_themes_events_admin_get_settings_products', $settings );
}
add_filter( 'woocommerce_get_settings_products', 'astoundify_wc_themes_events_admin_get_settings_products', 99 );
