<?php
/**
 * Template loader.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Locate and load a template file.
 *
 * @since 1.0.0
 *
 * @param string $template_name Nam of template file.
 * @param array  $args          (default: array()) Pass data to template.
 * @param string $template_path (default: '') Load from a different area.
 * @param string $default_path  (default: '') Default path.
 */
function astoundify_wc_themes_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	// Extract variable to use in template file.
	if ( ! empty( $args ) && is_array( $args ) ) {
		// @codingStandardsIgnoreStart
		extract( $args );
		// @codingStandardsIgnoreEnd
	}

	// Get template file.
	$located = astoundify_wc_themes_locate_template( $template_name, $template_path, $default_path );

	// File not exists, display error notice.
	if ( ! file_exists( $located ) ) {
		// Translators: %s Attempted template file.
		_doing_it_wrong( __CLASS__ . '::' . __FUNCTION__, esc_attr( sprintf( esc_html__( '%s does not exist.', 'astoundify-wc-themes' ), '<code>' . $located . '</code>' ), $located ), esc_attr( ASTOUNDIFY_WC_THEMES_VERSION ) );
		return;
	}

	include( $located );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *    yourtheme       /   $template_path   /   $template_name
 *    yourtheme       /   $template_name
 *    $default_path   /   $template_name
 *
 * @since 1.0.0
 *
 * @param string $template_name Name of template file.
 * @param string $template_path (default: '') Load from a different area.
 * @param string $default_path  (default: '') Default path.
 * @return string
 */
function astoundify_wc_themes_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	// Set theme path if not set.
	if ( ! $template_path ) {
		$template_path = 'astoundify-wc-themes';
	}

	// Set default template path if not set.
	if ( ! $default_path ) {
		$default_path = ASTOUNDIFY_WC_THEMES_TEMPLATE_PATH;
	}

	// Look within passed path within the theme - this is priority.
	$template = locate_template( trailingslashit( $template_path ) . $template_name );

	// Get default template if theme template file not found.
	if ( ! $template ) {
		$template = trailingslashit( $default_path ) . $template_name;
	}

	// Return what we found.
	return apply_filters( 'astoundify_wc_themes_locate_template', $template, $template_name, $template_path );
}

/**
 * Look in our custom templates directory when loading a WooCommerce template.
 *
 * @since 1.0.0
 *
 * @param string $template Template to find.
 * @return array
 */
function astoundify_wc_themes_woocommerce_locate_template( $template, $template_name, $template_path ) {
	$try = locate_template( array( trailingslashit( ASTOUNDIFY_WC_THEMES_TEMPLATE_PATH ) . 'woocommerce/' . $template ) );

	global $woocommerce;

	$_template = $template;

	if ( ! $template_path ) {
		$template_path = WC()->template_path();
	}

	$plugin_path = ASTOUNDIFY_WC_THEMES_TEMPLATE_PATH . 'woocommerce/';

	$template = locate_template( array( $template_path . $template_name, $template_name ) );

	if ( ! $template && file_exists( $plugin_path . $template_name ) ) {
		$template = $plugin_path . $template_name;
	}

	if ( ! $template ) {
		$template = $_template;
	}

	return $template;
}
add_filter( 'woocommerce_locate_template', 'astoundify_wc_themes_woocommerce_locate_template', 10, 3 );
