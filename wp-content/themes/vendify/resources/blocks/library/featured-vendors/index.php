<?php
/**
 * Featured Vendors block.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Block
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Only register if plugin exists.
if ( ! has_integration( 'woocommerce-product-vendors' ) ) {
	return;
}

/**
 * Output a grid of featured vendors.
 *
 * @since 1.0.0
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function gutenberg_featured_vendors( $attributes, $content ) {
	return get_partial(
		'block/featured-vendors',
		[
			'content'    => $content,
			'attributes' => $attributes,
		]
	);
}

// Register block.
register_block_type(
	'vendify/featured-vendors',
	[
		'render_callback' => 'Astoundify\Vendify\gutenberg_featured_vendors',
		'attributes'      => [
			'link'     => [
				'type' => 'string',
			],
			'linkText' => [
				'type'    => 'string',
				'default' => '#add-your-link-here'
			],
			'visitButtonStyle' => [
				'type'    => 'string',
				'default' => 'outline'
			],
			'rows' => [
				'type'    => 'Number',
				'default' => '1'
			],
		],
	]
);
