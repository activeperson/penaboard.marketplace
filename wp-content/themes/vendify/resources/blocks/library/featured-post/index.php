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
function gutenberg_featured_post( $attributes, $content ) {
	return get_partial(
		'block/featured-post',
		[
			'content'    => $content,
			'attributes' => $attributes,
		]
	);
}

// Register block.
register_block_type(
	'vendify/featured-post',
	[
		'render_callback' => 'Astoundify\Vendify\gutenberg_featured_post',
		'attributes'      => [
			'postID'     => [
				'type' => 'string',
				'default' => 1
			],
			'linkText' => [
				'type' => 'string',
				'default' => esc_html__( 'View More', 'vendify' )
			],
			'align' => [
				'type' => 'string',
			],
		],
	]
);
