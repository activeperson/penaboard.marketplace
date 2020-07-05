<?php
/**
 * Section: Global Colors
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
	'colors-colors',
	[
		'title'    => esc_html_x( 'Palette', 'customizer section title (colors)', 'vendify' ),
		'panel'    => 'colors',
		'priority' => 30,
	]
);
