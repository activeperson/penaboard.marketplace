<?php
/**
 * Control: Login & Register overlay.
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
	'login-register-gallery-overlay',
	[
		'default'           => 0.5,
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'login-register-gallery-overlay',
	[
		'label'           => esc_html__( 'Overlay Dim', 'vendify' ),
		'type'            => 'number',
		'input_attrs'     => [
			'min'  => 0,
			'max'  => 1,
			'step' => 0.1,
		],
		'section'         => 'layout-login-register',
		'priority'        => 60,
		'active_callback' => function() {
			return has_integration( 'woocommerce' );
		},
	]
);
