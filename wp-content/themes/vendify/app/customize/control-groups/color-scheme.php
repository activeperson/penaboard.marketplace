<?php
/**
 * Color scheme group definitions.
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
	'default' => [
		'title'    => esc_html__( 'Default', 'vendify' ),
		'controls' => [
			'color-body-color'  => '#767676',
			// 'color-link-color'  => '#4e4e4e',
			'color-menu-bg'     => '#ffffff',
			'color-menu-color'  => '#767676',

			'color-primary'     => '#000000',
			'color-secondary'   => '#f52f4c',
			'color-success'     => '#8dbd54',
			'color-information' => '#17a2b8',
			'color-warning'     => '#f2c663',
			'color-danger'      => '#f52f4c',
			'color-light'       => '#ffffff',
			'color-dark'        => '#000000'
		],
	],
	'royale' => [
		'title'    => esc_html__( 'Royale', 'vendify' ),
		'controls' => [
			'color-body-color'  => '#767676',
			// 'color-link-color'  => '#4e4e4e',
			'color-menu-bg'     => '#ffffff',
			'color-menu-color'  => '#717171',

			'color-primary'     => '#000000',
			'color-secondary'   => '#5064f9',
			'color-success'     => '#8dbd54',
			'color-information' => '#17a2b8',
			'color-warning'     => '#f2c663',
			'color-danger'      => '#ff656b',
			'color-light'       => '#ffffff',
			'color-dark'        => '#000000'
		],
	],
//	'tasti' => [
//		'title'    => esc_html__( 'Tasti', 'vendify' ),
//		'controls' => [
//			'color-body-color'  => '#696c8c',
//			'color-menu-bg'     => '#fc553f',
//			'color-menu-color'  => '#ffffff',
//
//			'color-primary'     => '#fc553f',
//			'color-secondary'   => '#3cd9c7',
//			'color-success'     => '#8dbd54',
//			'color-information' => '#17a2b8',
//			'color-warning'     => '#f2c663',
//			'color-danger'      => '#f52f4c',
//			'color-light'       => '#ffffff',
//			'color-dark'        => '#080a22'
//		],
//	],
];
