<?php
/**
 * Control: Login & Register content.
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
	'login-register-content',
	[
		'default'           => "It's free and easy!\n\n<a href='#' class='btn btn-outline-light'>Learn More</a>",
		'sanitize_callback' => 'wp_kses_post',
	]
);

$wp_customize->add_control(
	'login-register-content',
	[
		'type'     => 'textarea',
		'label'    => esc_html_x( 'Content', 'customizer control label', 'vendify' ),
		'section'  => 'layout-login-register',
		'priority' => 50,
	]
);
