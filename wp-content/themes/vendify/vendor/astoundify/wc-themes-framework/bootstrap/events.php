<?php
/**
 * Events
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category App
 * @author Astoundify
 */

require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/functions-setup.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/functions-product.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/functions-location.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/functions-schedule.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/functions-attendees.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/functions-lineup.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/functions-sponsors.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/functions-filters.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/functions-archive-page.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/functions-permalink.php' );
require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/functions-external.php' );

// WC Box Office.
if ( function_exists( 'WCBO' ) ) {
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/functions-woocommerce-box-office.php' );
}

if ( is_admin() ) {
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/admin/functions.php' );
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/admin/functions-settings.php' );
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/admin/functions-location.php' );
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/admin/functions-schedule.php' );
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/admin/functions-attendees.php' );
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/admin/functions-lineup.php' );
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/admin/functions-sponsors.php' );
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/events/admin/functions-external.php' );
}
