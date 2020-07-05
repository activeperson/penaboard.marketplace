<?php
/**
 * WooCommerce Product Vendors Integration.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Integration
 * @author Astoundify
 */

namespace Astoundify\Vendify\Integrations\WooCommerce_Product_Vendors;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WooCommerce Product Vendors
 *
 * @since 1.0.0
 */
class Integration extends \Astoundify\Vendify\Integration {

	/**
	 * Define the dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->set_dir( get_parent_theme_file_path( 'app/integrations/woocommerce-product-vendors' ) );

		$this->set_dependencies(
			[
				defined( 'WC_ABSPATH' ) && WC_ABSPATH,
				defined( 'WC_PRODUCT_VENDORS_VERSION' ) && WC_PRODUCT_VENDORS_VERSION,
			]
		);
	}

	/**
	 * Load extra files.
	 *
	 * @since 1.0.0
	 */
	public function includes() {
		require_once $this->get_dir() . '/template-functions.php';
		require_once $this->get_dir() . '/template-hooks.php';
	}

	/**
	 * Connect to WordPress
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action(
			'plugins_loaded',
			function() {
				$wcpv_frontend = new \WC_Product_Vendors_Vendor_Frontend();

				remove_action( 'woocommerce_after_shop_loop_item', [ $wcpv_frontend, 'add_sold_by_loop' ], 9 );
			}
		);

		add_action( 'wp_enqueue_scripts', [ $this, 'dequeue_styles' ], 20 );
		add_filter( 'theme_page_templates', 'Astoundify\Vendify\woocommerce_product_vendors_templates' );
	}

	/**
	 * Remove frontend styles.
	 *
	 * @since 1.0.0
	 */
	public function dequeue_styles() {
		wp_dequeue_style( 'wcpv-frontend-styles' );
	}
}
