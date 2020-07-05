<?php
/**
 * Load Astoundify Theme Customizer.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Customize
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Load Astoundify Theme Customizer
 *
 * @see https://github.com/astoundify/wp-theme-customizer
 * @see https://developer.wordpress.org/themes/advanced-topics/customizer-api/
 *
 * @since 1.0.0
 */
function vendify_astoundify_themecustomizer() {
	$lib = get_template_directory() . '/vendor/astoundify/wp-theme-customizer';

	if ( file_exists( $lib . '/astoundify-themecustomizer.php' ) ) {
		include_once $lib . '/astoundify-themecustomizer.php';

		\astoundify_themecustomizer(
			apply_filters(
				'vendify_astoundify_themecustomizer',
				[
					'stylesheet'      => 'vendify',
					'install_url'     => get_template_directory_uri() . '/vendor/astoundify/wp-theme-customizer/app',
					'install_dir'     => $lib,
					'definitions_dir' => get_template_directory() . '/app/customize',
					'generator'       => 'php',
				]
			)
		);
	}
}
add_action( 'after_setup_theme', 'vendify_astoundify_themecustomizer', 5 );

/**
 * Get the customizable typography elements.
 *
 * @since 1.0.0
 *
 * @return array $elements
 */
function vendify_customize_get_typography_elements() {
	$elements = [
		'base'     => esc_html_x( 'Global', 'customizer section title', 'vendify' ),
		'headings' => esc_html_x( 'Headings', 'customizer section title', 'vendify' ),
	];

	return $elements;
}

/**
 * Get default control settings for the Typography multi-control.
 *
 * @since 1.0.0
 *
 * @return array $controls
 */
function vendify_customize_get_default_typography_controls() {
	return [
		'font-family' => [
			'label'       => esc_html__( 'Font Family', 'vendify' ),
			'placeholder' => esc_html__( 'Search for a font...', 'vendify' ),
		],
		'font-size'   => [
			'label' => esc_html__( 'Font Size', 'vendify' ),
		],
		'font-weight' => [
			'label'       => esc_html__( 'Font Weight', 'vendify' ),
			'description' => esc_html__( 'Not all font families support all weights', 'vendify' ),
			'choices'     => [
				'200' => 200,
				'300' => 300,
				'400' => 400,
				'500' => 500,
				'600' => 600,
				'700' => 700,
			],
		],
		'line-height' => [
			'label' => esc_html__( 'Line Height', 'vendify' ),
		],
	];
}

/**
 * A list of color controls.
 *
 * @since 1.0.0
 *
 * @param string $controls The type of colors to return.
 * @return array
 */
function vendify_customize_get_theme_color_controls( $controls = 'all' ) {
	$colors = [
		'color-primary'     => esc_html_x( 'Primary', 'customizer control label', 'vendify' ),
		'color-secondary'   => esc_html_x( 'Secondary', 'customizer control label', 'vendify' ),
		'color-light'       => esc_html_x( 'Light', 'customizer control label', 'vendify' ),
		'color-dark'        => esc_html_x( 'Dark', 'customizer control label', 'vendify' ),
		'color-success'     => esc_html_x( 'Success', 'customizer control label', 'vendify' ),
		'color-information' => esc_html_x( 'Information', 'customizer control label', 'vendify' ),
		'color-warning'     => esc_html_x( 'Warning', 'customizer control label', 'vendify' ),
		'color-danger'      => esc_html_x( 'Danger', 'customizer control label', 'vendify' ),
	];

	$global = [
		'color-body-color' => esc_html_x( 'Text', 'customizer control label', 'vendify' ),
		'color-menu-bg'    => esc_html_x( 'Menu Background', 'customizer control label', 'vendify' ),
		'color-menu-color' => esc_html_x( 'Menu Text', 'customizer control label', 'vendify' ),
	];

	if ( 'all' === $controls ) {
		return array_merge( $global, $colors );
	}

	return $$controls;
}

/**
 * A list of typography controls.
 *
 * @since 1.0.0
 *
 * @return array
 */
function vendify_customize_get_theme_typography() {
	return [
		'base'     => esc_html_x( 'Base', 'customizer control label', 'vendify' ),
		'headings' => esc_html_x( 'Headings', 'customizer control label', 'vendify' ),
	];
}

/**
 * Convert a HEX value to RGBA.
 *
 * @since 1.0.0
 *
 * @param string $color HEX value.
 * @param int    $opacity Opacity to use.
 * @return string
 */
function vendify_customize_hex_to_rgba( $color, $opacity = false ) {
	if ( '#' === $color[0] ) {
		$color = substr( $color, 1 );
	}

	if ( 6 === strlen( $color ) ) {
		$hex = [ $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] ];
	} elseif ( 3 === strlen( $color ) ) {
		$hex = [ $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] ];
	} else {
		return $color;
	}

	$rgb = array_map( 'hexdec', $hex );

	if ( $opacity ) {
		if ( abs( $opacity ) > 1 ) {
			$opacity = 1.0;
		}

		$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
	} else {
		$output = 'rgb(' . implode( ',', $rgb ) . ')';
	}

	return $output;
}

/**
 * Generate button and badge configs for theme colors.
 *
 * @since 1.0.0
 *
 * @param string $color Color.
 * @param array  $configs Configs.
 * @return array
 */
function vendify_customize_theme_color_elements( $color, $configs ) {
	$config = [];

	if ( ! empty( $configs['btn'] ) ) {
		$config[] = [
			'selectors'    => $configs['btn'],
			'declarations' => [
				'background-color' => esc_attr( $color ),
				'border-color'     => esc_attr( $color ),
			],
		];

		$config[] = [
			'selectors'    => vendify_customize_add_hover_to_selector_list( $configs['btn'] ),
			'declarations' => [
				'background-color' => esc_attr( astoundify_themecustomizer_darken_hex( $color, -10 ) ),
				'border-color'     => esc_attr( astoundify_themecustomizer_darken_hex( $color, -10 ) ),
				'box-shadow'       => esc_attr( '0 2px 5px 1px ' . vendify_customize_hex_to_rgba( astoundify_themecustomizer_get_colorscheme_mod( 'color-dark' ), 0.1 ) ),
			],
		];
	}

	if ( ! empty( $configs['btn-outline'] ) ) {
		$config[] = [
			'selectors'    => $configs['btn-outline'],
			'declarations' => [
				'color'            => esc_attr( $color ),
				'border-color'     => esc_attr( vendify_customize_hex_to_rgba( $color, 0.40 ) ),
			],
		];

		$config[] = [
			'selectors'    => vendify_customize_add_hover_to_selector_list( $configs['btn-outline'] ),
			'declarations' => [
				'color'            => esc_attr( $color ),
				'border-color'     => esc_attr( vendify_customize_hex_to_rgba( $color, 0.75 ) ),
			],
		];
	}

	if ( ! empty( $configs['badge'] ) ) {
		$text_color = '#fff';
		if ( astoundify_hex_is_light( $color ) ) {
			$text_color = '#000';
		}
		$config[] = [
			'selectors'    => $configs['badge'],
			'declarations' => [
				'background-color' => esc_attr( $color ),
				'color'            => esc_attr( $text_color ),
			],
		];
	}

	if ( ! empty( $configs['badge-outline'] ) ) {
		$config[] = [
			'selectors'    => $configs['badge-outline'],
			'declarations' => [
				'border-color'     => esc_attr( vendify_customize_hex_to_rgba( $color, 0.25 ) ),
				'color'            => esc_attr( $color ),
			],
		];

		$config[] = [
			'selectors'    => vendify_customize_add_hover_to_selector_list( $configs['badge-outline'] ),
			'declarations' => [
				'border-color' => esc_attr( vendify_customize_hex_to_rgba( $color, 0.75 ) ),
				'color'        => esc_attr( $color ),
			],
		];
	}

	return $config;
}

/**
 * Add :hover to a list of selectors.
 *
 * @since 1.0.0
 *
 * @param array $selectors Selectors
 * @return array
 */
function vendify_customize_add_hover_to_selector_list( $selectors ) {
	$_selectors = [];

	foreach ( $selectors as $selector ) {
		$_selectors[] = $selector . ':hover';
		$_selectors[] = $selector . ':not(:disabled):not(.disabled):active';
		$_selectors[] = $selector . ':focus';
	}

	return $_selectors;
}

/**
 * Add Style class to body.
 *
 * @param $classes
 *
 * @return array
 */
function vendify_update_body_class( $classes ) {

	$style = get_theme_mod( 'style-kit', 'default' );
	if ( $style ) {
		$classes[] = 'style-' . $style;
	}

	return $classes;
}
add_filter( 'body_class', 'vendify_update_body_class' );
