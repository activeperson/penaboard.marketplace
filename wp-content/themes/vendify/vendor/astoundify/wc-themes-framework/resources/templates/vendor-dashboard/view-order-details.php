<?php
/**
 * View Order Details Section
 *
 * Shows the first intro screen on the account dashboard.
 * For Sales Summary, Links, etc.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var int    $order_id
 * @var object $order
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div id="vendors-order-details" class="vendors-order-section">

	<div class="vendors-order-section-column">
		<h4><?php esc_html_e( 'General Details', 'astoundify-wc-themes' ); ?></h4>

		<p><?php
			/* Translators: 1: order number 2: order date 3: order status */
			printf(
				esc_html__( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'astoundify-wc-themes' ),
				'<mark class="order-number">' . $order->get_order_number() . '</mark>',
				'<mark class="order-date">' . wc_format_datetime( $order->get_date_created() ) . '</mark>',
				'<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>'
			);
		?></p>
	</div><!-- .vendors-order-section-column -->

	<div class="vendors-order-section-column">
		<h4><?php esc_html_e( 'Billing Details', 'astoundify-wc-themes' ); ?></h4>

		<div class="address">
			<?php
			if ( $order->get_formatted_billing_address() ) {
				echo '<p><strong>' . esc_html__( 'Address', 'astoundify-wc-themes' ) . ':</strong><br/>' . wp_kses( $order->get_formatted_billing_address(), array(
					'br' => array(),
				) ) . '</p>';
			} else {
				echo '<p class="none_set"><strong>' . esc_html__( 'Address', 'astoundify-wc-themes' ) . ':</strong> ' . esc_html__( 'No shipping address set.', 'astoundify-wc-themes' ) . '</p>';
			}

			$address = $order->get_address(); ?>
			<p>
				<strong><?php esc_html_e( 'Email:', 'astoundify-wc-themes' ); ?></strong>
				<a href="mailto:<?php echo sanitize_email( $address['email'] ); ?>"><?php echo sanitize_email( $address['email'] ); ?></a>
			</p>

			<p>
				<strong><?php esc_html_e( 'Phone:', 'astoundify-wc-themes' ); ?></strong>
				<?php echo esc_html( $address['phone'] ); ?>
			</p>
		</div>
	</div><!-- .vendors-order-section-column -->

	<div class="vendors-order-section-column">
		<h4><?php esc_html_e( 'Shipping Details', 'astoundify-wc-themes' ); ?></h4>

		<div class="address">
			<?php
			if ( $order->get_formatted_shipping_address() ) {
				echo '<p><strong>' . esc_html__( 'Address', 'astoundify-wc-themes' ) . ':</strong>' . wp_kses( $order->get_formatted_shipping_address(), array(
					'br' => array(),
				) ) . '</p>';
			} else {
				echo '<p class="none_set"><strong>' . esc_html__( 'Address', 'astoundify-wc-themes' ) . ':</strong> ' . esc_html__( 'No shipping address set.', 'astoundify-wc-themes' ) . '</p>';
			}

			$address = $order->get_address(); ?>
		</div>
	</div><!-- .vendors-order-section-column -->

</div><!-- #vendors-order-details -->
