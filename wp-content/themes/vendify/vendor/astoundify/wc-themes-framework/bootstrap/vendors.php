<?php
/**
 * Vendors
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category App
 * @author Astoundify
 */

require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/vendors/functions-setup.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/vendors/functions-dashboard.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/vendors/functions-dashboard-orders.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/vendors/functions-dashboard-store-setting.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/vendors/functions-dashboard-overview.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/vendors/functions-dashboard-activities.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/vendors/functions-dashboard-products.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/vendors/functions-archive.php' );

// Admin.
if ( is_admin() ) {
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/vendors/admin/functions-dashboard-settings.php' );
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/vendors/admin/functions-edit-vendor.php' );
}

// Integrations.
if ( defined( 'ASTOUNDIFY_FAVORITES_VERSION' ) && ASTOUNDIFY_FAVORITES_VERSION ) {
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/vendors/integrations/astoundify-favorites/functions-favorites.php' );
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/vendors/integrations/astoundify-favorites/functions-favorites-activity.php' );
}
