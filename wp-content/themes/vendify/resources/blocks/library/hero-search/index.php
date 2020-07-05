<?php
/**
 * Hero Search block.
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
 * Output a hero search block.
 *
 * @since 1.0.0
 *
 * @param array  $attributes Block attributes.
 * @param string $content Block content.
 * @return string
 */
function gutenberg_hero_search( $attributes, $content ) {
	return get_partial(
		'block/hero-search',
		[
			'content'    => $content,
			'attributes' => $attributes,
		]
	);
}

$atts = [
	'keywordPlaceholder' => [
		'type'    => 'string',
		'default' => 'Keyword...',
	],
	'searchValue' => [
		'type'    => 'string',
		'default' => 'Find',
	],
];

// if ( has_integration( 'woocommerce-product-vendors' ) ) {
// 	$atts['locationPlaceholder'] = [
// 		'type'    => 'string',
// 		'default' => 'Location...',
// 	];
// }

// Register block.
register_block_type(
	'vendify/hero-search',
	[
		'render_callback' => 'Astoundify\Vendify\gutenberg_hero_search',
		'attributes'      => $atts,
	]
);
