<?php
/**
 * Panel: Typography
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

$wp_customize->add_panel(
	'typography',
	[
		'title'    => esc_html_x( 'Typography', 'customizer panel title', 'vendify' ),
		'priority' => 26,
	]
);
