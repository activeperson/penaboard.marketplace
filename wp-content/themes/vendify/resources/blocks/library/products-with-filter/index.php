<?php
/**
 * Blog Posts block.
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

/**
 * Output a grid of blog posts.
 *
 * @since 1.0.0
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function gutenberg_products_with_filter( $attributes, $content ) {
	return get_partial(
		'block/products-with-filter',
		[
			'content'    => $content,
			'attributes' => $attributes,
		]
	);
}

// Register block.
register_block_type(
	'vendify/products-with-filter',
	[
		'render_callback' => 'Astoundify\Vendify\gutenberg_products_with_filter',
		'attributes'      => [
			'postNumber'     => [
				'type' => 'string',
				'default' => 8,
			],
			'align' => [
				'type' => 'string',
			],
		],
	]
);
