<?php
/**
 * Products Item
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var WC_Product $product Product Object.
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<tr class="woocommerce-orders-table__row">

	<?php foreach ( astoundify_wc_themes_vendors_get_dashboard_products_columns() as $column_id => $column_name ) : ?>

		<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">

			<?php if ( has_action( 'astoundify_wc_themes_vendors_products_column_' . $column_id ) ) : ?>
				<?php do_action( 'astoundify_wc_themes_vendors_products_column_' . $column_id, $product ); ?>
			<?php endif; ?>

		</td>

	<?php endforeach; ?>

</tr>
