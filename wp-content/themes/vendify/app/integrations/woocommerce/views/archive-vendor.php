<?php
/**
 * Template Name: Find Vendors
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

if ( ! has_integration( 'woocommerce-product-vendors' ) ) {
	wp_die( esc_html__( 'Please reactivate the WooCommerce Product Vendors plugin.', 'vendify' ) );
}

view( 'global/header' );

wc_get_template( 'shop-featured-vendors.php' ); ?>

<div class="main-content main-content--single-section">
	<div class="container">
		<div class="row">

			<?php
			wc_get_template( 'vendors/search.php' );

			if ( ! isset( $_GET['vendor_search'] ) ) { // @codingStandardsIgnoreLine
				wc_get_template( 'vendors/tabs.php' );
			} else {
				wc_get_template( 'vendors/search-results.php' );
			} ?>

		</div>
	</div>
</div>

<?php
view( 'global/footer' );
