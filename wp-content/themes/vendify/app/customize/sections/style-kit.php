<?php
/**
 * Section: Style Kit
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

$wp_customize->add_section(
	'style-kit',
	[
		'title'    => esc_html__( 'Style Kit', 'vendify' ),
		'priority' => 0,
	]
);
