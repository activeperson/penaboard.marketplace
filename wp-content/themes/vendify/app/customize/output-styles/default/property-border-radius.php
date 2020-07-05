<?php
/**
 * Tasti: border-radius.
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

$selectors = include_once get_template_directory() . '/app/customize/selectors/border-radius.php';

$config = [
	// Global.
	[
		'selectors'    => [
			'div.wp-block-button.is-style-rounded, div.wp-block-button.is-style-rounded wp-block-button__link',
		],
		'declarations' => [
			'border-radius' => '4px',
		],
	],
];

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
