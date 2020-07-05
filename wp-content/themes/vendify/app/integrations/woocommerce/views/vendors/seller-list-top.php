<?php
/**
 * Seller list for vendor archive (top featured items).
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$vendor          = get_term( (int) $vendor, WC_PRODUCT_VENDORS_TAXONOMY );
$vendor_data     = get_vendor_meta( $vendor->term_id );
$recent_products = get_vendor_products(
	$vendor->term_id,
	[
		'limit' => 3,
	]
);
$total_products  = get_vendor_products_count( $vendor->term_id ); ?>

<div class="seller-grid__column">
	<div class="seller-item">

		<div class="seller-item__body">
			<?php foreach ( $recent_products as $product ) : ?>
				<div class="seller-item__img">
					<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
						<?php
							if ( ! empty( $product->get_image_id() ) ) {
								printf ( __('<div class="seller-item__img--content" style="background-image:url(%s);"></div>', 'vendify'),wp_get_attachment_url( $product->get_image_id() ) );
							}
						?>
					</a>
				</div>
			<?php endforeach; ?>
		</div>

		<footer class="seller-item__info">
			<span class="seller-item__shop-name">
				<a href="<?php echo esc_url( get_term_link( $vendor ) ); ?>" class="seller-item__logo">

					<img src="<?php echo esc_url( $vendor_data['logo_image'] ); ?>" alt="<?php esc_attr_e( 'Logo.', 'vendify' ); ?>" width="24" />
				</a>

				<a href="<?php echo esc_url( get_term_link( $vendor ) ); ?>" class="<?php echo apply_filters( 'vendify_product_card_autor_name_class', '' ); ?>">
					<?php echo esc_html( $vendor_data['name'] ); ?>
				</a>
			</span>

			<span class="seller-item__quantity">
				<?php echo esc_html( sprintf( __( '%d Products', 'vendify' ), $total_products ) ); ?>
			</span>
		</footer>

	</div>
</div>
