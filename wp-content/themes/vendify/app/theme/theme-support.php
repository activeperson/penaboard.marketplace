<?php
/**
 * WordPress features.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Theme
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Declare view support for various built in WordPress features.
 *
 * @since 1.0.0
 */
function add_theme_supports() {
	if ( ! isset( $content_width ) ) {
		$content_width = 930;
	}

	add_theme_support( 'title-tag' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support(
		'html5',
		[
			'search-form',
			'comment-form',
			'commentlist',
			'gallery',
			'caption',
		]
	);

	add_theme_support(
		'custom-background',
		[
			'default-color' => '#fafafa',
			'default-image' => '',
		]
	);

	add_post_type_support( 'page', 'excerpt' );

	add_theme_support(
		'post-formats',
		[
			'video',
		]
	);

	add_theme_support( 'post-thumbnails' );

	add_theme_support(
		'custom-logo',
		[
			'width'       => 130,
			'height'      => 30,
			'flex-height' => true,
			'flex-width'  => true,
		]
	);

	add_theme_support( 'astoundify-wc-themes', [ 'vendors', 'customers' ] );

	// A maximum image size to be used in Hero, Cover blocks or anything full width.
	add_image_size( 'cover', 1800 );

	if ( function_exists( 'astoundify_themecustomizer_get_googlefont_url' ) ) {
		add_editor_style( [ get_asset_src( 'public/css/editor-style', 'css' ), astoundify_themecustomizer_get_googlefont_url() ] );
	}

	// Fallback local domains.
	load_theme_textdomain( 'vendify', get_template_directory() . '/resources/languages' );
}
add_action( 'after_setup_theme', 'Astoundify\Vendify\add_theme_supports' );
