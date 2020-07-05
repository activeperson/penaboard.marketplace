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
function gutenberg_blog_posts( $attributes, $content ) {
	return get_partial(
		'block/blog-posts',
		[
			'content'    => $content,
			'attributes' => $attributes,
		]
	);
}

// Register block.
register_block_type(
	'vendify/blog-posts',
	[
		'render_callback' => 'Astoundify\Vendify\gutenberg_blog_posts',
		'attributes'      => [
			'link'     => [
				'type' => 'string',
			],
			'linkText' => [
				'type' => 'string',
			],
			'number'   => [
				'type'    => 'number',
				'default' => 3,
			],
			'cardStyle'   => [
				'type'    => 'string',
				'default' => 'classic',
			],
			'visitButtonStyle'   => [
				'type'    => 'string',
				'default' => 'classic',
			],
		],
	]
);
