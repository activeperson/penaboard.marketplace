<?php
/**
 * Font Pack
 *
 * @since 3.6.0
 */

if ( ! defined( 'ABSPATH' ) || ! $wp_customize instanceof WP_Customize_Manager ) {
	exit; // Exit if accessed directly.
}

$wp_customize->add_setting(
	'typography-font-pack',
	[
		'default'           => 'default',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_html',
	]
);

$wp_customize->add_control(
	new Astoundify_ThemeCustomizer_Control_ControlGroup(
		$wp_customize,
		'typography-font-pack',
		[
			'label'    => esc_html_x( 'Font Pack', 'customizer control title', 'vendify' ),
			'section'  => 'typography-font-pack',
			'priority' => 10,
		]
	)
);
