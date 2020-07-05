<?php
/**
 * Themeforest updater.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Setup
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use Astoundify_Envato_Market_API;
use Astoundify_ThemeForest_Updater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$library = get_template_directory() . '/vendor/astoundify/themeforest-updater';

// Quit early if therer is no library.
if ( ! file_exists( $library . '/app/class-astoundify-themeforest-updater.php' ) ) {
	return;
}

// Load library.
include_once $library . '/app/class-astoundify-themeforest-updater.php';
include_once $library . '/app/class-envato-market-api.php';

/**
 * Ajax callback for setting the token.
 *
 * @see https://github.com/Astoundify/wp-themeforest-updater
 *
 * @since 1.0.0
 */
function themeforest_updater_set_token() {
	check_ajax_referer( 'astoundify-add-token', 'security' );

	$token = isset( $_POST['token'] ) ? esc_attr( $_POST['token'] ) : false;
	$api   = Astoundify_Envato_Market_API::instance();

	update_option( '_vendify_themeforest_updater_token', $token );
	delete_transient( 'atu_can_make_request' );

	// Hotswap the token.
	$api->token = $token;

	wp_send_json_success(
		array(
			'token'          => $token,
			'can_request'    => $api->can_make_request_with_token(),
			'valid_purchase' => $api->is_valid_purchase( '23702564' ),
			'request_label'  => $api->connection_status_label(),
		)
	);

	exit();
}
add_action( 'wp_ajax_astoundify_updater_set_token', 'Astoundify\Vendify\themeforest_updater_set_token' );


/**
 * Ajax callback for deleting the token.
 *
 * @see https://github.com/Astoundify/wp-themeforest-updater
 *
 * @since 1.0.0
 */
function themeforest_updater_remove_token() {
	check_ajax_referer( 'astoundify-remove-token', 'security' );

	$api   = Astoundify_Envato_Market_API::instance();

	delete_option( '_vendify_themeforest_updater_token' );
	delete_transient( 'atu_can_make_request' );

	$api->token = null;

	exit();
}
add_action( 'wp_ajax_astoundify_updater_remove_token', 'Astoundify\Vendify\themeforest_updater_remove_token' );

/**
 * Hook into the wp-themeforest-updater and set the token.
 *
 * @see https://github.com/Astoundify/wp-themeforest-updater
 *
 * @since 1.0.0
 */
function themeforest_updater_get_token() {
	return get_option( '_vendify_themeforest_updater_token', null );
}
add_filter( 'astoundify_themeforest_updater', 'Astoundify\Vendify\themeforest_updater_get_token' );

/**
 * Load Astoundify Themeforest Updater
 *
 * @see https://github.com/Astoundify/wp-themeforest-updater
 *
 * @since 1.0.0
 */
function themeforest_updater() {
	$updater = Astoundify_ThemeForest_Updater::instance();

	// Set strings
	call_user_func_array(
		array( $updater, 'set_strings' ),
		array(
			'cheating'         => esc_html__( 'Cheating?', 'vendify' ),
			'no-token'         => esc_html__( 'An API token is required.', 'vendify' ),
			'api-error'        => esc_html__( 'API error.', 'vendify' ),
			'api-connected'    => esc_html__( 'Connected', 'vendify' ),
			'api-disconnected' => esc_html__( 'Disconnected', 'vendify' ),
		)
	);
}
add_action( 'admin_init', 'Astoundify\Vendify\themeforest_updater', 5 );

/**
 * Checks the purchase status.
 *
 * @see https://github.com/Astoundify/wp-themeforest-updater
 *
 * @since 1.0.0
 */
function is_valid_purchase( $allow = false ) {
	$api = Astoundify_Envato_Market_API::instance();
	return $api->is_valid_purchase( '23702564' );
}
add_filter( 'astoundify_ci_allow_import', 'Astoundify\Vendify\is_valid_purchase' );
