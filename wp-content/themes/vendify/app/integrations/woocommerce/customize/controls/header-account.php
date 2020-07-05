<?php
/**
 * Control: Header account avatar.
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
	'header-account',
	[
		'default'           => 'always',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'header-account',
	[
		'label'           => esc_html_x( 'Display account avatar', 'customizer control label', 'vendify' ),
		'section'         => 'layout-header',
		'type'            => 'select',
		'choices'         => [
			'always'    => esc_html__( 'Always', 'vendify' ),
			'user-only' => esc_html__( 'Logged-in Only', 'vendify' ),
			'never'     => esc_html__( 'Never', 'vendify' ),
		],
		'priority'        => 51,
		'active_callback' => function() {
			return has_integration( 'woocommerce' );
		},
	]
);

$wp_customize->selective_refresh->add_partial(
	'header-account',
	[
		'selector'        => '.site-header',
		'settings'        => [ 'header-account' ],
		'render_callback' => function() {
			partial( 'header/style-' . get_theme_mod( 'header-style', 1 ) );
		},
	]
);
