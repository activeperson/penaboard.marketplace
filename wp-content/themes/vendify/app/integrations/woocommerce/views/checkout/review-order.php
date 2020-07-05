<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

namespace Astoundify\Vendify;

defined( 'ABSPATH' ) || exit;
?>
<div class="card card--fancy checkout__sidebar__card woocommerce-checkout-review-order-table">
	<header class="checkout__sidebar__header"><?php esc_html_e( 'Your Order', 'vendify' ); ?></header>

	<div class="orders">
		<?php
			do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
				?>

		<div class="order-item">
				<?php if ( ! $_product->get_image_id() ) : ?>
			<span class="order-item__img">
					<?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); ?>
			</span>
			<?php endif; ?>

			<div class="order-item__body">
				<span class="order-item__name">
					<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ); ?>
				</span>

				<?php if ( ! $_product->is_sold_individually() ) : ?>

					<span class="order-item__quantity">
						<?php
						woocommerce_quantity_input(
							[
								'input_value' => $cart_item['quantity'],
								'input_name'  => sprintf( 'cart[%s][quantity]', $cart_item_key ),
								'type'        => 'number',
								'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
								'min_value'   => '1',
							],
							$_product
						);
						?>
					</span>

				<?php endif; ?>
			</div>

			<span class="price ml-auto"><?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?></span>

			<a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="btn-icon btn-icon--close">
				<?php
				svg(
					[
						'icon'    => 'close',
						'classes' => [ 'ico--xs' ],
					]
				);
				?>
			</a>
		</div>
				<?php
		endif;
endforeach;
		?>
	</div>

	<footer class="checkout-receipt">
		<div class="checkout-receipt__main">
			<div class="checkout-receipt__item">
				<span>Подытог</span>
				<span><?php wc_cart_totals_subtotal_html(); ?></span>
			</div>

			<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				<div class="checkout-receipt__item text-primary cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
					<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
					<span><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
				</div>
			<?php endforeach; ?>

			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
				<div class="checkout-receipt__item checkout-receipt__item--shipping">
					<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

					<?php wc_cart_totals_shipping_html(); ?>

					<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
				</div>
			<?php endif; ?>

			<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
				<div class="checkout-receipt__item">
					<span><?php echo esc_html( $fee->name ); ?></span>
					<span><?php wc_cart_totals_fee_html( $fee ); ?></span>
				</div>
			<?php endforeach; ?>

			<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) : ?>
				<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
					<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
						<div class="checkout-receipt__item tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
							<span><?php echo esc_html( $tax->label ); ?></span>
							<span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
						</div>
					<?php endforeach; ?>
				<?php else : ?>
					<div class="checkout-receipt__item tax-total">
						<span><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
						<span><?php wc_cart_totals_taxes_total_html(); ?></span>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
		</div>

		<div class="checkout-receipt__total">
			<span>Итог</span>
			<span><?php wc_cart_totals_order_total_html(); ?></span>
		</div>
	</footer>

	<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
</div>

<script>
	jQuery('form.checkout').on('change', '.order-item__quantity input', () => {
		const data = {
			nonce: wc_checkout_params.update_order_review_nonce,
			checkout: jQuery('form.checkout').serialize(),
		}

		wp.ajax.send( 'vendify_update_order_quantity', {
			data,
			success() {
				jQuery(document.body).trigger('update_checkout', {
					update_shipping_method: false,
				});
			},
		} );
	});
</script>
