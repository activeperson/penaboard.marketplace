<?php
/**
 * Admin Product Reporting Email Template
 *
 * Tags supported in this template.
 * - {site_title}
 * - {product_id}
 * - {product_name}
 * - {product_url}
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
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<h3><?php esc_html_e( 'Product Reported:', 'astoundify-wc-themes' ); ?></h3>

<ul>
	<li><?php esc_html_e( 'Name: {product_name} (#{product_id})', 'astoundify-wc-themes' ); ?></li>
	<li><?php esc_html_e( 'URL: {product_url}', 'astoundify-wc-themes' ); ?></li>
</ul>

<h3><?php esc_html_e( 'Reporter Details:', 'astoundify-wc-themes' ); ?></h3>

<ul>
	<li><?php esc_html_e( 'Reporter: {reporter_name} (#{reporter_id})', 'astoundify-wc-themes' ); ?></li>
	<li><?php esc_html_e( 'Email: {reporter_email}', 'astoundify-wc-themes' ); ?></li>
</ul>

<h3><?php esc_html_e( 'Report Reason: {report_reason}', 'astoundify-wc-themes' ); ?></h3>

{report_description}

<?php do_action( 'woocommerce_email_footer', $email ); ?>
