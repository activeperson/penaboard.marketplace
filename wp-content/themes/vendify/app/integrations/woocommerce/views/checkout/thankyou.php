<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order">

	<?php if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

	<div class="order-card">
		<header class="order-card__header">
			<?php if ( ! $order->has_status( 'failed' ) ) : ?>

				<h2>Ваш заказа принят!<?php // echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Your order has been received!', 'woocommerce' ), $order ); ?></h2>

			<?php endif; ?>
		</header>

		<div class="order-card__body">

			<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="btn btn-primary"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
					<?php endif; ?>
				</p>

			<?php else : ?>

				<div class="row">
					<div class="col">
						<h4 class="order-card__heading"><?php esc_html_e( 'Order number:', 'woocommerce' ); ?></h4>
						<p><?php echo $order->get_order_number(); ?></p>

						<h4 class="order-card__heading"><?php esc_html_e( 'Date:', 'woocommerce' ); ?></h4>
						<p><?php echo wc_format_datetime( $order->get_date_created() ); ?></p>

						<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
							<h4 class="order-card__heading"><?php esc_html_e( 'Email:', 'woocommerce' ); ?></h4>
							<p><?php echo $order->get_billing_email(); ?></p>
						<?php endif; ?>
					</div>
					<div class="col">
						<h4 class="order-card__heading"><?php esc_html_e( 'Total:', 'woocommerce' ); ?></h4>
						<p><?php echo $order->get_formatted_order_total(); ?></p>

						<?php if ( $order->get_payment_method_title() ) : ?>
							<h4 class="order-card__heading"><?php esc_html_e( 'Payment method:', 'woocommerce' ); ?></h4>
							<p><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></p>
						<?php endif; ?>

						<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
					</div>
				</div>

			<?php endif; ?>

		</div>

	</div>

		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

	<?php endif; ?>

</div>
