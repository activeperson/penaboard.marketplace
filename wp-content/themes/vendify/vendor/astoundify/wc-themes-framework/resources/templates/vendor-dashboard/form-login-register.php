<?php
/**
 * Login/Register Form.
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

wc_print_notices();
?>

<?php if ( ! is_user_logged_in() ) : // Not yet a user. ?>

	<?php if ( astoundify_wc_themes_vendors_dashboard_registration_enabled() ) : // Display 2 column login/register. ?>

		<div class="u-columns col2-set" id="vendor-login">

			<div class="u-column1 col-1">
				<h2><?php esc_html_e( 'Already a vendor?', 'astoundify-wc-themes' ); ?></h2>
				<p><?php esc_html_e( 'You can login using the form below.', 'astoundify-wc-themes' ); ?></p>
				<?php astoundify_wc_themes_vendors_dashboard_login_form(); ?>
			</div>

			<div class="u-column2 col-2">
				<?php echo astoundify_wc_themes_vendors_registration_shortcode(); ?>
			</div>

		</div><!-- #vendor-login -->

	<?php else : // Display simple login form. ?>

		<?php astoundify_wc_themes_vendors_dashboard_login_form(); ?>

	<?php endif; ?>

<?php elseif( ! WC_Product_Vendors_Utils::is_vendor() ) : // Logged-in user, but not a vendor. ?>

	<?php if ( astoundify_wc_themes_vendors_dashboard_registration_enabled() ) : ?>

		<?php echo astoundify_wc_themes_vendors_registration_shortcode(); ?>

	<?php else : ?>

		<p><?php esc_html_e( 'You do not have permission to view this page.', 'astoundify-wc-themes' ); ?></p>

	<?php endif; ?>

<?php endif; ?>
