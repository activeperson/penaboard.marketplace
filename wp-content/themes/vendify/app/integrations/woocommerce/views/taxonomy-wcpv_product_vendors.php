<?php
/**
 * The Template for displaying the vendor profile.
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
	exit; // Exit if accessed directly
}

$vendor = get_queried_object();

if ( ! is_object( $vendor ) || empty( $vendor->term_id ) ) {
	return;
}

$vendor_data = get_vendor_meta( $vendor->term_id );
$sales_data  = astoundify_wc_themes_vendors_get_vendor_total_data(
	[
		'vendor_id' => $vendor->term_id,
		'range'     => null,
	]
);

get_header( 'shop' );

wc_get_template(
	'single-vendor/hero.php',
	[
		'vendor'      => $vendor,
		'vendor_data' => $vendor_data,
		'sales_data'  => $sales_data,
	]
); ?>

<nav class="navigation navigation--profile">
	<div class="container">
		<ul class="nav nav-tabs">
			<li class="nav-item <?php echo 'shop' === astoundify_wc_themes_vendors_archive_get_active_endpoint() ? 'active' : null; ?>">
				<a class="nav-link" href="<?php echo esc_url( get_term_link( get_queried_object() ) ); ?>">
					<?php esc_html_e( 'Shop', 'vendify' ); ?>
				</a>
			</li>

			<?php foreach ( astoundify_wc_themes_vendors_archive_endpoints() as $key => $endpoint ) : ?>
				<li class="nav-item <?php if ( $key === astoundify_wc_themes_vendors_archive_get_active_endpoint() ) echo 'active'; ?>">
					<a class="nav-link" href="<?php echo esc_url( astoundify_wc_themes_vendors_archive_get_endpoint_url( $key ) ); ?>"><?php echo esc_html( $endpoint['title'] ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</nav>

<main class="main-content main-content--single-section">
	<div class="container">

		<div class="row">
			<aside class="profile-sidebar">
				<div class="shop-description">
					<?php

					// showing the rating stars based on the option from WooCommerce
					$show_ratings = get_option( 'wcpv_vendor_settings_vendor_review', 'yes' );
					if ( 'yes' === $show_ratings ) {
						$product_count = 0;
						$product_ids = WC_Product_Vendors_Utils::get_vendor_product_ids($vendor->term_id);
						foreach ( $product_ids as $product_id ) {
							$product_count += wc_get_product( $product_id )->get_rating_count();
						}
						printf( __('<div class="vendor-ratings-count">&#40; %s &#41;</div>', 'vendify'), $product_count);
						echo wc_get_rating_html( WC_Product_Vendors_Utils::get_vendor_rating( $vendor->term_id )); // WPCS: XSS ok.
					}

					if ( isset( $vendor_data['vendor_tagline'] ) && '' !== $vendor_data['vendor_tagline'] ) :
						echo wp_kses_post( wpautop( $vendor_data['vendor_tagline'] ) );
					endif;

					$url = isset( $vendor_data['contact_method_url'] ) ? esc_url( $vendor_data['contact_method_url'] ) : false;
					if ( $url ) : ?>
						<a href="<?php echo esc_url( $url ); ?>" rel="ugc"><?php echo esc_html( wp_parse_url( $url )['host'] ); ?></a>
					<?php endif;

					$methods = astoundify_wc_themes_get_additional_contact_methods();
					unset( $methods['url'] );
					if ( ! empty( $methods ) ) : ?>
					<div class="shop-description__social">
						<?php
						foreach ( $methods as $key => $value ) :
							if ( ! isset( $vendor_data[ 'contact_method_' . $key ] ) || ! $vendor_data[ 'contact_method_' . $key ] ) :
								continue;
							endif; ?>
							<a href="<?php echo esc_url( $vendor_data[ 'contact_method_' . $key ] ); ?>" rel="nofollow"><?php svg( $key ); ?></a>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
				</div>
			</aside>

			<div class="profile-main">
				<?php do_action( 'vendify_vendor_archive_' . astoundify_wc_themes_vendors_archive_get_active_endpoint() ); ?>
			</div>
		</div>

	</div>
</main>

<?php
get_footer( 'shop' );
