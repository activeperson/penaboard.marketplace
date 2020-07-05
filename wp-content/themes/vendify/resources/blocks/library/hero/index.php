<?php
/**
 * Hero block.
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
 * Output a hero block.
 *
 * @since 1.0.0
 *
 * @param array  $attributes Block attributes.
 * @param string $content Block content.
 * @return string
 */
function gutenberg_hero( $attributes, $content ) {
	return get_partial(
		'block/hero',
		[
			'content'    => $content,
			'attributes' => $attributes,
		]
	);
}

// Register block.
register_block_type(
	'vendify/hero',
	[
		'render_callback' => 'Astoundify\Vendify\gutenberg_hero',
		'attributes'      => [
			'title'         => [
				'type' => 'string',
			],
			'subtitle'      => [
				'type' => 'string',
			],
			'url'           => [
				'type' => 'string',
			],
			'id'            => [
				'type' => 'number',
			],
			'contentAlign'  => [
				'type'    => 'string',
				'default' => 'center',
			],
			'dimRatio'      => [
				'type'    => 'number',
				'default' => 50,
			],
			'hasParallax'   => [
				'type'    => 'boolean',
				'default' => false,
			],
			'hasAnimation'   => [
				'type'    => 'boolean',
				'default' => true,
			],
			'paddingTop'    => [
				'type'    => 'number',
				'default' => 130,
			],
			'paddingBottom'    => [
				'type'    => 'number',
				'default' => 130,
			],
		],
	]
);
