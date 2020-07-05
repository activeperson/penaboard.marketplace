<?php
/**
 * Typography
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

$wp_customize->add_control(
	new Astoundify_ThemeCustomizer_Control_Typography(
		$wp_customize,
		[
			'selector' => 'base',
			'source'   => 'googlefonts',
			'controls' => vendify_customize_get_default_typography_controls(),
			'section'  => 'typography-base',
		]
	)
);

// Headings size and line height are determined by hard coded CSS.
$heading_controls = vendify_customize_get_default_typography_controls();

unset( $heading_controls['font-size'] );
unset( $heading_controls['line-height'] );

$wp_customize->add_control(
	new Astoundify_ThemeCustomizer_Control_Typography(
		$wp_customize,
		[
			'selector' => 'headings',
			'source'   => 'googlefonts',
			'controls' => $heading_controls,
			'section'  => 'typography-headings',
		]
	)
);
