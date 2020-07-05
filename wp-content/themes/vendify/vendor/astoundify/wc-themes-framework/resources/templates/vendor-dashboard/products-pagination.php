<?php
/**
 * PRoducts Pagination
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var array $product_query  Array of WC_Product Object.
 * @var int   $paged          Current Page.
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
// Bail if pagination not needed.
if ( $product_query->max_num_pages < 2 ) {
	return;
}

// Get pages.
$pages = range( 1, $product_query->max_num_pages ); ?>
<nav class="woocommerce-pagination" role="navigation">
	<?php
	foreach ( $pages as $page ) {
		if ( absint( $page ) === absint( $paged ) ) { ?>
			<span class="page-number current"><?php echo absint( $page ); ?></span>
		<?php } else { ?>
			<a class="page-number"
			   href="<?php echo esc_url( astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-products', $page ) ); ?>"><?php echo absint( $page ); ?></a>
		<?php }
	} ?>
</nav><!-- .wp-link-pages.vendor-dashboard-pagination -->
