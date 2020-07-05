<?php
/**
 * Royale: border-radius.
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

// add specific selectors for Royale.
array_push(
	$selectors,
	'.collection-card-wrap',
	'.wp-block-button__link',
	'div.wp-block-button.is-style-rounded, div.wp-block-button.is-style-rounded wp-block-button__link',
	'.site-header .custom-search .form-control'
);

$config = [
	// Global.
	[
		'selectors'    => $selectors,
		'declarations' => [
			'border-radius' => '4px !important',
		],
	],
];

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
