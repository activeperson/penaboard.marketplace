<?php
/**
 * Control: Custom Logo (Transparent)
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
	'custom-logo-alt',
	[
		'theme_supports'    => [ 'custom-logo' ],
		'sanitize_callback' => 'sanitize_text_field',
	]
);

$custom_logo_args = get_theme_support( 'custom-logo' );

$wp_customize->add_control(
	new WP_Customize_Cropped_Image_Control(
		$wp_customize,
		'custom-logo-alt',
		[
			'label'         => esc_html__( 'Alternative Logo', 'vendify' ),
			'description'   => esc_html__( 'Used on pages with a transparent header.', 'vendify' ),
			'section'       => 'title_tagline',
			'priority'      => 8,
			'height'        => $custom_logo_args[0]['height'],
			'width'         => $custom_logo_args[0]['width'],
			'flex_height'   => $custom_logo_args[0]['flex-height'],
			'flex_width'    => $custom_logo_args[0]['flex-width'],
			'button_labels' => [
				'select'       => esc_html__( 'Select logo', 'vendify' ),
				'change'       => esc_html__( 'Change logo', 'vendify' ),
				'remove'       => esc_html__( 'Remove', 'vendify' ),
				'default'      => esc_html__( 'Default', 'vendify' ),
				'placeholder'  => esc_html__( 'No logo selected', 'vendify' ),
				'frame_title'  => esc_html__( 'Select logo', 'vendify' ),
				'frame_button' => esc_html__( 'Choose logo', 'vendify' ),
			],
		]
	)
);
