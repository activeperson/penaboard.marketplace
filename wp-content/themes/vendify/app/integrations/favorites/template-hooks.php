<?php
/**
 * Favorites template hooks.
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

// Allow template overrides.
add_filter( 'astoundify_favorites_get_template', 'Astoundify\Vendify\Favorites\get_template', 10, 2 );
add_filter( 'page_template_hierarchy', 'Astoundify\Vendify\Favorites\assign_page_templates', 5 );

// Allow output on products.
add_filter( 'astoundify_favorites_post_types', 'Astoundify\Vendify\Favorites\post_types' );

// Remove auto output on content.
add_filter( 'astoundify_favorites_content_filter', '__return_false' );

// Modify default text and attributes.
add_filter( 'astoundify_favorites_link_text', 'Astoundify\Vendify\Favorites\link_text', 10, 4 );
add_filter( 'astoundify_favorites_link_atts', 'Astoundify\Vendify\Favorites\link_atts', 10, 5 );

// Add activity to customers.
add_filter( 'vendify_woocommerce_get_customer_activity', 'Astoundify\Vendify\Favorites\activity' );

// Add output to product card
add_action( 'woocommerce_shop_loop_item_header', 'Astoundify\Vendify\Favorites\shop_loop_item_header' );

// redirect link while logged out.
add_filter( 'astoundify_favorites_link_atts', 'Astoundify\Vendify\Favorites\fav_link_while_logged_out' );
