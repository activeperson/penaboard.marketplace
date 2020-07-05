<?php
/**
 * Control: Login & Register gallery.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Customize
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use WP_Customize_Manager;
use Astoundify_ThemeCustomizer_Control_ImageGallery;

if ( ! defined( 'ABSPATH' ) || ! $wp_customize instanceof WP_Customize_Manager ) {
	exit; // Exit if accessed directly.
}

$wp_customize->add_setting(
	'login-register-gallery',
	[
		'default'           => [],
		'sanitize_callback' => 'astoundify_themecustomizer_sanitize_array_of_int',
	]
);

$wp_customize->add_control(
	new Astoundify_ThemeCustomizer_Control_ImageGallery(
		$wp_customize,
		'login-register-gallery',
		[
			'label'           => esc_html_x( 'Image Slider', 'customizer control label', 'vendify' ),
			'labels'          => [
				'select'       => esc_html__( 'Select images', 'vendify' ),
				'change'       => esc_html__( 'Choose images', 'vendify' ),
				'remove'       => esc_html__( 'Remove images', 'vendify' ),
				'frame_title'  => esc_html__( 'Select images', 'vendify' ),
				'frame_button' => esc_html__( 'Select images', 'vendify' ),
				'placeholder'  => esc_html__( 'No images selected', 'vendify' ),
			],
			'section'         => 'layout-login-register',
			'priority'        => 50,
			'active_callback' => function() {
				return has_integration( 'woocommerce' );
			},
		]
	)
);
