<?php
/**
 * Load public assets.
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
 * Enqueue styles.
 *
 * @since 1.0.0
 */
function enqueue_styles() {
	$version    =  get_theme_version();
	$stylesheet = 'vendify';

	$deps = [];

	if ( has_integration( 'woocommerce' ) ) {
		wp_enqueue_style( 'select2' );
	}

	// Vendify has it's own block styling for the WooCommerce Products Block plugin.
	wp_deregister_style( 'wc-block-style' );
	wp_deregister_style( 'wc-block-editor' );

	wp_enqueue_style( $stylesheet, get_asset_src( '/public/css/app', 'css' ), $deps, $version );
}
add_action( 'wp_enqueue_scripts', 'Astoundify\Vendify\enqueue_styles' );

/**
 * Load editor styles and custom fonts in TinyMCE instances.
 *
 * @since 1.0.0
 *
 * @param string $mce_css List of CSS files to load.
 * @return string
 */
function mce_css( $mce_css ) {
	if ( ! function_exists( 'astoundify_themecustomizer_get_option' ) ) {
		return;
	}

	if ( ! empty( $mce_css ) ) {
		$mce_css .= ',';
	}

	$mce_css .= str_replace( ',', '%2C', astoundify_themecustomizer_get_googlefont_url() );
	$mce_css .= ', ' . get_asset_src( '/public/css/editor-classic', 'css' );

	return $mce_css;
}
add_filter( 'mce_css', 'Astoundify\Vendify\mce_css' );

/**
 * Enqueue scripts.
 *
 * @since 1.0.0
 */
function enqueue_scripts() {
	$version    = get_theme_version();
	$stylesheet = 'vendify';

	$deps = [
		'wp-util',
		'jquery'
	];

	// load masonry if the blog card is not dark, which has a fixed height.
	if ( 'dark' !== get_theme_mod( 'blog-style', 'classic' ) ) {
		$deps[] = 'masonry';
	}

	if ( has_integration( 'woocommerce' ) ) {
		$deps[] = 'wc-cart-fragments';
		$deps[] = 'wc-checkout';
		$deps[] = 'selectWoo';
	}

	// Combined application scripts. See `gulpfile.js` for more.
	wp_enqueue_script( $stylesheet, get_asset_src( '/public/js/app', 'js' ), $deps, $version, true );

	// Send information to application scripts.
	wp_localize_script(
		$stylesheet,
		'Vendify',
		apply_filters(
			'vendify_i18n',
			[
				'loginModalLinks' => [
					'[href="' . wp_login_url() . '"]',
					'[href^="' . wp_login_url() . '?redirect_to"]',
				],
			]
		)
	);
}
add_action( 'wp_enqueue_scripts', 'Astoundify\Vendify\enqueue_scripts' );

/**
 * Retrieves the path to an asset if exists.
 * Relies on `SCRIPT_DEBUG` to print the minified or the development version.
 *
 * @param $path
 * @param $extension
 *
 * @return bool|string
 */
function get_asset_src( $path, $extension ) {

	if ( empty( $path ) || empty( $extension ) ) {
		return false;
	}

	$minified = '.';

	if ( ! defined( 'SCRIPT_DEBUG' ) || ! SCRIPT_DEBUG ) {
		$minified = '.min.';
	}

	$r_path = $path  . $minified . $extension;

	if ( file_exists( get_parent_theme_file_path( $r_path ) ) ) {
		return get_parent_theme_file_uri( $r_path );
	}

	return false;
}
