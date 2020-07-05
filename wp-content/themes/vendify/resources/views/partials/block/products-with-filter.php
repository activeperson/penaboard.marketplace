<?php
/**
 * Products with filter.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 *
 * @var $attributes array The attributes.
 *
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$products_per_page = isset( $attributes['postNumber'] ) ? $attributes['postNumber'] : '8';

ob_start(); ?>

<div
	class="wp-block-vendify-product-with-filter container-fluid align<?php echo( isset( $attributes['align'] ) ? $attributes['align'] : '' ); ?>">
	<div class="components-disabled">
		<?php
		if ( ! function_exists( 'wc_get_products' ) ) {
			return;
		}

		$product_categories = get_terms( array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
		) );

		$paged             = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		$products_per_page = $products_per_page;

		$products_ids = wc_get_products( array(
			'status'   => 'publish',
			'limit'    => $products_per_page,
			'page'     => $paged,
			'paginate' => true,
			'return'   => 'ids',
		) );

		wc_set_loop_prop( 'current_page', $paged );
		wc_set_loop_prop( 'is_paginated', wc_string_to_bool( true ) );
		wc_set_loop_prop( 'page_template', get_page_template_slug() );
		wc_set_loop_prop( 'per_page', $products_per_page );
		wc_set_loop_prop( 'total', $products_ids->total );
		wc_set_loop_prop( 'total_pages', $products_ids->max_num_pages );
		if ( $products_ids ) {
			do_action( 'woocommerce_before_shop_loop' );
			?>
			<div class="filter-wrapper">
				<div class="category-wrap">
					<ul class="product-categories">
						<li><a class="all" href="#" onclick="return false;"><?php _e( 'All', 'vendify' ); ?></a></li>
						<?php
						foreach ( $product_categories as $category ) {
							if ( 'uncategorized' === $category->slug ) {
								continue;
							} ?>
							<li>
							<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>"> <?php echo $category->name; ?></a>
							</li><?php
						}
						?>
					</ul>
				</div>
				<div class="product-sort">
					<div class="product-count"><?php echo $products_ids->total . __(' Results','vendify'); ?></div>
					<?php woocommerce_catalog_ordering(); ?>
				</div>
			</div><?php

			woocommerce_product_loop_start();
			foreach ( $products_ids->products as $featured_product ) {
				$post_object = get_post( $featured_product );
				setup_postdata( $GLOBALS['post'] =& $post_object );
				wc_get_template_part( 'content', 'product' );
			}
			wp_reset_postdata();
			woocommerce_product_loop_end();
			do_action( 'woocommerce_after_shop_loop' );
		} else {
			do_action( 'woocommerce_no_products_found' );
		}
		?>
	</div>
</div>


