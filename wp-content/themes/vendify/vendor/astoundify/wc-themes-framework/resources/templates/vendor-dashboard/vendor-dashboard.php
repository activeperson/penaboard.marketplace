<?php
/**
 * Vendor Dashboard Page
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

wc_print_notices();

/**
 * Vendor Dashboard Navigation.
 *
 * @since 1.0.0
 */
do_action( 'astoundify_wc_themes_vendors_dashboard_navigation' ); ?>

<div class="woocommerce-MyAccount-content astoundify-wc-themes-VendorDashboard-content">
	<?php
		/**
		 * Vendor Dashboard Content
		 *
		 * @since 1.0.0
		 */
		do_action( 'astoundify_wc_themes_vendors_dashboard_content' );
	?>
</div>
