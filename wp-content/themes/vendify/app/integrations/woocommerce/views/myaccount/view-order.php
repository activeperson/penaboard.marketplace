<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
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
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="container">
	<div class="row">
		<div class="view-order__main">
			<div class="order-card">
				<header class="order-card__header">
					<h2><?php printf( esc_html__( 'Order #%1$s Details', 'vendify' ), $order->get_order_number() ); ?></h2>
				</header>
				<div class="order-card__body">
					<div class="row">
						<div class="col">
							<p><?php echo wc_format_datetime( $order->get_date_created() ); ?></p>

							<h4 class="order-card__heading"><?php esc_html_e( 'Order Status', 'vendify' ); ?></h4>

							<p><span class="badge badge--<?php echo esc_attr( $order->get_status() ); ?>"><?php echo esc_attr( wc_get_order_status_name( $order->get_status() ) ); ?></span>

							<?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>
								<h4 class="order-card__heading">
									<?php echo str_replace( ':', '', ucwords( wp_kses_post( $total['label'] ) ) ); ?>
								</h4>
								<p><?php echo wp_kses_post( $total['value'] ); ?></p>
							<?php endforeach; ?>

							<?php if ( $order->get_customer_note() ) : ?>
								<h4 class="order-card__heading"><?php _e( 'Note:', 'vendify' ); ?></h4>
								<p><?php echo wptexturize( $order->get_customer_note() ); ?></p>
							<?php endif; ?>

							<p><?php woocommerce_order_again_button( $order ); ?></p>
						</div>

						<?php wc_get_template( 'order/order-details-customer.php', [ 'order' => $order ] ); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="view-order__sidebar">
			<h3 class="order-updates-title"><?php _e( 'Order Updates', 'vendify' ); ?></h3>

			<?php if ( $notes = $order->get_customer_order_notes() ) : ?>
				<ol class="order-updates">
					<?php foreach ( $notes as $note ) : ?>
					<li class="order-update">
						<div class="order-update__content">
							<header class="order-update__header">
								<span class="order-update__date"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $note->comment_date ) ); ?></span>
							</header>

							<div class="order-update__body">
								<?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
							</div>
						</div>
					</li>
					<?php endforeach; ?>
				</ol>
			<?php else : ?>
				<p><?php esc_html_e( 'No updates for this order.', 'vendify' ); ?></p>
			<?php endif; ?>
		</div>
	</div>

	<?php do_action( 'woocommerce_view_order', $order_id ); ?>
</div>
