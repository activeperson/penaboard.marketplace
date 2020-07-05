<?php
/**
 * Control: Product Catalog Vendors
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Customize
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) || ! $wp_customize instanceof WP_Customize_Manager ) {
	exit; // Exit if accessed directly.
}

$wp_customize->add_setting(
	'product-catalog-vendors',
	[
		'default'           => false,
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'product-catalog-vendors',
	[
		'label'    => esc_html_x( 'Display Vendor Tabs', 'customizer control label', 'vendify' ),
		'section'  => 'woocommerce_product_catalog',
		'type'     => 'checkbox',
		'priority' => 60,
	]
);
