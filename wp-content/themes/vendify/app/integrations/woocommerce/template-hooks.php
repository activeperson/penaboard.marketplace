<?php
/**
 * WooCommerce Template Hooks
 *
 * Action/filter hooks used for WooCommerce functions/templates.
 * This file contains justified usage of `remove_action` because we modified WooCommerce templates positions.
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

// Login/Register popup screen.
add_action( 'wp_footer', 'Astoundify\Vendify\woocommerce_login_register_screen' );
add_filter( 'vendify_i18n', 'Astoundify\Vendify\woocommerce_i18n' );

/**
 * Content Wrappers.
 *
 * @since 1.0.0
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

/**
 * Breadcrumbs.
 *
 * @since 1.0.0
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'Astoundify\Vendify\woocommerce_breadcrumb_defaults' );
add_filter( 'woocommerce_breadcrumb_home_url', 'Astoundify\Vendify\woocommerce_breadcrumb_home_url' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'woocommerce_before_single_product', 'woocommerce_breadcrumb' );

/**
 * Shop page.
 */

 add_filter( 'woocommerce_show_page_title', function(){
	return get_theme_mod( 'product-catalog-show-shop-title', true );
 });

/**
 * Remove product query count.
 *
 * @since 1.0.0
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

/**
 * Remove default product card content.
 *
 * Hooks remain in place but only for plugins. The theme has manual output.
 *
 * @since 1.0.0
 */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

add_action( 'woocommerce_shop_loop_item_header', 'woocommerce_show_product_loop_sale_flash' );

/**
 * Single product.
 *
 * @since 1.0.0
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

// Grouped product add to cart.
add_action(
	'woocommerce_before_main_content',
	function() {
		if ( wc_get_product() && 'grouped' === wc_get_product()->get_type() ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			add_action( 'woocommerce_after_single_product', 'woocommerce_template_single_add_to_cart' );
		}
	}
);

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_filter( 'woocommerce_get_star_rating_html', 'Astoundify\Vendify\woocommerce_get_star_rating_html', 10, 3 );
add_filter( 'woocommerce_product_get_rating_html', 'Astoundify\Vendify\woocommerce_get_star_rating_html', 10, 3 );
add_filter( 'woocommerce_rating_filter_count', '__return_empty_string' );

add_filter( 'woocommerce_single_product_carousel_options', 'Astoundify\Vendify\woocommerce_single_product_carousel_options' );
add_filter( 'woocommerce_single_product_image_gallery_classes', 'Astoundify\Vendify\woocommerce_single_product_image_gallery_classes' );

/**
 * Checkout.
 *
 * @since 1.0.0
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'Astoundify\Vendify\woocommerce_cart_count_fragments' );

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

if ( get_theme_mod( 'optimized-checkout', true ) ) {
	add_action( 'template_redirect', 'Astoundify\Vendify\woocommerce_redirect_cart' );
}

add_action( 'wp_ajax_nopriv_vendify_update_order_quantity', 'Astoundify\Vendify\update_order_quantity_ajax' );
add_action( 'wp_ajax_vendify_update_order_quantity', 'Astoundify\Vendify\update_order_quantity_ajax' );

/**
 * Dashboard
 *
 * @since 1.0.0
 */
add_filter( 'vendify_is_transparent_header', 'Astoundify\Vendify\woocommerce_is_transparent_header' );

remove_action( 'woocommerce_order_details_after_order_table', 'woocommerce_order_again_button' );

add_filter( 'vendify_woocommerce_get_customer_activity', 'Astoundify\Vendify\woocommerce_customer_activity_orders' );
add_filter( 'vendify_woocommerce_get_customer_activity', 'Astoundify\Vendify\woocommerce_customer_activity_reviews' );

add_filter( 'woocommerce_account_menu_items', 'Astoundify\Vendify\woocommerce_filter_navigation_labels', 10, 2 );

/**
 * Vendify calls the navigation in `./vendify/app/integrations/woocommerce/views/myaccount/hero.php`.
 * We need to remove the call from WooCommerce in order to avoid a double navigation.
 */
remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation' );


add_action( 'woocommerce_register_form', 'Astoundify\Vendify\registration_privacy_policy', 11 );
add_filter( 'woocommerce_registration_errors', 'Astoundify\Vendify\validate_privacy_registration', 10, 3 );


add_filter( 'woocommerce_blocks_product_grid_item_html', 'Astoundify\Vendify\woocommerce_products_grid_item', 1, 3 );

add_filter( 'comment_form_fields', 'Astoundify\Vendify\push_reviews_text_field_at_the_end', 9 );
