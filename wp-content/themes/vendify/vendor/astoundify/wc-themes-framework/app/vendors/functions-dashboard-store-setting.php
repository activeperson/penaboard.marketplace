<?php
/**
 * Vendor Dashboard Store Settings Functions
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Vendors
 * @author Astoundify
 */

/**
 * Process/Save Store Settings
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_dashboard_process_store_settings() {
	if (
		! isset( $_POST['_nonce'], $_POST['action'] ) ||
		! wp_verify_nonce( $_POST['_nonce'], 'vendor-dashboard_store-settings' ) ||
		'update_store_settings' !== $_POST['action']
	) {
		return;
	}

	$vendor_id          = WC_Product_Vendors_Utils::get_logged_in_vendor();
	$vendor_data        = WC_Product_Vendors_Utils::get_vendor_data_from_user();
	$posted_vendor_data = $_POST['vendor_data'];
	$save_pass          = true;

	if ( ! isset( $posted_vendor_data['name'] ) ) {
		return;
	}

	wp_update_term( $vendor_id, WC_PRODUCT_VENDORS_TAXONOMY, array(
		'name' => esc_attr( $posted_vendor_data['name'] ),
	) );

	update_term_meta( $vendor_id, 'vendor_name', esc_attr( $posted_vendor_data['name'] ) );

	if ( isset( $posted_vendor_data['location'] ) ) {
		update_term_meta( $vendor_id, 'vendor_location', esc_attr( $posted_vendor_data['location'] ) );
		unset( $posted_vendor_data['location'] );
	}

	if ( isset( $posted_vendor_data['profile'] ) ) {
		update_term_meta( $vendor_id, 'vendor_profile', wp_kses_post( stripslashes( $posted_vendor_data['profile'] ) ) );
		unset( $posted_vendor_data['profile'] );
	}

	if ( isset( $posted_vendor_data['tagline'] ) ) {
		update_term_meta( $vendor_id, 'vendor_tagline', wp_kses_post( stripslashes( $posted_vendor_data['tagline'] ) ) );
		unset( $posted_vendor_data['tagline'] );
	}

	if ( isset( $posted_vendor_data['shipping_policy'] ) ) {
		update_term_meta( $vendor_id, 'shipping_policy', wp_kses_post( stripslashes( $posted_vendor_data['shipping_policy'] ) ) );
		unset( $posted_vendor_data['shipping_policy'] );
	}

	if ( isset( $posted_vendor_data['return_policy'] ) ) {
		update_term_meta( $vendor_id, 'return_policy', wp_kses_post( stripslashes( $posted_vendor_data['return_policy'] ) ) );
		unset( $posted_vendor_data['return_policy'] );
	}

	$current_user = wp_get_current_user();
	$pass_cur     = ! empty( $_POST['password'] ) ? $_POST['password'] : '';
	$pass1        = ! empty( $_POST['password_1'] ) ? $_POST['password_1'] : '';
	$pass2        = ! empty( $_POST['password_2'] ) ? $_POST['password_2'] : '';

	if ( ! empty( $pass_cur ) && empty( $pass1 ) && empty( $pass2 ) ) {
		wc_add_notice( esc_html__( 'Please fill out all password fields.', 'astoundify-wc-themes' ), 'error' );
		$save_pass = false;
	} elseif ( ! empty( $pass1 ) && empty( $pass_cur ) ) {
		wc_add_notice( esc_html__( 'Please enter your current password.', 'astoundify-wc-themes' ), 'error' );
		$save_pass = false;
	} elseif ( ! empty( $pass1 ) && empty( $pass2 ) ) {
		wc_add_notice( esc_html__( 'Please re-enter your password.', 'astoundify-wc-themes' ), 'error' );
		$save_pass = false;
	} elseif ( ( ! empty( $pass1 ) || ! empty( $pass2 ) ) && $pass1 !== $pass2 ) {
		wc_add_notice( esc_html__( 'New passwords do not match.', 'astoundify-wc-themes' ), 'error' );
		$save_pass = false;
	} elseif ( ! empty( $pass1 ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {
		wc_add_notice( esc_html__( 'Your current password is incorrect.', 'astoundify-wc-themes' ), 'error' );
		$save_pass = false;
	}

	if ( $pass1 && $save_pass ) {
		wp_update_user( [
			'ID'        => get_current_user_id(),
			'user_pass' => $pass1,
		] );
	}

	$posted_vendor_data = array_map( 'sanitize_text_field', $posted_vendor_data );

	// Merge the changes with existing settings.
	$posted_vendor_data = array_merge( $vendor_data, $posted_vendor_data );

	update_term_meta( $vendor_id, 'vendor_data', $posted_vendor_data );

	if ( $save_pass ) {
		wc_add_notice( esc_html__( 'Settings updated.', 'astoundify-wc-themes' ), 'success' );
	}

	wp_safe_redirect( esc_url_raw( astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-store-settings' ) ) );
	exit;
}
add_action( 'template_redirect', 'astoundify_wc_themes_vendors_dashboard_process_store_settings' );
