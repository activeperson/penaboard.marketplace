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
?>

<div class="row">
	<div class="col-lg-10 mr-auto ml-auto">

		<?php wc_print_notices(); ?>

		<h3 class="dashboard__subheading"><?php esc_html_e( 'My Products', 'vendify' ); ?></h3>

		<?php if ( ! $product_query->products ) : ?>
			<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
				<?php esc_html_e( 'You have no products yet.', 'vendify' ); ?>
			</div>
			<?php
		else :
			add_filter(
				'option_woocommerce_catalog_columns',
				function() {
					return 3;
				}
			);

			woocommerce_product_loop_start();

			foreach ( $product_query->products as $product ) :
				astoundify_wc_themes_get_template(
					'vendor-dashboard/products-item.php',
					[
						'product' => $product,
					]
				);
			endforeach;

			woocommerce_product_loop_end();

			astoundify_wc_themes_get_template(
				'vendor-dashboard/products-pagination.php',
				[
					'product_query' => $product_query,
					'paged'         => $paged,
				]
			);
		endif;
		?>

	</div>
</div>
