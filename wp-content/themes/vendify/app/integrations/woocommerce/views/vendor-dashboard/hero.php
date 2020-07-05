<?php
/**
 * Hero
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use WC_Product_Vendors_Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$vendor_data = get_vendor_meta( WC_Product_Vendors_Utils::get_logged_in_vendor() ); ?>

<section class="hero hero--animatable hero--dashboard has-half-gradient--bottom">
	<div class="hero__content hero__content--horizontal container">
		<?php if ( is_user_logged_in() && WC_Product_Vendors_Utils::is_vendor() ) : ?>
		<div class="hero--dashboard__logo">
			<?php echo get_avatar( get_current_user_id(), 64 ); ?>
		</div>
		<?php endif; ?>

		<h1 class="page-title"><?php the_title(); ?></h1>

		<?php if ( is_user_logged_in() && WC_Product_Vendors_Utils::is_vendor() && ! WC_Product_Vendors_Utils::is_pending_vendor() ) { ?>
			<a href="<?php echo esc_url( woocommerce_product_vendors_new_product_url() ); ?>" class="btn-add tooltip tooltip--top" aria-label="<?php esc_html_e( 'Create Product', 'vendify' ); ?>">
				<?php
				svg(
					[
						'icon'    => 'plus',
						'classes' => [ 'ico--sm' ],
					]
				); ?>
			</a>
		<?php } ?>
	</div>

	<div class="hero__image-holder" aria-hidden="true">
		<div class="hero__image" style="background-image: url(<?php echo esc_url( hero_image_src( $vendor_data['cover_image'] ) ); ?>)"></div>
	</div>
</section>

<?php
if ( is_user_logged_in() && WC_Product_Vendors_Utils::is_vendor() ) :
	/**
	 * Vendor Dashboard Navigation.
	 *
	 * @since 1.0.0
	 */
	do_action( 'astoundify_wc_themes_vendors_dashboard_navigation' );
endif;

