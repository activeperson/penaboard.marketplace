<?php
/**
 * Section: Blog
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
	'content-blog',
	[
		'title'    => esc_html_x( 'Blog', 'customizer section title (colors)', 'vendify' ),
		'panel'    => 'layout',
		'priority' => 20,
	]
);
