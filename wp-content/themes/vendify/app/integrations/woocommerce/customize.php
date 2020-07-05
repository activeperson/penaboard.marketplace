<?php
/**
 * Load Astoundify Theme Customizer.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Customize
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Ensure WooCommerce customizer settings always show.
 *
 * We will use these customizer values for our defaults.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customize manager.
 */
function vendify_customize_register( $wp_customize ) {
	if ( $wp_customize->get_section( 'woocommerce_product_grid' ) ) {
		$wp_customize->get_section( 'woocommerce_product_grid' )->active_callback = '__return_true';
	}

	if ( $wp_customize->get_control( 'woocommerce_catalog_columns' ) ) {
		$wp_customize->get_control( 'woocommerce_catalog_columns' )->label = esc_html__( 'Maximum products per row', 'vendify' );
	}
}
add_action( 'customize_register', 'vendify_customize_register' );
