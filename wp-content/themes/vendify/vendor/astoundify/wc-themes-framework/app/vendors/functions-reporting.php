<?php
/**
 * Reporting Functions.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Events
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Email Class
 *
 * @since 1.0.0
 *
 * @param array $emails Emails.
 * @return array
 */
function astoundify_wc_themes_vendors_add_email_reporting_classes( $emails ) {
	$emails['Astoundify_WC_Themes_Vendors_Product_Email_Reporting'] = include( 'class-product-email-reporting.php' );
	$emails['Astoundify_WC_Themes_Vendors_Product_Email_Reporting_Vendor'] = include( 'class-product-email-reporting-vendor.php' );
	return $emails;
}
add_action( 'woocommerce_email_classes', 'astoundify_wc_themes_vendors_add_email_reporting_classes' );

/**
 * Is reporting enabled.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function astoundify_wc_themes_vendors_is_email_reporting_active() {
	$admin_email = get_option( 'woocommerce_astoundify_wc_themes_vendors_product_email_reporting_enabled', true );
	$vendor_email = get_option( 'woocommerce_astoundify_wc_themes_vendors_product_email_reporting_vendor_enabled', true );
	return apply_filters( 'astoundify_wc_themes_vendors_is_email_reporting_active', ( $admin_email || $vendor_email ) ? true : false );
}

/**
 * Reporting Reasons
 *
 * @since 1.0.0
 *
 * @return array
 */
function astoundify_wc_themes_vendors_get_reporting_reasons() {
	$reasons = array(
		'scam'      => esc_html__( 'Scam', 'astoundify-wc-themes' ),
		'explicit'  => esc_html__( 'Sexually Explicit', 'astoundify-wc-themes' ),
		'offensive' => esc_html__( 'Abusive/Offensive', 'astoundify-wc-themes' ),
		'other'     => esc_html__( 'Other', 'astoundify-wc-themes' ),
	);
	return apply_filters( 'astoundify_wc_themes_vendors_reporting_reasons', $reasons );
}

/**
 * Add Report Tab
 *
 * @since 1.0.0
 *
 * @param array $tabs Product Tabs.
 * @return array
 */
function astoundify_wc_themes_vendors_add_reporting_tab( $tabs ) {
	global $product, $post;

	// Only for vendor product.
	$product_vendor_id = WC_Product_Vendors_Utils::get_vendor_id_from_product( $product->get_id() );
	if ( ! $product_vendor_id ) {
		return $tabs;
	}

	// Do not display report tabs if current user is a vendor for the product.
	$user_vendor_id = WC_Product_Vendors_Utils::get_logged_in_vendor();
	if ( $user_vendor_id && $user_vendor_id === $product_vendor_id ) {
		return $tabs;
	}

	// Bail if no email set.
	if ( ! astoundify_wc_themes_vendors_is_email_reporting_active() ) {
		return $tabs;
	}

	$tabs['reporting'] = array(
		'title'    => esc_html__( 'Report Product', 'astoundify-wc-themes' ),
		'priority' => 99,
		'callback' => function() use ( $product ) {
			astoundify_wc_themes_get_template( 'product-tabs/reporting.php', array(
				'product' => $product,
				'reasons' => astoundify_wc_themes_vendors_get_reporting_reasons(),
			) );
		},
	);

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'astoundify_wc_themes_vendors_add_reporting_tab' );

/**
 * Trigger Send Email
 *
 * @since 1.0.0
 *
 * @param int $product_id     Product ID.
 * @param string $reason      Report Reason.
 * @param string $description Report Description.
 */
function astoundify_wc_themes_vendors_send_report_email( $product_id, $reason, $description ) {
	$mailer = WC()->mailer();
	do_action( 'astoundify_wc_themes_vendors_product_reporting_send_email', $product_id, $reason, $description );
}

/**
 * Process Reporting Submission
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_process_submit_reporting() {
	if ( ! isset( $_POST['product_id'], $_POST['action'], $_POST['_nonce'], $_POST['reason'], $_POST['description'] ) || ! wp_verify_nonce( $_POST['_nonce'], 'astoundify-wc-themes-vendors-product-reporting' ) ) {
		return;
	}

	// Check/validate reason.
	$valid_reasons = astoundify_wc_themes_vendors_get_reporting_reasons();
	if ( ! $_POST['reason'] || ! array_key_exists( $_POST['reason'], $valid_reasons ) ) {
		return;
	}

	// Only for vendor product.
	if ( ! WC_Product_Vendors_Utils::is_vendor_product( $_POST['product_id'] ) ) {
		return;
	}

	// Get product object.
	$product = wc_get_product( $_POST['product_id'] );
	if ( ! $product || ! is_user_logged_in() ) {
		return;
	}

	// Return URL.
	$url = $product->get_permalink();

	// Submit email trigger.
	astoundify_wc_themes_vendors_send_report_email( $_POST['product_id'], $_POST['reason'], $_POST['description'] );

	// Success notice.
	wc_add_notice( esc_html__( 'Thank you for your report.', 'astoundify-wc-themes' ), 'success' );

	// Redirect back for cleaner post.
	wp_safe_redirect( esc_url_raw( $url ) );
	exit;
}
add_action( 'template_redirect', 'astoundify_wc_themes_vendors_process_submit_reporting' );
