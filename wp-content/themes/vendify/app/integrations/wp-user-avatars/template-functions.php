<?php
/**
 * WP User Avatars template functions.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Prepend avatar upload template to WooCommerce Edit Account form.
 *
 * @since 1.0.0
 */
function vendify_wp_user_avatars_woocommerce_edit_account_form_start() {
	wc_get_template( 'myaccount/form-edit-account-avatar.php' );
}
