<?php
/**
 * Control: Login & Register autoplay.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Customize
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use WP_Customize_Manager;

if ( ! defined( 'ABSPATH' ) || ! $wp_customize instanceof WP_Customize_Manager ) {
	exit; // Exit if accessed directly.
}

$wp_customize->add_setting(
	'login-register-gallery-autoplay',
	[
		'default'           => 4.5,
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'login-register-gallery-autoplay',
	[
		'label'           => esc_html__( 'Autoplay delay (seconds)', 'vendify' ),
		'description'     => esc_html__( '0 to disable', 'vendify' ),
		'type'            => 'number',
		'input_attrs'     => [
			'min'  => 0,
			'max'  => 10,
			'step' => 0.5,
		],
		'section'         => 'layout-login-register',
		'priority'        => 70,
		'active_callback' => function() {
			return has_integration( 'woocommerce' );
		},
	]
);
