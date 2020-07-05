<?php
/**
 * WooCommerce Integration.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Integration
 * @author Astoundify
 */

namespace Astoundify\Vendify\Integrations\WooCommerce;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WooCommerce
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
		$this->set_dir( get_parent_theme_file_path( 'app/integrations/woocommerce' ) );

		$this->set_dependencies(
			[
				defined( 'WC_ABSPATH' ) && WC_ABSPATH,
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
		require_once $this->get_dir() . '/widget-functions.php';
		require_once $this->get_dir() . '/page-templates.php';
		require_once $this->get_dir() . '/customize.php';
		require_once $this->get_dir() . '/shortcodes.php';
	}

	/**
	 * Connect to WordPress
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'after_setup_theme', [ $this, 'add_theme_support' ] );
		add_filter( 'woocommerce_enqueue_styles', [ $this, 'dequeue_styles' ] );

		add_filter( 'woocommerce_template_path', [ $this, 'template_path' ] );
	}

	/**
	 * Declare template support for the plugin.
	 *
	 * @since 1.0.0
	 */
	public function add_theme_support() {
		add_theme_support(
			'woocommerce',
			[
				'product_grid' => [
					'min_columns' => 1,
					'max_columns' => 4,
				],
			]
		);

		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'wc-product-gallery-zoom' );
	}

	/**
	 * Dequeue visual WooCommerce styles.
	 *
	 * @since 1.0.0
	 *
	 * @param array $styles List of stylesheets.
	 * @return array $styles
	 */
	public function dequeue_styles( $styles ) {
		unset( $styles['woocommerce-general'] );
		unset( $styles['woocommerce-smallscreen'] );

		return $styles;
	}

	/**
	 * Locate a template in our new location.
	 *
	 * @since 1.0.0
	 *
	 * @param string $path Current template path.
	 * @return array $path
	 */
	public function template_path( $path ) {
		return 'app/integrations/woocommerce/views/';
	}

}
