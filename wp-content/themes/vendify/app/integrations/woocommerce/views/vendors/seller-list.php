<?php
/**
 * Seller list for vendor archive.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use WC_Product_Vendors_Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$vendor      = get_term( (int) $vendor, WC_PRODUCT_VENDORS_TAXONOMY );
$vendor_data = get_vendor_meta( $vendor->term_id ); ?>

<div class="seller-list__item">
	<a href="<?php echo esc_url( get_term_link( $vendor ) ); ?>" class="seller-list__img">
		<img src="<?php echo esc_url( $vendor_data['logo_image'] ); ?>" alt="<?php esc_attr_e( 'Logo.', 'vendify' ); ?>" width="54" />
	</a>

	<div class="seller-list__item__content">
		<h5>
			<a href="<?php echo esc_url( get_term_link( $vendor ) ); ?>">
				<?php echo esc_html( $vendor_data['name'] ); ?>
			</a>
		</h5>

		<span class="seller-item__rating">
			<?php
			svg(
				[
					'icon'    => 'star-rating',
					'classes' => [ 'ico--sm', 'mr-2' ],
				]
			);

			$stars = number_format( WC_Product_Vendors_Utils::get_vendor_rating( $vendor->term_id ), 1 );

			// Translators: %s Star rating.
			echo esc_html( 0 === $stars ? __( 'N/A', 'vendify' ) : sprintf( __( '%s Stars', 'vendify' ), $stars ) ); ?>
		</span>
	</div>
</div>
