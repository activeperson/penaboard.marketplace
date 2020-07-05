<?php
/**
 * WP User Avatars template hooks.
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

// Add upload template to customer edit account area.
add_action( 'woocommerce_edit_account_form_start', 'vendify_wp_user_avatars_woocommerce_edit_account_form_start' );
add_action( 'woocommerce_save_account_details', 'wp_user_avatars_edit_user_profile_update' );
add_action( 'template_redirect', 'wp_user_avatars_action_remove_avatars' );
