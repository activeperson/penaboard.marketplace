<?php
/**
 * Control: Global Colors
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

$priority = 20;
$colors   = vendify_customize_get_theme_color_controls( 'global' );

foreach ( $colors as $key => $label ) {
	$wp_customize->add_setting(
		$key,
		[
			'default'           => astoundify_themecustomizer_get_colorscheme_mod_default( $key ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		]
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$key,
			[
				'label'    => $label,
				'section'  => 'colors-global',
				'priority' => $priority,
			]
		)
	);

	$priority = $priority + 10;
}
