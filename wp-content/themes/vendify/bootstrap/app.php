<?php
/**
 * Boostrap the application.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Bootstrap
 * @author Astoundify
 */

namespace Astoundify\Vendify;

// Setup the theme.
$theme = [
	'views',
	'extras',
	'assets',
	'svg',
	'nav-menus',
	'widgets',
	'comments',
	'theme-support',
	'wordpress',
	'template-tags',
];

foreach ( $theme as $file ) {
	require_once get_parent_theme_file_path( '/app/theme/' . $file . '.php' );
}

if ( function_exists( 'register_block_type' ) ) {
	require_once get_parent_theme_file_path( '/app/theme/gutenberg.php' );
}

// Customize.
require_once get_parent_theme_file_path( '/app/customize/customize.php' );

// Astoundify's custom library for WooCommerce functionality.
if ( defined( 'WC_ABSPATH' ) && WC_ABSPATH ) {
	$path = get_template_directory() . '/vendor/astoundify/wc-themes-framework/';

	define( 'ASTOUNDIFY_WC_THEMES_PATH', $path );
	define( 'ASTOUNDIFY_WC_THEMES_URL', get_template_directory_uri() . '/vendor/astoundify/wc-themes-framework/' );

	if ( file_exists( $path . '/astoundify-wc-themes.php' ) ) {
		require_once $path . '/astoundify-wc-themes.php';
	}

	Integrations::register( 'astoundify-wc-themes', 'Astoundify_WC_Themes' );

	// Product editor
	$path = get_template_directory() . '/vendor/astoundify/wc-product-editor/';

	define( 'ASTOUNDIFY_WC_PRODUCT_EDITOR_TEMPLATE_PATH', $path . '/resources/views' );
	define( 'ASTOUNDIFY_WC_PRODUCT_EDITOR_URL', get_template_directory_uri() . '/vendor/astoundify/wc-product-editor/' );

	if ( file_exists( $path . '/wc-product-editor.php' ) ) {
		require_once $path . '/wc-product-editor.php';
	}

	Integrations::register( 'astoundify-wc-product-editor', 'Astoundify_WC_Product_Editor' );
}

// Plugin integrations.
Integrations::register( 'woocommerce', 'WooCommerce' );
Integrations::register( 'woocommerce-product-vendors', 'WooCommerce_Product_Vendors' );
Integrations::register( 'woocommerce-social-login', 'WooCommerce_Social_Login' );
Integrations::register( 'private-messages', 'Private_Messages' );
Integrations::register( 'favorites', 'Favorites' );
Integrations::register( 'wp-user-avatars', 'WPUserAvatars' );

Integrations::load();
