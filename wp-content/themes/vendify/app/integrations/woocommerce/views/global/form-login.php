<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
	return;
}

?>
<form class="woocommerce-form woocommerce-form-login login" action="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" method="post" <?php if ( $hidden ) echo 'style="display:none;"'; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php echo ( $message ) ? wpautop( wptexturize( $message ) ) : ''; // @codingStandardsIgnoreLine ?>

	<div class="form-group">
		<p class="form-row">
			<label for="username" class="label label--required"><?php esc_html_e( 'Username or email', 'vendify' ); ?></label>
			<input type="text" class="form-control" name="username" id="username" autocomplete="username" />
		</p>
	</div>

	<div class="form-group">
		<p class="form-row">
			<label for="password" class="label label--required"><?php esc_html_e( 'Password', 'vendify' ); ?></label>
			<input class="form-control" type="password" name="password" id="password" autocomplete="current-password" />
		</p>
	</div>

	<?php do_action( 'woocommerce_login_form' ); ?>

	<div class="form-group">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox custom-control custom-checkbox">
			<input class="woocommerce-form__input woocommerce-form__input-checkbox custom-control-input" name="rememberme" type="checkbox" id="rememberme" value="forever" />
			<span class="custom-control-indicator"></span>
			<span class="custom-control-description"><?php esc_html_e( 'Remember me', 'vendify' ); ?></span>
		</label>
	</div>

	<div class="form-group">
		<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
		<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
		<button type="submit" class="btn btn-primary btn-block" name="login" value="<?php esc_attr_e( 'Login', 'vendify' ); ?>"><?php esc_html_e( 'Login', 'vendify' ); ?></button>
	</div>

	<div class="form-group lost_password">
		<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="link"><?php esc_html_e( 'Lost your password?', 'vendify' ); ?></a>
	</div>

	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
