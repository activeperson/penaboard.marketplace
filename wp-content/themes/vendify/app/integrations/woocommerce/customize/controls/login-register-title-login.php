<?php
/**
 * Control: Login & Register login title.
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
	'login-register-title-login',
	[
		'default'           => 'Sign In',
		'sanitize_callback' => 'sanitize_text_field',
	]
);

$wp_customize->add_control(
	'login-register-title-login',
	[
		'type'     => 'text',
		'label'    => esc_html_x( '"Sign In" Form Label', 'customizer control label', 'vendify' ),
		'section'  => 'layout-login-register',
		'priority' => 10,
	]
);
