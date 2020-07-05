<?php
/**
 * Control: Color Scheme
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
	'color-scheme',
	[
		'default'           => 'default',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	new Astoundify_ThemeCustomizer_Control_ColorScheme(
		$wp_customize,
		'color-scheme',
		[
			'label'    => esc_html_x( 'Color Scheme', 'customizer control title', 'vendify' ),
			'section'  => 'colors-scheme',
			'priority' => 0,
		]
	)
);
