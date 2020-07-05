<?php
/**
 * New user guide.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Bootstrap
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$nux = [
	'setup-guide',
	'plugin-installer',
	'content-importer',
	'themeforest-updater',
];

foreach ( $nux as $file ) {
	require_once get_parent_theme_file_path( '/app/nux/' . $file . '.php' );
}
