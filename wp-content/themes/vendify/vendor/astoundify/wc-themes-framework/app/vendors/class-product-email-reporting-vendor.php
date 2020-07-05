<?php
/**
 * Email Reporting Class (Vendor).
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Vendors
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Astoundify_WC_Themes_Vendors_Product_Email_Reporting_Vendor', false ) ) :

/**
 * Product Reporting Email (Vendor).
 */
class Astoundify_WC_Themes_Vendors_Product_Email_Reporting_Vendor extends WC_Email {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->id             = 'astoundify_wc_themes_vendors_product_email_reporting_vendor';
		$this->title          = esc_html__( 'Vendor Product Reporting (Vendor)', 'astoundify-wc-themes' );
		$this->description    = esc_html__( "Vendor Product Reporting Email for product's vendor.", 'astoundify-wc-themes' );
		$this->template_base  = ASTOUNDIFY_WC_THEMES_TEMPLATE_PATH;
		$this->template_html  = 'emails/vendor-product-reporting.php';
		$this->template_plain = 'emails/plain/vendor-product-reporting.php';
		$this->placeholders   = array(
			'{site_title}'         => $this->get_blogname(),
			'{product_id}'         => '',
			'{product_name}'       => '',
			'{product_url}'        => '',
			'{reporter_id}'        => '',
			'{reporter_name}'      => '',
			'{reporter_email}'     => '',
			'{report_reason}'      => '',
			'{report_description}' => '',
		);

		// Triggers for this email
		add_action( 'astoundify_wc_themes_vendors_product_reporting_send_email', array( $this, 'trigger' ), 10, 3 );

		// Call parent constructor
		parent::__construct();
	}

	/**
	 * Get email subject.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_default_subject() {
		return esc_html__( '[{site_title}] {report_reason} Product Report: ({product_name})', 'astoundify-wc-themes' );
	}

	/**
	 * Get email heading.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_default_heading() {
		return esc_html__( 'Product Report', 'astoundify-wc-themes' );
	}

	/**
	 * Trigger the sending of this email.
	 *
	 * @param int $product_id  Product ID.
	 * @param int $reason_key  Report reason.
	 * @param int $description Report description.
	 */
	public function trigger( $product_id, $reason_key, $description ) {

		// If enabled and recipient is set.
		if ( $this->is_enabled() ) {

			// Check/validate reason.
			$valid_reasons = astoundify_wc_themes_vendors_get_reporting_reasons();
			if ( ! $reason_key || ! array_key_exists( $reason_key, $valid_reasons ) ) {
				return;
			}

			// Reporter is always current user.
			$reporter = wp_get_current_user();
			if ( ! $reporter->ID ) { // Not logged-in.
				return;
			}

			// Get product object.
			$product = wc_get_product( $product_id );
			if ( ! $product ) {
				return;
			}

			// Get vendor ID.
			$vendor_id = WC_Product_Vendors_Utils::get_vendor_id_from_product( $product_id );
			if ( ! $vendor_id ) {
				return;
			}
			$vendor_data = WC_Product_Vendors_Utils::get_vendor_data_by_id( $vendor_id );
			if ( ! $vendor_data['email'] ) {
				return;
			}

			// Set placeholder.
			$this->placeholders['{product_id}'] = $product->get_id();
			$this->placeholders['{product_name}'] = $product->get_name();
			$this->placeholders['{product_url}'] = $product->get_permalink();
			$this->placeholders['{reporter_id}'] = $reporter->ID;
			$this->placeholders['{reporter_name}'] = $reporter->display_name;
			$this->placeholders['{reporter_email}'] = $reporter->user_email;
			$this->placeholders['{report_reason}'] = strip_tags( esc_attr( $valid_reasons[ $reason_key ] ) );
			$this->placeholders['{report_description}'] = $description ? wp_kses_post( wpautop( $description ) ) : wpautop( esc_html__( 'No description', 'astoundify-wc-themes' ) );

			// Send.
			$this->send( $vendor_data['email'], $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
		}
	}

	/**
	 * Get content html.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_content_html() {
		ob_start();
		astoundify_wc_themes_get_template( $this->template_html, array(
			'email_heading' => $this->get_heading(),
			'sent_to_admin' => true,
			'plain_text'    => false,
			'email'         => $this,
		) );
		return $this->format_string( ob_get_clean() );
	}

	/**
	 * Get content plain.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_content_plain() {
		ob_start();
		astoundify_wc_themes_get_template( $this->template_plain, array(
			'email_heading' => $this->get_heading(),
			'sent_to_admin' => true,
			'plain_text'    => true,
			'email'         => $this,
		) );
		return $this->format_string( ob_get_clean() );
	}

	/**
	 * Initialise settings form fields.
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'enabled' => array(
				'title'         => __( 'Enable/Disable', 'astoundify-wc-themes' ),
				'type'          => 'checkbox',
				'label'         => __( 'Enable this email notification', 'astoundify-wc-themes' ),
				'default'       => 'yes',
			),
			'subject' => array(
				'title'         => __( 'Subject', 'astoundify-wc-themes' ),
				'type'          => 'text',
				'desc_tip'      => true,
				/* translators: %s: list of placeholders */
				'description'   => sprintf( __( 'Available placeholders: %s', 'astoundify-wc-themes' ), '<code>{site_title}, {product_id}, {product_name}, {vendor_id}, {vendor_name), {reporter_id}, {reporter_name}, {$reporter_email}, {report_reason}</code>' ),
				'placeholder'   => $this->get_default_subject(),
				'default'       => '',
			),
			'heading' => array(
				'title'         => __( 'Email heading', 'astoundify-wc-themes' ),
				'type'          => 'text',
				'desc_tip'      => true,
				/* translators: %s: list of placeholders */
				'description'   => sprintf( __( 'Available placeholders: %s', 'astoundify-wc-themes' ), '<code>{site_title}, {product_id}, {product_name}, {vendor_id}, {vendor_name), {vendor_url}, {vendor_email}, {reporter_id}, {reporter_name}, {$reporter_email}, {report_reason}, {report_decription}</code>' ),
				'placeholder'   => $this->get_default_heading(),
				'default'       => '',
			),
			'email_type' => array(
				'title'         => __( 'Email type', 'astoundify-wc-themes' ),
				'type'          => 'select',
				'description'   => __( 'Choose which format of email to send.', 'astoundify-wc-themes' ),
				'default'       => 'html',
				'class'         => 'email_type wc-enhanced-select',
				'options'       => $this->get_email_type_options(),
				'desc_tip'      => true,
			),
		);
	}

}

endif;

return new Astoundify_WC_Themes_Vendors_Product_Email_Reporting_Vendor();
