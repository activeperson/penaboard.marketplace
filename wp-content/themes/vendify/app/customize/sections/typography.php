<?php
/**
 * Section: Typography
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

$elements = vendify_customize_get_typography_elements();

foreach ( $elements as $element => $label ) {
	$wp_customize->add_section(
		'typography-' . $element,
		[
			'title' => $label,
			'panel' => 'typography',
		]
	);
}
