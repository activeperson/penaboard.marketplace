<?php
/**
 * Control: Login & Register register title.
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
	'login-register-title-register',
	[
		'default'           => 'Create an Account',
		'sanitize_callback' => 'sanitize_text_field',
	]
);

$wp_customize->add_control(
	'login-register-title-register',
	[
		'type'     => 'text',
		'label'    => esc_html_x( '"Sign Up" Form Label', 'customizer control label', 'vendify' ),
		'section'  => 'layout-login-register',
		'priority' => 20,
	]
);
