<?php
/**
 * Orders Item
 *
 * Shows the first intro screen on the account dashboard.
 * For Sales Summary, Links, etc.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var array  $item
 * @var object $order
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! $order ) :
	return;
endif;
?>

<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order">

	<?php foreach ( astoundify_wc_themes_vendors_get_dashboard_orders_columns() as $column_id => $column_name ) : ?>

		<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">

			<?php if ( has_action( 'astoundify_wc_themes_vendors_orders_column_' . $column_id ) ) : ?>
				<?php do_action( 'astoundify_wc_themes_vendors_orders_column_' . $column_id, $item, $order ); ?>
			<?php endif; ?>

		</td>

	<?php endforeach; ?>

</tr>
