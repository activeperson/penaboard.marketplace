<?php
/**
 * Astoundify WC Product Editor Template functions.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Enqueue additional assets.
 *
 * @since 1.0.0
 */
function wc_product_editor_enqueue_assets() {
	$version = get_theme_version();

	do_action( 'astoundify_themecustomizer_load_output_css' );

	wp_enqueue_style(
		'vendify-wc-product-editor',
		get_asset_src( '/public/css/product-editor', 'css' ),
		[],
		$version
	);

	wp_add_inline_style( 'vendify-wc-product-editor', astoundify_themecustomizer_get_inline_css() );

	if ( function_exists( 'astoundify_themecustomizer_get_googlefont_url' ) ) {
		wp_enqueue_style(
			'vendify-wc-product-editor-fonts',
			astoundify_themecustomizer_get_googlefont_url(),
			[],
			$version
		);
	}
}

/**
 * Update link back to products list.
 *
 * @since 1.0.0
 *
 * @param string $url URL to return to.
 * @return string
 */
function wc_product_editor_products_url( $url ) {
	if ( ! has_integration( 'woocommerce-product-vendors' ) ) {
		return admin_url( 'edit.php?post_type=product' );
	}

	return astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-products' );
}

/**
 * Edit product link. Update to use live editor.
 *
 * @since 1.0.0
 *
 * @param string $url Edit URL.
 * @return string
 */
function wc_product_editor_update_product_link( $url ) {
	return add_query_arg( 'wcre', true, $url ) . '#/details';
}

/**
 * Link product information to HTML DOM elements.
 *
 * @since 1.0.0
 *
 * @param array $elements Elements
 * @return array
 */
function wc_product_editor_elements( $elements ) {
	$elements['title'] = '.product-sidebar__name';

	$elements['regular_price'] = [
		'insertAfter' => '.product-sidebar__name',
		'parent'      => '.product-sidebar__price.price',
		'parentHTML'  => '<div class="product-sidebar__price price">${data}</div>',
		'element'     => '.product-main .woocommerce-Price-amount.amount',
	];

	$elements['sale_price'] = [
		'element' => '.product-main .woocommerce-Price-amount.amount',
	];

	$elements['description'] = [
		'refreshWhen'   => false,
		'updatePostKey' => 'description',
	];

	$elements['short-description'] = [
		'refreshWhen' => false,
	];

	$elements['categories'] = [
		'refreshWhen' => false,
	];

	$elements['tags'] = [
		'refreshWhen' => false,
	];

	return $elements;
}
