<?php
/**
 * Section: Hero
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
	'layout-hero',
	[
		'title'    => esc_html_x( 'Page Headers', 'customizer section title (colors)', 'vendify' ),
		'panel'    => 'layout',
		'priority' => 15,
	]
);
