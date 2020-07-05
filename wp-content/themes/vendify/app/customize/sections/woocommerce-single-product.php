<?php
/**
 * Section: (WooCommerce) > Product
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

$wp_customize->add_section(
	'vendify-wc-product',
	[
		'title'    => esc_html_x( 'Product Page', 'customizer section title (colors)', 'vendify' ),
		'panel'    => 'woocommerce',
		'priority' => 30,
	]
);
