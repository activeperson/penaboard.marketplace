<?php
/**
 * Orders Pagination
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
// Bail if pagination not needed.
if ( $order_query->get_total_pages() < 2 ) {
	return;
} ?>
<nav class="woocommerce-pagination" role="navigation">
	<?php
	foreach ( $order_query->get_pages() as $page ) {
		if ( absint( $page ) === absint( $order_query->get_current_page() ) ) { ?>
			<span class="page-number current"><?php echo absint( $page ); ?></span>
		<?php } else { ?>
			<a class="page-number"
			   href="<?php echo esc_url( astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-orders', $page ) ); ?>"><?php echo absint( $page ); ?></a>
		<?php }
	} ?>
</nav><!-- .wp-link-pages.vendor-dashboard-pagination -->
