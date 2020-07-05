<?php
/**
 * Single vendor hero.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use WC_Product_Vendors_Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<section class="hero hero--animatable hero--profile has-half-gradient--bottom">
	<div class="hero__image-holder" aria-hidden="true">
		<div class="hero__image" style="background-image: url(<?php echo esc_url( $vendor_data['cover_image'] ); ?>)"></div>
	</div>

	<div class="shop-info shop-info--large container">
		<div class="shop-info__logo">
			<img src="<?php echo esc_url( $vendor_data['logo_image'] ); ?>" alt="<?php esc_attr_e( 'Logo.', 'vendify' ); ?>" width="180" />
		</div>

		<div class="shop-info__content">
			<div class="shop-info__primary has-text-color has-light-color">
				<h2 class="shop-info__name"><?php echo esc_html( $vendor_data['name'] ); ?></h2>

				<ul class="shop-info__stats">
					<?php
					if ( ! empty( $vendor_data['vendor_location'] ) ) : ?>
						<li>
							<?php
							svg(
								[
									'icon'    => 'pin',
									'classes' => [ 'ico--reverse', 'ico--sm' ],
								]
							);

							echo esc_html( $vendor_data['vendor_location'] ); ?>
						</li>
					<?php endif; ?>

					<li>
						<?php
						svg(
							[
								'icon'    => 'sales-outline',
								'classes' => [ 'ico--reverse', 'ico--sm' ],
							]
						);

						// Translators: %d number of sales.
						esc_html_e( sprintf( _n( '%d Sale', '%d Sales', absint( $sales_data ), 'vendify' ), $sales_data ) ); ?>
					</li>

					<li class="<?php ( ! empty( $vendor_data['vendor_location'] ) ? esc_attr_e( 'd-none', 'vendify' ) : '' ); ?> d-md-flex">
						<?php
						svg(
							[
								'icon'    => 'star-outline',
								'classes' => [ 'ico--reverse', 'ico--sm' ],
							]
						);

						// Translators: %s number of stars out of 5.
						esc_html_e( sprintf( esc_html__( '%s Stars', 'vendify' ), number_format( WC_Product_Vendors_Utils::get_vendor_rating( $vendor->term_id ), 1 ) ) ); ?>
					</li>
				</ul>
			</div>

			<div class="shop-info__secondary">

				<?php
				if ( has_integration( 'favorites' ) ) {
					echo astoundify_favorites_link( get_queried_object_id(), '', '', 'wcpv_product_vendors' );
				}

				if ( has_integration( 'private-messages' ) && ! empty( $vendor_data['ID'] ) ) { ?>
					<a class="btn btn-sm btn-<?php echo apply_filters( 'vendify_vendor_contact_button_color', 'light' ); ?>" href="<?php echo esc_url( pm_get_new_message_url( $vendor_data['ID'] ) ); ?>">
						<?php esc_html_e( 'Contact Seller', 'vendify' ); ?>
					</a>
				<?php } ?>

			</div>
		</div>
	</div>
</section>
