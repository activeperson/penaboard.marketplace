<?php
/**
 * Pink Pastel: border-radius.
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

if ( 'pink-pastel' !== get_theme_mod( 'style-kit', 'default' ) ) {
	return;
}

$config = [
	// Global.
	[
		'selectors'    => include_once get_template_directory() . '/app/customize/selectors/border-radius.php',
		'declarations' => [
			'border-radius' => '3px',
		],
	],
];

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
