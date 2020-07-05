<?php
/**
 * Admin Product Reporting Email Template (Plain Text)
 *
 * Tags supported in this template.
 * - {site_title}
 * - {product_id}
 * - {product_name}
 * - {product_url}
 * - {vendor_id}
 * - {vendor_name}
 * - {vendor_email}
 * - {vendor_url}
 * - {reporter_id}
 * - {reporter_name}
 * - {reporter_email}
 * - {report_reason}
 * - {report_description}
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var string   $email_heading Email heading.
 * @var bool     $sent_to_admin Sent to Admin.
 * @var bool     $plain_text    True if it's a plain text email.
 * @var WC_Email $email         WC_Email object.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo "= " . $email_heading . " =\n\n";

echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo esc_html__( 'Product Reported:', 'astoundify-wc-themes' ) . "\n\n";
echo '- ' . esc_html__( 'Name: {product_name} (#{product_id})', 'astoundify-wc-themes' ) . "\n";
echo '- ' . esc_html__( 'URL: {product_url}', 'astoundify-wc-themes' ) . "\n";

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo esc_html__( 'Sold By:', 'astoundify-wc-themes' ) . "\n\n";
echo '- ' . esc_html__( 'Vendor: {vendor_name} (#{vendor_id})', 'astoundify-wc-themes' ) . "\n";
echo '- ' . esc_html__( 'Email: {vendor_email}', 'astoundify-wc-themes' ) . "\n";
echo '- ' . esc_html__( 'URL: {vendor_url}', 'astoundify-wc-themes' ) . "\n";

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo esc_html__( 'Reporter Details:', 'astoundify-wc-themes' ) . "\n\n";
echo '- ' . esc_html__( 'Reporter: {reporter_name} (#{reporter_id})', 'astoundify-wc-themes' ) . "\n";
echo '- ' . esc_html__( 'Email: {reporter_email}', 'astoundify-wc-themes' ) . "\n";

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo esc_html__( 'Report Reason: {report_reason}', 'astoundify-wc-themes' ) . "\n\n";
echo '{report_description}' . "\n\n";

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
