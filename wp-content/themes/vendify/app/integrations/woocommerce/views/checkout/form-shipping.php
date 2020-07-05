<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;

if ( true === WC()->cart->needs_shipping_address() ) : ?>

<fieldset class="woocommerce-shipping-fields">
		<div class="row align-items-center">
			<div class="col-md-6">
				<h3 class="form--checkout__title"><?php esc_html_e( 'Shipping Address', 'vendify' ); ?></h3>
			</div>

			<div id="ship-to-different-address" class="col-md-6">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox custom-control custom-checkbox">
					<input id="ship-to-different-address-checkbox" class="custom-control-input woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" type="checkbox" name="ship_to_different_address" value="1" />
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description"><?php esc_html_e( 'Ship to a different address?', 'vendify' ); ?></span>
				</label>
			</div>
		</div>

		<div class="shipping_address" style="display: none;">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<div class="woocommerce-shipping-fields__field-wrapper">
				<?php
				$fields = $checkout->get_checkout_fields( 'shipping' );

				foreach ( $fields as $key => $field ) {
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
				}
				?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

</fieldset>

<?php endif; ?>

<?php if ( ! apply_filters( 'vendify_optimized_checkout', true ) ) : ?>

	<div class="woocommerce-additional-fields">
		<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

		<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

			<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

				<h3><?php esc_html_e( 'Additional information', 'vendify' ); ?></h3>

			<?php endif; ?>

			<div class="woocommerce-additional-fields__field-wrapper">
				<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
	</div>

<?php endif; ?>
