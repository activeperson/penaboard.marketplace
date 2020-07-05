<?php
/**
 * Control: WooCommerce Optimized Checkout
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
	'optimized-checkout',
	[
		'default' => true,
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'optimized-checkout',
	[
		'label'       => esc_html_x( 'Optimize checkout flow.', 'customizer control label', 'vendify' ),
		'description' => esc_html__( 'Skip the cart page and send users directly to the checkout.', 'vendify' ),
		'section'     => 'woocommerce_checkout',
		'type'        => 'checkbox',
		'priority'    => 0,
	]
);
