<?php
/**
 * Section: Header
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
	'layout-header',
	[
		'title'    => esc_html_x( 'Header &amp; Navigation', 'customizer section title (colors)', 'vendify' ),
		'panel'    => 'layout',
		'priority' => 10,
	]
);
