<?php
/**
 * Typography control group definitions.
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

return [
	'default'     => [
		'title'    => esc_html__( 'Default', 'vendify' ),
		'controls' => [
			// Shim font weights. These are used in the theme in specific spots
			// but the elements do not have specific controls in the customizer.
			'typography-shim1-font-weight'    => 100,
			'typography-shim2-font-weight'    => 200,
			'typography-shim3-font-weight'    => 300,
			'typography-shim4-font-weight'    => 400,
			'typography-shim5-font-weight'    => 700,

			'typography-base-font-family'     => 'Montserrat',
			'typography-base-font-size'       => 15,
			'typography-base-font-weight'     => 300,
			'typography-base-line-height'     => 2.134,

			'typography-headings-font-family' => 'Montserrat',
			'typography-headings-font-size'   => 40,
			'typography-headings-font-weight' => 200,
			'typography-headings-line-height' => 1.1,
		],
	],
	'roboto-slab' => [
		'title'    => esc_html__( 'Roboto Slab', 'vendify' ),
		'controls' => [
			'typography-base-font-family'     => 'Montserrat',
			'typography-base-font-size'       => 15,
			'typography-base-font-weight'     => 300,
			'typography-base-line-height'     => 2.134,

			'typography-headings-font-family' => 'Roboto Slab',
			'typography-headings-font-size'   => 40,
			'typography-headings-font-weight' => 200,
			'typography-headings-line-height' => 1.1,
		],
	],
	'work-sans'   => [
		'title'    => esc_html__( 'Work Sans', 'vendify' ),
		'controls' => [
			'typography-base-font-family'     => 'Work Sans',
			'typography-base-font-size'       => 15,
			'typography-base-font-weight'     => 300,
			'typography-base-line-height'     => 2.134,

			'typography-headings-font-family' => 'Work Sans',
			'typography-headings-font-size'   => 40,
			'typography-headings-font-weight' => 200,
			'typography-headings-line-height' => 1.1,
		],
	],
	'poppins'     => [
		'title'    => esc_html__( 'Poppins', 'vendify' ),
		'controls' => [
			'typography-base-font-family'     => 'Poppins',
			'typography-base-font-size'       => 15,
			'typography-base-font-weight'     => 300,
			'typography-base-line-height'     => 2.134,

			'typography-headings-font-family' => 'Poppins',
			'typography-headings-font-size'   => 40,
			'typography-headings-font-weight' => 200,
			'typography-headings-line-height' => 1.1,
		],
	],
	'roboto'      => [
		'title'    => esc_html__( 'Roboto', 'vendify' ),
		'controls' => [
			'typography-base-font-family'     => 'Roboto',
			'typography-base-font-size'       => 15,
			'typography-base-font-weight'     => 300,
			'typography-base-line-height'     => 2.134,

			'typography-headings-font-family' => 'Roboto',
			'typography-headings-font-size'   => 40,
			'typography-headings-font-weight' => 200,
			'typography-headings-line-height' => 1.1,
		],
	],
];
