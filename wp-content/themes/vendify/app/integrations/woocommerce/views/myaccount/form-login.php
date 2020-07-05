<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

<div class="u-columns col2-set" id="customer_login">

	<div class="u-column1 col-1">

<?php else : ?>

<div class="row">
	<div class="col-md-8 col-lg-7 col-xl-5 ml-sm-auto mr-sm-auto">

<?php endif; ?>

		<h2 class="dashboard__subheading"><?php esc_html_e( 'Sign In', 'vendify' ); ?></h2>

		<form class="woocommerce-form woocommerce-form-login login" method="post" action="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
				<label for="username" class="label label--required"><?php esc_html_e( 'Username or email address', 'vendify' ); ?></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text form-control" name="username" id="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password" class="label label--required"><?php esc_html_e( 'Password', 'vendify' ); ?></label>
				<input class="woocommerce-Input woocommerce-Input--text form-control" type="password" name="password" id="password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox custom-control custom-checkbox" style="margin-bottom: 0;">
				<input class="woocommerce-form__input woocommerce-form__input-checkbox custom-control-input" name="rememberme" type="checkbox" id="rememberme" value="forever" />
				<span class="custom-control-indicator"></span>
				<span class="custom-control-description"><?php esc_html_e( 'Remember me', 'vendify' ); ?></span>
			</label>

			<p class="dashboard__submit-wrap">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>

				<button type="submit" class="woocommerce-Button btn btn-primary" name="login" value="<?php esc_attr_e( 'Login', 'vendify' ); ?>"><?php esc_html_e( 'Login', 'vendify' ); ?></button>

				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="ml-auto"><?php esc_html_e( 'Lost your password?', 'vendify' ); ?></a>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

	</div>

	<div class="u-column2 col-2">

		<h2 class="dashboard__subheading"><?php esc_html_e( 'Sign Up', 'vendify' ); ?></h2>

		<form method="post" class="register" <?php do_action( 'woocommerce_register_form_tag' ); ?>>

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_username" class="label label--required"><?php esc_html_e( 'Username', 'vendify' ); ?></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text form-control" name="username" id="reg_username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</p>

			<?php endif; ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="reg_email" class="label label--required"><?php esc_html_e( 'Email address', 'vendify' ); ?></label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text form-control" name="email" id="reg_email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_password" class="label label--required"><?php esc_html_e( 'Password', 'vendify' ); ?></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text form-control" name="password" id="reg_password" />
				</p>

				<?php else : ?>

					<p><?php esc_html_e( 'A password will be sent to your email address.', 'vendify' ); ?></p>

				<?php endif; ?>

			<?php do_action( 'woocommerce_register_form' ); ?>

			<p class="woocommerce-FormRow form-row form-row dashboard__submit-wrap">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<button type="submit" class="woocommerce-Button btn btn-primary mr-auto" name="register" value="<?php esc_attr_e( 'Register', 'vendify' ); ?>"><?php esc_html_e( 'Register', 'vendify' ); ?></button>
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

</div>

<?php else : ?>

	</div>
</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
