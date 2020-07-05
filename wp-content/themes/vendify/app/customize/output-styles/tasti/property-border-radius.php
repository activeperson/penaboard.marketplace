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

// add specific selectors for Tasti.
array_push(
	$selectors,
	'.collection-card-wrap',
	'.wp-block-button__link'
);

$config = [
	// Global.
	[
		'selectors'    => $selectors,
		'declarations' => [
			'border-radius' => '4px',
		],
	],
];

// Add.
foreach ( $config as $item ) {
	astoundify_themecustomizer_add_css( $item );
}
