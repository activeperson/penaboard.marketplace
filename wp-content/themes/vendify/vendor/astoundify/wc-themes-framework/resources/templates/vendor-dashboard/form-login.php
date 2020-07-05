<?php
/**
 * Login Form
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="vendor-dashboard-login-form">

	<?php do_action( 'astoundify_wc_themes_vendors_dashboard_login_form_before' ); ?>

	<?php wp_login_form( array(
		'form_id' => 'vendor-dashboard-login-form',
	) ); ?>

	<p class="forgot-password">
		<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'astoundify-wc-themes' ); ?></a>
	</p>

	<?php do_action( 'astoundify_wc_themes_vendors_dashboard_login_form_after' ); ?>

</div><!-- .vendor-dashboard-login-form -->
