<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.5.3
 */

namespace Astoundify\Vendify;

defined( 'ABSPATH' ) || exit;

if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
} ?>
<div id="payment" class="woocommerce-checkout-payment">
	<fieldset class="wc_payment_methods payment_methods methods">
		<?php if ( WC()->cart->needs_payment() ) {
			if ( ! empty( $available_gateways ) ) { ?>
				<ul class="d-flex justify-content-center align-items-center mb-7 payment-method-toggles">
					<?php foreach ( $available_gateways as $gateway ) : ?>
						<li>
							<input id="payment_method_<?php echo $gateway->id; ?>" type="radio" class="input-radio"
							       name="payment_method"
							       value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?>
							       data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>"/>

							<label for="payment_method_<?php echo $gateway->id; ?>"
							       class="<?php echo esc_attr( $gateway->chosen ? 'active' : null ); ?>">
							<span class="btn btn-light btn--checkout-method">
								<?php echo $gateway->get_title(); ?>
							</span>
							</label>

							<?php
							/**
							 * Stripe's error notification is very specific and we need to add this element for it.
							 */
							if ( 'WC_Gateway_Stripe' === get_class( $gateway ) ) { ?>
								<div class="stripe-source-errors"></div>
							<?php } ?>
						</li>
					<?php endforeach; ?>
				</ul>

				<ul>
					<?php foreach ( $available_gateways as $gateway ) {
						wc_get_template( 'checkout/payment-method.php', [ 'gateway' => $gateway ] );
					}

				} else {
					echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'vendify' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'vendify' ) ) . '</li>'; // @codingStandardsIgnoreLine
				} ?>
			</ul>
		<?php } ?>

		<?php wc_get_template( 'checkout/terms.php' ); ?>
	</fieldset>

	<div class="place-order">
		<noscript>
			<?php esc_html_e( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'vendify' ); ?>
			<br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'vendify' ); ?>"><?php esc_html_e( 'Update totals', 'vendify' ); ?></button>
		</noscript>

		<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

		<div class="form--checkout-submit-wrap">
			<a href="#addresses" id="addresses" class="js-toggle-checkout-step link link-cta text-xs has-icon">
				<?php
				svg(
					[
						'icon'    => 'long-arrow-left',
						'classes' => [ 'ico--xs mr-2' ],
					]
				);
				?>

				<?php esc_html_e( 'Back to Addresses', 'vendify' ); ?>
			</a>

			<?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="btn btn-primary btn--checkout-submit" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>
		</div>

		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
	</div>
</div>

<?php
if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
