<?php
/**
 * Control: Content Blog Layout
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
	'blog-style',
	[
		'default' => 'classic',
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'blog-style',
	[
		'label'    => esc_html_x( 'Blog Card Style', 'customizer control label', 'vendify' ),
		'section'  => 'content-blog',
		'type'     => 'select',
		'choices'  => [
			'classic' => 'Classic',
			'card'    => 'Card',
			'dark'    => 'Dark',
		],
		'priority' => 10,
	]
);
