<?php
/**
 * Modify some of WordPress' global functionality.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Determine if the current style kit has rounded edges.
 *
 * @since 1.0.0
 *
 * @param array $classes CSS Classes.
 * @return array
 */
add_filter( 'body_class', function( $classes ) {
	$rounded = false;
	$style   = get_theme_mod( 'style-kit', 'default' );

	switch ( $style ) {
		case 'tasti':
		case 'blue-rounded':
			$rounded = true;
			break;
		default:
			$rounded = false;
	}

	$classes[] = $rounded ? 'is-rounded' : null;

	return $classes;
});

/**
 * Output some helper data attributes on the custom logo
 * for switching between alt and original.
 *
 * @since 1.0.0
 *
 * @param string $html HTML.
 * @return string $html
 */
add_filter( 'get_custom_logo', function( $html ) {
	$alt_image_id = get_theme_mod( 'custom-logo-alt' );

	if ( ! $alt_image_id ) {
		return $html;
	}

	$alt = wp_get_attachment_image_url( $alt_image_id, 'cover', false );
	$org = wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'cover', false );

	$html = str_replace( '<a', '<a data-alt="' . $alt . '" data-org="' . $org . '"', $html );

	return $html;
});

/**
 * Plug in to get_search_form() and override with our own partial.
 *
 * @see https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @since 1.0.0
 *
 * @return string
 */
add_filter( 'get_search_form', function() {
	return get_partial( 'searchform' );
});

/**
 * On the blog archive limit the category list to one item.
 *
 * @since 1.0.0
 *
 * @param array $categories The list of categories found.
 * @return array $categories
 */
add_filter( 'the_category_list', function( $categories ) {
	return array_splice( $categories, 0, 1 );
});

/**
 * Remove [...] from excerpts. Use a &hellip; instead.
 *
 * @since 1.0.0
 *
 * @return string
 */
add_filter( 'excerpt_more', function() {
	return '&hellip;';
});

/**
 * Adjust the length of default excerpts.
 *
 * @since 1.0.0
 *
 * @return int
 */
add_filter( 'excerpt_length', function() {
	return 20;
});

/**
 * Allow SVG in KSES
 *
 * @since 1.0.0
 *
 * @param $allowedposttags Allowed tags in posts.
 * @return array
 */
add_filter( 'wp_kses_allowed_html', function( $allowedposttags ) {
	$allowedposttags['svg'] = [
		'class'           => true,
		'aria-hidden'     => true,
		'aria-labelledby' => true,
		'role'            => true,
	];

	$allowedposttags['use'] = [
		'href'       => true,
		'xlink:href' => true,
		'role'       => true,
	];

	return $allowedposttags;
});
