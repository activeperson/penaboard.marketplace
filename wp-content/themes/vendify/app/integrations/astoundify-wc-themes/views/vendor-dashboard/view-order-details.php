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

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="container">

	<?php wc_print_notices(); ?>

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

							<p>
								<span class="badge badge--<?php echo esc_attr( $order->get_status() ); ?>">
									<?php echo wc_get_order_status_name( esc_attr( $order->get_status() ) ); ?>
								</span>
							</p>

							<?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>
								<h4 class="order-card__heading"><?php echo wp_kses_post( $total['label'] ); ?></h4>
								<p><?php echo wp_kses_post( $total['value'] ); ?></p>
							<?php endforeach; ?>

							<?php if ( $order->get_customer_note() ) : ?>
								<h4 class="order-card__heading"><?php esc_html_e( 'Note', 'vendify' ); ?></h4>
								<p><?php echo wptexturize( $order->get_customer_note() ); ?></p>
							<?php endif; ?>
						</div>

						<div class="col">
							<h4 class="order-card__heading"><?php esc_html_e( 'Billing Address', 'vendify' ); ?></h4>

							<div class="address">
								<?php
								if ( $order->get_formatted_billing_address() ) {
									echo '<p>' . wp_kses(
										$order->get_formatted_billing_address(),
										[
											'br' => [],
										]
									) . '</p>';
								} else {
									echo '<p class="none_set">' . esc_html__( 'No shipping address set.', 'vendify' ) . '</p>';
								}

								$address = $order->get_address(); ?>

								<h4 class="order-card__heading"><?php esc_html_e( 'Email', 'vendify' ); ?></h4>

								<p>
									<a href="mailto:<?php echo esc_attr( $address['email'] ); ?>"><?php echo sanitize_email( $address['email'] ); ?></a>
								</p>

								<h4 class="order-card__heading"><?php esc_html_e( 'Phone', 'vendify' ); ?></h4>

								<p>
									<?php echo esc_html( $address['phone'] ); ?>
								</p>
							</div>
						</div>

						<div class="col">
							<h4 class="order-card__heading"><?php esc_html_e( 'Shipping Address', 'vendify' ); ?></h4>

							<div class="address">
								<?php
								if ( $order->get_formatted_shipping_address() ) {
									echo '<p>' . wp_kses(
										$order->get_formatted_shipping_address(),
										[
											'br' => [],
										]
									) . '</p>';
								} else {
									echo '<p class="none_set">' . esc_html__( 'No shipping address set.', 'vendify' ) . '</p>';
								}

								$address = $order->get_address(); ?>
							</div>
						</div>

					</div>
				</div>
			</div>

			<p>
				<a href="<?php echo esc_url( astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-orders' ) ); ?>" class="link link-cta text-xs has-icon">
					<?php
					svg(
						[
							'icon'    => 'long-arrow-left',
							'classes' => [ 'ico--xs mr-2' ],
						]
					);

					esc_html_e( 'Back to Orders', 'vendify' ); ?>
				</a>
			</p>

			<?php
				astoundify_wc_themes_get_template(
					'vendor-dashboard/view-order-items.php',
					[
						'order_id' => $order_id,
						'order'    => $order,
					]
				);
			?>

		</div>

		<div class="view-order__sidebar">
			<h3 class="order-updates-title"><?php _e( 'Order Updates', 'vendify' ); ?></h3>

			<?php
			astoundify_wc_themes_get_template(
				'vendor-dashboard/view-order-notes.php',
				[
					'order_id' => $order_id,
					'order'    => $order,
				]
			); ?>
		</div>
	</div>
</div>
