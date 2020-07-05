<?php
/**
 * Astoundify WC Themes Integration.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Integration
 * @author Astoundify
 */

namespace Astoundify\Vendify\Integrations\Astoundify_WC_Themes;

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
		$this->set_dir( get_parent_theme_file_path( 'app/integrations/astoundify-wc-themes' ) );

		$this->set_dependencies(
			[
				true,
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
		add_action( 'after_setup_theme', function() {
			remove_action( 'init', 'astoundify_wc_themes_setup' );
		} );
	}

}
