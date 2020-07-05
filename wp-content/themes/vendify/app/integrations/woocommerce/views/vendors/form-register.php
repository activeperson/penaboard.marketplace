<form class="wcpv-shortcode-registration-form">

	<?php do_action( 'wcpv_registration_form_start' ); ?>

	<?php if ( ! is_user_logged_in() ) { ?>
		<p class="form-row form-row-first">
			<label for="wcpv-firstname" class="label label--required"><?php esc_html_e( 'First Name', 'vendify' ); ?></label>
			<input type="text" class="input-text" name="firstname" id="wcpv-firstname" value="<?php echo esc_attr( ! empty( $_POST['firstname'] ) ? trim( $_POST['firstname'] ) : null ); ?>" tabindex="1" />
		</p>

		<p class="form-row form-row-last">
			<label for="wcpv-lastname" class="label label--required"><?php esc_html_e( 'Last Name', 'vendify' ); ?></label>
			<input type="text" class="input-text" name="lastname" id="wcpv-lastname" value="<?php echo esc_attr( ! empty( $_POST['lastname'] ) ? trim( $_POST['lastname'] ) : null ); ?>" tabindex="2" />
		</p>

		<div class="clear"></div>

		<p class="form-row form-row-wide">
			<label for="wcpv-username" class="label label--required"><?php esc_html_e( 'Username', 'vendify' ); ?></label>
			<input type="text" class="input-text" name="username" id="wcpv-username" value="<?php echo esc_attr( ! empty( $_POST['username'] ) ? trim( $_POST['username'] ) : null ); ?>" tabindex="3" />
		</p>

		<p class="form-row form-row-first">
			<label for="wcpv-email" class="label label--required"><?php esc_html_e( 'Email Address', 'vendify' ); ?></label>
			<input type="email" class="input-text" name="email" id="wcpv-email" value="<?php echo esc_attr( ! empty( $_POST['email'] ) ? trim( $_POST['email'] ) : null ); ?>" tabindex="4" />
		</p>

		<p class="form-row form-row-last">
			<label for="wcpv-confirm-email" class="label label--required"><?php esc_html_e( 'Confirm Email', 'vendify' ); ?></label>
			<input type="email" class="input-text" name="confirm_email" id="wcpv-confirm-email" value="<?php echo esc_attr( ! empty( $_POST['confirm_email'] ) ? trim( $_POST['confirm_email'] ) : null ); ?>" tabindex="5" />
		</p>

	<?php } ?>

	<p class="form-row form-row-wide">
		<label for="wcpv-vendor-vendor-name" class="label label--required"><?php esc_html_e( 'Vendor Name', 'vendify' ); ?></label>
		<input class="input-text" type="text" name="vendor_name" id="wcpv-vendor-name" value="<?php echo esc_attr( ! empty( $_POST['vendor_name'] ) ? trim( $_POST['vendor_name'] ) : null ); ?>" tabindex="6" />
		<span class="wcpv-field-note text-xs"><?php esc_html_e( 'This is the name that customers see when purchasing your products.  Please choose carefully.', 'vendify' ); ?></span>
	</p>

	<p class="form-row form-row-wide">
		<label for="wcpv-vendor-description" class="label label--required"><?php esc_html_e( 'Describe what you sell', 'vendify' ); ?></label>
		<textarea class="input-text" name="vendor_description" id="wcpv-vendor-description" rows="4" tabindex="7"><?php echo esc_textarea( ! empty( $_POST['vendor_description'] ) ? $_POST['vendor_description'] : null ); ?></textarea>
	</p>

	<?php do_action( 'wcpv_registration_form' ); ?>

	<p class="form-row">
		<input type="submit" class="btn btn-block btn-lg btn-primary" name="register" value="<?php esc_attr_e( 'Sign Up', 'vendify' ); ?>" tabindex="8" />
	</p>

	<?php do_action( 'wcpv_registration_form_end' ); ?>

</form>
