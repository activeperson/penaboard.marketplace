<?php
/**
 * Control: Header search.
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
	'header-search',
	[
		'default'           => true,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'header-search',
	[
		'label'    => esc_html_x( 'Display search form', 'customizer control label', 'vendify' ),
		'section'  => 'layout-header',
		'type'     => 'checkbox',
		'priority' => 30,
	]
);

$wp_customize->selective_refresh->add_partial(
	'header-search',
	[
		'selector'        => '.site-header',
		'settings'        => [ 'header-search' ],
		'render_callback' => function() {
			partial( 'header/style-' . get_theme_mod( 'header-style', 1 ) );
		},
	]
);
