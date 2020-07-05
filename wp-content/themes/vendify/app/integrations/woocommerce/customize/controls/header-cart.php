<?php
/**
 * Control: Header Cart icon.
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
	'header-cart',
	[
		'default'           => 'always',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'header-cart',
	[
		'label'           => esc_html_x( 'Display mini cart', 'customizer control label', 'vendify' ),
		'section'         => 'layout-header',
		'type'            => 'select',
		'choices'         => [
			'always'    => esc_html__( 'Always', 'vendify' ),
			'user-only' => esc_html__( 'Logged-in Only', 'vendify' ),
			'never'     => esc_html__( 'Never', 'vendify' ),
		],
		'priority'        => 50,
		'active_callback' => function() {
			return has_integration( 'woocommerce' );
		},
	]
);

$wp_customize->selective_refresh->add_partial(
	'header-cart',
	[
		'selector'        => '.site-header',
		'settings'        => [ 'header-cart' ],
		'render_callback' => function() {
			partial( 'header/style-' . get_theme_mod( 'header-style', 1 ) );
		},
	]
);
