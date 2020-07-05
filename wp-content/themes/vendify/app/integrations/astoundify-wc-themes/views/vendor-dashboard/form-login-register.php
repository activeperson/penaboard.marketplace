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

namespace Astoundify\Vendify;

use WC_Product_Vendors_Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! is_admin() ) {
	wc_print_notices();
}

if ( ! is_user_logged_in() ) { // Not yet a user.

	if ( astoundify_wc_themes_vendors_dashboard_registration_enabled() ) { // Display 2 column login/register. ?>

		<div class="u-columns col2-set" id="vendor-login">

			<div class="u-column1 col-1">
				<h2 class="dashboard__subheading"><?php esc_html_e( 'Sign In', 'vendify' ); ?></h2>

				<?php astoundify_wc_themes_vendors_dashboard_login_form(); ?>
			</div>

			<div class="u-column2 col-2">
				<h2 class="dashboard__subheading"><?php esc_html_e( 'Sign Up', 'vendify' ); ?></h2>

				<?php echo vendor_registration_form(); ?>
			</div>

		</div><!-- #vendor-login -->

	<?php } else { // Display simple login form.

		astoundify_wc_themes_vendors_dashboard_login_form();

	}

} elseif ( ! WC_Product_Vendors_Utils::is_vendor() ) { // Logged-in user, but not a vendor.

	if ( astoundify_wc_themes_vendors_dashboard_registration_enabled() ) { ?>

		<div class="row">
			<div class="col-md-8 col-lg-7 col-xl-5 ml-sm-auto mr-sm-auto">
				<h2 class="dashboard__subheading"><?php esc_html_e( 'Sign Up', 'vendify' ); ?></h2>

				<?php echo vendor_registration_form(); ?>
			</div>
		</div>

	<?php } else { ?>

		<p><?php esc_html_e( 'You do not have permission to view this page.', 'vendify' ); ?></p>

	<?php }

}
