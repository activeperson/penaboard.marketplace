<?php
/**
 * The template for displaying product content in the single-product.php template
 * when using the WooCommerce Product Vendors plugin.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$vendor_data  = get_vendor_meta( $product->get_id(), 'product_id' );
$all_products = get_vendor_products( $vendor_data['term_id'] );

wc_get_template(
	'single-product/hero/hero.php',
	[
		'vendor_data'  => $vendor_data,
		'all_products' => $all_products,
	]
);
?>

<main class="main-content main-content--single-section">
	<div class="container">
		<?php do_action( 'woocommerce_before_single_product' ); ?>

		<section class="product-main">
			<div class="product-gallery">
				<?php
				woocommerce_show_product_images();

				/**
				 * @hooked woocommerce_output_product_data_tabs - 10
				 */
				do_action( 'woocommerce_after_single_product_summary' );
				?>
			</div>

			<aside class="product-sidebar">
				<div class="product-sidebar__info">
					<?php
					woocommerce_template_single_rating();

					if ( 'variable' !== $product->get_type() ) :
						echo wc_get_stock_html( $product );
					endif;
					?>
				</div>

				<?php
				woocommerce_template_single_title();

				/**
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				do_action( 'woocommerce_single_product_summary' );
				?>

				<?php do_action( 'woocommerce_after_single_product' ); ?>

				<?php if ( ! empty( array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' ) ) || $product->has_weight() || $product->has_dimensions() ) : ?>
				<section class="card card--specs product-shop-info">
					<?php wc_display_product_attributes( $product ); ?>
				</section>
				<?php endif; ?>

				<section class="product-shop-info">
					<?php
					wc_get_template(
						'single-product/vendor-profile.php',
						[
							'vendor_data'  => $vendor_data,
							'all_products' => $all_products,
						]
					);
					?>
				</section>
			</aside>
		</section>

	</div>
</main>
