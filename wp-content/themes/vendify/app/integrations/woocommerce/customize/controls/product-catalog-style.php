<?php
/**
 * Control: Product Catalog Style
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Customize
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use WP_Customize_Manager;

if ( ! defined( 'ABSPATH' ) || ! $wp_customize instanceof WP_Customize_Manager ) {
	exit; // Exit if accessed directly.
}

$wp_customize->add_setting(
	'product-catalog-style',
	[
		'default'           => 1,
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'product-catalog-style',
	[
		'label'       => esc_html_x( 'Product Style', 'customizer control label', 'vendify' ),
		'description' => esc_html__( 'Product catalog result card style.', 'vendify' ),
		'section'     => 'woocommerce_product_catalog',
		'type'        => 'select',
		'choices'     => [
			1 => 'Style 1',
			2 => 'Style 2',
			3 => 'Style 3',
			4 => 'Style 4',
			5 => 'Style 5',
			6 => 'Style 6',
		],
		'priority'    => 50,
	]
);

$wp_customize->add_setting(
	'product-catalog-show-shop-title',
	[
		'default'           => true,
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'product-catalog-show-shop-title',
	[
		'label'       => esc_html_x( 'Show Shop Title.', 'customizer control label', 'vendify' ),
		'section'     => 'woocommerce_product_catalog',
		'type'        => 'checkbox',
		'active_callback' => function() {
			$shop_page_id = get_option( 'woocommerce_shop_page_id' );
			// Display this option only if we are on shop page and if we have the plugin active.
			return ! empty( $shop_page_id );
		},
	]
);

$wp_customize->add_setting(
	'product-catalog-show-featured-vendors',
	[
		'default'           => true,
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'product-catalog-show-featured-vendors',
	[
		'label'       => esc_html_x( 'Show Featured Vendors.', 'customizer control label', 'vendify' ),
		'description' => esc_html__( 'Display a Featured Vendors slider as the first element on the Shop page.', 'vendify' ),
		'section'     => 'woocommerce_product_catalog',
		'type'        => 'checkbox',
		'active_callback' => function() {
			$shop_page_id = get_option( 'woocommerce_shop_page_id' );
			// Display this option only if we are on shop page and if we have the plugin active.
			return has_integration( 'woocommerce-product-vendors' ) && ! empty( $shop_page_id );
		},
	]
);

$wp_customize->add_setting(
	'product-catalog-show-page-content',
	[
		'default'           => true,
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'product-catalog-show-page-content',
	[
		'label'       => esc_html_x( 'Show Page Content.', 'customizer control label', 'vendify' ),
		'description' => esc_html__( 'You can choose to show the page content from the designate Shop page.', 'vendify' ),
		'section'     => 'woocommerce_product_catalog',
		'type'        => 'checkbox',
		'active_callback' => function() {
			$shop_page_id = get_option( 'woocommerce_shop_page_id' );
			// Display this option only if we are on shop page and if we have the plugin active.
			return ! empty( $shop_page_id );
		},
	]
);
