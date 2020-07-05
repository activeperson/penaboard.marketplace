<?php
/**
 * Control: Login & Register content icon.
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
	'login-register-icon',
	[
		'default'           => false,
		'sanitize_callback' => 'astoundify_themecustomizer_sanitize_image_url',
	]
);

$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'login-register-icon',
		[
			'label'    => esc_html_x( 'Icon', 'customizer control label', 'vendify' ),
			'section'  => 'layout-login-register',
			'priority' => 30,
		]
	)
);
