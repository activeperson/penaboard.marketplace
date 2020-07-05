<?php
/**
 * Simple Social Login Integration.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Integration
 * @author Astoundify
 */

namespace Astoundify\Vendify\Integrations\WooCommerce_Social_Login;

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
		$this->set_dir( get_parent_theme_file_path( 'app/integrations/woocommerce-social-login' ) );

		$this->set_dependencies(
			[
				class_exists( 'WC_Social_Login' ),
			]
		);
	}

	/**
	 * Load extra files.
	 *
	 * @since 1.0.0
	 */
	public function includes() {}

	/**
	 * Connect to WordPress
	 *
	 * @since 1.0.0
	 */
	public function register() {
		// Remove default plugin output.
		remove_action(
			'woocommerce_login_form_end',
			[
				wc_social_login()->get_frontend_instance(),
				'render_social_login_buttons'
			]
		);

		foreach ( [
			'woocommerce_login_form_start',
			'woocommerce_register_form_start',
			'astoundify_wc_themes_vendors_dashboard_login_form_before',
		] as $hook ) {
			add_action( $hook, [ $this, 'render_social_login_buttons' ] );
		}
	}

	/**
	 * Render social login buttons.
	 * 
	 * Bypasses conditional loading checks.
	 *
	 * @since 1.0.0
	 */
	function render_social_login_buttons() {
		$return_url = is_checkout() ? wc_get_checkout_url() : wc_get_page_permalink( 'myaccount' );

		// only do this on the product pages
		if ( is_product() ) {
			$return_url = esc_url( home_url( add_query_arg( array() ) ) . '#comment-page-1' );
		}

		woocommerce_social_login_buttons( $return_url );
	}

}
