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

namespace Astoundify\Vendify;

use WP_Customize_Manager;

if ( ! defined( 'ABSPATH' ) || ! $wp_customize instanceof WP_Customize_Manager ) {
	exit; // Exit if accessed directly.
}

$wp_customize->add_setting(
	'product-gallery-style',
	[
		'default'           => is_multiple_vendors() ? 1 : 2,
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'product-gallery-style',
	[
		'label'    => esc_html_x( 'Gallery style', 'customizer control label', 'vendify' ),
		'section'  => 'vendify-wc-product',
		'type'     => 'select',
		'choices'  => [
			1 => esc_html__( 'Style 1', 'vendify' ),
			2 => esc_html__( 'Style 2', 'vendify' ),
		],
		'priority' => 10,
	]
);
