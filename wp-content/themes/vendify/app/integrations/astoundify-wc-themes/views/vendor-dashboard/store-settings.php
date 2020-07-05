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
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="row">
	<div class="col-md-11 col-lg-8 col-xl-7 ml-sm-auto mr-sm-auto dashboard__settings">

		<?php wc_print_notices(); ?>

		<form class="vendor-store-settings" method="POST">

			<h3 class="dashboard__subheading"><?php esc_html_e( 'Avatar &amp; Cover Image', 'vendify' ); ?></h3>

			<div class="vendors-upload-field form-group form-group--upload">
				<div class="upload">
					<img class="upload__placeholder vendors-upload-thumbnail" src="<?php echo esc_url( $logo_url ? $logo_url : get_template_directory_uri() . '/public/images/editor-avatar-placeholder.svg' ); ?>" data-placeholder="<?php echo esc_url( get_template_directory_uri() . '/public/images/editor-avatar-placeholder.svg' ); ?>" alt="avatar" width="90" />
				</div>

				<div class="upload-info">
					<label class="custom-file">
						<button class="vendors-upload-button button btn btn-sm btn-primary" data-title="<?php esc_attr_e( 'Upload Logo', 'vendify' ); ?>" data-insert="<?php esc_attr_e( 'Add logo', 'vendify' ); ?>">
							<?php esc_html_e( 'Upload Logo', 'vendify' ); ?>
						</button>

						<button class="btn-icon btn-icon--close vendors-upload-remove" <?php printf('style="display:%s"', empty( $logo_url ) ? 'none' : 'inline-block' ); ?>>
							<?php
							svg(
								[
									'icon'    => 'close',
									'classes' => [ 'ico--xs' ],
								]
							); ?>
						</button>

						<input type="hidden" class="vendors-upload-id" name="vendor_data[logo]" value="<?php echo absint( $logo ); ?>">
					</label>

					<?php esc_html_e( '300px &times; 300px square recommended.', 'vendify' ); ?>
				</div>
			</div>

			<div class="vendors-upload-field form-group form-group--upload">
				<div class="upload upload--header">
					<img class="upload__placeholder vendors-upload-thumbnail" src="<?php echo esc_url( $cover_image ? $cover_image : get_template_directory_uri() . '/public/images/editor-header-placeholder.svg' ); ?>" data-placeholder="<?php echo esc_url( get_template_directory_uri() . '/public/images/editor-header-placeholder.svg' ); ?>" alt="<?php esc_attr_e( 'Cover image.', 'vendify' ); ?>" width="335" />
				</div>

				<div class="upload-info">
					<div class="custom-file">
						<button class="vendors-upload-button button btn btn-sm btn-primary" data-title="<?php esc_attr_e( 'Upload Cover Image', 'vendify' ); ?>" data-insert="<?php esc_attr_e( 'Add cover image', 'vendify' ); ?>">
							<?php esc_html_e( 'Upload Cover Image', 'vendify' ); ?>
						</button>

						<button class="btn-icon btn-icon--close vendors-upload-remove" <?php printf('style="display:%s"', empty( $cover ) ? 'none' : 'inline-block' ); ?>>
							<?php
							svg(
								[
									'icon'    => 'close',
									'classes' => [ 'ico--xs' ],
								]
							); ?>
						</button>

						<input type="hidden" class="vendors-upload-id" name="vendor_data[cover]" value="<?php echo absint( $cover ); ?>">
					</div>

					<?php esc_html_e( '1200px &times; 300px rectangle recommended.', 'vendify' ); ?>
				</div>
			</div>

			<h3 class="dashboard__subheading"><?php esc_html_e( 'Store Information', 'vendify' ); ?></h3>

			<div class="form-group">
				<label for="vendor_data_name_field" class="label"><?php esc_html_e( 'Name', 'vendify' ); ?></label>
				<input id="vendor_data_name_field" class="form-control" type="text" name="vendor_data[name]" value="<?php echo esc_attr( $name ); ?>">
			</div>

			<div class="form-group">
				<label for="vendor_data_tagline_field" class="label">
					<?php esc_html_e( 'Store Tagline', 'vendify' ); ?>
				</label>

				<input id="vendor_data_tagline_field" class="form-control" type="text" name="vendor_data[tagline]" value="<?php echo esc_attr( $vendor_tagline ); ?>">
			</div>

			<div class="form-group">
				<label for="vendor_data_profile_field" class="label"><?php esc_html_e( 'Store Description', 'vendify' ); ?></label>
				<?php
				$args = [
					'textarea_name' => 'vendor_data[profile]',
					'textarea_rows' => 5,
					'media_buttons' => false,
				];
				wp_editor( wp_specialchars_decode( $vendor_profile ), 'wcpv_vendor_info', $args ); ?>
			</div>

			<?php if ( 'virtual' !== get_option( 'woocommerce_product_type' ) ) : ?>
			<div class="form-group">
				<label for="wcpv_vendor_shipping_policy" class="label">
					<?php esc_html_e( 'Store Shipping Policy', 'vendify' ); ?>
				</label>

				<?php
				$args = [
					'textarea_name' => 'vendor_data[shipping_policy]',
					'textarea_rows' => 3,
					'media_buttons' => false,
				];
				wp_editor( wp_specialchars_decode( $shipping_policy ), 'wcpv_vendor_shipping_policy', $args );
				?>
			</div>

			<div class="form-group">
				<label for="wcpv_vendor_return_policy" class="label">
					<?php esc_html_e( 'Store Return Policy', 'vendify' ); ?>
				</label>

				<?php
				$args = [
					'textarea_name' => 'vendor_data[return_policy]',
					'textarea_rows' => 3,
					'media_buttons' => false,
				];
				wp_editor( wp_specialchars_decode( $return_policy ), 'wcpv_vendor_return_policy', $args ); ?>
			</div>
			<?php endif; ?>

			<div class="form-group">
				<label for="vendor_data_location_field" class="label">
					<?php esc_html_e( 'Location', 'vendify' ); ?>
				</label>

				<input id="vendor_data_location_field" class="form-control" type="text" name="vendor_data[location]" value="<?php echo esc_attr( $vendor_location ); ?>">
			</div>

			<div class="form-group">
				<label for="vendor_data_email_field" class="label"><?php esc_html_e( 'Contact Email', 'vendify' ); ?></label>
				<input id="vendor_data_email_field" class="form-control" type="email" name="vendor_data[email]" value="<?php echo esc_attr( $email ); ?>">
			</div>

			<?php if ( ! empty( $contact_methods ) ) {
				foreach ( $contact_methods as $method_id => $method_label ) { ?>
					<div class="form-group">
						<label for="vendor_data_<?php echo esc_attr( $method_id ); ?>_field" class="label">
							<?php echo esc_html( $method_label ); ?>
						</label>
						<input id="vendor_data_<?php echo esc_attr( $method_id ); ?>_field" type="text" name="vendor_data[contact_method_<?php echo esc_attr( $method_id ); ?>]" value="<?php echo esc_attr( ${ "contact_method_{$method_id}" } ); ?>" class="form-control" />
					</div>
				<?php }
			} ?>

			<div class="form-group">
				<label for="vendor_data_timezone_field" class="label"><?php esc_html_e( 'Timezone', 'vendify' ); ?></label>
				<select id="vendor_data_timezone_field" class="custom-select" name="vendor_data[timezone]" aria-describedby="timezone-description" class="wc-enhanced-select">
					<?php echo wp_timezone_choice( $timezone ); ?>
				</select>
			</div>

			<h3 class="dashboard__subheading"><?php esc_html_e( 'Payment Settings', 'vendify' ); ?></h3>

			<div class="form-group">
				<label for="vendor_data_paypal_field" class="label"><?php esc_html_e( 'Paypal Email', 'vendify' ); ?></label>
				<input id="vendor_data_paypal_field" class="form-control" type="email" name="vendor_data[paypal]" value="<?php echo esc_attr( $paypal ); ?>">
			</div>

			<h3 class="dashboard__subheading"><?php esc_html_e( 'Security', 'vendify' ); ?></h3>

			<div class="form-group">
				<label for="vendor_data_password" class="label"><?php esc_html_e( 'Current Password', 'vendify' ); ?></label>
				<input id="vendor_data_password_field" class="form-control" type="password" name="password" value="">
			</div>

			<div class="form-group">
				<label for="vendor_data_password_1" class="label"><?php esc_html_e( 'New Password (leave blank to leave unchanged)', 'vendify' ); ?></label>
				<input id="vendor_data_password_field1" class="form-control" type="password" name="password_1" value="">
			</div>


			<div class="form-group">
				<label for="vendor_data_password_2" class="label"><?php esc_html_e( 'Confirm New Password', 'vendify' ); ?></label>
				<input id="vendor_data_password_field2" class="form-control" type="password" name="password_2" value="">
			</div>

			<div class="dashboard__submit-wrap">
				<input class="btn btn-primary ml-auto" type="submit" value="<?php esc_attr_e( 'Update', 'vendify' ); ?>">
				<input type="hidden" name="action" value="update_store_settings">
				<?php wp_nonce_field( 'vendor-dashboard_store-settings', '_nonce' ); ?>
			</div>

		</form><!-- .vendor-store-settings -->

	</div>
</div>
