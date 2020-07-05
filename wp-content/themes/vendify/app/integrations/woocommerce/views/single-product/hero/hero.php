<?php
/**
 * Single product hero.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="hero hero--animatable hero--product has-half-gradient--bottom">
	<div class="hero__image-holder" aria-hidden="true">
		<div class="hero__image" style="background-image: url(<?php echo esc_url( wp_get_attachment_image_url( $vendor_data['cover'], 'cover' ) ); ?>)"></div>
	</div>

	<div class="shop-info container">
		<div class="shop-info__logo">
			<img src="<?php echo esc_url( $vendor_data['logo_image'] ); ?>" alt="<?php esc_attr_e( 'Logo.', 'vendify' ); ?>" width="94" />
		</div>

		<div class="shop-info__content">
			<?php
			wc_get_template(
				'single-product/hero/primary.php',
				[
					'vendor_data'  => $vendor_data,
					'all_products' => $all_products,
				]
			);

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
</section>
