<?php
/**
 * Control: Bacgkround Color
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

$wp_customize->get_control( 'background_color' )->section = 'colors-global';
$wp_customize->get_control( 'background_color' )->label   = esc_html_x( 'Background', 'customizer control label', 'vendify' );
