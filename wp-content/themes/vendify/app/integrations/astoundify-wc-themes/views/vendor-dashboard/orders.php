<?php
/**
 * Orders
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var array $order_query
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="row">
	<div class="col-md-11 col-lg-8 col-xl-7 ml-sm-auto mr-sm-auto dashboard__settings">

		<?php wc_print_notices(); ?>

		<h3 class="dashboard__subheading"><?php esc_html_e( 'Manage Orders', 'vendify' ); ?></h3>

		<?php if ( ! $order_query->get_total_items() ) { ?>
			<div
				class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
				<?php esc_html_e( 'No orders have been made yet.', 'vendify' ); ?>
			</div>
			<?php return;
		} ?>

		<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table table table--history">

			<thead>
				<tr>
					<?php foreach ( astoundify_wc_themes_vendors_get_dashboard_orders_columns() as $column_id => $column_name ) { ?>
						<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
					<?php } ?>
				</tr>
			</thead>

			<tbody>
				<?php if ( ! $order_query->get_orders() ) { ?>
					<tr class="woocommerce-orders-table__row order">
						<td colspan="<?php echo absint( count( astoundify_wc_themes_vendors_get_dashboard_orders_columns() ) ); ?>">
							<?php esc_html_e( 'Not found', 'vendify' ); ?>
						</td>
					</tr>
				<?php } else {
					foreach ( $order_query->get_orders() as $item ) {
						astoundify_wc_themes_get_template(
							'vendor-dashboard/orders-item.php',
							[
								'item'  => $item,
								'order' => wc_get_order( $item->order_id ),
							]
						);
					}
				} ?>
			</tbody>

		</table><!-- .astoundify-wc-themes-vendors-orders-table -->

		<?php
		astoundify_wc_themes_get_template(
			'vendor-dashboard/orders-pagination.php',
			[
				'order_query' => $order_query,
			]
		); ?>

	</div>
</div>
