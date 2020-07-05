<?php
/**
 * Single product hero: primary.
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
?>

<div class="shop-info__primary">
	<h2 class="shop-info__name"><?php echo esc_html( $vendor_data['name'] ); ?></h2>

	<?php
	if ( has_integration( 'favorites' ) ) :
		echo astoundify_favorites_link( $vendor_data['term_id'], '', '', 'wcpv_product_vendors' ); // WPCS: XSS okay.
	endif;
	?>

	<a class="btn btn-sm btn-light d-inline-block" href="<?php echo esc_url( get_term_link( $vendor_data['term_id'], WC_PRODUCT_VENDORS_TAXONOMY ) ); ?>">
		<?php esc_html_e( 'View Profile', 'vendify' ); ?>
	</a>
</div>
