<?php
/**
 * Control: Header Private Messages icon.
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
	'header-private-messages',
	[
		'default'           => 'user-only',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_attr',
	]
);

$wp_customize->add_control(
	'header-private-messages',
	[
		'label'           => esc_html_x( 'Display recent messages', 'customizer control label', 'vendify' ),
		'section'         => 'layout-header',
		'type'            => 'select',
		'choices'         => [
			'always'    => esc_html__( 'Always', 'vendify' ),
			'user-only' => esc_html__( 'Logged-in Only', 'vendify' ),
			'never'     => esc_html__( 'Never', 'vendify' ),
		],
		'priority'        => 40,
		'active_callback' => function() {
			return has_integration( 'private-messages' );
		},
	]
);

$wp_customize->selective_refresh->add_partial(
	'header-private-messages',
	[
		'selector'        => '.site-header',
		'settings'        => [ 'header-private-messages' ],
		'render_callback' => function() {
			partial( 'header/style-' . get_theme_mod( 'header-style', 1 ) );
		},
	]
);
