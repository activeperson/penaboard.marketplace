<?php
/**
 * Control: Content Header Style
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
	'header-style',
	[
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'header-style',
	[
		'label'    => esc_html_x( 'Header Style', 'customizer control label', 'vendify' ),
		'section'  => 'layout-header',
		'type'     => 'select',
		'choices'  => [
			1 => 'Style 1',
			2 => 'Style 2',
			3 => 'Style 3',
			4 => 'Style 4',
			5 => 'Style 5',
		],
		'priority' => 20,
	]
);

$wp_customize->selective_refresh->add_partial(
	'header-style',
	[
		'selector'        => '.site-header',
		'settings'        => [ 'header-style' ],
		'render_callback' => function() {
			partial( 'header/style-' . get_theme_mod( 'header-style', 1 ) );
		},
		'container_inclusive' => true,
	]
);
