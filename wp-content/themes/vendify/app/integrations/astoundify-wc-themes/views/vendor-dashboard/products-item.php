<?php
/**
 * Products Item
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var WC_Product $product Product Object.
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="product product-vendor-overview js-reveal">
	<div class="card product-item product-item--scale product-item--editable">
		<header class="pi__header pi__header-vendor-product">
			<div class="dropdown dropdown--edit-pi">
				<button class="btn-icon btn-icon--more" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
					<?php
					svg(
						[
							'icon'    => 'more',
							'classes' => [ 'ico--inverse' ],
						]
					); ?>
				</button>

				<div class="dropdown-menu dropdown-menu-right dropdown-menu--has-icons">
					<?php astoundify_wc_themes_vendors_dashboard_products_actions( $product ); ?>
				</div>
			</div>
		</header>

		<div class="pi__img-holder">
			<?php echo $product->get_image( 'medium' ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

			<div class="pi__overlay">
				<div class="pi__stats">
					<div class="pi__stat">
						<span class="pi__stat__value"><?php echo $product->get_total_sales(); ?></span>
						<span class="pi__stat__name"><?php esc_html_e( 'Sales', 'vendify' ); ?></span>
					</div>

					<div class="pi__stat">
						<span class="pi__stat__value">
						<?php
						echo wc_price(
							astoundify_wc_themes_vendors_get_vendor_total_data(
								[
									'column'     => 'total_commission_amount',
									'status'     => 'paid',
									'range'      => null,
									'product_id' => $product->get_id(),
								]
							)
						); ?>
						</span>
						<span class="pi__stat__name"><?php esc_html_e( 'Earned', 'vendify' ); ?></span>
					</div>
				</div>
			</div>
		</div>

		<div class="pi__content">
			<div class="pi__content__body">
				<h5 class="pi__name">
					<?php echo $product->get_title(); ?>
				</h5>
				<?php astoundify_wc_themes_vendors_dashboard_products_columns_product_stock( $product ); ?>
			</div>

			<span class="badge badge-outline-primary ml-auto pi__price">
				<?php astoundify_wc_themes_vendors_dashboard_products_columns_product_price( $product ); ?>
			</span>
		</div>

		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</div>
</div>
