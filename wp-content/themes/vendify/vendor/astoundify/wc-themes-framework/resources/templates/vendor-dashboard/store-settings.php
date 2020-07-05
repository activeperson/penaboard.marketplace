<?php
/**
 * Store Settings
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var int    $logo              Attachment ID.
 * @var int    $logo_url          Attachment Image URL.
 * @var string $profile           Profile.
 * @var string $email             Email.
 * @var string $paypal            Paypal email.
 * @var int    $vendor_commission Commision.
 * @var string $timezone          Timezone string.
 * @var array  $contact_methods   All contact methods. Each data loaded via var "contact_method_{$method}".
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<form class="vendor-store-settings" method="POST">

	<div class="vendor-store-settings-logo-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<p>
			<label><?php esc_html_e( 'Store Logo', 'astoundify-wc-themes' ); ?></label>
		</p>

		<div class="vendors-upload-field">
			<p>
				<a href="#" class="vendors-upload-button button" data-title="<?php esc_attr_e( 'Upload Logo', 'astoundify-wc-themes' ); ?>" data-insert="<?php esc_attr_e( 'Add logo', 'astoundify-wc-themes' ); ?>"><?php esc_html_e( 'Upload Logo', 'astoundify-wc-themes' ); ?></a>
			</p>

			<input type="hidden" class="vendors-upload-id" name="vendor_data[logo]" value="<?php echo absint( $logo ); ?>">

			<img class="vendors-upload-thumbnail" src="<?php echo esc_url( $logo_url ); ?>" width="150" height="150" <?php echo ( ! empty( $logo_url ) ) ? '' : ' style="display:none;"'; ?>>

			<a href="#" class="vendors-upload-remove dashicons dashicons-no" <?php echo ( ! empty( $logo_url ) ) ? '' : ' style="display:none;"'; ?> title="<?php esc_attr_e( 'Click to remove image', 'astoundify-wc-themes' ); ?>"></a>
		</div>
	</div>

	<div class="vendor-store-settings-logo-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<p>
			<label><?php esc_html_e( 'Cover Image', 'astoundify-wc-themes' ); ?></label>
		</p>

		<div class="vendors-upload-field">
			<p>
				<a href="#" class="vendors-upload-button button" data-title="<?php esc_attr_e( 'Upload Cover Image', 'astoundify-wc-themes' ); ?>" data-insert="<?php esc_attr_e( 'Add cover image', 'astoundify-wc-themes' ); ?>"><?php esc_html_e( 'Upload Cover Image', 'astoundify-wc-themes' ); ?></a>
			</p>

			<input type="hidden" class="vendors-upload-id" name="vendor_data[cover]" value="<?php echo absint( $cover ); ?>">

			<img class="vendors-upload-thumbnail" src="<?php echo esc_url( $cover_image ); ?>" width="150" height="150" <?php echo ( ! empty( $cover_image ) ) ? '' : ' style="display:none;"'; ?>>

			<a href="#" class="vendors-upload-remove dashicons dashicons-no" <?php echo ( ! empty( $cover_image ) ) ? '' : ' style="display:none;"'; ?> title="<?php esc_attr_e( 'Click to remove image', 'astoundify-wc-themes' ); ?>"></a>
		</div>
	</div>

	<div class="vendor-store-settings-tagline-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<p>
			<label for="vendor_data_tagline_field"><?php esc_html_e( 'Store Tagline', 'astoundify-wc-themes' ); ?></label>
			<input id="vendor_data_tagline_field" type="tagline" name="vendor_data[tagline]" value="<?php echo esc_attr( $vendor_tagline ); ?>">
		</p>
	</div>

	<div class="vendor-store-settings-profile-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<p>
			<label for="vendor_data_profile_field"><?php esc_html_e( 'Store Description', 'astoundify-wc-themes' ); ?></label>
		</p>
		<?php
		$args = array(
			'textarea_name' => 'vendor_data[profile]',
			'textarea_rows' => 5,
		);
		wp_editor( wp_specialchars_decode( $vendor_profile ), 'wcpv_vendor_info', $args );
		?>
	</div>

	<?php if ( 'virtual' !== get_option( 'woocommerce_product_type' ) ) : ?>
	<div class="vendor-store-settings-profile-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<p>
			<label for="vendor_data_profile_field"><?php esc_html_e( 'Store Shipping Policy', 'astoundify-wc-themes' ); ?></label>
		</p>
		<?php
		$args = array(
			'textarea_name' => 'vendor_data[shipping_policy]',
			'textarea_rows' => 3,
		);
		wp_editor( wp_specialchars_decode( $shipping_policy ), 'wcpv_vendor_shipping_policy', $args );
		?>
	</div>

	<div class="vendor-store-settings-profile-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<p>
			<label for="vendor_data_profile_field"><?php esc_html_e( 'Store Return Policy', 'astoundify-wc-themes' ); ?></label>
		</p>
		<?php
		$args = array(
			'textarea_name' => 'vendor_data[return_policy]',
			'textarea_rows' => 3,
		);
		wp_editor( wp_specialchars_decode( $return_policy ), 'wcpv_vendor_return_policy', $args ); ?>
	</div>
	<?php endif; ?>

	<div class="vendor-store-settings-location-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<p>
			<label for="vendor_data_location_field"><?php esc_html_e( 'Store Location', 'astoundify-wc-themes' ); ?></label>
			<input id="vendor_data_location_field" type="location" name="vendor_data[location]" value="<?php echo esc_attr( $vendor_location ); ?>">
		</p>
	</div>

	<div class="vendor-store-settings-email-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<p>
			<label for="vendor_data_email_field"><?php esc_html_e( 'Contact Email', 'astoundify-wc-themes' ); ?></label>
			<input id="vendor_data_email_field" type="email" name="vendor_data[email]" value="<?php echo esc_attr( $email ); ?>">
		</p>
	</div>

	<?php foreach ( $contact_methods as $method_id => $method_label ) : // Contact methods. ?>

		<div class="vendor-store-settings-<?php echo esc_attr( $method_id ); ?>-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<p>
				<label for="vendor_data_<?php echo esc_attr( $method_id ); ?>_field"><?php /* translators: %s is contact method label. */ printf( esc_html__( "Vendor's %s", 'astoundify-wc-themes' ), $method_label ); ?></label>
				<input id="vendor_data_<?php echo esc_attr( $method_id ); ?>_field" type="text" name="vendor_data[contact_method_<?php echo esc_attr( $method_id ); ?>]" value="<?php echo esc_attr( ${ "contact_method_{$method_id}" } ); ?>">
			</p>
		</div>

	<?php endforeach; ?>

	<div class="vendor-store-settings-paypal-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<p>
			<label for="vendor_data_paypal_field"><?php esc_html_e( 'Paypal Email', 'astoundify-wc-themes' ); ?></label>
			<input id="vendor_data_paypal_field" type="email" name="vendor_data[paypal]" value="<?php echo esc_attr( $paypal ); ?>">
		</p>
	</div>

	<div class="vendor-store-settings-commission-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<p>
			<label for="vendor_data_timezone_field"><?php esc_html_e( 'Timezone', 'astoundify-wc-themes' ); ?></label>
			<select id="vendor_data_timezone_field" name="vendor_data[timezone]" aria-describedby="timezone-description" class="wc-enhanced-select">
				<?php echo wp_timezone_choice( $timezone ); ?>
			</select>
		</p>
	</div>

	<div class="vendor-store-settings-paypal-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<p>
			<label for="vendor_data_password"><?php esc_html_e( 'Current Password', 'astoundify-wc-themes' ); ?></label>
			<input id="vendor_data_password_field" type="password" name="password" value="">
		</p>
	</div>

	<div class="vendor-store-settings-paypal-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<p>
			<label for="vendor_data_password_1"><?php esc_html_e( 'New Password (leave blank to leave unchanged)', 'astoundify-wc-themes' ); ?></label>
			<input id="vendor_data_password_field1" type="password" name="password_1" value="">
		</p>
	</div>


	<div class="vendor-store-settings-paypal-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<p>
			<label for="vendor_data_password_2"><?php esc_html_e( 'Confirm New Password', 'astoundify-wc-themes' ); ?></label>
			<input id="vendor_data_password_field2" type="password" name="password_2" value="">
		</p>
	</div>

	<input type="submit" value="<?php esc_attr_e( 'Update', 'astoundify-wc-themes' ); ?>">
	<input type="hidden" name="action" value="update_store_settings">
	<?php wp_nonce_field( 'vendor-dashboard_store-settings', '_nonce' ); ?>

</form><!-- .vendor-store-settings -->
