<?php
/**
 * Control: Style kit.
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
	'style-kit',
	[
		'default'           => 'default',
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	new Astoundify_ThemeCustomizer_Control_StyleKit(
		$wp_customize,
		'style-kit',
		[
			'label'       => esc_html_x( 'Style Kit', 'customizer control title', 'vendify' ),
			'section'     => 'style-kit',
			'priority'    => 10,
			'screenshots' => get_template_directory_uri() . '/public/images/customize/',
		]
	)
);
