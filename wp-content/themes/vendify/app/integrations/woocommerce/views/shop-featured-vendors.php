<?php
/**
 * Shop featured vendors.
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

$featured = woocommerce_product_vendors_get_featured_vendors();

if ( empty( $featured ) ) {
	return;
} ?>

<section class="hero hero--find hero--slider">
	<div class="flickity--image <?php if ( count( $featured ) > 1 ) { echo esc_attr( 'hero__slider' ); } ?>">

		<?php
		foreach ( $featured as $term ) :
			$vendor_data  = get_vendor_meta( $term->term_id );
			$all_products = get_vendor_products( $term->term_id );

			$image_class = '';
			if ( ! empty( $vendor_data['cover'] ) ) {
				$imgmeta = wp_get_attachment_metadata( $vendor_data['cover'] );
				if ( $imgmeta['width'] > $imgmeta['height'] ) {
					$image_class = 'landscape';
				} else {
					$image_class = 'portrait';
				}
			} ?>

		<div class="hero__slide has-gradient--top">
			<?php if ( ! empty( $vendor_data['cover'] ) ) { ?>
				<img class="<?php echo esc_attr( 'hero-image-direction-' . $image_class ); ?>" src="<?php echo esc_url( wp_get_attachment_image_url( $vendor_data['cover'], 'cover' ) ); ?>" alt="<?php esc_attr_e( 'Cover image.', 'vendify' ); ?>" />
			<?php } ?>

			<div class="shop-info shop-info--listing container">
				<div class="shop-info__content">
					<div class="shop-info__primary">
						<h1>
							<?php if ( isset( $vendor_data['tagline'] ) ) : ?>
								<span class="display-4 d-block"><?php echo esc_html( $vendor_data['tagline'] ); ?></span>
							<?php endif; ?>

							<span class="display-2 d-block shop-info__name"><?php echo esc_html( $vendor_data['name'] ); ?></span>
						</h1>

						<div class="hero__cta">
							<a href="<?php echo esc_url( get_term_link( $term->term_id, WC_PRODUCT_VENDORS_TAXONOMY ) ); ?>" class="btn btn-light js-test"><?php esc_html_e( 'Visit Seller', 'vendify' ); ?></a>
						</div>
					</div>

					<div class="shop-info__secondary">
						<?php
						wc_get_template(
							'single-product/hero/secondary.php',
							[
								'vendor_data'  => $vendor_data,
								'all_products' => $all_products,
							]
						);
						?>
					</div>
				</div>
			</div>
		</div>

		<?php endforeach; ?>

	</div>
</section>
