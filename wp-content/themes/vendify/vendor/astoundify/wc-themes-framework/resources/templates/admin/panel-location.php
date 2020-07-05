<?php
/**
 * Location tab panel.
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

global $product_object;

add_filter( 'astoundify_wc_themes_events_product_data_js', function( $data ) use ( $product_object ) {
	$data['location']['data'] = array(
		'address'     => method_exists( $product_object, 'get_location_input' ) ? $product_object->get_location_input() : false,
		'address_1'   => method_exists( $product_object, 'get_location_address_1' ) ? $product_object->get_location_address_1() : false,
		'address_2'   => method_exists( $product_object, 'get_location_address_2' ) ? $product_object->get_location_address_2() : false,
		'city'        => method_exists( $product_object, 'get_location_city' ) ? $product_object->get_location_city() : false,
		'postcode'    => method_exists( $product_object, 'get_location_postcode' ) ? $product_object->get_location_postcode() : false,
		'country'     => method_exists( $product_object, 'get_location_country' ) ? $product_object->get_location_country() : false,
		'state'       => method_exists( $product_object, 'get_location_state' ) ? $product_object->get_location_state() : false,
		'latitude'    => method_exists( $product_object, 'get_location_latitude' ) ? $product_object->get_location_latitude() : false,
		'longitude'   => method_exists( $product_object, 'get_location_longitude' ) ? $product_object->get_location_longitude() : false,
	);

	return $data;
} );

echo '<div id="astoundify-wc-themes-product-location-fields">';

woocommerce_wp_text_input( array(
	'id'                => 'address',
	'label'             => esc_html__( 'Location', 'astoundify-wc-themes' ),
) );

echo '<div id="astoundify-wc-themes-product-location-map"></div>';

woocommerce_wp_textarea_input( array(
	'id'                => 'formatted',
	'label'             => esc_html__( 'Formatted Address', 'astoundify-wc-themes' ),
	'value'             => method_exists( $product_object, 'get_location_formatted' ) ? $product_object->get_location_formatted() : false,
	'description'       => esc_html__( 'Optional display address. Will use location input if empty.', 'astoundify-wc-themes' ),
	'desc_tip'          => true,
) );

woocommerce_wp_text_input( array(
	'id'                => 'address_1',
	'label'             => esc_html__( 'Address 1', 'astoundify-wc-themes' ),
) );

woocommerce_wp_text_input( array(
	'id'                => 'address_2',
	'label'             => esc_html__( 'Address 2', 'astoundify-wc-themes' ),
) );

woocommerce_wp_text_input( array(
	'id'                => 'city',
	'label'             => esc_html__( 'City', 'astoundify-wc-themes' ),
) );

woocommerce_wp_text_input( array(
	'id'                => 'postcode',
	'label'             => esc_html__( 'Postcode / ZIP', 'astoundify-wc-themes' ),
) );

woocommerce_wp_select( array(
	'id'                => 'country',
	'label'             => esc_html__( 'Country', 'astoundify-wc-themes' ),
	'class'             => 'js_field-country select',
	'style'             => 'width:100%;',
	'options'           => array(
		'' => esc_html__( 'Select a country&hellip;', 'astoundify-wc-themes' ),
	) + WC()->countries->get_allowed_countries(),
) );

woocommerce_wp_text_input( array(
	'id'                => 'state',
	'label'             => esc_html__( 'State / County', 'astoundify-wc-themes' ),
	'class'             => 'js_field-state select',
) );

woocommerce_wp_text_input( array(
	'id'                => 'latitude',
	'label'             => esc_html__( 'Latitude', 'astoundify-wc-themes' ),
) );

woocommerce_wp_text_input( array(
	'id'                => 'longitude',
	'label'             => esc_html__( 'Longitude', 'astoundify-wc-themes' ),
) );

echo '</div>';
?>

<style>
#astoundify-wc-themes-product-location-map {
	width: 100%;
	height: 200px;
}
</style>
