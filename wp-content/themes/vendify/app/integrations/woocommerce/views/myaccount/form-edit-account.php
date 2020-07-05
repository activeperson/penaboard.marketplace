<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<div class="row">
	<div class="col-md-11 col-lg-8 col-xl-7 ml-sm-auto mr-sm-auto dashboard__settings">

		<form class="woocommerce-EditAccountForm edit-account" action="" method="POST" enctype="multipart/form-data" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?>>

			<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

			<h3 class="dashboard__subheading">Информация об учетной записи<?php //', 'woocommerce' ); ?></h3>

			<div class="form-group">

				<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
					<label for="account_first_name" class="label label--required"><?php esc_html_e( 'First name', 'woocommerce' ); ?></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text form-control" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
				</p>
				<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
					<label for="account_last_name" class="label label--required"><?php esc_html_e( 'Last name', 'woocommerce' ); ?></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text form-control" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
				</p>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="account_email" class="label label--required"><?php esc_html_e( 'Email address', 'woocommerce' ); ?></label>
					<input type="email" class="woocommerce-Input woocommerce-Input--email form-control" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
				</p>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> <span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
				</p>
			</div>

			<h3 class="dashboard__subheading"><?php esc_html_e( 'Security', 'woocommerce' ); ?></h3>

			<div class="form-group">

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="password_current" class="label"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--password form-control" name="password_current" id="password_current" autocomplete="off" />
				</p>

				<div class="row">
					<div class="col-md-6">
						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<label for="password_1" class="label"><?php esc_html_e( 'New password', 'woocommerce' ); ?></label>
							<input type="password" class="woocommerce-Input woocommerce-Input--password form-control" name="password_1" id="password_1" autocomplete="off" />
						</p>
					</div>

					<div class="col-md-6">
						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<label for="password_2" class="label"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
							<input type="password" class="woocommerce-Input woocommerce-Input--password form-control" name="password_2" id="password_2" autocomplete="off" />
						</p>
					</div>
				</div>
			</div>

			<?php do_action( 'woocommerce_edit_account_form' ); ?>

			<div class="dashboard__submit-wrap">
				<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
				<button type="submit" class="woocommerce-Button btn btn-primary" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
				<input type="hidden" name="action" value="save_account_details" />
			</div>

			<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
		</form>

		<?php do_action( 'woocommerce_after_edit_account_form' ); ?>

	</div>
</div>
