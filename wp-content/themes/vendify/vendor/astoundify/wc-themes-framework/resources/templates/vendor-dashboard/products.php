<?php
/**
 * Products
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var array $product_query Array of WC_Product Object.
 * @var int   $paged         Current Page.
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// No product found.
if ( ! $product_query->products ) : ?>
	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<?php esc_html_e( 'You have no product yet.', 'astoundify-wc-themes' ); ?>
	</div>
<?php return;
endif; ?>

<table class="astoundify-wc-themes-vendors-products-table woocommerce-products-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">

	<thead>
		<tr>
			<?php foreach ( astoundify_wc_themes_vendors_get_dashboard_products_columns() as $column_id => $column_name ) : ?>
				<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
			<?php endforeach; ?>
		</tr>
	</thead>

	<tbody>
		<?php foreach( $product_query->products as $product ) : ?>
			<?php astoundify_wc_themes_get_template( 'vendor-dashboard/products-item.php', array(
				'product' => $product,
			) ); ?>
		<?php endforeach; ?>
	</tbody>

</table><!-- .astoundify-wc-themes-vendors-products-table -->

<?php astoundify_wc_themes_get_template( 'vendor-dashboard/products-pagination.php', array(
	'product_query' => $product_query,
	'paged'         => $paged,
) ); ?>
