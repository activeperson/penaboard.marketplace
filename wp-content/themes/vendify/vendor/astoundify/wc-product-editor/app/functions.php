<?php
/**
 * Helper functions.
 *
 * @since 1.0.0
 *
 * @package Astoundify\WC_Product_Editor
 * @category Functions
 * @author Astoundify
 */

namespace Astoundify\WC_Product_Editor;

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return a URL to edit a product with the editor.
 *
 * @since 1.0.0
 *
 * @param int $post_id ID of product to edit.
 * @return string
 */
function get_edit_url( $post_id ) {
	return esc_url_raw( add_query_arg( 'wcre', true, get_edit_post_link( $post_id ) ) . '#/details' );
}

/**
 * Create draft product.
 *
 * @since 1.0.0
 *
 * @return int $post_id ID of new product.
 */
function insert_draft_product() {
	$post_id = wp_insert_post(
		[
			'post_title'   => sprintf( '%s\'s New Product', wp_get_current_user()->display_name ),
			'post_content' => '',
			'post_status'  => 'draft',
			'post_type'    => 'product',
		]
	);

	wp_set_object_terms( $post_id, 'simple', 'product_type' );

	$product_meta = [
		'_visibility'            => 'visible',
		'_stock_status'          => 'instock',
		'total_sales'            => '0',
		'_downloadable'          => 'no',
		'_virtual'               => 'yes',
		'_regular_price'         => '',
		'_sale_price'            => '',
		'_purchase_note'         => '',
		'_featured'              => 'no',
		'_weight'                => '',
		'_length'                => '',
		'_width'                 => '',
		'_height'                => '',
		'_sku'                   => '',
		'_product_attributes'    => array(),
		'_sale_price_dates_from' => '',
		'_sale_price_dates_to'   => '',
		'_price'                 => '',
		'_sold_individually'     => '',
		'_manage_stock'          => 'no',
		'_backorders'            => 'no',
		'_stock'                 => '',
	];

	foreach ( $product_meta as $key => $value ) {
		update_post_meta( $post_id, $key, $value );
	}

	return $post_id;
}

/**
 * Get a formatted size of the maximum upload file size allowed.
 * 
 * @param int $decimals Optional. Precision of number of decimal places. Default 0.
 * @return string|false False on failure. Number string on success.
 */
function get_format_max_upload_size( $decimals = 0 ) {
	$wp_max_upload = wp_max_upload_size();

	return size_format( $wp_max_upload, $decimals );
}
