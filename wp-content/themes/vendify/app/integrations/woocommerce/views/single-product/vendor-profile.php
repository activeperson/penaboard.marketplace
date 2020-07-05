<?php
/**
 * Load vendor products.
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

if ( empty( $all_products ) ) :
	return;
endif;

// Get some other random products to show.
shuffle( $all_products ); ?>

<section class="product-shop-info">
	<header class="product-shop-info__header">
		<img class="product-shop-info__logo" src="<?php echo esc_url( wp_get_attachment_image_url( $vendor_data['logo'], 'thumbnail' ) ); ?>" alt="<?php esc_attr_e( 'Logo.', 'vendify' ); ?>">

		<a class="link link-cta text-dark" href="<?php echo esc_url( get_term_link( $vendor_data['term_id'], WC_PRODUCT_VENDORS_TAXONOMY ) ); ?>">
			<?php echo esc_html( $vendor_data['name'] ); ?>
		</a>

		<span class="vendor_location"><?php echo esc_html( $vendor_data['vendor_location'] ); ?></span>
	</header>

	<?php if ( ! empty( $all_products ) ) : ?>

		<section class="product-grid product-grid--small" data-columns="2">
		<?php
		remove_action( 'woocommerce_shop_loop_item_header', 'woocommerce_show_product_loop_sale_flash' );
		remove_action( 'woocommerce_shop_loop_item_header', 'Astoundify\Vendify\Favorites\shop_loop_item_header' );

		foreach ( array_slice( $all_products, 0, 4 ) as $product ) :
			$post_object                     = get_post( $product->get_id() );
			setup_postdata( $GLOBALS['post'] =& $post_object ); // @codingStandardsIgnoreLine
			wc_get_template(
				'content-product.php',
				[
					'show_vendor' => false,
					'card_style'  => 5,
				]
			);
		endforeach;
		wp_reset_postdata();

		add_action( 'woocommerce_shop_loop_item_header', 'woocommerce_show_product_loop_sale_flash' );
		add_action( 'woocommerce_shop_loop_item_header', 'Astoundify\Vendify\Favorites\shop_loop_item_header' ); ?>
		</section>

		<div class="text-center">
			<a href="<?php echo esc_url( get_term_link( $vendor_data['term_id'], WC_PRODUCT_VENDORS_TAXONOMY ) ); ?>" class="link link-cta text-xs has-icon">
				<?php
				esc_html_e( 'View All', 'vendify' );

				svg(
					[
						'icon'    => 'long-arrow-right',
						'classes' => [ 'ico--xs', 'ml-2' ],
					]
				);
				?>
			</a>
		</div>
	<?php endif; ?>
</section>
