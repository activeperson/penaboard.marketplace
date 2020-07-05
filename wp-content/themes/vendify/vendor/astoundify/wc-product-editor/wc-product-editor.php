<?php
/**
 * Plugin Name: WooCommerce Product Editor
 * Plugin URI: https://astoundify.com/
 * Description: Edit WooCommerce products on the frontend.
 * Version: 1.0.0
 * Author: Astoundify
 * Author URI: https://astoundify.com/
 * Requires at least: 4.8.0
 * Tested up to: 4.8
 * Text Domain: astoundify-wc-product-editor
 * Domain Path: resources/languages/
 *
 *    Copyright: 2017 Astoundify
 *    License: GNU General Public License v3.0
 *    License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package WooCommerceReactProducts
 * @category Core
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Activation PHP Notice
 *
 * @since 1.0.0
 */
function astoundify_woocommerce_react_products_php_notice() { ?>

<div class="notice notice-error">
	<p>
		<?php
		// Translators: %1$s minimum PHP version, %2$s current PHP version.
		printf( esc_html__( 'This Astoundify plugin requires at least PHP %1$s. You are running PHP %2$s. Please upgrade and try again.', 'astoundify-wc-product-editor' ), '<code>5.6.20</code>', '<code>' . PHP_VERSION . '</code>' );
		?>
	</p>
</div>

<?php
}

// Check for PHP version..
if ( version_compare( PHP_VERSION, '5.6.20', '<' ) ) {
	add_action( 'admin_notices', 'astoundify_woocommerce_react_products_php_notice' );

	return;
}

// Plugin can be loaded... define some constants.
define( 'ASTOUNDIFY_WC_PRODUCT_EDITOR_VERSION', '1.0.0' );
define( 'ASTOUNDIFY_WC_PRODUCT_EDITOR_FILE', __FILE__ );
define( 'ASTOUNDIFY_WC_PRODUCT_EDITOR_PLUGIN', plugin_basename( __FILE__ ) );

if ( ! defined( 'ASTOUNDIFY_WC_PRODUCT_EDITOR_PATH' ) ) {
	define( 'ASTOUNDIFY_WC_PRODUCT_EDITOR_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( ! defined( 'ASTOUNDIFY_WC_PRODUCT_EDITOR_URL' ) ) {
	define( 'ASTOUNDIFY_WC_PRODUCT_EDITOR_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
}

if ( ! defined( 'ASTOUNDIFY_WC_PRODUCT_EDITOR_TEMPLATE_PATH' ) ) {
	define( 'ASTOUNDIFY_WC_PRODUCT_EDITOR_TEMPLATE_PATH', trailingslashit( ASTOUNDIFY_WC_PRODUCT_EDITOR_PATH . 'resources/views' ) );
}

/**
 * Load auto loader.
 *
 * @since 1.0.0
 */
require_once ASTOUNDIFY_WC_PRODUCT_EDITOR_PATH . 'bootstrap/autoload.php';

/**
 * Start the application.
 *
 * @since 1.0.0
 */
require_once ASTOUNDIFY_WC_PRODUCT_EDITOR_PATH . 'bootstrap/app.php';
