<?php
/**
 * Do not modify this file.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Bootstrap
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Minimum PHP version.
define( 'VENDIFY_PHP_VERSION', '5.6.20' );

// Do not allow the theme to be active if the PHP version is not met.
if ( version_compare( PHP_VERSION, VENDIFY_PHP_VERSION, '<' ) ) {
	add_action( 'admin_notices', 'Astoundify\Vendify\php_admin_notices' );

	if ( is_admin() ) {
		return;
	}

	wp_die( get_php_notice_text() );
}

/**
 * Output a notice that the minimum PHP version is not met.
 *
 * @since 1.10.0
 */
function php_admin_notices() {
	echo '<div class="notice notice-error"><p>' . get_php_notice_text() . '</p></div>';
}

/**
 * PHP upgrade notice text.
 *
 * @since 1.10.0
 *
 * @return string
 */
function get_php_notice_text() {
	/**
	 * Filter text shown when current PHP version does not meet requirements.
	 *
	 * @since 1.10.0
	 *
	 * @param string $text Text to display.
	 */
	return apply_filters(
		'vendify_php_notice_text',
		/* translators: %s Minimum PHP version required for theme to run. */
		wp_kses_post( sprintf( __( 'Vendify requires PHP version <code>%s</code> or above to be active. Please contact your web host to upgrade.', 'vendify' ), esc_attr( VENDIFY_PHP_VERSION ) ) )
	);
}

// Composer autoloader.
require_once get_parent_theme_file_path( 'bootstrap/autoload.php' );

// Custom template loader.
require_once get_parent_theme_file_path( 'bootstrap/template-loader.php' );

// Start things.
require_once get_parent_theme_file_path( 'bootstrap/app.php' );

// New user experience.
require_once get_parent_theme_file_path( 'bootstrap/nux.php' );
