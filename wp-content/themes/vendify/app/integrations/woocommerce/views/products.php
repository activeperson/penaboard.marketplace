<?php
/**
 * The Template for displaying products for a global loop.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( woocommerce_product_loop() ) :
	do_action( 'woocommerce_before_shop_loop' );

	if ( wc_get_loop_prop( 'total' ) ) :
		wc_get_template( 'shop-filters.php' );

		woocommerce_product_loop_start();

		while ( have_posts() ) :
			the_post();

			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		endwhile;
	endif;

	woocommerce_product_loop_end();

	do_action( 'woocommerce_after_shop_loop' );
elseif ( ! woocommerce_product_subcategories(
	[
		'before' => woocommerce_product_loop_start( false ),
		'after'  => woocommerce_product_loop_end( false ),
	]
) ) :
	do_action( 'woocommerce_no_products_found' );
endif;
