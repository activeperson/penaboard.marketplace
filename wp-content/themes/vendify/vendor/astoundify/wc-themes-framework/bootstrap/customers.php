<?php
/**
 * Customers
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category App
 * @author Astoundify
 */

// Admin.
if ( is_admin() ) {
	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'app/customers/admin/functions-edit-customer.php' );
}
