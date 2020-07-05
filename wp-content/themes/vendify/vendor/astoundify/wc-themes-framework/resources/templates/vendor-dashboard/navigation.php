<?php
/**
 * Vendor Dashboard Navigation
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'astoundify_wc_themes_before_vendor_dashboard_navigation' );
?>

<nav class="woocommerce-MyAccount-navigation astoundify-wc-themes-VendorDasboard-navigation">
	<ul>
		<?php foreach ( astoundify_wc_themes_vendors_get_dashboard_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo astoundify_wc_themes_get_vendors_dashboard_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( astoundify_wc_themes_vendors_get_dashboard_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'astoundify_wc_themes_after_vendor_dashboard_navigation' ); ?>
