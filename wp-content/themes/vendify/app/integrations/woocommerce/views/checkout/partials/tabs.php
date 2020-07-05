<?php
/**
 * Checkout tabs.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Theme
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} ?>

<form name="checkout" method="post" class="checkout woocommerce-checkout row <?php echo esc_attr( false === wc_string_to_bool( get_option( 'woocommerce_checkout_highlight_required_fields', 'yes' ) ) ? 'hide-required' : null ); ?>" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<section class="checkout__main <?php echo ! woocommerce_is_order_received() ? 'checkout__main--has-sidebar' : null; ?>">

		<nav class="navigation navigation--checkout">
			<ul class="nav nav-tabs nav-justified">
				<li class="nav-item">
					<button target_id="addresses" class="js-toggle-checkout-step nav-link <?php echo ! woocommerce_is_order_received() ? 'active' : 'disabled'; ?>">
						<span class="badge badge--sm badge--pill <?php echo ! woocommerce_is_order_received() ? 'badge-secondary' : 'badge-outline-gray-500'; ?> mr-2">1</span>
						<?php esc_html_e( 'Addresses', 'vendify' ); ?>
					</button>
				</li>

				<li class="nav-item">
					<button target_id="choose-payment" class="js-toggle-checkout-step nav-link <?php echo ! woocommerce_is_order_received() ? null : 'disabled'; ?>">
						<span class="badge badge--sm badge--pill badge-outline-gray-500 mr-2">2</span>
						<?php esc_html_e( 'Payment', 'vendify' ); ?>
					</button>
				</li>

				<li class="nav-item">
					<button class="nav-link <?php echo woocommerce_is_order_received() ? 'active' : 'disabled'; ?>">
						<span class="badge badge--sm badge--pill <?php echo woocommerce_is_order_received() ? 'badge-secondary' : 'badge-outline-gray-500'; ?> mr-2">3</span>
						<?php esc_html_e( 'Confirmation', 'vendify' ); ?>
					</button>
				</li>
			</ul>
		</nav>

		<div class="tab-content">
			<div class="tab-pane active" target_id="addresses">
				<?php wc_get_template( 'checkout/partials/step-1.php' ); ?>
			</div>

			<div class="tab-pane" target_id="choose-payment">
				<?php wc_get_template( 'checkout/partials/step-2.php' ); ?>
			</div>
		</div>

	</section>

	<?php if ( ! woocommerce_is_order_received() ) : ?>
		<section class="checkout__sidebar">
			<?php woocommerce_order_review(); ?>
		</section>
	<?php endif; ?>

</form>
