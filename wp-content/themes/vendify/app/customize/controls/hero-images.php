<?php
/**
 * Control: Hero images.
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
	'hero-images',
	[
		'default'           => [],
		'sanitize_callback' => 'astoundify_themecustomizer_sanitize_array_of_int',
	]
);

$wp_customize->add_control(
	new Astoundify_ThemeCustomizer_Control_ImageGallery(
		$wp_customize,
		'hero-images',
		[
			'label'       => esc_html_x( 'Hero Images', 'customizer control label', 'vendify' ),
			'description' => esc_html__( 'Fallback images for pages that do not have a set Featured Image. Multiple images will randomly be shown.', 'vendify' ),
			'labels'      => [
				'select'       => esc_html__( 'Select images', 'vendify' ),
				'change'       => esc_html__( 'Choose images', 'vendify' ),
				'remove'       => esc_html__( 'Remove images', 'vendify' ),
				'frame_title'  => esc_html__( 'Select images', 'vendify' ),
				'frame_button' => esc_html__( 'Select images', 'vendify' ),
				'placeholder'  => esc_html__( 'No images selected', 'vendify' ),
			],
			'section'     => 'layout-hero',
			'priority'    => 10,
		]
	)
);
