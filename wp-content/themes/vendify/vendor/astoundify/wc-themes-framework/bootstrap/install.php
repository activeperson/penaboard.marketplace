<?php
/**
 * Installer. Create custom database tables, roles, etc.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Bootstrap
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle install.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_install() {
	astoundify_wc_themes_install_database();
}

/**
 * Create custom schema.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_install_database() {
	global $wpdb;

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "
		CREATE TABLE {$wpdb->prefix}wc_product_locations (
			id int(11) unsigned NOT NULL AUTO_INCREMENT,
			product_id int(11) NOT NULL,
			place_id int(11) NOT NULL,
			address_1 varchar(255) NOT NULL DEFAULT '',
			address_2 varchar(255) NOT NULL DEFAULT '',
			city varchar(255) NOT NULL DEFAULT '',
			state varchar(255) NOT NULL DEFAULT '',
			postcode varchar(255) NOT NULL DEFAULT '',
			country varchar(255) NOT NULL DEFAULT '',
			latitude varchar(255) NOT NULL DEFAULT '',
			longitude varchar(255) NOT NULL DEFAULT '',
			formatted varchar(255) NOT NULL DEFAULT '',
			input varchar(255) NOT NULL DEFAULT '',
			raw longtext NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;
	";

	dbDelta( $sql );
}
