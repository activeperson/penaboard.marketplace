<?php
/**
 * Astoundify WC Product Editor Template Hooks
 *
 * Action/filter hooks used for Astoundify WC Product Editor functions/templates.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Output custom assets.
add_action( 'astoundify_wc_product_editor_enqueue_assets', 'Astoundify\Vendify\wc_product_editor_enqueue_assets' );

// Update partials for live preview.
add_filter( 'astoundify_wc_product_editor_elements', 'Astoundify\Vendify\wc_product_editor_elements' );

// Update link back to products list.
add_filter( 'astoundify_wc_product_editor_products_url', 'Astoundify\Vendify\wc_product_editor_products_url' );

// Update edit product link on frontend "Edit" links.
add_filter( 'astoundify_wc_themes_vendors_edit_product_link', 'Astoundify\Vendify\wc_product_editor_update_product_link' );
add_filter( 'vendify_woocommerce_product_vendors_new_product_url', 'Astoundify\Vendify\wc_product_editor_update_product_link' );
