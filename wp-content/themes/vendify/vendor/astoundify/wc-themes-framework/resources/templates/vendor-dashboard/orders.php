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
}

// No order found.
if ( ! $order_query->get_total_items() ) : ?>
	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<?php esc_html_e( 'No order has been made yet.', 'astoundify-wc-themes' ); ?>
	</div>
<?php return;
endif; ?>

<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">

	<thead>
		<tr>
			<?php foreach ( astoundify_wc_themes_vendors_get_dashboard_orders_columns() as $column_id => $column_name ) : ?>
				<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
			<?php endforeach; ?>
		</tr>
	</thead>

	<tbody>
		<?php if ( ! $order_query->get_orders() ) : ?>
			<tr class="woocommerce-orders-table__row order">
				<td colspan="<?php echo absint( count( astoundify_wc_themes_vendors_get_dashboard_orders_columns() ) ); ?>">
					<?php echo esc_html_e( 'Not found', 'astoundify-wc-themes' ); ?>
				</td>
			</tr>
		<?php else : ?>
			<?php foreach( $order_query->get_orders() as $item ) : ?>
				<?php astoundify_wc_themes_get_template( 'vendor-dashboard/orders-item.php', array(
					'item'    => $item,
					'order'   => wc_get_order( $item->order_id ),
				) ); ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>

</table><!-- .astoundify-wc-themes-vendors-orders-table -->

<?php astoundify_wc_themes_get_template( 'vendor-dashboard/orders-pagination.php', array(
	'order_query' => $order_query,
) ); ?>
