<?php
/**
 * Style kit group definitions.
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

return [
	'default'          => [
		'title'    => esc_html__( 'Classic', 'vendify' ),
		'controls' => [
			'color-scheme'                    => 'default',
			'typography-font-pack'            => 'default',
			'product-catalog-style'           => 1,
			'typography-headings-font-weight' => '200',
			'header-style' => 1,
			'header-transparency' => true,
		],
		'thumbnail_data' => get_parent_theme_file_uri('resources/assets/images/customize/classic.png' ),
	],
	'royale'     => [
		'title'    => __( 'Royale', 'vendify' ),
		'controls' => [
			'color-scheme'                    => 'royale',
			'typography-font-pack'            => 'roboto',
			'product-catalog-style'           => 4,
			'typography-headings-font-weight' => '500',
			'typography-base-font-weight'     => '400',
			'header-style'                    => 5,
			'header-transparency'             => false,
			'blog-style'                      => 'card',
			'header-search'                   => true,
		],
		'thumbnail_data' => get_parent_theme_file_uri('resources/assets/images/customize/royale.png' ),
	],
//	'tasti'     => [
//		'title'    => __( 'Tasti', 'vendify' ),
//		'controls' => [
//			'color-scheme'                     => 'tasti',
//			'typography-font-pack'             => 'poppins',
//			'product-catalog-style'            => 6,
//			'typography-headings-font-weight' => '500',
//			'header-style' => 2,
//			'header-transparency' => false,
//		],
//		'thumbnail_data' => get_parent_theme_file_uri('resources/assets/images/customize/tasti.png' ),
//	],
	'beige-oval'       => [
		'title'    => __( 'Beige Oval', 'vendify' ),
		'controls' => [
			'color-scheme'         => 'beige',
			'typography-font-pack' => 'slab',
		],
	],
	'pink-pastel'      => [
		'title'    => __( 'Pink Pastel', 'vendify' ),
		'controls' => [
			'color-scheme'         => 'pink',
			'typography-font-pack' => 'work-sans',
		],
	],
	'firey-red'        => [
		'title'    => __( 'Firey Red', 'vendify' ),
		'controls' => [
			'color-scheme'         => 'red',
			'typography-font-pack' => 'poppins',
		],
	],
	'green-watermelon' => [
		'title'    => __( 'Green Watermelon', 'vendify' ),
		'controls' => [
			'color-scheme'         => 'green',
			'typography-font-pack' => 'roboto',
		],
	],
];
