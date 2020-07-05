<?php
/**
 * Section: Login & Register
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

$wp_customize->add_section(
	'layout-login-register',
	[
		'title'    => esc_html_x( 'Login & Register Overlay', 'customizer section title', 'vendify' ),
		'panel'    => 'layout',
		'priority' => 30,
	]
);
