<?php
/**
 * Section: Typography Pack
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
	'typography-font-pack',
	[
		'title'    => esc_html_x( 'Font Pack', 'customizer section title', 'vendify' ),
		'panel'    => 'typography',
		'priority' => 10,
	]
);
