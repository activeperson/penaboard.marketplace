<?php
/**
 * Plugin Name: Astoundify WC Themes
 * Plugin URI: https://astoundify.com/
 * Description: Helper plugin for extending Astoundify's WooCommerce-powered themes.
 * Version: 1.0.0
 * Author: Astoundify
 * Author URI: https://astoundify.com/
 * Requires at least: 4.9.0
 * Tested up to: 4.9.0
 * Text Domain: astoundify-wc-themes
 * Domain Path: resources/languages/
 *
 *    Copyright: 2017 Astoundify
 *    License: GNU General Public License v3.0
 *    License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package WC_Themes
 * @category Core
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ASTOUNDIFY_WC_THEMES_VERSION', '1.0.0' );

defined( 'ASTOUNDIFY_WC_THEMES_FILE' ) ?
	ASTOUNDIFY_WC_THEMES_FILE : define( 'ASTOUNDIFY_WC_THEMES_FILE', __FILE__ );

defined( 'ASTOUNDIFY_WC_THEMES_PLUGIN' ) ?
	ASTOUNDIFY_WC_THEMES_PLUGIN : define( 'ASTOUNDIFY_WC_THEMES_PLUGIN', plugin_basename( __FILE__ ) );

defined( 'ASTOUNDIFY_WC_THEMES_PATH' ) ?
	ASTOUNDIFY_WC_THEMES_PLUGIN : define( 'ASTOUNDIFY_WC_THEMES_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );

defined( 'ASTOUNDIFY_WC_THEMES_URL' ) ?
	ASTOUNDIFY_WC_THEMES_PLUGIN : define( 'ASTOUNDIFY_WC_THEMES_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

defined( 'ASTOUNDIFY_WC_THEMES_TEMPLATE_PATH' ) ?
	ASTOUNDIFY_WC_THEMES_TEMPLATE_PATH : define( 'ASTOUNDIFY_WC_THEMES_TEMPLATE_PATH', trailingslashit( ASTOUNDIFY_WC_THEMES_PATH . 'resources/templates' ) );

/**
 * Load plugin text domain so errors can be translated.
 *
 * @since 1.0.0
 */
add_action( 'plugins_loaded', function() {
	// Load textdomain. Always loaded so errors can be translated.
	load_plugin_textdomain( 'astoundify-wc-themes', false, ASTOUNDIFY_WC_THEMES_PATH . '/resources/languages' );
} );


/**
 * Activation PHP Notice
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_php_notice() {
	// Translators: %1$s minimum PHP version, %2$s current PHP version.
	$notice = sprintf( __( 'The extra functionality provided by this Astoundify plugin requires at least PHP %1$s. You are running PHP %2$s. Please upgrade and try again.', 'astoundify-wc-themes' ), '<code>5.4.0</code>', '<code>' . PHP_VERSION . '</code>' );
?>

<div class="notice notice-error">
	<p><?php echo wp_kses( $notice, array(
		'code' => array(),
	) ); ?></p>
</div>

<?php
}

// Check for PHP version.
if ( version_compare( PHP_VERSION, '5.4', '<' ) ) {
	add_action( 'admin_notices', 'astoundify_wc_themes_php_notice' );

	return;
}

/**
 * Activation WP Version Notice
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_wp_version_notice() {
	// Translators: %1$s minimum WP version, %2$s current PHP version.
	$notice = sprintf( __( 'The extra functionality provided by this Astoundify plugin requires WordPress version %1$s or newer. You are running version %2$s. Please upgrade and try again.', 'astoundify-wc-themes' ), '<code>4.9.0</code>', '<code>' . get_bloginfo( 'version' ) . '</code>' );
?>

<div class="notice notice-error">
	<p><?php echo wp_kses( $notice, array(
		'code' => array(),
	) ); ?></p>
</div>

<?php
}

// Check for WP version.
if ( version_compare( get_bloginfo( 'version' ), '4.8', '<' ) ) {
	add_action( 'admin_notices', 'astoundify_wc_themes_wp_version_notice' );

	return;
}

/**
 * Load auto loader.
 *
 * @since 1.0.0
 */
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'bootstrap/autoload.php' );

/**
 * Install the application.
 *
 * @since 1.0.0
 */
include_once( ASTOUNDIFY_WC_THEMES_PATH . 'bootstrap/install.php' );
register_activation_hook( __FILE__, 'astoundify_wc_themes_install' );

/**
 * Start the application.
 *
 * @since 1.0.0
 */
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'bootstrap/app.php' );
