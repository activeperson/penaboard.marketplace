<?php
/**
 * Control: Content Header Transparency.
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
	'header-transparency',
	[
		'default' => true,
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'header-transparency',
	[
		'label'       => esc_html_x( 'Use transparent header', 'customizer control label', 'vendify' ),
		'description' => esc_html__( 'Use transparent header on available pages.', 'vendify' ),
		'section'     => 'layout-header',
		'type'        => 'checkbox',
		'priority'    => 25,
	]
);
