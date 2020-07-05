<?php
/**
 * Initialize the product editor
 *
 * @since 1.0.0
 *
 * @package Astoundify\WC_Product_Editor
 * @category Admin
 * @author Astoundify
 */

namespace Astoundify\WC_Product_Editor;

use function Astoundify\WC_Product_Editor\get_format_max_upload_size;
use function Astoundify\WC_Product_Editor\get_template;

use WC_Product;

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialize the admin editor
 *
 * @since 1.0.0
 */
class Editor {

	/**
	 * @var $post
	 */
	private $post = null;

	/**
	 * Start things up.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $post Product to edit.
	 */
	public function __construct( $post ) {
		$this->post = $post;

		add_action( 'current_screen', [ $this, 'preview' ] );
		add_filter( 'admin_title', [ $this, 'set_title' ] );
		add_filter( 'admin_body_class', [ $this, 'body_class' ] );

		add_action( 'astoundify_wc_product_editor_before_preview', [ $this, 'remove_other_styles' ] );
		add_action( 'astoundify_wc_product_editor_before_preview', [ $this, 'remove_actions' ] );
		add_action( 'astoundify_wc_product_editor_before_preview', [ $this, 'enqueue_assets' ] );
	}

	public function set_title() {
		return sprintf( __( 'Edit %s', 'astoundify-wc-product-editor' ), $this->post->post_title );
	}

	public function body_class( $class ) {
		$class .= ' astoundify-wc-re';

		return $class;
	}

	/**
	 * Get elements that the editor can interact with.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_elements() {
		return apply_filters( 'astoundify_wc_product_editor_elements', array() );
	}

	/**
	 * Load the preview frame.
	 *
	 * @since 1.0.0
	 */
	public function preview() {
		if ( ! defined( 'IFRAME_REQUEST' ) ) {
			define( 'IFRAME_REQUEST', true );
		}

		global $menu, $post;

		$post      = get_post( $_GET['post'] );
		$permalink = get_permalink( $post );
		$menu      = array(); // Unset global menu items.

		// Allow things to happen before preview is loaded.
		do_action( 'astoundify_wc_product_editor_before_preview' );

		require_once ABSPATH . 'wp-admin/admin-header.php';

		get_template( 'product-editor.php' );

		require_once ABSPATH . 'wp-admin/admin-footer.php';
		exit();
	}

	/**
	 * Remove any other registered styles in the admin.
	 *
	 * @since 1.0.0
	 */
	public function remove_other_styles() {
		global $wp_styles;

		// Loop over all of the registered scripts.
		foreach ( $wp_styles->registered as $handle => $data ) {
			wp_deregister_style( $handle );
			wp_dequeue_style( $handle );
		}
	}

	/**
	 * Remove things plugins add.
	 *
	 * @since 1.0.0
	 */
	public function remove_actions() {
		// Hide notices.
		remove_all_actions( 'admin_notices' );

		// If-Menu
		remove_action('admin_footer', 'If_Menu::adminFooter');
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @todo Properly version.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_assets() {
		wp_enqueue_style( 'astoundify-wc-product-editor', ASTOUNDIFY_WC_PRODUCT_EDITOR_URL . 'public/css/app.min.css' );

		wp_enqueue_script('underscore' );

		wp_enqueue_script(
			'astoundify-wc-product-editor',
			ASTOUNDIFY_WC_PRODUCT_EDITOR_URL . 'public/js/app.min.js',
			[
				'wp-editor',
				'wp-i18n',
				'jquery',
			],
			time(),
			true
		);

		if ( ! wp_style_is( 'media-views' ) ) {
			wp_register_style( 'buttons', "/wp-includes/css/buttons.min.css" );
			wp_register_style( 'dashicons', "/wp-includes/css/dashicons.min.css" );

			wp_register_style( 'mediaelement', get_site_url() . "/wp-includes/js/mediaelement/mediaelementplayer-legacy.min.css", array(), '4.2.6-78496d1' );
			wp_register_style( 'wp-mediaelement', get_site_url() . "/wp-includes/js/mediaelement/wp-mediaelement.min.css", [ 'mediaelement' ] );

			wp_enqueue_style( 'media-views', "/wp-includes/css/media-views.min.css", [ 'buttons', 'dashicons', 'wp-mediaelement' ] );
		}

		wp_enqueue_media();
		wp_enqueue_script( 'media-grid' );
		wp_enqueue_script( 'media' );

		$featured_id = null;

		if ( has_post_thumbnail( $this->post->ID ) ) {
			$product     = new WC_Product( $this->post->ID );
			$featured_id = (int) $product->get_image_id();
		}

		wp_localize_script(
			'astoundify-wc-product-editor', 'astoundifyWrp', apply_filters(
				'astoundify_wc_product_editor_js_settings', [
					'homeUrl'             => home_url( '/' ),
					'apiRoot'             => esc_url_raw( rest_url() ),
					'nonce'               => wp_create_nonce( 'wp_rest' ),
					'postId'              => $this->post->ID,
					'featuredImage'       => $featured_id,
					'pluginUrl'           => ASTOUNDIFY_WC_PRODUCT_EDITOR_URL,
					'productsUrl'         => apply_filters( 'astoundify_wc_product_editor_products_url', admin_url( 'edit.php?post_type=product' ) ),
					'canCreateCategories' => apply_filters( 'astoundify_wc_product_editor_can_create_categories', false ),
					'canCreateTags'       => apply_filters( 'astoundify_wc_product_editor_can_create_tags', true ),
					'canPublish'          => apply_filters( 'astoundify_wc_product_editor_can_publish', current_user_can( 'publish_products' ) ),
					'elements'            => $this->get_elements(),
					'maxUpload'           => get_format_max_upload_size(),
					'i18n'                => [], // @todo get from theme config
					'vendor'              => [
						'products' => \WC_Product_Vendors_Utils::get_vendor_product_ids(),
					],
					'weightUnit'          => get_option( 'woocommerce_weight_unit', '' ),
					'dimensionUnit'       => get_option( 'woocommerce_dimension_unit', '' ),
				]
			)
		);

		do_action( 'astoundify_wc_product_editor_enqueue_assets' );
	}

}
