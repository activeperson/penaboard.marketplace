<?php
/**
 * View Order Items Section
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
} ?>

<div id="vendors-order-items" class="vendors-order-section">
	<h3 class="screen-reader-text"><?php esc_html_e( 'Order Items', 'vendify' ); ?></h3>

	<?php
	$order_query = new \Astoundify\WC_Themes\Vendors\Order_Query(
		[
			'limit'    => -1,
			'order_id' => $order_id,
		]
	); ?>

	<?php if ( ! $order_query->get_orders() ) : ?>
	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<?php esc_html_e( 'No order has been made yet.', 'vendify' ); ?>
	</div>
	<?php endif; ?>

	<table class="astoundify-wc-themes-vendors-orders-table woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table table table--history">

		<thead>
			<tr>
				<?php foreach ( astoundify_wc_themes_vendors_get_dashboard_order_items_columns() as $column_id => $column_name ) : ?>
					<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<?php foreach ( $order_query->get_orders() as $item ) : ?>

				<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order">

					<?php foreach ( astoundify_wc_themes_vendors_get_dashboard_order_items_columns() as $column_id => $column_name ) : ?>

						<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">

							<?php if ( has_action( 'astoundify_wc_themes_vendors_orders_column_' . $column_id ) ) : ?>
								<?php do_action( 'astoundify_wc_themes_vendors_orders_column_' . $column_id, $item, $order ); ?>
							<?php endif; ?>

						</td>

					<?php endforeach; ?>

				</tr>

			<?php endforeach; ?>
		</tbody>

	</table>

</div><!-- #vendors-order-items.vendors-order-section -->
