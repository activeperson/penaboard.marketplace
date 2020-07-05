<?php
/**
 * Setup guide steps.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Setup
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$steps = [];

if ( current_user_can( 'manage_options' ) ) {
	$steps['theme-updater'] = [
		'title'     => esc_html__( 'Enable Automatic Theme Updates', 'vendify' ),
		'completed' => 'n/a',
	];
}

if ( current_user_can( 'install_plugins' ) ) {
	$steps['install-plugins'] = [
		'title'     => esc_html__( 'Install Plugins', 'vendify' ),
		'completed' => has_integration( 'woocommerce' ),
	];
}

if ( current_user_can( 'import' ) ) {
	$steps['import-content'] = [
		'title'     => esc_html__( 'Choose Site Content', 'vendify' ),
		'completed' => apply_filters( 'astoundify_ci_allow_import', false ),
	];
}

if ( current_user_can( 'customize' ) ) {
	$steps['customize-theme'] = [
		'title'     => esc_html__( 'Customize Your Site', 'vendify' ),
		'completed' => 'n/a',
	];
}

$steps['support-us'] = [
	'title'     => esc_html__( 'Get Involved', 'vendify' ),
	'completed' => 'n/a',
];

return $steps;
