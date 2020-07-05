<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>

<div class="col">

	<h4 class="order-card__heading"><?php _e( 'Billing Address', 'vendify' ); ?></h4>

	<address>
		<?php echo wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'vendify' ) ) ); ?>

		<?php if ( $order->get_billing_phone() ) : ?>
			<p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
		<?php endif; ?>
	</address>


	<?php if ( $order->get_billing_email() ) : ?>
		<h4 class="order-card__heading"><?php _e( 'Email Address', 'vendify' ); ?></h4>

		<p class="woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></p>
	<?php endif; ?>
</div>

<?php if ( $show_shipping ) : ?>

	<div class="col">

		<h4 class="order-card__heading"><?php _e( 'Shipping Address', 'vendify' ); ?></h4>
		<address>
			<?php echo wp_kses_post( $order->get_formatted_shipping_address( __( 'N/A', 'vendify' ) ) ); ?>
		</address>

	</div><!-- /.col-2 -->

<?php endif; ?>

<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
